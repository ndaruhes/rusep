<?php
    require_once '../config/init.php';
    session_destroy();
    Redirect::to('../');
?>