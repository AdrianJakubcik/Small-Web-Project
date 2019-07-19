<?php
    if($_SERVER['SCRIPT_NAME']=="/TestingArea51/Public/index.php"){
        $dir = 'Nav/img/Wallpaper/';
    }else {
        $dir = '../Nav/img/Wallpaper/';
    }
    $bg = glob($dir . '*.jpg'); // array of filenames
    $i = rand(0, count($bg)-1); // generate random number size of the array
    $selectedBg = "$bg[$i]"; // set variable equal to which random filename was chosen
    echo'<meta http-equiv="content-type" content="text/html; charset=UTF-8">';
    echo'<meta name="viewport" content="width=device-width, initial-scale=1">';
    echo"<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>";
	echo'<link rel="stylesheet" href="http://localhost/TestingArea51/Public/Nav/css/reset.css"> <!-- CSS reset -->';
	echo'<link rel="stylesheet" href="http://localhost/TestingArea51/Public/Nav/css/style.css"> <!-- Resource style -->';
    echo'<script src="http://localhost/TestingArea51/Public/Nav/js/modernizr.js"></script>';
    echo"<style>
            main.body {
                background: url($selectedBg) no-repeat center center fixed !important;
                -webkit-background-size: cover !important;
            -moz-background-size: cover !important;
            -o-background-size: cover !important;
            background-size: cover !important;
            max-height: 100% !important;
            height: 100% !important;
            
            }
    </style";
?>