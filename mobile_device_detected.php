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

  </head>

  <style type="text/css">
    
    body { background-color:#f3f3ff; }

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
    
      #body{ 
				background-color:#f3f3ff;
				background-image: url('img/background_image.jpg');
				background-repeat: no-repeat; 
			}
			
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

</style>

<body id = "body">

		<div class="text-center">
		
    </div>

		<div class="row h-100 text-center">
			<div class="col-sm-12 my-auto">
			
					<img src = 'img/warning.png' style = 'width:150px; '>
					<h3>This website is not available on mobile devices.</h3>
			
			</div>
		</div>



</body>
</html>
