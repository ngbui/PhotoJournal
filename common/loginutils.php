<?php
// BCRYPT is the default hash algorithm as of PHP 5.5
$passwordHashAlgo = PASSWORD_BCRYPT;

function doLogin($username) {
    $_SESSION["username"] = $username;
    $_SESSION["loginTime"] = time();
}

function doLogout() {
    unset($_SESSION["username"]);
    unset($_SESSION["loginTime"]);
}

?>
