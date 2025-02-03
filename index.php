<!DOCTYPE html>
  <html>

  <head>

      <!--<meta charset="utf-8">-->

      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Login </title>

      <?php include "include/tab_icon.php"; ?>

      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

      <link href="css/animate.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"> </script>

      
        <?php
            function isMobileDevice() {
                return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo
            |fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i"
            , $_SERVER["HTTP_USER_AGENT"]);
            }
            if(isMobileDevice()){
                header("location:mobile_device_detected.php");
            }
        
        ?>

  </head>

  <style type="text/css">
    
    body { background-color: black; }

    section{
        height: 100vh;
        display: flex;
        align-items: center;
    }

    #main {
        margin: auto;
        width: 30%;
        height: 70vh;
        display: flex;
        align-items: center;
        background-color: rgba(255, 255, 255, 0.3);
        position: relative;
        border-radius: 5px;

        -webkit-box-shadow: 7px 17px 24px -5px rgba(0,0,0,0.75);
        -moz-box-shadow: 7px 17px 24px -5px rgba(0,0,0,0.75);
        box-shadow: 7px 17px 24px -5px rgba(0,0,0,0.75);
    }

    .row{
        margin: auto;
        display: flex;
        align-items: center;
    }

    #login_form, #logo{
        -webkit-box-shadow: 7px 17px 24px -5px rgba(0,0,0,0.75);
        -moz-box-shadow: 7px 17px 24px -5px rgba(0,0,0,0.75);
        box-shadow: 7px 17px 24px -5px rgba(0,0,0,0.75);
    }

    /*----------------------------------------------------*/
    /*----------------------------------------------------*/
    /* mobile view */

    @media only screen and (max-width: 768px) {
    
      #body{ background-color: black; }
      #logo{ display: none; }

      #main{
          width: 70%;
          height: 80vh;
      }

      #login_form{
          height: 70vh;
      }
      
    }
    /*----------------------------------------------------*/
    /*----------------------------------------------------*/

</style>

<body id = "body">


    <img src="img/2.jpg" id = "bg" style = " position: fixed;
        background-size: cover;
        width: 100vw;
        height: 100vh;
        opacity: 35%;">
    
    <div class = "container-fluid">
        <div class = "topnav" style = "padding-top:10px; position: fixed;" >
            <img class="rounded-circle img-fluid img-responsive" id = "logo" src = "img/cmycis logo.png" style = "position:relative; width:100px;">              
        </div>
    </div>

    <section>
        <div class = "container" id = "main" >
            <div class="col-md-12">

                <div class="ibox-content" style = "border-radius:5px;" id = "login_form">
                    <div class = "container"  style = "text-align:center;" >
                        <img class="rounded-circle img-fluid img-responsive" src = "img/m_logo.jpg" style = "width:60px; " id = "avatar">
                    </div>

                        <div class="form-group">
                            <select class="form-control" placeholder = "Select User" id="account_position" name="account_position">
                                <option value="" disabled selected hidden>Select User</option>                             
                                <option value="System Admin">System Admin</option>
                                <option value="Teacher">Teacher</option>
                                <option value="Registrar">Registrar</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <input type="text" class="form-control" placeholder = " User ID" name="account_user_id" id="account_user_id">
                        </div>

                        <div class="form-group">
                            <input type = "password" class="form-control" placeholder = " Password" name="account_password" id="account_password" >
                        </div>

                        <button type = "button" class="btn btn-success block full-width m-b" id="login_btn">Login</button>

                        <div id = "error" style = "text-align:center; color:red; font-weight:bold;"></div><br>

                        <div class = "row">
                            <div class="col-md-6 checkbox">
                                <label>
                                    <small> <input type = "checkbox" onclick = "showPassword()"> Show Password </small>
                                </label>
                            </div>
                        </div>
                 

                    <p class="m-t" style = "text-align: center;">
                         <small >Catcholic Ming Yuan College Enrollment System</small> 
                    </p>

                </div>
            </div>
        </div>
    </section>  

<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script> <!--shake effect on error -->

<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->
<!---UNAUTHORIZED SESSION--->

<?php             
  if(isset($_GET['unauthorized'])){
    print "
      <script>
        $(document).ready(function(){
          $('#error').show();  
          $('#error').html('Unauthorized Session! You have been logged out!'); 
          $('#error').effect('shake');        
        });
      </script>
    ";                  
  }
?>

<!--------------------------------------------------------------------------------------------------------------------->
<!--------------------------------------------------------------------------------------------------------------------->

<script>
  $(document).ready(function(){
              
    $('#login_btn').click(function(){

       var account_position = $('#account_position').val();
       var account_user_id = $('#account_user_id').val();
       var account_password = $('#account_password').val();

       if(account_position == "" || account_user_id == "" || account_password == ""){
        $('#error').show();
        $('#error').html("Invalid Attempt! Please fill up the form.");
        $('#error').effect('shake');

       }else{
        
          $.ajax({
              url: "admin_classes/check_user_login.php",
              type: "POST",
              data: {

                  account_position: account_position,
                  account_user_id: account_user_id,
                  account_password: account_password
              },
              cache: false,
              success: function(dataResult){
                  var dataResult = JSON.parse(dataResult);


                  if(dataResult.statusCode==204){
                      $('#error').show();  
                      $('#error').html("Your account has been deactivated!"); 
                      $('#error').effect("shake");

									}else if(dataResult.statusCode==205){

											$('#error').show();  
                      $('#error').html("Your account has been archived!"); 
                      $('#error').effect("shake");

                  }else if(dataResult.statusCode==200){

                      $('#error').show();  
                      $('#error').html("User ID or Password is incorrect!"); 
                      $('#error').effect("shake");  

                  }else if(dataResult.statusCode==201){
                      window.location = "admin_dashboard.php";

                  }else if(dataResult.statusCode==202){
                      window.location = "teacher_dashboard.php";	

                  }else if(dataResult.statusCode==203){
                      window.location = "registrar_dashboard.php";

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
        var x = document.getElementById("account_password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
</script>

</body>
</html>
