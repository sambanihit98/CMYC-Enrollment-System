<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_registrar.php";
?>

<!DOCTYPE html>

  <html>

    <head>
        <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Department </title>

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
       
      <!------SIDE NAV---------->
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
                              
                  <li class="active">
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

        <!----HEADER-------------------------------------------------------------------------------------------------------------->
        <div id="page-wrapper" class="gray-bg">
        <?php include'bootstrap_lower/header.php';?>
        <!----HEADER-------------------------------------------------------------------------------------------------------------->

        <!----UNDER HEADER-------------------------------------------------------------------------------------------------------------->
        <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
            <div class="col-lg-10">
              <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Department List </p>

            </div>
        </div>

        <!------------------------------------------------------------------------------------------------------------------------>
        <!------------------------------------------------------------------------------------------------------------------------>
        <!---HIDDEN DATA--->
        <!---faculty_user_id--->
        <?php include "include/faculty_user_id.php"; ?>

        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->
        <!--- ARCHIVED --->
        <div class="modal fade" id="archived_department" tabindex="-1" role="dialog"  aria-hidden="true">
          <div class="modal-dialog modal-lg" >
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"> Archived Departments </h5>
              </div>

                <div class="modal-body">
                  <?php
                    include 'admin_classes/config_mysqli.php';

                    $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_status = 2
                      ORDER BY department_code ASC");

                      if (mysqli_num_rows($query) > 0){

                        print "  
                          <table class='table table-striped'>
                            <thead class='bg-success text-center'>
                              <th>DEPARTMENT CODE</th>
                              <th>DESCRIPTION</th>
                              <th>STATUS</th>
                              <th>ACTION</th>
                            </thead>
                            <tbody class='text text-dark'>";

                        while($row = mysqli_fetch_array($query)){
                          
                          $department_id           = $row['department_id'];
                          $department_code         = $row['department_code'];
                          $department_description  = $row['department_description'];
                  
                          print("
                            <tr style = 'text-align:center;'>

                              <td> $department_code </td>
                              <td> $department_description </td>
                              <td style='text-align: center;'> <span class='badge badge-pill badge-warning'>ARCHIVED</span> </td>

                              <td style='text-align: center;'> 
                                <button type='button'
                                id = 'restore_department'
                                class = 'btn btn-primary btn-xs mr-2' 
                                data-id='$department_id'
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
        
        <!-- Restore Department -->
        <div class="modal fade" id="restore_confirm_modal" role="dialog" >
          <div class="modal-dialog" style = "width:400px;">
          <!-- Modal content-->
            <div class="modal-content" >
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body" style = "text-align:center;">
                <form method = "POST" action = "admin_classes/restore_department_script.php" id = "restore_form">
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

        <!----DATA TABLES ONE-------------------------------------------------------------------------------------------------------------->
        <div class="wrapper wrapper-content animated fadeInRight">

          <!--------------------------------------------------------------------------------------------------------------------->
          <!--------------------------------------------------------------------------------------------------------------------->
          <!---Added Department -->
          <?php             
            include 'admin_classes/config_mysqli.php';    
              if(isset($_GET['added'])){
                $department_id =  $_SESSION['department_id'];
                $query = mysqli_query($con, "SELECT * from manage_department WHERE department_id = '$department_id'");
                $row = mysqli_fetch_array($query);

                $department_code = $row['department_code'];
                $department_description = $row['department_description'];

                    print("
                        <div class = 'alert alert-primary alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span><b>$department_description ($department_code) </b> has been created successfully!</span>
                        </div>"
                    );                   
            }
          ?>

          <!--------------------------------------------------------------------------------------------------------------------->
          <!--------------------------------------------------------------------------------------------------------------------->
          <!---Updated Department -->
          <?php             
            include 'admin_classes/config_mysqli.php';    
              if(isset($_GET['updated'])){
                $department_id =  $_SESSION['department_id'];
                $department_code_hid = $_SESSION['department_code_hid'];
                $department_description_hid = $_SESSION['department_description_hid'];
                
                $query = mysqli_query($con, "SELECT * from manage_department WHERE department_id = '$department_id'");
                $row = mysqli_fetch_array($query);

                $department_code = $row['department_code'];
                $department_description = $row['department_description'];

                    print("
                        <div class = 'alert alert-primary alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span><b>$department_description_hid ($department_code_hid) </b> updated to <b>$department_description ($department_code)</b></span>
                        </div>"
                    );                   
            }
          ?>

          <!--------------------------------------------------------------------------------------------------------------------->
          <!--------------------------------------------------------------------------------------------------------------------->
          <!--- Activated Department -->
          <?php 
            include 'admin_classes/config_mysqli.php';      
            if(isset($_GET['activated'])){

                $department_id = $_GET['department_id'];

                $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
                while($row = mysqli_fetch_array($query)){
                    $department_code = ucwords($row['department_code']);
                    $department_description = ucwords($row['department_description']);
                    
                    print("
                        <div class = 'alert alert-success alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span><b>$department_code: $department_description</b> has been activated!</span>
                        </div>"
                    );
                }  
            }
          ?> 

          <!--------------------------------------------------------------------------------------------------------------------->
          <!--------------------------------------------------------------------------------------------------------------------->
          <!--- Deactivated Department -->
          <?php 
            include 'admin_classes/config_mysqli.php';      
            if(isset($_GET['deactivated'])){

                $department_id = $_GET['department_id'];

                $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
                while($row = mysqli_fetch_array($query)){
                    $department_code = ucwords($row['department_code']);
                    $department_description = ucwords($row['department_description']);

                    print("
                        <div class = 'alert alert-danger alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span><b> $department_code: $department_description</b> has been deactivated!</span>
                        </div>"
                    );
                }  
            }
          ?> 

          <!--------------------------------------------------------------------------------------------------------------------->
          <!--------------------------------------------------------------------------------------------------------------------->
          <!--- Archived Department -->
          <?php 
            include 'admin_classes/config_mysqli.php';      
            if(isset($_GET['archived'])){

                $department_id = $_GET['department_id'];

                $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
                while($row = mysqli_fetch_array($query)){
                    $department_code = ucwords($row['department_code']);
                    $department_description = ucwords($row['department_description']);

                    print("
                        <div class = 'alert alert-warning alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span><b> $department_code: $department_description</b> has been archived!</span>
                        </div>"
                    );
                }  
            }
          ?> 

          <!--------------------------------------------------------------------------------------------------------------------->
          <!--------------------------------------------------------------------------------------------------------------------->
          <!--- Restored Department -->
          <?php 
            include 'admin_classes/config_mysqli.php';      
            if(isset($_GET['restored'])){

                $department_id = $_GET['department_id'];

                $query = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
                while($row = mysqli_fetch_array($query)){
                    $department_code = ucwords($row['department_code']);
                    $department_description = ucwords($row['department_description']);

                    print("
                        <div class = 'alert alert-success alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span><b> $department_code: $department_description</b> has been restored!</span>
                        </div>"
                    );
                }  
            }
          ?> 

          <!--------------------------------------------------------------------------------------------------------------------->
          <!--------------------------------------------------------------------------------------------------------------------->
          <!--- Deleted Department -->
          <?php 
              if(isset($_GET['deleted'])){

                $department = $_GET['department'];

                    print("
                        <div class = 'alert alert-danger alert-dismissible alert-sm'>
                            <button type='button' class='close' data-dismiss='alert'>&times;</button>
                            <span><b>$department</b> has been deleted successfully!</span>
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
                  <h5> </h5>
                    <div class="ibox-tools">

                      <button type="button" 
                            class="btn btn-success btn-xs" 
                            data-toggle="modal" 
                            data-target="#myModal6"
                            id = "create_new">
                        <i class="fa fa-plus fa-lg" aria-hidden="true"></i> 
                        Create New 
                      </button>

                      <button type="button" 
                          class="btn btn-success btn-xs" 
                          data-toggle="modal" 
                          data-target="#archived_department" 
                          id = "archived_department_btn">
                        <i class="fa fa-archive fa-lg" aria-hidden="true"></i> 
                        Archived
                      </button>

                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!-----MODAL FOR ADNEW ----------------->

                      <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog pt-reduced pb-reduced " >
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title"> Department Registration </h5>                                            
                            </div>
                            <div class="modal-body">
                              <div class="row mt-2">
                                  <div class="col-sm">
                                        <table>
                                          <td>
                                            <label class="text-dark" style="font-weight: bold;" > DEPARTMENT CODE</label>
                                          </td>
                                        </table>
                                        <input type="text" class="form-control border border-secondary rounded input-sm" id="department_code" >
                                  </div>       
                              </div>

                              <div class="row mt-2">
                                <div class="col-sm">
                                  <table>
                                    <td>
                                      <label class="text-dark" style="font-weight: bold;" > DESCRIPTION</label>
                                    </td>
                                  </table>
                                  <input type="text" class="form-control border border-secondary rounded input-sm" id="department_description" >
                                </div>       
                              </div>
                             <br>
                              <div id = "empty" style = "color:red; font-weight: bold; text-align:center;"></div>

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
                        <form method = "POST" action = "admin_classes/archive_department_script.php" id = "archive_form">
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

                <!-- Update Department Modal -->
                <div class="modal fade" id="update_modal" role="dialog" >
                    <div class="modal-dialog" style = "width:500px;">
                    <!-- Modal content-->
                        <div class="modal-content" >
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                          <div class="modal-body" style = "text-align:center;">
                          <h2 style = 'font-weight:bold;'>Update Department</h2><br><br>
                            
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
                          <form method = "POST" action = "admin_classes/activate_department_script.php" id = "activate_form">
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
                                <form method = "POST" action = "admin_classes/deactivate_department_script.php" id = "deactivate_form">
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
                                <form method = "POST" action = "admin_classes/delete_department_script.php" id = "form_delete">
                                    
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
              <!----TABLE SORTED------------------------------------------------------------------------------------------------------------>

                <div class="ibox-content">
                  <div class="table-responsive">
                    <table class="table table-striped" >
                      <thead class="bg-success text-center">
                        <th > Department Code </th>
                        <th> Description </th>
                        <th> Status </th>
                        <th > Action </th>
                      </thead>
                      <tbody class='text-center';>

                        <?php  

                          include 'admin_classes/config.php';

                            $query = $connect->prepare("SELECT * FROM `manage_department` ORDER BY department_code ASC");
                            $query->execute();

                            $sub_insert = $query->fetchAll();

                            foreach ($sub_insert as $account) {
                              $department_id = $account['department_id'];
                              $department_code = $account['department_code'];
                              $department_description = $account['department_description']; 
                              $department_status = $account['department_status'];

                              if($department_status == 1){

                                print 
                                "
                                  <tr>
                                    <td > $department_code </td>
                                    <td > $department_description </td>
                                    <td style='text-align: center;'> <span class='badge badge-primary'>ACTIVE</span> </td>
                                    <td >
                                      <div class='dropdown dropleft'>
                                        <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                            Action 
                                        </button>
  
                                          <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                            <a class='dropdown-item' href='' data-id='$department_id' data-toggle='modal' data-target = '#update_modal' id = 'update'><i class='fa fa-pencil fa-fw'></i>  Update</a>
                                            <a class='dropdown-item' href='' data-id='$department_id' data-toggle='modal' data-target = '#deactivate_modal' id = 'deactivate'><i class='fa fa-lock fa-fw'></i>  Deactivate</a>
                                            <a class='dropdown-item' href='' data-id='$department_id' data-toggle='modal' data-target = '#archive_modal' id = 'archive'><i class='fa fa-archive fa-fw'></i>  Archive</a>
                                           
                                          </div> 
                                      </div>
                                    </td>
                                  </tr>
                                ";

                              }else if($department_status == 0){
                                print
                                "
                                  <tr>
                                    <td > $department_code </td>
                                    <td > $department_description </td>
                                    <td style='text-align: center;'> <span class='badge badge-danger'>INACTIVE</span> </td>
                                    <td >
                                      <div class='dropdown dropleft'>
                                        <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                            Action 
                                        </button>
  
                                          <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                            <a class='dropdown-item' href='' data-id='$department_id' data-toggle='modal' data-target = '#update_modal' id = 'update'><i class='fa fa-pencil fa-fw'></i>  Update</a>
                                            <a class='dropdown-item' href='' data-id='$department_id' data-toggle='modal' data-target = '#activate_modal' id = 'activate'><i class='fa fa-unlock fa-fw'></i>  Activate</a>
                                            <a class='dropdown-item' href='' data-id='$department_id' data-toggle='modal' data-target = '#archive_modal' id = 'archive'><i class='fa fa-archive fa-fw'></i>  Archive</a>
                                            
                                          </div> 
                                      </div>
                                    </td>
                                  </tr>
                                ";
                              }

                              

                            }
                        ?>
                      </tbody>
                    </table>       
                  </div>
                </div>
                </div>
<!----TABLE SORTED------------------------------------------------------------------------------------------------------------>
<!---------------------------------------------------------------------------------------------------------------------------->
            </div>
        </div>
    </div>
    
<!----DATA TABLES ONE-------------------------------------------------------------------------------------------------------------->

<div> 
  <?php include 'bootstrap_lower/lower.php'; ?>
</div>
                    

<!-- Mainly scripts -->
<!---------------------------------------------------------------------------------------------------------------------------->

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-----DATA TABLE SCRIPT---------------->

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


<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- UPDATE DEPARTMENT -->

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

          var department_id = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/update_department_form.php',
            type: 'POST',
            data: {

              department_id   :department_id
            },
            success: function(response){ 
                // Add response in Modal body
                $('#update_info').html(response);
            }
            });
        });
    });
