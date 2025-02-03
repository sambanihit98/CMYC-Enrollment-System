<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_teacher.php";
?>

<!DOCTYPE html>
<html>


<head>
    <title> <?php include'bootstrap_lower/title_header.php'; ?> | Account Settings </title>

    <?php include "include/tab_icon.php"; ?>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <!-- FooTable -->
    <link href="css/plugins/footable/footable.core.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link rel='stylesheet' href='https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css'>  
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

                <li>
                    <a href="teacher_subject_schedule.php"><i class="fa fa-lg fa-calendar" aria-hidden="true"></i> <span class="nav-label"> Subject Schedule  </span></a>
                </li>

                <li class="active">
                    <a href="teacher_account_settings.php"><i class="fa fa-lg fa-cog" aria-hidden="true"></i> <span class="nav-label">Account Settings</span></a>
                </li> 

            </ul>
        </div>
    </nav>
    <!------SIDE NAV--------------------------------------------------------------------------------------------------------------->

    <!----HEADER-------------------------------------------------------------------------------------------------------------->
    <div id="page-wrapper" class="gray-bg">
    <?php include'bootstrap_lower/header.php';?>
    <!----HEADER-------------------------------------------------------------------------------------------------------------->

    <!------------------------------------------------------------------------------------------------------------------------>
    <!------------------------------------------------------------------------------------------------------------------------>
    <!---faculty_user_id--->
    <?php include "include/faculty_user_id.php"; ?>

    <!----COUNTER------------------------------------------------------------------------------------------------------------------->
    <div class="wrapper wrapper-content bg-white ">
        <div class="row">

        </div>
     <!----COUNTER---------------------------------------------------------------------------------------------------------------->


     <div class="container rounded bg-white mb-5">
              <div class="row">
                <div class="col-md-3 border-right">
                  <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"><span class="font-weight-bold"> <?php echo "$account_firstname $account_lastname"; ?> </span><span class="text-black-50"> <h5><small class='badge badge-primary'>Active</small></h5> </span><span> </span></div>
                </div>
                <div class="col-md-5 border-right">

                  <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <h4 class="text-right">Profile Settings</h4>
                    </div>

                    <div class="row mt-3">
                      <div class="col-md-6"><label class="labels">Account ID</label><input type="text" class="form-control" name="faculty_id" value="<?php echo($account_user_id) ?>" readonly></div>
                      <div class="col-md-6"><label class="labels">Account Type</label><input type="text" class="form-control"  value="<?php echo($account_position) ?>" readonly></div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-md-6">
                        <label class="labels">Firstname</label>
                        <input type="text" class="form-control border" id = 'firstname' value="<?php echo $account_firstname  ?>" disabled required>
                      </div>
                      <div class="col-md-6">
                        <label class="labels">Lastname</label>
                        <input type="text" class="form-control border" id = 'lastname' value="<?php echo $account_lastname  ?>" disabled required>
                      </div>
                    </div>

                    <div class="row mt-3">
                      <div class="col-md-12">
                        <label class="labels">Password</label>
                          <input type="password" class="form-control" id="password" name="password" value="<?php echo $account_password ?>" disabled required>
                      </div>
                      <div class="col-md-6 checkbox mt-3">
                        <label>
                          <small> <input type = "checkbox" onclick = "showPassword()"> Show Password </small>
                        </label>
                      </div>
                    </div>

                    <div style = 'text-align:center; font-weight:bold; color:red;' id = 'error_messages'></div>
                      
                    <div class ="mt-2" style = 'float:right;'>
                        <button onclick='edit()' class="btn btn-sm btn-primary profile-button" type="button" id = 'edit_btn'> Edit</button>
                        <button class="btn btn-sm btn-success profile-button" type="button" id = 'save_btn' hidden > Save</button>
                        <button onclick='cancel()' class="btn btn-sm btn-secondary profile-button" type="button" id = 'cancel_btn' hidden > Cancel</button>
                    </div>

                  </div>
                </div>

                  <div class="col-md-4">
                    <div class="p-3 py-5" style="text-align: justify;">
                      <h4>Terms of Service</h4>
                      <p> Welcome to CMYCES! <br><br>
                        CMYCES builds technologies and services that enable people to connect with each other, build communities, and grow businesses. These Terms govern your use of CMYCES and the other products, features, apps, services, technologies, and software we offer (the CMYCES Products or Products), except where we expressly state that separate terms (and not these) apply. These Products are provided to you by CMYCES, Inc. <br> <br>
                        Our Data Policy explains how we collect and use your personal data to determine some of the ads you see and provide all of the other services described below. You can also go to your settings at any time to review the privacy choices you have about how we use your data.
                      </p>
                  </div>

                </div>
              </div>
<!---------------------------------------------------------------------------------------------------------------------------------->

<?php include 'bootstrap_lower/lower.php'; ?>
</div>
      
    <!-- Mainly scripts -->
</body>
</html>



<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->
<!-- HIDDEN DATA -->

<input type = "text" value = "<?php echo $account_user_id ?>" id = "account_user_id" hidden>

<!---------------------------------------------------------------------------------------------------------------------------------->
    <!-- Show Password -->
    <script>
        function showPassword() {
            var x = document.getElementById("password");
                if (x.type === "password") {
                    x.type = "text";
                } else {
                    x.type = "password";
                }
            }
    </script>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->

<script>
  function edit() {
    document.getElementById("firstname").disabled = false;
    document.getElementById("lastname").disabled = false;
    document.getElementById("password").disabled = false;

    document.getElementById("cancel_btn").hidden = false;
    document.getElementById("save_btn").hidden = false;
  }
</script>

<script>
  function cancel() {
    document.getElementById("firstname").disabled = true;
    document.getElementById("lastname").disabled = true;
    document.getElementById("password").disabled = true;

    document.getElementById("cancel_btn").hidden = true;
    document.getElementById("save_btn").hidden = true;

    document.getElementById("error_messages").style.display = "none";
  }
</script>

<script>
  $(document).ready(function(){

    $('#error_messages').hide();

    $('#save_btn').click(function(){

      var faculty_user_id = $('#account_user_id').val();
      var firstname       = $('#firstname').val();
      var lastname        = $('#lastname').val();
      var password        = $('#password').val();
      var account_user_id = $('#account_user_id').val();

      if(firstname == "" || lastname == "" || password == ""){
        $('#error_messages').show();
        $('#error_messages').html('Invalid attempt! Please try again!');
        $('#error_messages').effect('shake');

      }else if(password.length < 5){
        $('#error_messages').show();
        $('#error_messages').html('Password is too short!');
        $('#error_messages').effect('shake');
      }else{
        $.ajax({
            url: "admin_classes/update_account_settings.php",
            type: "POST",
            data: {
              faculty_user_id :faculty_user_id,
              firstname       :firstname,
              lastname        :lastname,
              password        :password,
              account_user_id :account_user_id,
              },
            cache: false,
            success: function(dataResult){
              var dataResult = JSON.parse(dataResult);

              if(dataResult.statusCode==200){
                window.location = "teacher_account_settings.php?updated"						 
              }else if(dataResult.statusCode==201){
                  
                $("#error_messages").show();  
                $('#error_messages').html('Update Failed!'); 
                $('#error_messages').effect("shake");                                  
              }   
            }
          });
      }

    });
  });
</script>
