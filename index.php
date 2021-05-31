<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>Main Page - PhotoJournal</title>
<link href="res/main.css" rel="stylesheet">
</head>

<body>
<?php require_once("common/pagehead.php");

$numPosts = 20;

global $conn;

if (isset($_GET["username"])) {
    $user = $_GET["username"];
} else {
    $user = null;
}
?>

<form action="index.php" method="get">
  <label for="username"><b>Search by username</b><br>
  <input type="username" id="username" name="username" placeholder="Username (leave blank for all)"
<?php
if ($user) {
    echo 'value="' . $user . '"';
}?>
  >
  <input type="submit" name="Search">
</form>

<?php
if ($user) {
    echo "<p>Showing the $numPosts most recent posts by {$user}:</p>";
} else {
    echo "<p>Showing the $numPosts most recent posts on the site:</p>";
}

// Select all posts, and the relevant Photo URL if for attachments that are photos
// This assumes that all attachments without a URL are albums (true so far)
if ($user) {
    $postsResult = executeBoundSQL(
        "SELECT Attachment.ID, Post.Title AS PostTitle, Attachment.Title AS AttachmentTitle, CreatorUsername, URL, Text, Timestamp
        FROM Attachment, Post
        LEFT OUTER JOIN Photo
        ON Photo.AttachmentID = Post.attachmentID
        WHERE Post.AttachmentID = Attachment.ID AND CreatorUsername = ?
        ORDER BY Timestamp DESC", "s", $user);
} else {
    $postsResult = executePlainSQL(
        "SELECT Attachment.ID, Post.Title AS PostTitle, Attachment.Title AS AttachmentTitle, CreatorUsername, URL, Text, Timestamp
        FROM Attachment, Post
        LEFT OUTER JOIN Photo
        ON Photo.AttachmentID = Post.attachmentID
        WHERE Post.AttachmentID = Attachment.ID
        ORDER BY Timestamp DESC");
}

if (!$postsResult) {
    print_error("Error retrieving posts: " . $conn->error);
} elseif ($postsResult->num_rows == 0) {
    echo '<p>No posts yet!</p>';
} else {
    $count = 0;
    while ($count < $numPosts && $row = $postsResult->fetch_assoc()) {
        $count++;
        // XXX: not checking against XSS
        echo "<h2>{$row['PostTitle']}</h2>";
        echo "<p class=\"info\">Submitted by {$row['CreatorUsername']} on {$row['Timestamp']}</p>";
        echo "<p>{$row['Text']}</p>";
        if ($row['URL']) {
            echo "<img class=\"img-display\" src=\"{$row['URL']}\" title=\"{$row['AttachmentTitle']}\">";
        } else {
            echo "<a href=\"album-view.php?id=${row['ID']}\">Click to view the album (#${row['ID']})</a>";
        }
        echo '<br>';
    }
}
?>

</body>
</html>
