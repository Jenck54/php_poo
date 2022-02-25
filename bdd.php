<?php

$connexion = new PDO(
    'mysql:host=localhost;dbname=php_poo;charset=UTF8',
    'root',
    ''
);

$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>