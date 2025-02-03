<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_system_admin.php";
?>

<!DOCTYPE html>

  <html>

    <head>
        <?php include'bootstrap_lower/boots.php'; ?>
        <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Academic</title>

        <?php include "include/tab_icon.php"; ?>
        
        <style>
          /*HIDES ARROWS ON NUMBER TYPE IN INPUT FIELDS */
          /* Chrome, Safari, Edge, Opera */
          input::-webkit-outer-spin-button,
          input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
          }
          /* Firefox */
          input[type=number] {
            -moz-appearance: textfield;
          }
        </style>
        
    </head>

    <body>
      

      <div id="wrapper">
       
<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->
<!-- SIDE NAV -->

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

              <li class="active">
                <a href="admin_academic.php"><i class="fa fa-lg fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">Academic Year</span></a>
              </li>

              <li>
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

<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->
<!--- HEADER -->

        <div id="page-wrapper" class="gray-bg">

          <?php include'bootstrap_lower/header.php';?>

            <!----UNDER HEADER-------------------------------------------------------------------------------------------------------------->
            <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
              <div class="col-lg-10">
                <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Academic Year </p>
              </div>
            </div>

            <!------------------------------------------------------------------------------------------------------------------------>
            <!------------------------------------------------------------------------------------------------------------------------>

            <!---faculty_user_id--->
            <?php include "include/faculty_user_id.php"; ?>

            <!--------------------------------------------------------------------------------------------------------------------->
            <!--------------------------------------------------------------------------------------------------------------------->
            <!--- ARCHIVED --->
            <div class="modal fade" id="archived_academic_year" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog modal-lg" >
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"> Archived Academic Year </h5>
                  </div>

                    <div class="modal-body">
                      <?php
                        include 'admin_classes/config_mysqli.php';

                        $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 2
                        ORDER BY academic_year_from DESC, academic_term DESC");

                          if (mysqli_num_rows($query) > 0){

                            print "  
                              <table class='table table-striped'>
                                <thead class='bg-success text-center'>
                                  <th> ACADEMIC YEAR </td>
                                  
                                  <th> TERM </td>
                                  <th> STATUS </td>
                                  <th> ACTION </td>
                                </thead>
                                <tbody class='text text-dark'>";

                            while($row = mysqli_fetch_array($query)){
                              
                              $academic_id          = $row['academic_id'];
                              $academic_year_from   = $row['academic_year_from']; 
                              $academic_year_to     = $row['academic_year_to'];
                              $academic_term        = $row['academic_term']; 
                              $academic_status      = $row['academic_status']; 

                      
                              print("
                                  <tr>
                                    <td style='text-align: center;'> $academic_year_from - $academic_year_to </td>
                                    <td style='text-align: center;'> $academic_term </td>
                                    <td style='text-align: center;'> <span class='badge badge-danger' >INACTIVE</span> </td>

                                    <td style='text-align: center;'> 
                                      <button type='button'
                                      id = 'restore_archived_post'
                                      class = 'btn btn-primary btn-xs mr-2' 
                                      data-faculty='$account_user_id'
                                      data-id='$academic_id'
                                      data-toggle='modal' 
                                      data-target = '#restore_confirm_modal'> <i class='fa fa-refresh fa-lg' aria-hidden='true'></i> Restore </button>
                                    </td>                             
                                  </tr>");   
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

            <!----DATA TABLES ONE-------------------------------------------------------------------------------------------------------------->
            <div class="wrapper wrapper-content animated fadeInRight">

            <!-- Restore Archived -->
            <div class="modal fade" id="restore_confirm_modal" role="dialog" >
                <div class="modal-dialog" style = "width:400px;">
                <!-- Modal content-->
                    <div class="modal-content" >
                            <div class="modal-header">
                                
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                        <div class="modal-body" style = "text-align:center;">

                            <form method = "POST" action = "admin_classes/restore_academic_year_script.php" id = "restore_form">
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
            <!--- Activated Academic Year -->
                <?php 
                  include 'admin_classes/config_mysqli.php';      
                  if(isset($_GET['activated'])){

                      $academic_id = $_GET['academic_id'];

                      $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_id = '$academic_id'");
                      while($row = mysqli_fetch_array($query)){
                          $academic_year_from = ucwords($row['academic_year_from']);
                          $academic_year_to = ucwords($row['academic_year_to']);
                          $academic_term = ucwords($row['academic_term']);
                          
                          print("
                              <div class = 'alert alert-success alert-dismissible alert-sm'>
                                  <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                  <span><b>A.Y. $academic_year_from - $academic_year_to ($academic_term)</b> has been activated!</span>
                              </div>"
                          );
                      }  
                  }
                ?> 
                <!--------------------------------------------------------------------------------------------------------------------->
                <!--------------------------------------------------------------------------------------------------------------------->
                <!--- Deactivated Academic Year -->
                <?php 
                  include 'admin_classes/config_mysqli.php';      
                  if(isset($_GET['deactivated'])){

                      $academic_id = $_GET['academic_id'];

                      $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_id = '$academic_id'");
                      while($row = mysqli_fetch_array($query)){
                          $academic_year_from = ucwords($row['academic_year_from']);
                          $academic_year_to = ucwords($row['academic_year_to']);
                          $academic_term = ucwords($row['academic_term']);
                          
                          print("
                              <div class = 'alert alert-danger alert-dismissible alert-sm'>
                                  <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                  <span><b>A.Y. $academic_year_from - $academic_year_to ($academic_term)</b> has been deactivated!</span>
                              </div>"
                          );
                      }  
                  }
                ?> 

              <!--------------------------------------------------------------------------------------------------------------------->
              <!--------------------------------------------------------------------------------------------------------------------->
              <!--- Archived Academic Year -->
              <?php 
                  include 'admin_classes/config_mysqli.php';      
                  if(isset($_GET['archived'])){

                      $academic_id = $_GET['academic_id'];

                      $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_id = '$academic_id'");
                      while($row = mysqli_fetch_array($query)){
                          $academic_year_from = ucwords($row['academic_year_from']);
                          $academic_year_to = ucwords($row['academic_year_to']);
                          $academic_term = ucwords($row['academic_term']);
                          
                          print("
                              <div class = 'alert alert-warning alert-dismissible alert-sm'>
                                  <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                  <span><b>A.Y. $academic_year_from - $academic_year_to ($academic_term)</b> has been archived!</span>
                              </div>"
                          );
                      }  
                  }
                ?> 

                <!--------------------------------------------------------------------------------------------------------------------->
                <!--------------------------------------------------------------------------------------------------------------------->
                <!--- Restored Academic Year -->
                  <?php 
                    include 'admin_classes/config_mysqli.php';      
                    if(isset($_GET['restored'])){

                        $academic_id = $_GET['academic_id'];

                        $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_id = '$academic_id'");
                        while($row = mysqli_fetch_array($query)){
                            $academic_year_from = ucwords($row['academic_year_from']);
                            $academic_year_to = ucwords($row['academic_year_to']);
                            $academic_term = ucwords($row['academic_term']);
                            
                            print("
                                <div class = 'alert alert-success alert-dismissible alert-sm'>
                                    <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                    <span><b>A.Y. $academic_year_from - $academic_year_to ($academic_term)</b> has been restored!</span>
                                </div>"
                            );
                        }  
                    }
                  ?> 
              <!--------------------------------------------------------------------------------------------------------------------->
              <!--------------------------------------------------------------------------------------------------------------------->
              <!--- Deleted Academic Year -->
                <?php 
                  if(isset($_GET['deleted'])){

                    $academic = $_GET['academic'];

                        print("
                            <div class = 'alert alert-danger alert-dismissible alert-sm'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                <span><b>A.Y. $academic</b> has been deleted!</span>
                            </div>"
                        );
                    
                }
                ?> 
              <!--------------------------------------------------------------------------------------------------------------------->
              <!--------------------------------------------------------------------------------------------------------------------->
              <!---Added Academic Year -->
                <?php 
              
                  include 'admin_classes/config_mysqli.php';    

                    if(isset($_GET['added'])){

                      $academic_id =  $_SESSION['academic_id'];

                      $query = mysqli_query($con, "SELECT * from academic_year WHERE academic_id = '$academic_id'");
                      $row = mysqli_fetch_array($query);

                      $academic_year_from = $row['academic_year_from'];
                      $academic_year_to = $row['academic_year_to'];
                      $academic_term = $row['academic_term'];

                          print("
                              <div class = 'alert alert-primary alert-dismissible alert-sm'>
                                  <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                  <span><b>A.Y. $academic_year_from - $academic_year_to ($academic_term) </b> has been created successfully!</span>
                              </div>"
                          );
                      
                  }
                  ?>


              <div class="row">
                <div class="col-lg-12">
                  <div class="ibox ">
                    <div class="ibox-title">

                      <h5> </h5>
                      
                      <div class="ibox-tools">

                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal6" id = "create_new_btn"><i class="fa fa-plus fa-lg" aria-hidden="true"></i> Create New </button>
                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#archived_academic_year" id = "archived_academic_year_btn"><i class="fa fa-archive fa-lg" aria-hidden="true"></i> Archived</button>

                      <!--- MODAL FRAME ADD ---------------------------------------------------------------------------------------------------------------------------->
                      <!--- MODAL --->
                      <!--- MODAL FOR ADNEW --->
                      <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog pt-reduced pb-reduced" >
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title"> Academic Year Registration </h5>
                            </div>
                              <div class="modal-body">
                                <div class="row mt-2">
                                  <div class="col-sm">
                                    <table>
                                      <tr>
                                        <td>
                                        <label class="text-dark" style="font-weight: bold;" >ACADEMIC YEAR</label>
                                        </td>
                                      </tr>
                                    </table>
                                    <div class = "row">
                                      <div class="col-sm-6">
                                          <input type="number" id="academic_year_from" name='academic_year_from' class="form-control border border-secondary rounded input-sm"  >                                      
                                      </div>
                                      <div class="col-sm-6">
                                          <input type="number" id="academic_year_to" name='academic_year_to' class="form-control border border-secondary rounded input-sm" disabled="disabled" >                           
                                      </div>
                                    </div>
                                  </div>
                                </div>

                                <div class="row mt-2">
                                  <div class="col-sm">
                                    <table>
                                      <tr>
                                        <td>
                                        <label class="text-dark" style="font-weight: bold;" >TERM</label>
                                        </td>
                                      </tr>
                                    </table>
                                      <select class="form-control border border-secondary rounded input-sm" id = "term" name = "term">
                                        <option disabled selected hidden >Select Term</option>
                                        <option value="1st Semester">1st Semester</option>
                                        <option value="2nd Semester">2nd Semester</option>       
                                      </select>
                                  </div>        
                                </div>

                                <br>

                                
                                <div style = "text-align:center; font-weight:bold; color:red;" class = "empty_error" id = "empty"></div>

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

                      <!-- ACTIVATE Modal -->
                      <div class="modal fade" id="activate_modal" role="dialog" >
                          <div class="modal-dialog" style = "width:400px;">
                          <!-- Modal content-->
                              <div class="modal-content" >
                                      <div class="modal-header">
                                          
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                  <div class="modal-body" style = "text-align:center;">

                                      <form method = "POST" action = "admin_classes/activate_academic_year_script.php" id = "activate_form">
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

                      <!-- DEACTIVATE Modal -->
                      <div class="modal fade" id="deactivate_modal" role="dialog" >
                          <div class="modal-dialog" style = "width:400px;">
                          <!-- Modal content-->
                              <div class="modal-content" >
                                      <div class="modal-header">
                                          
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                  <div class="modal-body" style = "text-align:center;">

                                      <form method = "POST" action = "admin_classes/deactivate_academic_year_script.php" id = "deactivate_form">
                                          
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

                       <!-- ARCHIVE Modal -->
                       <div class="modal fade" id="archive_modal" role="dialog" >
                          <div class="modal-dialog" style = "width:400px;">
                          <!-- Modal content-->
                              <div class="modal-content" >
                                      <div class="modal-header">
                                          
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                  <div class="modal-body" style = "text-align:center;">

                                      <form method = "POST" action = "admin_classes/archive_academic_year_script.php" id = "archive_form">
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

                      <!-- Delete  Modal -->
                      <div class="modal fade" id="delete_modal" role="dialog" >
                          <div class="modal-dialog" style = "width:300px;"> 
                          <!-- Modal content-->
                              <div class="modal-content" >
                                      <div class="modal-header" style = "color:red;">
                                          
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                  <div class="modal-body" style = "text-align:center;">
                                      <form method = "POST" action = "admin_classes/delete_academic_year_script.php" id = "form_delete">
                                          
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
<!----TABLE SORTED------------------------------------------------------------------------------------------------------------>
                   
                    <div class="ibox-content">
                      <div class="table-responsive" style = 'overflow:hidden;'>
                      
                        <div class = "row">
                          <div class = "col-md-3">
                            <input class="form-control" type="search" id="search" placeholder="Search academic year.." aria-label="Search">
                          </div>

                        </div><br>

                        <div id = 'table_data'>
                          <table class="table table-striped mb-5">
                            <thead class="bg-success text-center">
                              <th> ACADEMIC YEAR <i class="fa fa-arrow-down ml-2" id = 'sort_year_asc' ></i> </td>
                              
                              <th> TERM </td>
                              <th> STATUS </td>
                              <th> ACTION </td>
                            </thead>

                            <tbody class="text text-dark">

                            <?php 
                              include 'admin_classes/config.php';

                              $query = mysqli_query($con, "SELECT * FROM academic_year ORDER BY academic_year_from DESC, academic_term DESC");
                              while($row = mysqli_fetch_array($query)){
                                $academic_id = $row['academic_id'];
                                $academic_year_from = $row['academic_year_from']; 
                                $academic_year_to = $row['academic_year_to'];
                                $academic_term = $row['academic_term']; 
                                $academic_status = $row['academic_status']; 

                                if($academic_status == '1'){
                                  print("

                                    <tr>
                                      <td style='text-align: center;'> $academic_year_from - $academic_year_to </td>
                                      <td style='text-align: center;'> $academic_term </td>
                                      <td style='text-align: center;'> <span class='badge badge-primary' >ACTIVE</span> </td>

                                      <td style='text-align: center;'> 
                                        <div class='dropdown dropleft'>
                                          <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                              Action 
                                          </button>

                                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                              
                                              <a class='dropdown-item' href = '' data-id='$academic_id' data-toggle='modal' data-target = '#deactivate_modal'><i class='fa fa-lock fa-fw'></i>  Deactivate</a>
                                            
                                            </div> 
                                        </div>
                                      </td>                             
                                    </tr>

                                  "); 
                                }else if ($academic_status == '0'){
                                  print("

                                    <tr>
                                      <td style='text-align: center;'> $academic_year_from - $academic_year_to </td>
                                      <td style='text-align: center;'> $academic_term </td>
                                      <td style='text-align: center;'> <span class='badge badge-danger'>INACTIVE</span> </td>

                                      <td style='text-align: center;'> 
                                        <div class='dropdown dropleft'>
                                          <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                              Action 
                                          </button>

                                            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                              
                                              <a class='dropdown-item' href = '' data-id='$academic_id' data-toggle='modal' data-target = '#activate_modal'> <i class='fa fa-unlock fa-fw'></i> Activate</a>
                                              <a class='dropdown-item' href = '' data-id='$academic_id' data-toggle='modal' data-target = '#archive_modal'> <i class='fa fa-archive fa-fw'></i> Archive</a>
                                             
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

       

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->

</div>
  <?php include 'bootstrap_lower/lower.php'; ?>
</div>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- SORT ASC-->
<script>
    $(document).ready(function(){
      $(document).on('click', '#sort_year_asc', function(){
        var sort_year_asc = 'asc';
      
          $.ajax({
            url:"admin_classes/sort_admin_academic.php",
            method:"POST",
            data:{
              sort_year_asc:sort_year_asc
            },
            success:function(response){
                $('#table_data').html(response);
            }
          });
        
      });
    });
</script>

<!-- SORT DESC-->

<script>
    $(document).ready(function(){
      $(document).on('click', '#sort_year_desc', function(){
        var sort_year_desc = 'desc';
      
          $.ajax({
            url:"admin_classes/sort_admin_academic.php",
            method:"POST",
            data:{
              sort_year_desc:sort_year_desc
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

<!-- LIVE SEARCH -->
<script>
    $(document).ready(function(){
      $('#search').keyup(function(){
        var search_data = $(this).val();
      
          $.ajax({
            url:"admin_classes/search_academic_year.php",
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

<!------------------------------------------------------------------------------------------------------------------------>
<!------------------------------------------------------------------------------------------------------------------------>

<!-- ACTIVATE ACADEMIC YEAR -->
<script>
    $(document).ready(function(){
        $(document).on('click', '.dropdown-item', function(){

          var faculty_user_id     = $('#account_user_id').val();
          var academic_id         = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/activate_academic_year_ajax.php',
            type: 'POST',
            data: {

                faculty_user_id :faculty_user_id,
                academic_id     :academic_id
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
<!-- DEACTIVATE ACADEMIC YEAR -->

<script>
    $(document).ready(function(){
      $(document).on('click', '.dropdown-item', function(){

          var faculty_user_id   = $('#account_user_id').val();
          var academic_id       = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/deactivate_academic_year_ajax.php',
            type: 'POST',
            data: {
              faculty_user_id :faculty_user_id,
              academic_id     :academic_id
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

<!-- ARCHIVE ACADEMIC YEAR -->
<script>
    $(document).ready(function(){
        $(document).on('click', '.dropdown-item', function(){

          var faculty_user_id     = $('#account_user_id').val();
          var academic_id         = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/archive_academic_year_ajax.php',
            type: 'POST',
            data: {

                faculty_user_id :faculty_user_id,
                academic_id     :academic_id
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

<!-- RESTORE ACADEMIC YEAR -->
<script>
    $(document).ready(function(){
        $(document).on('click', '#restore_archived_post', function(){

          var faculty_user_id     = $(this).data('faculty');
          var academic_id         = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/restore_academic_year_ajax.php',
            type: 'POST',
            data: {

                faculty_user_id :faculty_user_id,
                academic_id     :academic_id
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

<!-- DELETE ACADEMIC YEAR -->
<script>
  $(document).ready(function(){
    $(document).on('click', '.dropdown-item', function(){

        var faculty_user_id   = $('#account_user_id').val();
        var academic_id       = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/delete_academic_year_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            academic_id     :academic_id
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
<!--Academic Year auto increment-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

  $(document).ready(function(){

      $('#academic_year_from').keyup(function(){

        var academic_year_from = parseInt($('#academic_year_from').val());
        var one = parseInt(1)
        var academic_year_to = academic_year_from + one;

        $('#academic_year_to').val(academic_year_to);
      
      });

  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- ADD ACADEMIC YEAR -->

<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!--shake effect on error -->

<script>

  $(document).ready(function(){
  //Error mesages               
      $('#create_new_btn').click(function(){       
        $(".empty_error").hide();   
        $("#academic_year_from").val('');   
        $("#academic_year_to").val('');   
        $("#term").val('');              
    });
  });
  </script>

<script>

  $(document).ready(function(){
  //Error mesages               
    $('#save_btn').click(function(){
      var academic_year = $('#academic_year_from').val();
      var term = $('#term').val();

        if(!$('#term').val() || academic_year == "" || term == ""){       
          
          $("#empty").html("Invalid Attempt! Please enter a value!");
                $("#empty").show();   
                $('#empty').effect("shake");
        }else{

          var faculty_user_id     = $('#account_user_id').val();
          var academic_year_from  = $('#academic_year_from').val();
          var academic_year_to    = $('#academic_year_to').val();
          var term                = $('#term').val();

          $.ajax({
            url: "admin_classes/admin_academic_year_insert.php",
            type: "POST",
            data: {

                faculty_user_id    :faculty_user_id,
                academic_year_from :academic_year_from,
                academic_year_to   :academic_year_to,
                term               :term            
            },
            cache: false,
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    window.location = "admin_academic.php?added";						
                }else if(dataResult.statusCode==201){
                   
                  $("#empty").show();  
                    $('#empty').html('Academic Year and Term already exists!'); 
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

</body>
</html>
