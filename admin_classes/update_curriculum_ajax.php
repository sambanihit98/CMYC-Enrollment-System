<?php 
session_start();
include 'config_mysqli.php';

$program_id_new      = $_POST['program_id_new'];
$curriculum_year_new = $_POST['curriculum_year_new'];

//hidden
$program_id_old      = $_POST['program_id_old'];
$curriculum_year_old = $_POST['curriculum_year_old'];
$department_id_hid   = $_POST['department_id_hid'];
$curriculum_id_hid   = $_POST['curriculum_id_hid'];

//data for user log table
$faculty_user_id  = $_POST['faculty_user_id'];
$user_log_date    = date('Y-m-d');
$user_log_time    = date('H:i:s');
$zero             = 0; 

$query = mysqli_query($con, "SELECT * FROM manage_curriculum WHERE program_id ='$program_id_new' 
                            AND department_id = '$department_id_hid' AND curriculum_year = '$curriculum_year_new'");
                            
if (mysqli_num_rows($query)>0){
    echo json_encode(array("statusCode"=>201));

}else{

    $sql = "UPDATE `manage_curriculum` SET `program_id`='$program_id_new',
            `curriculum_year`='$curriculum_year_new' WHERE `curriculum_id`='$curriculum_id_hid'";
    
    if (mysqli_query($con, $sql)) {

        $query_curriculum_old = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id_old'");
        while($row_curriculum_old = mysqli_fetch_array($query_curriculum_old)){
            $program_code_old = $row_curriculum_old['program_code'];
            $hyphen = " - ";

            $curriculum_old =  $program_code_old.$hyphen.$curriculum_year_old;
        }

        $query_curriculum_new = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id_new'");
        while($row_curriculum_new = mysqli_fetch_array($query_curriculum_new)){
            $program_code_new = $row_curriculum_new['program_code'];
            
            $curriculum_new = $program_code_new.$hyphen.$curriculum_year_new;
        }

        //---------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------
        // user log
        $user_action  = 'Updated <b>'.$curriculum_old.'</b> to <b>'.$curriculum_new.'</b> curriculum';

        mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
        VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

        //---------------------------------------------------------------------------------------------
        //---------------------------------------------------------------------------------------------

        $_SESSION['curriculum_old'] = $curriculum_old;
        $_SESSION['curriculum_new'] = $curriculum_new;

        echo json_encode(array("statusCode"=>200));
        

        //$_SESSION['program_id'] = $program_id; 

        //$_SESSION['program_code'] = $program_code;
        //$_SESSION['program_description'] = $program_description;

        //$_SESSION['program_code_hid'] = $program_code_hid;
        //$_SESSION['program_description_hid'] = $program_description_hid;

    } else {
        echo json_encode(array("statusCode"=>201));
    }

}
 ?>