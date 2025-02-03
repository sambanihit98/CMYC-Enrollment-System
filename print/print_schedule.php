<?php 

include '../admin_classes/config_mysqli.php';

$teacher_user_id   = $_GET['teacher_user_id'];
$academic_id       = $_GET['academic_id'];
$registrar_user_id = $_GET['registrar_user_id'];
$date_today        = date('M-d-Y');

$query = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_user_id = '$teacher_user_id'");
while($row = mysqli_fetch_array($query)){
  $account_firstname = ucwords($row['account_firstname']);
  $account_lastname  = ucwords($row['account_lastname']);

  $teacher = "$account_firstname $account_lastname";

  $query_academic = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_id = '$academic_id'");
  while($row_academic = mysqli_fetch_array($query_academic)){
    $academic_year_from = $row_academic['academic_year_from'];
    $academic_year_to   = $row_academic['academic_year_to'];
    $academic_term      = $row_academic['academic_term'];

    $academic_year = "$academic_year_from - $academic_year_to ($academic_term)";

    $query_registrar = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_user_id = '$registrar_user_id'");
    while($row_registrar = mysqli_fetch_array($query_registrar)){
      $account_firstname = ucwords($row_registrar['account_firstname']);
      $account_lastname  = ucwords($row_registrar['account_lastname']);

      $registrar = "$account_firstname $account_lastname ";
    }

  }
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>CMYCES | Print Schedule</title>

  <link rel="icon" href="../img/cmycis logo.png">
  
</head>
<body onload="window.print()">


<!----HEAD---->
 <table style="margin-left: 1%">
  <tr style="border: none;">
    <th><img src="../img/m_logo.jpg" style="width: 100px; margin-left: 10px;"></th>
    <th style="font-size: 30px;"> CATHOLIC MING YUAN COLLEGE 

      <p style="font-size: 15px; margin-left: -40px; margin-top: -5px;"> Hda Binitin Murcia, Negros Occidental Philippines</p> 

      <p style="font-size: 15px; margin-left: -45px; margin-top: -17px; color: blue;" >mingyuancollege@gmail.com | (034) 4413570</p>

    </th>
  </tr>
</table>

<h3 style="margin-bottom: -10px; text-align: center;"> SUBJECT SCHEDULE </h3>
<hr>

<table>
  <tr>
    <td> Teacher's Name:</td>
    <td style="font-weight: bold;" > <?php echo $teacher; ?> </td>
  </tr>

  <tr>
    <td> Released Date:</td>
    <td style="font-weight: bold;" > <?php echo "$date_today"; ?> </td>
  </tr>

  <tr>
    <td> Academic Year:</td>
    <td style="font-weight: bold;" ><?php echo $academic_year; ?></td>
  </tr>
</table>


<hr>
<!----HEAD---->

<!--------------------BIG TABLE------------------------->
<!---------------------->
<table class="mt-2" style="width: 100%; border-collapse: collapse; border: 1px solid black; font-size: 13px;">
  <thead style="text-align: center; background: yellow; " >
    <td class = 'table_header'>SUBJECT CODE</td>
    <td class = 'table_header'>SUBJECT DESCRIPTION</td>
    <td class = 'table_header'>UNIT</td>
    <td class = 'table_header'>TIME</td>
    <td class = 'table_header'>DAY</td>
    <td class = 'table_header'>ROOM</td>
    <td class = 'table_header'>COURSE & SECTION</td>
  </thead>

  <?php

    $query = mysqli_query($con, "SELECT DISTINCT subject_id, subject_section FROM teacher_subject_load 
                                WHERE account_user_id = '$teacher_user_id' 
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

          print "<td class = 'table_data'>$subject_code <br><br></td>";
          print "<td class = 'table_data'>$subject_description <br><br></td>";
          print "<td class = 'table_data'>$subject_unit <br><br></td>";
          
        }

        //---------------------------------------------------------------------------------------------------------------------------->
        //---------------------------------------------------------------------------------------------------------------------------->
        
        print "<td class = 'table_data'>";  //time
          $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                        AND subject_section = '$subject_section'
                                        AND academic_id = '$academic_id'
                                        AND account_user_id = '$teacher_user_id'");
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
        
        print "<td class = 'table_data'>";  //day
          $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                        AND subject_section = '$subject_section'
                                        AND academic_id = '$academic_id'
                                        AND account_user_id = '$teacher_user_id'");
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
        
        print "<td class = 'table_data'>"; //room
        $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                      AND subject_section = '$subject_section'
                                      AND academic_id = '$academic_id'
                                      AND account_user_id = '$teacher_user_id'");
          while($row1 = mysqli_fetch_array($query1)){

            $subject_room  = $row1['subject_room'];

            print "$subject_room <br><br>";
          }
        print "</td>"; //end of room

        //---------------------------------------------------------------------------------------------------------------------------->
        //---------------------------------------------------------------------------------------------------------------------------->
        
        print "<td class = 'table_data'>"; //course and section
        $query1 = mysqli_query($con, "SELECT * FROM teacher_subject_load WHERE subject_id = '$subject_id'
                                      AND subject_section = '$subject_section'
                                      AND academic_id = '$academic_id'
                                      AND account_user_id = '$teacher_user_id'");
                                      
          $row1 = mysqli_fetch_array($query1);

            $program_id          = $row1['program_id'];
            $subject_section     = $row1['subject_section'];
            $subject_year_level  = $row1['subject_year_level_teacher'];

            $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
            $row_program = mysqli_fetch_array($query_program);
              
              $program_code = $row_program['program_code'];

            print "$program_code - $subject_year_level$subject_section<br><br>";

          
          
        print "</td>"; //end of course and section

        print "</tr>";

      }
  ?>
</table>
<!---------------------->
<br>

<!--------------------BIG TABLE------------------------->

<div class = "row">
  <div class = "col-md-9"></div>
  <div class = "col-md-3">
    <label style="margin-left: 70%; font-size: 20px; color: black; color: black;"> <?php echo $registrar; ?>  </label>
    <hr style="margin-left: 70%; margin-top: 2px;  margin-bottom: 2px; width: 200px; background: black;">
    <label style="margin-left: 70%; font-size: 15px; color: black;">Released by:</label>
  </div>
</div>

<style>

.table_header{
  height: 35px;
  font-weight: bold;
  border: 1px solid black;
}

.table_data{
  border: 1px solid black;
  color: black;
  text-align: justify;
  text-align: center;
  vertical-align:middle;
}
  </style>
</body>
</html>