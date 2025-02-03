<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_teacher.php";
?>

<!DOCTYPE html>
  <html>

  <head>
    <?php include 'bootstrap_lower/boots.php'; ?>
    <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Home</title>

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

            <li class="active">
                <a href="teacher_dashboard.php"><i class="fa fa-lg fa-home" aria-hidden="true"></i> <span class="nav-label">Home</span></a>
            </li>

            <li>
                <a href="teacher_encode.php"><i class="fa fa-lg fa-book" aria-hidden="true"></i> <span class="nav-label">Grade Encoding</span></a>
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

      <!--------------------------------------------------------------------------------------------------------------------->
      <!--------------------------------------------------------------------------------------------------------------------->

      <div class="modal fade" id="change_pass" data-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Change your Password</h5>
              
            </div>
            <div class="modal-body">
              <h3 style = "text-align:center; font-weight:bold;"><i class="fa fa-key"></i> Change your password</h3><hr>

                <div class = 'row mt-4'>
                  <div class = 'col-md-12'>
                    <label>New Password</label>
                    <input type="password" class="form-control border border-secondary rounded input-sm " id="new_password" >
                  </div>
                </div>

                <div class = 'row mt-4'>
                  <div class = 'col-md-12'>
                    <label>Confirm Password</label>
                    <input type="password" class="form-control border border-secondary rounded input-sm " id="confirm_password" >
                  </div>
                </div>

                <div class = "row mt-4">
                  <div class="col-md-12 checkbox">
                    <label>
                      <small> <input type = "checkbox" onclick = "showPassword()"> Show Password </small>
                    </label>
                  </div>
                </div>

                <div style = 'color: red; font-weight: bold; text-align:center;' id = 'error_messages'></div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-success" id = 'save_btn'>Save</button>
            </div>
          </div>
        </div>
      </div>

      <!--------------------------------------------------------------------------------------------------------------------->
      <!--------------------------------------------------------------------------------------------------------------------->

      <!----HEADER-------->
      <div id="page-wrapper" class="gray-bg">
        <?php include 'bootstrap_lower/header.php';?>
  
        <!----COUNTER--------->
        <div class="wrapper wrapper-content bg-white ">
          <div class="row">
          </div>

          <!----UNDER COUNTER ------>
          <div class="row">

            <div class="col-lg-11 mx-auto">
              <div class="ibox">
                <div class="ibox-title bg-success text-center">
                  <h5> : : : MY PERSONAL PAGE : : : </h5>
                <div class="ibox-tools">
                <div class="btn-group">
                    <!--ORDERS RIGHT UPPER BBUTTONS-->
                </div>
              </div>
            </div>

            <div class="ibox-content text-dark">
                <!--BLANKO NGA UNOD KA ORDERSS-->
                <h4 class="text-center"><strong>Welcome, <?php echo "$account_firstname $account_lastname";  ?> to your personal page!</strong></h4><br><br>
                <p style="text-align: justify;">Please note that every activity is monitored closely. For any problem in the system, contact System Administrator for details. Click the links under MENU to select operation. It is recommended to logout by clicking the logout button everytime you leave your PC.</p>
                <p>If you do not agree with the conditions or you are not <strong><?php echo "$account_firstname";  ?></strong> please logout.</p>
            </div>

          </div>
        </div>
      </div>

    </div>
    <?php include 'bootstrap_lower/lower.php'; ?>

</body>
</html>

<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!--shake effect on error -->

<?php
  include 'admin_classes/config_mysqli.php';
    if($account_password == 'cmyces'){
      print"
        <script>
        $(document).ready(function(){
          $('#change_pass').modal('show');
        });
      </script>";
    }
?>

<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->
<!---HIDDEN DATA----->
<input type = 'text' value = '<?php echo $account_position; ?>' id = 'account_position' hidden >
<input type = 'text' value = '<?php echo $account_user_id; ?>' id = 'account_user_id' hidden >

<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->

<script>
  $(document).ready(function(){
    $('#error_messages').hide();

    $('#save_btn').click(function(){
      var new_password     = $('#new_password').val();
      var confirm_password = $('#confirm_password').val();
      var account_position = $('#account_position').val();
      var account_user_id  = $('#account_user_id').val();

      if(new_password == "" || confirm_password == ""){
        $('#error_messages').show();
        $('#error_messages').html('Invalid Attempt! Please fill up the form!');
        $('#error_messages').effect('shake');

      }else if(new_password != confirm_password){
        $('#error_messages').show();
        $('#error_messages').html('Password does not match!');
        $('#error_messages').effect('shake');

      }else if(new_password == "cmyces" && confirm_password == "cmyces"){
        $('#error_messages').show();
        $('#error_messages').html('Please change your default password!');
        $('#error_messages').effect('shake');

      }else if(new_password.length < 5){
        $('#error_messages').show();
        $('#error_messages').html('Password is too short!');
        $('#error_messages').effect('shake');
      }else{
        $.ajax({
            url: "admin_classes/change_default_password.php",
            type: "POST",
            data: {
              new_password      :new_password,
              confirm_password  :confirm_password,
              account_position  :account_position,
              account_user_id   :account_user_id
              },
            cache: false,
            success: function(dataResult){
              var dataResult = JSON.parse(dataResult);

              if(dataResult.statusCode==200){
                window.location = "teacher_dashboard.php?password_changed"						 
              }else if(dataResult.statusCode==201){
                  
                $("#error_messages").show();  
                $('#error_messages').html('Changing password failed!'); 
                $('#error_messages').effect("shake");                                  
              }   
            }
          });
      }
    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!-- Show Password -->

<script>
  function showPassword() {
    var x = document.getElementById('new_password');
    var c = document.getElementById('confirm_password');
    
      if (x.type === "password" && c.type) {
          x.type = "text";
          c.type = "text";
      } else {
          x.type = "password";
          c.type = "password";
      }
    }
</script>