<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_registrar.php";
?>

<!DOCTYPE html>
  <html>

    <head>
      <title> <?php include'bootstrap_lower/title_header.php'; ?> | Schedule </title>

      <?php include "include/tab_icon.php"; ?>
      
      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
      <!-- FooTable -->
      <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
      <link href="css/animate.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">

      <link rel='stylesheet' href='https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css'>
      <link rel='stylesheet' href='https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css'>
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
  
              <li>
                <a href="registrar_student_record.php"><i class="fa fa-lg fa-address-card" aria-hidden="true"></i> <span class="nav-label">Student Record</span></a>
              </li> 

              <li class="active">
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
        <!------SIDE NAV----->

        <!----HEADER------->
        <div id="page-wrapper" class="gray-bg">
          <?php include 'bootstrap_lower/header.php';?>
        <!----HEADER------->

          <!----UNDER HEADER---------->
          <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
            <div class="col-lg-10">
              <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Teacher's List </p>
            </div>
          </div>
          <!----UNDER HEADER---------->

          <!----DATA TABLES ONE------>
          <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
              <div class="col-lg-12">
                <div class="ibox ">

                  <!-----MODAL FOR ADD NEW ------>
                  <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-xl" >
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title"> </h4>
                        </div>

                        <div class="modal-body"> </div>
   
                        <div class="modal-footer">
                          <button type="button" class="btn btn-success btn-xs" id="subject_btn">Add User</button>
                        </div>

                      </div>
                    </div>
                  </div>

                  <!----TABLE SORTED-------->
                  <div class="ibox-content">
                    <div class="table-responsive">
    
                      <table>
                        <td>
                          <input class="form-control" type="search" id="search" placeholder="Search teacher..." aria-label="Search">
                        </td>  
                      </table><br>

                      <!----BIG TABLE---->
                      <div id = 'table_data'>
                      <table class="table table-striped" >
                        <thead class="bg-success text-center">
                          <th >ID NUMBER</th>
                          <th >FULL NAME</th>
                          <th >STATUS</th>
                          <th >ACTION</th>
                        </thead>

                          <?php  
                            include 'admin_classes/config_mysqli.php';

                            $query = mysqli_query($con, "SELECT * FROM faculty_account 
                                                          WHERE account_position = 'Teacher'");

                            while($row = mysqli_fetch_array($query)){
                              $account_user_id = $row['account_user_id']; 
                              $account_firstname = $row['account_firstname'];
                              $account_lastname = $row['account_lastname'];
                              $account_position = $row['account_position'];
                              $account_status = $row['account_status'];

                              if ($account_status == 0) {
                                $acc_STATUS = "<h5><small class='badge badge-danger'>DEACTIVATED</small></h5>";  
                              }else{
                                $acc_STATUS = "<h5><small class='badge badge-primary'>EMPLOYED</small></h5>"; 
                              }

                              echo "
                                <tr class ='text-center'>
                                  <td >  $account_user_id </td>
                                  <td >  $account_firstname $account_lastname</td>
                                  <td >  $acc_STATUS </td>
                                  <td>

                                    <div class='dropdown dropleft'>
                                      <button class='btn btn-success btn-sm dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                          Action 
                                      </button>

                                      <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'> 
                                        <a  class='dropdown-item' href='registrar_teacher_scheduler_load.php?account_user_id=$account_user_id' ><i class='fa fa-pencil fa-fw'></i> Load Subject </a>
                                      </div> 
                                    </div>  
                                   
                                  </td> 
                                </tr>
                              ";
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

          <?php include 'bootstrap_lower/lower.php'; ?>
        </div>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-----DATA TABLE SCRIPT------------------------------------------------------------------------------------------------------>

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
<!-- LIVE SEARCH -->
<script>
    $(document).ready(function(){
      $('#search').keyup(function(){
        var search_teacher = $(this).val();
      
          $.ajax({
            url:"admin_classes/search_teacher.php",
            method:"POST",
            data:{
              search_teacher:search_teacher
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


  </body>
</html>
