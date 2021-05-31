<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>

<head>
  <title>Photos - PhotoJournal</title>
  <link href="res/main.css" rel="stylesheet">
</head>

<body>
  <?php require_once("common/pagehead.php"); ?>
  <?php
  // $hideLoginInfo = true;
  require_once("common/loginutils.php");
  ?>
  <h1>Photos</h1>
  <h2 id="addphoto">Add Photo</h2>
  <form action="photos.php" method="post">
    <label for="photoUrl"><b>Photo URL</b></label><br>
    <input type="text" id="photoUrl" name="photoUrl"><br><br>

    <label for="photoTitle"><b>Photo Title</b></label><br>
    <input type="text" id="photoTitle" name="photoTitle"><br><br>
    <input type="submit" name="addPhoto">
  </form>

  <h2 id="myphotos">Photos by Uploader</h2>
  <form method="GET" action="photos.php">
    <!--refresh page when submitted-->
    <label for="refreshPhotos"><b>Refresh</b></label><br>
<?php if (isset($_GET['username'])) {
  // prefill the search box with the current username if loged in
  echo '<input type="text" name="username" placeholder="Username" value="' . $_GET['username'] . '">';
} else if (isset($_SESSION['username'])) {
  echo '<input type="text" name="username" placeholder="Username" value="' . $_SESSION['username'] . '">';
} else {
  echo '<input type="text" name="username" placeholder="Username">';
} ?>
    <input type="hidden" id="refreshPhotos" name="refreshPhotos">
    <input type="submit" name="refresh"></p>
  </form>

  <?php

  function handleAddPhotoRequest()
  {
    global $conn;

    $id = 0;
    while ($id <= 0 || executePlainSQL("SELECT * FROM Attachment WHERE Id='" . $id . "'")->num_rows !== 0) {
      $id = rand(1, 1000); //generate random integer from 1 to 1000 for id
    }

    $title = $_POST["photoTitle"];
    $url = $_POST["photoUrl"];
    if (isset($_SESSION['username'])) {
      $user = $_SESSION['username'];
    } else {
      print_error("You must be logged in to perform this action");
      return false;
    }

    if (empty($title) || empty($url)) {
      print_error("Title and URL must not be empty", false);
      return false;
    }

    $result_attachment = executeBoundSQL("INSERT INTO Attachment VALUES (?, ?, ?)", "iss", $id, $title, $user);
    if (!$result_attachment) {
      print_error("Error adding attachment: " . $conn->error, false);
      return false;
    }

    $result_photo = executeBoundSQL("INSERT INTO Photo VALUES (?,?,NULL, NULL, NULL, NULL)", "is", $id, $url);
    if (!$result_photo) {
      print_error("Error adding photo: " . $conn->error, false);
      return false;
    }
    print_success("Added new photo with ID #" . $id, false);
  }

  function writeDeleteForm($photoID) {
    echo '<form method="POST" action="photos.php">';
    echo '<input type="hidden" id="deletePhotoID" name="deletePhotoID" value="' . $photoID . '">';
    echo '<input type="submit" name="deletePhoto" value="Delete this Photo">';
    echo '</form>';
  }

  function handleRefreshRequest()
  {
    global $conn;

    if (!isset($_GET["username"])) {
      return false;
    }
    $user = $_GET["username"];

    echo "<br>";

    $stmt = $conn->prepare("SELECT AttachmentID, URL, Title FROM Photo JOIN Attachment On (AttachmentID = ID) WHERE UploaderUsername = ? ORDER BY Title");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
      print_error("No results found.", false);
      return;
    }

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      echo "<br>";
      echo "<h3>{$row['Title']} (#{$row['AttachmentID']})</h3><br>";
      echo "<img src=\"" . $row['URL'] . "\" class=\"img-display\"><br>";
      writeDeleteForm($row['AttachmentID']);
    }
  }

  function handleDeleteRequest() {
    global $conn;
    $result = executeBoundSQL("DELETE FROM Attachment WHERE ID = ? AND ID IN (SELECT AttachmentID AS ID FROM Photo)",
      "i", $_POST['deletePhotoID']) ;
    if ($result) {
      print_success('OK, deleted ' . $result . ' photo with ID ' . $_POST['deletePhotoID'], false);
    } else {
      print_error('No such Photo', false);
    }
  }

  if (isset($_POST['photoUrl']) && isset($_POST['photoTitle'])) {
    handleAddPhotoRequest();
  } else if (isset($_POST['deletePhotoID'])) {
    handleDeleteRequest();
  } else if (isset($_GET['refreshPhotos'])) {
    handleRefreshRequest();
  }

  ?>


</body>

</html>
