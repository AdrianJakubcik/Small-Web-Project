<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Password Reset</title>
    <?php
    require('../Nav/Nav_Header.php');
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="index_style.css?v=2.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body style="z-index: -10;">
<main class="body">
    <?php
  require("../Nav/Nav.php");
?>
        <div class="container">
            <main>
                <div id='login' class="show">
                    <form class="reset-form" novalidate>
                        <div>
                            <h2 class="container_title">Password Reset</h2>
                            <p class="description">Please Enter Your Email Below For Us To Help You Gain Access To Your Account</p>
                            <hr/>
                            <div class="label_holder"><label for="" style="text-align: center;">Email</label></div>
                            <div class="input_holder"><input id="reset-email" type="email" required autofocus />
                            <div class="msg-error" id="first_err">Please enter your email</div>
                            <div class="msg-error">No such email Found</div></div>
                        </div>
                        <div class="submit_button_holder">
                            <button type="submit">Submit</button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
        <?php
      require('../Nav/Nav_Footer.php');
    ?>
        <script src="index_java.js?v=2.0"></script>
        </main>
</body>

</html>