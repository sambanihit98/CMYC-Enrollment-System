<?php 

include 'config_mysqli.php';

if(isset($_POST['announcement_id'])){
    
    $faculty_user_id = $_POST['faculty_user_id'];
    $announcement_id = $_POST['announcement_id'];

        $response = "<input type = 'text' name = 'announcement_id' value = '$announcement_id' hidden>";
        $response .= "<input type = 'text' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";
    

    echo $response;
    exit;
}

?>