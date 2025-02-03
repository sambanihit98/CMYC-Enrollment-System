<?php 

$item_idz = $_GET['item_id'];
$student_id = $_GET['student_id'];
$curriculumz = $_GET['curriculumz'];
$description = $_GET['description'];

 ?>

<!DOCTYPE html>
<html>
<head>
    <title> <?php include'../bootstrap_lower/title_header.php'; ?> | Subject </title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="../css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="../css/animate.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

</head>

<body>

    <div id="wrapper">


    <!------SIDE NAV--------------------------------------------------------------------------------------------------------------->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">
                <li class="nav-header">

                    <div class="dropdown profile-element">
                        <img alt="image" class="rounded-circle img-fluid img-thumbnail" src="../img/m_logo.jpg" style="">                  
                    </div>           
                    
                </li>


    <li>
      <a href="../registrar_student_record_evaluate.php?student_id=<?php echo($student_id)?>&curriculum=<?php echo($curriculumz)?>"><i class="fa fa-lg fa-arrow-circle-left" aria-hidden="true"></i> <span class="nav-label"> <span class="nav-label">Back</span></a>
    </li>

            </ul>
        </div>
    </nav>
     <!------SIDE NAV--------------------------------------------------------------------------------------------------------------->
       





        <!----HEADER-------------------------------------------------------------------------------------------------------------->
        <div id="page-wrapper" class="gray-bg">
          <?php
          session_start();
          include '../admin_classes/config.php';

              
              if (!isset($_SESSION['acc_id'])) {
                  header("location:index.php?unauthorized");
              }else{
                  @$ac = $_SESSION['acc_id'];

          $query2 =  $connect->prepare("SELECT * FROM `faculty_account` WHERE acc_id = :ac");

          $query2->bindParam(':ac',$ac );
          $query2->execute();

              $userlist = $query2->fetchAll();
              foreach ($userlist as $row) {
                  $faculty_fname = $row['acc_fname'];
                  $faculty_id = $row['acc_user_id']; 
              }
              }    
          ?>

          <div class="row border-bottom">
          <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
          <div class="navbar-header">

          </div>
          <ul class="nav navbar-top-links navbar-right">
              <li>
                  <p class="mt-3" style="font-weight: bold;" >Welcome, <?php echo "$faculty_fname |"; ?></p>
              </li>

              <li>
                  <a href="../bootstrap_lower/log_out.php">
                      <i class="fa fa-sign-out"></i> Log-out
                  </a>
              </li>             
          </ul>

          </nav>
          </div>
<!----HEADER-------------------------------------------------------------------------------------------------------------->






<!----UNDER HEADER-------------------------------------------------------------------------------------------------------------->
  <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
      <div class="col-lg-10">
         <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Update Subject </p>

       </div>
  </div>
<!----UNDER HEADER-------------------------------------------------------------------------------------------------------------->








<!----DATA TABLES ONE-------------------------------------------------------------------------------------------------------------->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">

         <div class="ibox-content">
 
<table style="width: 100%;">
  <tr>
    <td class="bg-success text-center"> <strong> : : : UPDATE SUBJECT : : : </strong> </td>
  </tr>
</table>




<!--------UPDATE------->
<div class="container mt-4">
  <div class="row">

    <div class="col text-center">
      <h2> Catholic Ming Yuan College </h2>
      <img src="../img/3.jpg" style="width: 500px;">
    </div>

<!---devider-->

<div class="col">
<form method="post" action="../admin_classes/update_student_record.php" >

  <?php 
include '../admin_classes/config.php';
      $query = $connect->prepare("SELECT 

        manage_course.course_code AS course_code,
        manage_course.description AS description,
        manage_course.unit AS unit,
        student_subject_load.load_stat AS load_stat,
        student_subject_load.item_id AS item_id,
        manage_course.curriculum AS curriculum

        FROM `student_subject_load` LEFT OUTER JOIN manage_course ON student_subject_load.description = manage_course.description WHERE student_subject_load.student_id = '$student_id' ");

      $query->execute();
      $sub_insert = $query->fetchAll();
        foreach ($sub_insert as $sub_in) {

       
        $course_code = $sub_in['course_code'];
        $unit = $sub_in['unit'];
        $load_stat = $sub_in['load_stat'];
        $item_id = $sub_in['item_id'];
        $curriculum = $sub_in['curriculum'];
     
        if ($load_stat == 0) {
            $color = "rgb(255, 255, 255)";
        }else{
            $color = "rgb(255, 153, 153)";
        }

}
 ?>      

<!-----1st row------->
    <div class="row mt-2">
        <div class="col-sm">
            <label class="text-dark" style="font-weight: bold;" >DESCRIPTIVE TITLE*</label>

            <input type="hidden" name="student_id" value="<?php echo($student_id) ?>">
            <input type="hidden" name="item_id" value="<?php echo($item_idz) ?>">
            <input type="hidden" name="curriculum" value="<?php echo($curriculumz) ?>">

              <input list="browsers" class="form-control input-sm border-secondary rounded" id="description" name="description" value="<?php echo($description)?>" required>
                <datalist id="browsers"> 
                <?php  
                include '../admin_classes/config.php';
                $query = $connect->prepare("SELECT * FROM `manage_course` WHERE curriculum = '$curriculumz' ");
                $query->execute();
                $sub_insert = $query->fetchAll();
                foreach ($sub_insert as $sub_in) {
                  $course_code = $sub_in['course_code'];
                  $description = $sub_in['description'];

                  echo "<option value='$description'> $course_code </option>";
                }
                ?>
                </datalist> 
        </div>
      </div>    
<!-----3rd row------->


            <div class="modal-footer mt-3">
                <button type="submit" class="btn btn-sm border-secondary btn-success">Update</button>            
            </div>
      </div>
</form>
<!--------UPDATE------->


  </div>
</div>



</div>


            </div>
        </div>
    </div>







</div>
<?php include'../bootstrap_lower/lower.php'; ?>
</div>









</body>
</html>
