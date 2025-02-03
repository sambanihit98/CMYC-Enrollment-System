<?php

  include 'config_mysqli.php';

  if(isset($_POST['save_btn'])){

    //---------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------
    if(isset($_POST['prelim_student_id'])){

      foreach($_POST['prelim_student_id'] as $student_id){

        $prelim         = $_POST['prelim_'.$student_id];
        $period         = $_POST['period_'.$student_id];
        $student_id     = $_POST['student_id_'.$student_id];
        $academic_id    = $_POST['academic_id_'.$student_id];
        $enrollment_id  = $_POST['enrollment_id_'.$student_id];
        $subject_id     = $_POST['subject_id_'.$student_id];

        $program_id     = $_POST['program_id_'.$student_id];
        $year_level     = $_POST['year_level_'.$student_id];
        $section        = $_POST['section_'.$student_id];
    
        $query = mysqli_query($con, "UPDATE grades_report SET prelim = '$prelim' 
                        WHERE academic_id = '$academic_id'
                        AND student_id = '$student_id'
                        AND enrollment_id = '$enrollment_id'
                        AND subject_id = '$subject_id'");

        $query1 = mysqli_query($con, "SELECT * FROM grades_report 
                                WHERE academic_id = '$academic_id'
                                AND student_id = '$student_id'
                                AND enrollment_id = '$enrollment_id'
                                AND subject_id = '$subject_id'");

          while($row1 = mysqli_fetch_array($query1)){
            $midterm = $row1['midterm'];
            $final   = $row1['final'];

            $prelim_ave   = $prelim * .3;
            $midterm_ave  = $midterm * .3;
            $final_ave    = $final * .4;

            $total_ave = $prelim_ave + $midterm_ave + $final_ave;
            $number_format = number_format($total_ave, 1, '.', '');
            $rounded_ave = round($number_format,0,PHP_ROUND_HALF_EVEN);

            if($rounded_ave >= 75 && $prelim != 0 && $midterm != 0 && $final != 0){
              $remarks = 'PASSED';
            }else if($rounded_ave < 75 && $prelim != 0 && $midterm != 0 && $final != 0){
              $remarks = 'FAILED';
            }else if($prelim == 0 || $midterm == 0 || $final == 0){
              $remarks = 'UNDEFINED';
            }

            mysqli_query($con, "UPDATE grades_report SET average = '$rounded_ave', remarks = '$remarks'
                        WHERE academic_id = '$academic_id'
                        AND student_id = '$student_id'
                        AND enrollment_id = '$enrollment_id'
                        AND subject_id = '$subject_id'");
          }

        header("location:../teacher_encode_grades.php?period=$period&program_id=$program_id&year_level=$year_level&section=$section&subject_id=$subject_id&academic_id=$academic_id");

      }

       //-------------------------------------------------------------------------------------------------
        //-------------------------------------------------------------------------------------------------
        //USER LOG

        //manage_program
        $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
        while($row_program = mysqli_fetch_array($query_program)){
          $program_code        = $row_program['program_code'];
        }

        //manage_subject
        $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
        while($row_subject = mysqli_fetch_array($query_subject)){
          $subject_code        = $row_subject['subject_code'];
          $subject_description = $row_subject['subject_description'];
        }

        $subject_name = $subject_code.': '.$subject_description;
        $section_name = $program_code.'-'.$year_level.$section;

        //data for user log table
        $faculty_user_id  = $_POST['account_user_id'];
        $user_action      = 'Encoded grades on <b>'.$section_name.'</b> for the subject <b>'.$subject_name.'</b> on <b>Prelim</b> period';
        $user_log_date    = date('Y-m-d');
        $user_log_time    = date('H:i:s');
        $zero             = 0; 

        mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
        VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");
        

    //---------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------
    }else if(isset($_POST['midterm_student_id'])){

      foreach($_POST['midterm_student_id'] as $student_id){

        $midterm        = $_POST['midterm_'.$student_id];
        $period         = $_POST['period_'.$student_id];
        $student_id     = $_POST['student_id_'.$student_id];
        $academic_id    = $_POST['academic_id_'.$student_id];
        $enrollment_id  = $_POST['enrollment_id_'.$student_id];
        $subject_id     = $_POST['subject_id_'.$student_id];

        $program_id     = $_POST['program_id_'.$student_id];
        $year_level     = $_POST['year_level_'.$student_id];
        $section        = $_POST['section_'.$student_id];
    
        $query = mysqli_query($con, "UPDATE grades_report SET midterm = '$midterm' 
                        WHERE academic_id = '$academic_id'
                        AND student_id = '$student_id'
                        AND enrollment_id = '$enrollment_id'
                        AND subject_id = '$subject_id'");

        $query1 = mysqli_query($con, "SELECT * FROM grades_report 
          WHERE academic_id = '$academic_id'
          AND student_id = '$student_id'
          AND enrollment_id = '$enrollment_id'
          AND subject_id = '$subject_id'");

          while($row1 = mysqli_fetch_array($query1)){
            $prelim  = $row1['prelim'];
            $final   = $row1['final'];

            $prelim_ave   = $prelim * .30;
            $midterm_ave  = $midterm * .30;
            $final_ave    = $final * .40;

            $total_ave = $prelim_ave + $midterm_ave + $final_ave;
            $number_format = number_format($total_ave, 1, '.', '');
            $rounded_ave = round($number_format,0,PHP_ROUND_HALF_EVEN);

            if($rounded_ave >= 75 && $prelim != 0 && $midterm != 0 && $final != 0){
              $remarks = 'PASSED';
            }else if($rounded_ave < 75 && $prelim != 0 && $midterm != 0 && $final != 0){
              $remarks = 'FAILED';
            }else if($prelim == 0 || $midterm == 0 || $final == 0){
              $remarks = 'UNDEFINED';
            }

            mysqli_query($con, "UPDATE grades_report SET average = '$rounded_ave', remarks = '$remarks' 
              WHERE academic_id = '$academic_id'
              AND student_id = '$student_id'
              AND enrollment_id = '$enrollment_id'
              AND subject_id = '$subject_id'");
          }

        header("location:../teacher_encode_grades.php?period=$period&program_id=$program_id&year_level=$year_level&section=$section&subject_id=$subject_id&academic_id=$academic_id");

      }

      //-------------------------------------------------------------------------------------------------
      //-------------------------------------------------------------------------------------------------
      //USER LOG

      //manage_program
      $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
      while($row_program = mysqli_fetch_array($query_program)){
        $program_code        = $row_program['program_code'];
      }

      //manage_subject
      $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
      while($row_subject = mysqli_fetch_array($query_subject)){
        $subject_code        = $row_subject['subject_code'];
        $subject_description = $row_subject['subject_description'];
      }

      $subject_name = $subject_code.': '.$subject_description;
      $section_name = $program_code.'-'.$year_level.$section;

      //data for user log table
      $faculty_user_id  = $_POST['account_user_id'];
      $user_action      = 'Encoded grades on <b>'.$section_name.'</b> for the subject <b>'.$subject_name.'</b> on <b>Midterm</b> period';
      $user_log_date    = date('Y-m-d');
      $user_log_time    = date('H:i:s');
      $zero             = 0; 

      mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
      VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    //---------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------
    //---------------------------------------------------------------------------------------------------------------------------
    }else if(isset($_POST['final_student_id'])){

      foreach($_POST['final_student_id'] as $student_id){

        //$prelim         = $_POST['prelim_'.$student_id];
        //$midterm        = $_POST['midterm_'.$student_id];

        $program_id     = $_POST['program_id_'.$student_id];
        $year_level     = $_POST['year_level_'.$student_id];
        $section        = $_POST['section_'.$student_id];

        $final          = $_POST['final_'.$student_id];
        $period         = $_POST['period_'.$student_id];
        $student_id     = $_POST['student_id_'.$student_id];
        $academic_id    = $_POST['academic_id_'.$student_id];
        $enrollment_id  = $_POST['enrollment_id_'.$student_id];
        $subject_id     = $_POST['subject_id_'.$student_id];

          $query = mysqli_query($con, "UPDATE grades_report SET final = '$final' 
                              WHERE academic_id = '$academic_id'
                              AND student_id = '$student_id'
                              AND enrollment_id = '$enrollment_id'
                              AND subject_id = '$subject_id'");


          $query1 = mysqli_query($con, "SELECT * FROM grades_report 
            WHERE academic_id = '$academic_id'
            AND student_id = '$student_id'
            AND enrollment_id = '$enrollment_id'
            AND subject_id = '$subject_id'");

            while($row1 = mysqli_fetch_array($query1)){
              $prelim    = $row1['prelim'];
              $midterm   = $row1['midterm'];

              $prelim_ave   = $prelim * .30;
              $midterm_ave  = $midterm * .30;
              $final_ave    = $final * .40;

              $total_ave = $prelim_ave + $midterm_ave + $final_ave;
              $number_format = number_format($total_ave, 1, '.', '');
              $rounded_ave = round($number_format,0,PHP_ROUND_HALF_EVEN);

              if($rounded_ave >= 75 && $prelim != 0 && $midterm != 0 && $final != 0){
                $remarks = 'PASSED';
              }else if($rounded_ave < 75 && $prelim != 0 && $midterm != 0 && $final != 0){
                $remarks = 'FAILED';
              }else if($prelim == 0 || $midterm == 0 || $final == 0){
                $remarks = 'UNDEFINED';
              }

              mysqli_query($con, "UPDATE grades_report SET average = '$rounded_ave', remarks = '$remarks' 
                WHERE academic_id = '$academic_id'
                AND student_id = '$student_id'
                AND enrollment_id = '$enrollment_id'
                AND subject_id = '$subject_id'");
            }

          
          header("location:../teacher_encode_grades.php?period=$period&program_id=$program_id&year_level=$year_level&section=$section&subject_id=$subject_id&academic_id=$academic_id");
      
      }

      //-------------------------------------------------------------------------------------------------
      //-------------------------------------------------------------------------------------------------
      //USER LOG

      //manage_program
      $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
      while($row_program = mysqli_fetch_array($query_program)){
        $program_code        = $row_program['program_code'];
      }

      //manage_subject
      $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
      while($row_subject = mysqli_fetch_array($query_subject)){
        $subject_code        = $row_subject['subject_code'];
        $subject_description = $row_subject['subject_description'];
      }

      $subject_name = $subject_code.': '.$subject_description;
      $section_name = $program_code.'-'.$year_level.$section;

      //data for user log table
      $faculty_user_id  = $_POST['account_user_id'];
      $user_action      = 'Encoded grades on <b>'.$section_name.'</b> for the subject <b>'.$subject_name.'</b> on <b>Final</b> period';
      $user_log_date    = date('Y-m-d');
      $user_log_time    = date('H:i:s');
      $zero             = 0; 

      mysqli_query($con, "INSERT INTO `user_log`(`user_log_id`, `account_user_id`, `user_action`, `user_log_time`, `user_log_date`) 
      VALUES ('$zero','$faculty_user_id','$user_action','$user_log_time','$user_log_date')");

    }

  }

 
?>