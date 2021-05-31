<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>Log In - PhotoJournal</title>
<link href="res/main.css" rel="stylesheet">
</head>

<body>
<?php require_once("common/pagehead.php"); ?>
<h1>Log In</h1>
<form action="login-post.php" method="post">
  <label for="username"><b>Username</b> (case sensitive)</label><br>
  <input type="text" id="username" name="username"><br><br>

  <label for="password"><b>Password</b></label><br>
  <input type="password" id="password" name="password"><br><br>
  <input type="submit">
</form>

</body>
</html>
