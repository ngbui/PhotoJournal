<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>Log Out - PhotoJournal</title>
<link href="res/main.css" rel="stylesheet">
</head>

<body>
<?php
$hideLoginInfo = true;
require_once("common/pagehead.php");
require_once("common/loginutils.php");
?>
<h1>Log Out</h1>

<?php

if (empty($_SESSION["username"])) {
    print_error("You are not logged in.");
} else {
    $oldUser = $_SESSION["username"];
    doLogout();
    print_success("Successfully logged out of " . htmlspecialchars($oldUser));
}
?>

</body>
</html>
