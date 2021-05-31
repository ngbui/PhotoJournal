<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>Sign Up - PhotoJournal</title>
<link href="res/main.css" rel="stylesheet">
</head>

<body>
<?php
$hideLoginInfo = true;
require_once("common/pagehead.php");
require_once("common/loginutils.php");
?>
<h1>Sign Up Status</h1>

<?php
function process_register() {
    // Begin input sanitization
    foreach (array("username", "email", "password") as $varName) {
        if (empty($_POST[$varName])) {
            print_error("$varName must be set");
            return false;
        }
    }
    $username     = $_POST['username'];
    $email        = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        print_error("Invalid email $email");
        return false;
    }
    // End input sanitization

    global $conn, $passwordHashAlgo;
    $passwordHash = password_hash($_POST['password'], $passwordHashAlgo);

    $result = executeBoundSQL(
        "INSERT INTO Account (Username, Email, RegistrationTime, PasswordHash) VALUES (?, ?, now(), ?)",
        // "sss" here refers to the type of the 3 args: see https://www.php.net/manual/en/mysqli-stmt.bind-param.php
        "sss", $username, $email, $passwordHash);

    if ($result) {
        doLogin($username);
        print_success("Successfully registered as " . htmlspecialchars($username));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process_register();
} else {
    print_error("bad request type");
}

?>

</body>
</html>
