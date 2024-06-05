<?php
    $hostname = "localhost";
    $dbname = "scuola";
    $user = "root";
    $pass = "";
    $conn = mysqli_connect($hostname, $user, $pass, $dbname) or die("Errore : " . mysqli_connect_error());
    ?>