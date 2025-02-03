	
    <!-------ADMIN CACHE---->


		<?php 

    include 'config.php';

	   $acc_user_id = $_GET['acc_user_id'];


    $query = $connect->prepare("DELETE FROM `faculty_account` WHERE acc_user_id = :acc_user_id");

      $query->bindParam('acc_user_id',$acc_user_id);
      $query->execute();

     if($query){
     	 header("location:../admin_designation.php");
     	 
     }


 	?>



    <!-------ADMIN CACHE---->