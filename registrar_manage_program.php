<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_registrar.php";
?>

<!DOCTYPE html>
  <html>
    <head>
        <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Program </title>

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

      <div id="wrapper">
        <!----------------------------------------------------------------------------------------------------------------------------->
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
              <li class="active">
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

        
        <!------SIDE NAV--------------------------------------------------------------------------------------------------------------->
        <!----------------------------------------------------------------------------------------------------------------------------->

        <!----HEADER---------->
        <div id="page-wrapper" class="gray-bg">
          <?php include 'bootstrap_lower/header.php';?>
        <!----HEADER---------->

          <!----UNDER HEADER------------>
          <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
              <div class="col-lg-10">
                <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Program List </p>
              </div>
          </div>

          <!------------------------------------------------------------------------------------------------------------------------>
          <!------------------------------------------------------------------------------------------------------------------------>
          <!---HIDDEN DATA--->
          <!---faculty_user_id--->
          <?php include "include/faculty_user_id.php"; ?>
          
          <!--HIDES ADD NEW BUTTON -->
          <?php 
              
              if(!isset($_GET['department'])){
                print "                           
                  <script>
                      $(document).ready(function(){                                 
                            $('#add_new').hide();  
                            $('#archived_program_btn').hide();                              
                      });
                  </script>      
                ";        
              }
            ?> 

            <!--------------------------------------------------------------------------------------------------------------------->
            <!--------------------------------------------------------------------------------------------------------------------->
            <!--- ARCHIVED --->
            <div class="modal fade" id="archived_program" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog modal-lg" >
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"> Archived Departments </h5>
                  </div>

                    <div class="modal-body">
                      <?php
                        include 'admin_classes/config_mysqli.php';

                        $query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_status = 2
                          ORDER BY program_code ASC");

                          if (mysqli_num_rows($query) > 0){

                            print "  
                              <table class='table table-striped'>
                                <thead class='bg-success text-center'>
                                  <th>PROGRAM CODE</th>
                                  <th>DESCRIPTION</th>
                                  <th>STATUS</th>
                                  <th>ACTION</th>
                                </thead>
                                <tbody class='text text-dark'>";

                            while($row = mysqli_fetch_array($query)){
                              
                              $program_id           = $row['program_id'];
                              $program_code         = $row['program_code'];
                              $program_description  = $row['program_description'];
                      
                              print("
                                <tr style = 'text-align:center;'>

                                  <td> $program_code </td>
                                  <td> $program_description </td>
                                  <td style='text-align: center;'> <span class='badge badge-pill badge-warning'>ARCHIVED</span> </td>

                                  <td style='text-align: center;'> 
                                    <button type='button'
                                    id = 'restore_program'
                                    class = 'btn btn-primary btn-xs mr-2' 
                                    data-id='$program_id'
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

            <!------------------------------------------------------------------------------------------------------------------------>
            <!------------------------------------------------------------------------------------------------------------------------>
            
            <!-- Restore Program -->
            <div class="modal fade" id="restore_confirm_modal" role="dialog" >
              <div class="modal-dialog" style = "width:400px;">
              <!-- Modal content-->
                <div class="modal-content" >
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body" style = "text-align:center;">
                    <form method = "POST" action = "admin_classes/restore_program_script.php" id = "restore_form">
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

          <!----------------------------------------------------------------------------------------------------------------------------->
          <!----DATA TABLES ONE---------------------------------------------------------------------------------------------------------->
          <div class="wrapper wrapper-content animated fadeInRight">

            <!--------------------------------------------------------------------------------------------------------------------->
            <!--------------------------------------------------------------------------------------------------------------------->
            <!---Added Program -->
            <?php             
              include 'admin_classes/config_mysqli.php';    
                if(isset($_GET['added'])){
                  $program_id =  $_SESSION['program_id'];
                  $department_id =  $_SESSION['department_id'];

                  $query = mysqli_query($con, "SELECT * from manage_program WHERE program_id = '$program_id'");
                  $row = mysqli_fetch_array($query);

                  $program_code = $row['program_code'];
                  $program_description = $row['program_description'];

                    print("
                    <div class = 'alert alert-primary alert-dismissible alert-sm'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        <span><b>$program_description ($program_code) </b> has been successfully added!</b></span>
                    </div>"
                    );    
                }
            ?>

            <!--------------------------------------------------------------------------------------------------------------------->
            <!--------------------------------------------------------------------------------------------------------------------->
            <!---Updated Program -->
            <?php             
              include 'admin_classes/config_mysqli.php';    
                if(isset($_GET['updated'])){

                  $program_id =  $_SESSION['program_id'];
                  
                  $program_code = $_SESSION['program_code'];
                  $program_description = $_SESSION['program_description'];

                  $program_code_hid = $_SESSION['program_code_hid'];
                  $program_description_hid = $_SESSION['program_description_hid'];
                                      
                  $query = mysqli_query($con, "SELECT * from manage_program WHERE program_id = '$program_id'");
                  $row = mysqli_fetch_array($query);

                  $program_code = $row['program_code'];
                  $program_description = $row['program_description'];

                    print("
                      <div class = 'alert alert-primary alert-dismissible alert-sm'>
                          <button type='button' class='close' data-dismiss='alert'>&times;</button>
                          <span><b>$program_description_hid ($program_code_hid)</b> updated to <b>$program_description ($program_code)</b></span>
                      </div>"
                    ); 
                          
                }                        
              
            ?>

            <!--------------------------------------------------------------------------------------------------------------------->
            <!--------------------------------------------------------------------------------------------------------------------->
            <!--- Activated Program -->
            <?php 
              include 'admin_classes/config_mysqli.php';      
              if(isset($_GET['activated'])){

                  $program_id = $_GET['program_id'];

                  $query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                  while($row = mysqli_fetch_array($query)){
                      $program_code = ucwords($row['program_code']);
                      $program_description = ucwords($row['program_description']);
                      
                      print("
                          <div class = 'alert alert-success alert-dismissible alert-sm'>
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                              <span><b>$program_description ($program_code)</b> has been activated!</span>
                          </div>"
                      );
                  }  
                }
            ?> 

            <!--------------------------------------------------------------------------------------------------------------------->
            <!--------------------------------------------------------------------------------------------------------------------->
            <!--- Deactivated program -->
            <?php 
              include 'admin_classes/config_mysqli.php';      
              if(isset($_GET['deactivated'])){

                  $program_id = $_GET['program_id'];

                  $query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                  while($row = mysqli_fetch_array($query)){
                      $program_code = ucwords($row['program_code']);
                      $program_description = ucwords($row['program_description']);

                      print("
                          <div class = 'alert alert-danger alert-dismissible alert-sm'>
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                              <span><b>$program_description ($program_code)</b> has been deactivated!</span>
                          </div>"
                      );
                  }  
              }
            ?> 

            <!--------------------------------------------------------------------------------------------------------------------->
            <!--------------------------------------------------------------------------------------------------------------------->
            <!--- archived program -->
            <?php 
              include 'admin_classes/config_mysqli.php';      
              if(isset($_GET['archived'])){

                  $program_id = $_GET['program_id'];

                  $query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                  while($row = mysqli_fetch_array($query)){
                      $program_code = ucwords($row['program_code']);
                      $program_description = ucwords($row['program_description']);

                      print("
                          <div class = 'alert alert-warning alert-dismissible alert-sm'>
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                              <span><b>$program_description ($program_code)</b> has been archived!</span>
                          </div>"
                      );
                  }  
              }
            ?> 

            <!--------------------------------------------------------------------------------------------------------------------->
            <!--------------------------------------------------------------------------------------------------------------------->
            <!--- restored program -->
            <?php 
              include 'admin_classes/config_mysqli.php';      
              if(isset($_GET['restored'])){

                  $program_id = $_GET['program_id'];

                  $query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                  while($row = mysqli_fetch_array($query)){
                      $program_code = ucwords($row['program_code']);
                      $program_description = ucwords($row['program_description']);

                      print("
                          <div class = 'alert alert-success alert-dismissible alert-sm'>
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                              <span><b>$program_description ($program_code)</b> has been restored!</span>
                          </div>"
                      );
                  }  
              }
            ?> 

            <!--------------------------------------------------------------------------------------------------------------------->
            <!--------------------------------------------------------------------------------------------------------------------->
            <!--- Deleted Program -->
            <?php 
                if(isset($_GET['deleted'])){

                  $program = $_GET['program'];

                      print("
                          <div class = 'alert alert-danger alert-dismissible alert-sm'>
                              <button type='button' class='close' data-dismiss='alert'>&times;</button>
                              <span><b>$program</b> has been deleted successfully!</span>
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
                        <button class='btn btn-success btn-xs dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                          <i class="fa fa-caret-down fa-lg"></i> Department 
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
                                      <a class='dropdown-item choose_department' href = 'registrar_manage_program.php?department&department_id=$department_id' title = '$department_description'> <span style = 'color:black;'> $department_code </span></a>
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
                          data-target="#archived_program" 
                          id = "archived_program_btn"> <i class="fa fa-archive fa-lg" aria-hidden="true"></i> Archived
                        </button>
                      
                      </div>  

                      <!-----MODAL FRAME ADD------------>
                      <!-----MODAL---------------------->
                      <!-----MODAL FOR ADNEW ----------->
                      <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog pt-reduced pb-reduced " >
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title"> Program Registration </h5>
                            </div>
                            <div class="modal-body">

                              <!---------------------------------------------------------------------------------------------------------------------------->
                              <!--------DEPARTMENT--------------->

                              <div class="row mt-2">
                                <div class="col-sm">
                                  <table>
                                    <td>
                                      <label class="text-dark" style="font-weight: bold;" > DEPARTMENT</label>
                                    </td>
                                  </table>

                                  <input type = "text" 
                                    class = "form-control border border-secondary rounded input-sm" 
                                    id = "" 
                                    value = "<?php 
                                              include 'admin_classes/config_mysqli.php';

                                              if(isset($_GET['department_id'])){
                                                $department_id = $_GET['department_id'];

                                                $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
                                                while($row = mysqli_fetch_array($query)){
                                                  $department_code = $row['department_code'];
                                                  $department_description = $row['department_description'];

                                                    print "$department_code - $department_description";
                                                }
                                              }
                                            ?>" 
                                    readonly>

                                   <!-- Hidden Department ID -->
                                   <input type = "text" 
                                    class = "form-control border border-secondary rounded input-sm" 
                                    id = "department_id" 
                                    value = "<?php 
                                              if(isset($_GET['department_id'])){
                                                $department_id = $_GET['department_id'];

                                                  print "$department_id";
                                              }
                                            ?>" 
                                    hidden>

                              
                                </div>
                              </div>

                              <!--------PROGRAM CODE--------------->
                              <div class="row mt-2">
                                <div class="col-sm">
                                  <input type="hidden" >
                                    <table>
                                      <td>
                                        <label class="text-dark" style="font-weight: bold;" > PROGRAM CODE</label>
                                      </td>
                                    </table>
                                    <input type="text" class="form-control border border-secondary rounded input-sm" id = "program_code">
                                </div>
                              </div>

                              <!--------PROGRAM DESCRIPTION--------------->
                              <div class="row mt-2">
                                  <div class="col-sm">
                                        <table>
                                          <td>
                                            <label class="text-dark" style="font-weight: bold;" > PROGRAM DESCRIPTION</label>
                                          </td>
                                        </table>
                                        <input type="text" class="form-control border border-secondary rounded input-sm" id="program_description">
                                  </div>       
                              </div>
                            
                              <!--ERROR MESSAGE-->
                              <br><div style = "color:red; font-weight:bold;text-align:center" id = "empty"></div>

                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-success btn-sm border-secondary" id="save_btn"> Save </button>
                              <button type="button" class="btn btn-light btn-sm border-secondary" data-dismiss="modal"> Cancel </button>
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
                                          <h2 style = 'font-weight:bold;'>Update Program</h2><br><br>
                                        </div>
                                <div class="modal-body" >
                                    
                                        <div id = "update_info" style = "text-align:left;"></div>

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
                                <form method = "POST" action = "admin_classes/activate_program_script.php" id = "activate_form">
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
                                      <form method = "POST" action = "admin_classes/deactivate_program_script.php" id = "deactivate_form">
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

                      <!-- ARCHIVE Modal -->
                      <div class="modal fade" id="archive_modal" role="dialog" >
                        <div class="modal-dialog" style = "width:400px;">
                        <!-- Modal content-->
                          <div class="modal-content" >
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body" style = "text-align:center;">
                              <form method = "POST" action = "admin_classes/archive_program_script.php" id = "archive_form">
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

                      <!-- Delete Program Modal -->
                      <div class="modal fade" id="delete_modal" role="dialog" >
                          <div class="modal-dialog" style = "width:300px;"> 
                          <!-- Modal content-->
                              <div class="modal-content" >
                                      <div class="modal-header" style = "color:red;">
                                          
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                  <div class="modal-body" style = "text-align:center;">
                                      <form method = "POST" action = "admin_classes/delete_program_script.php" id = "form_delete">
                                          
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

                      <!-----MODAL FRAME------------------------------------------------------------------------------------------------------------>
                      <!---------------------------------------------------------------------------------------------------------------------------->

                    </div>
                  </div>

                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!----TABLE SORTED------------>
                
                  
                  <div class = 'program_list'>
                    <div class='ibox-content'>
                      <div class='table-responsive'>
                        <table class='table table-striped'>
                          <thead class='bg-success text-center'>
                            <th > Program Code </th>
                            <th > Description </th>
                            <th > Department </th>
                            <th > Status </th>
                            <th > Action </th>
                          </thead>
                            <tbody class='text-center';>

                            <?php 

                              include 'admin_classes/config_mysqli.php';      
                              if(isset($_GET['department'])){

                                $department_id = $_GET['department_id'];

                                $query = mysqli_query($con, "SELECT * FROM manage_program WHERE department_id = '$department_id' ORDER BY program_code ASC");

                                  
                                  while($row = mysqli_fetch_array($query)){

                                    $program_id = $row['program_id'];
                                    $program_code = $row['program_code'];
                                    $program_description = $row['program_description'];
                                    $program_status = $row['program_status'];
                                    $department_id = $row['department_id'];

                                    $query_department = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
                                      while($row = mysqli_fetch_array($query_department)){
                                        $department_code = $row['department_code'];
                                        $department_description = $row['department_description'];
                                
                                          if($program_status == 1){

                                            print 
                                            "
                                            <tr>
                                                <td > $program_code </td>
                                                <td > $program_description </td>
                                                <td title = '$department_description'> $department_code </td>
                                                <td style='text-align: center;'> <span class='badge badge-primary'>ACTIVE</span> </td>
                                                <td >
                                                <div class='dropdown dropleft'>
                                                    <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        Action 
                                                    </button>

                                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                                      <a class='dropdown-item' href='' data-id='$program_id' data-toggle='modal' data-target = '#update_modal'     id = 'update'>   <i class='fa fa-pencil fa-fw'></i>Update</a>
                                                      <a class='dropdown-item' href='' data-id='$program_id' data-toggle='modal' data-target = '#deactivate_modal' id = 'activate'> <i class='fa fa-lock fa-fw'></i>Deactivate</a>
                                                      <a class='dropdown-item' href='' data-id='$program_id' data-toggle='modal' data-target = '#archive_modal'    id = 'archive'>  <i class='fa fa-archive fa-fw'></i>Archive</a>
                                                    </div> 
                                                </div>                             
                                                </td>
                                            </tr>
                                            ";
                                            
                                          }else if($program_status == 0){
                                            print 
                                            "
                                            <tr>
                                                <td > $program_code </td>
                                                <td > $program_description </td>
                                                <td title = '$department_description'> $department_code </td>
                                                <td style='text-align: center;'> <span class='badge badge-danger'>INACTIVE</span> </td>
                                                <td >
                                                <div class='dropdown dropleft'>
                                                    <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        Action 
                                                    </button>

                                                    <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                                      <a class='dropdown-item' href='' data-id='$program_id' data-toggle='modal' data-target = '#update_modal'   id = 'update'>   <i class='fa fa-pencil fa-fw'></i>Update</a>
                                                      <a class='dropdown-item' href='' data-id='$program_id' data-toggle='modal' data-target = '#activate_modal' id = 'activate'> <i class='fa fa-unlock fa-fw'></i>Activate</a>
                                                      <a class='dropdown-item' href='' data-id='$program_id' data-toggle='modal' data-target = '#archive_modal'  id = 'archive'>  <i class='fa fa-archive fa-fw'></i>Archive</a>
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
        </div>
        
<!----DATA TABLES ONE-------------->
<!---------------------------------------------------------------------------------------------------------------------------->

<div> 
  <?php include 'bootstrap_lower/lower.php'; ?>
</div>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- Mainly scripts -->

<!-- ADD NEW PROGRAM -->
<script>
  $(document).ready(function(){
  //Error mesages               
      $('#add_new').click(function(){  
        $("#program_code").val('');   
        $("#program_description").val('');  
        $("#empty").hide();  
        
    });
  });
</script>

<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!--shake effect on error -->

<script>
  $(document).ready(function(){
              
    $('#save_btn').click(function(){
    
      var faculty_user_id      = $('#account_user_id').val();
      var program_code         = $('#program_code').val();
      var program_description  = $('#program_description').val();
      var department_id        = $('#department_id').val();

        if(program_code == "" || program_description == ""){       
          
          $("#empty").html("Invalid Attempt! Please enter a value!");
                $("#empty").show();   
                $('#empty').effect("shake");
        }else{

          $.ajax({
            url: "admin_classes/reg_manage_program_insert.php",
            type: "POST",
            data: {

              faculty_user_id      :faculty_user_id,
              program_code         :program_code,
              program_description  :program_description,
              department_id        :department_id            
            },
            cache: false,
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                
                    window.location = "registrar_manage_program.php?department&department_id=<?php echo $department_id; ?>&program_id=<?php echo $_SESSION['program_id']; ?>&added";						
                }else if(dataResult.statusCode==201){
                  
                  $("#empty").show();  
                  $('#empty').html('Program Code or Program Description already exists!'); 
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
        
          var program_id       = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/update_program_form.php',
            type: 'POST',
            data: {
              
              program_id       :program_id
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

      var program_code       = $('#program_code_update').val();
      var program_description = $('#program_description_update').val();

      if(program_code == '' || program_description == ''){       
          
          $('#empty_update').html('Invalid Attempt! Please enter a value!');
                $('#empty_update').show();   
                $('#empty_update').effect('shake');
                
      }else{

          var program_code = $('#program_code_update').val();
          var program_description = $('#program_description_update').val();
          var program_id = $('#program_id_hid').val();
          

          //hidden input field
          var faculty_user_id         = $('#account_user_id').val();
          var program_code_hid        = $('#program_code_hid').val();
          var program_description_hid = $('#program_description_hid').val();
          var department_id_hid       = $('#department_id_hid').val();
         
          $.ajax({
            url: "admin_classes/update_program_ajax.php",
            type: "POST",
            data: {

              faculty_user_id :faculty_user_id,
              program_code: program_code,
              program_description: program_description,
              program_id: program_id,
              program_code_hid: program_code_hid,
              program_description_hid: program_description_hid,
              department_id_hid: department_id_hid            },
            cache: false,
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    window.location = "registrar_manage_program.php?department&department_id=<?php echo $department_id; ?>&updated";						
                }else if(dataResult.statusCode==201){
                   
                  $("#empty_update").show();  
                    $('#empty_update').html('Program Code or Description already exists!'); 
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

          var faculty_user_id  = $('#account_user_id').val();
          var program_id       = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/activate_program_ajax.php',
            type: 'POST',
            data: {
              faculty_user_id :faculty_user_id,
              program_id      :program_id
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
          var program_id       = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/deactivate_program_ajax.php',
            type: 'POST',
            data: {
              faculty_user_id :faculty_user_id,
              program_id      :program_id
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
          var program_id       = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/archive_program_ajax.php',
            type: 'POST',
            data: {

                faculty_user_id :faculty_user_id,
                program_id      :program_id
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
        $(document).on('click', '#restore_program', function(){

          var faculty_user_id   = $('#account_user_id').val();
          var program_id     = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/restore_program_ajax.php',
            type: 'POST',
            data: {

                faculty_user_id :faculty_user_id,
                program_id      :program_id
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

<!-- DELETE PROGRAM -->
<script>
  $(document).ready(function(){
      $('.dropdown-item').click(function(){

        var faculty_user_id  = $('#account_user_id').val();
        var program_id       = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/delete_program_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            program_id      :program_id
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
