<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_registrar.php";
?>

<!DOCTYPE html>
<html>

  <head>
      <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Subject </title>

      <?php include "include/tab_icon.php"; ?>

      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
      <!-- FooTable -->
      <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
      <link href="css/animate.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">

      <link rel='stylesheet' href='https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css'>   

      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </head>



<body>

<!--Hide and show buttons -->

<?php
  if(!isset($_GET['department'])){

    print "        
      <script> 
        $(document).ready(function(){
          $('#curriculum_btn').hide();
          $('#add_new').hide();
          $('#archived_program_btn').hide();  

          $('#select_year_level').hide();
          $('#select_semester').hide();
          $('#show_subject_list').hide();
          $('#show_all').hide();
        });
      </script>    
    ";

  }else if(!isset($_GET['curriculum_id'])){
    print "     
      <script> 
        $(document).ready(function(){
          $('#add_new').hide();
          $('#archived_program_btn').hide();  

          $('#select_year_level').hide();
          $('#select_semester').hide();
          $('#show_subject_list').hide();
          $('#show_all').hide();
        });
      </script>    
    ";
  }else{
    print "     
    <script> 
      $(document).ready(function()
      $('#curriculum_btn').show();
        $('#add_new').show();
        $('#archived_program_btn').show();  

        $('#select_year_level').show();
        $('#select_semester').show();
        $('#show_subject_list').show();
        $('#show_all').show();
      });
    </script>    
  ";
  }
