<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_registrar.php";
?>

<!DOCTYPE html>

<html>

  <head>
      <title> <?php include'bootstrap_lower/title_header.php'; ?> | Curriculum </title>

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
    <!--HIDES ADD NEW BUTTON -->
    <?php 
      include 'admin_classes/config_mysqli.php';      
      if(!isset($_GET['department'])){
        print "                           
          <script>
              $(document).ready(function(){                                 
                    $('#add_new').hide();   
                    $('#archived_curriculum_btn').hide();                               
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
            <li class="active">
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
      <!------SIDE NAV--------------------------------------------------------------------------------------------------------------->

      <!----HEADER-------------------------------------------------------------------------------------------------------------->
      <div id="page-wrapper" class="gray-bg">
        <?php include 'bootstrap_lower/header.php';?>
      <!----HEADER-------------------------------------------------------------------------------------------------------------->

      <!----UNDER HEADER-------------------------------------------------------------------------------------------------------------->
      <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
        <div class="col-lg-10">
          <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Curriculum List </p>
        </div>
      </div>
      <!----UNDER HEADER-------------------------------------------------------------------------------------------------------------->
      
      <!------------------------------------------------------------------------------------------------------------------------>
      <!------------------------------------------------------------------------------------------------------------------------>
      <!---HIDDEN DATA--->
      <!---faculty_user_id--->
      <?php include "include/faculty_user_id.php"; ?>

      <!--------------------------------------------------------------------------------------------------------------------->
      <!--------------------------------------------------------------------------------------------------------------------->
      <!--- ARCHIVED --->
      <div class="modal fade" id="archived_curriculum" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" >
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"> Archived Curriculums </h5>
            </div>

              <div class="modal-body">
                <?php
                  include 'admin_classes/config_mysqli.php';

                  $query = mysqli_query($con, "SELECT * FROM manage_curriculum JOIN manage_program
                  ON manage_curriculum.program_id = manage_program.program_id WHERE manage_curriculum.curriculum_status = 2");

                    if (mysqli_num_rows($query) > 0){

                      print "  
                        <table class='table table-striped'>
                          <thead class='bg-success text-center'>
                            <th>CURRICULUM</th>
                            <th>PROGRAM DESCRIPTION</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                          </thead>
                          <tbody class='text text-dark'>";

                      while($row = mysqli_fetch_array($query)){
                        
                        //manage_curriculum table
                        $curriculum_id        =  $row['curriculum_id'];
                        $curriculum_year      =  $row['curriculum_year'];

                        //manage_program table
                        $program_code         = $row['program_code'];
                        $program_description  = $row['program_description'];
                
                        print("
                          <tr style = 'text-align:center;'>

                            <td> $program_code - $curriculum_year</td>
                            <td> $program_description </td>
                            <td style='text-align: center;'> <span class='badge badge-pill badge-warning'>ARCHIVED</span> </td>

                            <td style='text-align: center;'> 
                              <button type='button'
                              id = 'restore_curriculum'
                              class = 'btn btn-primary btn-xs mr-2' 
                              data-id='$curriculum_id'
                              data-toggle='modal' 
                              data-target = '#restore_confirm_modal'> <i class='fa fa-refresh fa-lg' aria-hidden='true'></i> Restore </button>
                            </td>  
                          </tr> ");
                                            
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

      <!--------------------------------------------------------------------------------------------------------------------->
      <!--------------------------------------------------------------------------------------------------------------------->

      <!-- Restore curriculum -->
      <div class="modal fade" id="restore_confirm_modal" role="dialog" >
        <div class="modal-dialog" style = "width:400px;">
        <!-- Modal content-->
          <div class="modal-content" >
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style = "text-align:center;">
              <form method = "POST" action = "admin_classes/restore_curriculum_script.php" id = "restore_form">
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
        <!---Added Curriculum -->
        <?php             
          include 'admin_classes/config_mysqli.php';    
            if(isset($_GET['added'])){
              $curriculum =  $_SESSION['curriculum'];

                print("
                <div class = 'alert alert-primary alert-dismissible alert-sm'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <span><b>$curriculum </b> curriculum has been successfully added!</b></span>
                </div>"
            );    
              
          }
        ?>

        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->

        <!---Updated Cuurriculum -->
        <?php             
          include 'admin_classes/config_mysqli.php';    
            if(isset($_GET['updated'])){

              $curriculum_old = $_SESSION['curriculum_old'];
              $curriculum_new = $_SESSION['curriculum_new'];

                print("
                  <div class = 'alert alert-primary alert-dismissible alert-sm'>
                      <button type='button' class='close' data-dismiss='alert'>&times;</button>
                      <span><b>$curriculum_old</b> updated to <b>$curriculum_new</b> successfully!</span>
                  </div>"
                );          
            }                        
        ?>

        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->
        <!--- Activated Curriculum -->
        <?php 
          include 'admin_classes/config_mysqli.php';      
          if(isset($_GET['activated'])){

            $curriculum = $_GET['curriculum'];
                  
                  print("
                      <div class = 'alert alert-success alert-dismissible alert-sm'>
                          <button type='button' class='close' data-dismiss='alert'>&times;</button>
                          <span><b>$curriculum</b> has been activated!</span>
                      </div>"
                  );
          }
        ?> 

        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->
        <!--- Deactivated Curriculum -->
        <?php 
          include 'admin_classes/config_mysqli.php';      
          if(isset($_GET['deactivated'])){

            $curriculum = $_GET['curriculum'];

            print("
                <div class = 'alert alert-danger alert-dismissible alert-sm'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <span><b>$curriculum</b> has been deactivated!</span>
                </div>"
            );
          }
        ?> 

        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->
        <!--- Archived Curriculum -->
        <?php 
          include 'admin_classes/config_mysqli.php';      
          if(isset($_GET['archived'])){

            $curriculum = $_GET['curriculum'];

            print("
                <div class = 'alert alert-warning alert-dismissible alert-sm'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <span><b>$curriculum</b> has been archived!</span>
                </div>"
            );
          }
        ?> 

        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->
        <!--- restored Curriculum -->
        <?php 
          include 'admin_classes/config_mysqli.php';      
          if(isset($_GET['restored'])){

            $curriculum = $_GET['curriculum'];

            print("
                <div class = 'alert alert-success alert-dismissible alert-sm'>
                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                    <span><b>$curriculum</b> has been restored!</span>
                </div>"
            );
          }
        ?> 
        
        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->
        <!--- Deleted Department -->
        <?php 
            if(isset($_GET['deleted'])){

              $curriculum = $_GET['curriculum'];

                  print("
                      <div class = 'alert alert-danger alert-dismissible alert-sm'>
                          <button type='button' class='close' data-dismiss='alert'>&times;</button>
                          <span><b>$curriculum</b> has been deleted successfully!</span>
                      </div>"
                  );
              
          }
          ?> 

        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->

        <div class="row">
            <div class="col-lg-12">
              <div class="ibox ">
                <div class="ibox-title">

                  <!-- DEPARTMENT TITLE OF THE PAGE -->
                  <?php 
                    include 'admin_classes/config_mysqli.php';      
                    if(isset($_GET['department'])){

                        $department_id = $_GET['department_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
                        while($row = mysqli_fetch_array($query)){
                            $department_code = ucwords($row['department_code']);
                            $department_description = ucwords($row['department_description']);
                            
                            print("
                                <h3>$department_description ($department_code)</h3>
                            ");
                        }  
                    }
                  ?> 

                  <div class="ibox-tools">

                    <!--CHOOSE DEPARTMENT -->
                    <div class='dropdown' >
                      <button class='btn btn-success btn-xs dropdown-toggle' 
                        type='button' id='dropdownMenuButton' 
                        data-toggle='dropdown' 
                        aria-haspopup='true' 
                        aria-expanded='false'> <i class="fa fa-caret-down fa-lg"></i> Department 
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
                                    <a class='dropdown-item choose_department' href = 'registrar_manage_curriculum.php?department&department_id=$department_id' title = '$department_description'> <span style = 'color:black;'> $department_code </span></a>
                                    "); 
                            }                        
                        ?>  
                      </div>

                      <button type="button" 
                        class="btn btn-success btn-xs" 
                        data-toggle="modal" 
                        data-target="#myModal6" 
                        id = "add_new"> <i class="fa fa-plus" aria-hidden="true"></i> Add New 
                      </button>

                      <button type="button" 
                        class="btn btn-success btn-xs" 
                        data-toggle="modal" 
                        data-target="#archived_curriculum" 
                        id = "archived_curriculum_btn"> <i class="fa fa-archive fa-lg" aria-hidden="true"></i> Archived
                      </button>
                   
                    </div>  

                    <!---------------------------------------------------------------------------------------------------------------------------->
                    <!---------------------------------------------------------------------------------------------------------------------------->
                    <!-----MODAL FOR ADD NEW --------------->
                    <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
                      <div class="modal-dialog pt-reduced pb-reduced " >
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title"> Curriculum Registration </h5>
                          </div>
                        <div class="modal-body">
                        <!-----MODAL------->

                        <div class="row mt-2">
                            <div class="col-md">
                                <div class = "row">
                                  <div class="col-md-12">
                                    <label class="text-dark" style="font-weight: bold; float:left;" > DEPARTMENT</label>

                                    <?php
                                     include 'admin_classes/config_mysqli.php';      
                                     if(isset($_GET['department'])){
                 
                                         $department_id = $_GET['department_id'];
                 
                                         $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
                                         while($row = mysqli_fetch_array($query)){
                                             $department_code = ucwords($row['department_code']);
                                             $department_description = ucwords($row['department_description']);
                                          
                                          $department = $department_description." "."("."$department_code".")";
                                            print("
                                              <input type='text' id='department' value = '$department'  class='form-control border border-secondary rounded input-sm' disabled = 'disbaled'>
                                              <input type='text' id='department_id' value = '$department_id' hidden >
                                            "); 
                                        }   
                                      }                     
                                    ?>                            
                                  </div>                      
                                </div>
                            </div>
                        </div>

                       <br>

                          <div class="row mt-2">
                            <div class="col-md">
                                <div class = "row">
                                  <div class="col-md-6">
                                  <label class="text-dark" style="font-weight: bold; float:left;" > PROGRAM CODE</label>

                                      <select class="form-control border-secondary rounded input-sm" id = "program_id" >
                                        <option value = "" disabled selected hidden></option>

                                          <?php
                                            include 'admin_classes/config_mysqli.php';      
                                              if(isset($_GET['department'])){
                          
                                                $department_id = $_GET['department_id'];
                          
                                                $query = mysqli_query($con, "SELECT * FROM manage_program WHERE department_id = '$department_id' AND program_status = 1");
                                                  while($row = mysqli_fetch_array($query)){
                                                    $program_id = $row['program_id'];
                                                    $program_code = $row['program_code'];
                                                    $program_description = $row['program_description'];

                                                    print("
                                                  
                                                      <option value = '$program_id'> $program_code </option>

                                                    ");
                                              }
                                            }
                                          ?>   
                                      </select>    
 
                                  </div>
                                  <div class="col-md-6">
                                  <label class="text-dark" style="font-weight: bold; float:left;" > YEAR</label>
                                      <input type="number" id="curriculum_year" name='curriculum_year' class="form-control border border-secondary rounded input-sm" >                           
                                  </div>

                                </div>
                            </div>
                          </div>


                          <br>
                          <div id = "empty" style = "color: red; font-weight:bold;text-align:center;"></div>
                          <!-----1st row------->
                          <!----FILL UP--------->
                        </div>
                       
                        <div class="modal-footer">
                          <button type="button" class="btn btn-success btn-sm border-secondary" id="save_btn"> Save </button>
                          <button type="button" class="btn btn-light btn-sm border-secondary" data-dismiss="modal"> Cancel </button>
                        </div>
                      </div>
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
                      <form method = "POST" action = "admin_classes/archive_curriculum_script.php" id = "archive_form">
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

              <!---------------------------------------------------------------------------------------------------------------------------->
              <!---------------------------------------------------------------------------------------------------------------------------->
              <!-- Update Program Modal -->

              <div class="modal fade" id="update_modal" role="dialog" >
                  <div class="modal-dialog" style = "width:500px;">
                  <!-- Modal content-->
                      <div class="modal-content" >
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                          
                                <div style = "text-align:center;">
                                  <h2 style = 'font-weight:bold;'>Update Curriculum</h2><br><br>
                                </div>
                        <div class="modal-body" >
                            
                                <div id = "update_info" style = "text-align:left;"></div><br>

                                <div style ="color:red;font-weight:bold;text-align:center;" id = "empty_update"></div>
                            
                        </div>

                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                          <button type="button" class="btn btn-primary" id = 'update_btn' name='update_btn'>Update</button>
                        </div>
                      </div>
                  </div>
              </div>

              <!---------------------------------------------------------------------------------------------------------------------------->
              <!---------------------------------------------------------------------------------------------------------------------------->

              <!-- ACTIVATE Modal -->
              <div class="modal fade" id="activate_modal" role="dialog" >
                <div class="modal-dialog" style = "width:400px;">
                  <!-- Modal content-->
                  <div class="modal-content" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                      <div class="modal-body" style = "text-align:center;">
                        <form method = "POST" action = "admin_classes/activate_curriculum_script.php" id = "activate_form">
                            <div class = "activate_info"></div>
                        </form>
                       
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style = "float:right;">Close</button>
                        <input type='submit' id = 'activate_btn' class ="btn btn-primary" value='Activate' name='activate_btn' style = "float:right;">
                      </div>
                  </div>
                </div>
              </div>

              <!---------------------------------------------------------------------------------------------------------------------------->
              <!---------------------------------------------------------------------------------------------------------------------------->

              <!-- DEACTIVATE Modal -->
              <div class="modal fade" id="deactivate_modal" role="dialog" >
                  <div class="modal-dialog" style = "width:400px;">
                  <!-- Modal content-->
                      <div class="modal-content" >
                              <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                              </div>
                          <div class="modal-body" style = "text-align:center;">
                              <form method = "POST" action = "admin_classes/deactivate_curriculum_script.php" id = "deactivate_form">
                                  <div class = "deactivate_info" ></div>
                              </form>
                              
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style = "float:right;">Close</button>
                            <input type='submit' id = 'deactivate_btn' class ="btn btn-danger" value='Deactivate' name='deactivate' style = "float:right;">
                          </div>
                      </div>
                  </div>
              </div>

              <!---------------------------------------------------------------------------------------------------------------------------->
              <!---------------------------------------------------------------------------------------------------------------------------->

               <!-- Delete Department Modal -->
               <div class="modal fade" id="delete_modal" role="dialog" >
                  <div class="modal-dialog" style = "width:300px;"> 
                    <!-- Modal content-->
                    <div class="modal-content" >
                      <div class="modal-header" style = "color:red;">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body" style = "text-align:center;">
                          <form method = "POST" action = "admin_classes/delete_curriculum_script.php" id = "form_delete">
                              
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

              <!---------------------------------------------------------------------------------------------------------------------------->
              <!---------------------------------------------------------------------------------------------------------------------------->

              <!----TABLE SORTED-------->
              <div class="ibox-content">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead class="bg-success text-center">
                        <th > Curriculum </th>
                        <th > Program Description </th>
                        <th > Status </th>
                        <th > Action </th>
                      </thead>
                      <tbody class='text-center';>
                          
                      <?php 

                        include 'admin_classes/config_mysqli.php';      
                        if(isset($_GET['department'])){

                          $department_id = $_GET['department_id'];

                          $query = mysqli_query($con, "SELECT * FROM manage_curriculum 
                                                        JOIN manage_program ON manage_curriculum.program_id = manage_program.program_id 
                                                        WHERE manage_curriculum.department_id = '$department_id' 
                                                        AND manage_program.program_status = 1 ORDER BY manage_curriculum.curriculum_status DESC,
                                                        manage_curriculum.curriculum_year DESC");

                            while($row = mysqli_fetch_array($query)){

                              $curriculum_id     = $row['curriculum_id'];
                              $program_id        = $row['program_id'];
                              $department_id     = $row['department_id'];
                              $curriculum_year   = $row['curriculum_year'];
                              $curriculum_status = $row['curriculum_status'];

                              $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                while($row_program = mysqli_fetch_array($query_program)){
                                  $program_code = $row_program['program_code'];
                                  $program_description = $row_program['program_description'];
                          
                                    if($curriculum_status == 1){

                                      print 
                                      "
                                      <tr>
                                          <td > $program_code - $curriculum_year </td>
                                          <td > $program_description </td>
     
                                          <td style='text-align: center;'> <span class='badge badge-primary'>ACTIVE</span> </td>
                                          <td >
                                          <div class='dropdown dropleft'>
                                              <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                  Action 
                                              </button>

                                              <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                              <a class='dropdown-item' href='' data-id='$curriculum_id' data-toggle='modal' data-target = '#update_modal'     id = 'update'>   <i class='fa fa-pencil fa-fw'></i>Update</a>
                                              <a class='dropdown-item' href='' data-id='$curriculum_id' data-toggle='modal' data-target = '#deactivate_modal' id = 'activate'> <i class='fa fa-lock fa-fw'></i>Deactivate</a>
                                              <a class='dropdown-item' href='' data-id='$curriculum_id' data-toggle='modal' data-target = '#archive_modal'    id = 'archive'>  <i class='fa fa-archive fa-fw'></i>Archive</a>
                                              </div> 
                                          </div>                             
                                          </td>
                                      </tr>
                                      ";
                                      
                                    }else if($curriculum_status == 0){
                                      print 
                                      "
                                      <tr>
                                        <td > $program_code - $curriculum_year </td>
                                        <td > $program_description </td>
                                          
                                          <td style='text-align: center;'> <span class='badge badge-danger'>INACTIVE</span> </td>
                                          <td >
                                          <div class='dropdown dropleft'>
                                              <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                  Action 
                                              </button>

                                              <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                              <a class='dropdown-item' href='' data-id='$curriculum_id' data-toggle='modal' data-target = '#update_modal'   id = 'update'>   <i class='fa fa-pencil fa-fw'></i>Update</a>
                                              <a class='dropdown-item' href='' data-id='$curriculum_id' data-toggle='modal' data-target = '#activate_modal' id = 'activate'> <i class='fa fa-unlock fa-fw'></i>Activate</a>
                                              <a class='dropdown-item' href='' data-id='$curriculum_id' data-toggle='modal' data-target = '#archive_modal'  id = 'archive'>  <i class='fa fa-archive fa-fw'></i>Archive</a>
                                              </div> 
                                          </div>                             
                                          </td>
                                      </tr>
                                      ";

                                    }
                                }
                            }    
                                
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

        <div>
          <?php include 'bootstrap_lower/lower.php'; ?>
        </div>

<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->
<!-- Mainly scripts -->

<!-- ADD NEW CURRICULUM -->
<script>
  $(document).ready(function(){
  //Error mesages               
      $('#add_new').click(function(){  
        $("#curriculum_program_code").val('');   
        $("#curriculum_year").val('');   
        
    });
  });
</script>

<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!--shake effect on error -->

<!-- ADD -->
<script>

  $(document).ready(function(){
              
    $('#save_btn').click(function(){

      var faculty_user_id   = $('#account_user_id').val();
      var program_id        = $('#program_id').val();
      var curriculum_year   = $('#curriculum_year').val();
      var department_id     = $('#department_id').val();

        if(program_id == "" || curriculum_year == ""){       
          
          $("#empty").html("Invalid Attempt! Please enter a value!");
                $("#empty").show();   
                $('#empty').effect("shake");
        }else{

          $.ajax({
            url: "admin_classes/reg_manage_curriculum_insert.php",
            type: "POST",
            data: {

              faculty_user_id  :faculty_user_id,
              program_id       :program_id,
              curriculum_year  :curriculum_year,
              department_id    :department_id            
            },
            cache: false,
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    window.location = "registrar_manage_curriculum.php?department&department_id=<?php echo $department_id;?>&added";						
                }else if(dataResult.statusCode==201){
                  
                  $("#empty").show();  
                    $('#empty').html('Program Code and Year already exists!'); 
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
<!-- UPDATE PROGRAM -->

<script>
    $(document).ready(function(){
        $('#update').click(function(){      
          $('#empty_update').hide();
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('.dropdown-item').click(function(){
        
          var curriculum_id   = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/update_curriculum_form.php',
            type: 'POST',
            data: {

              curriculum_id   :curriculum_id
            },
            success: function(response){ 
                // Add response in Modal body
                $('#update_info').html(response);
            }
            });
        });
    });
</script>

<!-- FORM UPDATE PROGRAM-->
<script>
    $(document).ready(function(){
      $('#update_btn').click(function(){

      var program_id_new = $('#program_id_new').val();
      var curriculum_year_new = $('#curriculum_year_new').val();

      //hidden input field
      var program_id_old        = $('#program_id_old').val();
      var curriculum_year_old   = $('#curriculum_year_old').val();
      var department_id_hid     = $('#department_id_hid').val();
      var curriculum_id_hid     = $('#curriculum_id_hid').val();
      var faculty_user_id       = $('#account_user_id').val();

      if(program_id_new == '' || curriculum_year_new == ''){       
          
        $('#empty_update').html('Invalid Attempt! Please enter a value!');
        $('#empty_update').show();   
        $('#empty_update').effect('shake');
                
      }else{

          $.ajax({
            url: "admin_classes/update_curriculum_ajax.php",
            type: "POST",
            data: {

              faculty_user_id     :faculty_user_id,
              program_id_new      :program_id_new,
              curriculum_year_new :curriculum_year_new,
              program_id_old      :program_id_old,
              curriculum_year_old :curriculum_year_old,
              department_id_hid   :department_id_hid,
              curriculum_id_hid   :curriculum_id_hid
                         },
            cache: false,
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    window.location = "registrar_manage_curriculum.php?department&department_id=<?php echo $department_id; ?>&updated";						
                }else if(dataResult.statusCode==201){
                   
                  $("#empty_update").show();  
                    $('#empty_update').html('Curriculum already exists!'); 
                    $('#empty_update').effect("shake");                                 
                   
                }   
            }
          });
        }
      
      });   
    });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- ACTIVATE PROGRAM -->
<script>
    $(document).ready(function(){
        $('.dropdown-item').click(function(){

          var faculty_user_id = $('#account_user_id').val();
          var curriculum_id   = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/activate_curriculum_ajax.php',
            type: 'POST',
            data: {
              faculty_user_id :faculty_user_id,
              curriculum_id   :curriculum_id
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
<!-- DEACTIVATE PROGRAM -->

<script>
    $(document).ready(function(){
        $('.dropdown-item').click(function(){

          var faculty_user_id  = $('#account_user_id').val();
          var curriculum_id    = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/deactivate_curriculum_ajax.php',
            type: 'POST',
            data: {
              faculty_user_id :faculty_user_id,
              curriculum_id   :curriculum_id
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

          var faculty_user_id     = $('#account_user_id').val();
          var curriculum_id       = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/archive_curriculum_ajax.php',
            type: 'POST',
            data: {

                faculty_user_id :faculty_user_id,
                curriculum_id   :curriculum_id
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

<!-- RESTORE  -->
<script>
  $(document).ready(function(){
    $(document).on('click', '#restore_curriculum', function(){

      var faculty_user_id   = $('#account_user_id').val();
      var curriculum_id     = $(this).data('id');

    // AJAX request
        $.ajax({
        url: 'admin_classes/restore_curriculum_ajax.php',
        type: 'POST',
        data: {

            faculty_user_id :faculty_user_id,
            curriculum_id   :curriculum_id
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

<!-- DELETE CURRICULUM -->
<script>
  $(document).ready(function(){
      $('.dropdown-item').click(function(){

        var faculty_user_id  = $('#account_user_id').val();
        var curriculum_id    = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/delete_curriculum_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            curriculum_id   :curriculum_id
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

</body>
</html>
