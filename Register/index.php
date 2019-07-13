<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Testing</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="index_style.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../Menu/main_menu.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body style="z-index: -10;">
<?php
  require("../Menu/main_menu.php");
?>
<div class="container">
  <nav class="auth">
    <div class="login" onclick="location.href='../Login';">Login</div>
    <div class="signup selected">Register</div>
  </nav>
  <main>
    <div id='signup' class="show">
      <form class="signup-form" novalidate>
        <div>
          <label for="">Username</label>
          <input id="signup-username" type="text" required autofocus/>
          <div class="msg-error">Please enter your username</div>
        </div>
        <div>
          <label for="">Password</label>
          <input id="signup-password" type="password" required/>
          <div class="msg-error">Please enter your password</div>
        </div>
        <div>
          <label for="">Confirm Password</label>
          <input id="signup-repassword" type="password" required/>
          <div class="msg-error" id="first_error">Please re-enter your password</div>
          <div class="msg-error" id="second_error">The passwords don't match</div>
        </div>
        <div>
          <label for="">Email</label>
          <input id="signup-email" type="email" required/>
          <div class="msg-error">Please enter your email</div>
        </div>
        <div>
        <button>Sign up</button>
        </div>
        </form>
      </div>
  </main>
</div>
<script src="index_java.js"></script>
</body>
</html>