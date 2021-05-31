<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>My Account - PhotoJournal</title>
<link href="res/main.css" rel="stylesheet">
</head>

<body>
<?php require_once("common/pagehead.php"); ?>
<h1>My Account</h1>
<?php
// nesting HTML inside PHP conditions is a bit of a hack, see
// https://softwareengineering.stackexchange.com/questions/357782/
if (isset($_SESSION["username"])) {
?>
<h2>Change Password</h2>
<form action="myaccount-pass-post.php" method="post">
  <label for="oldPass"><b>Current password</b></label><br>
  <input type="password" id="oldPass" name="oldPass"><br><br>

  <label for="newPass"><b>New password</b></label><br>
  <input type="password" id="newPass" name="newPass"><br><br>
  <input type="submit">
</form>

<h2>Change Email</h2>
<p>Your current email is <b>
<?php
    global $conn;
    $stmt = $conn->prepare("SELECT Email FROM Account WHERE Username = ?");
    $stmt->bind_param("s", $_SESSION["username"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        print_error("Problem getting login information: " . $stmt->error, $showBackButton=false);
        return false;
    }

    $row = $result->fetch_assoc();
    if ($row) {
        echo $row["Email"];
    } else {
        echo 'UNKNOWN';
    }
?>
</b>
<form action="myaccount-email-post.php" method="post">
  <label for="newEmail"><b>New email address</b></label><br>
  <input type="text" id="newEmail" name="newEmail"><br><br>
  <input type="submit">
</form>

<h2>Delete Account</h2>
<p class="warning">This action is irreversible!</p>
<form action="myaccount-delete-post.php" method="post">
  <input type="submit" value="Delete my account">
</form>

<?php } else {
    print_error("You must be logged in to view this page.");
} ?>
</body>
</html>
