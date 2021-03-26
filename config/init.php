<?php
    define('__ROOT__', dirname(dirname(__FILE__)));

    // Load Class
    spl_autoload_register(function($class){
        require_once (__ROOT__.'../classes/'.$class.'.php');
    });

    // Load URL
    require_once 'base_url.php';

    // Session Start
    session_start();

    // Load DB
    $db = Database::koneksiDatabase();
?>