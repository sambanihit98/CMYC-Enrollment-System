

<!DOCTYPE html>
<html>
<head>
    <title> <?php include'../bootstrap_lower/title_header.php'; ?> | Curriculum </title>
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

<!---------HERE----->

    <li>
      <a href="../registrar_manage_curriculum.php"><i class="fa fa-lg fa-arrow-circle-left" aria-hidden="true"></i> <span class="nav-label"> <span class="nav-label">Back</span></a>
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
         <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Update Curriculum </p>

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
    <td class="bg-success text-center"> <strong> : : : UPDATE CURRICULUM : : : </strong> </td>
  </tr>
</table>


<!--------HERE-------->

<!--------UPDATE------->
<div class="container mt-4">
  <div class="row">

    <div class="col text-center">
      <h2> Catholic Ming Yuan College </h2>
      <img src="../img/3.jpg" style="width: 500px;">
    </div>

<!---devider-->

<?php 
include '../admin_classes/config.php';
$item_id = $_GET['item_id'];
$query = $connect->prepare("SELECT * FROM `manage_curriculum` WHERE item_id ='$item_id'");
$query->execute();

$sub_insert = $query->fetchAll();

foreach ($sub_insert as $account) {
$item_id = $account['item_id'];
$num_que = $account['num_que'];  
$curriculum = $account['curriculum']; 
$program_code = $account['program_code'];

}
?>


<div class="col">
<form method="post" action="../admin_classes/update_curriculum.php" >

            <input type="hidden" id="item_id" name="item_id" value="<?php echo($item_id) ?>">


<!---FILL UP------------------------------------------------------------------------------------------------------------------->
<!-----1st row------->
    <div class="row mt-2">
        <div class="col-sm">
              <table>
                <td>
                  <label class="text-dark" style="font-weight: bold;" > CURRICULUM*</label>
                </td>
              </table>
              <input type="text" class="form-control border border-secondary rounded input-sm" name="curriculum" value="<?php echo($curriculum) ?>">
        </div>
    </div>

    <div class="row mt-2">
        <div class="col-sm">
              <table>
                <td>
                  <label class="text-dark" style="font-weight: bold;" > PROGRAM CODE*</label>
                </td>
              </table>
              <select class="form-control border-secondary rounded input-sm" disabled="">
              <option value="<?php echo($program_code) ?>"> <?php echo "$program_code"; ?> </option>
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
<!-----1st row------->
<!---FILL UP------------------------------------------------------------------------------------------------------------------->


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
