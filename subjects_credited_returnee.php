<?php

  $faculty_user_id            = $_GET['faculty_user_id'];
  $student_id                 = $_GET['student_id'];
  $academic_id                = $_GET['academic_id'];
  $department_id              = $_GET['department_id'];
  $program_id                 = $_GET['program_id'];
  $curriculum_id              = $_GET['curriculum_id'];

  $student_status             = $_GET['student_status'];
  $student_year_level         = $_GET['student_year_level'];
  $student_semester           = $_GET['student_semester'];
  $student_section            = $_GET['student_section'];

?>

<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_registrar.php";
?>

<!DOCTYPE html>
    <html>

    <head>
        <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Enrollment </title>

        <?php include "include/tab_icon.php"; ?>
        
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
        <!-- FooTable -->
        <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
        <link href="css/animate.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">

        <link rel='stylesheet' href='https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css'>   

        
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
                <a href="registrar_scheduler.php"><i class="fa fa-lg fa-calendar-check-o" aria-hidden="true"></i> <span class="nav-label">Teacher Scheduler</span></a>
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
                <a href="registrar_manage_course.php"><i class="fa fa-lg fa-folder-open" aria-hidden="true"></i> <span class="nav-label"> Manage Course </span></a>
              </li> 
                              
              <li>
                <a href="registrar_account_settings.php"><i class="fa fa-lg fa-cog" aria-hidden="true"></i> <span class="nav-label">Account Settings</span></a>
              </li>

            </ul>
          </div>
        </nav>

        <!----HEADER-------->
        <div id="page-wrapper" class="gray-bg">
          <?php include 'bootstrap_lower/header.php';?>

          <!----UNDER HEADER----->
          <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
            <div class="col-lg-10">
              <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Enroll Student </p>
            </div>
          </div>

          <!----DATA TABLES ONE-------->
          <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
              <div class="col-lg-12">
                <div class="ibox ">
                  <div class="ibox-title">

                    <div class = "row">
                      <div class = "col-md-6">

                        <div class = "row">
                          <div class = "col-sm-4">
                            <p>Academic Year:</p>
                          </div>
                          <div class = "col-sm-8">
                            <p style = "font-weight: bold; font-size: 15px;"> 
                              <?php 
                                include 'admin_classes/config_mysqli.php';
                                  $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                                  while($row = mysqli_fetch_array($query)){
                                    $academic_year_from = $row['academic_year_from'];
                                    $academic_year_to = $row['academic_year_to'];
                                    $academic_term = $row['academic_term'];

                                    print "$academic_year_from - $academic_year_to ($academic_term)";
                                  }
                              ?>
                            </p>
                          </div>
                        </div>

                        <div class = "row" >
                          <div class = "col-sm-4">
                            <p style = 'vertical-align: middle;'>Student Type:</p>
                          </div>
                          <div class = "col-sm-8">
                            <p style = 'font-weight: bold; font-size: 15px; vertical-align: middle;'>Returnee</p>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="ibox-tools">
                      <!-- modals -->
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

                              <h3 style = "text-align:center;">Please fill up the form!</h3>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!-- Error modal / Already enrolled in current academic year -->

                      <div class="modal fade" id="enrolled_error_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Duplicate Error</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <h2 style = "text-align:center; font-weight:bold; color:red;">ERROR!</h2>

                              <h3 style = "text-align:center;">Student already enrolled!</h3>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->

                    </div>
                  </div>

                  <!----TABLE SORTED-------->
                  <div class="ibox-content">

                    <div class = "container">
                    <!---------------------------------------------------------------------------------------------------------------------------->
                    <!---------------------------------------------------------------------------------------------------------------------------->
                    <!-- 1st row -->
                    <div class = "row mt-4">

                      <div class="col-sm">
                        <label  class="text-dark" style="font-weight: bold" >STUDENT ID</label>
                        <input type="text" class="form-control border border-secondary rounded input-sm" 
                                          value = '<?php echo $_GET['student_id']; ?>' readonly>
                      </div> 

                      <div class="col-sm">
                        <label  class="text-dark" style="font-weight: bold" >DEPARTMENT</label>
                        <input type="text" class="form-control border border-secondary rounded input-sm" 
                                          value = '<?php 
                                                      include 'admin_classes/config_mysqli.php';
                                                      $department_id = $_GET['department_id']; 
                                                        $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
                                                          while($row = mysqli_fetch_array($query)){
                                                            $department_code = $row['department_code'];
                                                            $department_description = $row['department_description'];
                                                              print "$department_code: $department_description";
                                                            }
                                                    ?>' readonly>
                      </div>


                      <div class="col-sm">
                        <label  class="text-dark" style="font-weight: bold" >COURSE</label>
                        <input type="text" class="form-control border border-secondary rounded input-sm" 
                                            value = '<?php 
                                                        $program_id = $_GET['program_id']; 
                                                        $query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                                          while($row = mysqli_fetch_array($query)){
                                                            $program_code = $row['program_code'];
                                                            $program_description = $row['program_description'];
                                                              print "$program_code: $program_description";
                                                          }
                                                    ?>' readonly>
                      </div>


                      <div class="col-sm">
                        <label  class="text-dark" style="font-weight: bold" >CURRICULUM</label>
                        <input type="text" class="form-control border border-secondary rounded input-sm" 
                                            value = '<?php 
                                                        $curriculum_id = $_GET['curriculum_id']; 
                                                        $query = mysqli_query($con, "SELECT * FROM manage_curriculum JOIN manage_program 
                                                                                      ON manage_curriculum.program_id = manage_program.program_id 
                                                                                      WHERE manage_curriculum.curriculum_id = '$curriculum_id'");
                                                          while($row = mysqli_fetch_array($query)){
                                                            $curriculum_year = $row['curriculum_year'];
                                                            $program_code = $row['program_code'];
                                                              print "$program_code - $curriculum_year";
                                                          }
                                                    ?>' readonly>
                      </div>

                      </div><!-- end of 1st Row -->

                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!-- 2nd row -->
                      <div class = "row mt-3">

                      <div class="col-sm">
                        <label  class="text-dark" style="font-weight: bold" >STATUS</label>
                        <input type="text" class="form-control border border-secondary rounded input-sm" 
                                            value = '<?php echo $_GET['student_status']; ?>' readonly>
                      </div>

                      <div class="col-sm">
                        <label  class="text-dark" style="font-weight: bold" >SEMESTER</label>
                        <input type="text" class="form-control border border-secondary rounded input-sm" 
                                            value = '<?php echo $_GET['student_semester']; ?>' readonly>
                      </div>

                      <div class="col-sm">
                        <label  class="text-dark" style="font-weight: bold" >YEAR LEVEL</label>
                        <input type="text" class="form-control border border-secondary rounded input-sm" 
                                            value = '<?php echo $_GET['student_year_level']; ?>' readonly>
                      </div>

                      <div class="col-sm">
                        <label  class="text-dark" style="font-weight: bold" >SECTION</label>
                        <input type="text" class="form-control border border-secondary rounded input-sm" 
                                            value = '<?php echo $_GET['student_section']; ?>' readonly>
                      </div>

                      </div><!-- end of 2nd Row -->

                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!-- 3rd Row -->
                      <div class="row mt-4" >
                        <div class="col-md" >
                          <label  class="text-dark" style="font-weight: bold" >SURNAME</label>
                          <input type="text" class="form-control border border-secondary rounded input-sm"
                                              value = '<?php 
                                                        $query = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = '$student_id'");
                                                        while($row = mysqli_fetch_array($query)){                                               
                                                          $lastname = $row['lastname'];
                                                            echo $lastname;
                                                        } ?>' readonly>
                        </div>

                        <div class="col-md" >
                            <label  class="text-dark" style="font-weight: bold;" >GIVEN NAME</label>
                            <input type="text" class="form-control border border-secondary rounded input-sm" 
                                                value = '<?php   $query = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = '$student_id'");
                                                          while($row = mysqli_fetch_array($query)){
                                                            $firstname = $row['firstname'];
                                                              echo $firstname;
                                                          } ?>' readonly>        
                        </div> 

                        <div class="col-md" >
                            <label  class="text-dark" style="font-weight: bold;" >MIDDLENAME</label>
                            <input type="text" class="form-control border border-secondary rounded input-sm" 
                                                value = '<?php   $query = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = '$student_id'");
                                                          while($row = mysqli_fetch_array($query)){
                                                            $middlename     = $row['middlename'];
                                                                echo $middlename;
                                                          } ?>' readonly>        
                        </div> 

                        <div class="col-md" >
                            <label  class="text-dark" style="font-weight: bold;" >NAME EXTENTION</label>
                            <input type="text" class="form-control border border-secondary rounded input-sm" 
                                                value = '<?php   $query = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = '$student_id'");
                                                          while($row = mysqli_fetch_array($query)){
                                                            $name_extension = $row['name_extension'];
                                                              echo $name_extension;
                                                          } ?>' readonly>        
                            
                      </div> <!-- end of 3rd row -->
                    </div>
                  </div> <!-- end of container -->

                  <hr>

                  <div class = "container">
                    <i class="fa fa-info-circle fa-lg" aria-hidden="true"></i> <i> (Select subjects to be credited below.)</i>             
                  </div>

                  <hr>

                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <form action = "admin_classes/insert_returnee_enrollment.php" method = "POST">
                    <!---------------------------------------------------------------------------------------------------------------------------->
                    <!--HIDDEN DATA---->
                    <input type = 'text' value = '<?php echo $_GET['faculty_user_id']; ?>'    name = 'faculty_user_id'    hidden>
                    <input type = 'text' value = '<?php echo $_GET['student_id']; ?>'         name = 'student_id'         hidden>
                    <input type = 'text' value = '<?php echo $_GET['academic_id']; ?>'        name = 'academic_id'        hidden>
                    <input type = 'text' value = '<?php echo $_GET['department_id']; ?>'      name = 'department_id'      hidden>
                    <input type = 'text' value = '<?php echo $_GET['program_id']; ?>'         name = 'program_id'         hidden>
                    <input type = 'text' value = '<?php echo $_GET['curriculum_id']; ?>'      name = 'curriculum_id'      hidden>
                    <input type = 'text' value = '<?php echo $_GET['student_status']; ?>'     name = 'student_status'     hidden>
                    <input type = 'text' value = '<?php echo $_GET['student_year_level']; ?>' name = 'student_year_level' hidden>
                    <input type = 'text' value = '<?php echo $_GET['student_semester']; ?>'   name = 'student_semester'   hidden>
                    <input type = 'text' value = '<?php echo $_GET['student_section']; ?>'    name = 'student_section'    hidden>

                    <div class = "container">
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
                          //<!---------------------------------------------------------------------------------------------------------------------------->
                          //<!---------------------------------------------------------------------------------------------------------------------------->
                          // 1st year 1st semester
                          include 'admin_classes/config_mysqli.php';

                            $curriculum_id = $_GET['curriculum_id'];
                            $student_id = $_GET['student_id'];

                            $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 1 AND subject_semester = '1st Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                            while($row = mysqli_fetch_array($query)){
                              $subject_id          = $row['subject_id'];                        
                              $subject_code        = $row['subject_code'];
                              $subject_description = $row['subject_description'];
                              $subject_unit        = $row['subject_unit'];

                              //checks the grades if students is passed
                              $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                                AND student_id = '$student_id' AND remarks = 'PASSED'");

                                  if(mysqli_num_rows($query_grades_report)>0){    
                                    print "
                                    <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                                      <td>$subject_code</td>
                                      <td>$subject_description</td>
                                      <td>$subject_unit</td>
                                      <td> 
                                        <div class='form-check'>
                                          <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                        </div>
                                      </td>
                                    </tr>";
                                  
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
                                    </tr>";
                                  }
                              }
                          
                        ?>

                      <tr style = 'border: 1px solid Transparent;'>
                        <td ><button type="button" class="btn btn-outline-primary"><b>1st Year (2nd Semester)</b></button></td>
                      </tr>

                        <?php

                        //<!---------------------------------------------------------------------------------------------------------------------------->
                        //<!---------------------------------------------------------------------------------------------------------------------------->
                          // 1st year 2nd semester
                          include 'admin_classes/config_mysqli.php';

                          $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 1 AND subject_semester = '2nd Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                          while($row = mysqli_fetch_array($query)){
                            $subject_id          = $row['subject_id'];                        
                            $subject_code        = $row['subject_code'];
                            $subject_description = $row['subject_description'];
                            $subject_unit        = $row['subject_unit'];

                              //checks the grades if students is passed
                              $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                                AND student_id = '$student_id' AND remarks = 'PASSED'");
                          
                              if(mysqli_num_rows($query_grades_report)>0){                                      

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

                        //<!---------------------------------------------------------------------------------------------------------------------------->
                        //<!---------------------------------------------------------------------------------------------------------------------------->
                          // 2nd year 1st semester
                          include 'admin_classes/config_mysqli.php';

                          $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 2 AND subject_semester = '1st Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                          while($row = mysqli_fetch_array($query)){
                            $subject_id          = $row['subject_id'];                        
                            $subject_code        = $row['subject_code'];
                            $subject_description = $row['subject_description'];
                            $subject_unit        = $row['subject_unit'];

                              //checks the grades if students is passed
                              $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                                AND student_id = '$student_id' AND remarks = 'PASSED'");
                            
                              if(mysqli_num_rows($query_grades_report)>0){                                      

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

                        //<!---------------------------------------------------------------------------------------------------------------------------->
                        //<!---------------------------------------------------------------------------------------------------------------------------->
                          // 2nd year 2nd semester
                          include 'admin_classes/config_mysqli.php';

                          

                          $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 2 AND subject_semester = '2nd Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                          while($row = mysqli_fetch_array($query)){
                            $subject_id          = $row['subject_id'];                        
                            $subject_code        = $row['subject_code'];
                            $subject_description = $row['subject_description'];
                            $subject_unit        = $row['subject_unit'];

                              //checks the grades if students is passed
                              $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                                AND student_id = '$student_id' AND remarks = 'PASSED'");
                            

                              if(mysqli_num_rows($query_grades_report)>0){                                      

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

                        //<!---------------------------------------------------------------------------------------------------------------------------->
                        //<!---------------------------------------------------------------------------------------------------------------------------->
                          // 3rd year 1st semester
                          include 'admin_classes/config_mysqli.php';

                          $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 3 AND subject_semester = '1st Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                          while($row = mysqli_fetch_array($query)){
                            $subject_id          = $row['subject_id'];                        
                            $subject_code        = $row['subject_code'];
                            $subject_description = $row['subject_description'];
                            $subject_unit        = $row['subject_unit'];

                              //checks the grades if students is passed
                              $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                                AND student_id = '$student_id' AND remarks = 'PASSED'");
                            
                              if(mysqli_num_rows($query_grades_report)>0){                                      

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

                        //<!---------------------------------------------------------------------------------------------------------------------------->
                        //<!---------------------------------------------------------------------------------------------------------------------------->
                          // 3rd year 2nd semester
                          include 'admin_classes/config_mysqli.php';

                        
                          $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 3 AND subject_semester = '2nd Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                          while($row = mysqli_fetch_array($query)){
                            $subject_id          = $row['subject_id'];                        
                            $subject_code        = $row['subject_code'];
                            $subject_description = $row['subject_description'];
                            $subject_unit        = $row['subject_unit'];

                              //checks the grades if students is passed
                              $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                                AND student_id = '$student_id' AND remarks = 'PASSED'");
                            
                              if(mysqli_num_rows($query_grades_report)>0){                                      

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

                        //<!---------------------------------------------------------------------------------------------------------------------------->
                        //<!---------------------------------------------------------------------------------------------------------------------------->
                          // 4th year 1st semester
                          include 'admin_classes/config_mysqli.php';

                          $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 4 AND subject_semester = '1st Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                          while($row = mysqli_fetch_array($query)){
                            $subject_id          = $row['subject_id'];                        
                            $subject_code        = $row['subject_code'];
                            $subject_description = $row['subject_description'];
                            $subject_unit        = $row['subject_unit'];

                              //checks the grades if students is passed
                              $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                                AND student_id = '$student_id' AND remarks = 'PASSED'");
                            
                              if(mysqli_num_rows($query_grades_report)>0){                                      

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

                        //<!---------------------------------------------------------------------------------------------------------------------------->
                        //<!---------------------------------------------------------------------------------------------------------------------------->
                          // 4th year 2nd semester
                          include 'admin_classes/config_mysqli.php';

                        

                          $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 4 AND subject_semester = '2nd Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                          while($row = mysqli_fetch_array($query)){
                            $subject_id          = $row['subject_id'];                        
                            $subject_code        = $row['subject_code'];
                            $subject_description = $row['subject_description'];
                            $subject_unit        = $row['subject_unit'];

                              //checks the grades if students is passed
                              $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                                AND student_id = '$student_id' AND remarks = 'PASSED'");

                              if(mysqli_num_rows($query_grades_report)>0){                                      

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
                        
                  </div><!--end of container -->
                  <hr>
                  <div class="row mt-4">
                    <div class="col-sm" >                     
                      <button type="button" class="btn btn-success btn-sm border-secondary" data-toggle='modal' data-target = '#save_modal' style = "float:right;">Save</button>
                    </div> 
                  </div>

                  <!-- Delete Department Modal -->
                  <div class="modal fade" id="save_modal" role="dialog" >
                    <div class="modal-dialog" style = "width:300px;"> 
                    <!-- Modal content-->
                      <div class="modal-content" >
                          <div class="modal-header" style = "color:red;">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body" style = "text-align:center;">
                            <h6 style = "font-size:20px; font-weight:bold;"> Are you sure you want to save this information? </h6>  
                          </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id = "save_btn" name = "save_btn">Save</button>
                        </div>
                      </div>
                    </div>
                  </div>

                </form>



                    
                    
                  </div>

                </div>
              </div>
            </div>

          </div>
            <?php include 'bootstrap_lower/lower.php'; ?>
        </div>


<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-----DATA TABLE SCRIPT------------------------------------------------------------------------------------------------------>

   <script type="text/javascript">
        $(document).ready(function() {

     $('#example').DataTable( {
        "order": [],"bSort" : false,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                text: 'Export to Excel',
                exportOptions: {columns: [ 1, 2, 3, 4, 5, 6],
                  modifier: {selected: null}
                 },
            }
        ],
        select: true
    } );
} );

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
