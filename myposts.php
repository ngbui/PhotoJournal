<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Manage Posts - PhotoJournal</title>
    <link href="res/main.css" rel="stylesheet">
</head>

<body>
    <?php
    require_once("common/pagehead.php");
    require_once("common/loginutils.php");

    function handleCreatePostRequest()
    {
        global $conn;

        $id = 0;
        while ($id <= 0 || executePlainSQL("SELECT * FROM Post WHERE ID='" . $id . "'")->num_rows !== 0) {
            $id = rand(1, 1000); //generate random integer from 1 to 1000 for id
        }

        $title = $_POST["title"];
        $text = $_POST["text"];
        $attachmentID = $_POST["attachment"];
        if (isset($_SESSION['username'])) {
            $user = $_SESSION['username'];
        } else {
            print_error("You must be logged in to perform this action");
            return false;
        }

        $stmt = $conn->prepare("INSERT INTO Post Values (?, ?, ?, now(), NULL, ?, ?, NULL)");
        $stmt->bind_param("isiss", $id, $user, $attachmentID, $title, $text);
        $stmt->execute();
        $conn->commit();
    }

    function handleDeletePostsRequest()
    {
        global $conn;

        if (isset($_SESSION['username'])) {
            $user = $_SESSION['username'];
        } else {
            print_error("You must be logged in to perform this action");
            return false;
        }

        echo "<br>";

        if (!empty($_POST["delete_post_list"])) {
            foreach ($_POST["delete_post_list"] as $post_id) {
                $stmt = $conn->prepare("DELETE FROM Post WHERE ID = ? AND CreatorUsername = ?");
                $stmt->bind_param("is", $post_id, $user);
                $stmt->execute();
            }
        }
    }

    // Run this code BEFORE showing the forms, so that add and remove operations immediately show
    // after completing
    if (isset($_POST['title']) && isset($_POST['text']) && isset($_POST['attachment'])) {
        handleCreatePostRequest();
    } else if (isset($_POST['delete_post_list'])) {
        handleDeletePostsRequest();
    }

    if (isset($_SESSION['username'])) {
        $user = $_SESSION['username'];
    ?>

    <h1>My Posts</h1>
    <h2>Create New Post</h2>
    <form action="myposts.php" method="post">
        <label for="title"><b>Title</b></label><br>
        <input type="text" id="title" name="title"><br><br>

        <label for="Text"><b>Text</b></label><br>
        <textarea name="text" rows="10" cols="60"></textarea><br><br>

        <label for="attachment"><b>Attachment</b></label><br>
        <select id="attachment" name="attachment">
            <?php

            global $conn;

            echo "<br>";

            // List out all of the user's photos and albums
            $stmt = $conn->prepare("SELECT ID, Title FROM Photo JOIN Attachment On (AttachmentID = ID) WHERE UploaderUsername = ?");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<option value=\"" . $row["ID"] . "\">" . "Photo ID #" . $row["ID"] . ": " . $row["Title"] . "</option>";
            }

            $stmt = $conn->prepare("SELECT ID, Title FROM Album JOIN Attachment On (AttachmentID = ID) WHERE UploaderUsername = ?");
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<option value=\"" . $row["ID"] . "\">" . "Album ID #" . $row["ID"] . ": " . $row["Title"] . "</option>";
            }
            ?>
        </select><br><br>

        <input type="submit" name="createPost" value="Create Post">
    </form>

    <h2>Delete Posts</h2>
    <form action="myposts.php" method="post">
        <?php
        global $conn;

        if (isset($_SESSION['username'])) {
            $user = $_SESSION['username'];
        } else {
            print_error("You must be logged in to view this page");
            return false;
        }

        $stmt = $conn->prepare("SELECT ID, AttachmentID, Timestamp, Title, Text FROM Post WHERE CreatorUsername = ? ORDER BY Timestamp DESC");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo "<input type=\"checkbox\" name=\"delete_post_list[]\" value=\"" . $row["ID"] . "\"><b>" . $row["Title"] . "</b><br><p>" . $row["Text"] . "</p>-" . $row["Timestamp"] . "<br><br>";
        }

        ?>

        <input type="submit" name="deletePost" value="Delete Selected Posts">
    </form>

<?php } else {
    print_error("You must be logged in to view this page");
}
?>
</body>

</html>
