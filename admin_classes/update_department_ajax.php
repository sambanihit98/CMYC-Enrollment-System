<?php 
session_start();
include 'config_mysqli.php';
   
$department_code         = $_POST['department_code'];
$department_description  = $_POST['department_description'];
$department_id           = $_POST['department_id'];

$department_code_upper = strtoupper($department_code);
$department_description_uc = ucwords($department_description);

//hidden
$department_code_hid = $_POST['department_code_hid'];
$department_description_hid = $_POST['department_description_hid'];

//data for user log table
$faculty_user_id  = $_POST['faculty_user_id'];
$user_action      = 'Updated <b>'.$department_description_uc.' '.'('.$department_code_upper.')</b>'.' department';
$user_log_date    = date('Y-m-d');
$user_log_time    = date('H:i:s');
$zero             = 0;  

$query = mysqli_query($con,"SELECT * FROM manage_department WHERE department_code ='$department_code' AND department_description ='$department_description'");

if (mysqli_num_rows($query)>0){
		echo json_encode(array("statusCode"=>201));

}else{
    $sql = "UPDATE `manage_department` SET `department_code`='$department_code_upper',`department_description`='$department_description_uc' WHERE `department_id`='$department_id'";
    
    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    if (mysqli_query($con, $sql)) {

        $_SESSION['department_id'] = $department_id;
        $_SESSION['department_code_hid'] = $department_code_hid;
        $_SESSION['department_description_hid'] = $department_description_hid;

        echo json_encode(array("statusCode"=>200));

    } else {
        echo json_encode(array("statusCode"=>201));
    }


}







 ?>