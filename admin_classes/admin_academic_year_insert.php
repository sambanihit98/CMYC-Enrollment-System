<?php 
session_start();
include 'config_mysqli.php';
   
$academic_id         = mt_rand(100000,999999);
$academic_year_from  = $_POST['academic_year_from'];
$academic_year_to    = $_POST['academic_year_to'];
$academic_term       = $_POST['term'];
$academic_status     = '0';

//user log
$faculty_user_id     = $_POST['faculty_user_id'];
$user_action = 'Added academic year <b>'.$academic_year_from.' - '.$academic_year_to.' '.'('.$academic_term.')</b>';
$user_log_date = date('Y-m-d');
$user_log_time = date('H:i:s');
$zero          = 0;


$check_academic = mysqli_query($con,"SELECT * FROM academic_year WHERE academic_year_from ='$academic_year_from' AND academic_term ='$academic_term'");

if (mysqli_num_rows($check_academic)>0){
		echo json_encode(array("statusCode"=>201));

}else{
    $sql = "INSERT INTO `academic_year`(`academic_id`, `academic_year_from`, `academic_year_to`, `academic_term`, `academic_status`) 
    VALUES ('$academic_id','$academic_year_from','$academic_year_to','$academic_term','$academic_status')";
    
    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    if (mysqli_query($con, $sql)) {

        $_SESSION['academic_id'] = $academic_id;
        echo json_encode(array("statusCode"=>200));

    } else {
        echo json_encode(array("statusCode"=>201));
    }


}







 ?>