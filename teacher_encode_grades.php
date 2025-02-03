<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_teacher.php";
?>

<!DOCTYPE html>
  <html>

  <head>
    <?php include 'bootstrap_lower/boots.php'; ?>
    <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Grades Encoding </title>
    <?php include "include/tab_icon.php"; ?>
  </head>

  <body>

    <div id="wrapper">

    <!------SIDE NAV--------------------------------------------------------------------------------------------------------------->
    <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            
          <li class="nav-header">
            <?php include 'bootstrap_lower/side_name_logo.php'; ?>    
          </li>

          <li>
              <a href="teacher_dashboard.php"><i class="fa fa-lg fa-home" aria-hidden="true"></i> <span class="nav-label">Home</span></a>
          </li>

          <li class="active">
              <a href="teacher_encode.php"><i class="fa fa-lg fa-book" aria-hidden="true"></i> <span class="nav-label">Grades Encoding</span></a>
          </li>

          <li>
              <a href="teacher_subject_schedule.php"><i class="fa fa-lg fa-calendar" aria-hidden="true"></i> <span class="nav-label"> Subject Schedule  </span></a>
          </li>

          <li>
              <a href="teacher_account_settings.php"><i class="fa fa-lg fa-cog" aria-hidden="true"></i> <span class="nav-label">Account Settings</span></a>
          </li> 

        </ul>
      </div>
    </nav>
    
    <!----HEADER----->
    <div id="page-wrapper" class="gray-bg">
      <?php include 'bootstrap_lower/header.php';?>
      
      <!----UNDER HEADER------->
      <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
        <div class="col-lg-10">
          <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Grades Encoding </p>
        </div>
      </div>

      <!---------------------------------------------------------------------------------------------------------------------------->
      <!---------------------------------------------------------------------------------------------------------------------------->
      <!-- Error modal / Empty fields-->

      <div class="modal fade" id="empty_error_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Empty Field Error</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <h2 style = "text-align:center; font-weight:bold; color:red;">ERROR!</h2>

              <h3 style = "text-align:center;">Please fill up the information needed!</h3>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <!----DATA TABLES ONE-------------------------------------------------------------------------------------------------------------->
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox-content">

              <div class = "container"> <!-- start of container -->

                <div class = "row">
                  <div class = "col-md-12">
                    <div class = "row">

                      <div class = "col-md-3">
                        <h4 style="font-weight: 350; margin-right: 15px;">Teacher </h4>  
                      </div> 

                      <div class = "col-md-3">
                        <h3 style="font-size: 15px;"> 
                        <?php echo "$account_firstname $account_lastname";  ?>
                        </h3>
                      </div>

                      <div class = "col-md-3"></div>

                      <div class = "col-md-3"></div>

                    </div>
                  </div>
                </div>
                    
                <div class = "row">
                  <div class = "col-md-12">
                    <div class = "row">

                      <div class = "col-md-3">
                        <h4 style="font-weight: 350; margin-right: 15px;" class="text-dark">Academic Year </h4> 
                      </div>

                      <div class = "col-md-3">
                        <h3 style="font-size: 15px;"> 
                          <?php 
                            include 'admin_classes/config_mysqli.php';
                              $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                              while($row = mysqli_fetch_array($query)){
                                $academic_year_from  = $row['academic_year_from'];
                                $academic_year_to    = $row['academic_year_to'];

                                print "$academic_year_from - $academic_year_to";
                              }
                          ?> 
                        </h3>
                      </div>

                      <div class = "col-md-3"></div>
                      <div class = "col-md-3"></div>
 
                    </div>
                  </div>
                </div>

                <div class = "row">
                  <div class = "col-md-12">
                    <div class = "row">

                      <div class = "col-md-3">
                        <h4 style="font-weight: 350; margin-right: 15px;"> Term: </h4>  
                      </div>
                      
                      <div class = "col-md-3">
                        <h3 style="font-size: 15px;"> 
                          <?php 
                            include 'admin_classes/config_mysqli.php';
                              $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                              while($row = mysqli_fetch_array($query)){
                               
                                $academic_term       = $row['academic_term'];

                                print "$academic_term";
                              }
                          ?> 
                        </h3>
                      </div>

                      <div class = "col-md-3"></div>
                      <div class = "col-md-3"></div>

                    </div>
                  </div>
                </div>

                <div class = "row">
                  <div class = "col-md-12">
                    <div class = "row">

                      <div class = "col-md-3">
                      <h4 style="font-weight: 350; margin-right: 15px;">Period: </h4>  
                      </div>
                      
                      <div class = "col-md-3">
                        <select class="form-control border-secondary rounded input-sm" id = "period" >
                          <option value = "<?php echo $_GET['period']?>" hidden><?php echo $_GET['period']?></option>   
                          <option value = "Prelim" >Prelim</option> 
                          <option value = "Midterm" >Midterm</option> 
                          <!--<option value = "Semi Final" >Semi Final</option>--> 
                          <option value = "Final" >Final</option> 
                          <option value = "Average" >Average</option> 
                        </select>
                      </div>

                      <div class = "col-md-3"></div>
                      <div class = "col-md-3"></div>

                    </div>
                  </div>
                </div> 
                    
                <div class = "row mt-2">
                  <div class = "col-md-12">
                    <div class = "row">

                      <div class = "col-md-3">
                        <h4 style="font-weight: 350; margin-right: 15px;">Course, Year & Section: </h4>  
                      </div> 
                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!-- COURSE / PROGRAM -->

                      <div class = "col-md-3">
                        <select class="form-control border-secondary rounded input-sm" id = "program_id" >
                          <option value = "<?php echo $_GET['program_id'];?>" hidden>
                            <?php 
                              include 'admin_classes/config_mysqli.php';
                              $program_id = $_GET['program_id'];
                                $query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                while($row = mysqli_fetch_array($query)){
                                  $program_code = $row['program_code'];
                                  echo $program_code;
                                }
                            ?>
                          </option>   

                          <?php
                            include 'admin_classes/config_mysqli.php';
                            //gets single course only// disregarding duplicates
                            $query = mysqli_query($con, "SELECT DISTINCT program_id FROM teacher_subject_load
                                                        WHERE account_user_id = '$account_user_id'");
                                                        
                            while($row = mysqli_fetch_array($query)){
                              $program_id = $row['program_id'];
                            
                                //getting the program code
                                $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                while($row_program = mysqli_fetch_array($query_program)){

                                  $program_code = $row_program['program_code'];

                                  print "<option value = '$program_id' >$program_code</option>  ";
                                }                           
                            }
                          ?>
                        </select> 
                      </div>

                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!-- YEAR LEVEL -->

                      <div class = "col-md-3">
                        <select class="form-control border-secondary rounded input-sm" id = "year_level" >
                          <option value = "<?php echo $_GET['year_level']; ?>" hidden>
                            <?php 
                              if($_GET['year_level'] == 1){
                                echo "1st Year";
                              }else if($_GET['year_level'] == 2){
                                echo "2nd Year";
                              }else if($_GET['year_level'] == 3){
                                echo "3rd Year";
                              }else if($_GET['year_level'] == 4){
                                echo "4th Year";
                              }
                            ?>
                          </option>   

                          <?php
                            include 'admin_classes/config_mysqli.php';

                            //gets single year level only// disregarding duplicates
                            $query = mysqli_query($con, "SELECT DISTINCT subject_year_level_teacher FROM teacher_subject_load
                                                        WHERE account_user_id = '$account_user_id' ORDER BY subject_year_level_teacher ASC");
                                                        
                            while($row = mysqli_fetch_array($query)){
                              $subject_year_level_teacher  = $row['subject_year_level_teacher'];
  
                              if($subject_year_level_teacher == 1){
                                $year_level = "1st Year";
                              }else if($subject_year_level_teacher == 2){
                                $year_level = "2nd Year";
                              }else if($subject_year_level_teacher == 3){
                                $year_level = "3rd Year";
                              }else if($subject_year_level_teacher == 4){
                                $year_level = "4th Year";
                              }
                                  print "<option value = '$subject_year_level_teacher' >$year_level</option>  ";
                            }
                          ?>
                          </select>
                      </div>

                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!-- SECTION -->

                      <div class = "col-md-3">
                        <select class="form-control border-secondary rounded input-sm" id = "section" >
                          <option value = "<?php echo $_GET['section'];?>" hidden><?php echo $_GET['section'];?></option>  
                          
                          <?php
                            include 'admin_classes/config_mysqli.php';

                            //gets single section only// disregarding duplicates
                            $query = mysqli_query($con, "SELECT DISTINCT subject_section FROM teacher_subject_load
                                                        WHERE account_user_id = '$account_user_id' ORDER BY subject_section ASC");
                                                        
                            while($row = mysqli_fetch_array($query)){
                              $subject_section = $row['subject_section'];                         
                                  print "<option value = '$subject_section' >$subject_section</option>  ";
                            }
                          ?>
                          </select>
                      </div>

                    </div>
                  </div>
                </div>

                <!---------------------------------------------------------------------------------------------------------------------------->
                <!---------------------------------------------------------------------------------------------------------------------------->
                <!-- SUBJECT -->

                <div class = "row mt-2">
                  <div class = "col-md-12">
                    <div class = "row">

                      <div class = "col-md-3">
                        <h4 style="font-weight: 350; margin-right: 15px;">Subject Handled </h4>  
                      </div> 

                      <div class = "col-md-6">
                      <select class="form-control border-secondary rounded input-sm" id = "subject_id" >
                          <option value = "<?php echo $_GET['subject_id']; ?>" hidden>
                            <?php
                              include 'admin_classes/config_mysqli.php';
                              $subject_id = $_GET['subject_id'];
                                $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
                                  while($row = mysqli_fetch_array($query)){
                                    $subject_code        = $row['subject_code'];
                                    $subject_description = $row['subject_description'];

                                    print "$subject_code: $subject_description";
                                  }

                            ?>
                          </option>  
                          
                          <?php
                            include 'admin_classes/config_mysqli.php';

                            //gets single section only// disregarding duplicates
                            $query = mysqli_query($con, "SELECT DISTINCT subject_id FROM teacher_subject_load
                                                        WHERE account_user_id = '$account_user_id' ORDER BY subject_section ASC");
                                                        
                            while($row = mysqli_fetch_array($query)){
                              $subject_id = $row['subject_id']; 
                              
                                $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
                                while($row_subject = mysqli_fetch_array($query_subject)){
                                  $subject_code        = $row_subject['subject_code'];
                                  $subject_description = $row_subject['subject_description'];
                                  print "<option value = '$subject_id' >$subject_code: $subject_description</option>";
                                }  
                            }
                          ?>
                          </select>
                      </div>

                      <div class = "col-md-3" >
                        <button type="button" class="btn btn-success btn-sm ml-2" style = 'float:right;' id = 'show_btn'> <i class="fa fa-eye" aria-hidden="true"></i> Show</button>   
                      </div> 

                    </div>
                  </div>
                </div>

              </div> <!-- end of container -->

              <hr>

              <div id = 'table_data'>

                <table style='width: 100%;'>
                  <tr>
                    <td class='text-center'> <strong> LIST OF ENROLLED STUDENT IN THIS SUBJECT </strong> </td>
                  </tr>
                </table>

                <br>

                <!------------------------------------------------------------------------------------------------------------------------------>
                <!------------------------------------------------------------------------------------------------------------------------------>        
                <!------------------------------------------------------------------------------------------------------------------------------>
                <!------------------------------------------------------------------------------------------------------------------------------>           

                <form action = "admin_classes/insert_student_grade.php" method = "POST">

                  <!------------------------------------------------------------------------------------------------------------------------>
                  <!------------------------------------------------------------------------------------------------------------------------>
                  <!---faculty_user_id--->
                  <?php include "include/faculty_user_id.php"; ?>
               
                    <?php

                    //---------------------------------------------------------------------------------------------------------------------------->
                    //---------------------------------------------------------------------------------------------------------------------------->
                    
                    if($_GET['period'] == 'Prelim'){

                      print " 
                            <table class = 'table table-striped'>
                              <thead class='bg-success text-center'>
                                <th > STUDENT ID </th>
                                <th > STUDENT NAME </th>
                                <th > COURSE & SECTION </th>
                                <th > GRADE</th>
                                <th > REMARKS </th>
                                <th > <input class='form-check-input select_all' id = 'select_all' name = 'select_all' type='checkbox' disabled></th>
                              </thead>
                              <tbody class='text-center'>";

                      $period       = $_GET['period'];  
                      $academic_id  = $_GET['academic_id'];
                      $program_id   = $_GET['program_id']; 
                      $year_level   = $_GET['year_level']; 
                      $section      = $_GET['section']; 
                      $subject_id   = $_GET['subject_id']; 
                      $query = mysqli_query($con, "SELECT * FROM grades_report JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id
                                                    JOIN manage_enrollment ON grades_report.enrollment_id = manage_enrollment.enrollment_id
                                                    JOIN student_info ON grades_report.student_id = student_info.student_id
                                                    JOIN manage_program ON grades_report.program_id = manage_program.program_id
                                                    WHERE grades_report.academic_id = '$academic_id' 
                                                    AND grades_report.grades_section = '$section'
                                                    AND grades_report.grades_course = '$program_id'
                                                    AND grades_report.grades_year = '$year_level'
                                                    AND grades_report.subject_id = '$subject_id' ORDER BY student_info.lastname ASC");


                        while($row = mysqli_fetch_array($query)){

                          //student_info table
                          $student_id     = $row['student_id'];
                          $firstname      = ucwords($row['firstname']);
                          $middlename     = ucwords($row['middlename']);
                          $lastname       = ucwords($row['lastname']);

                          $middle_initial = substr("$middlename", 0, 1);  // returns "abcde"

                          //manage_enrollment table
                          $enrollment_id = $row['enrollment_id'];

                          //manage_program table
                          $program_code = $row['program_code'];

                          //grades_report table
                          $grades_section  = $row['grades_section'];
                          $grades_year     = $row['grades_year'];
                          $prelim          = $row['prelim'];

                          print "
                            <tr class='text-center'>
                              <td>$student_id</td>
                              <td>$lastname, $firstname $middle_initial.</td>
                              <td>$program_code - $grades_year$grades_section</td>
                              <td><input type='text' 
                                        class='form-control border border-secondary rounded input-sm grades' 
                                        style='width: 80px; margin:auto;'
                                        value = '$prelim' disabled
                                        id = 'grade' name = 'prelim_$student_id'>  
                                  <input type='text' value = '$period' id = 'period' name = 'period_$student_id' hidden> 
                                  <input type='text' value = '$student_id' id = 'student_id' name = 'student_id_$student_id' hidden>
                                  <input type='text' value = '$academic_id' id = 'academic_id' name = 'academic_id_$student_id' hidden>
                                  <input type='text' value = '$enrollment_id' id = 'enrollment_id' name = 'enrollment_id_$student_id' hidden>
                                  <input type='text' value = '$subject_id' id = 'subject_id' name = 'subject_id_$student_id' hidden> 
                                  
                                  <input type='text' value = '$program_id' id = 'program_id' name = 'program_id_$student_id' hidden>
                                  <input type='text' value = '$year_level' id = 'year_level' name = 'year_level_$student_id' hidden>
                                  <input type='text' value = '$section' id = 'section' name = 'section_$student_id' hidden>
                              </td>";


                              $rounded_ave = round($prelim,0,PHP_ROUND_HALF_EVEN);

                              if($prelim == 0){

                                print "<td>
                                        <span class='badge badge-secondary'>No grades yet</span>
                                      </td>";

                              }else if($rounded_ave >= 75){

                                print "<td>
                                        <span class='badge badge-primary'>Passed</span>
                                      </td>";
                              }else if($rounded_ave < 75){

                                print "<td>
                                        <span class='badge badge-danger'>Failed</span>
                                      </td>";
                              }

                              print "<td>                   
                                        <input class='form-check-input checkbox_value' name = 'prelim_student_id[]' type='checkbox' value='$student_id' disabled>
                                    </td>";

                                print "</tr>";  
                            
                      }

                      print "</tbody></table>"; 

                      print "
                        <div class='modal-footer'>
                        <button type='button' class='btn btn-primary btn-sm' id='edit_btn'>Edit</button>
                        <button type='submit' class='btn btn-success btn-sm' name = 'save_btn' id='save_btn' hidden>Save</button>
                      </div>";

                    //<!--------------------------------------------------------------------------------------------------------------------->
                    //<!--------------------------------------------------------------------------------------------------------------------->
                    
                    }else if($_GET['period'] == 'Midterm'){

                      print " 
                      <table class = 'table table-striped'>
                        <thead class='bg-success text-center'>
                          <th > STUDENT ID </th>
                          <th > STUDENT NAME </th>
                          <th > COURSE & SECTION </th>
                          <th > GRADE</th>
                          <th > REMARKS </th>
                          <th > <input class='form-check-input select_all' id = 'select_all' name = 'select_all' type='checkbox' disabled></th>
                        </thead>
                        <tbody class='text-center'>";

                      $period       = $_GET['period'];  
                      $academic_id  = $_GET['academic_id'];
                      $program_id   = $_GET['program_id']; 
                      $year_level   = $_GET['year_level']; 
                      $section      = $_GET['section']; 
                      $subject_id   = $_GET['subject_id']; 
                      $query = mysqli_query($con, "SELECT * FROM grades_report JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id
                                                    JOIN manage_enrollment ON grades_report.enrollment_id = manage_enrollment.enrollment_id
                                                    JOIN student_info ON grades_report.student_id = student_info.student_id
                                                    JOIN manage_program ON grades_report.program_id = manage_program.program_id
                                                    WHERE grades_report.academic_id = '$academic_id' 
                                                    AND grades_report.grades_section = '$section'
                                                    AND grades_report.grades_course = '$program_id'
                                                    AND grades_report.grades_year = '$year_level'
                                                    AND grades_report.subject_id = '$subject_id' ORDER BY student_info.lastname ASC");

                        while($row = mysqli_fetch_array($query)){

                          //student_info table
                          $student_id     = $row['student_id'];
                          $firstname      = ucwords($row['firstname']);
                          $middlename     = ucwords($row['middlename']);
                          $lastname       = ucwords($row['lastname']);

                          $middle_initial = substr("$middlename", 0, 1);  // returns "abcde"

                          //manage_enrollment table
                          $enrollment_id = $row['enrollment_id'];

                          //manage_program table
                          $program_code = $row['program_code'];

                          //grades_report table
                          $grades_section  = $row['grades_section'];
                          $grades_year     = $row['grades_year'];
                          $midterm = $row['midterm'];

                          print "
                            <tr class='text-center'>
                              <td>$student_id</td>
                              <td>$lastname, $firstname $middle_initial.</td>
                              <td>$program_code - $grades_year$grades_section</td>
                              <td><input type='text' 
                                        class='form-control border border-secondary rounded input-sm grades' 
                                        style='width: 80px; margin:auto;'
                                        value = '$midterm' disabled
                                        id = 'grade' name = 'midterm_$student_id'>  
                                  <input type='text' value = '$period' id = 'period' name = 'period_$student_id' hidden> 
                                  <input type='text' value = '$student_id' id = 'student_id' name = 'student_id_$student_id' hidden>
                                  <input type='text' value = '$academic_id' id = 'academic_id' name = 'academic_id_$student_id' hidden>
                                  <input type='text' value = '$enrollment_id' id = 'enrollment_id' name = 'enrollment_id_$student_id' hidden>
                                  <input type='text' value = '$subject_id' id = 'subject_id' name = 'subject_id_$student_id' hidden>
                                  
                                  <input type='text' value = '$program_id' id = 'program_id' name = 'program_id_$student_id' hidden>
                                  <input type='text' value = '$year_level' id = 'year_level' name = 'year_level_$student_id' hidden>
                                  <input type='text' value = '$section' id = 'section' name = 'section_$student_id' hidden>
                              </td>";

                              $rounded_ave = round($midterm,0,PHP_ROUND_HALF_EVEN);

                              if($midterm == 0){

                                print "<td>
                                        <span class='badge badge-secondary'>No grades yet</span>
                                      </td>";

                              }else if($rounded_ave >= 75){

                                print "<td>
                                        <span class='badge badge-primary'>Passed</span>
                                      </td>";
                              }else if($rounded_ave < 75){

                                print "<td>
                                        <span class='badge badge-danger'>Failed</span>
                                      </td>";
                              }

                              print "<td> 
                                        <input class='form-check-input checkbox_value' name = 'midterm_student_id[]' type='checkbox' value='$student_id' disabled>
                                    </td>";

                                print "</tr>"; 
                                
                          
                      }

                      print "</tbody></table>"; 

                      print "
                        <div class='modal-footer'>
                        <button type='button' class='btn btn-primary btn-sm' id='edit_btn'>Edit</button>
                        <button type='submit' class='btn btn-success btn-sm' name = 'save_btn' id='save_btn' hidden>Save</button>
                      </div>";

                    //<!--------------------------------------------------------------------------------------------------------------------->
                    //<!--------------------------------------------------------------------------------------------------------------------->
                   
                    }else if($_GET['period'] == 'Final'){

                      print " 
                            <table class = 'table table-striped'>
                              <thead class='bg-success text-center'>
                                <th > STUDENT ID </th>
                                <th > STUDENT NAME </th>
                                <th > COURSE & SECTION </th>
                                <th > GRADE</th>
                                <th > REMARKS </th>
                                <th > <input class='form-check-input select_all' id = 'select_all' name = 'select_all' type='checkbox' disabled></th>
                              </thead>
                              <tbody class='text-center'>";

                      $period       = $_GET['period'];  
                      $academic_id  = $_GET['academic_id'];
                      $program_id   = $_GET['program_id']; 
                      $year_level   = $_GET['year_level']; 
                      $section      = $_GET['section']; 
                      $subject_id   = $_GET['subject_id']; 
                      $query = mysqli_query($con, "SELECT * FROM grades_report JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id
                                                    JOIN manage_enrollment ON grades_report.enrollment_id = manage_enrollment.enrollment_id
                                                    JOIN student_info ON grades_report.student_id = student_info.student_id
                                                    JOIN manage_program ON grades_report.program_id = manage_program.program_id
                                                    WHERE grades_report.academic_id = '$academic_id' 
                                                    AND grades_report.grades_section = '$section'
                                                    AND grades_report.grades_course = '$program_id'
                                                    AND grades_report.grades_year = '$year_level'
                                                    AND grades_report.subject_id = '$subject_id' ORDER BY student_info.lastname ASC");

                        while($row = mysqli_fetch_array($query)){

                          //student_info table
                          $student_id     = $row['student_id'];
                          $firstname      = ucwords($row['firstname']);
                          $middlename     = ucwords($row['middlename']);
                          $lastname       = ucwords($row['lastname']);

                          $middle_initial = substr("$middlename", 0, 1);  // returns "abcde"

                          //manage_enrollment table
                          $enrollment_id = $row['enrollment_id'];

                          //manage_program table
                          $program_code = $row['program_code'];

                          //grades_report table
                          $grades_section  = $row['grades_section'];
                          $grades_year     = $row['grades_year'];
                          $prelim        = $row['prelim'];
                          $midterm       = $row['midterm'];

                          $final        = $row['final'];

                          

                          print "
                            <tr class='text-center'>
                              <td>$student_id</td>
                              <td>$lastname, $firstname $middle_initial.</td>
                              <td>$program_code - $grades_year$grades_section</td>
                              <td><input type='text' 
                                        class='form-control border border-secondary rounded input-sm grades' 
                                        style='width: 80px; margin:auto;'
                                        value = '$final' disabled
                                        id = 'grade' name = 'final_$student_id'>  
                                  <input type='text' value = '$prelim' id = 'prelim' name = 'prelim_$student_id' hidden> 
                                  <input type='text' value = '$midterm ' id = 'midterm' name = 'midterm_$student_id' hidden>

                                  <input type='text' value = '$period' id = 'period' name = 'period_$student_id' hidden> 
                                  <input type='text' value = '$student_id' id = 'student_id' name = 'student_id_$student_id' hidden>
                                  <input type='text' value = '$academic_id' id = 'academic_id' name = 'academic_id_$student_id' hidden>
                                  <input type='text' value = '$enrollment_id' id = 'enrollment_id' name = 'enrollment_id_$student_id' hidden>
                                  <input type='text' value = '$subject_id' id = 'subject_id' name = 'subject_id_$student_id' hidden>
                                  
                                  <input type='text' value = '$program_id' id = 'program_id' name = 'program_id_$student_id' hidden>
                                  <input type='text' value = '$year_level' id = 'year_level' name = 'year_level_$student_id' hidden>
                                  <input type='text' value = '$section' id = 'section' name = 'section_$student_id' hidden>
                              </td>";

                              $rounded_ave = round($final,0,PHP_ROUND_HALF_EVEN);

                              if($final == 0){

                                print "<td>
                                        <span class='badge badge-secondary'>No grades yet</span>
                                      </td>";

                              }else if($rounded_ave >= 75){

                                print "<td>
                                        <span class='badge badge-primary'>Passed</span>
                                      </td>";
                              }else if($rounded_ave < 75){

                                print "<td>
                                        <span class='badge badge-danger'>Failed</span>
                                      </td>";
                              }

                              print "<td> 
                                        <input class='form-check-input checkbox_value' name = 'final_student_id[]' type='checkbox' value='$student_id' disabled>
                                    </td>";

                              print "</tr>";       
                         
                      }

                      print "</tbody></table>";

                      print "
                        <div class='modal-footer'>
                        <button type='button' class='btn btn-primary btn-sm' id='edit_btn'>Edit</button>
                        <button type='submit' class='btn btn-success btn-sm' name = 'save_btn' id='save_btn' hidden>Save</button>
                      </div>";

                    //<!---------------------------------------------------------------------------------------------------------------------------->
                    //<!---------------------------------------------------------------------------------------------------------------------------->

                    }else if($_GET['period'] == 'Average'){

                      print " 
                        <table class = 'table table-striped'>
                          <thead class='bg-success text-center'>
                            <th > STUDENT ID </th>
                            <th > STUDENT NAME </th>
                            <th > COURSE & SECTION </th>
                            <th > PRELIM </th>
                            <th > MIDTERM </th>
                            <th > FINAL </th>
                            <th > AVERAGE </th>
                            <th > REMARKS </th>
                          </thead>
                          <tbody class='text-center'>";

                      $period       = $_GET['period'];  
                      $academic_id  = $_GET['academic_id'];
                      $program_id   = $_GET['program_id']; 
                      $year_level   = $_GET['year_level']; 
                      $section      = $_GET['section']; 
                      $subject_id   = $_GET['subject_id']; 
                      $query = mysqli_query($con, "SELECT * FROM grades_report JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id
                                                    JOIN manage_enrollment ON grades_report.enrollment_id = manage_enrollment.enrollment_id
                                                    JOIN student_info ON grades_report.student_id = student_info.student_id
                                                    JOIN manage_program ON grades_report.program_id = manage_program.program_id
                                                    WHERE grades_report.academic_id = '$academic_id' 
                                                    AND grades_report.grades_section = '$section'
                                                    AND grades_report.grades_course = '$program_id'
                                                    AND grades_report.grades_year = '$year_level'
                                                    AND grades_report.subject_id = '$subject_id' ORDER BY student_info.lastname ASC ");

                        while($row = mysqli_fetch_array($query)){

                          //student_info table
                          $student_id     = $row['student_id'];
                          $firstname      = ucwords($row['firstname']);
                          $middlename     = ucwords($row['middlename']);
                          $lastname       = ucwords($row['lastname']);

                          $middle_initial = substr("$middlename", 0, 1);  // returns "abcde"

                          //manage_enrollment table
                          $enrollment_id = $row['enrollment_id'];

                          //manage_program table
                          $program_code = $row['program_code'];

                          //grades_report table
                          $grades_section  = $row['grades_section'];
                          $grades_year     = $row['grades_year'];
                          $prelim          = $row['prelim'];
                          $midterm         = $row['midterm'];
                          $final           = $row['final'];
                          $average         = $row['average'];
                          $remarks         = $row['remarks'];

                          print "
                            <tr class='text-center'>
                              <td>$student_id</td>
                              <td>$lastname, $firstname $middle_initial.</td>
                              <td>$program_code - $grades_year$grades_section</td>
                              <td>$prelim</td>
                              <td>$midterm</td>
                              <td>$final</td>
                              <td><b>$average</b></td>
                              ";

                          if($remarks == "UNDEFINED"){
                            print "<td>  <span class='badge badge-secondary'>$remarks</span> </td>";

                          }else if($remarks == "PASSED"){
                            print "<td>  <span class='badge badge-primary'>$remarks</span> </td>";

                          }else if($remarks == "FAILED"){
                            print "<td>  <span class='badge badge-danger'>$remarks</span> </td>";

                          }

                            print "</tr>";                                      
                      }

//<!---------------------------------------------------------------------------------------------------------------------------->                   //<!---------------------------------------------------------------------------------------------------------------------------->

                      print "</tbody></table>";

                    }
                    ?>         
                
                
                </form>
              </div>
       
            </div>

          </div>
        </div>
      </div>
      <br>
        <?php include 'bootstrap_lower/lower.php'; ?>
    </div>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-----ENABLE GRADES field and save button------------>

<script>

    $(document).ready(function(){
    $('#edit_btn').click(function(){
        $(".checkbox_value").prop("disabled", false);
        $("#select_all").prop("disabled", false);
        $(".grades").prop("disabled", false);
        $("#save_btn").prop("hidden", false);
    });
    });

</script>



<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-----HIDDEN DATA------------>

<?php
  include 'admin_classes/config_mysqli.php';
  $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
    while($row = mysqli_fetch_array($query)){
      $academic_id = $row['academic_id'];

      print "<input type = 'text' id = 'academic_id' value = '$academic_id' hidden>";
    }
?>


<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-----INSERTS GRADES------------>

<script>
  $(document).ready(function(){
    $('#save_btddn').click(function(){
      
      var grade = $('#grade').val();
      var period = $('#period').val();
      var student_id = $('#student_id').val();
      var academic_id = $('#academic_id').val();
      var enrollment_id = $('#enrollment_id').val();
      var subject_id = $('#subject_id').val();

      var period = $('#period').val();
      var program_id = $('#program_id').val();
      var year_level = $('#year_level').val();
      var section = $('#section').val();
      var subject_id = $('#subject_id').val();

      var prelim = $('#prelim').val();
      var midterm = $('#midterm').val();
      var semi_final = $('#semi_final').val();

      $.ajax({
        url: "admin_classes/insert_student_grade.php",
        type: "POST",
        data: {
          grade         :grade,
          period        :period,
          student_id    :student_id,
          academic_id   :academic_id,
          enrollment_id :enrollment_id,
          subject_id    :subject_id,
          prelim        :prelim,
          midterm       :midterm,
          semi_final    :semi_final
        },
        cache: false,
        success: function(data){
         
          window.location.replace("teacher_encode_grades.php?period="+period+"&program_id="+program_id+"&year_level="+year_level+"&section="+section+"&subject_id="+subject_id+"&academic_id="+academic_id);
         
        }
      });

    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-----SHOW------------>
<script>
      $(document).ready(function(){
        $('#show_btn').click(function(){
          var academic_id = $('#academic_id').val();

          var period = $('#period').val();
          var program_id = $('#program_id').val();
          var year_level = $('#year_level').val();
          var section = $('#section').val();
          var subject_id = $('#subject_id').val();

          if(period == "" || program_id == "" || year_level == "" || section == "" || subject_id == ""){
            $('#empty_error_modal').modal('show');
          }else{
            window.location.replace("teacher_encode_grades.php?period="+period+"&program_id="+program_id+"&year_level="+year_level+"&section="+section+"&subject_id="+subject_id+"&academic_id="+academic_id);
          }

        });
      });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-----CHECKBOX------------>

<!-----PRELIM------------>
<script>
  $(document).ready(function(){
    $('#select_all').change(function(){
      if($(this).is(':checked')){
        $('input[name="prelim_student_id[]"]').prop('checked',true);
      }else{
        $('input[name="prelim_student_id[]"]').each(function(){
          $(this).prop('checked',false);
        });
      }
    });
  });

  $('input[name="prelim_student_id[]"]').click(function(){
    var total_checkboxes = $('input[name="prelim_student_id[]"]').length;
    var total_checkboxes_checked = $('input[name="prelim_student_id[]"]:checked').length;

    if(total_checkboxes_checked == total_checkboxes){
      $('#select_all').prop('checked',true);
    }else{
      $('#select_all').prop('checked',false);
    }
  });
</script>

<!-----MIDTERM------------>
<script>
  $(document).ready(function(){
    $('#select_all').change(function(){
      if($(this).is(':checked')){
        $('input[name="midterm_student_id[]"]').prop('checked',true);
      }else{
        $('input[name="midterm_student_id[]"]').each(function(){
          $(this).prop('checked',false);
        });
      }
    });
  });

  $('input[name="midterm_student_id[]"]').click(function(){
    var total_checkboxes = $('input[name="midterm_student_id[]"]').length;
    var total_checkboxes_checked = $('input[name="midterm_student_id[]"]:checked').length;

    if(total_checkboxes_checked == total_checkboxes){
      $('#select_all').prop('checked',true);
    }else{
      $('#select_all').prop('checked',false);
    }
  });
</script>

<!-----FINAL------------>
<script>
  $(document).ready(function(){
    $('#select_all').change(function(){
      if($(this).is(':checked')){
        $('input[name="final_student_id[]"]').prop('checked',true);
      }else{
        $('input[name="final_student_id[]"]').each(function(){
          $(this).prop('checked',false);
        });
      }
    });
  });

  $('input[name="final_student_id[]"]').click(function(){
    var total_checkboxes = $('input[name="final_student_id[]"]').length;
    var total_checkboxes_checked = $('input[name="final_student_id[]"]:checked').length;

    if(total_checkboxes_checked == total_checkboxes){
      $('#select_all').prop('checked',true);
    }else{
      $('#select_all').prop('checked',false);
    }
  });
</script>

<!------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------->
<!--- Disabling save button if no checkbox were checked ---->
<script>
    $(document).ready(function(){
        $('#save_btn').prop("disabled", true);
            $('input:checkbox').click(function() {
                if ($(this).is(':checked')) {
                    $('#save_btn').prop("disabled", false);
                } else {
                    if ($('.checkbox_value').filter(':checked').length < 1){
                        $('#save_btn').attr('disabled',true);
                    }
                }
            });
    });
</script>
<!------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------->
<!-- NUMBERS AND DECIMAL POINT ONLY -->
<script>
$(".grades").on("input", function(evt) {
   var self = $(this);
   self.val(self.val().replace(/[^0-9\.]/g, ''));
   if ((evt.which != 46 || self.val().indexOf('.') != -1) && (evt.which < 48 || evt.which > 57)) 
   {
     evt.preventDefault();
   }
 });
 </script>

</body>
</html>
