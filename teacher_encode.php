<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_teacher.php";

  $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1;");
  while($row = mysqli_fetch_array($query)){
    $academic_id = $row['academic_id'];
  }
?>

<!DOCTYPE html>
  <html>

  <head>
    <?php include 'bootstrap_lower/boots.php'; ?>
    <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Grades Encoding </title>

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

          <li class="active">
              <a href="teacher_encode.php"><i class="fa fa-lg fa-book" aria-hidden="true"></i> <span class="nav-label">Grades Encoding</span></a>
          </li>

          <li>
              <a href="teacher_subject_schedule.php"><i class="fa fa-lg fa-calendar" aria-hidden="true"></i> <span class="nav-label"> Subject Schedule  </span></a>
          </li>

          <li>
              <a href="teacher_account_settings.php"><i class="fa fa-lg fa-cog" aria-hidden="true"></i> <span class="nav-label">Account Settings</span></a>
          </li> 

        </ul>
      </div>
    </nav>
    
    <!----HEADER----->
    <div id="page-wrapper" class="gray-bg">
      <?php include 'bootstrap_lower/header.php';?>
      
      <!----UNDER HEADER------->
      <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
        <div class="col-lg-10">
          <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Grades Encoding </p>
        </div>
      </div>

      <!---------------------------------------------------------------------------------------------------------------------------->
      <!---------------------------------------------------------------------------------------------------------------------------->
      <!-- Error modal / Empty fields-->

      <div class="modal fade" id="empty_error_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Empty Field Error</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <h2 style = "text-align:center; font-weight:bold; color:red;">ERROR!</h2>

              <h3 style = "text-align:center;">Please fill up the information needed!</h3>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

      <!----DATA TABLES ONE-------------------------------------------------------------------------------------------------------------->
      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-12">
            <div class="ibox-content">

              <div class = "container"> <!-- start of container -->

                <div class = "row">
                  <div class = "col-md-12">
                    <div class = "row">

                      <div class = "col-md-3">
                        <h4 style="font-weight: 350; margin-right: 15px;">Teacher </h4>  
                      </div> 

                      <div class = "col-md-3">
                        <h3 style="font-size: 15px;"> 
                        <?php echo "$account_firstname $account_lastname";  ?>
                        </h3>
                      </div>

                      <div class = "col-md-3"></div>

                      <div class = "col-md-3"></div>

                    </div>
                  </div>
                </div>
                    
                <div class = "row">
                  <div class = "col-md-12">
                    <div class = "row">

                      <div class = "col-md-3">
                        <h4 style="font-weight: 350; margin-right: 15px;" class="text-dark">Academic Year </h4> 
                      </div>

                      <div class = "col-md-3">
                        <h3 style="font-size: 15px;"> 
                          <?php 
                            include 'admin_classes/config_mysqli.php';
                              $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                              while($row = mysqli_fetch_array($query)){
                                $academic_year_from  = $row['academic_year_from'];
                                $academic_year_to    = $row['academic_year_to'];

                                print "$academic_year_from - $academic_year_to";
                              }
                          ?> 
                        </h3>
                      </div>

                      <div class = "col-md-3"></div>
                      <div class = "col-md-3"></div>
 
                    </div>
                  </div>
                </div>

                <div class = "row">
                  <div class = "col-md-12">
                    <div class = "row">

                      <div class = "col-md-3">
                        <h4 style="font-weight: 350; margin-right: 15px;"> Term: </h4>  
                      </div>
                      
                      <div class = "col-md-3">
                        <h3 style="font-size: 15px;"> 
                          <?php 
                            include 'admin_classes/config_mysqli.php';
                              $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
                              while($row = mysqli_fetch_array($query)){
                               
                                $academic_term       = $row['academic_term'];

                                print "$academic_term";
                              }
                          ?> 
                        </h3>
                      </div>

                      <div class = "col-md-3"></div>
                      <div class = "col-md-3"></div>

                    </div>
                  </div>
                </div>

                <div class = "row">
                  <div class = "col-md-12">
                    <div class = "row">

                      <div class = "col-md-3">
                      <h4 style="font-weight: 350; margin-right: 15px;">Period: </h4>  
                      </div>
                      
                      <div class = "col-md-3">
                        <select class="form-control border-secondary rounded input-sm" id = "period" >
                          <option value = "" hidden>Select Period</option>   
                          <option value = "Prelim" >Prelim</option> 
                          <option value = "Midterm" >Midterm</option> 
                          <!--<option value = "Semi Final" >Semi Final</option>-->
                          <option value = "Final" >Final</option> 
                          <option value = "Average" >Average</option>
                        </select>
                      </div>

                      <div class = "col-md-3"></div>
                      <div class = "col-md-3"></div>

                    </div>
                  </div>
                </div> 
                    
                <div class = "row mt-2">
                  <div class = "col-md-12">
                    <div class = "row">

                      <div class = "col-md-3">
                        <h4 style="font-weight: 350; margin-right: 15px;">Course, Year & Section: </h4>  
                      </div> 
                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->

                      <div class = "col-md-3">
                        <select class="form-control border-secondary rounded input-sm" id = "program_id" >
                          <option value = "" hidden>Select Course</option>   

                          <?php
                            include 'admin_classes/config_mysqli.php';
                            //gets single course only// disregarding duplicates
                            $query = mysqli_query($con, "SELECT DISTINCT program_id FROM teacher_subject_load
                                                        WHERE account_user_id = '$account_user_id'
                                                        AND academic_id = '$academic_id'");
                                                        
                            while($row = mysqli_fetch_array($query)){
                              $program_id = $row['program_id'];
                            
                                //getting the program code
                                $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
                                while($row_program = mysqli_fetch_array($query_program)){

                                  $program_code = $row_program['program_code'];

                                  print "<option value = '$program_id' >$program_code</option>  ";
                                }                           
                            }
                          ?>
                        </select>
                      </div>

                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->

                      <div class = "col-md-3">
                        <select class="form-control border-secondary rounded input-sm" id = "year_level" >
                          <option value = "" hidden>Select Year Level</option>   

                          <?php
                            include 'admin_classes/config_mysqli.php';

                            //gets single year level only// disregarding duplicates
                            $query = mysqli_query($con, "SELECT DISTINCT subject_year_level_teacher FROM teacher_subject_load
                                                        WHERE account_user_id = '$account_user_id'
                                                        AND academic_id = '$academic_id'
                                                        ORDER BY subject_year_level_teacher ASC");
                                                        
                            while($row = mysqli_fetch_array($query)){
                              $subject_year_level_teacher  = $row['subject_year_level_teacher'];
  
                              if($subject_year_level_teacher == 1){
                                $year_level = "1st Year";
                              }else if($subject_year_level_teacher == 2){
                                $year_level = "2nd Year";
                              }else if($subject_year_level_teacher == 3){
                                $year_level = "3rd Year";
                              }else if($subject_year_level_teacher == 4){
                                $year_level = "4th Year";
                              }
                                  print "<option value = '$subject_year_level_teacher' >$year_level</option>  ";
                            }
                          ?>
                          </select>
                      </div>

                      <!---------------------------------------------------------------------------------------------------------------------------->
                      <!---------------------------------------------------------------------------------------------------------------------------->

                      <div class = "col-md-3">
                        <select class="form-control border-secondary rounded input-sm" id = "section" >
                          <option value = "" hidden>Select Section</option>  
                          
                          <?php
                            include 'admin_classes/config_mysqli.php';

                            //gets single section only// disregarding duplicates
                            $query = mysqli_query($con, "SELECT DISTINCT subject_section FROM teacher_subject_load
                                                        WHERE account_user_id = '$account_user_id'
                                                        AND academic_id = '$academic_id'
                                                        ORDER BY subject_section ASC");
                                                        
                            while($row = mysqli_fetch_array($query)){
                              $subject_section = $row['subject_section'];                         
                                  print "<option value = '$subject_section' >$subject_section</option>  ";
                            }
                          ?>
                          </select>
                      </div>

                    </div>
                  </div>
                </div>

                <!---------------------------------------------------------------------------------------------------------------------------->
                <!---------------------------------------------------------------------------------------------------------------------------->

                <div class = "row mt-2">
                  <div class = "col-md-12">
                    <div class = "row">

                      <div class = "col-md-3">
                        <h4 style="font-weight: 350; margin-right: 15px;">Subject Handled </h4>  
                      </div> 

                      <div class = "col-md-6">
                      <select class="form-control border-secondary rounded input-sm" id = "subject_id" >
                          <option value = "" hidden>Select Subject</option>  
                          
                          <?php
                            include 'admin_classes/config_mysqli.php';

                            //gets single section only// disregarding duplicates
                            $query = mysqli_query($con, "SELECT DISTINCT subject_id FROM teacher_subject_load
                                                        WHERE account_user_id = '$account_user_id'
                                                        AND academic_id = '$academic_id'
                                                        ORDER BY subject_section ASC");
                                                        
                            while($row = mysqli_fetch_array($query)){
                              $subject_id = $row['subject_id']; 
                              
                                $query_subject = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_id = '$subject_id'");
                                while($row_subject = mysqli_fetch_array($query_subject)){
                                  $subject_code        = $row_subject['subject_code'];
                                  $subject_description = $row_subject['subject_description'];
                                  print "<option value = '$subject_id' >$subject_code: $subject_description</option>";
                                }  
                            }
                          ?>
                          </select>
                      </div>

                      <div class = "col-md-3" >
                        <button type="button" class="btn btn-success btn-sm ml-2" style = 'float:right;' id = 'show_btn'> <i class="fa fa-eye" aria-hidden="true"></i> Show</button>   
                      </div> 

                    </div>
                  </div>
                </div>

              </div> <!-- end of container -->

              <hr>

              <div id = 'table_data'>
              
              </div>
       
            </div>

          </div>
        </div>
      </div>
        <?php include 'bootstrap_lower/lower.php'; ?>
    </div>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-----HIDDEN DATA------------>

<?php
  include 'admin_classes/config_mysqli.php';
  $query = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_status = 1");
    while($row = mysqli_fetch_array($query)){
      $academic_id = $row['academic_id'];

      print "<input type = 'text' id = 'academic_id' value = '$academic_id' hidden>";
    }
?>


<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-----SCRIPTS------------>

    <script>
      $(document).ready(function(){
        $('#show_btn').click(function(){
          var academic_id = $('#academic_id').val();

          var period = $('#period').val();
          var program_id = $('#program_id').val();
          var year_level = $('#year_level').val();
          var section = $('#section').val();
          var subject_id = $('#subject_id').val();

          if(period == "" || program_id == "" || year_level == "" || section == "" || subject_id == ""){
            $('#empty_error_modal').modal('show');
          }else{
            window.location.replace("teacher_encode_grades.php?period="+period+"&program_id="+program_id+"&year_level="+year_level+"&section="+section+"&subject_id="+subject_id+"&academic_id="+academic_id);
          }

        });
      });
    </script>




</body>
</html>
