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
                            <p style = 'font-weight: bold; font-size: 15px; vertical-align: middle;'>Shiftee</p>
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

                    <!---------------------------------------------------------------------------------------------------------------------------->
                    <!---------------------------------------------------------------------------------------------------------------------------->
                    <!---------------------------------------------------------------------------------------------------------------------------->
                    <!---------------------------------------------------------------------------------------------------------------------------->
                    
                    <div class = "container">
                    <form action = "subjects_credited_shiftee.php" method = "POST">
             
                    <!---------------------------------------------------------------------------------------------------------------------------->
                    <!---------------------------------------------------------------------------------------------------------------------------->
                    <!---HIDDEN DATA--->
                    <!---faculty_user_id--->
                    <?php include "include/faculty_user_id.php"; ?>

                    <?php
                      include 'admin_classes/config_mysqli.php';
                      $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $academic_id = $row['academic_id'];
                          //ACADEMIC ID 
                          print "<input type = 'text' value = '$academic_id' name = 'academic_id' id = 'academic_id' hidden>";
                        }
                    ?>

                    <!-- 1st row -->
                    <div class = "row mt-4">

                      <div class="col-sm">
                        <label  class="text-dark" style="font-weight: bold" >STUDENT ID</label>
                        <input type="text" class="form-control border border-secondary rounded input-sm" name="student_id" id="student_id"  >
                      </div> 

                      <div class="col-sm">
                        <label class="text-dark" style="font-weight: bold;" >DEPARTMENT</label>
                          <select class="form-control border border-secondary rounded input-sm select" name="select_department" id="select_department">
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


                        <div class="col-sm">
                          <div id = "program_list"> <!-- realtime retrieval -->
                            <label class="text-dark" style="font-weight: bold;" >COURSE</label>
                              <select class="form-control border border-secondary rounded input-sm select" id = "program">
                                <option value="" hidden>Course</option>
                                
                              </select>
                          </div> 
                        </div> 


                      <div class="col-sm">
                        <div id = "curriculum_list"> <!-- realtime retrieval -->
                          <label class="text-dark" style="font-weight: bold;" >CURRICULUM</label>
                            <select class="form-control border border-secondary rounded input-sm" id = "curriculum">
                              <option value="" hidden>Curriculum</option>
                              
                            </select>
                        </div>
                      </div> 

                      </div><!-- end of 1st Row -->

                      <!-- 2nd row -->
                      <div class = "row mt-3">

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >STATUS</label>
                            <select class="form-control border border-secondary rounded input-sm" name="student_status" id="student_status">
                              <option value="" hidden>Status</option>
                              <option value="Regular"> Regular </option>
                              <option value=" Irregular"> Irregular </option>
                            </select>
                        </div> 

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold" >SEMESTER</label>
                            <select class="form-control border border-secondary rounded input-sm" name="student_semester" id="student_semester">
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
                            <select class="form-control border border-secondary rounded input-sm" name="student_year_level" id="student_year_level">
                              <option value="" hidden>Year-Level</option>
                              <option value="1"> 1st Year </option>
                              <option value="2"> 2nd Year </option>
                              <option value="3"> 3rd Year </option>
                              <option value="4"> 4th Year </option>
                            </select>
                        </div>

                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" >SECTION</label>
                            <select class="form-control border border-secondary rounded input-sm" name="student_section" id="student_section">
                              <option value="" hidden>Section</option>
                              <option value="A"> A </option>
                              <option value="B"> B </option>
                              <option value="C"> C </option>
                              <option value="D"> D </option>
                            </select>
                        </div>

                      </div><!-- end of 2nd Row -->

                      <hr>

                      <div id = "fullname">
                        <!-- 3rd Row -->
                        <div class="row mt-4" >
                          <div class="col-md" >
                            <label  class="text-dark" style="font-weight: bold" >SURNAME</label>
                            <input type="text" class="form-control border border-secondary rounded input-sm" name="" id=""  readonly>
                          </div>

                          <div class="col-md" >
                              <label  class="text-dark" style="font-weight: bold;" >GIVEN NAME</label>
                              <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="" readonly>        
                          </div> 

                          <div class="col-md" >
                              <label  class="text-dark" style="font-weight: bold;" >MIDDLENAME</label>
                              <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="" readonly>        
                          </div> 

                          <div class="col-md" >
                              <label  class="text-dark" style="font-weight: bold;" >NAME EXTENTION</label>
                              <input type="text" class="form-control border border-secondary rounded input-sm" name="" id="" readonly>        
                          </div>         
                        </div> <!-- end of 3rd row -->
                      </div>

                       <!-- 54th Row -->
                       <div class="row mt-4">
                        <div class="col-sm" >                     
                          <button type="submit" class="btn btn-success btn-sm border-secondary" name = "next_btn" id="next_btn" style = "float:right;">Next</button>
                        </div> 
                      </div>

                    </form>
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
<!-- Add Shiftee Student -->

<script>
  $(document).ready(function(){
    $('#next_btn').click(function(){

      var student_id                 = $('#student_id').val();
      var academic_id                = $('#academic_id').val();

      //foreign keys
      var department_id              = $('#select_department').val();
      var program_id                 = $('#select_program').val();
      var curriculum_id              = $('#select_curriculum').val();

      var student_status             = $('#student_status').val();
      var student_year_level         = $('#student_year_level').val();
      var student_semester           = $('#student_semester').val();
      var student_section            = $('#student_section').val();

      var student_lastname           = $('#student_lastname').val();
      var student_firstname          = $('#student_firstname').val();
      var student_middlename         = $('#student_middlename').val();
      var student_name_extension     = $('#student_name_extension').val();


        if (department_id == "" 
            || !$('#select_program').val() 
            || !$('#select_curriculum').val()
            || student_status == ""
            || student_year_level == ""
            || student_semester == ""
            || student_section == ""
            || student_lastname == ""
            || student_firstname == ""
            || student_middlename == ""){

              $('#empty_error_modal').modal('show'); 
              
              // disables form to send
              $('input[type=submit]', this).attr('disabled', 'disabled');
              $('form').bind('submit',function(e){e.preventDefault();});
        }else{
              //enabled form to send
              $('form').unbind('submit');
        }
      
    });
  });
</script>


<!-- Mainly scripts -->
<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- Auto generation of name -->

<script>

  $(document).ready(function(){
    $('#student_id').keyup(function(){

      var student_id = $(this).val();

        $.ajax({
          url:"admin_classes/get_info_shiftee.php",
          method:"POST",
          data:{student_id:student_id},
          success:function(response){
              $('#fullname').html(response);
          }
        });
    
    });
  });
</script>

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

<?php
  if(isset($_GET['duplicate'])){
    print"
      <script>
        $(document).ready(function(){
          $('#enrolled_error_modal').modal('show');
        });
      </script>
    ";
  }
?>

  </body>
</html>
