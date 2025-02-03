<!-- CREDIT SUBJECT -->

        <!-- Modal -->
        <div class="modal fade" id="credit_subject" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">Subject List</4>
              </div>
              <div class="modal-body">
                
                <!---------------------------------------------------------------------------------------------------------------------------->
                <!---------------------------------------------------------------------------------------------------------------------------->
                <form action = "admin_classes/insert_student_credit_subject.php" method = "POST">

                <!-- HIDDEN DATA -->

                <?php
                  if(isset($_GET['enrollment_id'])){
                    $enrollment_id = $_GET['enrollment_id'];

                    //enrollment_ id
                    print "<input type = 'text' name = 'enrollment_id' value = '$enrollment_id' id = 'enrollment_id' hidden>";
                  }

                ?>

                <!------------------------------------------------------------------------------------------------------------------------>
                <!------------------------------------------------------------------------------------------------------------------------>
                <!---faculty_user_id--->
                <?php include "faculty_user_id.php"; ?>

                <table class = "table table-sm">
                    <tr style = 'background-color:#fef6c5;'><td><b>Subjects currently taking</b></td></tr>
                    <tr style = 'background-color:#a3e7d6;'><td><b>Subjects passed or credited</b></td></tr>
                </table>
                <br>
                <table class = "table table-sm">
                  <thead class="bg-success text-center">
                    
                      <th>Subject Code</th>
                      <th>Subject Description</th>
                      <th>Units</th>
                      <th>Select</th>
                    
                  </thead>

                    

                  
                    <tbody class = 'text-center'>

                    <tr>
                      <td><button type="button" class="btn btn-outline-primary"><b>1st Year (1st Semester)</b></button></td>
                    </tr>

                      <?php
                        // 1st year 1st semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 1 AND subject_semester = '1st Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];


                          $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");
                            
                            $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                            while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                              $student_id = $row_enrollment['student_id'];

                              //checks the grades if students is passed
                              $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                                AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                            }
                          
                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";
                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";
                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>1st Year (2nd Semester)</b></button></td>
                    </tr>

                      <?php
                        // 1st year 2nd semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 1 AND subject_semester = '2nd Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                           $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";
                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>2nd Year (1st Semester)</b></button></td>
                    </tr>

                      <?php
                        // 2nd year 1st semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 2 AND subject_semester = '1st Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                          $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>2nd Year (2nd Semester)</b></button></td>
                    </tr>

                      <?php
                        // 2nd year 2nd semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 2 AND subject_semester = '2nd Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                           $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>3rd Year (1st Semester)</b></button></td>
                    </tr>

                      <?php
                        // 3rd year 1st semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 3 AND subject_semester = '1st Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                          $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";
                            
                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>3rd Year (2nd Semester)</b></button></td>
                    </tr>

                      <?php
                        // 3rd year 2nd semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 3 AND subject_semester = '2nd Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                          $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";
                            
                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>4th Year (1st Semester)</b></button></td>
                    </tr>

                      <?php
                        // 4th year 1st semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 4 AND subject_semester = '1st Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                          $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    <tr style = 'border: 1px solid Transparent;'>
                      <td ><button type="button" class="btn btn-outline-primary"><b>4th Year (2nd Semester)</b></button></td>
                    </tr>

                      <?php
                        // 4th year 2nd semester
                        include 'admin_classes/config_mysqli.php';

                        $enrollment_id = $_GET['enrollment_id'];

                        $query = mysqli_query($con, "SELECT * FROM manage_subject WHERE subject_year_level = 4 AND subject_semester = '2nd Semester' AND curriculum_id = '$curriculum_id' AND subject_status = 1");
                        while($row = mysqli_fetch_array($query)){
                          $subject_id          = $row['subject_id'];                        
                          $subject_code        = $row['subject_code'];
                          $subject_description = $row['subject_description'];
                          $subject_unit        = $row['subject_unit'];

                          $query_student_load = mysqli_query($con, "SELECT * FROM student_subject_load WHERE subject_id = $subject_id
                                                                    AND enrollment_id = '$enrollment_id'");

                          $query_enrollment = mysqli_query($con, "SELECT * FROM manage_enrollment WHERE enrollment_id = '$enrollment_id'");
                          while($row_enrollment = mysqli_fetch_array($query_enrollment)){
                            $student_id = $row_enrollment['student_id'];

                            //checks the grades if students is passed
                            $query_grades_report = mysqli_query($con, "SELECT * FROM grades_report WHERE subject_id = $subject_id
                              AND student_id = '$student_id' AND (remarks = 'PASSED' OR remarks = 'CREDITED')");
                          }

                          if(mysqli_num_rows($query_student_load)>0){

                            print "
                            <tr class = 'text-center' style = 'background-color:#fef6c5;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";

                          }else if(mysqli_num_rows($query_grades_report)>0){                                      

                            print "
                            <tr class = 'text-center' style = 'background-color:#a3e7d6;'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id' disabled>
                                </div>
                              </td>
                            </tr>
                            ";
                            
                          }else{                                      

                            print "
                            <tr class = 'text-center'>
                              <td>$subject_code</td>
                              <td>$subject_description</td>
                              <td >$subject_unit</td>
                              <td> 
                                <div class='form-check'>
                                  <input class='form-check-input checkbox_value' name = 'checkbox_value[]' type='checkbox' value='$subject_id'>
                                </div>
                              </td>
                            </tr>
                            ";
                          }

                        }
                      ?>

                    </tbody>

                </table>

              </div>
              
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name = "save_subject" class="btn btn-primary" id = 'save_btn'>Save</button>
              </div>

              </form>
              <!---------------------------------------------------------------------------------------------------------------------------->
              <!---------------------------------------------------------------------------------------------------------------------------->

            </div>
          </div>
        </div>

        <!-- END OF CREDIT SUBJECT -->
        <!---------------------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------------------------------------------------------------------------------->
        <!---------------------------------------------------------------------------------------------------------------------------->