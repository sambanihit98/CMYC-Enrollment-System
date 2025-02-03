<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_registrar.php";
?>

<?php

include 'admin_classes/config_mysqli.php';

  if(isset($_GET['enrollment_id'])){
    $enrollment_id = $_GET['enrollment_id'];

    $query = mysqli_query($con, "SELECT * FROM manage_enrollment
                                  JOIN manage_program ON manage_enrollment.program_id = manage_program.program_id
                                   WHERE manage_enrollment.enrollment_id = '$enrollment_id'");
      while($row = mysqli_fetch_array($query)){
        $student_id          = $row['student_id'];
        $student_firstname   = ucwords($row['student_firstname']);
        $student_lastname    = ucwords($row['student_lastname']);
        $student_middlename  = ucwords($row['student_middlename']);
        $student_year_level  = $row['student_year_level'];
        $student_semester    = $row['student_semester'];
        $student_status      = $row['student_status'];
        $student_section     = $row['student_section'];
        $student_type        = $row['student_type'];
        
        //manage_program table
        $curriculum_id       = $row['curriculum_id'];
        $program_id          = $row['program_id'];
        $program_code        = $row['program_code'];
        $program_description = $row['program_description'];

        //middle initial
        $middle_initial = substr("$student_middlename", 0, 1);  // returns "abcde"
      }
  }

?>


<!DOCTYPE html>
  <html>

  <head>
    <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Evaluation </title>

    <?php include "include/tab_icon.php"; ?>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

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
              <a href="registrar_dashboard.php"><i class="fa fa-lg fa-home" aria-hidden="true"></i> <span class="nav-label">Home</span></a>
            </li>

            <li class="active">
              <a href="registrar_manage_enrollment.php"><i class="fa fa-lg fa-address-book-o" aria-hidden="true"></i> <span class="nav-label">Enrollment</span></a>
            </li>

            <li>
              <a href="registrar_student_record.php"><i class="fa fa-lg fa-address-card" aria-hidden="true"></i> <span class="nav-label">Student Record</span></a>
            </li> 

            <li>
              <a href="registrar_teacher_scheduler.php"><i class="fa fa-lg fa-calendar-check-o" aria-hidden="true"></i> <span class="nav-label">Teacher Scheduler</span></a>
            </li>
                            
            <li>
              <a href="registrar_manage_department.php"><i class="fa fa-lg fa-folder-open" aria-hidden="true"></i> <span class="nav-label">Manage Department </span></a>
            </li> 

            <li>
              <a href="registrar_manage_program.php"><i class="fa fa-lg fa-folder-open" aria-hidden="true"></i> <span class="nav-label">Manage Program </span></a>
            </li> 

            <li>
              <a href="registrar_manage_curriculum.php"><i class="fa fa-lg fa-folder-open" aria-hidden="true"></i> <span class="nav-label">Manage Curriculum</span></a>
            </li> 

            <li>
              <a href="registrar_manage_subject.php"><i class="fa fa-lg fa-folder-open" aria-hidden="true"></i> <span class="nav-label"> Manage Subject </span></a>
            </li> 
                            
            <li>
              <a href="registrar_account_settings.php"><i class="fa fa-lg fa-cog" aria-hidden="true"></i> <span class="nav-label">Account Settings</span></a>
            </li>

          </ul>
        </div>
      </nav>

      <!---------------------------------------------------------------------------------------------------------------------------->
      <!---------------------------------------------------------------------------------------------------------------------------->

       <!-- Delete Program Modal -->
       <div class="modal fade" id="delete_modal" role="dialog" >
          <div class="modal-dialog" style = "width:300px;"> 
          <!-- Modal content-->
              <div class="modal-content" >
                      <div class="modal-header" style = "color:red;">
                          
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                  <div class="modal-body" style = "text-align:center;">
                      <form method = "POST" action = "admin_classes/delete_student_subject_load_script.php" id = "form_delete">
                          
                          <h6 style = "font-size:20px; font-weight:bold;"> Are you sure you want to remove this data? </h6>  
                          <div class = "delete_info" ></div>

                      </form>
                  </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="button" class="btn btn-danger" id = "delete_btn">Delete</button>
                      
                  </div>
              </div>
          </div>
      </div>

      <!--------------------------------------------------------------------------------------------------------------------->
      <!--------------------------------------------------------------------------------------------------------------------->

      <!-- Update Modal -->
      <div class="modal fade" id="update_modal" role="dialog" >
        <div class="modal-dialog modal-md" >
          <!-- Modal content-->
          <div class="modal-content" >
            <div class="modal-header">
              <div class="modal-title" ><h4>Update Student Schedule</h4></div>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
              <div class="modal-body">
            
                <div id = "update_data"></div>

                <div class = "mt-4" id = "error" style = 'color:red; font-weight:bold; text-align:center;'></div>

                <div class = "row mt-4" style = "float:right;">
                  <button type="button" style = "margin:5px;" class="btn btn-secondary" data-dismiss="modal" id = "cancel_btn"> Cancel</button>
                  <button type="button" style = "margin:5px;" class="btn btn-primary" id = "update_btn"> Update</button>
                </div>
              </div>
              <div class="modal-footer">
              </div>
          </div>
        </div>
      </div>

      <!---------------------------------------------------------------------------------------------------------------------------->
      <!---------------------------------------------------------------------------------------------------------------------------->

      <!----HEADER----->
      <div id="page-wrapper" class="gray-bg">
        <?php include 'bootstrap_lower/header.php';?>

        <!----UNDER HEADER-------------------------------------------------------------------------------------------------------------->
        <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
          <div class="col-lg-10">
            <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Student Evaluation </p>
          </div>
        </div>

        <!-- LOAD SUBJECT -->

        <!-- Modal -->
        <div class="modal fade" id="load_subject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Subject List</4>
              </div>
              <div class="modal-body">
                
                <!---------------------------------------------------------------------------------------------------------------------------->
                <!---------------------------------------------------------------------------------------------------------------------------->
                <form action = "admin_classes/insert_student_subject_load.php" method = "POST">

                <!-- HIDDEN DATA -->

                <?php
                  if(isset($_GET['enrollment_id'])){
                    $enrollment_id = $_GET['enrollment_id'];

                    //enrollment_ id
                    print "<input type = 'text' name = 'enrollment_id' value = '$enrollment_id' id = 'enrollment_id' hidden>";
                  }

                ?>

                <!------------------------------------------------------------------------------------------------------------------------>
                <!------------------------------------------------------------------------------------------------------------------------>
                <!---faculty_user_id--->
                <?php include "include/faculty_user_id.php"; ?>

                <table class = "table table-sm">
                    <tr style = 'background-color:#fef6c5;'><td><b>Subjects currently taking</b></td></tr>
                    <tr style = 'background-color:#a3e7d6;'><td><b>Subjects passed or credited</b></td></tr>
                </table>
                <br>
                <table class = "table table-sm">
                  <thead class="bg-success text-center">
                    
                      <th>Subject Code</th>
                      <th>Subject Description</th>
                      <th>Units</th>
                      <th>Select</th>
                    
                  </thead>
                  
                    <tbody class = 'text-center'>

                    <tr>
                      <td><button type="button" class="btn btn-outline-primary"><b>1st Year (1st Semester)</b></button></td>
                    </tr>

                      <?php
                        // 1st year 1st semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 1 AND subject_semester = '1st Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];


                          $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");
                            
                            $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                            while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                              $student_id = $row_enrollment['student_id'];

                              //checks the grades if students is passed
                              $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                                AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                            }
                          
                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";
                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";
                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>1st Year (2nd Semester)</b></button></td>
                    </tr>

                      <?php
                        // 1st year 2nd semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 1 AND subject_semester = '2nd Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                           $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";
                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>2nd Year (1st Semester)</b></button></td>
                    </tr>

                      <?php
                        // 2nd year 1st semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 2 AND subject_semester = '1st Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                          $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>2nd Year (2nd Semester)</b></button></td>
                    </tr>

                      <?php
                        // 2nd year 2nd semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 2 AND subject_semester = '2nd Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                           $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>3rd Year (1st Semester)</b></button></td>
                    </tr>

                      <?php
                        // 3rd year 1st semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 3 AND subject_semester = '1st Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                          $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";
                            
                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>3rd Year (2nd Semester)</b></button></td>
                    </tr>

                      <?php
                        // 3rd year 2nd semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 3 AND subject_semester = '2nd Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                          $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";
                            
                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>4th Year (1st Semester)</b></button></td>
                    </tr>

                      <?php
                        // 4th year 1st semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 4 AND subject_semester = '1st Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                          $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>4th Year (2nd Semester)</b></button></td>
                    </tr>

                      <?php
                        // 4th year 2nd semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 4 AND subject_semester = '2nd Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                          $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";
                            
                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    </tbody>

                </table>

              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name = "save_subject" class="btn btn-primary" id = 'save_btn'>Save</button>
              </div>

              </form>
              <!---------------------------------------------------------------------------------------------------------------------------->
              <!---------------------------------------------------------------------------------------------------------------------------->

            </div>
          </div>
        </div>

        <!-- END OF LOAD SUBJECT -->

        <!---------------------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------------------------------------------------------------------------------->

        <?php include 'include/credit_subject_modal.php'; ?>

        <!---------------------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------------------------------------------------------------------------------->

        <!----UP TABLE---------->
        <div class="wrapper wrapper-content animated fadeInRight">
          <div class="row">
            <div class="col-lg-12">
              <div class="ibox-content">

                <h4 class="text-center">: : :  STUDENT SUBJECT ALLOCATION  : : :</h4> <br>

                <div class = "container"> <!-- start of container -->
 
                  <div class = "row">
                    <div class = "col-md-6">
                      <div class = "row">

                        <div class = "col-md-5">
                          <h4 style="font-weight: 350; margin-right: 15px;" class="text-dark">ID Number: </h4>
                        </div>
                        
                        <div class = "col-md-7">
                          <h3 style="font-size: 15px;"> <?php echo "$student_id"; ?>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class = "row">
                    <div class = "col-md-6">
                      <div class = "row">

                        <div class = "col-md-5">
                        <h4 style="font-weight: 350; margin-right: 15px;">Student's Name: </h4>  
                        </div>
                        
                        <div class = "col-md-7">
                        <h3 style="font-size: 15px;"> <?php echo "$student_lastname, $student_firstname $middle_initial."; ?>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class = "row">
                    <div class = "col-md-6">
                      <div class = "row">

                        <div class = "col-md-5">
                        <h4 style="font-weight: 350; margin-right: 15px;">Student Type: </h4>  
                        </div>
                        
                        <div class = "col-md-7">
                        <h3 style="font-size: 15px;"> <?php echo "$student_type"; ?>
                        </div>

                      </div>
                    </div>
                  </div>

                  <div class = "row">
                    <div class = "col-md-6">
                      <div class = "row">

                        <div class = "col-md-5">
                        <h4 style="font-weight: 350; margin-right: 15px;">Course & Section: </h4>  
                        </div>
                        
                        <div class = "col-md-7">
                        <h3 style="font-size: 15px;"> <?php echo "$program_code - $student_year_level$student_section"; ?>
                        </div>

                      </div>
                    </div>
                  </div> 
                  
                  <div class = "row">
                    <div class = "col-md-6">
                      <div class = "row">

                        <div class = "col-md-5">
                          <h4 style="font-weight: 350; margin-right: 15px;">Academic Year: </h4>  
                        </div> 

                        <div class = "col-md-7">
                          <h3 style="font-size: 15px;"> 
                            <?php 
                              include 'admin_classes/config_mysqli.php';
                                $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                                while($row = mysqli_fetch_array($query)){
                                  $academic_year_from = $row['academic_year_from'];
                                  $academic_year_to   = $row['academic_year_to'];
                                  $academic_term      = $row['academic_term'];

                                  print "$academic_year_from - $academic_year_to ($academic_term)";
                                }
                            ?> 
                          </h3>
                        </div>

                      </div>
                    </div>          

                    <div class = "col-md-6" >
                      <div class = "row" style = "float:right;">
                          <button type="button" style = "margin:5px; display:none;" class="btn btn-success btn-xs" data-toggle="modal" data-target="#credit_subject" data-whatever="@mdo" id = "credit_subject_btn"> <i class="fa fa-plus fa-lg" aria-hidden="true"></i> Credit Subject</button> 
                          <button type="button" style = "margin:5px;" class="btn btn-success btn-xs" data-toggle="modal" data-target="#load_subject" data-whatever="@mdo" id = "load_subject"> <i class="fa fa-plus fa-lg" aria-hidden="true"></i> Load Subject</button> 
                           <a href="print/print_cor.php?enrollment_id=<?php echo $_GET['enrollment_id']; ?>&registrar_user_id=<?php echo $_SESSION['registrar_user_id']; ?>" target="_blank" class="btn btn-xs btn-success" style = "margin:5px;"> <i class="fa fa-print" aria-hidden="true"> </i> Print COR</a> 
                      </div>
                    </div>

                  </div>
                  
                </div> <!-- end of container -->

                <hr>

                <!--------------------------------------------------------------------------------------------------------------------->
                <!--------------------------------------------------------------------------------------------------------------------->
                <!--- Deleted Alert -->
                <?php 
                if(isset($_GET['deleted'])){
                    print("
                    <div class = 'alert alert-danger alert-dismissible alert-sm'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <i class='fa fa-exclamation-circle'></i> <span> Subject has been deleted successfully!</span>
                    </div>"
                    );  
                }
                ?> 

                <!--------------------------------------------------------------------------------------------------------------------->
                <!--------------------------------------------------------------------------------------------------------------------->
                <!--- Added Alert -->
                <?php 
                if(isset($_GET['added'])){
                    print("
                    <div class = 'alert alert-success alert-dismissible alert-sm'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <i class='fa fa-exclamation-circle'></i> <span> Subjects has been added successfully!</span>
                    </div>"
                    );  
                }
                ?> 

                <!--------------------------------------------------------------------------------------------------------------------->
                <!--------------------------------------------------------------------------------------------------------------------->
                <!--- Credited Alert -->
                <?php 
                if(isset($_GET['credited'])){
                    print("
                    <div class = 'alert alert-success alert-dismissible alert-sm'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <i class='fa fa-exclamation-circle'></i> <span> Subjects has been credited successfully!</span>
                    </div>"
                    );  
                }
                ?> 

                <!-- TABLE -->

                <table class="mt-2 table table-striped">
                  <thead class="bg-success text-center">
                    <th >SUBJECT CODE</th>
                    <th >SUBJECT DESCRIPTION</th>
                    <th >UNITS</th>
                    <th style = 'width:150px;'>TIME</th>
                    <th >DAY</th>
                    <th >SECTION</th>
                    <th >ROOM</th>
                    <th >TEACHER</th>
                    <th >ACTION</th>
                  </thead>
                  <tbody>
                    <?php
                      include 'admin_classes/config_mysqli.php';

                      $enrollment_id = $_GET['enrollment_id'];

                      $query = mysqli_query($con, "SELECT * FROM student_subject_load 
                                                    JOIN manage_subject ON student_subject_load.subject_id = manage_subject.subject_id
                                                    JOIN manage_enrollment ON student_subject_load.enrollment_id = manage_enrollment.enrollment_id
                                                    WHERE student_subject_load.enrollment_id = '$enrollment_id'");

                        while($row = mysqli_fetch_array($query)){
                          //student_subject_load table
                          $student_subject_load_id        = $row['student_subject_load_id'];
                          $academic_id                    = $row['academic_id'];
                          $student_subject_section        = $row['student_subject_section'];
                          //$student_subject_section_course = $row['student_subject_section_course'];

                          //manage_subject table
                          $subject_id              = $row['subject_id'];
                          $subject_code            = $row['subject_code'];
                          $subject_description     = $row['subject_description'];
                          $subject_unit            = $row['subject_unit'];

                          //manage_enrollment table
                          //$student_section         = $row['student_section'];

                          print "
                            <tr class='text-center' >
                              <td style = 'vertical-align:middle;'> $subject_code </td>
                              <td style = 'vertical-align:middle;'> $subject_description </td>
                              <td style = 'vertical-align:middle;'> $subject_unit </td> ";

                              //SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id' AND subject_section = '$student_section

                          // checks if there is a teacher aasigned to this subject and section
                          $query_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                                                                        JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
                                                                        WHERE teacher_subject_load.subject_id = '$subject_id'
                                                                        AND teacher_subject_load.subject_section = '$student_subject_section'
                                                                        AND teacher_subject_load.academic_id = '$academic_id'");

                          if(mysqli_num_rows($query_teacher_schedule)>0){
                          $row_teacher = mysqli_fetch_array($query_teacher_schedule);

                            //teacher name
                            $account_user_id = $row_teacher['account_user_id'];
                            $account_firstname  = ucwords($row_teacher['account_firstname']);
                            $account_lastname  = ucwords($row_teacher['account_lastname']);

                              //---------------------------------------------------------------------------------------------------------------------------->
                              //---------------------------------------------------------------------------------------------------------------------------->
                              print "<td style = 'vertical-align:middle;'>";  //time
                                $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                              AND subject_section = '$student_subject_section' 
                                                              AND academic_id = '$academic_id'
                                                              AND account_user_id = '$account_user_id'");
                                while($row1 = mysqli_fetch_array($query1)){
    
                                  $subject_time_from     = $row1['subject_time_from'];
                                  $subject_time_to       = $row1['subject_time_to'];
                                  $time_from             = date("g:ia", strtotime($subject_time_from));
                                  $time_to               = date("g:ia", strtotime($subject_time_to));

                                  print "$time_from - $time_to <br><br>";
                                }
                              print "</td>"; //end of time

                              //---------------------------------------------------------------------------------------------------------------------------->
                              //---------------------------------------------------------------------------------------------------------------------------->
                              print "<td style = 'vertical-align:middle;'>"; //day
                                $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                              AND subject_section = '$student_subject_section'
                                                              AND academic_id = '$academic_id'
                                                              AND account_user_id = '$account_user_id'");
                                while($row1 = mysqli_fetch_array($query1)){

                                  $day_initial   = $row1['day_initial'];

                                  if($day_initial == "1Mon"){
                                    $day = "Monday";
                                  }else if($day_initial == "2Tue"){
                                    $day = "Tuesday";
                                  }else if($day_initial == "3Wed"){
                                    $day = "Wednesday";
                                  }else if($day_initial == "4Thu"){
                                    $day = "Thursday";
                                  }else if($day_initial == "5Fri"){
                                    $day = "Friday";
                                  }else if($day_initial == "6Sat"){
                                    $day = "Saturday";
                                  }else if($day_initial == "7Sun"){
                                    $day = "Sunday";
                                  }
                               
                                  print "$day <br><br>";
                                }
                              print "</td>"; //end of day

                              //---------------------------------------------------------------------------------------------------------------------------->
                              //---------------------------------------------------------------------------------------------------------------------------->
                              print "<td style = 'vertical-align:middle;'>"; //section
                                $query1 = mysqli_query($con, "SELECT * FROM student_subject_load JOIN manage_program 
                                  ON student_subject_load.student_subject_section_course = manage_program.program_id
                                  WHERE student_subject_load.subject_id = '$subject_id'
                                  AND student_subject_load.enrollment_id = '$enrollment_id'");
                                  while($row1 = mysqli_fetch_array($query1)){

                                  $student_subject_section       = $row1['student_subject_section'];
                                  $program_code                  = $row1['program_code'];
                                  $student_subject_section_year  = $row1['student_subject_section_year'];

                                  print "$program_code-$student_subject_section_year$student_subject_section <br><br>";
                                }
                              print "</td>"; //end of section

                              //---------------------------------------------------------------------------------------------------------------------------->
                              //---------------------------------------------------------------------------------------------------------------------------->
                              print "<td style = 'vertical-align:middle;'>"; //room
                                $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                              AND subject_section = '$student_subject_section'
                                                              AND academic_id = '$academic_id'
                                                              AND account_user_id = '$account_user_id'");
                                  while($row1 = mysqli_fetch_array($query1)){

                                  $subject_room  = $row1['subject_room'];
 
                                  print "$subject_room <br><br>";
                                }
                              print "</td>"; //end of room

                              //---------------------------------------------------------------------------------------------------------------------------->
                              //---------------------------------------------------------------------------------------------------------------------------->
                              
                              print "<td style = 'vertical-align:middle'> $account_firstname $account_lastname </td>"; 

                              //---------------------------------------------------------------------------------------------------------------------------->
                              //---------------------------------------------------------------------------------------------------------------------------->
                              
                              print " 
                                <td style = 'vertical-align:middle;'> 
                                  <div class='dropdown dropleft'>
                                    <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                        Action 
                                    </button>

                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                      <a class='dropdown-item' href = '' data-id='$student_subject_load_id' data-academic='$academic_id' data-subject='$subject_id' data-toggle='modal' data-target = '#update_modal'> <i class='fa fa-pencil fa-fw'></i>Update</a>
                                      <a class='dropdown-item' href = '' data-id='$student_subject_load_id' data-academic='$academic_id' data-subject='$subject_id' data-toggle='modal' data-target = '#delete_modal'> <i class='fa fa-trash fa-fw'></i>Delete</a>
                                    </div> 
                                </div>
                                </td>";

                        }else{
                          //no teacher yet
                          print "
                              <td style = 'vertical-align:middle;'> -- </td>
                              <td style = 'vertical-align:middle;'> -- </td>
                              <td style = 'vertical-align:middle;'> -- </td>
                              <td style = 'vertical-align:middle;'> -- </td>
                              <td style = 'vertical-align:middle;'> <span class='badge badge-secondary'>No teacher yet</span> </td>
                              <td style = 'vertical-align:middle;'> 
                                <div class='dropdown dropleft'>
                                  <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                      Action 
                                  </button>

                                  <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                    <a class='dropdown-item' href = '' data-id='$student_subject_load_id' data-academic='$academic_id' data-subject='$subject_id' data-toggle='modal' data-target = '#update_modal'> <i class='fa fa-pencil fa-fw'></i>Update</a>
                                    <a class='dropdown-item' href = '' data-id='$student_subject_load_id' data-academic='$academic_id' data-subject='$subject_id' data-toggle='modal' data-target = '#delete_modal'> <i class='fa fa-trash fa-fw'></i>Delete</a>
                                  </div> 
                                </div>
                              </td>
                          ";
                        }  
                          
                          print "</tr>";

                        }
                          
                    ?>
                  </tbody>
                </table>

            </div>   
        </div>
    </div>
</div>
<!----------UP TABLE---------->
 
<?php include 'bootstrap_lower/lower.php'; ?>
</div>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->

<?php
  
  if($student_type == 'Shiftee' || $student_type == 'Transferee' || $student_type == 'Returnee'){
    
    print "
      <script>
        $(document).ready(function(){
          $('#credit_subject_btn').show();
        });
      </script>
    ";
  }

?>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->

<script>
    $(document).ready(function(){
      $(document).on("click",".dropdown-item", function (){ 
        
        var student_subject_load_id = $(this).data('id');
        var academic_id = $(this).data('academic');
        var subject_id = $(this).data('subject');

        // AJAX request
            $.ajax({
            url: 'admin_classes/update_student_schedule_form.php',
            type: 'POST',
            data: {
              student_subject_load_id  :student_subject_load_id,
              academic_id              :academic_id,
              subject_id               :subject_id
            },
            success: function(response){ 
                // Add response in Modal body
                $('#update_data').html(response);
            }
            });
        });
    });
</script>

<!-- FORM UPDATE-->
<script>
    $(document).ready(function(){
      $(document).on("click", "#update_btn", function(){

        var faculty_user_id         = $('#account_user_id').val();
        var choose_section          = $('#choose_section').val();

        var enrollment_id           = $('select option:selected').data('enrollmentid');
        var program_id              = $('select option:selected').data('program');
        var subject_id              = $('select option:selected').data('subject');
        var old_subject_id          = $('select option:selected').data('oldsubject');
        var year_level              = $('select option:selected').data('year');
        var section                 = $('select option:selected').data('section');
        var student_subject_load_id = $('select option:selected').data('loadid');


        if(choose_section == ""){       
          
          $('#error').html('Invalid Attempt! Please select a section!');
          $('#error').show();   
          $('#error').effect('shake');

        }else{

          $.ajax({
            
            url: "admin_classes/update_student_schedule_ajax.php",
            type: "POST",
            data: {

              faculty_user_id          :faculty_user_id,
              enrollment_id            :enrollment_id,
              subject_id               :subject_id,
              old_subject_id           :old_subject_id,
              program_id               :program_id,
              year_level               :year_level,
              section                  :section,
              student_subject_load_id  :student_subject_load_id
   
            },
            cache: false,
            success: function(dataResult){

              var dataResult = JSON.parse(dataResult);
               
              if(dataResult.statusCode==200){
                    window.location = "registrar_student_evaluation.php?updated&enrollment_id=<?php echo $enrollment_id ?>";						
                }else{
                   
                  $("#error").show();  
                  $('#error').html('Updating student schedule failed!'); 
                  $('#error').effect("shake");                                 
                   
                }  
            }
           
          });
        }
      
      });   
    });
</script>

<!------------------------------------------------------------------------------->
<!------------------------------------------------------------------------------->

<!-- DELETE PROGRAM -->
<script>
  $(document).ready(function(){
      $('.dropdown-item').click(function(){

        var faculty_user_id         = $('#account_user_id').val();
        var student_subject_load_id = $(this).data('id');
        var academic_id             = $(this).data('academic');
        var subject_id              = $(this).data('subject');

      // AJAX request
          $.ajax({
          url: 'admin_classes/delete_student_subject_load_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id         :faculty_user_id,
            student_subject_load_id :student_subject_load_id,
            academic_id             :academic_id,
            subject_id              :subject_id
            },
          success: function(response){ 
              // Add response in Modal body
              $('.delete_info').html(response);
          }
          });
      });
  });
</script> 

  <script>
  $(document).ready(function(){
    $('#delete_btn').click(function(){
      $('#form_delete').submit();
    });
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


</body>
</html>
