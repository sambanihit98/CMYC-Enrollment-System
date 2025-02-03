<?php 
session_start();
include 'config_mysqli.php';
   
$program_code             = $_POST['program_code'];
$program_description      = $_POST['program_description'];
$program_id               = $_POST['program_id'];

//hidden
$program_code_hid         = $_POST['program_code_hid'];
$program_description_hid  = $_POST['program_description_hid'];
$department_id            = $_POST['department_id_hid'];

$program_code_upper       = strtoupper($program_code);
$program_description_uc   = ucwords($program_description);

//data for user log table
$faculty_user_id  = $_POST['faculty_user_id'];
$user_action      = 'Updated <b>'.$program_description_uc.' '.'('.$program_code_upper.')</b>'.' program';
$user_log_date    = date('Y-m-d');
$user_log_time    = date('H:i:s');
$zero             = 0;  

$query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_code ='$program_code' 
                            AND program_description = '$program_description' AND department_id = '$department_id'");
                            
if (mysqli_num_rows($query)>0){
    echo json_encode(array("statusCode"=>201));

}else{

    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
    VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    $sql = "UPDATE `manage_program` SET `program_code`='$program_code_upper',
            `program_description`='$program_description_uc' WHERE `program_id`='$program_id'";
    
    if (mysqli_query($con, $sql)) {

        echo json_encode(array("statusCode"=>200));

        $_SESSION['program_id'] = $program_id; 

        $_SESSION['program_code'] = $program_code;
        $_SESSION['program_description'] = $program_description;

        $_SESSION['program_code_hid'] = $program_code_hid;
        $_SESSION['program_description_hid'] = $program_description_hid;

    } else {
        echo json_encode(array("statusCode"=>201));
    }


}

 ?>