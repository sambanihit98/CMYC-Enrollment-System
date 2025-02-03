<?php 

    session_start();
    include "config_mysqli.php";
    
    $subject_id               = mt_rand(100000,999999);

    $curriculum_id            = $_POST['curriculum_id'];
    $subject_year_level       = $_POST['subject_year_level'];
    $subject_semester         = $_POST['subject_semester'];
 
    $subject_description      = addslashes($_POST['subject_description']);
    $subject_unit             = $_POST['subject_unit'];
    $subject_id_prerequisite  = $_POST['subject_id_prerequisite'];
    $subject_status           = "1";
    $subjectcode              = strtoupper($_POST['subjectcode']);

    $subject_desc_uc = ucwords($subject_description);

    $subject = $subject_description.' '.'('.$subjectcode.')';

    //data for user log table
    $faculty_user_id  = $_POST['faculty_user_id'];
    $user_log_date    = date('Y-m-d');
    $user_log_time    = date('H:i:s');
    $zero             = 0;  

    //year
    if($subject_year_level == 1){
        $year_level = '1st Year';

    }else if($subject_year_level == 2){
        $year_level = '2nd Year';

    }else if($subject_year_level == 3){
        $year_level = '3rd Year';

    }else if($subject_year_level == 4){
        $year_level = '4th Year';
        
    }


$query = mysqli_query($con,"SELECT * FROM manage_subject
                            WHERE subject_code = '$subjectcode' 
                            AND subject_description = '$subject_description' 
                            AND curriculum_id = '$curriculum_id'");

if(mysqli_num_rows($query)>0){

		echo json_encode(array("statusCode"=>201));

}else{

    $query_program_department = mysqli_query($con, "SELECT * FROM manage_curriculum JOIN manage_program 
    ON manage_curriculum.program_id = manage_program.program_id WHERE manage_curriculum.curriculum_id = '$curriculum_id'");
    while($row_program_department = mysqli_fetch_array($query_program_department)){
        
        $department_id = $row_program_department['department_id'];

        //manage_program table
        $program_id    = $row_program_department['program_id'];
        $program_code  = $row_program_department['program_code'];

        //user log
        $user_action      = 'Added new subject <b>'.$subject_desc_uc.' '.'('.$subjectcode.')</b> on <b>'.$program_code.'</b> course (<b>'.$year_level.' - '.$subject_semester.'</b>)';

        $sql = "INSERT INTO `manage_subject`(`subject_id`, `department_id`, `program_id`, `curriculum_id`, `subject_code`, `subject_description`, `subject_unit`, `subject_id_prerequisite`, `subject_year_level`, `subject_semester`, `subject_status`)
         VALUES ('$subject_id','$department_id','$program_id','$curriculum_id','$subjectcode','$subject_desc_uc','$subject_unit','$subject_id_prerequisite','$subject_year_level','$subject_semester','$subject_status')";


        mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
            VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");
    }

    
if (mysqli_query($con, $sql)){     

    $_SESSION['subject'] = $subject;
    echo json_encode(array("statusCode"=>200));

} else {
    echo json_encode(array("statusCode"=>201));
}

}


?>