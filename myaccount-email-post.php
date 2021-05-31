<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>Update email - PhotoJournal</title>
<link href="res/main.css" rel="stylesheet">
</head>

<body>
<?php
$hideLoginInfo = true;
require_once("common/pagehead.php");
require_once("common/loginutils.php");
?>
<h1>Update email</h1>

<?php
function process_request() {
    // Begin input sanitization
    if (empty($_SESSION["username"])) {
        print_error("You must be logged in to perform this action");
        return false;
    }
    if (empty($_POST["newEmail"])) {
        print_error("email must not be empty");
        return false;
    }
    $email = $_POST['newEmail'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        print_error("Invalid email $email");
        return false;
    }

    global $conn;
    $stmt = $conn->prepare("UPDATE Account SET Email = ? WHERE Username = ?");
    // "ss" here refers to the type of the args: see https://www.php.net/manual/en/mysqli-stmt.bind-param.php
    $stmt->bind_param("ss", $email, $_SESSION["username"]);
    if (!$stmt->execute()) {
        print_error("Error updating email: " . $stmt->error);
    } else {
        print_success("Successfully updated email to " . $email);
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
