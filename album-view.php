<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>View Album - PhotoJournal</title>
<link href="res/main.css" rel="stylesheet">
</head>

<body>
<?php require_once("common/pagehead.php");

if (!isset($_GET["id"])) {
    print_error("No album ID given.");
} else {
    $albumID = $_GET["id"];

    $albumInfo = executeBoundSQL(
        "SELECT Title
        FROM Attachment
        WHERE Attachment.ID = ?",
        "i", $albumID);
    $photosResult = executeBoundSQL(
        "SELECT PhotoId, TimeAdded, URL, Title
        FROM BelongsTo, Photo, Attachment
        WHERE Photo.AttachmentID = BelongsTo.PhotoID
        AND Attachment.ID = Photo.AttachmentID
        AND AlbumID = ?",
        "i", $albumID);

    if (!$photosResult || !$albumInfo) {
        print_error("Error retrieving photos for this album: " . $conn->error);
    } elseif ($albumInfo->num_rows == 0) {
        print_error("No such album " . $albumID);
    } elseif ($photosResult->num_rows == 0) {
        print_error("No photos in this album yet!");
    } else {
        $albumTitle = $albumInfo->fetch_assoc()["Title"];
        echo "<h1>Viewing album: $albumTitle</h1>";
        print_success("Total of {$photosResult->num_rows} photos in this album:", $showHomeButton=false);
        while ($row = $photosResult->fetch_assoc()) {
            echo "<img class=\"img-display\" src=\"{$row['URL']}\" title=\"{$row['Title']}\">";
            echo '<br>';
        }
    }
}
?>
<h1>View Another Album</h1>
<form action="album-view.php" method="get">
  <label for="id"><b>Album ID</b><br>
  <input type="id" id="id" name="id"
<?php
if (isset($_GET["id"])) {
    echo 'value="' . $_GET['id'] . '"';
}?>
  ><br><br>
  <input type="submit" name="View Album">
</form>

</body>
</html>
