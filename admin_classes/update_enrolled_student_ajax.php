<?php 
  session_start();
  include 'config_mysqli.php';
    
    $enrollment_id          = $_POST['enrollment_id'];  
    $student_id             = $_POST['student_id'];
    $new_firstname          = $_POST['new_firstname'];   
    $new_middlename         = $_POST['new_middlename'];  
    $new_lastname           = $_POST['new_lastname'];
    $new_name_extension     = $_POST['new_name_extension'];
    $new_student_status     = $_POST['new_student_status'];
    $new_student_year_level = $_POST['new_student_year_level'];
    $new_student_section    = $_POST['new_student_section'];
    $new_student_type       = $_POST['new_student_type'];

    $middle_initial = substr($new_middlename, 0, 1);
    $fullname = $new_firstname.' '.$middle_initial.'. '.$new_lastname;

    //data for user log table
    $faculty_user_id  = $_POST['faculty_user_id'];
    $user_action      = 'Updated <b>'.$fullname.' (Student)</b> enrollment information';
    $user_log_date    = date('Y-m-d');
    $user_log_time    = date('H:i:s');
    $zero             = 0;

    //-------------------------------------------------------------------------------------------
    //-------------------------------------------------------------------------------------------

    mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
        VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    mysqli_query($con, "UPDATE student_info SET firstname = '$new_firstname',
                        middlename = '$new_middlename',
                        lastname = '$new_lastname',
                        name_extension = '$new_name_extension'
                        WHERE student_id = '$student_id'");

    mysqli_query($con, "UPDATE manage_enrollment SET student_firstname = '$new_firstname',
                                                    student_middlename = '$new_middlename',
                                                    student_lastname = '$new_lastname',
                                                    student_name_extension = '$new_name_extension'
                                                WHERE student_id = '$student_id'");

    mysqli_query($con, "UPDATE manage_enrollment SET student_status = '$new_student_status',
                                                    student_year_level = '$new_student_year_level',
                                                    student_section = '$new_student_section',
                                                    student_type = '$new_student_type'
                                                WHERE enrollment_id = '$enrollment_id'");

    echo json_encode(array("statusCode"=>200));

 ?>