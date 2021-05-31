<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>Fun Stats - PhotoJournal</title>
<link href="res/main.css" rel="stylesheet">
</head>

<body>
<?php require_once("common/pagehead.php"); ?>

<h1>Fun Stats about the Site</h1>

<h2>Album stats</h2>
<p>Find how many photos are in each (non-empty) album, as well as the latest addition to it:</p>
<?php
if (isset($_GET["albumStats"])) {
    $result = executePlainSQL(
        "SELECT AlbumID, COUNT(*) AS PhotoCount, MAX(TimeAdded) AS LatestChange
        FROM BelongsTo
        GROUP BY AlbumID");
    print_result_table($result);
}
?>
<br>
<form action="stats.php" method="get">
    <input type="submit" value="View Stats" name="albumStats">
</form>

<h2>Users with more than X attachments</h2>
<p>Find users who have created more than X attachments:</p>
<?php
if (isset($_GET["userAttachmentStats"])) {
    $result = executeBoundSQL(
        "SELECT UploaderUsername AS Username, COUNT(ID) AS numAttachments
        FROM Attachment
        GROUP BY UploaderUsername
        HAVING COUNT(*) >= ?", "i", $_GET["count"]);
    print_result_table($result);
}
?>
<br>
<form action="stats.php" method="get">
    <input type="text" name="count" placeholder="# attachments (default 0)"
<?php
if (isset($_GET["count"])) {
    echo 'value="' . $_GET["count"] . '"';
}
?>
    >
    <input type="submit" value="View Stats" name="userAttachmentStats">
</form>

<h2>Users with most posts</h2>
<p>Find users with most posts:</p>
<?php
if (isset($_GET["userPostStats"])) {
    $result = executePlainSQL(
        "SELECT CreatorUsername AS Username, COUNT(*) AS PostCount
        FROM Post
        GROUP BY CreatorUsername
        HAVING COUNT(*) >= ALL (SELECT COUNT(*) FROM Post GROUP BY CreatorUsername)");
    print_result_table($result);
}
?>
<br>
<form action="stats.php" method="get">
    <input type="submit" value="View Stats" name="userPostStats">
</form>


</body>
</html>
