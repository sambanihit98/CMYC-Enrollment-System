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

        <!----HEADER-------->
        <div id="page-wrapper" class="gray-bg">
          <?php include 'bootstrap_lower/header.php';?>

          <!----UNDER HEADER----->
          <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
            <div class="col-lg-10">
              <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Enroll Student  </p>
            </div>
          </div>

          <!---------------------------------------------------------------------------------------------------------------------------->
          <!---------------------------------------------------------------------------------------------------------------------------->
          <!---HIDDEN DATA--->
          <!---faculty_user_id--->
          <?php include "include/faculty_user_id.php"; ?>

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
                            <p style = 'font-weight: bold; font-size: 15px; vertical-align: middle;'>Cross Enrollee</p>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="ibox-tools">

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
                      <!-- Error modal / Duplicate data -->

                      <div class="modal fade" id="duplicate_error_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

                              <h3 style = "text-align:center;">Student information already exist!</h3>
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

                      <!-- 1st row -->
                      <div class = "row">
                        

                        <div class="col-md-4">
                          <label class="text-dark" style="font-weight: bold;" >DEPARTMENT</label>
                            <select class="form-control border border-secondary rounded input-sm select" name="" id="select_department">
                              <option value="" hidden>Department</option>
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

             
                          <div class="col-md-4">
                            <div id = "program_list"> <!-- realtime retrieval -->
                              <label class="text-dark" style="font-weight: bold;" >COURSE</label>
                                <select class="form-control border border-secondary rounded input-sm select" id = "program">
                                  <option value="" hidden>Course</option>
                                  
                                </select>
                            </div> 
                          </div> 
                        

                        <div class="col-md-4">
                          <div id = "curriculum_list"> <!-- realtime retrieval -->
                            <label class="text-dark" style="font-weight: bold;" >CURRICULUM</label>
                              <select class="form-control border border-secondary rounded input-sm" id = "curriculum">
                                <option value="" hidden>Curriculum</option>
                                
                              </select>
                          </div>
                        </div> 
                        
                      </div><!-- end of 1st Row -->

                      <div class = "row mt-4">

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >STATUS</label>
                            <select class="form-control border border-secondary rounded input-sm" name="" id="student_status">
                              <option value="" hidden>Status</option>
                              <option value="Regular"> Regular </option>
                              <option value="Irregular"> Irregular </option>
                            </select>
                        </div> 

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold" >SEMESTER</label>
                            <select class="form-control border border-secondary rounded input-sm" name="" id="student_semester">
                              <option value="" hidden> Semester </option>
                                <?php
                                  include 'admin_classes/config_mysqli.php';
                                    $query_academic = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                                    while($row_academic = mysqli_fetch_array($query_academic)){
                                      $academic_term =$row_academic['academic_term'];

                                      print "<option value='$academic_term'> $academic_term </option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >YEAR LEVEL</label>
                            <select class="form-control border border-secondary rounded input-sm" name="" id="student_year_level">
                              <option value="" hidden>Year-Level</option>
                              <option value="1"> 1st Year </option>
                              <option value="2"> 2nd Year </option>
                              <option value="3"> 3rd Year </option>
                              <option value="4"> 4th Year </option>
                            </select>
                        </div>

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >SECTION</label>
                            <select class="form-control border border-secondary rounded input-sm" name="" id="student_section">
                              <option value="" hidden>Section</option>
                              <option value="A"> A </option>
                              <option value="B"> B </option>
                              <option value="C"> C </option>
                              <option value="D"> D </option>
                              <option value="D"> E </option>
                            </select>
                        </div>

                        
                      </div>

                      <hr>

                      <!-- 2nd Row -->
                      <div class="row mt-4" >
                        <div class="col-md" >
                          <label  class="text-dark" style="font-weight: bold" >SURNAME</label>
                          <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="lastname"  >
                        </div>

                        <div class="col-md" >
                            <label  class="text-dark" style="font-weight: bold;" >GIVEN NAME</label>
                            <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="firstname" >        
                        </div> 

                        <div class="col-md" >
                            <label  class="text-dark" style="font-weight: bold;" >MIDDLENAME</label>
                            <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="middlename" >        
                        </div> 

                        <div class="col-md" >
                            <label  class="text-dark" style="font-weight: bold;" >NAME EXTENTION</label>
                            <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="name_extension" >        
                        </div>         
                      </div> <!-- end of 2nd row -->

                      <!-- 3rd Row -->
                      <div class="row mt-3">
                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >HOME ADDRESS</label>
                          <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="address" >
                        </div>
                      </div><!-- end of 3rd Row -->

                      <!-- 4th Row -->
                      <div class="row mt-4">
                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >DATE OF BIRTH</label>
                          <input type="date" class="form-control border border-secondary rounded input-sm" name="" id="birthdate">
                        </div> 

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >PLACE OF BIRTH</label>
                          <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="birthplace" >
                        </div> 

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >GENDER</label>
                            <select class="form-control border border-secondary rounded input-sm" name="" id="gender">
                              <option value="" hidden>Select Gender</option>
                              <option value="Male">Male</option>
                              <option value="Female">Female</option>
                            </select>
                        </div>

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >CIVIL STATUS</label>
                            <select class="form-control border border-secondary rounded input-sm" name="" id="civil_status">
                              <option value="" hidden>Select Civil Staus</option>
                              <option value="Married">Married</option>
                              <option value="Single">Single</option>
                            </select>
                        </div>
                      </div>

                      <!-- 5th Row -->
                      <div class="row mt-4">
                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >CITIZENSHIP</label>
                          <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="citizenship">
                        </div> 

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >RELIGION</label>
                          <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="religion">
                        </div>

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >MOBILE PHONE</label>
                          <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="phone_number">
                        </div>

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >EMAIL ADDRESS</label>
                          <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="email">
                        </div>  
                      </div>

                      <!-- 5th Row -->
                      <div class="row mt-4">
                        <div class="col-sm" >                     
                          <button type="button" class="btn btn-success btn-sm border-secondary" id="save_btn" style = "float:right;">Save</button>
                        </div> 
                      </div>

                    </div> <!-- end of container -->
                    
                  </div>

                </div>
              </div>
            </div>

          </div>
            <?php include 'bootstrap_lower/lower.php'; ?>
        </div>
<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- Hidden data -->

<?php 
  $random = rand(100,500); 
  $day = date('d');
  $year = date('Y');
  $student_id = "$day-$year-$random";

  //STUDENT ID 
  print "<input type = 'text' value = '$student_id' id = 'student_id' hidden>";
?>

<?php
  include 'admin_classes/config_mysqli.php';
  $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
    while($row = mysqli_fetch_array($query)){
      $academic_id = $row['academic_id'];

      //ACADEMIC ID 
      print "<input type = 'text' value = '$academic_id' id = 'academic_id' hidden>";
    }
?>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- Retrieve the course list base on the department -->

<script>
  $(document).ready(function() {
    $('#select_department').change(function(){
      var department_id = $('#select_department').val();

          $.ajax({
              url: "admin_classes/get_program_list_enrollment.php",
              method: "POST",
              data: { 
                
                  department_id: department_id

                },
              success:function(data){
                  $('#program_list').html(data);
              }
         
      });
    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- Retrieve the curriculum list base on the program/course -->

<script>
  $(document).ready(function(){
    $('#program_list').change(function(){
      var program_id = $('#select_program').val();
      //var department_id = $('#department_id').val();

        $.ajax({
          url: "admin_classes/get_curriculum_list_enrollment.php",
          method: "POST",
          data: {             
            program_id:  program_id
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
<!-- Add new Student -->

<script>
  $(document).ready(function(){
    $('#save_btn').click(function(){

      //hidden data
      var faculty_user_id    = $('#account_user_id').val();
      var student_id         = $('#student_id').val();
      var academic_id        = $('#academic_id').val();

      //foreign keys
      var department_id      = $('#select_department').val();
      var program_id         = $('#select_program').val();
      var curriculum_id      = $('#select_curriculum').val();

      var student_status     = $('#student_status').val();
      var student_year_level = $('#student_year_level').val();
      var student_semester   = $('#student_semester').val();
      var student_section    = $('#student_section').val();

      var lastname           = $('#lastname').val();
      var firstname          = $('#firstname').val();
      var middlename         = $('#middlename').val();
      var name_extension     = $('#name_extension').val();

      var address            = $('#address').val();

      var birthdate          = $('#birthdate').val();
      var birthplace         = $('#birthplace').val();
      var gender             = $('#gender').val();
      var civil_status       = $('#civil_status').val();

      var citizenship        = $('#citizenship').val();
      var religion           = $('#religion').val();
      var phone_number       = $('#phone_number').val();
      var email              = $('#email').val();

        if (department_id == "" 
            || !$('#select_program').val() 
            || !$('#select_curriculum').val()
            || student_status == ""
            || student_year_level == ""
            || student_semester == ""
            || student_section == ""
            || lastname == ""
            || firstname == ""
            || middlename == ""
            || address == ""
            || birthdate == ""
            || birthplace == ""
            || gender == ""
            || civil_status == ""
            || citizenship == ""
            || religion == ""
            || phone_number == ""
            || email == ""){
                $('#empty_error_modal').modal('show'); 
        }else{

          $.ajax({
            url: "admin_classes/insert_cross_enrollee_enrollment.php",
            type: "POST",
            data: {

              faculty_user_id    :faculty_user_id,
              student_id         :student_id,   
              academic_id        :academic_id,
              department_id      :department_id,      
              program_id         :program_id,       
              curriculum_id      :curriculum_id,  
              student_status     :student_status,
              student_year_level :student_year_level,
              student_semester   :student_semester,
              student_section    :student_section,
              lastname           :lastname,
              firstname          :firstname,
              middlename         :middlename,   
              name_extension     :name_extension,   
              address            :address,
              birthdate          :birthdate,
              birthplace         :birthplace, 
              gender             :gender,
              civil_status       :civil_status, 
              citizenship        :citizenship,
              religion           :religion,
              phone_number       :phone_number,   
              email              :email

            },
            cache: false,
            success: function(dataResult){
              var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    window.location = "registrar_manage_enrollment.php?cross_enrollee_added";	

                }else if(dataResult.statusCode==201){
                  
                  $('#duplicate_error_modal').modal('show');                   
                  
                }else if(dataResult.statusCode==202){
                  alert("Student already enrolled on current academic year");
                  $('#enrolled_error_modal').modal('show');  
                  
                }
            }
          });
        }
      
    });
  });
</script>

  </body>
</html>
