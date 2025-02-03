<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_registrar.php";

  $student_id = $_GET['student_id'];

  $query = mysqli_query($con, "SELECT * FROM student_info WHERE student_id = '$student_id'");
    while($row = mysqli_fetch_array($query)){
      $firstname   = ucwords($row['firstname']);
      $middlename  = ucwords($row['middlename']);
      $lastname    = ucwords($row['lastname']);
      
    }

    //--------------------------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------------------------

    $query1 = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
    while($row1 = mysqli_fetch_array($query1)){
      $academic_id = $row1['academic_id'];

      $query2 = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE student_id = '$student_id' AND academic_id = '$academic_id'");
        while($row2 = mysqli_fetch_array($query2)){
          $enrollment_id   = $row2['enrollment_id'];
          $program_id      = $row2['program_id'];
          $student_section = $row2['student_section']; 

          $query3 = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                        while($row3 = mysqli_fetch_array($query3)){
                            $student_year_level = $row3['student_year_level'];   
                            $student_semester   = $row3['student_semester'];                                                   

                            if($student_year_level == 1){
                                $year_level = "1st Year";
                            }else if($student_year_level == 2){
                                $year_level = "2nd Year";
                            }else if($student_year_level == 3){
                                $year_level = "3rd Year";
                            }else if($student_year_level == 4){
                                $year_level = "4th Year";
                            }

                        }
        }
    }
?>

