<?php 
session_start();
include 'config_mysqli.php';
   
$department_id           = mt_rand(100000,999999);
$department_code         = $_POST['department_code'];
$department_description  = $_POST['department_description'];
$department_status       = 1;

$department_code_upper = strtoupper($department_code);
$department_description_uc = ucwords($department_description);

//data for user log table
$faculty_user_id  = $_POST['faculty_user_id'];
$user_action      = 'Added new department <b>'.$department_description_uc.' '.'('.$department_code_upper.')</b>';
$user_log_date    = date('Y-m-d');
$user_log_time    = date('H:i:s');
$zero             = 0;  

$query = mysqli_query($con,"SELECT * FROM manage_department WHERE department_code ='$department_code' OR department_description ='$department_description'");

if (mysqli_num_rows($query)>0){
		echo json_encode(array("statusCode"=>201));

}else{
    $sql = "INSERT INTO `manage_department`(`department_id`, `department_code`, `department_description`, `department_status`)
            VALUES ('$department_id','$department_code_upper','$department_description_uc', '$department_status')";

    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");
    
    if (mysqli_query($con, $sql)) {

        $_SESSION['department_id'] = $department_id;
        echo json_encode(array("statusCode"=>200));

    } else {
        echo json_encode(array("statusCode"=>201));
    }


}







 ?>