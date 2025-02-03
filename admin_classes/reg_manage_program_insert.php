<?php 
session_start();
include 'config_mysqli.php';
   
$program_id           = mt_rand(100000,999999);
$program_code         = $_POST['program_code'];
$program_description  = $_POST['program_description'];
$department_id        = $_POST['department_id'];

$program_code_upper     = strtoupper($program_code);
$program_description_uc = ucwords($program_description);
$program_status = 1;

//data for user log table
$faculty_user_id  = $_POST['faculty_user_id'];
$user_action      = 'Added new program <b>'.$program_description_uc.' '.'('.$program_code_upper.')</b>';
$user_log_date    = date('Y-m-d');
$user_log_time    = date('H:i:s');
$zero             = 0;  

$query = mysqli_query($con,"SELECT * FROM manage_program WHERE program_code = '$program_code' OR program_description = '$program_description'");

if (mysqli_num_rows($query)>0){
		echo json_encode(array("statusCode"=>201));

}else{

    $sql = "INSERT INTO `manage_program`(`program_id`, `department_id`, `program_code`, `program_description`, `program_status`) 
            VALUES ('$program_id','$department_id','$program_code_upper','$program_description_uc','$program_status')";

    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");
    
    if (mysqli_query($con, $sql)) {

        $_SESSION['department_id'] = $department_id;
        $_SESSION['program_id']    = $program_id;
        echo json_encode(array("statusCode"=>200));

    } else {
        echo json_encode(array("statusCode"=>201));
    }


}

 ?>