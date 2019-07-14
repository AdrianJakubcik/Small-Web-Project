<?php

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Password Reset</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="index_style.css?v=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" media="screen" href="../Menu/main_menu.css" />
</head>

<body style="z-index: -10;">
    <?php
  require("../Menu/main_menu.php");
?>
        <div class="container">
            <main>
                <div id='login' class="show">
                    <form class="reset-form-Pass" novalidate>
                        <div>
                            <h2 class="container_title">Password Reset</h2>
                            <p class="description">Please Enter Your New Password Below And Then Confirm It</p>
                            <hr/>
                            <div class="label_holder"><label for="" style="text-align: center;">New Password</label></div>
                            <div class="input_holder"><input id="reset-pass" type="password" required autofocus />
                            <div class="msg-error">Please enter your new password</div>
                            <div class="label_holder"><label for="" style="text-align: center;">Confirm Password</label></div>
                            <div class="input_holder"><input id="reset-re-pass" type="password" required autofocus />
                            <div class="msg-error" id="first_err">Please confirm your new password</div>
                            <div class="msg-error">Passwords do not match!</div></div>
                        </div>
                        <div class="submit_button_holder">
                            <button type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
        <script src="pw_reset_java.js?v=1.5"></script>
</body>

</html>