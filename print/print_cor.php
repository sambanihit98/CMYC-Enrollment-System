<?php
  include '../admin_classes/config_mysqli.php';
    $enrollment_id = $_GET['enrollment_id'];
    $registrar_user_id = $_GET['registrar_user_id'];

    $query_registrar = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_user_id = '$registrar_user_id'");
    while($row_registrar = mysqli_fetch_array($query_registrar)){
      $account_firstname = ucwords($row_registrar['account_firstname']);
      $account_lastname  = ucwords($row_registrar['account_lastname']);

      $registrar = "$account_firstname $account_lastname";
    }

    $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
    while($row_enrollment = mysqli_fetch_array($query_enrollment)){
      $academic_id        = $row_enrollment['academic_id'];
      $student_id         = $row_enrollment['student_id'];
      $student_firstname  = $row_enrollment['student_firstname'];
      $student_middlename = $row_enrollment['student_middlename'];
      $student_lastname   = $row_enrollment['student_lastname'];
      $student_year_level = $row_enrollment['student_year_level'];
      $student_section    = $row_enrollment['student_section'];
      $program_id         = $row_enrollment['program_id'];

      $middle_initial = substr($student_middlename, 0, 1);
      $fullname = "$student_firstname $middle_initial. $student_lastname";

      $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
      while($row_program = mysqli_fetch_array($query_program)){
        $program_description = $row_program['program_description'];
      }

      $query_academic = mysqli_query($con, "SELECT * FROM academic_year WHERE academic_id = '$academic_id'");
      while($row_academic = mysqli_fetch_array($query_academic)){
        $academic_year_from = $row_academic['academic_year_from'];
        $academic_year_to   = $row_academic['academic_year_to'];
        $academic_term = $row_academic['academic_term'];

        $academic_year = "$academic_year_from - $academic_year_to ( $academic_term)";
      }
    }
?>

<!DOCTYPE html>
  <html>
    <head>
      <title>CMYCES | Print COR</title>

  <link rel="icon" href="../img/cmycis logo.png">
      
    </head>
    <body onload="window.print();" >

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
      <!----HEAD---->

      <h3 style="text-align: center; margin-top: -10px; margin-bottom: -10px;"> STUDENT'S COPY </h3>
      <hr>

      <table style="margin-bottom: 50px;">
        <tr>
          <td style="width: 50%;"><b>NAME:</b> <?php echo $fullname; ?>  <br><b>PROGRAM: </b><?php echo $program_description; ?> </td>
          <td style="width: 30%;"><b>ID Number:</b> <?php echo "$student_id"; ?> <br><b>A.Y: </b><?php echo $academic_year; ?></td>
        </tr>
      </table>

      <hr style="margin-bottom: -1px;">

      <table style = 'width:100%;'>
        <thead style = 'text-align:center;'>
          <th class = 'table_header' >Subject Code</th>
          <th class = 'table_header' >Descriptive Title</th>
          <th class = 'table_header' >Credit Unit</th>
        </thead>

        <tbody style="font-size: 12px;">
          <?php 

              $query = mysqli_query($con, "SELECT * FROM student_subject_load 
                          JOIN manage_subject ON student_subject_load.subject_id = manage_subject.subject_id
                          JOIN manage_enrollment ON student_subject_load.enrollment_id = manage_enrollment.enrollment_id
                          WHERE student_subject_load.enrollment_id = '$enrollment_id'");

                while($row = mysqli_fetch_array($query)){
                  $student_subject_load_id = $row['student_subject_load_id'];
                  $academic_id             = $row['academic_id'];
                  $subject_id              = $row['subject_id'];
                  $subject_code            = $row['subject_code'];
                  $subject_description     = $row['subject_description'];
                  $subject_unit            = $row['subject_unit'];

                  $student_section         = $row['student_section'];

                  print "
                    <tr style = 'text-align:center;'>
                      <td class = 'table_data'> $subject_code </td>
                      <td class = 'table_data'> $subject_description </td>
                      <td class = 'table_data'> $subject_unit </td> 
                    </tr>";
                  }
          ?>
        </tbody>
      </table>

      <hr>


<!------COUNT----->
<?php 
include '../admin_classes/config.php';
      $query = $connect->prepare("SELECT SUM(manage_subject.subject_unit) AS unit
                                  FROM `student_subject_load` 
                                  LEFT OUTER JOIN manage_subject ON student_subject_load.subject_id = manage_subject.subject_id 
                                  WHERE student_subject_load.student_id = '$student_id'
                                  AND student_subject_load.enrollment_id = '$enrollment_id'");

      $query->execute();
      $sub_insert = $query->fetchAll();
        foreach ($sub_insert as $sub_in) {

        $unit = $sub_in['unit'];
       } 
      ?>

<table style="font-weight: bold; margin-top: -10px;">
  <tr>
    <td style="width: 10%;"> </td>
    <td style="width: 40%;"> </td>
    <td style="width: 10%;"> Total Units: <?php echo "$unit"; ?></td>
  </tr>
</table>
<!------COUNT----->



<hr style="margin-top: -1px;">


<table style="margin-left: 20px; margin-top: 50px; margin-bottom: 50px; color: black">
  <tr>
    <td>
      <strong style="font-size: 20px;" >AGREEMENT:</strong> <br>
      <p style="text-align: justify; font-size: 15px;"> I hereby to the foregoing enrollment and I shall abide by all the rules and regulation now enforced or may be promulgated by Catholic Ming Yuan College, from time to time.. Likewise, I agree to the cancellation of the credits I have earned in course I have  enrolled under false pretenses. I am aware of the tuition and all other fees at the time of enrollment and I obliged myself to pay the amount as schedule subject of adjustments as may be required. </p>
    </td>
  </tr>
</table>


<table class="mt-2" style = 'margin-left: 20px;'>
  <tr>
    <td style="width: 50%;"> <hr style="width: 50%; margin-left: 6px; margin-bottom: -20px;"> <br> Signature Over Printed Name </td>
    <td style="width: 15%;"><?php echo  $registrar; ?><br> Registrar </td>
  </tr>
</table>



<table style="margin-left: 20px; margin-top: 20px; color: black">
  <tr>
    <td>
      <strong style="font-size: 20px;" >NOTE: </strong> <br>
      <p style="text-align: justify; font-size: 15px;"> This is your informed, official enrollments, thus you  are enrolled officially ONLY in the courses and sections listed above. Since the foregoing ASSESSMENT is based on the official enrollment, should there be any discrepancy from your validated enrollment (Student’s Copy) or if you wish to cancel your enrollment, you are advised to see the registrar.  </p>
    </td>
  </tr>
</table>


</body>
</html>