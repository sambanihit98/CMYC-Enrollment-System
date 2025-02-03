<?php

include 'config_mysqli.php';

    $user_log_date = $_POST['user_log_date'];

    $query_date = mysqli_query($con, "SELECT * FROM user_log WHERE user_log_date = '$user_log_date'");

    if(mysqli_num_rows($query_date)>0){

        print "
        <table class='table table-striped'>
            <thead class='bg-success text-center'>
            <th> ID NUMBER </td>
            <th> FULLNAME </td>
            <th> ACTION DESCRIPTION</td>
            <th> TIME </td>
            <th> DATE </td>
            </thead>

            <tbody class='text text-dark'>";

            $query = mysqli_query($con, "SELECT * FROM user_log JOIN faculty_account
            ON user_log.account_user_id = faculty_account.account_user_id WHERE user_log.user_log_date = '$user_log_date'
            ORDER BY user_log.user_log_id DESC");

            while($row = mysqli_fetch_array($query)){
                //user log
                $user_log_id      = $row['user_log_id'];
                $user_action      = $row['user_action'];
                $user_log_time    = $row['user_log_time']; 
                $user_log_date    = $row['user_log_date']; 

                $time1 = strtotime($user_log_time);
                $time2 = date("h:i:s a", $time1);

                $date1 = strtotime($user_log_date);
                $date2 = date("M. j, Y", $date1);

                //faculty account
                $account_user_id    = $row['account_user_id']; 
                $account_firstname  = $row['account_firstname'];
                $account_lastname   = $row['account_lastname'];
                $account_position   = $row['account_position'];

                print("

                    <tr>
                        <td style='text-align: center; width:100px;'>$account_user_id</td>
                        <td style='text-align: center;'>$account_firstname $account_lastname (<b>$account_position</b>)</td>
                        <td >$user_action</td>
                        <td style='text-align: center; width:100px;'>$time2</td>  
                        <td style='text-align: center; width:100px;'>$date2</td>                             
                    </tr>"); 
            }

        print "</tbody> </table>";
       
    }else{
        echo "<h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>";
    }

    
    
?>