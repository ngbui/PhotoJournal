<?php require_once("common/database.php"); ?>
<!DOCTYPE html>

  <html>
  <head>
        <title>Manage Tags - PhotoJournal</title>
            <link href="res/main.css" rel="stylesheet">
    </head>

    <body>

        <?php
            require_once("common/pagehead.php");
        ?>

        <h2>Create a new tag!</h2> <!--insert Query-->
        <form method="POST" action="tag.php"> <!--refresh page when submitted-->
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">
            Name: <input type="text" name="tagName"> <br /><br />
            <input type="submit" value="Insert" name="insertSubmit"></p>
        </form>

        <hr />

        <h2>Search for attachments by tag names</h2> <!--projection Query-->
        <form method="GET" action="tag.php"> <!--refresh page when submitted-->
            <input type="hidden" id="searchQueryRequest" name="searchQueryRequest">
            Tag Name: <input type="text" name="toSearch"> <br /><br />
            <input type="submit" name="searchTuples"></p>
        </form>

        <hr />

        <h2>Tag an attachment</h2> <!--insert Query-->
        <form method="POST" action="tag.php"> <!--refresh page when submitted-->
            <input type="hidden" id="searchQueryRequest" name="tagQueryRequest">
            Tag Name: <input type="text" name="toTag"> <br /><br />
            Attachment ID: <input type="text" name="idnum"> <br /><br />
            <input type="submit" value="Tag Attachment" name="tagSubmit"></p>
        </form>

        <hr />

        <h2>Display all available Tags</h2> <!--selection Query-->
        <form method="GET" action="tag.php"> <!--refresh page when submitted-->
            <input type="hidden" id="displayTupleRequest" name="displayTupleRequest">
            <input type="submit" name="displayTuples"></p>
        </form>

        <hr />

        <h2>Find the attachments with all the tags!</h2> <!--division Query-->
        <form method="GET" action="tag.php"> <!--refresh page when submitted-->
            <input type="hidden" id="findQueryRequest" name="findQueryRequest">
            <input type="submit" value="Find" name="findTuples"></p>
        </form>

        <hr />

        <h2>Find popular tags</h2> <!--Aggregation with Having Query-->
        <p>Find tags that are associated with at least this many attachments:</p>
        <form method="GET" action="tag.php"> <!--refresh page when submitted-->
            <input type="hidden" id="popularQueryRequest" name="popularQueryRequest">
            Number of attachments: <input type="text" name="num"> <br /><br />
            <input type="submit" value="Find Popular Tags" name="findPopular"></p>
        </form>

        <?php

        function handleTagRequest() {
            global $conn;
            $toInsert = $_POST['toTag'];
            $id = $_POST['idnum'];

            $result = executePlainSQL("SELECT * FROM Tag WHERE Name='" . $toInsert . "'");
            if ($result->num_rows == 0) {
                echo "<br>Tag does not exist. Please create a new tag.<br>";
                return false;
            } else {
                $findAtt = executePlainSQL("SELECT * FROM Attachment WHERE Id='" . $id . "'");
                if($findAtt->num_rows == 0) {
                    echo "<br>Attachment does not exist. Please try again with a valid attachment.<br>";
                } else {
                    $stmt = $conn->prepare("insert into AttachmentTag values (?, ?)");
                    $stmt->bind_param("is", $id, $toInsert);
                    $result = $stmt->execute();
                    echo "<br>Tagged attachment #$id with tag $toInsert.<br>";
                    $conn->commit();
                }
            }
        }

        function handleDisplayRequest() {
            global $conn;
            $result = executePlainSQL("SELECT * FROM Tag");
            echo "<br>Retrieved available tags:<br>";
            echo "<table>";
            echo "<tr><th>Name</th></tr>";

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<tr><td>" . $row["Name"] . "</td></tr>";
            }
            echo "</table>";
        }

        function handleInsertRequest() {
            global $conn;
            $name = $_POST['tagName'];

            $result = executePlainSQL("SELECT * FROM Tag WHERE Name='" . $name . "'");
            if ($result->num_rows > 0) {
                echo "<br>Tag already exists. Please choose a different name.<br>";
            } else {
                $stmt = $conn->prepare("insert into Tag(Name) values (?)");
                $stmt->bind_param("s", $name);
                $result = $stmt->execute();
                echo "<br>Created a new tag called $name<br>";
                $conn->commit();
            }
        }

        function handleSearchRequest() {
            global $conn;

            $tag_name = $_GET['toSearch'];
            $result = executeBoundSQL(
                "SELECT TagName, at.AttachmentId, URL
                FROM AttachmentTag AS at LEFT OUTER JOIN Photo on at.AttachmentID = Photo.AttachmentId
                WHERE at.TagName = ?", "s", $tag_name);
            if ($result->num_rows == 0) {
                echo "<p>No attachments found.</p>";
            } else {
                echo "<p>Retrieved attachment ids:</p>";
                echo "<table>";
                echo "<tr><th>ID</th><th>URL</th></tr>";

                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . $row["AttachmentId"] . "</td>";
                    if ($row["URL"]) {
                        echo '<td><a href="' . $row["URL"] . '">' . $row["URL"] .'</a></td>';
                    } else {
                        echo '<td><a href="album-view.php?id=' . $row["AttachmentId"] . '">Click to View Album</a></td>';
                    }

                    echo "</tr>";
                }
                echo "</table>";
            }
        }

        function handleFindRequest() {
            global $conn;
            $result = executePlainSQL("SELECT DISTINCT a1.AttachmentId AS AttachmentId
            FROM AttachmentTag a1
            WHERE NOT EXISTS
             (SELECT Tag.Name FROM Tag
             WHERE Tag.Name NOT IN (SELECT a2.TagName FROM AttachmentTag a2 WHERE a2.AttachmentId = a1.AttachmentId))") or die(mysqli_error($conn));
            echo "<br>Retrieved attachment ids:<br>";
            echo "<table>";
            echo "<tr><th>ID</th></tr>";

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<tr><td>" . $row["AttachmentId"] . "</td></tr>";
            }
            echo "</table>";
        }

        function handlePopularRequest() {
            global $conn;

            $num = $_GET['num'];
            if ((is_int($num) || ctype_digit($num)) && (int)$num > 0 ) {
                $result = executePlainSQL("SELECT TagName, COUNT(*) AS Count FROM AttachmentTag GROUP BY TagName HAVING COUNT(*) >= $num")
                or die(mysqli_error($conn));

                print_result_table($result);
            } else {
                echo "<br> Invalid input type. Please enter a positive integer.<br>";
            }
        }
    ?>
        <h2>Query Result</h2>
    <?php
		if (isset($_POST['insertSubmit'])) {
            handleInsertRequest();
        } else if (isset($_GET['displayTupleRequest'])) {
            handleDisplayRequest();
        } else if (isset($_GET['searchQueryRequest'])) {
            handleSearchRequest();
        } else if (isset($_GET['findQueryRequest'])) {
            handleFindRequest();
        } else if (isset($_POST['tagSubmit'])) {
            handleTagRequest();
        } else if (isset($_GET['popularQueryRequest'])) {
            handlePopularRequest();
        }
		?>
	</body>
</html>
