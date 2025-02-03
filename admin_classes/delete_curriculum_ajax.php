<?php 

include '../admin_classes/config_mysqli.php';

if(isset($_POST['curriculum_id'])){
    
    $faculty_user_id = $_POST['faculty_user_id'];
    $curriculum_id   = $_POST['curriculum_id'];

        $response = "<input type  = 'text' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";
        $response .= "<input type = 'text' name = 'curriculum_id'   value = '$curriculum_id'   hidden>";
    

    echo $response;
    exit;
}

?>