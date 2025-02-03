

<!DOCTYPE html>
<html>
<head>
    <title> <?php include'../bootstrap_lower/title_header.php'; ?> | Enrollment </title>
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
<?php  

$student_id = $_GET['student_id'];

include '../admin_classes/config.php';
$query = $connect->prepare("SELECT * FROM `manage_enrollment` WHERE student_id = '$student_id' ");
$query->execute();
$sub_insert = $query->fetchAll();
foreach ($sub_insert as $account) {

$item_id = $account['item_id'];
$num_que = $account['num_que']; 
$student_id = $account['student_id']; 
$program_code = $account['program_code'];
$lastname = $account['lastname'];
$firstname = $account['firstname'];
$middlename = $account['middlename'];
$program_code = $account['program_code'];
$status = $account['status'];
$curriculum = $account['curriculum'];

}
?>


    <li>
      <a href="../registrar_manage_enrollment.php"><i class="fa fa-lg fa-arrow-circle-left" aria-hidden="true"></i> <span class="nav-label"> <span class="nav-label">Back</span></a>
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
         <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Update Student </p>

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
    <td class="bg-success text-center"> <strong> : : : UPDATE STUDENT : : : </strong> </td>
  </tr>
</table>


<?php 
$student_id = $_GET['student_id'];
$item_id = $_GET['item_id'];

include '../admin_classes/config.php';
$query = $connect->prepare("SELECT * FROM `manage_enrollment` WHERE student_id = '$student_id' ");
$query->execute();
$sub_insert = $query->fetchAll();
foreach ($sub_insert as $account) {

$item_id = $account['item_id'];
$num_que = $account['num_que']; 
$student_id = $account['student_id']; 
$program_code = $account['program_code'];
$lastname = $account['lastname'];
$firstname = $account['firstname'];
$middlename = $account['middlename'];
$program_code = $account['program_code'];
$status = $account['status'];



}
 ?>

<!--------UPDATE------->
<div class="container mt-4">
  <div class="row">

    <div class="col text-center">
      <h2> Catholic Ming Yuan College </h2>
      <img src="../img/3.jpg" style="width: 500px;">
    </div>

<!---devider-->

<div class="col">
<form method="post" action="../admin_classes/update_enrollment.php" >

            <input type="hidden" id="item_id" name="item_id" value="<?php echo($item_id) ?>">
            <input type="hidden" id="student_id" name="student_id" value="<?php echo($student_id) ?>">

<!-----1st row------->
    <div class="row mt-2">
        <div class="col-sm">
              <table>
                <td>
                  <label class="text-dark text-center" style="font-weight: bold;" > LAST NAME*</label>
                </td>
              </table>
              <input type="text" class="form-control border border-secondary rounded input-sm" id="lastname" name="lastname" value="<?php echo($lastname) ?>" required>
        </div>       
    </div>

    <div class="row mt-2">
        <div class="col-sm">
              <table>
                <td>
                  <label class="text-dark" style="font-weight: bold;" > FIRST NAME*</label>
                </td>
              </table>
              <input type="text" class="form-control border border-secondary rounded input-sm" id="firstname" name="firstname" value="<?php echo($firstname) ?>" required>
        </div>       
    </div>

    <div class="row mt-2">
        <div class="col-sm">
              <table>
                <td>
                  <label class="text-dark" style="font-weight: bold;" > MIDDLE NAME*</label>
                </td>
              </table>
              <input type="text" class="form-control border border-secondary rounded input-sm" id="middlename" name="middlename" value="<?php echo($middlename) ?>" required>
        </div>       
    </div>
<!-----1st row------->

<!-----2nd row------->
    <div class="row mt-2">
        <div class="col-sm">
              <table>
                <td>
                  <label class="text-dark" style="font-weight: bold;" > PROGRAM*</label>
                </td>
              </table>
              <select class="form-control border-secondary rounded input-sm" id="program_code" name="program_code" required>
              <option style="display: none;" value="<?php echo "$program_code"; ?>" > <?php echo "$program_code"; ?> </option>
              <?php  
              include 'admin_classes/config.php';
              $query = $connect->prepare("SELECT * FROM `manage_program`");
              $query->execute();
              $sub_insert = $query->fetchAll();
              foreach ($sub_insert as $account) {
              $program_code = $account['program_code'];

              print 
              "
                <tr>
                <option value='$program_code'> $program_code </option>
                </tr>
              ";
              }
              ?>
              </select>
        </div>  
    </div>

    <div class="row mt-2">
        <div class="col-sm">
              <table>
                <td>
                  <label class="text-dark" style="font-weight: bold;" > CURRICULUM*</label>
                </td>
              </table>
              <select class="form-control border-secondary rounded input-sm" id="curriculum" name="curriculum" required>
              <option style="display: none;" value="<?php echo "$curriculum"; ?>" > <?php echo "$curriculum"; ?> </option>
              <?php  
              include 'admin_classes/config.php';
              $query = $connect->prepare("SELECT * FROM `manage_curriculum` ");
              $query->execute();
              $sub_insert = $query->fetchAll();
              foreach ($sub_insert as $account) {
              $curriculum = $account['curriculum'];

              print 
              "
                <tr>
                <option value='$curriculum'> $curriculum </option>
                </tr>
              ";
              }
              ?>
              </select>
        </div>  
    </div>

    <div class="row mt-2">
        <div class="col-sm">
              <table>
                <td>
                  <label class="text-dark" style="font-weight: bold;" > STATUS*</label>
                </td>
              </table>
              <select class="form-control border-secondary rounded input-sm" id="status" name="status" required>
              <option style="display: none;" value=" <?php echo "$status"; ?> " > <?php echo "$status"; ?> </option>
              <option value="Regular"> Regular </option>
              <option value="Irregular"> Irregular </option>
              </select>
        </div>       
    </div>
<!-----2nd row------->


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

<?php 
       if (isset($_GET['updated'])) {
                echo "
                <div class='alert alert-success alert-block' role='alert' id='suc' style='position: fixed; width:100%; z-index:9999; left: 0px; top: 0px; text-align:center; border-radius:0px' >
                <strong>Data has been updated.</strong>
                </div>
                ";
              }
 ?>

        <script>
        $(document).ready(function() {
        $('#suc').fadeOut(4000);
            });
        </script> 




<!-----DATA TABLE SCRIPT------------------------------------------------------------------------------------------------------------>

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
<!-----DATA TABLE SCRIPT------------------------------------------------------------------------------------------------------------>








</body>
</html>
