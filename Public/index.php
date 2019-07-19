<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Welcome</title>
    <?php
    require('Nav/Nav_Header.php');
    ?>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' media='screen' href='index_style.css'>
        <!--<script src='main.js'></script>-->
</head>

<body>
    <!--<section id="cd-intro">
        <div id="cd-intro-tagline">
            <h1>Welcome To Paradise</h1>
            <a href="#" class="cd-btn">Scroll Down</a>
        </div>
    </section>-->
    <main class="body">
        <!--  Nav Menu Begin -->
        <?php require('Nav/Nav.php'); ?>
        <!--  Nav Menu End  -->

        <!-- Body Begin -->
        <!--<div class="container_message">
            <div class="tasks">
                <ul>
                    <div class="block"><i class="finished"><li class="task" id="finished">Build Database</li></i></div>
                    <div class="block"><i class="finished"><li class="task" id="finished">Login & Register</li></i></div>
                    <div class="block"><i class="pending"><li class="task" id="pending">Validate Forms</li></i></div>
                </ul>
            </div>
        </div>-->
        <!-- Body End -->
        <?php require('Nav/Nav_Footer.php');?>
        <script>
            $(document).ready(function() {

                $('.cd-btn').click(function() {
                    $('html, body').animate({
                        scrollTop: $(document).height()
                    }, 'slow');
                    return false;
                });

            });
        </script>
    </main>
</body>

</html>