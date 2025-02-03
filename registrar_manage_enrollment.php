<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_registrar.php";
?>

<!DOCTYPE html>
    <html>

    <head>
        <title> <?php include'bootstrap_lower/title_header.php'; ?> | Enrollment </title>

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

        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->

        <!-- Update Modal -->
        <div class="modal fade" id="update_modal" role="dialog" >
          <div class="modal-dialog modal-md" >
            <!-- Modal content-->
            <div class="modal-content" >
              <div class="modal-header">
                <div class="modal-title" ><h4>Update Enrolled Student Information</h4></div>
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

        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->

        <!-- Delete Modal -->
        <div class="modal fade" id="delete_modal" role="dialog" >
          <div class="modal-dialog" style = "width:300px;"> 
          <!-- Modal content-->
              <div class="modal-content" >
                      <div class="modal-header" style = "color:red;">
                          
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                  <div class="modal-body" style = "text-align:center;">
                      <form method = "POST" action = "admin_classes/delete_enrolled_student_script.php" id = "form_delete">
                          
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

        <!----HEADER-------->
        <div id="page-wrapper" class="gray-bg">
          <?php include 'bootstrap_lower/header.php';?>

          <!----UNDER HEADER----->
          <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
            <div class="col-lg-10">
              <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Enrolled Student </p>
            </div>
          </div>

          <!------------------------------------------------------------------------------------------------------------------------>
          <!------------------------------------------------------------------------------------------------------------------------>
          <!---HIDDEN DATA--->
          <!---faculty_user_id--->
          <?php include "include/faculty_user_id.php"; ?>

          <!----DATA TABLES ONE-------->
          <div class="wrapper wrapper-content animated fadeInRight" >
            <div class="row">
              <div class="col-lg-12">
                <div class="ibox ">
                  <div class="ibox-title">
                    <span>Academic Year: </span>

                    <h3> 
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
                    </h3> 

                    <div class="ibox-tools">
                      <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#student_type"><i class="fa fa-plus fa-lg" aria-hidden="true"></i> Enroll Student </button>

                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!-- Type of Student Modal -->

                      <div class="modal fade" id="student_type" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h3 class="modal-title" id="exampleModalLabel">Student Type</h3>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                                      
                              <div class = "col-md">
                                <a href = "reg_manage_enrollment_new_student.php">
                                  <button type="button" class="btn btn-outline-primary btn-block btn-lg rounded-pill" id = "new_student_btn"><b>New Student</b></button>
                                </a>
                              </div>
                              
                              <div class = "col-md">
                                <a href = "reg_manage_enrollment_old_student.php">
                                  <button type="button" class="btn btn-outline-primary btn-block btn-lg rounded-pill" id = "old_student_btn"><b>Old Student</b></button>
                                </a>
                              </div>  
               
                                                      
                              <div class = "col-md">
                                <a href = "reg_manage_enrollment_returnee.php">
                                  <button type="button" class="btn btn-outline-primary btn-block btn-lg rounded-pill" id = "returnee_btn"><b>Returnee</b></button>
                                </a>
                              </div>

                              <div class = "col-md">
                                <a href = "reg_manage_enrollment_transferee.php">
                                  <button type="button" class="btn btn-outline-primary btn-block btn-lg rounded-pill" id = "transferee_btn"><b>Transferee</b></button>
                                </a>
                              </div>
                                                        
                              <div class = "col-md">
                                <a href = "reg_manage_enrollment_shiftee.php">
                                  <button type="button" class="btn btn-outline-primary btn-block btn-lg rounded-pill" id = "shiftee_btn"><b>Shiftee</b></button>
                                </a>
                              </div>

                              <div class = "col-md">
                                <a href = "reg_manage_enrollment_cross_enrollee.php">
                                  <button type="button" class="btn btn-outline-primary btn-block btn-lg rounded-pill" id = "shiftee_btn"><b>Cross Enrollee</b></button>
                                </a>
                              </div>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>

                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!--Course and Section filter Modal -->
                  <div class="modal fade" id="course_section_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Select Course and Section</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">

                          <div class = "row">
                            <div class = "col-sm-12">
                              
                              <select class="form-control form-control-lg" id = 'filter_course'>
                                <option value = '' hidden>Select Course...</option>
                                <?php 
                                  include 'admin_classes/config_mysqli.php';
                                  $query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_status = 1");

                                  while($row = mysqli_fetch_array($query)){
                                    $program_id    = $row['program_id'];
                                    $program_code  = $row['program_code'];

                                    print "<option value = '$program_id'>$program_code</option>";
                                  }                                
                                ?>
                              </select>
                            </div>
                            <div class = "col-sm-12 mt-3">
                              
                              <select class="form-control form-control-lg" id = 'filter_year_level'>
                                <option value = '' hidden>Select Year Level...</option>
                                <option value = "1">1st Year</option>
                                <option value = "2">2nd Year</option>
                                <option value = "3">3rd Year</option>
                                <option value = "4">4th Year</option>
                              </select>
                            </div>
                            <div class = "col-sm-12 mt-3">
                              
                              <select class="form-control form-control-lg" id = 'filter_section'>
                                <option value = '' hidden>Select Section...</option>
                                <option value = "A">A</option>
                                <option value = "B">B</option>
                                <option value = "C">C</option>
                                <option value = "D">D</option>
                                <option value = "E">E</option>
                              </select>
                            </div>
                          </div> 

                          <br><div style = 'color:red; font-weight:bold; text-align:center;' id = 'filter_course_section_error'></div>
                          

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" id = 'filter_course_section_show_btn'>Show</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!--Year Level filter Modal -->
                  <div class="modal fade" id="year_level_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Select Year Level</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class = "col-sm-12 mt-3">                            
                            <select class="form-control form-control-lg" id = 'filter_year_level_only'>
                              <option value = '' hidden>Select Year Level...</option>
                              <option value = "1">1st Year</option>
                              <option value = "2">2nd Year</option>
                              <option value = "3">3rd Year</option>
                              <option value = "4">4th Year</option>
                            </select>
                          </div>

                          <br><div style = 'color:red; font-weight:bold; text-align:center;' id = 'filter_year_level_error'></div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" id = 'filter_year_level_show_btn'>Show</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!--Status filter Modal -->
                  <div class="modal fade" id="status_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Select Student Status</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">

                          <div class = "row">
                            <div class = "col-sm">
                              <label>Student Status</label>
                              <select class="form-control form-control-lg" id = 'filter_status'>
                                <option value = '' hidden>Select Status...</option>
                                <option value = "Regular">Regular</option>
                                <option value = "Irregular">Irregular</option>
                              </select>
                            </div>
                          </div>

                          <br><div style = 'color:red; font-weight:bold; text-align:center;' id = 'filter_status_error'></div>

                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" id = 'filter_status_show_btn'>Show</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!--Type filter Modal -->
                  <div class="modal fade" id="type_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Select Student Type</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">

                          <div class = "row">
                            <div class = "col-sm">
                              <label>Student Type</label>
                              <select class="form-control form-control-lg" id = 'filter_type'>
                                <option value = '' hidden>Select Type...</option>
                                <option value = "New Student">New Student</option>
                                <option value = "Old Student">Old Student</option>
                                <option value = "Returnee">Returnee</option>
                                <option value = "Transferee">Transferee</option>
                                <option value = "Shiftee">Shiftee</option>
                              </select>
                            </div>
                          </div>

                          <br><div style = 'color:red; font-weight:bold; text-align:center;' id = 'filter_type_error'></div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary" id = 'filter_type_show_btn'>Show</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!---------------------------------------------------------------------------------------------------------------------------->

                  <!----TABLE SORTED-------->
                  <div class="ibox-content" >
                    <div class="table-responsive" style = 'overflow:hidden;'>

                    <!--------------------------------------------------------------------------------------------------------------------->
                          <!--------------------------------------------------------------------------------------------------------------------->
                          <!--- Deleted Department -->
                          <?php 
                              if(isset($_GET['deleted'])){

                                $fullname      = $_GET['fullname'];
                                $academic_year = $_GET['academic_year'];

                                    print("
                                        <div class = 'alert alert-danger alert-dismissible alert-sm'>
                                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                            <span><b>$fullname</b> has been removed from academic year <b>$academic_year</b></span>
                                        </div>"
                                    );
                                
                            }
                            ?>

                      <div class="alert alert-warning" role="alert">
                        <i class="fa fa-info-circle" aria-hidden="true"></i><b> Note: </b> The number of rows for the students shown below is limited to 50. To see more, please use the <b>search box</b> or <b>filter options</b>.
                      </div>
                         
                        <div class = "row">
                          <div class = "col-md-3">
                            <input class="form-control" type="search" id="search" placeholder="Search student.." aria-label="Search">
                          </div>

                          <div class = "col-md-6"></div>

                          <div class = "col-md-3">
                            <div class="btn-group" style = 'float:right;'>
                              <button class="btn btn-success btn-lg dropdown-toggle" id = 'filter_options' type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filter Options
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" id = 'course_section' data-toggle="modal" data-target="#course_section_modal">Course & Section</a>
                                <!--<a class="dropdown-item" href="#" id = 'year_level' data-toggle="modal" data-target="#year_level_modal">Year Level</a>
                                <a class="dropdown-item" href="#" id = 'status' data-toggle="modal" data-target="#status_modal">Status</a>
                                <a class="dropdown-item" href="#" id = 'type' data-toggle="modal" data-target="#type_modal">Type</a> -->

                              </div>
                            </div>
                          </div>
                        </div>
                      
                      
                      <hr>

                      <div id = 'table_data'>
                      <table class="table table-striped" style = "margin-bottom:100px;">
                        <thead class="bg-success text-center">
                          <th > Student ID </th>
                          <th > Lastname </th>
                          <th > Firstname </th>
                          <th > Middlename</th>
                          <th > Course & Section </th>
                          <th > Status </th>
                          <th > Type </th>
                          <th > Action </th>
                        </thead>

                        <tbody class='text-center'>

                          <?php 
                            include 'admin_classes/config_mysqli.php';
                              $query = mysqli_query($con, "SELECT * FROM manage_enrollment
                                                            JOIN academic_year ON manage_enrollment.academic_id = academic_year.academic_id
                                                            JOIN manage_program ON manage_enrollment.program_id = manage_program.program_id
                                                            WHERE academic_year.academic_status = 1
                                                            ORDER BY manage_enrollment.student_section ASC,
                                                                      manage_enrollment.student_lastname ASC, 
                                                                      manage_enrollment.student_year_level ASC LIMIT 50");

                                while($row = mysqli_fetch_array($query)){
                                  $enrollment_id         = $row['enrollment_id'];
                                  $student_id            = $row['student_id'];
                                  $student_lastname      = ucwords($row['student_lastname']);
                                  $student_firstname     = ucwords($row['student_firstname']);
                                  $student_middlename    = ucwords($row['student_middlename']);
                                  $program_code          = $row['program_code'];
                                  $student_section       = $row['student_section'];
                                  $student_year_level    = $row['student_year_level'];
                                  $student_status        = $row['student_status'];
                                  $student_type          = $row['student_type'];

                                  print "

                                  <tr>
                                    <td> $student_id </td>
                                    <td> $student_lastname </td>
                                    <td> $student_firstname </td>
                                    <td> $student_middlename </td>
                                    <td> $program_code - $student_year_level$student_section</td>  
                                    <td> $student_status </td>
                                    <td> $student_type </td>

                                    <td >

                                    <div class='dropdown dropleft'>
                                        <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                            Action 
                                        </button>
  
                                          <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                            <a class='dropdown-item' href='#' data-id='$enrollment_id' data-toggle='modal' data-target = '#update_modal' id = 'update'><i class='fa fa-pencil fa-fw'></i> Update </a>
                                            <a class='dropdown-item' href='#' data-id='$enrollment_id' data-toggle='modal' data-target = '#delete_modal' id = 'delete'><i class='fa fa-trash fa-fw'></i> Delete </a>
                                            <a class='dropdown-item' href='registrar_student_evaluation.php?enrollment_id=$enrollment_id' ><i class='fa fa-pencil-square-o fa-fw'></i> Load Subject </a>
                     
                                          </div> 
                                       
                                      </div>

                                    </td>
                                  </tr>
                                ";

                                }
                          ?>

                          
                        </tbody>
                      </table>
                      </div>

                    </div>
                  </div>

                </div>
              </div>
            </div>

          </div>
            <?php include 'bootstrap_lower/lower.php'; ?>
        </div>
<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!---HIDDEN DATA---->
<?php
  include 'admin_classes/config_mysqli.php';
  $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
  while($row_academic = mysqli_fetch_array($query)){
    $academic_id = $row_academic['academic_id'];

    print "<input type = 'text' id = 'academic_id' value = '$academic_id' hidden>";
  }
?>
<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->



<!-- LIVE SEARCH -->
<script>
    $(document).ready(function(){
      $('#search').keyup(function(){
        var search_student = $(this).val();
      
          $.ajax({
            url:"admin_classes/search_enrolled_student.php",
            method:"POST",
            data:{
              search_student:search_student
            },
            success:function(response){
                $('#table_data').html(response);
            }
          });
        
      });
    });
</script>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->

<script>
    $(document).ready(function(){
      $(document).on("click",".dropdown-item", function (){ 
        
          var enrollment_id = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/update_enrolled_student_form.php',
            type: 'POST',
            data: {
              enrollment_id:enrollment_id
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
      $('#update_btn').click(function(){

      var faculty_user_id    = $('#account_user_id').val();
      var enrollment_id      = $('#enrollment_id').val();

      var student_id         = $('#student_id').val();
      var new_firstname      = $('#new_firstname').val();
      var new_middlename     = $('#new_middlename').val();
      var new_lastname       = $('#new_lastname').val();
      var new_name_extension = $('#new_name_extension').val();
      
      var new_student_status      = $('#new_student_status').val();
      var new_student_year_level  = $('#new_student_year_level').val();
      var new_student_section     = $('#new_student_section').val();
      var new_student_type        = $('#new_student_type').val();


        if(new_firstname          == '' || 
          new_middlename          == '' || 
          new_lastname            == '' ||
          new_student_status      == '' ||
          new_student_year_level  == '' ||
          new_student_section     == '' ||
          new_student_type        == ''   ){       
          
          $('#error').html('Invalid Attempt! Please enter a value!');
          $('#error').show();   
          $('#error').effect('shake');

        }else{

          $.ajax({
            url: "admin_classes/update_enrolled_student_ajax.php",
            type: "POST",
            data: {

              faculty_user_id        :faculty_user_id,
              enrollment_id          :enrollment_id,
              student_id             :student_id,  
              new_firstname          :new_firstname,   
              new_middlename         :new_middlename,  
              new_lastname           :new_lastname,
              new_name_extension     :new_name_extension,
              new_student_status     :new_student_status,
              new_student_year_level :new_student_year_level,
              new_student_section    :new_student_section,
              new_student_type       :new_student_type
   
            },
            cache: false,
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    window.location = "registrar_manage_enrollment.php?updated";						
                }else if(dataResult.statusCode==201){
                   
                  $("#error").show();  
                  $('#error').html('Updating student information failed!'); 
                  $('#error').effect("shake");                                 
                   
                }   
            }
          });
        }
      
      });   
    });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- DELETE  -->
<script>
  $(document).ready(function(){
    $(document).on("click",".dropdown-item", function (){ 

      var faculty_user_id    = $('#account_user_id').val();
      var enrollment_id = $(this).data('id');

        // AJAX request
        $.ajax({
          url: 'admin_classes/delete_enrolled_student_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            enrollment_id   :enrollment_id
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

<script>
  $(document).ready(function(){
    $('#filter_options').click(function(){

      $('#filter_course_section_error').hide();
      $('#filter_year_level_error').hide();
      $('#filter_status_error').hide();
      $('#filter_type_error').hide();
      
      $('#filter_course').val('');
      $('#filter_year_level').val('');
      $('#filter_section').val('');

      $('#filter_year_level_only').val('');
      $('#filter_status').val('');
      $('#filter_type').val('');
      
    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!---FILTER COURSE AND SECTION--->
<script>
  $(document).ready(function(){
    
    $('#filter_course_section_show_btn').click(function(){
      var program_id = $('#filter_course').val();
      var year_level = $('#filter_year_level').val();
      var section    = $('#filter_section').val();

      if(program_id == "" || year_level == "" || section == ""){
        $('#filter_course_section_error').show();
        $('#filter_course_section_error').html('Invalid Attempt! Please try again!');
        $('#filter_course_section_error').effect('shake');
      }else{
        $('#course_section_modal').modal('toggle');

        $.ajax({
          url: 'admin_classes/filter_course_section.php',
          type: 'POST',
          data: {
            program_id  :program_id,
            year_level  :year_level,
            section     :section
            },
          success: function(response){ 
              // Add response in Modal body
              $('#table_data').html(response);
          }
        });
      }

    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!---FILTER YEAR LEVEL--->
<script>
  $(document).ready(function(){
    
    $('#filter_year_level_show_btn').click(function(){
      var year_level = $('#filter_year_level_only').val();

      if(year_level == ""){
        $('#filter_year_level_error').show();
        $('#filter_year_level_error').html('Invalid Attempt! Please try again!');
        $('#filter_year_level_error').effect('shake');
      }else{
        $('#year_level_modal').modal('toggle');

        $.ajax({
          url: 'admin_classes/filter_year_level.php',
          type: 'POST',
          data: {
            year_level  :year_level,
            },
          success: function(response){ 
              // Add response in Modal body
              $('#table_data').html(response);
          }
        });
      }

    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!---FILTER STATUS--->
<script>
  $(document).ready(function(){
    
    $('#filter_status_show_btn').click(function(){
      var status = $('#filter_status').val();

      if(status == ""){
        $('#filter_status_error').show();
        $('#filter_status_error').html('Invalid Attempt! Please try again!');
        $('#filter_status_error').effect('shake');
      }else{
        $('#status_modal').modal('toggle');

        $.ajax({
          url: 'admin_classes/filter_status.php',
          type: 'POST',
          data: {
            status  :status,
            },
          success: function(response){ 
              // Add response in Modal body
              $('#table_data').html(response);
          }
        });
      }

    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!---FILTER TYPE--->
<script>
  $(document).ready(function(){
    
    $('#filter_type_show_btn').click(function(){
      var type = $('#filter_type').val();

      if(type == ""){
        $('#filter_type_error').show();
        $('#filter_type_error').html('Invalid Attempt! Please try again!');
        $('#filter_type_error').effect('shake');
      }else{
        $('#type_modal').modal('toggle');

        $.ajax({
          url: 'admin_classes/filter_type.php',
          type: 'POST',
          data: {
            type  :type,
            },
          success: function(response){ 
              // Add response in Modal body
              $('#table_data').html(response);
          }
        });
      }

    });
  });
</script>


  </body>
</html>
