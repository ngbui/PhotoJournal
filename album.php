<?php require_once("common/database.php"); ?>
<!DOCTYPE html>

  <html>
    <head>
        <title>Manage Albums - PhotoJournal</title>
            <link href="res/main.css" rel="stylesheet">
    </head>

    <body>

    <?php
        require_once("common/pagehead.php");
    ?>

    <h2>Create a new album!</h2>
        <form method="POST" action="album.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Title: <input type="text" name="title"> <br /><br />

            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

    <h2>Deleting an existing album</h2>
        <form method="POST" action="album.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            ID: <input type="text" name="insNo"> <br /><br />

            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <hr />

    <h2>Insert a photo into an existing album!</h2>
        <form method="POST" action="album.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            PhotoID: <input type="text" name="photoNo"> <br /><br />
            AlbumID: <input type="text" name="albumNo"> <br /><br />

            <input type="submit" value="Insert Photo" name="photoinsertSubmit"></p>
        </form>
        <a href="/photos.php?refreshPhotos#myphotos" target="_blank">View your photos</a>

    <h2>Display current albums</h2>
        <form method="GET" action="album.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="submit" name="displayRequest"></p>
        </form>

        <?php

        function handleInsertRequest() {
            global $conn;

            $id = 0;
            while ($id <=0 || executePlainSQL("SELECT * FROM Attachment WHERE Id='" . $id . "'")->num_rows !== 0) {
                $id = rand(1,100); //generate random integer from 1 to 100 for id
            }

            $title = $_POST['title'];

            if(isset($_SESSION['username'])) {
                $user = $_SESSION['username'];
            } else {
                print_error("You must be logged in to perform this action");
                return false;
            }

            $stmt = $conn->prepare("INSERT INTO Attachment VALUES (?,?,?)");
            $stmt->bind_param('iss', $id, $title, $user);
            $stmt->execute();
            $conn->commit();

            $stmtalbum = $conn->prepare("INSERT INTO Album VALUES (?)");
            if($stmtalbum !== FALSE) {
                $stmtalbum->bind_param('i', $id);
                $stmtalbum->execute();
                $result = $stmtalbum->get_result();
                $conn->commit();
            }
            if ($stmt && $stmtalbum) {
                echo "<p>Created new album called $title with $id.</p>";
            } else {
                echo "Could not add album: " . $conn->error;
            }
        }

        function handleDeleteRequest() {
            global $conn;
            $id = $_POST['insNo'];

            $deleteResult = executeBoundSQL("DELETE FROM Attachment WHERE ID=?", "i", $id);
            if ($conn->error) {
                echo "<p>Error processing DELETE query: " . $conn->error . "</p>";
            } else if ($deleteResult) {
                echo "<p>Deleted album #$id</p>";
            } else {
                echo "<p>No such album exists.</p>";
            }
            $conn->commit();
        }

        function handlePhotoInsert() {
            global $conn;
            $idA = $_POST['albumNo'];
            $idP = $_POST['photoNo'];

            $result = executeBoundSQL("SELECT * FROM Album WHERE AttachmentId=?", "i", $idA);
            if ($result->num_rows == 0) {
                echo "<p>Album does not exist. Please create a new album.</p>";
                return false;
            } else {
                $findAtt = executeBoundSQL("SELECT * FROM Photo WHERE AttachmentId=?", "i", $idP);
                if($findAtt->num_rows == 0) {
                    echo "<p>Photo does not exist. Please try again with a valid photo.</p>";
                    return false;
                } else {
                    $result = executeBoundSQL("INSERT INTO BelongsTo VALUES (?, ?, NOW())", "ii", $idP, $idA);
                    $conn->commit();

                    if (!$result) {
                        echo "Could not add photo into album: " . $stmt->error;
                    } else {
                        echo "<p>Added photo #$idP to album #$idA </p>";
                    }
                }
            }
            $result = executePlainSQL("SELECT * FROM BelongsTo");
            echo "<p>All album entries:</p>";
            echo "<table>";
            echo "<tr><th>PhotoId</th><th>AlbumId</th><th>TimeAdded</th></tr>";

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<tr><td>" . $row["PhotoId"] . "</td><td>" . $row["AlbumId"] ."</td><td>" . $row["TimeAdded"] . "</td></tr>";
            }
            echo "</table>";
        }

        function handleDisplayRequest() {
            global $conn;
            echo "<p>Displaying current albums:</p>";
            echo "<table>";
            echo "<tr>
                <th>ID</th>
                <th>Title</th>
                <th>View link</th>
                </tr>";

            // Normalize case on ID field (older tables had it as "Id")
            $result = executePlainSQL("SELECT ID as ID, Title, UploaderUsername FROM Attachment WHERE Id IN (SELECT * FROM Album)");
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row["ID"] . "</td>";
                echo "<td>" . $row["Title"] . "</td>";
                echo "<td><a href=\"album-view.php?id=" . $row["ID"] . "\">View Album</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        }

		if (isset($_POST['insertSubmit'])) {
            handleInsertRequest();
        } else if (isset($_POST['deleteSubmit'])) {
            handleDeleteRequest();
        } else if (isset($_POST['photoinsertSubmit'])) {
            handlePhotoInsert();
        } else if (isset($_GET['displayTupleRequest'])) {
            handleDisplayRequest();
        }
		?>
	</body>
</html>