?>

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

          <li>
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

          <li class="active">
              <a href="registrar_manage_subject.php"><i class="fa fa-lg fa-folder-open" aria-hidden="true"></i> <span class="nav-label"> Manage Subject </span></a>
          </li> 

          <li>
              <a href="registrar_account_settings.php"><i class="fa fa-lg fa-cog" aria-hidden="true"></i> <span class="nav-label">Account Settings</span></a>
          </li>

        </ul>
      </div>
    </nav>
  
     <!-- Delete Modal -->
     <div class="modal fade" id="delete_modal" role="dialog" >
          <div class="modal-dialog" style = "width:300px;"> 
          <!-- Modal content-->
              <div class="modal-content" >
                      <div class="modal-header" style = "color:red;">
                          
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                  <div class="modal-body" style = "text-align:center;">
                      <form method = "POST" action = "admin_classes/delete_subject_script.php" id = "form_delete">
                          
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

    <!----HEADER-------->
    <div id="page-wrapper" class="gray-bg">
      <?php include 'bootstrap_lower/header.php';?>
    <!----HEADER-------->

      <!----UNDER HEADER--------->
      <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
        <div class="col-lg-10">
          <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Subject List </p>
        </div>
      </div>
      <!----UNDER HEADER--------->

      <!------------------------------------------------------------------------------------------------------------------------>
      <!------------------------------------------------------------------------------------------------------------------------>
      <!---faculty_user_id--->
      <?php include "include/faculty_user_id.php"; ?>

      <!--------------------------------------------------------------------------------------------------------------------->
      <!--------------------------------------------------------------------------------------------------------------------->
      <!--- ARCHIVED --->
      <div class="modal fade" id="archived_subject" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-xl" >
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"> Archived Subjects </h5>
            </div>

              <div class="modal-body">
                <?php
                  include 'admin_classes/config_mysqli.php';

                  $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_status = 2
                    ORDER BY subject_year_level ASC, subject_semester ASC, subject_code ASC");

                    if (mysqli_num_rows($query) > 0){

                      print "  
                        <table class='table table-striped'>
                          <thead class='bg-success text-center'>
                            <th>SUBJECT CODE</th>
                            <th>DESCRIPTION</th>
                            <th>UNITS</th>
                            <th>PRE-REQUISITE</th>
                            <th>YEAR LEVEL</th>
                            <th>SEMESTER</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                          </thead>
                          <tbody class='text text-dark'>";

                      while($row = mysqli_fetch_array($query)){
                        
                        $subject_id               = $row['subject_id'];
                        $subject_code             = $row['subject_code'];
                        $subject_description      = $row['subject_description'];
                        $subject_unit             = $row['subject_unit'];
                        $subject_id_prerequisite  = $row['subject_id_prerequisite'];
                        $subject_year_level       = $row['subject_year_level'];
                        $subject_semester         = $row['subject_semester'];
                
                        print"
                          <tr style = 'text-align:center;'>
                            <td> $subject_code </td>
                            <td> $subject_description </td>
                            <td> $subject_unit </td>";

                        if($subject_id_prerequisite == "None"){
                          print "<td><span class='badge badge-secondary' style = 'font-weight:bold;'>$subject_id_prerequisite</span></td>";

                        }else{
                          $query_prerequisite = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id_prerequisite'");
                          while($row_prerequisite = mysqli_fetch_array($query_prerequisite)){
                            $subject_code_prerequisite = $row_prerequisite['subject_code'];

                            print "<td title = '$subject_description'>$subject_code_prerequisite</td>";
                          }
                        }  
                        if($subject_year_level == 1){
                          print "<td>1st Year</td>";
                        }else if($subject_year_level == 2){
                          print "<td>2nd Year</td>";
                        }else if($subject_year_level == 3){
                          print "<td>3rd Year</td>";
                        }else if($subject_year_level == 4){
                          print "<td>4th Year</td>";
                        }  
                        print"
                            <td> $subject_semester </td>
                            <td style='text-align: center;'> <span class='badge badge-pill badge-warning'>ARCHIVED</span> </td>

                            <td style='text-align: center;'> 
                              <button type='button'
                              id = 'restore_subject'
                              class = 'btn btn-primary btn-xs mr-2' 
                              data-id='$subject_id'
                              data-toggle='modal' 
                              data-target = '#restore_confirm_modal'> <i class='fa fa-refresh fa-lg' aria-hidden='true'></i> Restore </button>
                            </td>  
                          </tr> ";               
                      }
                      print "</tbody></table>";
                    }else{
                      echo "<h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>";
                    }
                ?>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-light btn-sm border-secondary" data-dismiss="modal"> Close </button>
              </div>
          </div>
        </div>
      </div>

      <!------------------------------------------------------------------------------------------------------------------------>
      <!------------------------------------------------------------------------------------------------------------------------>
      
      <!-- Restore Subject -->
      <div class="modal fade" id="restore_confirm_modal" role="dialog" >
        <div class="modal-dialog" style = "width:400px;">
        <!-- Modal content-->
          <div class="modal-content" >
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style = "text-align:center;">
              <form method = "POST" action = "admin_classes/restore_subject_script.php" id = "restore_form">
                <div class = "restore_info"></div>
              </form>
            </div>
            <div class="modal-footer">                     
              <button type="button" class="btn btn-default" data-dismiss="modal" style = "float:right;">Close</button>               
              <input type='submit' id = 'restore_btn' class ="btn btn-primary" value='Restore' name='restore_btn' style = "float:right;">
            </div>
          </div>
        </div>
      </div>

      <!--------------------------------------------------------------------------------------------------------------------->
      <!--------------------------------------------------------------------------------------------------------------------->
      
      <!----DATA TABLES ONE-------------------------------------------------------------------------------------------------------------->
      <div class="wrapper wrapper-content animated fadeInRight">

        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->
        <!--- ALERT BOXES -->

        <!--- Added Subject -->
        <?php 
          include 'admin_classes/config_mysqli.php';      
          if(isset($_GET['added'])){

              $subject = $_SESSION['subject'];

                  print("
                      <div class = 'alert alert-success alert-dismissible alert-sm'>
                          <button type='button' class='close' data-dismiss='alert'>&times;</button>
                          <span><b>$subject</b> has been added!</span>
                      </div>"
                  );
              
            }
        ?> 

        <!--- Added Subject -->
        <?php 
          include 'admin_classes/config_mysqli.php';      
          if(isset($_GET['updated'])){

              $subject = $_SESSION['subject'];

                  print("
                      <div class = 'alert alert-primary alert-dismissible alert-sm'>
                          <button type='button' class='close' data-dismiss='alert'>&times;</button>
                          <span><b>$subject</b> has been updated!</span>
                      </div>"
                  );
              
            }
        ?> 

        <!--- Deactivated Subject -->
        <?php 
          include 'admin_classes/config_mysqli.php';      
          if(isset($_GET['deactivated'])){

              $subject = $_GET['subject'];

                  print("
                      <div class = 'alert alert-danger alert-dismissible alert-sm'>
                          <button type='button' class='close' data-dismiss='alert'>&times;</button>
                          <span><b>$subject</b> has been deactivated!</span>
                      </div>"
                  );
              
            }
        ?> 

        <!--- Activated Subject -->
        <?php 
          include 'admin_classes/config_mysqli.php';      
          if(isset($_GET['activated'])){

              $subject = $_GET['subject'];

                  print("
                      <div class = 'alert alert-success alert-dismissible alert-sm'>
                          <button type='button' class='close' data-dismiss='alert'>&times;</button>
                          <span><b>$subject</b> has been activated!</span>
                      </div>"
                  );
              
            }
        ?> 

        <!--- Archived Subject -->
        <?php 
          include 'admin_classes/config_mysqli.php';      
          if(isset($_GET['archived'])){

              $subject = $_GET['subject'];

                  print("
                      <div class = 'alert alert-warning alert-dismissible alert-sm'>
                          <button type='button' class='close' data-dismiss='alert'>&times;</button>
                          <span><b>$subject</b> has been archived!</span>
                      </div>"
                  );
              
            }
        ?> 

        <!--- Restored Subject -->
        <?php 
          include 'admin_classes/config_mysqli.php';      
          if(isset($_GET['restored'])){

              $subject = $_GET['subject'];

                  print("
                      <div class = 'alert alert-success alert-dismissible alert-sm'>
                          <button type='button' class='close' data-dismiss='alert'>&times;</button>
                          <span><b>$subject</b> has been restored!</span>
                      </div>"
                  );
              
            }
        ?> 

        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->

        <div class="row">
          <div class="col-lg-12">
            <div class="ibox ">

              <!-----MODAL FRAME ADD--------->
              <!-----MODAL FOR ADD NEW -------->
              <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog pt-reduced pb-reduced" >
                  <div class="modal-content">
                    <div class="modal-header">

                      <h5 class="modal-title"> Subject Registration </h5>

                    </div>
                                        
                    <div class="modal-body">
                      <!-----MODAL------->

                      <!---FILL UP--------->
                      <!-----1st row------->
                      <div class="row mt-2" >
                        <div class="col-sm">
                          <label class = "text-dark" style="font-weight: bold;" > CURRICULUM</label>
                            <input type = "text" 
                                  class = "form-control border border-secondary rounded input-sm" 
                                  id = "curriculum" 
                                  value = "<?php 
                                            
                                            include 'admin_classes/config_mysqli.php';

                                            if(isset($_GET['curriculum_id'])){
                                              $curriculum_id = $_GET['curriculum_id'];

                                              $query = mysqli_query($con, "SELECT * FROM manage_curriculum WHERE curriculum_id = '$curriculum_id'");
                                              while($row = mysqli_fetch_array($query)){
                                                $program_id = $row['program_id'];
                                                $curriculum_year = $row['curriculum_year'];

                                                $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                                while($row_program = mysqli_fetch_array($query_program)){
                                                  $program_code = $row_program['program_code'];

                                                  print "$program_code - $curriculum_year";
                                                }
                                              }
                                            }

                                          ?>" 
                                  readonly>

                                  <!-- Hidden Curriculum ID -->
                                  <input type = "text" 
                                          id = "curriculum_id" 
                                          value = "<?php 

                                                    if(isset($_GET['curriculum_id'])){
                                                      $curriculum_id = $_GET['curriculum_id'];

                                                      print "$curriculum_id";
                                                    }
                                                  ?>" 
                                          hidden>
                        </div>
                      </div>

                      <div class="row mt-2" >
                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" > YEAR LEVEL </label>
                            <select class="form-control border-secondary rounded input-sm" id="subject_year_level" >
                              <option value=""  hidden> Select Year </option>
                              <option value="1" > 1st Year </option>
                              <option value="2" > 2nd Year </option>
                              <option value="3" > 3rd Year </option>
                              <option value="4" > 4th Year </option>
                            </select>
                        </div>
                      </div>

                      <div class="row mt-2" >   
                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" > SEMESTER </label>
                          <select class="form-control border-secondary rounded input-sm" id="subject_semester" >
                            <option value="" hidden> Select Semester</option>
                            <option value="1st Semester" > 1st Semester </option>
                            <option value="2nd Semester" > 2nd Semester </option>
                          </select>
                        </div>
                      </div>

                      <hr>

                      <div class="row mt-2">
                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" > SUBJECT CODE </label>
                          <input type="text" class="form-control border border-secondary rounded input-sm" id="subject_code" >
                        </div>
                      </div>

                      <div class="col-sm"></div>

                      <div class="col-sm"></div>
    
                      <div class="row mt-2">
                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" > DESCRIPTIVE TITLE </label>
                          <input type="text" class="form-control border border-secondary rounded input-sm" id="subject_description"  >
                        </div>
                      </div>

                      <div class="row mt-2">
                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" > TOTAL UNITS </label>
                          <input type="number" class="form-control border border-secondary rounded input-sm" id="subject_unit"  >      
                        </div>
                      </div>

                      <div class="col-sm"></div>

                      <div class="col-sm"></div>
    

                      <div class="row mt-2">
                        <div class="col-sm">
                          <label class="text-dark" style="font-weight: bold;" > PRE-REQUISITE </label>
                            <select class="form-control border-secondary rounded input-sm" id="subject_id_prerequisite">
                              <option value="" hidden> Select Subject</option>
                              <option value="None" > None</option>

                              <?php 
                              include 'admin_classes/config_mysqli.php';

                                $department_id = $_GET['department_id'];
                                $curriculum_id = $_GET['curriculum_id'];

                                $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE department_id = '$department_id' AND curriculum_id = '$curriculum_id' ORDER BY subject_year_level ASC, subject_semester ASC, subject_code ASC");
                                  while($row = mysqli_fetch_array($query)){
                                    $subject_id = $row['subject_id'];
                                    $curriculum_id = $row['curriculum_id'];                                   
                                    $program_id = $row['program_id'];
                                    $department_id = $row['department_id'];
                                    $subject_code = $row['subject_code'];
                                    $subject_description = $row['subject_description'];

                                    print "<option value = '$subject_id' > $subject_code - $subject_description</option>";
                                  }
                            ?>
                          
                            </select>   
                              
                        </div>
                      </div>

                      <div class="col-sm"></div>

                      <div class="col-sm"></div>
    
          
                      <br><div id = "empty" style = "color:red; font-weight:bold; text-align:center"></div>

                    </div>

   
                    <div class="modal-footer">
                      <button type="button" class="btn btn-success btn-sm border-secondary" id="save_btn"> Save </button>
                      <button type="button" class="btn btn-light btn-sm border-secondary" data-dismiss="modal"> Cancel </button>
                    </div>
                  </div>
                </div>
              </div>
              
              <!--------------------------------------------------------------------------------------------------------------------->
              <!--------------------------------------------------------------------------------------------------------------------->
              <!-----Update ------------>
              <div class="modal inmodal fade" id="update_modal" tabindex="-1" role="dialog"  aria-hidden="true">
                <div class="modal-dialog pt-reduced pb-reduced" >
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title"> Update Subject </h5>
                    </div>
                                        
                    <div class="modal-body">
                      
                      <div id = "update_info"></div>

                      <div class = 'mt-2' style ="color:red;font-weight:bold;text-align:center;" id = "error"></div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-light btn-sm border-secondary" data-dismiss="modal"> Cancel </button>
                      <button type="button" class="btn btn-success btn-sm border-secondary" id="update_btn"> Update </button>
                    </div>
                  </div>
                </div>
              </div>

              <!--------------------------------------------------------------------------------------------------------------------->
              <!--------------------------------------------------------------------------------------------------------------------->

              <!-- ACTIVATE Modal -->
              <div class="modal fade" id="activate_modal" role="dialog" >
                <div class="modal-dialog" style = "width:400px;">
                  <!-- Modal content-->
                  <div class="modal-content" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                      <div class="modal-body" style = "text-align:center;">
                        <form method = "POST" action = "admin_classes/activate_subject_script.php" id = "activate_form">
                            <div class = "activate_info"></div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light btn-sm" data-dismiss="modal"> Cancel </button>
                        <button type="button" class="btn btn-primary btn-sm " id = 'activate_btn'> Activate </button>
                      </div>
                  </div>
                </div>
              </div>
              
              <!--------------------------------------------------------------------------------------------------------------------->
              <!--------------------------------------------------------------------------------------------------------------------->

              <!-- DEACTIVATE Modal -->
              <div class="modal fade" id="deactivate_modal" role="dialog" >
                  <div class="modal-dialog" style = "width:400px;">
                  <!-- Modal content-->
                      <div class="modal-content" >
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                          <div class="modal-body" style = "text-align:center;">
                              <form method = "POST" action = "admin_classes/deactivate_subject_script.php" id = "deactivate_form">
                                  <div class = "deactivate_info" ></div>
                              </form>
                            
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-light btn-sm" data-dismiss="modal"> Cancel </button>
                            <button type="button" class="btn btn-danger btn-sm " id = 'deactivate_btn'> Deactivate </button>
                          </div>
                      </div>
                  </div>
              </div>

              <!---------------------------------------------------------------------------------------------------------------------------->
              <!---------------------------------------------------------------------------------------------------------------------------->

              <!-- ARCHIVE Modal -->
              <div class="modal fade" id="archive_modal" role="dialog" >
                <div class="modal-dialog" style = "width:400px;">
                <!-- Modal content-->
                  <div class="modal-content" >
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" style = "text-align:center;">
                      <form method = "POST" action = "admin_classes/archive_subject_script.php" id = "archive_form">
                        <div class = "archive_info"></div>
                      </form>
                    </div>

                    <div class="modal-footer">                     
                      <button type="button" class="btn btn-default" data-dismiss="modal" style = "float:right;">Close</button>               
                      <input type='submit' id = 'archive_btn' class ="btn btn-warning" value='Archive' name='archive_btn' style = "float:right;">
                    </div>
                  </div>
                </div>
              </div>

              <!--------------------------------------------------------------------------------------------------------------------->
              <!--------------------------------------------------------------------------------------------------------------------->
              
              <!----TABLE SORTED------------------------------------------------------------------------------------------------------------->
              <div class="ibox-content">
                <div class="table-responsive">

                  <!--------------------------------------------------------------------------------------------------------------------->
                  <!--------------------------------------------------------------------------------------------------------------------->

                  <!--DROPDOWN BUTTONS -->
                  <div class = "container">
                    <div class = "row">

                      <div class = "col-md-6">
                        <div class = "row">
                          <div class='dropdown' style = "margin:5px;">
                            <button class='btn btn-success btn-sm ' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                              Department <i class="fa fa-caret-down fa-lg"></i>
                            </button>

                              <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                                <?php
                                  include 'admin_classes/config_mysqli.php';
                                  $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_status = 1");
                                    while($row = mysqli_fetch_array($query)){  
                                      $department_id = $row['department_id'];                       
                                      $department_code = $row['department_code'];  
                                      $department_description = $row['department_description'];                          
                                        print("
                                            <a class='dropdown-item choose_department' href = 'registrar_manage_subject.php?department&department_id=$department_id' title = '$department_description'> <span style = 'color:black;'> $department_code </span></a>
                                            "); 
                                    }                        
                                ?>  
                              </div> 
                          </div>

                          <div class='dropdown' style = "margin:5px;" >
                            <button class='btn btn-success btn-sm ' type='button' id='curriculum_btn' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                              Curriculum <i class="fa fa-caret-down fa-lg"></i>
                            </button>

                            <div class='dropdown-menu' aria-labelledby='curriculum_btn'>
                              <?php

                                if(isset($_GET['department_id'])){

                                  $department_id = $_GET['department_id'];

                                  include 'admin_classes/config_mysqli.php';
                                  $query = mysqli_query($con, "SELECT * FROM manage_curriculum WHERE department_id = '$department_id' AND curriculum_status = 1");
                                    while($row = mysqli_fetch_array($query)){  
                                      $curriculum_id = $row['curriculum_id'];
                                      $department_id = $row['department_id'];                       
                                      $program_id = $row['program_id'];  
                                      $curriculum_year = $row['curriculum_year'];  
                                      
                                      $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                        while($row_program = mysqli_fetch_array($query_program)){
                                          $program_code = $row_program['program_code'];
                                            print("
                                              <a class='dropdown-item choose_department' href = 'registrar_manage_subject.php?department&department_id=$department_id&curriculum_id=$curriculum_id' > <span style = 'color:black;'>$program_code - $curriculum_year</span></a>
                                            "); 
                                        } 
                                    }    
                                }                     
                              ?>  
                            </div> 
                          </div> 

                          <div style = "margin:5px;" >
                            <button type="button" 
                              class="btn btn-success btn-sm" 
                              data-toggle="modal" 
                              data-target="#myModal6" 
                              id = "add_new">Add New <i class="fa fa-plus" aria-hidden="true"></i> 
                            </button>
                          </div> 

                          <div style = "margin:5px;" >
                            <button type="button" 
                              class="btn btn-success btn-sm" 
                              data-toggle="modal" 
                              data-target="#archived_subject" 
                              id = "archived_program_btn"> <i class="fa fa-archive fa-lg" aria-hidden="true"></i> Archived
                            </button>
                          </div>

                        </div>
                      </div>

                      <div class = "col-md-6">
                        <div class = "row"  style = "float:right;">

                          <div style = "margin:3px;" >
                              <select class="border-secondary rounded input-sm" id="select_year_level" >
                                <option value=""  hidden> Year Level </option>
                                <option value="1" > 1st Year </option>
                                <option value="2" > 2nd Year </option>
                                <option value="3" > 3rd Year </option>
                                <option value="4" > 4th Year </option>
                              </select>
                          </div> 

                          <div style = "margin:3px;" >
                              <select class="border-secondary rounded input-sm" id="select_semester" >
                                <option value=""  hidden> Semester </option>
                                <option value="1st Semester" > 1st Semester </option>
                                <option value="2nd Semester" > 2nd Semester </option>
                              </select>
                          </div> 

                          <div style = "margin:5px;" >
                            <button type="button" class="btn btn-success btn-sm" id = "show_subject_list">Show <i class="fa fa-eye" aria-hidden="true"></i> </button>
                          </div> 
                        
                          <div style = "margin:5px;" >
                            <a href = ''><button type="button" class="btn btn-success btn-sm" id = "show_all"> Refresh <i class="fa fa-refresh" aria-hidden="true"></i> </button></a>
                          </div> 

                        </div>
                      </div>

                    </div>
                  </div>
                  <!--------------------------------------------------------------------------------------------------------------------->
                  <!--------------------------------------------------------------------------------------------------------------------->

                  <br>
                  
                  <?php 
                    include 'admin_classes/config_mysqli.php';

                    if(isset($_GET['department_id'])){
                      $department_id = $_GET['department_id'];

                      $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
                      while($row = mysqli_fetch_array($query)){
                        $department_code = $row['department_code'];
                        $department_description = $row['department_description'];

                        print "
                        
                        <h3 style = 'text-align:center;'>$department_description ($department_code)</h3>
                        
                        ";
                      }
                    }
                  
                  ?>
                  
                  <hr>

                  <!-----PRINT--
                  <form method="post" action="print/print_subject_list.php" target="_blank"> 
                    <input type="hidden" name="print" id="print" value="<?php //print"$curriculumz"; ?>">
                    <button type="submit" class="btn btn-success btn-xs" style="margin-top: -3px; margin-left: 94%;" > <i class="fa fa-xs fa-print" aria-hidden="true"></i> Print </button>
                  </form>
                  ----PRINT---->

                  <table style="width: 25%; margin:auto; margin-top: -10px;">
                    <tr>
                      <td>
                        <p style="background-color: rgb(179, 209, 255); font-weight: bold; font-size: 14px; text-align: center; color: #001f4d; margin-top: -15px;"> : : : CURRICULUM : : : </p>
                        
                        <br>
                        <!--------------------------------------------------------------------------------------------------------------------->
                        <!--------------------------------------------------------------------------------------------------------------------->
                        <!-----CURRICULUM NAME---->
                          <?php 

                          include 'admin_classes/config_mysqli.php';

                            if(isset($_GET['curriculum_id'])){
                              $curriculum_id = $_GET['curriculum_id'];

                              $query = mysqli_query($con, "SELECT * FROM manage_curriculum WHERE curriculum_id = '$curriculum_id'");
                              while($row = mysqli_fetch_array($query)){
                                $curriculum_year = $row['curriculum_year'];
                                $program_id = $row['program_id'];

                                $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                while($row_program = mysqli_fetch_array($query_program)){
                                  $program_code = $row_program['program_code'];

                                  print "<p style='text-align: center; margin-top: -15px; font-weight: bold;'> $program_code - $curriculum_year </p>";
                                }
                              }
                            }
                          ?> 
                
                          </td>
                    </tr>
                  </table>

                  <!--------->
                  <div id = "table_data">
                    <table class = "table table-striped">
                      <thead class="bg-success text-center">
                        
                        <th > Subject Code </th>
                        <th > Description </th>
                        <th > Units </th>
                        <th > Pre-requisite </th>
                        <th > Year Level </th>
                        <th > Semester </th>
                        <th > Status </th>
                        <th > Action </th>
                      </thead>
                      <?php 

                        include 'admin_classes/config_mysqli.php';   

                        if(isset($_GET['curriculum_id'])){

                          $curriculum_id = $_GET['curriculum_id'];

                            $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE curriculum_id = '$curriculum_id' AND subject_status != 2 ORDER BY subject_year_level ASC, subject_semester ASC, subject_code ASC");

                              while($row = mysqli_fetch_array($query)){
                                $department_id = $row['department_id'];
                                $curriculum_id = $row['curriculum_id'];
                                $program_id = $row['program_id'];
                                $subject_code = $row['subject_code'];
                                $subject_description = $row['subject_description'];
                                $subject_unit = $row['subject_unit'];
                                $subject_id_prerequisite = $row['subject_id_prerequisite'];
                                $subject_year_level = $row['subject_year_level'];
                                $subject_semester = $row['subject_semester'];
                                $subject_status = $row['subject_status'];
                                $subject_id = $row['subject_id'];

                                print "
                                  <tr style = 'text-align:center;'>
                                    <td>$subject_code</td>
                                    <td>$subject_description</td>
                                    <td>$subject_unit</td>
                                ";

                                if($subject_id_prerequisite == "None"){
                                  print "<td><span class='badge badge-secondary' style = 'font-weight:bold;'>$subject_id_prerequisite</span></td>";

                                }else{
                                  $query_prerequisite = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id_prerequisite'");
                                  while($row_prerequisite = mysqli_fetch_array($query_prerequisite)){
                                    $subject_code_prerequisite = $row_prerequisite['subject_code'];
  
                                    print "<td title = '$subject_description'>$subject_code_prerequisite</td>";
                                  }
                                }
                                
                               

                                if($subject_year_level == 1){
                                  print "<td>1st Year</td>";
                                }else if($subject_year_level == 2){
                                  print "<td>2nd Year</td>";
                                }else if($subject_year_level == 3){
                                  print "<td>3rd Year</td>";
                                }else if($subject_year_level == 4){
                                  print "<td>4th Year</td>";
                                }
                                    
                                print "<td>$subject_semester</td>";
                                  if($subject_status == 1){
                                    print "
                                      <td style='text-align: center;'> <span class='badge badge-primary'>ACTIVE</span> </td>
                                      <td>
                                        <div class='dropdown dropleft'>
                                          <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                              Action 
                                          </button>

                                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                              <a class='dropdown-item' href='' data-id='$subject_id' data-toggle='modal' data-target = '#update_modal'     id = 'update'>     <i class='fa fa-pencil fa-fw'></i>  Update</a>
                                              <a class='dropdown-item' href='' data-id='$subject_id' data-toggle='modal' data-target = '#deactivate_modal' id = 'deactivate'> <i class='fa fa-unlock fa-fw'></i>  Deactivate</a>
                                              <a class='dropdown-item' href='' data-id='$subject_id' data-toggle='modal' data-target = '#archive_modal'    id = 'archive'>    <i class='fa fa-archive fa-fw'></i> Archive</a>
                                            </div> 
                                        </div>
                                      </td>";
                                  }else if($subject_status == 0){
                                    print "
                                      <td style='text-align: center;'> <span class='badge badge-danger'>INACTIVE</span> </td>
                                      <td>
                                        <div class='dropdown dropleft'>
                                          <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                              Action 
                                          </button>

                                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                              <a class='dropdown-item' href='' data-id='$subject_id' data-toggle='modal' data-target = '#update_modal'   id = 'update'>     <i class='fa fa-pencil fa-fw'></i>  Update</a>
                                              <a class='dropdown-item' href='' data-id='$subject_id' data-toggle='modal' data-target = '#activate_modal' id = 'deactivate'> <i class='fa fa-unlock fa-fw'></i>  Activate</a>
                                              <a class='dropdown-item' href='' data-id='$subject_id' data-toggle='modal' data-target = '#archive_modal'  id = 'archive'>    <i class='fa fa-archive fa-fw'></i> Archive</a>
                                            </div> 
                                        </div>
                                      </td>";
                                  }
      
                                   
                                print "</tr>";

                              }
                        }
                        ?> 
                    </table>
                  </div>
                     
                </div>
              </div>
          

            </div>
          </div>
        </div>
      </div>

<!-- GET the department_id and curriculum_id for realtime data retrieval -->
<?php 
  if(isset($_GET['curriculum_id'])){
    $department_id = $_GET['department_id'];
    $curriculum_id = $_GET['curriculum_id'];

    print "
      <input type = 'text' id = 'department_id_hid' value = '$department_id' hidden>
      <input type = 'text' id = 'curriculum_id_hid' value = '$curriculum_id' hidden>
    ";
  }
?>

      
<?php include 'bootstrap_lower/lower.php'; ?>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- HIDDEN DATA -->


<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- Mainly scripts -->

<!-- ADD NEW SUBJECT -->
<script>
  $(document).ready(function(){
  //Error mesages               
      $('#add_new').click(function(){  
        $('#subject_year_level').val('');
        $('#subject_semester').val('');
        $('#subject_code').val('');
        $('#subject_description').val('');
        $('#subject_unit').val('');
        $('#subject_id_prerequisite').val('');

        $('#empty').hide();
        
    });
  });
</script>

<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!--shake effect on error -->

<!-- ADD -->
<script>

  $(document).ready(function(){
              
    $('#save_btn').click(function(){

      var faculty_user_id          = $('#account_user_id').val();
      var curriculum_id            = $('#curriculum_id').val();
      var subject_year_level       = $('#subject_year_level').val();
      var subject_semester         = $('#subject_semester').val();
      var subjectcode              = $('#subject_code').val();
      var subject_description      = $('#subject_description').val();
      var subject_unit             = $('#subject_unit').val();
      var subject_id_prerequisite  = $('#subject_id_prerequisite').val();


        if(subject_year_level == "" || subject_semester == "" || subjectcode == "" || subject_description == "" || subject_unit == "" || subject_id_prerequisite == ""){       

          $("#empty").html("Invalid Attempt! Please enter a value!");
          $("#empty").show();   
          $('#empty').effect("shake");

        }else{

          $.ajax({
            url: "admin_classes/reg_manage_subject_insert.php",
            type: "POST",
            data: {

              faculty_user_id          :faculty_user_id,
              curriculum_id            :curriculum_id,
              subject_year_level       :subject_year_level,
              subject_semester         :subject_semester,
              subjectcode              :subjectcode,
              subject_description      :subject_description,
              subject_unit             :subject_unit,
              subject_id_prerequisite  :subject_id_prerequisite

            },
            cache: false,
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                window.location = "registrar_manage_subject.php?department&department_id=<?php echo $department_id;?>&curriculum_id=<?php echo $curriculum_id;?>&added"

                    						 
                }else if(dataResult.statusCode==201){
                  
                  $("#empty").show();  
                    $('#empty').html('Subject code and Descriptive Title already exists!'); 
                    $('#empty').effect("shake");                                 
                  
                }   
            }
          });
        }
      
    });   
  });

  </script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- Shows specific data based on chosen year level and semester -->

