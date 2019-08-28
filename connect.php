<?php

    $dbhost = 'localhost';
    $dbname = 'projector_studio';
    $dbuser = 'root';
    $dbpass = '';

    try {
        $connect = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
        $connect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOexception $e) {
        echo $e -> getMessage();
        exit;
    }

?>