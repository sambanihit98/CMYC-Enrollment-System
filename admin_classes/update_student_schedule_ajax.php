<?php 

    include 'config_mysqli.php';
    
        $enrollment_id            = $_POST['enrollment_id'];
        $old_subject_id           = $_POST['old_subject_id'];
        $subject_id               = $_POST['subject_id'];
        $program_id               = $_POST['program_id'];
        $year_level               = $_POST['year_level'];
        $section                  = $_POST['section'];
        $student_subject_load_id  = $_POST['student_subject_load_id'];

        $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
        while($row_subject = mysqli_fetch_array($query_subject)){
            $subject_code        = $row_subject['subject_code'];
            $subject_description = $row_subject['subject_description'];

            //-------------------------------------------------
            $subject = $subject_code.': '.$subject_description;
        }

        $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment 
        JOIN academic_year ON manage_enrollment.academic_id = academic_year.academic_id
        WHERE enrollment_id = '$enrollment_id'");

        while($row_enrollment = mysqli_fetch_array($query_enrollment)){
            $student_firstname  = $row_enrollment['student_firstname'];
            $student_middlename = $row_enrollment['student_middlename'];
            $student_lastname   = $row_enrollment['student_lastname'];
            $middle_initial     = substr($student_middlename, 0, 1);

            //academic_year
            $academic_year_from = $row_enrollment['academic_year_from'];
            $academic_year_to   = $row_enrollment['academic_year_to'];
            $academic_term      = $row_enrollment['academic_term'];

            //-------------------------------------------------
            $fullname      = $student_firstname.' '.$middle_initial.'. '.$student_lastname;
            $academic_year = $academic_year_from.' - '.$academic_year_to.' ('.$academic_term.')';
        }

        //data for user log table
        $faculty_user_id  = $_POST['faculty_user_id'];
        $user_log_date    = date('Y-m-d');
        $user_log_time    = date('H:i:s');
        $zero             = 0; 
        $user_action      = 'Updated <b>'.$subject.'</b> subject load schedule of <b>'.$fullname.' (Student)</b> on academic year <b>'.$academic_year.'</b>';

        //------------------------------------------------------------------------------------------------
        //------------------------------------------------------------------------------------------------
        //insert user_log
        mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
        VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

        //update student_subject_load table
        mysqli_query($con, "UPDATE `student_subject_load` SET `student_subject_section`='$section',
        `student_subject_section_course`='$program_id', `student_subject_section_year`='$year_level', 
        `subject_id`='$subject_id' WHERE student_subject_load_id = '$student_subject_load_id'");

        //update grades report                                      
        mysqli_query($con, "UPDATE `grades_report` SET `grades_section`='$section',
        `grades_course`='$program_id', `grades_year`='$year_level',
        `subject_id`='$subject_id' WHERE enrollment_id = '$enrollment_id' AND subject_id = '$old_subject_id'");

        echo json_encode(array("statusCode"=>200));

                

 ?>