	
    <!-------ADMIN CACHE---->


	<?php 

	$item_id = $_REQUEST['item_id'];
    $acc_user_id = $_REQUEST['acc_user_id'];


	include 'config.php';

    $query = $connect->prepare("UPDATE `teacher_subject_load` SET `load_stat`= 1 WHERE item_id = :item_id ");

    $query->bindParam('item_id',$item_id);
    $query->execute();

    if($query){
     	 header("location:../registrar_scheduler_load.php?acc_user_id=$acc_user_id");
     	 
     }

 	?>



    <!-------ADMIN CACHE---->