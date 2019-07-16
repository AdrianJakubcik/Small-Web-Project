<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Testing</title>
    <?php
    require('../Nav/Nav_Header.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="index_style.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!--<link rel="stylesheet" type="text/css" media="screen" href="../Menu/main_menu.css" />-->
</head>

<body style="z-index: -10;">
<main class="body">
    <?php
      //require("../Menu/main_menu.php");
      require('../../Public/Nav/Nav.php');
    ?>
        <div class="container">
            <nav class="auth">
                <div class="login selected">Login</div>
                <div class="signup" onclick="location.href='../Register';">Register</div>
            </nav>
            <main>
                <div id='login' class="show">
                    <form class="login-form" novalidate>
                        <div>
                            <div style="text-align:center;"><label for="">Username</label></div>
                            <input id="login-username" type="text" required autofocus />
                            <?php
                              //echo(date("d.m.Y"));
                            ?>
                                <div class="msg-error">Please enter your username</div>
                        </div>
                        <div>
                            <div style="text-align:center;"><label for="">Password</label></div>
                            <input id="login-password" type="password" required />
                            <div class="msg-error">Please enter your password</div>
                        </div>
                        <div>
                            <div class="input-select">
                                <input id="remember-me" type="checkbox" />
                                <label for="remember-me">Remember me</label>
                            </div>
                        </div>
                        <div class="forgot_pw_container">
                            <div>Forgot Password?</div>
                        </div>
                        <div>
                            <button type="submit" class="submit-btn">Login</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
        <?php
        require('../Nav/Nav_Footer.php');
        ?>
        <script src="index_java.js"></script>
</main>
</body>

</html>