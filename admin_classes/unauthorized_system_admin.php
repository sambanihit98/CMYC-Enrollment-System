<?php

if(!isset($_SESSION['system_admin_user_id'])){
    // not logged in
    header('location:index.php?unauthorized');
    exit();
 }

?>