</script>

<!-- FORM UPDATE DEPARTMENT-->
<script>
    $(document).ready(function(){
      $('#update_btn').click(function(){

      var faculty_user_id = $('#account_user_id').val();
      var department_code        = $('#department_code_update').val();
      var department_description = $('#department_description_update').val();
      var department_id          = $('#department_id_hid').val();

      //hidden input field
      var department_code_hid = $('#department_code_hid').val();
      var department_description_hid = $('#department_description_hid').val();

      if(department_code == '' || department_description == ''){       
          
          $('#empty_update').html('Invalid Attempt! Please enter a value!');
                $('#empty_update').show();   
                $('#empty_update').effect('shake');
        }else{

          $.ajax({
            url: "admin_classes/update_department_ajax.php",
            type: "POST",
            data: {

              faculty_user_id :faculty_user_id,
              department_code: department_code,
              department_description: department_description,
              department_id: department_id,
              department_code_hid: department_code_hid,
              department_description_hid: department_description_hid       
            },
            cache: false,
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    window.location = "registrar_manage_department.php?updated";						
                }else if(dataResult.statusCode==201){
                   
                  $("#empty_update").show();  
                    $('#empty_update').html('Department Code or Description already exists!'); 
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
<!-- CREATE NEW DEPARTMENT-->

<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!--shake effect on error -->

<script>
  $(document).ready(function(){
  //Error mesages               
      $('#create_new').click(function(){    
        $("#empty").hide(); 
        $("#department_code").val('');   
        $("#department_description").val('');    
    });
  });
</script>

<script>
  $(document).ready(function(){
             
      $('#save_btn').click(function(){       
    });
  });
</script>

<script>

  $(document).ready(function(){
              
    $('#save_btn').click(function(){
      var faculty_user_id = $('#account_user_id').val();
      var department_code = $('#department_code').val();
      var department_description = $('#department_description').val();

        if(department_code == "" || department_description == ""){       
          
          $("#empty").html("Invalid Attempt! Please enter a value!");
                $("#empty").show();   
                $('#empty').effect("shake");
        }else{

          var department_code         = $('#department_code').val();
          var department_description  = $('#department_description').val();

          $.ajax({
            url: "admin_classes/reg_manage_department_insert.php",
            type: "POST",
            data: {
                faculty_user_id         :faculty_user_id,
                department_code         :department_code,
                department_description  :department_description           
            },
            cache: false,
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult.statusCode==200){
                    window.location = "registrar_manage_department.php?added";						
                }else if(dataResult.statusCode==201){
                   
                  $("#empty").show();  
                    $('#empty').html('Department Code or Description already exists!'); 
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

<!-- ACTIVATE DEPARTMENT -->
<script>
    $(document).ready(function(){
        $('.dropdown-item').click(function(){

          var faculty_user_id = $('#account_user_id').val();
          var department_id = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/activate_department_ajax.php',
            type: 'POST',
            data: {
              faculty_user_id :faculty_user_id,
              department_id   :department_id
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
<!-- DEACTIVATE DEPARTMENT -->

<script>
    $(document).ready(function(){
        $('.dropdown-item').click(function(){

          var faculty_user_id = $('#account_user_id').val();
          var department_id   = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/deactivate_department_ajax.php',
            type: 'POST',
            data: {
              faculty_user_id :faculty_user_id,
              department_id   :department_id
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
          var department_id       = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/archive_department_ajax.php',
            type: 'POST',
            data: {

                faculty_user_id :faculty_user_id,
                department_id   :department_id
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
        $(document).on('click', '#restore_department', function(){

          var faculty_user_id   = $('#account_user_id').val();
          var department_id     = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/restore_department_ajax.php',
            type: 'POST',
            data: {

                faculty_user_id :faculty_user_id,
                department_id   :department_id
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

<!-- DELETE DEPARTMENT -->
<script>
  $(document).ready(function(){
      $('.dropdown-item').click(function(){

        var faculty_user_id = $('#account_user_id').val();
        var department_id = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/delete_department_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            department_id   :department_id
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

</body>
</html>
