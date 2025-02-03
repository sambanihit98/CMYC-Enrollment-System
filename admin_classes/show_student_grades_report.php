<?php

  include "config_mysqli.php";

//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->

  if($_POST['period'] == 'Prelim'){

    $year_level  = $_POST['year_level'];
    $semester    = $_POST['term'];
    $period      = $_POST['period'];
    $program_id  = $_POST['program'];
    $student_id  = $_POST['student_id'];

    if($year_level == 1){
      $year = "1st Year";
    }else if($year_level == 2){
        $year = "2nd Year";
    }else if($year_level == 3){
        $year = "3rd Year";
    }else if($year_level == 4){
        $year = "4th Year";
    } 

      $response = "<h3 style = 'text-align:center;'>$year | $semester | $period  </h3>";

      $response .= "

        <table class = 'table table-striped'>
          <thead class='bg-success text-center'>
            <th>Subject Code</th>
            <th>Subject Description</th>
            <th>Credit</th>
            <th>Teacher</th>
            <th>Grade</th>
            <th>Remarks</th>
          </thead>
          <tbody>";

          $query1 = mysqli_query($con, "SELECT * FROM grades_report 
            JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id
            JOIN manage_enrollment ON grades_report.enrollment_id = manage_enrollment.enrollment_id
            WHERE manage_enrollment.student_year_level = '$year_level'
            AND manage_enrollment.student_semester = '$semester'
            AND manage_enrollment.student_id = '$student_id'
            AND grades_report.program_id = '$program_id'");
                      
              if(mysqli_num_rows($query1)>0){

                while($row1 = mysqli_fetch_array($query1)){
                  //manage_subject table
                  $subject_id           = $row1['subject_id'];
                  $subject_code         = $row1['subject_code'];
                  $subject_description  = $row1['subject_description'];
                  $subject_unit         = $row1['subject_unit'];
        
                  //grades_report table
                  $grades_report_id = $row1['grades_report_id'];
                  $prelim           = $row1['prelim'];
                  $grades_section   = $row1['grades_section'];
                  $remarks          = $row1['remarks'];
        
                  $response .= "<tr class='text-center'>";
                   
                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------
                  //Subject Code / Subject Description / Credit Units columns

                  $response .= "<td>$subject_code</td>
                                <td>$subject_description</td>
                                <td>$subject_unit</td>";

                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------
                  //Teacher column

                  $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE student_id = '$student_id' 
                    AND student_year_level = '$year_level' AND student_semester = '$semester' AND program_id = '$program_id'");
                    $row_enrollment = mysqli_fetch_array($query_enrollment);

                      //manage_enrollment table
                      $academic_id     = $row_enrollment['academic_id'];
                      //$student_section = $row_enrollment['student_section'];

                      $query_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                        JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
                        WHERE teacher_subject_load.subject_id = '$subject_id'
                        AND teacher_subject_load.subject_section = '$grades_section'
                        AND teacher_subject_load.academic_id = '$academic_id'
                        ");

                        if(mysqli_num_rows($query_teacher_schedule)>0){
                          $row_teacher = mysqli_fetch_array($query_teacher_schedule);

                            //teacher name // faculty_account table
                            $account_firstname  = ucwords($row_teacher['account_firstname']);
                            $account_lastname   = ucwords($row_teacher['account_lastname']);

                            $response .= "<td>$account_firstname $account_lastname</td>";

                        }else if($remarks == "Credited"){
                          $response .= "<td >--</td>";

                        }else{
                          $response .= "<td><span class='badge badge-secondary'>No teacher yet</span></td>";
                        }

                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------

                  $rounded_ave = round($prelim,0,PHP_ROUND_HALF_EVEN);

                  //Grades and Remarks columns
                  if($remarks == "Credited"){
                    $response .= "<td >--</td>";
                    $response .= "<td ><span class='badge badge-success'>Credited</span></td>";

                  }else if($prelim == 0){
                    $response .= "<td>--</td>";
                    $response .= "<td><span class='badge badge-secondary'>No grades yet</span></td>";

                  }else if($rounded_ave >= 75){
                    $response .= "<td>$prelim</td>";
                    $response .= "<td><span class='badge badge-primary'>Passed</span></td>";

                  }else if($rounded_ave < 75){
                    $response .= "<td>$prelim</td>";
                    $response .= "<td><span class='badge badge-danger'>Failed</span></td>";
                  } 

                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------            
                            
                  $response .= "</tr>";
                  
                }

                $response .= "</tbody> </table>"; 

                echo $response;
                exit;

              }else{
                echo "
                <h3 style = 'text-align:center;'>$year | $semester | $period  </h3>
                <h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>";   
              }
                                 
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->

  }else if($_POST['period'] == 'Midterm'){

    $year_level  = $_POST['year_level'];
    $semester    = $_POST['term'];
    $period      = $_POST['period'];
    $program_id  = $_POST['program'];
    $student_id  = $_POST['student_id'];

    if($year_level == 1){
      $year = "1st Year";
    }else if($year_level == 2){
        $year = "2nd Year";
    }else if($year_level == 3){
        $year = "3rd Year";
    }else if($year_level == 4){
        $year = "4th Year";
    }

      $response = "<h3 style = 'text-align:center;'>$year | $semester | $period  </h3>";

      $response .= "

        <table class = 'table table-striped'>
          <thead class='bg-success text-center'>
            <th>Subject Code</th>
            <th>Subject Description</th>
            <th>Credit</th>
            <th>Teacher</th>
            <th>Grade</th>
            <th>Remarks</th>
          </thead>
          <tbody>";

          $query1 = mysqli_query($con, "SELECT * FROM grades_report 
            JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id
            JOIN manage_enrollment ON grades_report.enrollment_id = manage_enrollment.enrollment_id
            WHERE manage_enrollment.student_year_level = '$year_level'
            AND manage_enrollment.student_semester = '$semester'
            AND manage_enrollment.student_id = '$student_id'
            AND grades_report.program_id = '$program_id'");
                      
              if(mysqli_num_rows($query1)>0){

                while($row1 = mysqli_fetch_array($query1)){
                  //manage_subject table
                  $subject_id           = $row1['subject_id'];
                  $subject_code         = $row1['subject_code'];
                  $subject_description  = $row1['subject_description'];
                  $subject_unit         = $row1['subject_unit'];
        
                  //grades_report table
                  $grades_report_id = $row1['grades_report_id'];
                  $midterm          = $row1['midterm'];
                  $grades_section   = $row1['grades_section'];
                  $remarks          = $row1['remarks'];
        
                  $response .= "<tr class='text-center'>";
                   
                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------
                  //Subject Code / Subject Description / Credit Units columns

                  $response .= "<td>$subject_code</td>
                                <td >$subject_description</td>
                                <td >$subject_unit</td>";

                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------
                  //Teacher column

                  $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE student_id = '$student_id' 
                    AND student_year_level = '$year_level' AND student_semester = '$semester' AND program_id = '$program_id'");
                    $row_enrollment = mysqli_fetch_array($query_enrollment);

                      //manage_enrollment table
                      $academic_id     = $row_enrollment['academic_id'];
                      //$student_section = $row_enrollment['student_section'];

                      $query_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                        JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
                        WHERE teacher_subject_load.subject_id = '$subject_id'
                        AND teacher_subject_load.subject_section = '$grades_section'
                        AND teacher_subject_load.academic_id = '$academic_id'");

                        if(mysqli_num_rows($query_teacher_schedule)>0){
                          $row_teacher = mysqli_fetch_array($query_teacher_schedule);

                            //teacher name // faculty_account table
                            $account_firstname  = ucwords($row_teacher['account_firstname']);
                            $account_lastname   = ucwords($row_teacher['account_lastname']);

                            $response .= "<td>$account_firstname $account_lastname</td>";

                        }else if($remarks == "Credited"){
                          $response .= "<td >--</td>";

                        }else{
                          $response .= "<td><span class='badge badge-secondary'>No teacher yet</span></td>";
                        }

                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------
                  //Grades and Remarks columns

                  $rounded_ave = round($midterm,0,PHP_ROUND_HALF_EVEN);

                  if($remarks == "Credited"){
                    $response .= "<td >--</td>";
                    $response .= "<td ><span class='badge badge-success'>Credited</span></td>";

                  }else if($midterm == 0){
                    $response .= "<td >--</td>";
                    $response .= "<td ><span class='badge badge-secondary'>No grades yet</span></td>";

                  }else if($rounded_ave >= 75){
                    $response .= "<td >$midterm</td>";
                    $response .= "<td ><span class='badge badge-primary'>Passed</span></td>";

                  }else if($rounded_ave < 75){
                    $response .= "<td >$midterm</td>";
                    $response .= "<td ><span class='badge badge-danger'>Failed</span></td>";
                  } 

                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------            
                            
                  $response .= "</tr>";
                }

                $response .= "</tbody> </table>"; 

                echo $response;
                exit;

              }else{
                echo "
                <h3 style = 'text-align:center;'>$year | $semester | $period  </h3>
                <h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>";       
              }
                   
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->

  
                   
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->

  }else if($_POST['period'] == 'Final'){

    $year_level  = $_POST['year_level'];
    $semester    = $_POST['term'];
    $period      = $_POST['period'];
    $program_id  = $_POST['program'];
    $student_id  = $_POST['student_id'];

    if($year_level == 1){
      $year = "1st Year";
    }else if($year_level == 2){
        $year = "2nd Year";
    }else if($year_level == 3){
        $year = "3rd Year";
    }else if($year_level == 4){
        $year = "4th Year";
    }

      $response = "<h3 style = 'text-align:center;'>$year | $semester | $period  </h3>";

      $response .= "

        <table class = 'table table-striped'>
          <thead class='bg-success text-center'>
            <th>Subject Code</th>
            <th>Subject Description</th>
            <th>Credit</th>
            <th>Teacher</th>
            <th>Grade</th>
            <th>Remarks</th>
          </thead>
          <tbody>";

          $query1 = mysqli_query($con, "SELECT * FROM grades_report 
            JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id
            JOIN manage_enrollment ON grades_report.enrollment_id = manage_enrollment.enrollment_id
            WHERE manage_enrollment.student_year_level = '$year_level'
            AND manage_enrollment.student_semester = '$semester'
            AND manage_enrollment.student_id = '$student_id'
            AND grades_report.program_id = '$program_id'");
                      
              if(mysqli_num_rows($query1)>0){

                while($row1 = mysqli_fetch_array($query1)){
                  //manage_subject table
                  $subject_id           = $row1['subject_id'];
                  $subject_code         = $row1['subject_code'];
                  $subject_description  = $row1['subject_description'];
                  $subject_unit         = $row1['subject_unit'];
        
                  //grades_report table
                  $grades_report_id = $row1['grades_report_id'];
                  $final            = $row1['final'];
                  $grades_section   = $row1['grades_section'];
                  $remarks          = $row1['remarks'];
        
                  $response .= "<tr class='text-center'>";
                   
                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------
                  //Subject Code / Subject Description / Credit Units columns

                  $response .= "<td>$subject_code</td>
                                <td >$subject_description</td>
                                <td >$subject_unit</td>";

                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------
                  //Teacher column

                  $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE student_id = '$student_id' 
                    AND student_year_level = '$year_level' AND student_semester = '$semester' AND program_id = '$program_id'");
                    $row_enrollment = mysqli_fetch_array($query_enrollment);

                      //manage_enrollment table
                      $academic_id     = $row_enrollment['academic_id'];
                      //$student_section = $row_enrollment['student_section'];

                      $query_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                        JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
                        WHERE teacher_subject_load.subject_id = '$subject_id'
                        AND teacher_subject_load.subject_section = '$grades_section'
                        AND teacher_subject_load.academic_id = '$academic_id'");

                        if(mysqli_num_rows($query_teacher_schedule)>0){
                          $row_teacher = mysqli_fetch_array($query_teacher_schedule);

                            //teacher name // faculty_account table
                            $account_firstname  = ucwords($row_teacher['account_firstname']);
                            $account_lastname   = ucwords($row_teacher['account_lastname']);

                            $response .= "<td>$account_firstname $account_lastname</td>";

                        }else if($remarks == "Credited"){
                          $response .= "<td >--</td>";

                        }else{
                          $response .= "<td><span class='badge badge-secondary'>No teacher yet</span></td>";
                        }

                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------
                  //Grades and Remarks columns

                  $rounded_ave = round($final,0,PHP_ROUND_HALF_EVEN);

                  if($remarks == "Credited"){
                    $response .= "<td >--</td>";
                    $response .= "<td ><span class='badge badge-success'>Credited</span></td>";

                  }else if($final == 0){
                    $response .= "<td >--</td>";
                    $response .= "<td ><span class='badge badge-secondary'>No grades yet</span></td>";

                  }else if($rounded_ave >= 75){
                    $response .= "<td >$final</td>";
                    $response .= "<td ><span class='badge badge-primary'>Passed</span></td>";

                  }else if($rounded_ave < 75){
                    $response .= "<td >$final</td>";
                    $response .= "<td ><span class='badge badge-danger'>Failed</span></td>";
                  } 

                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------            
                            
                  $response .= "</tr>";
                }

                $response .= "</tbody> </table>"; 

                echo $response;
                exit;

              }else{
               
                echo "
                <h3 style = 'text-align:center;'>$year | $semester | $period  </h3>
                <h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>";
              }
                   
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->
//<!------------------------------------------------------------------------------------------------->

  }else if($_POST['period'] == 'Average'){

    $year_level  = $_POST['year_level'];
    $semester    = $_POST['term'];
    $period      = $_POST['period'];
    $program_id  = $_POST['program'];
    $student_id  = $_POST['student_id'];

    if($year_level == 1){
      $year = "1st Year";
    }else if($year_level == 2){
        $year = "2nd Year";
    }else if($year_level == 3){
        $year = "3rd Year";
    }else if($year_level == 4){
        $year = "4th Year";
    }

      $response = "<h3 style = 'text-align:center;'>$year | $semester | $period  </h3>";

      $response .= "

        <table class = 'table table-striped'>
          <thead class='bg-success text-center'>
            <th>Subject Code</th>
            <th>Subject Description</th>
            <th>Credit</th>
            <th>Teacher</th>
            <th>Grade</th>
            <th>Remarks</th>
          </thead>
          <tbody>";

          $query1 = mysqli_query($con, "SELECT * FROM grades_report 
            JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id
            JOIN manage_enrollment ON grades_report.enrollment_id = manage_enrollment.enrollment_id
            WHERE manage_enrollment.student_year_level = '$year_level'
            AND manage_enrollment.student_semester = '$semester'
            AND manage_enrollment.student_id = '$student_id'
            AND grades_report.program_id = '$program_id'");
                      
              if(mysqli_num_rows($query1)>0){

                while($row1 = mysqli_fetch_array($query1)){
                  //manage_subject table
                  $subject_id           = $row1['subject_id'];
                  $subject_code         = $row1['subject_code'];
                  $subject_description  = $row1['subject_description'];
                  $subject_unit         = $row1['subject_unit'];
        
                  //grades_report table
                  $grades_report_id = $row1['grades_report_id'];
                  $average          = $row1['average'];
                  $grades_section   = $row1['grades_section'];
                  $remarks          = $row1['remarks'];
        
                  $response .= "<tr class='text-center'>";
                   
                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------
                  //Subject Code / Subject Description / Credit Units columns

                  $response .= "<td>$subject_code</td>
                                <td >$subject_description</td>
                                <td >$subject_unit</td>";

                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------
                  //Teacher column

                  $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE student_id = '$student_id' 
                    AND student_year_level = '$year_level' AND student_semester = '$semester' AND program_id = '$program_id'");
                    $row_enrollment = mysqli_fetch_array($query_enrollment);

                      //manage_enrollment table
                      $academic_id     = $row_enrollment['academic_id'];
                      //$student_section = $row_enrollment['student_section'];

                      $query_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                        JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
                        WHERE teacher_subject_load.subject_id = '$subject_id'
                        AND teacher_subject_load.subject_section = '$grades_section'
                        AND teacher_subject_load.academic_id = '$academic_id'");

                        if(mysqli_num_rows($query_teacher_schedule)>0){
                          $row_teacher = mysqli_fetch_array($query_teacher_schedule);

                            //teacher name // faculty_account table
                            $account_firstname  = ucwords($row_teacher['account_firstname']);
                            $account_lastname   = ucwords($row_teacher['account_lastname']);

                            $response .= "<td>$account_firstname $account_lastname</td>";

                        }else if($remarks == "Credited"){
                          $response .= "<td >--</td>";

                        }else{
                          $response .= "<td><span class='badge badge-secondary'>No teacher yet</span></td>";
                        }

                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------
                  //Grades and Remarks columns

                  if($remarks == "Credited"){
                    $response .= "<td >--</td>";
                    $response .= "<td ><span class='badge badge-success'>Credited</span></td>";

                  }elseif($average == 0){
                    $response .= "<td >--</td>";
                    $response .= "<td ><span class='badge badge-secondary'>No grades yet</span></td>";

                  }else if($average >= 75){
                    $response .= "<td >$average</td>";
                    $response .= "<td ><span class='badge badge-primary'>Passed</span></td>";

                  }else if($average < 75){
                    $response .= "<td >$average</td>";
                    $response .= "<td ><span class='badge badge-danger'>Failed</span></td>";
                  } 

                  //-----------------------------------------------------------------------------------------
                  //-----------------------------------------------------------------------------------------            
                            
                  $response .= "</tr>";
                }

                $response .= "</tbody> </table>"; 

                echo $response;
                exit;

              }else{
               
                echo "
                <h3 style = 'text-align:center;'>$year | $semester | $period  </h3>
                <h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>";
              }

  }
  
?>