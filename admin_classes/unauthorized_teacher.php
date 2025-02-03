<?php

if(!isset($_SESSION['teacher_user_id'])){
    // not logged in
    header('location:index.php?unauthorized');
    exit();
 }

?>