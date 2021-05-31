<?php require_once("common/database.php"); ?>
<!DOCTYPE html>
<html>
<head>
<title>Sign Up - PhotoJournal</title>
<link href="res/main.css" rel="stylesheet">
</head>

<body>
<?php require_once("common/pagehead.php"); ?>
<h1>Sign Up</h1>
<form action="register-post.php" method="post">
  <label for="username"><b>Username</b> (case sensitive)</label><br>
  <input type="text" id="username" name="username"><br><br>

  <label for="email"><b>Email</b></label><br>
  <input type="text" id="email" name="email"><br><br>

  <label for="password"><b>Password</b></label><br>
  <input type="password" id="password" name="password"><br><br>
  <input type="submit">
</form>

</body>
</html>
