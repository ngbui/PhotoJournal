<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>Delete account - PhotoJournal</title>
<link href="res/main.css" rel="stylesheet">
</head>

<body>
<?php
$hideLoginInfo = true;
require_once("common/pagehead.php");
require_once("common/loginutils.php");
?>
<h1>Delete account</h1>

<?php
function process_request() {
    // Begin input sanitization
    if (empty($_SESSION["username"])) {
        print_error("You must be logged in to perform this action");
        return false;
    }

    global $conn;
    $stmt = $conn->prepare("DELETE FROM Account WHERE Username = ?");
    $stmt->bind_param("s", $_SESSION["username"]);
    if ($stmt->execute()) {
        print_success("Deleted the account " . $_SESSION["username"]);
        doLogout();
    } else {
        print_error("Error deleting account: " . $stmt->error);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process_request();
} else {
    print_error("bad request type");
}

?>

</body>
</html>