<!DOCTYPE html>
<html>

  <head>
      <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Student List </title>

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
       
    <!------SIDE NAV-------->
    <nav class="navbar-default navbar-static-side" role="navigation">
      <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
          
          <li class="nav-header">
            <?php include 'bootstrap_lower/side_name_logo.php'; ?>                   
          </li>

          <li>
              <a href="registrar_dashboard.php"><i class="fa fa-lg fa-home" aria-hidden="true"></i> <span class="nav-label">Home</span></a>
          </li>

          <li>
              <a href="registrar_manage_enrollment.php"><i class="fa fa-lg fa-address-book-o" aria-hidden="true"></i> <span class="nav-label">Enrollment</span></a>
          </li>

          <li class="active">
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
    <!-- No data found -->

    <div class="modal fade" id="no_data_found_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Print Error!</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <h2 style = "text-align:center; font-weight:bold; color:red;">No Data Found!</h2>
            <img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>

    <!--------------------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------------------->

    <!-- SUBJECT CREDITED Modal -->
    <div class="modal fade" id="subjects_credited_modal" role="dialog" >
      <div class="modal-dialog modal-lg" >
        <!-- Modal content-->
        <div class="modal-content" >
          <div class="modal-header">
              Subjects Credited <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
            <div class="modal-body">

              <div class = 'container-fluid'>
                <?php
                  include "admin_classes/config_mysqli.php";

                  $query = mysqli_query($con, "SELECT * FROM grades_report 
                  JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id
                  WHERE grades_report.remarks = 'CREDITED' AND grades_report.student_id = '$student_id'");
                    if(mysqli_num_rows($query)>0){

                      print "
                        <table class = 'table table-striped'>
                          <thead class='bg-success text-center'>
                            <th>Subject Code</th>
                            <th>Description</th>
                            <th>Unit</th>
                            <th>Action</th>
                          </thead>
                          <tbody>";

                      while($row = mysqli_fetch_array($query)){

                        //grades_report table
                        $grades_report_id     = $row['grades_report_id'];

                        //manage_subject table
                        $subject_id           = $row['subject_id'];
                        $subject_code         = $row['subject_code'];
                        $subject_description  = $row['subject_description'];
                        $subject_unit         = $row['subject_unit'];

                        print "
                          <tr class = 'text-center'>
                            <td>$subject_code</td>
                            <td>$subject_description </td>
                            <td>$subject_unit</td>
                            <td> 
                              <button type='button'
                              
                                id = 'delete_subjects_credited'
                                style = 'float:right;' 
                                class = 'btn btn-danger btn-xs' 
                                data-student='$student_id'
                                data-id='$grades_report_id'
                                data-toggle='modal' 
                                data-target = '#delete_confirm_modal'> <i class='fa fa-trash fa-lg' aria-hidden='true'></i> Delete </button>
                            </td>
                          </tr>";
                      }
                        
                      print "</tbody></table>";

                    }else{
                      print "<h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>";
                    }
                  
                ?>
              </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" style = "float:right;">Close</button>
            </div>
        </div>
      </div>
    </div>

    <!--------------------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------------------->

    <!-- Delete Confirmation Modal subjects credited-->
    <div class="modal fade" id="delete_confirm_modal" role="dialog" >
      <div class="modal-dialog" style = "width:300px;"> 
      <!-- Modal content-->
          <div class="modal-content" >
                  <div class="modal-header" style = "color:red;">
                      
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
              <div class="modal-body" style = "text-align:center;">
                  <form method = "POST" action = "admin_classes/delete_subjects_credited_script.php" id = "form_delete">    
                      <h6 style = "font-size:20px; font-weight:bold;"> Are you sure you want to permanently remove this data? </h6>  
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

    <!----HEADER----->
    <div id="page-wrapper" class="gray-bg">
      <?php include 'bootstrap_lower/header.php';?>

      <!----UNDER HEADER---->
      <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
          <div class="col-lg-10">
            <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Grades Report </p>

          </div>
      </div>

      <!------------------------------------------------------------------------------------------------------------------------>
      <!------------------------------------------------------------------------------------------------------------------------>
      <!---HIDDEN DATA--->
      <!---faculty_user_id--->
      <?php include "include/faculty_user_id.php"; ?>
 
      <!----DATA TABLES ONE------>
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox ">

              <!----TABLE SORTED----->
              <div class="ibox-content">
                <div class="table-responsive">

                  <div class = "container"><!-- start of container -->
                    <div class = "row">
                      <div class = "col-md-6">
                        <div class = "row">

                          <div class = "col-md-4">
                            <h4 style="font-weight: 350; margin-right: 15px;" class="text-dark">Student ID: </h4>
                          </div>
                          
                          <div class = "col-md-8">
                            <h3 style="font-size: 19px;"> <?php echo $student_id; ?> </h3>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div class = "row">
                      <div class = "col-md-6">
                        <div class = "row">

                          <div class = "col-md-4">
                          <h4 style="font-weight: 350; margin-right: 15px;">Student Name: </h4>  
                          </div>
                          
                          <div class = "col-md-8">
                          <h3 style="font-size: 15px;"> <?php print "$lastname, $firstname $middlename"; ?></h3>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div class = "row">
                      <div class = "col-md-6">
                        <div class = "row">

                          <div class = "col-md-4">
                            <h4 style="font-weight: 350; margin-right: 15px;">Course: </h4>
                          </div>
                          
                          <div class = "col-md-8">
                            <h3 style="font-size: 15px;"> 
                              <?php include 'admin_classes/config_mysqli.php';

                                if(isset($enrollment_id)){

                                  $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                  while($row_program = mysqli_fetch_array($query_program)){
                                    $program_code = $row_program['program_code'];

                                    print "$program_code - $student_year_level$student_section";
                                  }
                                  

                                }else{
                                  $query = mysqli_query($con, "SELECT * FROM student_info JOIN manage_curriculum
                                    ON student_info.curriculum_id = manage_curriculum.curriculum_id
                                    WHERE student_info.student_id = '$student_id'");

                                    while($row = mysqli_fetch_array($query)){
                                      $program_id = $row['program_id'];

                                      $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                      $row_program = mysqli_fetch_array($query_program);

                                      $program_code = $row_program['program_code'];

                                      print "$program_code";
                                    }
                                }

                              ?> 
                            </h3>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div class = "row">
                      <div class = "col-md-6">
                        <div class = "row">

                          <div class = "col-md-4">
                            <h4 style="font-weight: 350; margin-right: 15px;">Year Level: </h4>  
                          </div>
                          
                          <div class = "col-md-8">
                            <h3 style="font-size: 15px;">
                              <?php 
                                if(isset($enrollment_id)){
                                  print "$year_level";
                                }else{
                                  print "--";
                                }
                              ?></h3>
                          </div>

                        </div>
                      </div>
                    </div>

                    <div class = "row">
                      <div class = "col-md-12">
                        <div class = "row">

                          <div class = "col-md-2">
                            <h4 style="font-weight: 350; margin-right: 15px;">Academic Year: </h4>  
                          </div>
                          
                          <div class = "col-md-7">
                            <h3 style="font-size: 15px;">
                              <?php 
                                include 'admin_classes/config_mysqli.php';
                                $query_academic = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                                  while($row_academic = mysqli_fetch_array($query_academic)){
                                    $academic_year_from = $row_academic['academic_year_from'];
                                    $academic_year_to   = $row_academic['academic_year_to'];
                                    $academic_term      = $row_academic['academic_term'];

                                    print "$academic_year_from - $academic_year_to ($academic_term)";
                                  }
                              ?></h3>
                          </div>

                          <div class = "col-md-3">
                            <button type="button" 
                                    style = 'float:right;' 
                                    class = "btn btn-success btn-xs ml-2"
                                    id = 'print_btn'> 
                                    <i class="fa fa-print" aria-hidden="true"></i> Print</button>

                            <button type="button" 
                                    style = 'float:right;' 
                                    class = "btn btn-success btn-xs" 
                                    data-toggle="modal" 
                                    data-target="#subjects_credited_modal"> <i class="fa fa-list" aria-hidden="true"></i> Subjects Credited</button>

                                    
                                    
                          </div>

                        </div>
                      </div>
                    </div>
                  </div><!-- end of container -->

                  <hr>

                  <div class = "container"><!-- start of container -->
                    <div class = 'row'>
                      <div class = "col-md-12">
                      <div class = "row">
                        <div class = "col-md-2"></div>

                        <div class = "col-md-2">
                          <label><b>Year Level:</b></label>
                        </div>
                        <div class = "col-md-2">
                          <label><b>Term:</b></label>
                        </div>
                        <div class = "col-md-2">
                          <label><b>Period:</b></label>
                        </div>
                        <div class = "col-md-2">
                          <label><b>Program:</b></label>
                        </div>
                      </div>
                      </div>
                    </div>

                    <div class = "row">
                      <div class = "col-md-12">
                        <div class = "row">

                          <div class = "col-md-2">
                            <h4 style="font-weight: 350; margin-right: 15px;" class="text-dark">Filter Options: </h4>
                          </div>
                          
                          <!--------------------------------------------------------------------------------------------->
                          <!--------------------------------------------------------------------------------------------->
                          <!---YEAR LEVEL---->
                          <div class = "col-md-2">
                            <select class="form-control form-control-lg filter" id = 'year_level'> 
                              <?php 
                                if(isset($enrollment_id)){
                                  print "<option hidden value = '$student_year_level'>$year_level</option>";
                                }else{
                                  print "<option hidden value = '1'>1st Year</option>";
                                }
                              ?>
                              <option value = "1">1st Year</option>
                              <option value = "2">2nd Year</option>
                              <option value = "3">3rd Year</option>
                              <option value = "4">4th Year</option>
                            </select>
                          </div>

                          <!--------------------------------------------------------------------------------------------->
                          <!--------------------------------------------------------------------------------------------->
                           <!---TERM/SEMESTER---->
                          <div class = "col-md-2">
                            <select class="form-control form-control-lg filter" id = 'term'> 
                            <?php 
                                if(isset($enrollment_id)){
                                  print "<option hidden value = '$student_semester'>$student_semester</option>";
                                }else{
                                  print "<option hidden value = '1st Semester'>1st Semester</option>";
                                }
                              ?>
                              <option value = '1st Semester'>1st Semester</option>
                              <option value = '2nd Semester'>2nd Semester</option>
                            </select>
                          </div>

                          <!--------------------------------------------------------------------------------------------->
                          <!--------------------------------------------------------------------------------------------->
                          <!---PERIOD---->
                          <div class = "col-md-2">
                            <select class="form-control form-control-lg filter" id = 'period'> 
                              <option hidden value = 'Prelim'>Prelim</option>
                              <option value = 'Prelim'>Prelim</option>
                              <option value = 'Midterm'>Midterm</option>
                              <option value = 'Final'>Final</option>
                              <option value = 'Average'>Average</option>
                            </select>
                          </div>

                          <!--------------------------------------------------------------------------------------------->
                          <!--------------------------------------------------------------------------------------------->
                          <!---COURSE---->
                          <div class = "col-md-2">
                            <select class="form-control form-control-lg filter" id = 'program'> 

                              <!-- DEFAULT PROGRAM/COURSE -->
                              <?php
                                include "admin_classes/config_mysqli.php";
                                  $query = mysqli_query($con, "SELECT * FROM student_info 
                                    JOIN manage_curriculum ON student_info.curriculum_id = manage_curriculum.curriculum_id
                                    WHERE student_info.student_id = '$student_id'");
                                    
                                    while($row = mysqli_fetch_array($query)){
                                      //manage_curriculum
                                      $curriculum_id = $row['curriculum_id'];
                                      $program_id    = $row['program_id'];

                                      $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                      $row_program = mysqli_fetch_array($query_program);
                                        $program_id    = $row_program['program_id'];
                                        $program_code = $row_program['program_code'];

                                        print "<option hidden value = '$program_id'> $program_code</option>";
                                    }
                              ?>
                              
                              <?php 
                                include "admin_classes/config_mysqli.php";
                                $query = mysqli_query($con, "SELECT DISTINCT program_id FROM manage_enrollment 
                                                              WHERE student_id = '$student_id'");
                                  while($row = mysqli_fetch_array($query)){
                                    $program_id   = $row['program_id'];

                                    $query1 = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                    while($row1 = mysqli_fetch_array($query1)){
                                      $program_code        = $row1['program_code'];
                                      $program_description = $row1['program_description'];
                                    }
                                    
                                    print "<option value = '$program_id' title = '$program_description'>$program_code</option>";
                                }
                              ?>
                            </select>
                          </div>

                          <div class = "col-md-2" >
                            <button class = "btn btn-success btn-md" id = 'show_btn' style = 'float:right;'> <i class="fa fa-eye" aria-hidden="true"></i> Show</button>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                    
                  </div><!-- end of container -->
                  
                  <!--------------------------------------------------------------------------------------------->
                  <!--------------------------------------------------------------------------------------------->

                  <div id = 'grades_table' class = 'mt-4'>

                    <?php 

                      if(isset($enrollment_id)){
                        print "<h3 style = 'text-align:center;'>$year_level | $student_semester | Prelim </h3>";
                      }else{
                        print "<h3 style = 'text-align:center;'>1st Year | 1st Semester | Prelim </h3>";
                      }

                      print "
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

                          //-------------------------------------------------------------------------
                          //-------------------------------------------------------------------------
                          //-------------------------------------------------------------------------

                          if(isset($enrollment_id)){

                            $query4 = mysqli_query($con, "SELECT * FROM grades_report 
                              JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id 
                              WHERE grades_report.enrollment_id = '$enrollment_id'");

                       

                              while($row4 = mysqli_fetch_array($query4)){
                                
                                //manage_subject table
                                $subject_id           = $row4['subject_id'];
                                $subject_code         = $row4['subject_code'];
                                $subject_description  = $row4['subject_description'];
                                $subject_unit         = $row4['subject_unit'];

                                //grades_report table
                                $grades_report_id = $row4['grades_report_id'];
                                $prelim           = $row4['prelim'];
                                $grades_section   = $row4['grades_section'];
                                $remarks          = $row4['remarks'];


                                print "<tr class='text-center'>";

                                //-------------------------------------------------------------------------
                                //-------------------------------------------------------------------------
                                
                                print "
                                    <td >$subject_code</td>
                                    <td >$subject_description</td>
                                    <td >$subject_unit</td>";
                                //-------------------------------------------------------------------------
                                //-------------------------------------------------------------------------

                                // checks if there is a teacher aasigned to this subject and section
                                $query_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                                JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
                                WHERE teacher_subject_load.subject_id = '$subject_id'
                                AND teacher_subject_load.subject_section = '$grades_section'
                                AND teacher_subject_load.academic_id = '$academic_id'");

                                if(mysqli_num_rows($query_teacher_schedule)>0){
                                  $row_teacher = mysqli_fetch_array($query_teacher_schedule);

                                    //teacher name
                                    $account_firstname  = ucwords($row_teacher['account_firstname']);
                                    $account_lastname  = ucwords($row_teacher['account_lastname']);

                                    print "<td>$account_firstname $account_lastname</td>";

                                }else if($remarks == "Credited"){
                                  print "<td >--</td>";

                                }else{
                                    print "<td><span class='badge badge-secondary'>No teacher yet</span></td>";
                                }

                                //-------------------------------------------------------------------------
                                //-------------------------------------------------------------------------

                                $rounded_ave = round($prelim,0,PHP_ROUND_HALF_EVEN);

                                    if($remarks == "Credited"){
                                      print "<td >--</td>";
                                      print "<td ><span class='badge badge-success'>Credited</span></td>";

                                    }else if($prelim == 0){
                                      print "<td >--</td>";
                                      print "<td ><span class='badge badge-secondary'>No grades yet</span></td>";

                                    }else if($rounded_ave >= 75){
                                      print "<td >$prelim</td>";
                                      print "<td ><span class='badge badge-primary'>Passed</span></td>";

                                    }else if($rounded_ave < 75){
                                      print "<td >$prelim</td>";
                                      print "<td ><span class='badge badge-danger'>Failed</span></td>";
                                    }
                                //-------------------------------------------------------------------------
                                //-------------------------------------------------------------------------

                                print "</tr>";
                              }

                          //-------------------------------------------------------------------------
                          //-------------------------------------------------------------------------
                          //-------------------------------------------------------------------------
                          }else{

                            $query5 = mysqli_query($con, "SELECT * FROM grades_report 
                              JOIN manage_enrollment ON grades_report.enrollment_id = manage_enrollment.enrollment_id 
                              JOIN manage_subject ON grades_report.subject_id = manage_subject.subject_id 
                              WHERE grades_report.student_id = '$student_id'
                              AND manage_enrollment.student_year_level = 1");

                            while($row5 = mysqli_fetch_array($query5)){
                              //manage_subject table
                              $subject_id           = $row5['subject_id'];
                              $subject_code         = $row5['subject_code'];
                              $subject_description  = $row5['subject_description'];
                              $subject_unit         = $row5['subject_unit'];

                              //grades_report table
                              $grades_report_id = $row5['grades_report_id'];
                              $prelim           = $row5['prelim'];
                              $grades_section   = $row5['grades_section'];
                              $remarks          = $row5['remarks'];

                              print "<tr class='text-center'>";

                              //-----------------------------------------------------------------------------------------
                              //-----------------------------------------------------------------------------------------

                              print"
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td>$subject_unit</td>"; 

                              //-----------------------------------------------------------------------------------------
                              //-----------------------------------------------------------------------------------------
                              //Teacher column

                              $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE student_id = '$student_id' 
                              AND student_year_level = 1");
                              while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                                $academic_id     = $row_enrollment['academic_id'];
                                //$student_section = $row_enrollment['student_section'];
                              

                                $query_teacher_schedule = mysqli_query($con, "SELECT * FROM teacher_subject_load 
                                  JOIN faculty_account ON faculty_account.account_user_id = teacher_subject_load.account_user_id 
                                  WHERE teacher_subject_load.subject_id = '$subject_id'
                                  AND teacher_subject_load.subject_section = '$grades_section'
                                  AND teacher_subject_load.academic_id = '$academic_id'");

                                  if(mysqli_num_rows($query_teacher_schedule)>0){
                                    $row_teacher = mysqli_fetch_array($query_teacher_schedule);

                                      //teacher name
                                      $account_firstname  = ucwords($row_teacher['account_firstname']);
                                      $account_lastname   = ucwords($row_teacher['account_lastname']);

                                      print "<td>$account_firstname $account_lastname</td>";

                                  }else if($remarks == "Credited"){
                                    print "<td >--</td>";

                                  }else{
                                      print "<td><span class='badge badge-secondary'>No teacher yet</span></td>";
                                  }
                              }

                              //-----------------------------------------------------------------------------------------
                              //-----------------------------------------------------------------------------------------

                              $rounded_ave = round($prelim,0,PHP_ROUND_HALF_EVEN);

                              if($remarks == "Credited"){
                                print "<td >--</td>";
                                print "<td ><span class='badge badge-success'>Credited</span></td>";
                              }else if($prelim == 0){
                                print "<td >--</td>";
                                print "<td ><span class='badge badge-secondary'>No grades yet</span></td>";

                              }else if($rounded_ave >= 75){
                                print "<td >$prelim</td>";
                                print "<td ><span class='badge badge-primary'>Passed</span></td>";

                              }else if($rounded_ave < 75){
                                print "<td >$prelim</td>";
                                print "<td ><span class='badge badge-danger'>Failed</span></td>";
                              }
                              //-----------------------------------------------------------------------------------------
                              //-----------------------------------------------------------------------------------------

                              print "</tr>";

                            } 

                          }

                          print "</tbody> </table>";
                            
                    ?>
                      
                  </div>
                  
                </div>
              </div><!----TABLE SORTED---->

            </div>
          </div>
        </div>
      </div>
      <?php include 'bootstrap_lower/lower.php'; ?>
      </div>
      
    </div>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!---HIDDEN---------->
<input type = 'text' value = '<?php echo $student_id ?>' id = 'student_id' hidden>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!---SCRIPT---------->

<script>
  $(document).ready(function(){

    $('#show_btn').click(function(){

      var year_level    = $('#year_level').val();
      var term          = $('#term').val();
      var period        = $('#period').val();
      var program       = $('#program').val();
      var student_id    = $('#student_id').val();
      

      var filter        = $('.filter').val();

      if(year_level == "" && term == "" && period == "" && program == ""){
        
        $('#year_level').css("border", "1px solid red");
        $('#term').css("border", "1px solid red");
        $('#period').css("border", "1px solid red");
        $('#program').css("border", "1px solid red");

      }else if(year_level == ""){
        $('#year_level').css("border", "1px solid red");
        $('#term').removeAttr("style");
        $('#period').removeAttr("style");
        $('#program').removeAttr("style");

      }else if(term == ""){
        $('#term').css("border", "1px solid red");
        $('#year_level').removeAttr("style");
        $('#period').removeAttr("style");
        $('#program').removeAttr("style");

      }else if(period == ""){
        $('#period').css("border", "1px solid red")
        $('#year_level').removeAttr("style");
        $('#term').removeAttr("style");
        $('#program').removeAttr("style");

      }else if(program == ""){
        $('#program').css("border", "1px solid red")
        $('#year_level').removeAttr("style");
        $('#term').removeAttr("style");
        $('#period').removeAttr("style");
        
      }else{
        $('.filter').removeAttr("style");

        $.ajax({
          url: 'admin_classes/show_student_grades_report.php',
          type: 'POST',
          data: {
            year_level  :year_level,
            term        :term,
            period      :period,
            program     :program,
            student_id  :student_id
          },
          success: function(response){ 
              // Add response in Modal body
              $('#grades_table').html(response);
          }
        });
        
      }
    
    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->

<!-- DELETE SUBJECT CREDITED -->
<script>
  $(document).ready(function(){
    $(document).on("click","#delete_subjects_credited", function (){ 

        var faculty_user_id   = $('#account_user_id').val();
        var student_id        = $(this).data('student');
        var grades_report_id  = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/delete_subjects_credited_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id   :faculty_user_id,
            student_id        :student_id,
            grades_report_id  :grades_report_id
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

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!--PRINT-->

<script>
  $(document).ready(function(){
    $("#print_btn").click(function(){

      var student_id      = $("#student_id").val();
      var faculty_user_id = $('#account_user_id').val();

      var year_level      = $("#year_level").val();
      var term            = $("#term").val();
      var period          = $("#period").val();
      var program_id      = $("#program").val();

      $.ajax({
        url: "print/print_grades_report_ajax.php",
        type: "POST",
        data: {
            faculty_user_id  :faculty_user_id,
            student_id       :student_id,
            year_level       :year_level,
            term             :term,
            period           :period,
            program_id       :program_id
        },
        cache: false,
        success: function(dataResult){
            var dataResult = JSON.parse(dataResult);
            if(dataResult.statusCode==200){
              $("#no_data_found_modal").modal('show');  
            }else if(dataResult.statusCode==201){
              window.open("print/print_grades_report.php?student_id="+student_id+"&faculty="+faculty_user_id+"&year_level="+year_level+"&term="+term+"&period="+period+"&program_id="+program_id, "_blank");					
              
              
                //$('#empty').html('Department Code or Description already exists!'); 
                //$('#empty').effect("shake");                                 
                
            }   
        }
      });
    });
  });
</script>

</body>
</html>

