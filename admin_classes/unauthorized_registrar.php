<?php

if(!isset($_SESSION['registrar_user_id'])){
    // not logged in
    header('location:index.php?unauthorized');
    exit();
 }

?>