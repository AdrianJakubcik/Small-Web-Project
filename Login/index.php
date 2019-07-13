<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Testing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="index_style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="../Menu/main_menu.css" />
</head>
<body style="background-color:#737373; z-index: -10;">
<?php
  require("../Menu/main_menu.php");
?>
<div class="container" style="max-width:22.2%; padding-bottom:8px; margin-top:300px;">
  <nav class="auth">
    <div class="login selected">Login</div>
    <div class="signup" onclick="location.href='../Register';">Register</div>
  </nav>
  <main>
    <div id='login' class="show">
      <form class="login-form" novalidate>
        <div>
          <label for="">Username</label>
          <input id="login-username" type="text" required autofocus />
          <?php
            //echo(date("d.m.Y"));
          ?>
          <div class="msg-error">Please enter your username</div>
        </div>
        <div>
          <label for="">Password</label>
          <input id="login-password" type="password" required />
          <div class="msg-error">Please enter your password</div>
        </div>
        <div>
          <div class="input-select">
            <input id="remember-me" type="checkbox" />
            <label for="remember-me">Remember me</label>
          </div>
        </div>
        <div>
          <button type="submit">Log in</button>
        </div>
      </form>
      </div>    
    </main>
  </div>
<script src="index_java.js"></script>
</body>
</html>