<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_registrar.php";
?>

<?php  

include 'admin_classes/config_mysqli.php';

$account_user_id = $_GET['account_user_id'];

$query1 = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_user_id = '$account_user_id'");
while($row1 = mysqli_fetch_array($query1)){
  $teacher_user_id = $row1['account_user_id']; 
  $teacher_firstname = $row1['account_firstname'];
  $teacher_lastname = $row1['account_lastname'];
  $teacher_position = $row1['account_position'];
  $teacher_status = $row1['account_status'];

}

$query2 = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
while($row2 = mysqli_fetch_array($query2)){
  $academic_id = $row2['academic_id'];
  $academic_year_from = $row2['academic_year_from'];
  $academic_year_to = $row2['academic_year_to'];
  $academic_term = $row2['academic_term'];
}

?>

<!DOCTYPE html>
<html>


<head>
    <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Schedule </title>

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
       
      <!------SIDE NAV--------->
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

            <li>
              <a href="registrar_student_record.php"><i class="fa fa-lg fa-address-card" aria-hidden="true"></i> <span class="nav-label">Student Record</span></a>
            </li> 

            <li class="active">
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
      <!------SIDE NAV-------->

      <!----HEADER------>
      <div id="page-wrapper" class="gray-bg">
        <?php include 'bootstrap_lower/header.php';?>
      <!----HEADER------>

          <!----UNDER HEADER---->
          <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
            <div class="col-lg-10">
              <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Teacher Schedule </p>
            </div>
          </div>
          <!----UNDER HEADER---->

          <!---------------------------------------------------------------------------------------------------------------------------->
          <!---------------------------------------------------------------------------------------------------------------------------->
          <!-- Error modal / Already enrolled in current academic year -->

          <div class="modal fade" id="enrolled_error_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Error!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <h2 style = "text-align:center; font-weight:bold; color:red;">ERROR!</h2>

                  <h3 style = "text-align:center;" id = 'error_msg'></h3>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <!---------------------------------------------------------------------------------------------------------------------------->
          <!---------------------------------------------------------------------------------------------------------------------------->

          <!-- Delete  Modal -->
          <div class="modal fade" id="delete_modal" role="dialog" >
            <div class="modal-dialog" style = "width:300px;"> 
              <!-- Modal content-->
              <div class="modal-content" >
                <div class="modal-header" style = "color:red;">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body" style = "text-align:center;">
                  <form method = "POST" action = "admin_classes/delete_teacher_schedule_script.php" id = "form_delete">
                    <h6 style = "font-size:20px; font-weight:bold;"> Are you sure you want to remove this schedule? </h6>  
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

          <!---------------------------------------------------------------------------------------------------------------------------->
          <!---------------------------------------------------------------------------------------------------------------------------->

          <!--update modal --->
          <div class="modal inmodal fade" id="update_modal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog pt-reduced pb-reduced " >
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title"> Update Teacher Schedule </h5>
                </div>

                <div class="modal-body">

                  <div id = "update_info"></div>

                  <br><div style = "text-align:center; color:red; font-weight:bold" id = "error_update"></div> 
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-light btn-sm border-secondary" data-dismiss="modal"> Cancel </button>
                  <button type="button" class="btn btn-success btn-sm border-secondary" id="update_btn"> Update </button>
                </div>

              </div>
            </div>
          </div>

          <!---------------------------------------------------------------------------------------------------------------------------->
          <!---------------------------------------------------------------------------------------------------------------------------->
              
          <!----DATA TABLES ONE---->
          <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
              <div class="col-lg-12">
                <div class="ibox ">

                  <div class="ibox-content">
                    <div class="table-responsive">

               

                      <!-----NEW TABLE---->
                      <h4 class="text-center">: : :  TEACHER TIME & SCHEDULE  : : :</h4>

                      <div class = "container"> <!-- start of container -->

                        <div class = "row">
                          <div class = "col-md-6">
                            <div class = "row">

                              <div class = "col-md-4">
                                <h4 style="font-weight: 350; margin-right: 15px;" class="text-dark">ID Number: </h4>
                              </div>
                              
                              <div class = "col-md-8">
                                <h3 style="font-size: 19px;"> <?php echo "$teacher_user_id"; ?> </h3>
                              </div>

                            </div>
                          </div>
                        </div>

                        <div class = "row">
                          <div class = "col-md-6">
                            <div class = "row">

                              <div class = "col-md-4">
                              <h4 style="font-weight: 350; margin-right: 15px;">Teachers Name: </h4>  
                              </div>
                              
                              <div class = "col-md-8">
                              <h3 style="font-size: 15px;"> <?php echo "$teacher_firstname $teacher_lastname"; ?>
                              </div>

                            </div>
                          </div>
                        </div>

                        <div class = "row">
                          <div class = "col-md-6">
                            <div class = "row">

                              <div class = "col-md-4">
                                <h4 style="font-weight: 350; margin-right: 15px;">Position: </h4>
                              </div>
                              
                              <div class = "col-md-8">
                                <h3 style="font-size: 15px;"> <?php echo "$teacher_position"; ?> </h3>
                              </div>

                            </div>
                          </div>
                        </div>

                        <div class = "row">
                          <div class = "col-md-6">
                            <div class = "row">

                              <div class = "col-md-4">
                                <h4 style="font-weight: 350; margin-right: 15px;">Academic Year: </h4>  
                              </div>
                              
                              <div class = "col-md-8">
                                <h3 style="font-size: 15px;"> <?php echo "$academic_year_from - $academic_year_to"; ?>
                              </div>

                            </div>
                          </div>
                        </div>

                        <div class = "row">
                          <div class = "col-md-6">
                            <div class = "row">

                              <div class = "col-md-4">
                                <h4 style="font-weight: 350; margin-right: 15px;">Academic Term: </h4>  
                              </div>
                              
                              <div class = "col-md-8">
                                <h3 style="font-size: 15px;"> <?php echo "$academic_term"; ?>
                              </div>

                            </div>
                          </div>

                          <div class = "col-md-6" >
                            <div class = "row" style = "float:right;">
                                <button type="button" style = "margin:5px;" class="btn btn-success btn-xs" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo" id = "load_subject"> <i class="fa fa-plus fa-lg" aria-hidden="true"></i> Load Subject</button> 
                                <a href="print/print_schedule.php?teacher_user_id=<?php echo $teacher_user_id; ?>&registrar_user_id=<?php echo $_SESSION['registrar_user_id'];?>&academic_id=<?php echo $academic_id ?>" target="_blank" class="btn btn-xs btn-success" style = "margin:5px;"> <i class="fa fa-print" aria-hidden="true"> </i> Print</a> 
                            </div>
                          </div>
                        </div>

                      </div> <!-- end of container -->

                      <br>

                      <hr style="margin-top: -15px;">

                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!--- Deleted Alert -->
                      <?php 
                        if(isset($_GET['deleted'])){
                          print("
                            <div class = 'alert alert-danger alert-dismissible alert-sm'>
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                              <i class='fa fa-exclamation-circle'></i> <span> Subject time schedule has been deleted successfully!</span>
                            </div>"
                          );  
                        }
                      ?> 

                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!--- Deleted Alert -->
                      <?php 
                        if(isset($_GET['added'])){
                          print("
                            <div class = 'alert alert-success alert-dismissible alert-sm'>
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                              <i class='fa fa-exclamation-circle'></i> <span> Subject time schedule has been added successfully!</span>
                            </div>"
                          );  
                        }
                      ?> 

                      <!----TABLE----->
                      <table class="table table-striped" >
                        <thead class="bg-success text-center">
                          <th >SUBJECT CODE</th>
                          <th >SUBJECT DESCRIPTION</th>
                          <th >UNIT</th>
                          <th >TIME</th>
                          <th >DAY</th>
                          <th >ROOM</th>
                          <th >Course & Section</th>
                          
                          <th >ACTION</th>
                        </thead>

                          <?php
                            include 'admin_classes/config_mysqli.php';

                            $teacher_user_id = $_GET['account_user_id'];

                            $query = mysqli_query($con, "SELECT DISTINCT subject_id, subject_section FROM teacher_subject_load WHERE account_user_id = '$teacher_user_id' 
                                                          AND academic_id = '$academic_id' ORDER BY day_initial ASC");

                              while($row = mysqli_fetch_array($query)){
                                $subject_id       = $row['subject_id'];
                                $subject_section  = $row['subject_section'];

                                print "<tr class ='text-center'>";

                                //---------------------------------------------------------------------------------------------------------------------------->
                                //---------------------------------------------------------------------------------------------------------------------------->
                                
                                $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
                                while($row_subject = mysqli_fetch_array($query_subject)){

                                  $subject_code           = $row_subject['subject_code'];
                                  $subject_description    = $row_subject['subject_description'];
                                  $subject_unit           = $row_subject['subject_unit'];

                                  print "<td style = 'vertical-align:middle;'>$subject_code</td>";
                                  print "<td style = 'vertical-align:middle;'>$subject_description</td>";
                                  print "<td style = 'vertical-align:middle;'>$subject_unit</td>";
                                  
                                }

                                //---------------------------------------------------------------------------------------------------------------------------->
                                //---------------------------------------------------------------------------------------------------------------------------->
                               
                                print "<td style = 'vertical-align:middle;'>";  //time
                                  $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                                AND subject_section = '$subject_section' 
                                                                AND academic_id = '$academic_id'
                                                                AND account_user_id = '$teacher_user_id'
                                                                ORDER BY day_initial ASC");
                                  while($row1 = mysqli_fetch_array($query1)){

                                    $subject_time_from     = $row1['subject_time_from'];
                                    $subject_time_to       = $row1['subject_time_to'];
                                    $time_from             = date("g:ia", strtotime($subject_time_from));
                                    $time_to               = date("g:ia", strtotime($subject_time_to));

                                    print "$time_from - $time_to<br><br>";
                                  }
                                print "</td>"; //end of time

                                //---------------------------------------------------------------------------------------------------------------------------->
                                //---------------------------------------------------------------------------------------------------------------------------->
                               
                                print "<td style = 'vertical-align:middle;'>";  //day
                                  $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                                AND subject_section = '$subject_section' 
                                                                AND academic_id = '$academic_id'
                                                                AND account_user_id = '$teacher_user_id'
                                                                ORDER BY day_initial ASC");
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
                                
                                print "<td style = 'vertical-align:middle;'>"; //room
                                $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                              AND subject_section = '$subject_section' 
                                                              AND academic_id = '$academic_id'
                                                              AND account_user_id = '$teacher_user_id'
                                                              ORDER BY day_initial ASC");
                                  while($row1 = mysqli_fetch_array($query1)){

                                    $subject_room  = $row1['subject_room'];

                                    print "$subject_room <br><br>";
                                  }
                                print "</td>"; //end of room

                                //---------------------------------------------------------------------------------------------------------------------------->
                                //---------------------------------------------------------------------------------------------------------------------------->
                               
                                print "<td style = 'vertical-align:middle;'>"; //course and section
                                $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                              AND subject_section = '$subject_section' 
                                                              AND academic_id = '$academic_id'
                                                              AND account_user_id = '$teacher_user_id'
                                                              ORDER BY day_initial ASC");
                                                              
                                  while($row1 = mysqli_fetch_array($query1)){

                                    $program_id          = $row1['program_id'];
                                    $subject_section     = $row1['subject_section'];
                                    $subject_year_level  = $row1['subject_year_level_teacher'];

                                    $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                    $row_program = mysqli_fetch_array($query_program);
                                      
                                      $program_code = $row_program['program_code'];

                                    print "$program_code - $subject_year_level$subject_section<br><br>";

                                  }
                                  
                                print "</td>"; //end of course and section

                                //---------------------------------------------------------------------------------------------------------------------------->
                                //---------------------------------------------------------------------------------------------------------------------------->
                                print "<td style = 'vertical-align:middle;'>"; //action
                                $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                              AND subject_section = '$subject_section' 
                                                              AND academic_id = '$academic_id'
                                                              AND account_user_id = '$teacher_user_id'
                                                              ORDER BY day_initial ASC");
                                  while($row1 = mysqli_fetch_array($query1)){

                                    $subject_load_id  = $row1['subject_load_id'];
                                    $teacher_user_id  = $row1['account_user_id'];

                                    print "<div class='dropdown dropleft mb-2'>
                                            <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Action 
                                            </button>

                                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                              
                                              <a class='dropdown-item' href = '' data-id='$subject_load_id' data-user='$teacher_user_id' data-toggle='modal' data-target = '#update_modal'> <i class='fa fa-pencil fa-fw'></i>Update</a>
                                              <a class='dropdown-item' href = '' data-id='$subject_load_id' data-user='$teacher_user_id' data-toggle='modal' data-target = '#delete_modal'> <i class='fa fa-trash fa-fw'></i> Delete</a>
                                              
                                            </div> 
                                          </div>";
                                    }
                                print "</td>"; //end of action

                                //---------------------------------------------------------------------------------------------------------------------------->
                                //---------------------------------------------------------------------------------------------------------------------------->

                                print "</tr>";
                               


                              }
                                

                            

                            
                          ?>
                      </table>

                      <hr>

                    

                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->

                      <!--MODAL FOR ADNEW --->
                      <div class="modal inmodal fade" id="exampleModal" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog pt-reduced pb-reduced " >
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title"> Schedule Registration </h5>
                            </div>

                            <div class="modal-body">

                            <form action = "admin_classes/reg_teacher_scheduler_load_insert.php" method = "POST">

                              <!------------------------------------------------------------------------------------------------------------------------>
                              <!------------------------------------------------------------------------------------------------------------------------>
                              <!---faculty_user_id--->
                              <?php include "include/faculty_user_id.php"; ?>

                              <!------------------------------------------------------------------------------------------------------------------------>
                              <!------------------------------------------------------------------------------------------------------------------------>

                              <div class="row mt-2">
                                <div class="col-sm">
                                    <label class="text-dark" style="font-weight: bold;" >DEPARTMENT</label>
                                    <select class="form-control border border-secondary rounded input-sm select" id="select_department" name="select_department">

                                      <option value="" hidden>Select Department</option>
                                        <?php
                                        
                                        include 'admin_classes/config_mysqli.php';
                                          $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_status = 1");
                                            while($row = mysqli_fetch_array($query)){
                                              $department_id = $row['department_id'];
                                              $department_code = $row['department_code'];
                                              $department_description = $row['department_description'];

                                              print "<option value='$department_id'>$department_code: $department_description</option>";
                                            }
                                        
                                        ?>
                                      
                                    </select> 
                                </div>
                              </div>

                              <div id = "curriculum_list">
                                <div class="row mt-2">
                                  <div class="col-sm">
                                      <label class="text-dark" style="font-weight: bold;" >CURRICULUM</label>
                                      <select class="form-control border border-secondary rounded input-sm" id="">
                                        <option value="" hidden>Select Curriculum</option>

                                        
                                      </select> 
                                  </div> 
                                </div>
                              </div>

                              <div class="row mt-2">
                                <div class="col-md-6">
                                  <label class="text-dark" style="font-weight: bold;" >Year Level</label>
                                  
                                    <select class="form-control border border-secondary rounded input-sm select" id="subject_year_level" name="subject_year_level">
                                      <option value="" hidden>Select Year Level</option>
                                      <option value="1" >1st Year</option>
                                      <option value="2" >2nd Year</option>
                                      <option value="3" >3rd Year</option>
                                      <option value="4" >4th Year</option>
                                    </select>    
                                </div>

                                <div class="col-md-6">
                                  <label class="text-dark" style="font-weight: bold;" >Semester</label>
                                  
                                    <select class="form-control border border-secondary rounded input-sm select" id="subject_semester" name="subject_semester">
                                      <option value="" hidden>Select Semester</option>
                                      <option value="<?php echo $academic_term; ?>" ><?php echo $academic_term; ?></option>
                                    </select> 
                                </div>
                              </div>

                              <hr>

                              <!-- retrieves subject list base on curriculum, year level and semester -->
                              <div id = "subject_list">
                                <div class="row mt-2">
                                  <div class="col-sm">
                                  
                                    <label class="text-dark" style="font-weight: bold;" >SUBJECT TITLE</label>
                                    
                                        <select class="form-control border border-secondary rounded input-sm">
                                          <option value="0" hidden>Select Subject</option>
                                        </select>
                                        
                                  </div>
                                </div>
                              </div>

                              <div class="row mt-4">
                                <div class="col-sm">
                                  <label class="text-dark" style="font-weight: bold;" >DAY</label> 
                                  <table class = 'table table-borderless'>
                                    <tbody>
                                      <tr>
                                        <td><input class='checkbox_value' name = 'checkbox_value[]' type='checkbox' value = '1Mon'> Monday</td>
                                        <td><input class='checkbox_value' name = 'checkbox_value[]' type='checkbox' value = '2Tue'> Tuesday</td>
                                      </tr>
                                      <tr>
                                        <td><input class='checkbox_value' name = 'checkbox_value[]' type='checkbox' value = '3Wed'> Wednesday</td>
                                        <td><input class='checkbox_value' name = 'checkbox_value[]' type='checkbox' value = '4Thu'> Thursday</td>
                                      </tr>
                                      <tr>
                                        <td><input class='checkbox_value' name = 'checkbox_value[]' type='checkbox' value = '5Fri'> Friday</td>
                                        <td><input class='checkbox_value' name = 'checkbox_value[]' type='checkbox' value = '6Sat'> Saturday</td>
                                      </tr>
                                    </tbody>
                                  </table>
                                   
                                </div>
                              </div>

                              <div class="row mt-4">
                                <div class="col-md-6">
                                    <label class="text-dark" style="font-weight: bold;" >TIME-FROM</label>
                                    <input type="time" class="form-control border border-secondary rounded input-sm" id="subject_time_from" name="subject_time_from">        
                                </div> 

                                <div class="col-md-6">
                                    <label class="text-dark" style="font-weight: bold;" >TIME-TO</label>
                                    <input type="time" class="form-control border border-secondary rounded input-sm" id="subject_time_to" name="subject_time_to">  
                                </div>  
                              </div>

                              <div class="row mt-2">   
                                <div class="col-md-6">
                                  <label class="text-dark" style="font-weight: bold;" >SECTION</label>

                                    <select class="form-control border border-secondary rounded input-sm" id="subject_section" name="subject_section">
                                      <option value="" hidden>Select Section</option>
                                      <option value="A">A</option>
                                      <option value="B">B</option>
                                      <option value="C">C</option>
                                      <option value="D">D</option>
                                      <option value="E">E</option>
                                    </select>  
                                </div> 

                                <div class="col-md-6">
                                  <label class="text-dark" style="font-weight: bold;" >ROOM</label>
                                  <input type="text" class="form-control border border-secondary rounded input-sm" id="subject_room" name="subject_room">            
                                </div>
                              </div>

                              <hr>

                            <div style = "text-align:center; color:red; font-weight:bold" id = "error"></div> <br>

                              

                              <!-- FOOTER -->
                              </div>
                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-success btn-sm border-secondary" name = 'save_btn' id="save_btn"> Save </button>
                                  <button type="button" class="btn btn-light btn-sm border-secondary" data-dismiss="modal"> Cancel </button>
                                </div>
                              </div>

                            </div>

                            <!---------------------------------------------------------------------------------------------------------------------------->
                            <!---------------------------------------------------------------------------------------------------------------------------->
                            <!-- Hidden data -->
                            <input type = "text" 
                                  value = "<?php 
                                            include 'admin_classes/config_mysqli.php';
                                            $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                                            while($row = mysqli_fetch_array($query)){
                                              $academic_id = $row['academic_id'];
                                              echo "$academic_id";
                                            }
                                          ?>" hidden id = "academic_id" name = "academic_id">

                            <input type = "text" 
                                  value = "<?php 
                                            echo $_GET['account_user_id'];
                                          ?>" hidden id = "teacher_user_id" name = "teacher_user_id">

                            <input type = "text" 
                                  value = "<?php 
                                            echo $account_user_id;
                                          ?>" hidden id = "faculty_user_id" name = "faculty_user_id">

                          </form>

                          </div>
                        </div>
                      </div>

                </div>
              </div>
            </div>
          </div>
    
        <?php include 'bootstrap_lower/lower.php'; ?>
        </div>


<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!--shake effect on error -->
<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- Clears load subject form 

<script>
  $(document).ready(function() {
    $('#load_subject').click(function(){
      $('#subject_curriculum').val('');
      $('#subject_year_level').val('');
      $('#subject_semester').val('');

      $('#subject_title').val('');
      $('#subject_day').val('');
      $('#subject_time_from').val('');
      $('#subject_time_to').val('');
      $('#subject_section').val('');
      $('#subject_room').val('');

    });
  });
</script>-->

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- Retrieve the curriculum list base on the choices on select tag -->

<script>
  $(document).ready(function() {
    $('#select_department').change(function(){
      var department_id = $('#select_department').val();
      $('#subject_year_level').val('');
      $('#subject_semester').val('');

          $.ajax({
              url: "admin_classes/get_curriculum_list.php",
              method: "POST",
              data: { 
                
                  department_id: department_id

                },
              success:function(data){
                  $('#curriculum_list').html(data);
              }
         
      });
    });
  });
</script> 

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- Retrieve the subject list base on the choices on select tag -->

<script>
  $(document).ready(function() {
    $(document).on('change', '.select', function(){
      var curriculum_id = $('#subject_curriculum').val();
        var subject_year_level = $('#subject_year_level').val();
          var subject_semester = $('#subject_semester').val();
            var department_id = $('#select_department').val();

          $.ajax({
              url: "admin_classes/get_subject_list.php",
              method: "POST",
              data: { 
                
                curriculum_id: curriculum_id,
                subject_year_level: subject_year_level,
                subject_semester: subject_semester,
                department_id: department_id

                },
              success:function(data){
                  $('#subject_list').html(data);
              }         
      });
    });
  });
</script> 

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- Add Subject 

<script type="text/javascript">
    $(document).ready(function(){
        $('#save_btn').click(function(){

          //var select_department = $('#select_department').val();
          var subject_curriculum = $('#subject_curriculum').val();
          var subject_year_level = $('#subject_year_level').val();
          var subject_semester = $('#subject_semester').val();

          var subject_title = $('#subject_title').val();
          var subject_day = $('#subject_day').val();
          var subject_time_from = $('#subject_time_from').val();
          var subject_time_to = $('#subject_time_to').val();
          var subject_section = $('#subject_section').val();
          var subject_room = $('#subject_room').val();

          //hidden data
          var academic_id = $('#academic_id').val();
          var teacher_user_id = $('#teacher_user_id').val();        

          if(subject_curriculum == "" ||
            subject_year_level == "" || 
            subject_semester == "" ||
            subject_title == "" ||
            subject_day == "" ||
            subject_time_from == "" ||
            subject_time_to == "" ||
            subject_section == "" ||
            subject_room == ""
            ){
        
            $('#error').show();
            $('#error').html('Invalid Attempt! Please fill up the form.');
            $('#error').effect('shake');

          }else{
            
            $.ajax({
              url: "admin_classes/reg_teacher_scheduler_load_insert.php",
              type: "POST",
              data: {

                subject_curriculum:  subject_curriculum,
                subject_year_level: subject_year_level,
                subject_semester: subject_semester,
                subject_title: subject_title,
                subject_day: subject_day,
                subject_time_from: subject_time_from,
                subject_time_to: subject_time_to,
                subject_section: subject_section,
                subject_room: subject_room,
                academic_id: academic_id,
                teacher_user_id: teacher_user_id

              },
              cache: false,
              success: function(dataResult){
                  var dataResult = JSON.parse(dataResult);
                  if(dataResult.statusCode==200){
                      window.location = "registrar_teacher_scheduler_load.php?added&account_user_id=<?php //echo "$teacher_user_id" ?>";	

                  }else if(dataResult.statusCode==201){
                    
                    $("#error").show();  
                    $('#error').html('Scheduled time has already been taken!'); 
                    $('#error').effect('shake');                                 
                    
                  }else if(dataResult.statusCode==202){
                    
                    $("#error").show();  
                    $('#error').html('Invalid time schedule! Please try again!'); 
                    $('#error').effect('shake');  

                  }else if(dataResult.statusCode==205){
                
                    $("#error").show();  
                    $('#error').html('Subject has already assigned to a teacher on that section!'); 
                    $('#error').effect('shake');                               
                    
                  }else if(dataResult.statusCode==203){
                    
                    $("#error").show();  
                    $('#error').html('Conflict time schedule! Please try again!'); 
                    $('#error').effect('shake');                                 
                    
                  }else if(dataResult.statusCode==204){
                    
                    $("#error").show();  
                    $('#error').html('Room and time schedule already taken!'); 
                    $('#error').effect('shake');                                 
                    
                  }   
              }
            });

          }
     
        });
    });

</script>-->

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- DELETE  -->
<script>
  $(document).ready(function(){
      $('.dropdown-item').click(function(){

        var faculty_user_id = $('#account_user_id').val();
        var subject_load_id = $(this).data('id');
        var account_user_id = $(this).data('user');

      // AJAX request
          $.ajax({
          url: 'admin_classes/delete_teacher_schedule_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            subject_load_id :subject_load_id,
            account_user_id :account_user_id
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


<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- UPDATE  -->

<script>
    $(document).ready(function(){
        $('#update').click(function(){      
          $('#error_update').hide();
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('.dropdown-item').click(function(){
        
          var subject_load_id = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/update_teacher_schedule_form.php',
            type: 'POST',
            data: {
              subject_load_id:subject_load_id
            },
            success: function(response){ 
                // Add response in Modal body
                $('#update_info').html(response);
            }
            });
        });
    });
</script>

<!-- FORM UPDATE -->
<script>
    $(document).ready(function(){
      $('#update_btn').click(function(){

      var faculty_user_id        = $('#account_user_id').val();
      var teacher_user_id        = $('#teacher_user_id').val();
      var academic_id            = $('#academic_id').val();
      var subject_load_id        = $('#subject_load_id').val();

      var new_subject_day        = $('#new_subject_day').val();
      var new_subject_time_from  = $('#new_subject_time_from').val();
      var new_subject_time_to    = $('#new_subject_time_to').val();
      var new_subject_section    = $('#new_subject_section').val();
      var new_subject_room       = $('#new_subject_room').val();

      var curriculum_id               = $('#curriculum_id').val();
      var subject_year_level_teacher  = $('#subject_year_level_teacher').val();
      var subject_id                  = $('#subject_id').val();

      if(new_subject_day       == '' || 
        new_subject_time_from  == '' ||
        new_subject_time_to    == '' ||
        new_subject_section    == '' ||
        new_subject_room       == ''   ){       
          
          $('#error_update').html('Invalid Attempt! Please enter a value!');
          $('#error_update').show();   
          $('#error_update').effect('shake');
        }else{

          $.ajax({
            url: "admin_classes/update_teacher_schedule_load_ajax.php",
            type: "POST",
            data: {

              faculty_user_id            :faculty_user_id,
              teacher_user_id            :teacher_user_id,
              academic_id                :academic_id,
              subject_load_id            :subject_load_id,
              new_subject_day            :new_subject_day,
              new_subject_time_from      :new_subject_time_from,
              new_subject_time_to        :new_subject_time_to,
              new_subject_section        :new_subject_section,
              new_subject_room           :new_subject_room,
              curriculum_id              :curriculum_id,
              subject_year_level_teacher :subject_year_level_teacher,
              subject_id                 :subject_id
            },
            cache: false,
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    window.location = "registrar_teacher_scheduler_load.php?updated&account_user_id=<?php echo $teacher_user_id ?>";						
                }else if(dataResult.statusCode==201){
                   
                  $("#error_update").show();  
                  $('#error_update').html('Scheduled time has already been taken!'); 
                  $('#error_update').effect("shake");                                 
                   
                }else if(dataResult.statusCode==202){
                   
                   $("#error_update").show();  
                   $('#error_update').html('Invalid time schedule! Please try again!'); 
                   $('#error_update').effect("shake"); 

                  }else if(dataResult.statusCode==205){
                
                $("#error_update").show();  
                $('#error_update').html('Subject has already assigned to a teacher on that section!'); 
                $('#error_update').effect('shake');     

                 }else if(dataResult.statusCode==203){
                   
                   $("#error_update").show();  
                   $('#error_update').html('Conflict time schedule! Please try again!'); 
                   $('#error_update').effect("shake");                                 
                    
                 }else if(dataResult.statusCode==204){
                   
                   $("#error_update").show();  
                   $('#error_update').html('Room and time schedule already taken!'); 
                   $('#error_update').effect("shake");                                 
                    
                 }        
            }
          });
        }
      
      });   
    });
</script>


<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<?php
  if(isset($_GET['error_101'])){
    print"
      <script>
        $(document).ready(function(){
          $('#enrolled_error_modal').modal('show');
          $('#error_msg').html('Scheduled time has already been taken!');
        });
      </script>
    ";

  }else if(isset($_GET['error_102'])){
    print"
      <script>
        $(document).ready(function(){
          $('#enrolled_error_modal').modal('show');
          $('#error_msg').html('Invalid time schedule! Please try again!');
        });
      </script>
    ";

  }else if(isset($_GET['error_103'])){
    print"
      <script>
        $(document).ready(function(){
          $('#enrolled_error_modal').modal('show');
          $('#error_msg').html('Subject has already assigned to a teacher on that section!');
        });
      </script>
    ";

  }else if(isset($_GET['error_104'])){
    print"
      <script>
        $(document).ready(function(){
          $('#enrolled_error_modal').modal('show');
          $('#error_msg').html('Conflict time schedule! Please try again!');
        });
      </script>
    ";

  }else if(isset($_GET['error_105'])){
    print"
      <script>
        $(document).ready(function(){
          $('#enrolled_error_modal').modal('show');
          $('#error_msg').html('Room and time schedule already take!');
        });
      </script>
    ";

  }
?>



</body>
</html>
