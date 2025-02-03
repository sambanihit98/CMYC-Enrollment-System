<?php 

include 'config_mysqli.php';

if(isset($_POST['subject_load_id'])){
    
    $faculty_user_id = $_POST['faculty_user_id'];
    $subject_load_id = $_POST['subject_load_id'];
    $account_user_id = $_POST['account_user_id'];
   
        $response  = "<input type = 'text' name = 'subject_load_id' value = '$subject_load_id' hidden>";
        $response .= "<input type = 'text' name = 'account_user_id' value = '$account_user_id' hidden>";
        $response .= "<input type = 'text' name = 'faculty_user_id' value = '$faculty_user_id' hidden>";

    echo $response;
    exit;
}

?>