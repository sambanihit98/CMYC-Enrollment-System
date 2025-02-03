<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_system_admin.php";
?>

<!DOCTYPE html>
<html>
  <head>
    <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Designation </title>

    <?php include "include/tab_icon.php"; ?>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link rel='stylesheet' href='https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css'>
    <link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css'>
    <link rel='stylesheet' href='https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css'>
  </head>
  <body>
    <div id="wrapper">

    <!---------------------------------------------------------------------------------------------------------------------------->
    <!------SIDE NAV-------------------------------------------------------------------------------------------------------------->
      <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
          <ul class="nav metismenu" id="side-menu">

            <li class="nav-header">
                <?php include 'bootstrap_lower/side_name_logo.php'; ?>  
            </li>

            <li>
                <a href="admin_dashboard.php"><i class="fa fa-lg fa-home" aria-hidden="true"></i> <span class="nav-label">Home</span></a>
            </li>

            <li>
                <a href="admin_data_dashboard.php"><i class="fa fa-lg fa-bar-chart" aria-hidden="true"></i> <span class="nav-label">Data Dashboard</span></a>
            </li>

            <li>
                <a href="admin_academic.php"><i class="fa fa-lg fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">Academic Year</span></a>
            </li>

            <li  class="active">
                <a href="admin_designation.php"><i class="fa fa-lg fa-user-plus" aria-hidden="true"></i> <span class="nav-label">Designation</span></a>
            </li>

            <li>
              <a href="admin_user_log.php"><i class="fa fa-lg fa-list"></i> <span class="nav-label"> User Log</span></a>
            </li>
            
            <li>
              <a href="admin_announcements.php"><i class="fa fa-bullhorn"></i> <span class="nav-label">Announcements</span></a>
            </li>

            <li>
                <a href="admin_account_settings.php"><i class="fa fa-lg fa-cog" aria-hidden="true"></i> <span class="nav-label">Account Settings</span></a>
            </li>

          </ul>
        </div>
      </nav>
      <!------------------------------------------------------------------------------------------------------------------------>
      <!----HEADER-------------------------------------------------------------------------------------------------------------->

      <div id="page-wrapper" class="gray-bg">
        <?php include 'bootstrap_lower/header.php';?>

        <!----UNDER HEADER---->
        <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
          <div class="col-lg-10">
            <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Designation </p>
          </div>
        </div>

      <!------------------------------------------------------------------------------------------------------------------------>
      <!------------------------------------------------------------------------------------------------------------------------>

      <!---faculty_user_id--->
      <?php include "include/faculty_user_id.php"; ?>

      <!--------------------------------------------------------------------------------------------------------------------->
      <!--------------------------------------------------------------------------------------------------------------------->
      <!--- ARCHIVED --->
      <div class="modal fade" id="archived_faculty_account" tabindex="-1" role="dialog"  aria-hidden="true">
        <div class="modal-dialog modal-lg" >
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"> Archived Faculty Accounts </h5>
            </div>

              <div class="modal-body">
                <?php
                  include 'admin_classes/config_mysqli.php';

                  $query = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_status = 2
                  ORDER BY account_firstname ASC, account_lastname ASC");

                    if (mysqli_num_rows($query) > 0){

                      print "  
                        <table class='table table-striped'>
                          <thead class='bg-success text-center'>
                            <th>ID NUMBER</th>
                            <th>FIRSTNAME</th>
                            <th>LASTNAME</th>
                            <th>ACCOUNT TYPE</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                          </thead>
                          <tbody class='text text-dark'>";

                      while($row = mysqli_fetch_array($query)){
                        
                        $account_user_id   = $row['account_user_id'];
                        $account_firstname = $row['account_firstname'];
                        $account_lastname  = $row['account_lastname'];
                        $account_position  = $row['account_position'];
                        $account_status    = $row['account_status'];
                
                        print("
                          <tr style = 'text-align:center;'>

                            <td> $account_user_id </td>
                            <td> $account_firstname </td>
                            <td> $account_lastname </td>
                            <td> $account_position </td>
                            <td style='text-align: center;'> <span class='badge badge-pill badge-warning'>ARCHIVED</span> </td>

                            <td style='text-align: center;'> 
                              <button type='button'
                              id = 'restore_faculty_account'
                              class = 'btn btn-primary btn-xs mr-2' 
                              data-id='$account_user_id'
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
      
      <!-- Restore FACULTY ACCOUNT -->
      <div class="modal fade" id="restore_confirm_modal" role="dialog" >
        <div class="modal-dialog" style = "width:400px;">
        <!-- Modal content-->
          <div class="modal-content" >
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style = "text-align:center;">
              <form method = "POST" action = "admin_classes/restore_faculty_account_script.php" id = "restore_form">
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

      <!------------------------------------------------------------------------------------------------------------------------>
      <!------------------------------------------------------------------------------------------------------------------------>
        <!----DATA TABLES ONE-------------------------------------------------------------------------------------------------------------->
        <div class="wrapper wrapper-content animated fadeInRight">
          <div class="row">
            <div class="col-lg-12">
              <div class="ibox ">
                <div class="ibox-title">
                  <h5> </h5>
                  <div class="ibox-tools">

                    <button type="button" 
                            class="btn btn-success btn-xs" 
                            data-toggle="modal" 
                            data-target="#myModal6">
                        <i class="fa fa-plus fa-lg" aria-hidden="true"></i> 
                        Add New
                    </button>

                    <button type="button" 
                            class="btn btn-success btn-xs" 
                            data-toggle="modal" 
                            data-target="#archived_faculty_account" 
                            id = "archived_faculty_account_btn">
                          <i class="fa fa-archive fa-lg" aria-hidden="true"></i> 
                          Archived
                    </button>

                    <!---MODAL FOR ADD NEW --------->
                    <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
                      <div class="modal-dialog pt-reduced pb-reduced" >
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title"> Account Registration </h5>                                      
                          </div>

                          <div class="modal-body">

                            <!-----FILL UP------->
                            <!-----1st row------->
                            <div class="row mt-2">
                              <div class="col-sm">
                                <table>
                                  <tr>
                                    <td>
                                      <label class="text-dark" style="font-weight: bold;" >FIRSTNAME </label>
                                    </td>
                                  </tr>
                                </table>
                                <input type="text" class="form-control border border-secondary rounded input-sm" name="account_firstname" id="account_firstname" >
                              </div>

                              <div class="col-sm">
                                <table>
                                  <tr>
                                    <td>
                                      <label class="text-dark" style="font-weight: bold;" >LASTNAME </label>
                                    </td>
                                  </tr>
                                </table>
                                <input type="text" class="form-control border border-secondary rounded input-sm" name="account_lastname" id="account_lastname" >
                              </div>
                            </div>

                            <div class="row mt-2">
                              <div class="col-sm">
                                <table>
                                  <tr>
                                    <td>
                                      <label class="text-dark" style="font-weight: bold;" >ACCOUNT TYPE</label>
                                    </td>
                                  </tr>
                                </table>
                                <select class="form-control border border-secondary rounded input-sm" name="account_position" id="account_position">
                                  <option value="" hidden>Select Position</option>
                                  <option value="System Admin">System Admin</option>
                                  <option value="Teacher">Teacher</option>
                                  <option value="Registrar">Registrar</option>               
                                </select>
                              </div>        
                            </div>

                            <div class = 'mt-4' id = 'error' style = 'color:red; font-weight:bold; text-align:center'></div>

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

                <!-- Update Modal -->
                <div class="modal fade" id="update_modal" role="dialog" >
                    <div class="modal-dialog" style = "width:500px;">
                    <!-- Modal content-->
                        <div class="modal-content" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body" style = "text-align:center;">
                                <h2 style = 'font-weight:bold;'>Update Account</h2><br><br>                                                   
                                <div id = "update_info"></div>
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
                          <form method = "POST" action = "admin_classes/activate_faculty_script.php" id = "activate_form">
                              <div class = "activate_info"></div>
                          </form>
                          
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                              <button type="button" class="btn btn-primary" id = 'activate_btn' name='activate_btn'>Activate</button>
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
                                <form method = "POST" action = "admin_classes/deactivate_faculty_script.php" id = "deactivate_form">
                                    <div class = "deactivate_info" ></div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
                                <button type="button" class="btn btn-warning" id = 'deactivate_btn' name='deactivate_btn'>Deactivate</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!---------------------------------------------------------------------------------------------------------------------------->
                <!---------------------------------------------------------------------------------------------------------------------------->

                  <!-- reset_password -->
                <div class="modal fade" id="reset_password_modal" role="dialog" >
                  <div class="modal-dialog" style = "width:400px;"> 
                  <!-- Modal content-->
                    <div class="modal-content" >
                        <div class="modal-header" style = "color:red;">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body" style = "text-align:center;">
                          <form method = "POST" action = "admin_classes/reset_password_faculty_script.php" id = "form_reset_password">
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
                        <form method = "POST" action = "admin_classes/archive_faculty_account_script.php" id = "archive_form">
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

                <!-- Delete Modal -->
                <div class="modal fade" id="delete_modal" role="dialog" >
                    <div class="modal-dialog" style = "width:400px;"> 
                    <!-- Modal content-->
                        <div class="modal-content" >
                                <div class="modal-header" style = "color:red;">
                                    
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                            <div class="modal-body" style = "text-align:center;">
                                <form method = "POST" action = "admin_classes/delete_faculty_account_script.php" id = "form_delete">
                                    
                                    <h3> Are you sure you want to remove the account of</h3>  
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

                <!----TABLE SORTED---------->
                <div class="ibox-content">

                  <div class = "row">
                    <div class = "col-md-3">
                      <input class="form-control" type="search" id="search" placeholder="Search..." aria-label="Search">
                    </div>
                  </div><br>

                  <div class="table-responsive">       
                      
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--- Password Reset -->
                    <?php   
                      if(isset($_GET['password_reset'])){

                        $fullname = $_GET['name'];

                        print("
                          <div class = 'alert alert-primary alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span> <i class='fa fa-exclamation-circle'></i> <b>$fullname</b>'s password has been updated back to default succesfully!</span>
                          </div>"
                        );
                      }
                    ?> 
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--- deleted -->
                    <?php   
                      if(isset($_GET['deleted'])){

                        $fullname = $_GET['name'];

                        print("
                          <div class = 'alert alert-danger alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span> <i class='fa fa-exclamation-circle'></i> <b>$fullname</b>'s account has been deleted succesfully!</span>
                          </div>"
                        );
                      }
                    ?> 
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--- added -->
                    <?php   
                      if(isset($_GET['added'])){

                        print("
                          <div class = 'alert alert-success alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span> <i class='fa fa-exclamation-circle'></i> New user has been added succesfully!</span>
                          </div>"
                        );
                      }
                    ?> 
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--- deactivated -->
                    <?php   
                      if(isset($_GET['deactivated'])){

                        $fullname = $_GET['name'];

                        print("
                          <div class = 'alert alert-danger alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span> <i class='fa fa-exclamation-circle'></i> <b>$fullname</b>'s account has been deactivated succesfully!</span>
                          </div>"
                        );
                      }
                    ?> 
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--- activated -->
                    <?php   
                      if(isset($_GET['activated'])){

                        $fullname = $_GET['name'];

                        print("
                          <div class = 'alert alert-success alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span> <i class='fa fa-exclamation-circle'></i> <b>$fullname</b>'s account has been activated succesfully!</span>
                          </div>"
                        );
                      }
                    ?> 
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--- archived -->
                    <?php   
                      if(isset($_GET['archived'])){

                        $fullname          = $_GET['name'];
                        $account_position  = $_GET['account_position'];

                        print("
                          <div class = 'alert alert-warning alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span> <i class='fa fa-exclamation-circle'></i> <b>$fullname ($account_position)</b> account has been archived succesfully!</span>
                          </div>"
                        );
                      }
                    ?> 
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--- restored -->
                    <?php   
                      if(isset($_GET['restored'])){

                        $fullname          = $_GET['name'];
                        $account_position  = $_GET['account_position'];

                        print("
                          <div class = 'alert alert-success alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span> <i class='fa fa-exclamation-circle'></i> <b>$fullname ($account_position)</b> account has been restored succesfully!</span>
                          </div>"
                        );
                      }
                    ?> 
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <!--------------------------------------------------------------------------------------------------------------------->
                    <div id = 'table_data'>                                
                      <table id="example" class="table table-striped" style="width:100%">
                        <thead class="bg-success no-sort">
                          <tr style = 'text-align:center;'>
                            <th>ID NUMBER</th>
                            <th>FIRSTNAME</th>
                            <th>LASTNAME</th>
                            <th>ACCOUNT TYPE</th>
                            <th>STATUS</th>
                            <th>ACTION</th>
                          </tr>
                        </thead>
                        <tbody class="text text-dark">

                          <?php
                            include 'admin_classes/config_mysqli.php';

                            $query = mysqli_query($con, "SELECT * FROM faculty_account  ORDER BY account_firstname ASC, account_lastname ASC");
                              while($row = mysqli_fetch_array($query)){
                                $account_user_id   = $row['account_user_id'];
                                $account_firstname = $row['account_firstname'];
                                $account_lastname  = $row['account_lastname'];
                                //$account_password  = $row['account_password'];
                                $account_position  = $row['account_position'];
                                $account_status    = $row['account_status'];

                                //encrypt password base on character
                                //$pass_encrypt = str_repeat("*", strlen($account_password));

                                if ($account_status == 1){
                                  print("
                                    <tr style = 'text-align:center;'>
      
                                      <td> $account_user_id </td>
                                      <td> $account_firstname </td>
                                      <td> $account_lastname </td>
                                      <td> $account_position </td>
                                      <td style='text-align: center;'> <span class='badge badge-primary'>EMPLOYED</span> </td>

                                      <td>
                                        <div class='dropdown dropleft'>
                                          <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                              Action 
                                          </button>
                                          <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                            
                                            <a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#deactivate_modal' id = 'deactivate'><i class='fa fa-lock fa-fw'></i>  Deactivate</a>
                                            <a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#reset_password_modal' id = 'reset_pass'><i class='fa fa-refresh fa-fw'></i>  Reset Password</a>
                                            <a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#archive_modal' id = 'archive'><i class='fa fa-archive fa-fw'></i>  Archive</a>
                                            
                                          </div> 
                                        </div>
                                      </td>
                                    </tr>
                                  ");
                                                                  
                                }else if($account_status == 0){
                                  print("
                                    <tr style = 'text-align:center;'>
                                    
                                      <td> $account_user_id </td>
                                      <td> $account_firstname </td>
                                      <td> $account_lastname </td>
                                      <td> $account_position </td>
                                      <td style='text-align: center;'> <span class='badge badge-danger'>DEACTIVATED</span> </td>

                                      <td>
                                        <div class='dropdown dropleft'>
                                          <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                              Action 
                                          </button>
                                          <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                            
                                            <a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#activate_modal' id = 'activate'><i class='fa fa-unlock fa-fw'></i>  Activate</a>
                                            <a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#reset_password_modal' id = 'reset_pass'><i class='fa fa-refresh fa-fw'></i>  Reset Password</a>
                                            <a class='dropdown-item' href='' data-id='$account_user_id' data-toggle='modal' data-target = '#archive_modal' id = 'archive'><i class='fa fa-archive fa-fw'></i>  Archive</a>
                                            
                                          </div> 
                                        </div>
                                      </td>
                                    </tr>
                                  ");
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
      <div>

      <?php include 'bootstrap_lower/lower.php'; ?>
    </div>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- LIVE SEARCH -->
<script>
    $(document).ready(function(){
      $('#search').keyup(function(){
        var search_data = $(this).val();
      
          $.ajax({
            url:"admin_classes/search_faculty_account.php",
            method:"POST",
            data:{
              search_data:search_data
            },
            success:function(response){
                $('#table_data').html(response);
            }
          });
        
      });
    });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!--addnew -->

<script>
  $(document).ready(function(){
    
    $('#save_btn').click(function(){  
      
      var faculty_user_id   = $('#account_user_id').val();
      var account_firstname = $('#account_firstname').val();
      var account_lastname  = $('#account_lastname').val();
      var account_position  = $('#account_position').val();

      if(account_firstname == "" || account_lastname == "" || account_position == ""){
        $('#error').show();
        $('#error').html('Invalid attempt! Please try again!');
        $('#error').effect('shake');
      }else{
        $.ajax({
          url: "admin_classes/insert_admin_faculty_account.php",
          type: "POST",
          data: {
            faculty_user_id   :faculty_user_id,
            account_firstname :account_firstname,
            account_lastname  :account_lastname,
            account_position  :account_position
          },
          cache: false,
          success: function(dataResult){
            var dataResult = JSON.parse(dataResult);
              if(dataResult.statusCode==201){
                $('#error').show();
                $('#error').html('Duplicate ID. Please refresh the page!');
                $('#error').effect('shake');					
              }else if(dataResult.statusCode==202){
                $('#error').show();
                $('#error').html('Firstname and Lastname already exist!');
                $('#error').effect('shake');                                 
              }else if(dataResult.statusCode==203){
                window.location = "admin_designation.php?added";		
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
      $(document).on('click', '.dropdown-item', function(){

        var faculty_user_id   = $('#account_user_id').val();
        var account_user_id = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/reset_password_faculty_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            account_user_id:account_user_id
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

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- DELETE -->
<script>
  $(document).ready(function(){
    $(document).on('click', '.dropdown-item', function(){

        var faculty_user_id   = $('#account_user_id').val();
        var account_user_id = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/delete_faculty_account_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            account_user_id:account_user_id
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
<!-- DEACTIVATE  -->

<script>
    $(document).ready(function(){
      $(document).on('click', '.dropdown-item', function(){

          var faculty_user_id   = $('#account_user_id').val();
          var account_user_id = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/deactivate_faculty_ajax.php',
            type: 'POST',
            data: {
              faculty_user_id :faculty_user_id,
              account_user_id :account_user_id
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

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- ACTIVATE -->
<script>
    $(document).ready(function(){
      $(document).on('click', '.dropdown-item', function(){

          var faculty_user_id   = $('#account_user_id').val();
          var account_user_id = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/activate_faculty_ajax.php',
            type: 'POST',
            data: {
              faculty_user_id :faculty_user_id,
              account_user_id: account_user_id
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

<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>

<!-- ARCHIVE FACULTY ACCOUNT-->
<script>
    $(document).ready(function(){
        $(document).on('click', '.dropdown-item', function(){

          var faculty_user_id     = $('#account_user_id').val();
          var account_user_id     = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/archive_faculty_account_ajax.php',
            type: 'POST',
            data: {

                faculty_user_id :faculty_user_id,
                account_user_id :account_user_id
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

<!-- RESTORE FACULTY ACCOUNT  -->
<script>
    $(document).ready(function(){
        $(document).on('click', '#restore_faculty_account', function(){

          var faculty_user_id   = $('#account_user_id').val();
          var account_user_id   = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/restore_faculty_account_ajax.php',
            type: 'POST',
            data: {

                faculty_user_id :faculty_user_id,
                account_user_id :account_user_id
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

</body>
</html>
