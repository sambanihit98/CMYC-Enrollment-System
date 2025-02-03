<?php

include 'config_mysqli.php';

if(isset($_POST['curriculum_id'])){

    $curriculum_id = $_POST['curriculum_id'];

   $query = mysqli_query($con, "SELECT * FROM manage_curriculum WHERE curriculum_id = '$curriculum_id'");
        while ($row = mysqli_fetch_array($query)){
            $program_id_old = $row['program_id'];
            $department_id = $row['department_id'];
            $curriculum_year = $row['curriculum_year'];
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

                        //fetch the department name (readonly)
                        $query_department = mysqli_query($con, "SELECT * FROM manage_department WHERE department_id = '$department_id'");
                            while($row_department = mysqli_fetch_array($query_department)){
                                $department_code = ucwords($row_department['department_code']);
                                $department_description = ucwords($row_department['department_description']);
                         
                                $department = $department_description." "."("."$department_code".")";

                    $response .= "<input type='text' id='' value = '$department'  class='form-control border border-secondary rounded input-sm' disabled = 'disbaled'>"; 
                       
                            }   
        
                    $response .= "
                                
                            </div>
                        </div>
                        <br>

                        <div class='row mt-2'>
                            <div class='col-md'>
                                <div class = 'row'>
                                  <div class='col-md-6'>
                                  <label class='text-dark' style='font-weight: bold; float:left;'> PROGRAM CODE</label>

                                      <select class='form-control border-secondary rounded input-sm' id ='program_id_new'>
                    ";
                                        //fetch the current program code on select tag
                                        $query_program_code = mysqli_query($con, "SELECT * FROM manage_program WHERE program_id = '$program_id_old'");
                                        while($row_program_code = mysqli_fetch_array($query_program_code)){
                                            $program_code = $row_program_code['program_code'];

                    $response .=            "<option value = '$program_id_old' hidden>$program_code</option>";

                                        }
                                        
                                            //fetch all the available program unders specific department
                                            $query_program = mysqli_query($con, "SELECT * FROM manage_program WHERE department_id = '$department_id' AND program_status = 1");
                                            while($row_program = mysqli_fetch_array($query_program)){
                                                $program_id = $row_program['program_id'];
                                                $program_code = $row_program['program_code'];
                                                $program_description = $row_program['program_description'];

                                                    
                                                  
                    $response .=            "<option value = '$program_id'> $program_code </option>  ";

                                                    
                                            }
                                            
                    $response .= "                        
                                      </select>    
 
                                  </div>
                                  <div class='col-md-6'>
                                  <label class='text-dark' style='font-weight: bold; float:left;' > YEAR</label>
                                      <input type='number' id='curriculum_year_new' name='curriculum_year_new' value = '$curriculum_year' class='form-control border border-secondary rounded input-sm' >                           
                                  </div>

                                </div>
                            </div>
                          </div> 
                    ";

                    $response .= "<input type = 'text' id = 'curriculum_id_hid' value = '$curriculum_id' hidden>";
                    $response .= "<input type = 'text' id = 'program_id_old' value = '$program_id_old' hidden>";
                    $response .= "<input type = 'text' id = 'department_id_hid' value = '$department_id' hidden>";
                    $response .= "<input type = 'text' id = 'curriculum_year_old' value = '$curriculum_year' hidden>";
            
        }
        
    echo $response;
    exit;
    
}



?>