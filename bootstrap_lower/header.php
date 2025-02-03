

<div class="row border-bottom">
<nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
<div class="navbar-header">



</div>
<ul class="nav navbar-top-links navbar-right">
    <li>

      <?php 

        include 'admin_classes/config_mysqli.php';

        //<!---------------------------------------------------------------------------------------------------------------------------->
        //<!---------------------------------------------------------------------------------------------------------------------------->

          if(isset($_SESSION['system_admin_user_id'])){

            $system_admin_user_id =  $_SESSION['system_admin_user_id'];
            $query = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_user_id = '$system_admin_user_id'");
            while($row = mysqli_fetch_array($query)){
              $account_user_id = $row['account_user_id'];
              $account_firstname = $row['account_firstname'];
              $account_lastname = $row['account_lastname'];
              $account_position = $row['account_position'];
              $account_password = $row['account_password'];

              print "<p class='mt-3' style='font-weight: bold;' >Welcome, $account_firstname  $account_lastname |</p>";
            }

        //<!---------------------------------------------------------------------------------------------------------------------------->
        //<!---------------------------------------------------------------------------------------------------------------------------->

          }else if(isset($_SESSION['teacher_user_id'])){
            $teacher_user_id =  $_SESSION['teacher_user_id'];
            $query = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_user_id = '$teacher_user_id'");
            while($row = mysqli_fetch_array($query)){
              $account_user_id = $row['account_user_id'];
              $account_firstname = $row['account_firstname'];
              $account_lastname = $row['account_lastname'];
              $account_position = $row['account_position'];
              $account_password = $row['account_password'];

              print "<p class='mt-3' style='font-weight: bold;' >Welcome, $account_firstname  $account_lastname |</p>";
            }

        //<!---------------------------------------------------------------------------------------------------------------------------->
        //<!---------------------------------------------------------------------------------------------------------------------------->

          }else if(isset($_SESSION['registrar_user_id'])){
            $registrar_user_id =  $_SESSION['registrar_user_id'];
            $query = mysqli_query($con, "SELECT * FROM faculty_account WHERE account_user_id = '$registrar_user_id'");
            while($row = mysqli_fetch_array($query)){
              $account_user_id   = $row['account_user_id'];
              $account_firstname = $row['account_firstname'];
              $account_lastname  = $row['account_lastname'];
              $account_position  = $row['account_position'];
              $account_password  = $row['account_password'];

              print "<p class='mt-3' style='font-weight: bold;' >Welcome, $account_firstname  $account_lastname |</p>";
            }
          }

        //<!---------------------------------------------------------------------------------------------------------------------------->
        //<!---------------------------------------------------------------------------------------------------------------------------->
      ?>
        
    </li>

    <li>
        <a href="bootstrap_lower/log_out.php">
            <i class="fa fa-sign-out"></i> Log-out
        </a>
    </li>             
</ul>

</nav>
</div>