<script>
  $(document).ready(function(){
      $('#show_subject_list').click(function(){
          
          var select_year_level = $('#select_year_level').val();
          var select_semester = $('#select_semester').val();
          var department_id = $('#department_id_hid').val();
          var curriculum_id = $('#curriculum_id_hid').val();

          $.ajax({
              url: "admin_classes/select_subject_list.php",
              method: "POST",
              data: { 
                select_year_level: select_year_level,
                select_semester: select_semester,
                department_id: department_id,
                curriculum_id: curriculum_id
               },
              success:function(data){
                  $('#table_data').html(data);
              }
          });
      });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- DELETE -->
<script>
  $(document).ready(function(){
      $(document).on("click",".dropdown-item", function (){ 

        var faculty_user_id  = $('#account_user_id').val();
        var subject_id       = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/delete_subject_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            subject_id      :subject_id
           
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
          $('#error').hide();
        });
    });
</script>

<script>
    $(document).ready(function(){
        $(document).on("click",".dropdown-item", function (){ 
        
          var subject_id       = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/update_subject_form.php',
            type: 'POST',
            data: {
              
              subject_id      :subject_id
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

      //hidden data
      var new_subject_id              = $('#new_subject_id').val();
      var new_curriculum_id           = $('#new_curriculum_id').val();
      var new_department_id           = $('#new_department_id').val();
      var faculty_user_id             = $('#account_user_id').val();

      var new_subject_year_level      = $('#new_subject_year_level').val();
      var new_subject_semester        = $('#new_subject_semester').val();
      var new_subject_code            = $('#new_subject_code').val();
      var new_subject_description     = $('#new_subject_description').val();
      var new_subject_unit            = $('#new_subject_unit').val();
      var new_subject_id_prerequisite = $('#new_subject_id_prerequisite').val();


      if(new_subject_year_level       == '' || 
          new_subject_semester        == '' ||
          new_subject_code            == '' ||
          new_subject_description     == '' ||
          new_subject_unit            == '' ||
          new_subject_id_prerequisite == ''   ){       
          
          $('#error').html('Invalid Attempt! Please enter a value!');
          $('#error').show();   
          $('#error').effect('shake');

      }else{

          $.ajax({
            url: "admin_classes/update_subject_ajax.php",
            type: "POST",
            data: {
              faculty_user_id              :faculty_user_id,
              new_subject_id               :new_subject_id,
              new_curriculum_id            :new_curriculum_id,
              new_subject_year_level       :new_subject_year_level,
              new_subject_semester         :new_subject_semester,
              new_subject_code             :new_subject_code,
              new_subject_description      :new_subject_description,
              new_subject_unit             :new_subject_unit,
              new_subject_id_prerequisite  :new_subject_id_prerequisite
            },
            cache: false,
            success: function(dataResponse){
                var dataResponse = JSON.parse(dataResponse);
                if(dataResponse.statusCode==200){
          
                    window.location = "registrar_manage_subject.php?updated&department&department_id="+new_department_id+"&curriculum_id="+new_curriculum_id;						
                }else if(dataResponse.statusCode==201){
                   
                  $("#error").show();  
                  $('#error').html('Subject Code or Description already exists!'); 
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

<!-- ACTIVATE -->
<script>
    $(document).ready(function(){
        $(document).on("click",".dropdown-item", function (){ 

          var faculty_user_id  = $('#account_user_id').val();
          var subject_id       = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/activate_subject_ajax.php',
            type: 'POST',
            data: {
              faculty_user_id  :faculty_user_id,
              subject_id       :subject_id
              },
            success: function(response){ 
                // Add response in Modal body
                $('.activate_info').html(response);    
            }
            });
        });
    });
</script>

<script>
  $(document).ready(function(){
    $('#activate_btn').click(function(){
      $('#activate_form').submit();
    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- DEACTIVATE-->

<script>
    $(document).ready(function(){
      $(document).on("click",".dropdown-item", function (){ 

          var faculty_user_id  = $('#account_user_id').val();
          var subject_id       = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/deactivate_subject_ajax.php',
            type: 'POST',
            data: {
                faculty_user_id :faculty_user_id,
                subject_id      :subject_id
              },
            success: function(response){ 
                // Add response in Modal body
                $('.deactivate_info').html(response);   
            }
            });
        });
    });
</script>

<script>
  $(document).ready(function(){
    $('#deactivate_btn').click(function(){
      $('#deactivate_form').submit();
    });
  });
</script>

<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>

<!-- ARCHIVE -->
<script>
    $(document).ready(function(){
        $(document).on('click', '.dropdown-item', function(){

          var faculty_user_id  = $('#account_user_id').val();
          var subject_id       = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/archive_subject_ajax.php',
            type: 'POST',
            data: {

                faculty_user_id :faculty_user_id,
                subject_id      :subject_id
              },
            success: function(response){ 
                // Add response in Modal body
                $('.archive_info').html(response);    
            }
            });
        });
    });
</script>

<script>
  $(document).ready(function(){
    $('#archive_btn').click(function(){
      $('#archive_form').submit();
    });
  });
</script>

<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>

<!-- RESTORE -->
<script>
    $(document).ready(function(){
        $(document).on('click', '#restore_subject', function(){

          var faculty_user_id   = $('#account_user_id').val();
          var subject_id     = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/restore_subject_ajax.php',
            type: 'POST',
            data: {

                faculty_user_id :faculty_user_id,
                subject_id      :subject_id
              },
            success: function(response){ 
                // Add response in Modal body
                $('.restore_info').html(response);    
            }
            });
        });
    });
</script>

<script>
  $(document).ready(function(){
    $('#restore_btn').click(function(){
      $('#restore_form').submit();
    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->

</body>
</html>
