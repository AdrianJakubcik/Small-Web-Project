<?php
  $bg = array('img/Wallpaper/1.jpg', 'img/Wallpaper/2.jpg'); // array of filenames

  $i = rand(0, count($bg)-1); // generate random number size of the array
  $selectedBg = "$bg[$i]"; // set variable equal to which random filename was chosen
?>