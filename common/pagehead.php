<?php
// Common code that runs at the start of each page

// Load PHP sessions for tracking user logins
if (!empty($phpSessionPath)) {
    if (!is_writable($phpSessionPath)) {
        print_error("ERROR: php session path is not writable, logins will not work!");
    }
    session_save_path($phpSessionPath);
}
session_start();

?>
<nav class="nav">
    <ul class="nav-inner">
        <li><a href="index.php"><b>PhotoJournal</b></a></li>
        <!-- Add more links here -->
        <li><a href="photos.php">Photos</a></li>
        <li><a href="album.php">Albums</a></li>
        <li><a href="myposts.php">Manage Posts</a></li>
        <li><a href="tag.php">Manage Tags</a></li>
        <li><a href="stats.php">Stats</a></li>
        <li><a href="myaccount.php">My Account</a></li>
        <div style="float: right" class="nav-inner">
<?php
    // Not a rigorous login check
    if (!$hideLoginInfo) {
        if (isset($_SESSION["username"])) {
            echo '<li>Logged in as <b>' . htmlspecialchars($_SESSION["username"]) . '</b></li>';
            echo '<li><a href="logout.php">Log out</a></li>';
        } else {
            echo '<li><a href="register.php">Register</a></li>';
            echo '<li><a href="login.php">Log in</a></li>';
        }
    }
?>
    </ul>
</nav>

