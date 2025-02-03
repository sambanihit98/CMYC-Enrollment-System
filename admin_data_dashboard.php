<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_system_admin.php";
?>

<!DOCTYPE html>
<html>

<head>
  <?php include 'bootstrap_lower/boots.php'; ?>
  <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Data Dashboard</title>

  <?php include "include/tab_icon.php"; ?>
  
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
              <a href="admin_dashboard.php"><i class="fa fa-lg fa-home" aria-hidden="true"></i> <span class="nav-label">Home</span></a>
          </li>

          <li class="active">
              <a href="admin_data_dashboard.php"><i class="fa fa-lg fa-bar-chart" aria-hidden="true"></i> <span class="nav-label">Data Dashboard</span></a>
          </li>

          <li>
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

    <!----HEADER----->
    <div id="page-wrapper" class="gray-bg">
    <?php include 'bootstrap_lower/header.php';?>

      <!----COUNTER------------------------------------------------------------------------------------------------------------------->
      <div class="wrapper wrapper-content bg-white ">

        <div class = "container">
          <?php
            include 'admin_classes/config_mysqli.php';
            $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
              while($row = mysqli_fetch_array($query)){
                $academic_id          = $row['academic_id'];
                $academic_year_from   = $row['academic_year_from'];
                $academic_year_to     = $row['academic_year_to'];
                $academic_term        = $row['academic_term'];
              }
          ?>

          <h4>Current Academic Year:</h4>
          <h2 style = 'font-weight:bold;'> <?php print "$academic_year_from - $academic_year_to ($academic_term)";  ?> </h2>
        </div>

      </div>

      <hr>
     
        <!----COUNTER------------------------------------------------------------------------------------------------------------------->
        <div class="wrapper wrapper-content bg-white ">

          <div class="row">

            <div class="col-sm">
              <div class="ibox ">
                <div class="ibox-title bg-success">
                  <h5>ADMINISTRATOR</h5>
                </div>
                <div class="ibox-content">
                  <h1 class="no-margins" style="font-weight: bold; font-size: 35px;"> 
                    <?php 
                      include 'admin_classes/config_mysqli.php';

                      $query_total_admins = mysqli_query($con, "SELECT COUNT(account_user_id) AS total_admins FROM faculty_account 
                                                                  WHERE account_position = 'System Admin' AND account_status = 1");
                      $row_total_admins = mysqli_fetch_array($query_total_admins);
                      $total_admins = $row_total_admins['total_admins'];

                      print "$total_admins";
                      
                    ?>
                  </h1>                    
                  <small>Total System Admins</small>
                </div>
              </div>
            </div>

            <div class="col-sm">
              <div class="ibox ">
                <div class="ibox-title bg-success">
                  <h5>REGISTRAR</h5>
                </div>
                <div class="ibox-content">
                  <h1 class="no-margins" style="font-weight: bold; font-size: 35px;">
                    <?php 
                      include 'admin_classes/config_mysqli.php';

                      $query_total_registrars = mysqli_query($con, "SELECT COUNT(account_user_id) AS total_registrars FROM faculty_account 
                                                                  WHERE account_position = 'System Admin' AND account_status = 1");
                      $row_total_registrars = mysqli_fetch_array($query_total_registrars);
                      $total_registrars = $row_total_registrars['total_registrars'];

                      print "$total_registrars";
                      
                    ?>
                  </h1>
                  <small>Total Registrars</small>
                </div>
              </div>
            </div>

            <div class="col-sm">
              <div class="ibox ">
                <div class="ibox-title bg-success">
                  <h5>TEACHER</h5>
                </div>
                <div class="ibox-content">
                  <h1 class="no-margins">   </h1>                  
                  <h1 class="no-margins" style="font-weight: bold; font-size: 35px;">
                    <?php 
                      include 'admin_classes/config_mysqli.php';

                      $query_total_teachers = mysqli_query($con, "SELECT COUNT(account_user_id) AS total_teachers FROM faculty_account 
                                                                  WHERE account_position = 'Teacher' AND account_status = 1");
                      $row_total_teachers = mysqli_fetch_array($query_total_teachers);
                      $total_teachers = $row_total_teachers['total_teachers'];

                      print "$total_teachers";
                      
                    ?>
                  </h1>
                  <small>Total Employed Teachers</small>
                </div>
              </div>
            </div>

            <div class="col-sm">
              <div class="ibox ">
                <div class="ibox-title bg-success">
                  <h5>STUDENTS</h5>
                </div>
                <div class="ibox-content">
                  <h1 class="no-margins" style="font-weight: bold; font-size: 35px;"> 
                    <?php 
                      include 'admin_classes/config_mysqli.php';

                      $query_total_students = mysqli_query($con, "SELECT COUNT(enrollment_id) AS total_students FROM manage_enrollment WHERE academic_id = '$academic_id'");
                      $row_total_students = mysqli_fetch_array($query_total_students);
                      $total_students = $row_total_students['total_students'];

                      print "$total_students";
                      
                    ?>
                  </h1>
                  <small>Total Enrolled Students</small>
                </div>
              </div>
            </div>
            
          </div>

          <hr>

          <!---------------------------------------------------------------------------------------------------->
          <!---------------------------------------------------------------------------------------------------->

          <div class="row">

            <div class="col-sm">
              <div class="ibox ">
                <div class="ibox-title bg-success">
                  <h5>DEPARTMENT</h5>
                </div>
                <div class="ibox-content">
                  <h1 class="no-margins" style="font-weight: bold; font-size: 35px;"> 
                    <?php 
                      include 'admin_classes/config_mysqli.php';

                      $query_total_departments = mysqli_query($con, "SELECT COUNT(department_id) AS total_departments FROM manage_department 
                                                                  WHERE department_status = 1");
                      $row_total_departments = mysqli_fetch_array($query_total_departments);
                      $total_departments = $row_total_departments['total_departments'];

                      print "$total_departments";
                      
                    ?>
                  </h1>                    
                  <small>Total Departments</small>
                </div>
              </div>
            </div>

            <div class="col-sm">
              <div class="ibox ">
                <div class="ibox-title bg-success">
                  <h5>PROGRAM</h5>
                </div>
                <div class="ibox-content">
                  <h1 class="no-margins" style="font-weight: bold; font-size: 35px;">
                    <?php 
                      include 'admin_classes/config_mysqli.php';

                      $query_total_programs = mysqli_query($con, "SELECT COUNT(program_id) AS total_programs FROM manage_program 
                                                                  WHERE program_status = 1");
                      $row_total_programs = mysqli_fetch_array($query_total_programs);
                      $total_programs = $row_total_programs['total_programs'];

                      print "$total_programs";
                      
                    ?>
                  </h1>
                  <small>Total Programs (Course)</small>
                </div>
              </div>
            </div>

            <div class="col-sm">
              <div class="ibox ">
                <div class="ibox-title bg-success">
                  <h5>SUBJECT</h5>
                </div>
                <div class="ibox-content">
                  <h1 class="no-margins">   </h1>                  
                  <h1 class="no-margins" style="font-weight: bold; font-size: 35px;">
                    <?php 
                      include 'admin_classes/config_mysqli.php';

                      $query_total_subjects = mysqli_query($con, "SELECT COUNT(subject_id) AS total_subjects FROM manage_subject 
                                                                  WHERE subject_status = 1");
                      $row_total_subjects = mysqli_fetch_array($query_total_subjects);
                      $total_subjects = $row_total_subjects['total_subjects'];

                      print "$total_subjects";
                      
                    ?>
                  </h1>
                  <small>Total Subjects</small>
                </div>
              </div>
            </div>

          </div>

</div>
<?php include 'bootstrap_lower/lower.php'; ?>
</div>
      
    <!-- Mainly scripts -->
</body>
</html>
