<?php
  session_start();
  include 'admin_classes/config_mysqli.php';
  include "admin_classes/unauthorized_system_admin.php";
?>

<!DOCTYPE html>

  <html>

    <head>
        <?php include'bootstrap_lower/boots.php'; ?>
        <title> <?php include 'bootstrap_lower/title_header.php'; ?> | Academic</title>

        <?php include "include/tab_icon.php"; ?>
        
        <style>
          /*HIDES ARROWS ON NUMBER TYPE IN INPUT FIELDS */
          /* Chrome, Safari, Edge, Opera */
          input::-webkit-outer-spin-button,
          input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
          }
          /* Firefox */
          input[type=number] {
            -moz-appearance: textfield;
          }
        </style>
        
    </head>

    <body>
      <div id="wrapper">

        <!-- SIDE NAV -->
        <nav class="navbar-default navbar-static-side" role="navigation">
          <div class="sidebar-collapse">
            <ul class="nav metismenu" id="side-menu">

              <li class="nav-header">
                <?php include 'bootstrap_lower/side_name_logo.php'; ?>   
              </li>

              <li>
                <a href="admin_dashboard.php"><i class="fa fa-lg fa-home" aria-hidden="true"></i> <span class="nav-label">Home</span></a>
              </li>

              <li>
                <a href="admin_data_dashboard.php"><i class="fa fa-lg fa-bar-chart" aria-hidden="true"></i> <span class="nav-label">Data Dashboard</span></a>
              </li>

              <li>
                <a href="admin_academic.php"><i class="fa fa-lg fa-graduation-cap" aria-hidden="true"></i> <span class="nav-label">Academic Year</span></a>
              </li>

              <li>
                <a href="admin_designation.php"><i class="fa fa-lg fa-user-plus" aria-hidden="true"></i> <span class="nav-label">Designation</span></a>
              </li> 

              <li>
                <a href="admin_user_log.php"><i class="fa fa-lg fa-list"></i> <span class="nav-label"> User Log</span></a>
              </li>

              <li  class="active">
                <a href="admin_announcements.php"><i class="fa fa-bullhorn"></i> <span class="nav-label">Announcements</span></a>
              </li>

              <li>
                <a href="admin_account_settings.php"><i class="fa fa-lg fa-cog" aria-hidden="true"></i> <span class="nav-label">Account Settings</span></a>
              </li>

            </ul>
          </div>
        </nav>

        <!--------------------------------------------------------------------------------------------------------------------->
        <!--------------------------------------------------------------------------------------------------------------------->
        <!--- HEADER -->

        <div id="page-wrapper" class="gray-bg">
          <?php include 'bootstrap_lower/header.php';?>

            <!----UNDER HEADER------->
            <div class="row wrapper border-bottom white-bg page-heading" style="height: 70px;">
              <div class="col-lg-10">
                <p style="font-size: 30px; margin-top: 12px; font-family: 'Nunito';"> Announcements </p>
              </div>
            </div>

            <!------------------------------------------------------------------------------------------------------------------------>
            <!------------------------------------------------------------------------------------------------------------------------>

            <!---faculty_user_id--->
            <?php include "include/faculty_user_id.php"; ?>

            <!--------------------------------------------------------------------------------------------------------------------->
            <!--------------------------------------------------------------------------------------------------------------------->
            <!--- ARCHIVED POSTS --->
            <div class="modal fade" id="archived_posts" tabindex="-1" role="dialog"  aria-hidden="true">
              <div class="modal-dialog modal-lg" >
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"> Archived Posts </h5>
                  </div>

                    <div class="modal-body">
                      <?php
                        include 'admin_classes/config_mysqli.php';

                        $query = mysqli_query($con, "SELECT * FROM announcements WHERE announcement_status = 2
                          ORDER BY date_posted DESC, time_posted DESC");

                          if (mysqli_num_rows($query) > 0){

                            while($row = mysqli_fetch_array($query)){
                              $announcement_id       = $row['announcement_id'];
                              $announcement          = $row['announcement'];
                              $date_posted           = $row['date_posted'];
                              $time_posted           = $row['time_posted'];
                              $announcement_status   = $row['announcement_status'];
                              $link                  = $row['link'];
                            
                              $time1 = strtotime($time_posted);
                              $time2 = date("h:i:sa", $time1);
  
                              $date1 = strtotime($date_posted);
                              $date2 = date("M. j, Y", $date1);
  
  
                              print "
                                <div class='card bg-light' 
                                  style = 'width: 90%; 
                                          margin-right:auto; 
                                          margin-left:auto; 
                                          
                                          -webkit-box-shadow: 2px 1px 7px 0px rgba(0,0,0,0.75);
                                          -moz-box-shadow: 2px 1px 7px 0px rgba(0,0,0,0.75);
                                          box-shadow: 2px 1px 7px 0px rgba(0,0,0,0.75);'>
  
                                  <div class='card-body' style = 'text-align:left;'>
                                          
                                    <h6 class='card-subtitle mb-2 text-muted'>$date2 | $time2</h6>
                                        <p class='card-text'>$announcement <br><br> 
                                            <a href = '//$link' target='_blank'>$link</a>
                                        </p>
                                    <br>
  
                                    <div class = 'row' style = 'float:right;'>
                                      
                                        <button type='button'
                                          id = 'restore_archived_post'
                                          style = 'float:right;' 
                                          class = 'btn btn-primary btn-xs mr-2' 
                                          data-faculty='$account_user_id'
                                          data-id='$announcement_id'
                                          data-toggle='modal' 
                                          data-target = '#restore_confirm_modal'> <i class='fa fa-refresh fa-lg' aria-hidden='true'></i> Restore </button>
                                      
                                    </div>
  
                                  </div>
                                </div>
                                <br>"; 
                            }

                          }else{
                            echo "<h2 style = 'text-align:center;'>NO DATA FOUND</h2><img style = 'display: block; margin-left: auto; margin-right: auto; width:80px;' src = 'img/no data icon.png'>";
                          }
                          
                      ?>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-light btn-sm border-secondary" data-dismiss="modal"> Close </button>
                    </div>
                </div>
              </div>
            </div>

            <!--------------------------------------------------------------------------------------------------------------------->
            <!--------------------------------------------------------------------------------------------------------------------->

            <!-- Delete Archived Post -->
            <div class="modal fade" id="delete_confirm_modal" role="dialog" >
              <div class="modal-dialog" style = "width:300px;"> 
              <!-- Modal content-->
                  <div class="modal-content" >
                          <div class="modal-header" style = "color:red;">
                              
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                      <div class="modal-body" style = "text-align:center;">
                          <form method = "POST" action = "admin_classes/delete_announcement_script.php" id = "form_delete_archived">    
                              <h6 style = "font-size:20px; font-weight:bold;"> Are you sure you want to permanently remove this data? </h6>  
                              <div class = "delete_archived_info" ></div>
                          </form>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id = "delete_archived_btn">Delete</button>
                      </div>
                  </div>
              </div>
            </div>

            <!--------------------------------------------------------------------------------------------------------------------->
            <!--------------------------------------------------------------------------------------------------------------------->

            <!-- Restore Archived Post -->
            <div class="modal fade" id="restore_confirm_modal" role="dialog" >
              <div class="modal-dialog" style = "width:300px;"> 
              <!-- Modal content-->
                  <div class="modal-content" >
                          <div class="modal-header" style = "color:red;">
                              
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                          </div>
                      <div class="modal-body" style = "text-align:center;">
                          <form method = "POST" action = "admin_classes/restore_announcement_script.php" id = "form_restore">    
                              <h6 style = "font-size:20px; font-weight:bold;"> Are you sure you want to restore this data? </h6>  
                              <div class = "restore_info" ></div>
                          </form>
                      </div>

                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id = "restore_btn">Restore</button>
                      </div>
                  </div>
              </div>
            </div>

            <!------------------------------------------------------------------------------------------------------------------------>
            <!------------------------------------------------------------------------------------------------------------------------>

            <!----DATA TABLES ONE-------------------------------------------------------------------------------------------------------------->
            <div class="wrapper wrapper-content animated fadeInRight">

              <div class="row">
                <div class="col-lg-12">
                  <div class="ibox ">
                    <div class="ibox-title">

                      <h5> </h5>
                      
                      <div class="ibox-tools">

                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#myModal6" id = "create_new_btn"><i class="fa fa-plus fa-lg" aria-hidden="true"></i> Create New </button>
                        <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#archived_posts" id = "archived_posts_btn"><i class="fa fa-archive fa-lg" aria-hidden="true"></i> Archived</button>

                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!--- MODAL FOR ADNEW --->
                      <div class="modal inmodal fade" id="myModal6" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title"> Announcements </h5>
                            </div>

                              <div class="modal-body">
                                <br>
                                <div class = "row">
                                  <div class="col-sm">
                                    <label style = 'float:left;'><b>Announcement:</b></label>
                                    <textarea class="form-control border border-secondary rounded input-sm" id = "announcement" style="resize: none; height:200px;" placeholder="Write something here..."></textarea>                               
                                  </div>
                                </div>

                                <br>

                                <div class = "row">
                                  <div class="col-sm">
                                      <label style = 'float:left;'><b>Link:</b></label>
                                      <textarea class="form-control border border-secondary rounded input-sm" id = "link" style="resize: none; height:100px;" placeholder="Add link here (optional)..."></textarea>                               
                                  </div>
                                </div>
                                <br>
                                <div style = "text-align:center; font-weight:bold; color:red;" id = "error"></div>
                              </div>
   
                              <div class="modal-footer">
                                <button type="button" class="btn btn-light btn-sm border-secondary" data-dismiss="modal"> Cancel </button>
                                <button type="button" class="btn btn-success btn-sm border-secondary" id="post_btn"> Post </button>
                              </div>
                          </div>
                        </div>
                      </div>

                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!-- Hide Modal -->

                      <div class="modal fade" id="hide_modal" role="dialog" >
                          <div class="modal-dialog" style = "width:300px;"> 
                          <!-- Modal content-->
                              <div class="modal-content" >
                                      <div class="modal-header" style = "color:red;">
                                          
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                  <div class="modal-body" style = "text-align:center;">
                                      <form method = "POST" action = "admin_classes/hide_announcement_script.php" id = "form_hide">
                                          
                                          <h6 style = "font-size:20px; font-weight:bold;"> Are you sure you want to hide this post? </h6>  
                                          <div class = "hide_info" ></div>

                                      </form>
                                  </div>

                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                      <button type="button" class="btn btn-primary" id = "hide_btn">Hide</button>
                                      
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!-- Unhide Modal -->

                      <div class="modal fade" id="unhide_modal" role="dialog" >
                          <div class="modal-dialog" style = "width:300px;"> 
                          <!-- Modal content-->
                              <div class="modal-content" >
                                      <div class="modal-header" style = "color:red;">
                                          
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                  <div class="modal-body" style = "text-align:center;">
                                      <form method = "POST" action = "admin_classes/unhide_announcement_script.php" id = "form_unhide">
                                          
                                          <h6 style = "font-size:20px; font-weight:bold;"> Are you sure you want to unhide this post? </h6>  
                                          <div class = "unhide_info" ></div>

                                      </form>
                                  </div>

                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                      <button type="button" class="btn btn-secondary" id = "unhide_btn">Unhide</button>
                                      
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!-- Archived Modal -->

                      <div class="modal fade" id="archive_modal" role="dialog" >
                          <div class="modal-dialog" style = "width:300px;"> 
                          <!-- Modal content-->
                              <div class="modal-content" >
                                      <div class="modal-header" style = "color:red;">
                                          
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                  <div class="modal-body" style = "text-align:center;">
                                      <form method = "POST" action = "admin_classes/archive_announcement_script.php" id = "form_archive">
                                          
                                          <h6 style = "font-size:20px; font-weight:bold;"> Are you sure you want to archive this post? </h6>  
                                          <div class = "archive_info" ></div>

                                      </form>
                                  </div>

                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                      <button type="button" class="btn btn-warning" id = "archive_btn">Archive</button>
                                      
                                  </div>
                              </div>
                          </div>
                      </div>

                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!-- Update  Modal -->
                 
                      <div class="modal inmodal fade" id="update_modal" tabindex="-1" role="dialog"  aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title"> Update Announcement </h5>
                            </div>

                              <div class="modal-body">
                                <br>
                                <div id = "update_info" style = "text-align:left;"></div>
                                <br>
                                <div style = "text-align:center; font-weight:bold; color:red;" id = "empty_update"></div>
                              </div>
   
                              <div class="modal-footer">
                                <button type="button" class="btn btn-light btn-sm border-secondary" data-dismiss="modal"> Cancel </button>
                                <button type="button" class="btn btn-success btn-sm border-secondary" id="update_btn"> Update </button>
                              </div>
                          </div>
                        </div>
                      </div>
                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!--------------------------------------------------------------------------------------------------------------------->
                      <!-- Delete  Modal -->
                      <div class="modal fade" id="delete_modal" role="dialog" >
                          <div class="modal-dialog" style = "width:300px;"> 
                          <!-- Modal content-->
                              <div class="modal-content" >
                                      <div class="modal-header" style = "color:red;">
                                          
                                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                                      </div>
                                  <div class="modal-body" style = "text-align:center;">
                                      <form method = "POST" action = "admin_classes/delete_announcement_script.php" id = "form_delete">
                                          
                                          <h6 style = "font-size:20px; font-weight:bold;"> Are you sure you want to remove this post? </h6>  
                                          <div class = "delete_info" ></div>

                                      </form>
                                  </div>

                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                      <button type="button" class="btn btn-danger" id = "delete_btn">Delete</button>
                                      
                                  </div>
                              </div>
                          </div>
                      </div>

                    </div>
                  </div>
                      
                  <!---------------------------------------------------------------------------------------------------------------------------->
                  <!---------------------------------------------------------------------------------------------------------------------------->

                    <!----TABLE SORTED---------->
                    <div class="ibox-content">

                    <?php
                        include 'admin_classes/config_mysqli.php';

                        $query = mysqli_query($con, "SELECT * FROM announcements WHERE announcement_status = 0 OR announcement_status = 1
                                  ORDER BY date_posted DESC, time_posted DESC");
                                  while($row = mysqli_fetch_array($query)){
                                    $announcement_id       = $row['announcement_id'];
                                    $announcement          = $row['announcement'];
                                    $date_posted           = $row['date_posted'];
                                    $time_posted           = $row['time_posted'];
                                    $announcement_status   = $row['announcement_status'];
                                    $link                  = $row['link'];
                                  
                                    $time1 = strtotime($time_posted);
                                    $time2 = date("h:i:sa", $time1);

                                    $date1 = strtotime($date_posted);
                                    $date2 = date("M. j, Y", $date1);

                                    if ($announcement_status == 1){

                                      print "
                                        <div class='card bg-light' 
                                            style = 'width: 70%; 
                                                    margin-right:auto; 
                                                    margin-left:auto; 
                                                    -webkit-box-shadow: 2px 1px 7px 0px rgba(0,0,0,0.75);
                                                    -moz-box-shadow: 2px 1px 7px 0px rgba(0,0,0,0.75);
                                                    box-shadow: 2px 1px 7px 0px rgba(0,0,0,0.75);'>

                                            <div class='card-body'>
                                                
                                                <h6 class='card-subtitle mb-2 text-muted'>$date2 | $time2</h6>
                                                    <p class='card-text'>$announcement <br><br> 
                                                        <a href = '//$link' target='_blank'>$link</a>
                                                    </p>
                                                <br>

                                                <div style = 'float:right;'>
                                                <a href='' data-id='$announcement_id' data-toggle='modal' data-target = '#update_modal'  id = 'update'  class='btn btn-xs btn-success action'> <i class='fa fa-pencil fa-lg' aria-hidden='true'></i> Update</a>
                                                <a href='' data-id='$announcement_id' data-toggle='modal' data-target = '#hide_modal'    id = 'hide'    class='btn btn-xs btn-primary action'> <i class='fa fa-eye fa-lg' aria-hidden='true'></i> Hide</a>
                                                <a href='' data-id='$announcement_id' data-toggle='modal' data-target = '#archive_modal' id = 'archive' class='btn btn-xs btn-warning action'> <i class='fa fa-archive fa-lg' aria-hidden='true'></i> Archive</a>
                                                </div>
                                            </div>
                                        </div>
                                        <br>";
                                    }else{
                                      print "
                                      <div class='card bg-light' 
                                          style = 'width: 70%; 
                                                  margin-right:auto; 
                                                  margin-left:auto; 
                                                  -webkit-box-shadow: 2px 1px 7px 0px rgba(0,0,0,0.75);
                                                  -moz-box-shadow: 2px 1px 7px 0px rgba(0,0,0,0.75);
                                                  box-shadow: 2px 1px 7px 0px rgba(0,0,0,0.75);'>

                                          <div class='card-body'>
                                              
                                              <h6 class='card-subtitle mb-2 text-muted'>$date2 | $time2</h6>
                                                  <p class='card-text'>$announcement <br><br> 
                                                      <a href = '//$link' target='_blank'>$link</a>
                                                  </p>
                                              <br>

                                              <div style = 'float:right;'>
                                              <a href='' data-id='$announcement_id' data-toggle='modal' data-target = '#update_modal'  id = 'update'  class='btn btn-xs btn-success action'> <i class='fa fa-pencil fa-lg' aria-hidden='true'></i> Update</a>
                                              <a href='' data-id='$announcement_id' data-toggle='modal' data-target = '#unhide_modal'  id = 'unhide'  class='btn btn-xs btn-secondary action'> <i class='fa fa-eye-slash fa-lg' aria-hidden='true'></i> Unhide</a>
                                              <a href='' data-id='$announcement_id' data-toggle='modal' data-target = '#archive_modal' id = 'archive' class='btn btn-xs btn-warning action'> <i class='fa fa-archive fa-lg' aria-hidden='true'></i> Archive</a>                               
                                              </div>
                                          </div>
                                      </div>
                                      <br>";
                                    }
                                  }
                    ?>

                     
                    </div>

                </div>
              </div>
            </div>
          </div>
          <?php include 'bootstrap_lower/lower.php'; ?>
        </div>
    </body>
  </html>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- ADD -->
<script>
  $(document).ready(function(){
    $('#post_btn').click(function(){

      $('#error').hide();

      var faculty_user_id   = $('#account_user_id').val();
      var announcement      = $('#announcement').val();
      var link              = $('#link').val();

      if(announcement == ""){

        $('#error').show();
        $('#error').html('Invalid Attempt! Please try again!');
        $('#error').effect('shake');
       
      }else{
        
        $.ajax({
          url: "admin_classes/insert_announcements.php",
          type: "POST",
          data: {
            faculty_user_id :faculty_user_id,
            announcement    :announcement,
            link            :link
          },
          cache: false,
          success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult = 1){
                    window.location = "admin_announcements.php?added";						
                }else{
                   
                  $("#empty").show();  
                  $('#empty').html('Announcement post failed!'); 
                  $('#empty').effect("shake");                                 
                   
                }   
            }
        });

      }
    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- HIDE -->
<script>
  $(document).ready(function(){
      $('.action').click(function(){

        var faculty_user_id   = $('#account_user_id').val();
        var announcement_id   = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/hide_announcement_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            announcement_id :announcement_id
            },
          success: function(response){ 
              // Add response in Modal body
              $('.hide_info').html(response);
          }
          });
      });
  });
</script> 

  <script>
  $(document).ready(function(){
    $('#hide_btn').click(function(){
      $('#form_hide').submit();
    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- UNHIDE -->
<script>
  $(document).ready(function(){
      $('.action').click(function(){

        var faculty_user_id   = $('#account_user_id').val();
        var announcement_id = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/unhide_announcement_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            announcement_id:announcement_id
            },
          success: function(response){ 
              // Add response in Modal body
              $('.unhide_info').html(response);
          }
          });
      });
  });
</script> 

  <script>
  $(document).ready(function(){
    $('#unhide_btn').click(function(){
      $('#form_unhide').submit();
    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- UPDATE -->

<script>
    $(document).ready(function(){
        $('.action').click(function(){

          $('#empty_update').hide();  
          
          var announcement_id = $(this).data('id');

        // AJAX request
            $.ajax({
            url: 'admin_classes/update_announcement_form.php',
            type: 'POST',
            data: {
              announcement_id :announcement_id
            },
            success: function(response){ 
                // Add response in Modal body
                $('#update_info').html(response);
            }
            });
        });
    });
</script>


<!-- FORM UPDATE-->
<script>
    $(document).ready(function(){
      $('#update_btn').click(function(){
       
        var faculty_user_id   = $('#account_user_id').val();
        var announcement     = $('#announcement_new').val();
        var announcement_id  = $('#announcement_id_hid').val();
        var link             = $('#link_new').val();
    
        if(announcement == ''){       
            
          $('#empty_update').html('Invalid Attempt! Please try again!');
          $('#empty_update').show();   
          $('#empty_update').effect('shake');
                  
        }else{
          
          $.ajax({
            url: "admin_classes/update_announcement_ajax.php",
            type: "POST",
            data: {
              faculty_user_id  :faculty_user_id,
              announcement_id  :announcement_id,
              announcement     :announcement,
              link             :link        
              },
            cache: false,
            success: function(dataResult){
                var dataResult = JSON.parse(dataResult);
                if(dataResult = 1){
                    window.location = "admin_announcements.php?updated";						
                }else{
                   
                  $("#empty_update").show();  
                    $('#empty_update').html('Updating announcement failed!'); 
                    $('#empty_update').effect("shake");                                 
                   
                }   
            }
          });           
        }   
      });   
    });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->

<!-- DELETE  -->
<script>
  $(document).ready(function(){
      $('.action').click(function(){

        var faculty_user_id = $('#account_user_id').val();
        var announcement_id = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/delete_announcement_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            announcement_id :announcement_id
            },
          success: function(response){ 
              // Add response in Modal body
              $('.delete_info').html(response);
          }
          });
      });
  });
</script> 

  <script>
  $(document).ready(function(){
    $('#delete_btn').click(function(){
      $('#form_delete').submit();
    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------->
<!-- ARCHIVE POST -->
<script>
  $(document).ready(function(){
      $('.action').click(function(){

        var faculty_user_id = $('#account_user_id').val();
        var announcement_id = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/archive_announcement_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id :faculty_user_id,
            announcement_id :announcement_id
            },
          success: function(response){ 
              // Add response in Modal body
              $('.archive_info').html(response);
          }
          });
      });
  });
</script> 

  <script>
  $(document).ready(function(){
    $('#archive_btn').click(function(){
      $('#form_archive').submit();
    });
  });
</script>


<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->

<!-- DELETE ARCHIVED POST -->
<script>
  $(document).ready(function(){
    $(document).on("click","#delete_archived_post", function (){ 

        var faculty_user_id  = $(this).data('faculty');
        var announcement_id  = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/delete_announcement_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id   :faculty_user_id,
            announcement_id   :announcement_id
            },
          success: function(response){ 
              // Add response in Modal body
              $('.delete_archived_info').html(response);
          }
          });
      });
  });
</script> 

  <script>
  $(document).ready(function(){
    $('#delete_archived_btn').click(function(){
      $('#form_delete_archived').submit();
    });
  });
</script>

<!---------------------------------------------------------------------------------------------------------------------------------->
<!---------------------------------------------------------------------------------------------------------------------------------->

<!-- RESTORE ARCHIVED POST -->
<script>
  $(document).ready(function(){
    $(document).on("click","#restore_archived_post", function (){ 

        var faculty_user_id  = $(this).data('faculty');
        var announcement_id  = $(this).data('id');

      // AJAX request
          $.ajax({
          url: 'admin_classes/restore_announcement_ajax.php',
          type: 'POST',
          data: {
            faculty_user_id   :faculty_user_id,
            announcement_id   :announcement_id
            },
          success: function(response){ 
              // Add response in Modal body
              $('.restore_info').html(response);
          }
          });
      });
  });
</script> 

  <script>
  $(document).ready(function(){
    $('#restore_btn').click(function(){
      $('#form_restore').submit();
    });
  });
</script>
