<?php 
session_start();
include 'config_mysqli.php';

$curriculum_id = mt_rand(100000,999999);
$program_id = $_POST['program_id'];
$curriculum_year = $_POST['curriculum_year'];
$department_id = $_POST['department_id'];
$curriculum_status = '0';

//data for user log table
$faculty_user_id  = $_POST['faculty_user_id'];
$user_log_date    = date('Y-m-d');
$user_log_time    = date('H:i:s');
$zero             = 0;  

$check_curriculum = mysqli_query($con,"SELECT * FROM manage_curriculum WHERE program_id ='$program_id' AND curriculum_year ='$curriculum_year'");

if (mysqli_num_rows($check_curriculum)>0){

		echo json_encode(array("statusCode"=>201));

}else{

    $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
    while($row_program = mysqli_fetch_array($query_program)){
        $program_code = $row_program['program_code'];
        $hyphen       = "-";
        $curriculum   = $program_code." ".$hyphen." ".$curriculum_year;

        //---------------------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------------------
        //data for user log table

        $user_action  = 'Added new curriculum <b>'.$curriculum.'</b>';

        mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
        VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

        //---------------------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------------------

        $sql = "INSERT INTO `manage_curriculum`(`curriculum_id`, `program_id`, `department_id`, `curriculum_year`, `curriculum_status`) 
            VALUES ('$curriculum_id','$program_id','$department_id','$curriculum_year','$curriculum_status')";

            if (mysqli_query($con, $sql)) {

                $_SESSION['curriculum'] = $curriculum;

                echo json_encode(array("statusCode"=>200)); 

            } else {
                echo json_encode(array("statusCode"=>201));
            }

    }

}

 ?>