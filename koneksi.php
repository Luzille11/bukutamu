<?php
    $server = "localhost";
    $user = "root";
    $passwoard = "";
    $databaese = "db_bukutamu";

    $koneksi = mysqli_connect($server, $user, $passwoard, $databaese) or die(myqli_error ($koneksi));


?>