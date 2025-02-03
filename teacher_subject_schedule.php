<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_teacher.php";

  $query2 = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
    while($row2 = mysqli_fetch_array($query2)){
      $academic_id = $row2['academic_id'];
      $academic_year_from = $row2['academic_year_from'];
      $academic_year_to = $row2['academic_year_to'];
      $academic_term = $row2['academic_term'];
    }

?>

<!DOCTYPE html>
  <html>

  <head>
      <?php include 'bootstrap_lower/boots.php'; ?>
      <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Schedule</title>

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
                  <a href="teacher_dashboard.php"><i class="fa fa-lg fa-home" aria-hidden="true"></i> <span class="nav-label">Home</span></a>
              </li>

              <li>
                  <a href="teacher_encode.php"><i class="fa fa-lg fa-book" aria-hidden="true"></i> <span class="nav-label">Grade Encoding</span></a>
              </li>

              <li class="active">
                  <a href="teacher_subject_schedule.php"><i class="fa fa-lg fa-calendar" aria-hidden="true"></i> <span class="nav-label"> Subject Schedule  </span></a>
              </li>

              <li>
                  <a href="teacher_account_settings.php"><i class="fa fa-lg fa-cog" aria-hidden="true"></i> <span class="nav-label">Account Settings</span></a>
              </li> 

          </ul>
        </div>
      </nav>

      <!----HEADER-------------------------------------------------------------------------------------------------------------->
      <div id="page-wrapper" class="gray-bg">
        <?php include 'bootstrap_lower/header.php';?>
      
          <!----UNDER HEADER--------------->
          <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
              <div class="col-lg-10">
                <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Schedule </p>

              </div>
          </div>
       
          <!----DATA TABLES ONE---->
          <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
              <div class="col-lg-12">
                <div class="ibox ">

                  <div class="ibox-content">
                    <div class="table-responsive">

                      <!-----NEW TABLE---->
                      <h4 class="text-center">: : :  TEACHER TIME & SCHEDULE  : : :</h4>

                      <div class = "container"> <!-- start of container -->

                        <div class = "row">
                          <div class = "col-md-6">
                            <div class = "row">

                              <div class = "col-md-4">
                                <h4 style="font-weight: 350; margin-right: 15px;" class="text-dark">ID Number: </h4>
                              </div>
                              
                              <div class = "col-md-8">
                                <h3 style="font-size: 19px;"> <?php echo "$account_user_id"; ?> </h3>
                              </div>

                            </div>
                          </div>
                        </div>

                        <div class = "row">
                          <div class = "col-md-6">
                            <div class = "row">

                              <div class = "col-md-4">
                              <h4 style="font-weight: 350; margin-right: 15px;">Teachers Name: </h4>  
                              </div>
                              
                              <div class = "col-md-8">
                              <h3 style="font-size: 15px;"> <?php echo "$account_firstname $account_lastname"; ?>
                              </div>

                            </div>
                          </div>
                        </div>

                        <div class = "row">
                          <div class = "col-md-6">
                            <div class = "row">

                              <div class = "col-md-4">
                                <h4 style="font-weight: 350; margin-right: 15px;">Position: </h4>
                              </div>
                              
                              <div class = "col-md-8">
                                <h3 style="font-size: 15px;"> <?php echo "$account_position"; ?> </h3>
                              </div>

                            </div>
                          </div>
                        </div>

                        <div class = "row">
                          <div class = "col-md-6">
                            <div class = "row">

                              <div class = "col-md-4">
                                <h4 style="font-weight: 350; margin-right: 15px;">Academic Year: </h4>  
                              </div>
                              
                              <div class = "col-md-8">
                                <h3 style="font-size: 15px;"> 
                                
                                  <?php print "$academic_year_from - $academic_year_to"; ?>
                              </div>

                            </div>
                          </div>
                        </div>

                        <div class = "row">
                          <div class = "col-md-6">
                            <div class = "row">

                              <div class = "col-md-4">
                                <h4 style="font-weight: 350; margin-right: 15px;">Academic Term: </h4>  
                              </div>
                              
                              <div class = "col-md-8">
                                <h3 style="font-size: 15px;">

                                  <?php print "$academic_term"; ?>
                              </div>

                            </div>
                          </div>

                          
                        </div>

                      </div> <!-- end of container -->

                      <br>

                      <hr style="margin-top: -15px;">

                      <!----TABLE----->
                      <table class="table table-striped" >
                        <thead class="bg-success text-center">
                          <th >SUBJECT CODE</th>
                          <th >SUBJECT DESCRIPTION</th>
                          <th >UNIT</th>
                          <th >TIME</th>
                          <th >DAY</th>
                          <th >ROOM</th>
                          <th >Course & Section</th>
                        </thead>

                          <?php
                            include 'admin_classes/config_mysqli.php';

                            $query = mysqli_query($con, "SELECT DISTINCT subject_id, subject_section FROM teacher_subject_load WHERE account_user_id = '$account_user_id' 
                                                          AND academic_id = '$academic_id' ORDER BY day_initial ASC");

                              while($row = mysqli_fetch_array($query)){
                                $subject_id       = $row['subject_id'];
                                $subject_section  = $row['subject_section'];

                                print "<tr class ='text-center'>";

                                //---------------------------------------------------------------------------------------------------------------------------->
                                //---------------------------------------------------------------------------------------------------------------------------->
                                
                                $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
                                while($row_subject = mysqli_fetch_array($query_subject)){

                                  $subject_code           = $row_subject['subject_code'];
                                  $subject_description    = $row_subject['subject_description'];
                                  $subject_unit           = $row_subject['subject_unit'];

                                  print "<td style = 'vertical-align:middle;'>$subject_code</td>";
                                  print "<td style = 'vertical-align:middle;'>$subject_description</td>";
                                  print "<td style = 'vertical-align:middle;'>$subject_unit</td>";
                                  
                                }

                                //---------------------------------------------------------------------------------------------------------------------------->
                                //---------------------------------------------------------------------------------------------------------------------------->
                               
                                print "<td style = 'vertical-align:middle;'>";  //time
                                  $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                                AND subject_section = '$subject_section'");
                                  while($row1 = mysqli_fetch_array($query1)){
      
                                    $subject_time_from     = $row1['subject_time_from'];
                                    $subject_time_to       = $row1['subject_time_to'];
                                    $time_from             = date("g:ia", strtotime($subject_time_from));
                                    $time_to               = date("g:ia", strtotime($subject_time_to));

                                    print "$time_from - $time_to <br><br>";
                                  }
                                print "</td>"; //end of time

                                //---------------------------------------------------------------------------------------------------------------------------->
                                //---------------------------------------------------------------------------------------------------------------------------->
                               
                                print "<td style = 'vertical-align:middle;'>";  //day
                                  $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                                AND subject_section = '$subject_section'");
                                  while($row1 = mysqli_fetch_array($query1)){
      
                                    $day_initial   = $row1['day_initial'];

                                    if($day_initial == "1Mon"){
                                      $day = "Monday";
                                    }else if($day_initial == "2Tue"){
                                      $day = "Tuesday";
                                    }else if($day_initial == "3Wed"){
                                      $day = "Wednesday";
                                    }else if($day_initial == "4Thu"){
                                      $day = "Thursday";
                                    }else if($day_initial == "5Fri"){
                                      $day = "Friday";
                                    }else if($day_initial == "6Sat"){
                                      $day = "Saturday";
                                    }else if($day_initial == "7Sun"){
                                      $day = "Sunday";
                                    }
                                
                                    print "$day <br><br>";
                                  }
                                print "</td>"; //end of day

                                //---------------------------------------------------------------------------------------------------------------------------->
                                //---------------------------------------------------------------------------------------------------------------------------->
                                
                                print "<td style = 'vertical-align:middle;'>"; //room
                                $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                              AND subject_section = '$subject_section'");
                                  while($row1 = mysqli_fetch_array($query1)){

                                    $subject_room  = $row1['subject_room'];

                                    print "$subject_room <br><br>";
                                  }
                                print "</td>"; //end of room

                                //---------------------------------------------------------------------------------------------------------------------------->
                                //---------------------------------------------------------------------------------------------------------------------------->
                               
                                print "<td style = 'vertical-align:middle;'>"; //course and section
                                $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                                              AND subject_section = '$subject_section'");
                                                              
                                  while($row1 = mysqli_fetch_array($query1)){

                                    $program_id          = $row1['program_id'];
                                    $subject_section     = $row1['subject_section'];
                                    $subject_year_level  = $row1['subject_year_level_teacher'];

                                    $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                    $row_program = mysqli_fetch_array($query_program);
                                      
                                      $program_code = $row_program['program_code'];

                                    print "$program_code - $subject_year_level$subject_section<br><br>";

                                  }
                                  
                                print "</td>"; //end of course and section

                                //---------------------------------------------------------------------------------------------------------------------------->
                                //---------------------------------------------------------------------------------------------------------------------------->

                                print "</tr>";
                               


                              }
                                

                            

                            
                          ?>
                      </table>

                      <hr>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
              
<?php include 'bootstrap_lower/lower.php'; ?>

</div>

</body>
</html>
