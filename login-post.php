<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>Log In - PhotoJournal</title>
<link href="res/main.css" rel="stylesheet">
</head>

<body>
<?php
$hideLoginInfo = true;
require_once("common/pagehead.php");
require_once("common/loginutils.php");
?>
<h1>Login Status</h1>

<?php
function process_login() {
    // Begin input sanitization
    foreach (array("username", "password") as $varName) {
        if (empty($_POST[$varName])) {
            print_error("$varName must be set");
            return false;
        }
    }
    $username     = $_POST['username'];
    $password     = $_POST['password'];
    // End input sanitization

    global $conn;
    $result = executeBoundSQL("SELECT Username, PasswordHash FROM Account WHERE Username = ?",
        "s", $username);

    $row = $result->fetch_assoc();
    if (!$row || !password_verify($_POST['password'], $row["PasswordHash"])) {
        print_error("Bad username or password");
    } else {
        $username = $row["Username"];
        doLogin($username);
        print_success("Successfully logged in as " . htmlspecialchars($username));
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    process_login();
} else {
    print_error("bad request type");
}

?>

</body>
</html>
