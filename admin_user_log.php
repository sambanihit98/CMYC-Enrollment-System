<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_system_admin.php";
?>

<!DOCTYPE html>

  <html>

    <head>
        <?php include'bootstrap_lower/boots.php'; ?>
        <title> <?php include 'bootstrap_lower/title_header.php'; ?> | User Log</title>

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

              <li>
                <a href="admin_academic.php"><i class="fa fa-lg fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">Academic Year</span></a>
              </li>

              <li>
                <a href="admin_designation.php"><i class="fa fa-lg fa-user-plus" aria-hidden="true"></i> <span class="nav-label">Designation</span></a>
              </li> 

              <li  class="active">
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
                <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> User Log </p>
              </div>
            </div>

            <!----DATA TABLES ONE-------------------------------------------------------------------------------------------------------------->
            <div class="wrapper wrapper-content animated fadeInRight">

    
              <div class="row">
                <div class="col-lg-12">
                  <div class="ibox ">
                    <div class="ibox-title">

                      <h5> </h5>
                      
                      <div class="ibox-tools">

                        <div class = 'row'>
                        <div class = "col-md-12" >
                          
                            <input type="date"  
                                    class="border border-secondary rounded input-sm" 
                                    name="user_log_date" 
                                    id="user_log_date"
                                    value = "<?php echo date('Y-m-d'); ?>">
                            <button type="button" class="btn btn-success btn-md" name="show_btn" id="show_btn">Show</button>

                        </div>
                        </div>

                      </div>
                    </div>

                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!----TABLE SORTED------------------------------------------------------------------------------------------------------------>
                   
                    <div class="ibox-content">
                      <div class="table-responsive">
                        <div class="table-responsive">
                        <div id = 'user_log_data'>

                            <?php 
                              include 'admin_classes/config.php';

                              $date    = date('Y-m-d');

                              $query_date = mysqli_query($con, "SELECT * FROM user_log WHERE user_log_date = '$date'");
                              if(mysqli_num_rows($query_date)>0){

                                print "
                                <table class='table table-striped'>
                                  <thead class='bg-success text-center'>
                                    <th> ID NUMBER </td>
                                    <th> FULLNAME </td>
                                    <th> ACTION DESCRIPTION</td>
                                    <th> TIME </td>
                                    <th> DATE </td>
                                  </thead>
                                  <tbody class='text text-dark'>
                                ";

                                $query = mysqli_query($con, "SELECT * FROM user_log JOIN faculty_account
                                ON user_log.account_user_id = faculty_account.account_user_id WHERE user_log_date = '$date' ORDER BY user_log.user_log_id DESC");
                              
                                while($row = mysqli_fetch_array($query)){
                                    //user log
                                  $user_log_id      = $row['user_log_id'];
                                  $user_action      = $row['user_action'];
                                  $user_log_time    = $row['user_log_time']; 
                                  $user_log_date    = $row['user_log_date']; 

                                  $time1 = strtotime($user_log_time);
                                  $time2 = date("h:i:s a", $time1);

                                  $date1 = strtotime($user_log_date);
                                  $date2 = date("M. j, Y", $date1);

                                  //faculty account
                                  $account_user_id    = $row['account_user_id']; 
                                  $account_firstname  = $row['account_firstname'];
                                  $account_lastname   = $row['account_lastname'];
                                  $account_position   = $row['account_position'];
                            
                                    print("

                                      <tr>
                                        <td style='text-align: center; width:100px;'>$account_user_id</td>
                                        <td style='text-align: center;'>$account_firstname $account_lastname (<b>$account_position</b>)</td>
                                        <td >$user_action</td>
                                        <td style='text-align: center; width:100px;'>$time2</td>  
                                        <td style='text-align: center; width:100px;'>$date2</td>                             
                                      </tr>

                                    "); 
                                  
                                }

                                print "</tbody> </table>";

                              }else{
                                echo "<h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>";
                              }

                            ?>
                            
                        </div>    
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
<!--Academic Year auto increment-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
  
  $(document).ready(function(){
    $('#show_btn').click(function(){

      var user_log_date = $('#user_log_date').val();

      if(user_log_date == ''){
        alert('empty');
      }else{
        $.ajax({
          url: 'admin_classes/get_user_log.php',
          type: 'POST',
          data: {
            user_log_date :user_log_date
            },
          success: function(response){ 
              // Add response in Modal body
              $('#user_log_data').html(response);   
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
