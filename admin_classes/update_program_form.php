<?php

include 'config_mysqli.php';

if(isset($_POST['program_id'])){

    $program_id = $_POST['program_id'];

   $query = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id'");
        while ($row = mysqli_fetch_array($query)){
            $program_code = $row['program_code'];
            $program_description = $row['program_description'];
            $department_id = $row['department_id'];
            //$department_id = $row['department_id'];
                    $response = "

                        <div class='row'>
                            <div class='col-lg-12'>
                                <table>
                                    <td>
                                        <label class='text-dark' style='font-weight: bold;' > DEPARTMENT</label>
                                    </td>
                                </table>
                    ";

                  

                        $query_department = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
                            while($row_department = mysqli_fetch_array($query_department)){
                                $department_code = ucwords($row_department['department_code']);
                                $department_description = ucwords($row_department['department_description']);
                         
                                $department = $department_description." "."("."$department_code".")";

                    $response .= "<input type='text' id='' value = '$department'  class='form-control border border-secondary rounded input-sm' disabled = 'disbaled'>"; 
                       
                            }   
                         
                                           
                                        
                    $response .= "
                                </select>
                            </div>
                        </div>
                        <br>

                        <div class = 'row'>                    
                            <div class = 'col-lg-12'>
                                <label class='text-dark' style='font-weight: bold;'>PROGRAM CODE</label>
                                <input type = 'text' class = 'form-control' id = 'program_code_update' name = 'program_code' value = '$program_code'>
                            </div>
                        </div>
                        <br>
                        <div class = 'row'>                    
                            <div class = 'col-lg-12'>
                                <label class='text-dark' style='font-weight: bold;'>DESCRIPTION</label>
                                <input type = 'text' class = 'form-control' id = 'program_description_update' name = 'program_description' value = '$program_description'>
                            </div>               
                        </div>
                        <br>    
                    ";

                    $response .= "<input type = 'text' id = 'program_id_hid' value = '$program_id' hidden>";
                    $response .= "<input type = 'text' id = 'program_code_hid' value = '$program_code' hidden>";
                    $response .= "<input type = 'text' id = 'program_description_hid' value = '$program_description' hidden>";

                    $response .= "<input type = 'text' id = 'department_id_hid' value = '$department_id' hidden>";
            
        }
        
    echo $response;
    exit;
    
}



?>