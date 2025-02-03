<?php
    include 'config_mysqli.php';

    $enrollment_id = mt_rand(100000,999999);

    $student_id         = $_POST['student_id'];
    $academic_id        = $_POST['academic_id'];

    $department_id      = $_POST['department_id'];    
    $program_id         = $_POST['program_id'];     
    $curriculum_id      = $_POST['curriculum_id']; 

    $student_status     = $_POST['student_status'];
    $student_year_level = $_POST['student_year_level'];
    $student_semester   = $_POST['student_semester'];
    $student_section    = $_POST['student_section'];

    $lastname           = $_POST['lastname'];
    $firstname          = $_POST['firstname'];
    $middlename         = $_POST['middlename']  ;
    $name_extension     = $_POST['name_extension'];

    $address            = $_POST['address'];

    $birthdate          = $_POST['birthdate'];
    $birthplace         = $_POST['birthplace'];
    $gender             = $_POST['gender'];
    $civil_status       = $_POST['civil_status'];
    
    $citizenship        = $_POST['citizenship'];
    $religion           = $_POST['religion'];
    $phone_number       = $_POST['phone_number'];
    $email              = $_POST['email'];

    $password           = "cmycstudent";
    $student_type       = 'Cross Enrollee';
    
    $enrolled_date = date('Y-m-d');
    $enrolled_time = date('H:i:s');

    //---------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------
    //COURSE
    $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
    while($row_program = mysqli_fetch_array($query_program)){
      $program_code        = $row_program['program_code'];
    }

    //ACADEMIC YEAR
    $query_academic = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_id = '$academic_id'");
    while($row_academic = mysqli_fetch_array($query_academic)){
      $academic_year_from = $row_academic['academic_year_from'];
      $academic_year_to   = $row_academic['academic_year_to'];
      $academic_term      = $row_academic['academic_term'];
    }
    //---------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------
    //MERGE
    $middle_initial   = substr($middlename, 0, 1);
    $fullname         = $firstname.' '.$middle_initial.'. '.$lastname;
    $section          = $program_code.'-'.$student_year_level.$student_section;
    $academic_year    = $academic_year_from.' - '.$academic_year_to.' ('.$academic_term.')';

    //data for user log table
    $faculty_user_id  = $_POST['faculty_user_id'];
    $user_log_date    = date('Y-m-d');
    $user_log_time    = date('H:i:s');
    $zero             = 0;  
    $user_action      = 'Enrolled <b>'.$fullname.' (Cross Enrollee)</b> in <b>'.$section.'</b> for the academic year <b>'.$academic_year.'</b>';
    
    //---------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------
    
    // checks in student_info table
    $query1 = mysqli_query($con, "SELECT * FROM student_info 
                                    WHERE firstname = '$firstname' 
                                    AND middlename = '$middlename'
                                    AND lastname = '$lastname'");
                                    
    // checks in manage_enrollment table // checks with academic_id
    $query2 = mysqli_query($con, "SELECT * FROM manage_enrollment
                            WHERE academic_id = '$academic_id'
                            AND student_firstname = '$firstname' 
                            AND student_middlename = '$middlename'
                            AND student_lastname = '$lastname'");

        //Error Duplicate on student_info table
        if (mysqli_num_rows($query1)>0){
            echo json_encode(array("statusCode"=>201));

        //Error Duplicate on manage_enrollment table
        }else if (mysqli_num_rows($query2)>0){
          echo json_encode(array("statusCode"=>202));

        }else{    
            
          //inserts on user_log table
          mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
          VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");     

          //inserts on student_info table
          mysqli_query($con, "INSERT INTO `student_info`(`student_id`, `curriculum_id`, `firstname`, `middlename`, `lastname`, `name_extension`, `address`, `birthdate`, `birthplace`, `gender`, `civil_status`, `citizenship`, `religion`, `phone_number`, `email`, `password`) 
                              VALUES ('$student_id','$curriculum_id','$firstname','$middlename','$lastname','$name_extension','$address','$birthdate','$birthplace','$gender','$civil_status','$citizenship','$religion','$phone_number','$email','$password')");

          //inserts on manage_enrollment table
          mysqli_query($con, "INSERT INTO `manage_enrollment`(`enrollment_id`, `student_id`, `student_firstname`, `student_middlename`, `student_lastname`, `student_name_extension`, `academic_id`, `curriculum_id`, `program_id`, `department_id`, `student_status`, `student_type`, `student_year_level`, `student_semester`, `student_section`, `enrolled_date`, `enrolled_time`) 
                              VALUES ('$enrollment_id','$student_id','$firstname','$middlename','$lastname','$name_extension','$academic_id','$curriculum_id','$program_id','$department_id','$student_status','$student_type','$student_year_level','$student_semester','$student_section','$enrolled_date','$enrolled_time')");
                        
          echo json_encode(array("statusCode"=>200));
            
        }
?>