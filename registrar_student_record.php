<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_registrar.php";
?>

<!DOCTYPE html>
<html>

  <head>
      <title> <?php include'bootstrap_lower/title_header.php'; ?> | Student List </title>

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

  

    <!--------------------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------------------->

    <!-- VIEW INFO Modal -->
    <div class="modal fade" id="student_info" role="dialog" >
      <div class="modal-dialog modal-md" >
        <!-- Modal content-->
        <div class="modal-content" >
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
            <div class="modal-body">

              <div id = "table_data">
                
              </div>
              
              <button type="button" class="btn btn-secondary" data-dismiss="modal" style = "float:right;">Close</button>
            </div>
            <div class="modal-footer">
            </div>
        </div>
      </div>
    </div>

    <!--------------------------------------------------------------------------------------------------------------------->
    <!--------------------------------------------------------------------------------------------------------------------->

    <!-- Update Modal -->
    <div class="modal fade" id="update_modal" role="dialog" >
      <div class="modal-dialog modal-xl" >
        <!-- Modal content-->
        <div class="modal-content" >
          <div class="modal-header">
            <div class="modal-title" ><h4>Update Student Information</h4></div>
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

    <!-- reset_password -->
    <div class="modal fade" id="reset_password_modal" role="dialog" >
      <div class="modal-dialog" style = "width:400px;"> 
      <!-- Modal content-->
        <div class="modal-content" >
            <div class="modal-header" style = "color:red;">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style = "text-align:center;">
              <form method = "POST" action = "admin_classes/reset_password_student_script.php" id = "form_reset_password">
                  <h3> Are you sure you want to reset the password back to default on </h3>  
                  <div class = "reset_password_info" ></div>
              </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id = "reset_btn">Reset</button>
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
            <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Student List </p>

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
                <div class="table-responsive" style = 'overflow:hidden;'>

          <?php
            include 'admin_classes/config_mysqli.php';
            $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
              while($row = mysqli_fetch_array($query)){
                $academic_id          = $row['academic_id'];
                $academic_year_from   = $row['academic_year_from'];
                $academic_year_to     = $row['academic_year_to'];
                $academic_term        = $row['academic_term'];
              }
          ?>

          <h4>Academic Year:</h4>
          <h3 style = 'font-weight:bold;'> <?php print "$academic_year_from - $academic_year_to ($academic_term)";  ?> </h3>
        <hr>
    
                    <br>

                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--- Updated -->
                    <?php   
                      if(isset($_GET['updated'])){

                        print("
                          <div class = 'alert alert-primary alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span> <i class='fa fa-exclamation-circle'></i> Student's information has been updated succesfully!</span>
                          </div>"
                        );
                      }
                    ?> 

                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--- Password Reset -->
                    <?php   
                      if(isset($_GET['password_reset'])){

                        print("
                          <div class = 'alert alert-primary alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span> <i class='fa fa-exclamation-circle'></i> Password has been updated back to default succesfully!</span>
                          </div>"
                        );
                      }
                    ?> 

                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--------------------------------------------------------------------------------------------------------------------->

                    <div class="alert alert-warning" role="alert">
                        <i class="fa fa-info-circle" aria-hidden="true"></i><b> Note: </b> The number of rows for the students shown below is limited to 50. To see more, please use the <b>search box</b>.
                      </div>
                          
                        <div class = "row">
                          <div class = "col-md-3">
                            <input class="form-control" type="search" id="search" placeholder="Search student.." aria-label="Search">
                          </div>

                          <div class = "col-md-6"></div>

                          <div class = "col-md-3">
                            <!--<div class="btn-group" style = 'float:right;'>
                              <button class="btn btn-success btn-lg dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Filter Options
                              </button>
                              <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" id = 'course_section' data-toggle="modal" data-target="#course_section_modal">Enrolled</a>
                                <a class="dropdown-item" href="#" id = 'year_level' data-toggle="modal" data-target="#year_level_modal">Not enrolled</a>
                              </div>
                            </div>-->
                          </div>
                        </div>
                      

                    <div id = "student_record_table">
                    <table class="mt-2 table table-striped" style = "margin-bottom:100px;">
                      <thead class="bg-success text-center">
                        <th > STUDENT ID </th>
                        <th > LAST NAME </th>
                        <th > FIRST NAME </th>
                        <th > MIDDLE NAME</th>
                        <th > COURSE </th>
                        <th > STATUS </th>
                        <th > ACTION </th>
                      </thead>

                        <tbody class='text-center';>

                          <?php
                            include 'admin_classes/config_mysqli.php';
                            $query = mysqli_query($con, "SELECT * FROM student_info ORDER BY lastname LIMIT 50");
                              while($row = mysqli_fetch_array($query)){
                                $student_id = $row['student_id'];
                                $firstname  = ucwords($row['firstname']);
                                $middlename = ucwords($row['middlename']);
                                $lastname   = ucwords($row['lastname']);

                                $curriculum_id = $row['curriculum_id'];
                                $query_program = mysqli_query($con, "SELECT * FROM manage_curriculum JOIN manage_program 
                                  ON manage_curriculum.program_id = manage_program.program_id
                                  WHERE manage_curriculum.curriculum_id = '$curriculum_id'");

                                  while($row_program = mysqli_fetch_array($query_program)){
                                    $program_code        = $row_program['program_code'];
                                    $program_description = $row_program['program_description'];

                                    print "
                                      <tr>
                                        <td>$student_id</td>
                                        <td>$lastname</td>
                                        <td>$firstname</td>
                                        <td>$middlename</td>
                                        <td title = '$program_description'>$program_code</td>";

                                          $query_academic = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                                          while($row_academic = mysqli_fetch_array($query_academic)){
                                            $academic_id = $row_academic['academic_id'];
                                          
                                            $query_enroll = mysqli_query($con,"SELECT * FROM manage_enrollment WHERE academic_id = '$academic_id' AND student_id = '$student_id'");
                                            
                                            if(mysqli_num_rows($query_enroll)>0){
                                              print "
                                                <td>
                                                  <span class='badge badge-primary'>Enrolled</span>
                                                </td>
                                              ";

                                            }else{
                                              print "
                                                <td>
                                                  <span class='badge badge-secondary'>Not enrolled</span>
                                                </td>
                                              ";

                                            }
                                          }
                                        
                              
                                    print "
                                        <td>
                                          <div class='dropdown dropleft'>
                                            <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                Action 
                                            </button>

                                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                              <a class='dropdown-item' href='' data-id='$student_id' data-toggle='modal' data-target = '#student_info' id = 'view_info'><i class='fa fa-eye fa-fw'></i>View Info</a>
                                              <a class='dropdown-item' href='' data-id='$student_id' data-toggle='modal' data-target = '#update_modal' id = 'update'><i class='fa fa-pencil fa-fw'></i>Update</a>
                                              <a class='dropdown-item' href='registrar_student_grades_report.php?student_id=$student_id' id = 'grades_report'><i class='fa fa-list-ul'></i> Grades Report</a>
                                              <a class='dropdown-item' href='' data-id='$student_id' data-toggle='modal' data-target = '#reset_password_modal' id = 'reset_password'><i class='fa fa-refresh fa-fw'></i>Reset Password</a>
                                            </div> 
                                          </div>  
                                        </td>
                                      </tr>";

                                  }

                                
                              }
                          ?>

                        </tbody>
                    </table> 
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
<!---SCRIPT----------------------------------------------->

<!-----DATA TABLE SCRIPT----->

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

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->

<script>
    $(document).ready(function(){
      $(document).on("click",".dropdown-item", function (){ 
        
          var student_id = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/show_student_info.php',
            type: 'POST',
            data: {
              student_id:student_id
            },
            success: function(response){ 
                // Add response in Modal body
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
        
          var student_id = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/update_student_info_form.php',
            type: 'POST',
            data: {
              student_id:student_id
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

      var student_id         = $('#student_id').val();
      var new_firstname      = $('#new_firstname').val();
      var new_middlename     = $('#new_middlename').val();
      var new_lastname       = $('#new_lastname').val();
      var new_name_extension = $('#new_name_extension').val();
      var new_address        = $('#new_address').val();
      var new_birthdate      = $('#new_birthdate').val();
      var new_birthplace     = $('#new_birthplace').val();
      var new_gender         = $('#new_gender').val();
      var new_civil_status   = $('#new_civil_status').val();
      var new_citizenship    = $('#new_citizenship').val();
      var new_religion       = $('#new_religion').val();
      var new_phone_number   = $('#new_phone_number').val();
      var new_email          = $('#new_email').val();

        if(new_firstname     == '' || 
          new_middlename     == '' || 
          new_lastname       == '' ||
          new_address        == '' ||
          new_birthdate      == '' ||
          new_birthplace     == '' ||
          new_gender         == '' ||
          new_civil_status   == '' ||
          new_citizenship    == '' ||
          new_religion       == '' ||
          new_phone_number   == '' ||
          new_email          == ''){       
          
          $('#error').html('Invalid Attempt! Please enter a value!');
          $('#error').show();   
          $('#error').effect('shake');

        }else{

          $.ajax({
            url: "admin_classes/update_student_info_ajax.php",
            type: "POST",
            data: {

              faculty_user_id     :faculty_user_id,
              student_id          :student_id,  
              new_firstname       :new_firstname,   
              new_middlename      :new_middlename,  
              new_lastname        :new_lastname,
              new_name_extension  :new_name_extension,
              new_address         :new_address,
              new_birthdate       :new_birthdate,
              new_birthplace      :new_birthplace,
              new_gender          :new_gender,
              new_civil_status    :new_civil_status,
              new_citizenship     :new_citizenship,
              new_religion        :new_religion,
              new_phone_number    :new_phone_number,
              new_email           :new_email
            },
            cache: false,
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    window.location = "registrar_student_record.php?updated";						
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

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->

<!-- RESET PASSWORD -->
<script>
  $(document).ready(function(){
    $(document).on("click",".dropdown-item", function (){ 

        var faculty_user_id = $('#account_user_id').val();
        var student_id      = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/reset_password_student_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            student_id      :student_id
            },
          success: function(response){ 
              // Add response in Modal body
              $('.reset_password_info').html(response);
          }
          });
      });
  });
</script> 

  <script>
  $(document).ready(function(){
    $('#reset_btn').click(function(){
      $('#form_reset_password').submit();
    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->

<!-- LIVE SEARCH -->
<script>
    $(document).ready(function(){
      $('#search').keyup(function(){
        var search_student = $(this).val();
      
          $.ajax({
            url:"admin_classes/search_student_record.php",
            method:"POST",
            data:{
              search_student:search_student
            },
            success:function(response){
                $('#student_record_table').html(response);
            }
          });
      });
    });
</script>

</body>
</html>
