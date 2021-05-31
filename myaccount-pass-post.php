<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>Change password - PhotoJournal</title>
<link href="res/main.css" rel="stylesheet">
</head>

<body>
<?php
$hideLoginInfo = true;
require_once("common/pagehead.php");
require_once("common/loginutils.php");
?>
<h1>Change password</h1>

<?php
function process_request() {
    // Begin input sanitization
    if (empty($_SESSION["username"])) {
        print_error("You must be logged in to perform this action");
        return false;
    }
    foreach (array("oldPass", "newPass") as $varName) {
        if (empty($_POST[$varName])) {
            print_error("$varName must be set");
            return false;
        }
    }
    global $conn, $passwordHashAlgo;

    $stmt = $conn->prepare("SELECT Username, PasswordHash FROM Account WHERE Username = ?");
    $stmt->bind_param("s", $_SESSION["username"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        print_error("Problem getting login information: " . $stmt->error);
        return false;
    }

    // Check that the Current Password is correct
    $row = $result->fetch_assoc();
    if (!$row || !password_verify($_POST['oldPass'], $row["PasswordHash"])) {
        print_error("Incorrect current password");
        return false;
    }

    // Now update to use the new password
    $stmt = $conn->prepare("UPDATE Account SET PasswordHash = ? WHERE Username = ?");
    $passwordHash = password_hash($_POST['newPass'], $passwordHashAlgo);
    $stmt->bind_param("ss", $passwordHash, $_SESSION["username"]);
    if ($stmt->execute()) {
        print_success("Successfully updated your password.");
    } else {
        print_error("Error updating your password: " . $stmt->error);
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
