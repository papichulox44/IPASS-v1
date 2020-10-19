<?php
    $contact_id = $row['contact_id'];
?>
<style >
    .shad { box-shadow:0px 2px 4px #b3b3b3; }
</style>
<style type="text/css">
    .test {
  display: inline-block;
  padding: 20px;
}
.spinner-circle {
  width: 160px;
  height: 160px;
  position: relative;
  margin: 30px;
}
.spinner {
  height: 100%;
  width: 100%;
  border-radius: 50%;
  border: 5px solid rgba(0,0,0,0.3);
  border-right: 5px solid #42A5F5;
  animation: rotate--spinner 1.6s linear infinite;
  box-sizing: border-box;

}
@keyframes rotate--spinner {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content">  

        <div class="row">            
            <div class="col-md-12">
                <div class="block block-mode-hidden shad">
                    <div class="block-header block-header-default" style="background-color: #5CC6D0;">
                        <h1 class="block-title text-white">My contact</h1>
                        <div class="block-options">
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                        </div>
                    </div>
                    <div class="block-content">    
                        <h2 class="content-heading" style="margin-top: -40px;">
                            <!-- <span id="id_contact" class="badge float-right mt-5" style="font-size: 13px; color: #fff; background-color: #0d7694;">Contact ID: <?php echo $row['contact_id'];?></span> -->
                            Personal Details
                        </h2>
                        <div class="row items-push">
                            <div class="col-lg-4">
                                <div class="block block-themed text-center">
                                    <div class="block-content block-content-full block-sticky-options pt-30" style="background-color: #e6e6e6;">
                                        <?php if($row['contact_profile'] != ""): ?>
                                            <img class="prof" src="client_profile/<?php echo $row['contact_profile']; ?>">
                                        <?php else: ?>
                                            <img class="prof" src="../assets/media/photos/avatar.jpg">
                                        <?php endif; ?>  
                                    </div>
                                    <div class="block-content block-content-full block-content-sm" style="background-color: #5CC6D0;">
                                        <div class="font-w600 text-white mb-5"><?php echo $row['contact_fname'] . " " . $row['contact_mname'] . " " . $row['contact_lname'];?></div>
                                        <div class="font-size-sm text-white-op">Contact Name</div>
                                    </div>
                                </div>                                   
                            </div>
                            <div class="col-lg-8">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">First Name</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_fname'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Middle Name</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_mname'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Last Name</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_lname'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Birthdate</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_bdate'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Gender</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_gender'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Email</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_email'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Status</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_status'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Nationality</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_nationality'];?>" readonly>
                                         </div>
                                         
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="crypto-settings-street-1">FB Name</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_fbname'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Messenger</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_messenger'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Country</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_country'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">City</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_city'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Zip Code</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_zip'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Street</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_street'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Contact #</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_cpnum'];?>" readonly>
                                         </div>
                                         <div class="form-group">
                                            <label for="crypto-settings-street-1">Location</label>
                                            <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_location'];?>" readonly>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div>                          
                    </div>
                </div>

                <div class="block block-mode-hidden shad">
                    <div class="block-header block-header-default" style="background-color: #5CC6D0;">
                        <h1 class="block-title text-white">Check the latest information here! <span class="badge badge-danger" id="count_latest_noti"></span></h1>
                        <div class="block-options">
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle" onclick="latest_noti()"></button>
                        </div> 
                    </div>
                    <div class="block-content"> 
                        <?php 
                        $query = mysqli_query($conn, "SELECT * FROM tbl_information WHERE info_status = 1");
                        foreach ($query as $data) {
                         ?>
                        <hr>
                            <center>
                                <?php if (!empty($data['info_image'])) {
                                 ?>
                                <img style="width: 50%; height: auto;" src="../assets/media/information/<?php echo $data['info_image']; ?>">
                                <?php } ?>
                                <strong>
                                    <h3><?php echo $data['info_title']; ?></h3>
                                </strong>
                                <label><?php echo $data['info_text']; ?></label>
                            </center>
                        <?php } ?>
                    </div>  
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="block block-content shadow">
                            <!-- Progress Details -->      
                            <h2 class="content-heading" style="margin-top: -40px;">
                                Application Progress 
                            </h2>
                            <div class="row items-push">
                                <?php
                                    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_contact = '$contact_id'");
                                    while($fetch_task = mysqli_fetch_array($select_task))
                                    {
                                        $list_id = $fetch_task['task_list_id'];
                                        $select_list = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$list_id'");
                                        $fetch_select_list = mysqli_fetch_array($select_list);
                                        $list_name = $fetch_select_list['list_name'];
                                        $list_space_id = $fetch_select_list['list_space_id'];
                                        $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$list_space_id'");
                                        $fetch_select_space = mysqli_fetch_array($select_space);
                                        $space_name = $fetch_select_space['space_name'];
                                        $status_id = $fetch_task['task_status_id'];

                                        $status = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id ='$list_id' ORDER BY status_order_no ASC");
                                        $count_status = mysqli_num_rows($status);
                                        $count = 0;
                                        while($fetch_status = mysqli_fetch_array($status))
                                        {
                                            $count ++;
                                            if($status_id == $fetch_status['status_id'])
                                            {
                                                $z = $count;
                                            }
                                        }
                                        if($count_status == 1)
                                        {
                                            $percentage = 0;
                                        }
                                        else
                                        {
                                            $minus = 1 / ($count_status - 1) * 100;
                                            $percentage = number_format(($z / ($count_status - 1) * 100) - $minus)."";   
                                        }
 
                                        echo '
                                        <div class="col-md-6">
                                            <div class="block block-themed text-center ribbon ribbon-bookmark ribbon-primary">
                                                <div style="background: #eee; padding: 15px;">
                                                    <div class="py-20 text-center shadow" style="background-color: #fff;">
                                                        <div class="test">
                                                          <div class="spinner-circle">
                                                            <div class="spinner"></div>
                                                            <span>
                                                            ';
                                                                if($percentage == 100)
                                                                { echo '<img style="height: 145px; margin-top: -182px;" src="../assets/media/photos/logo-ipass.png">'; }
                                                                else
                                                                { echo '<img style="height: 145px; margin-top: -182px;" src="../assets/media/photos/logo-ipass.png">'; }
                                                            echo'
                                                           </span>
                                                         </div>
                                                        </div>
                                                        <br>
                                                        <div class="block-content-full block-content-sm" style="background-color: #5CC6D0;">
                                                            <div class="font-w600 text-white" style="font-size: 70px;">'.$percentage.'%</div>
                                                            <div class="text-uppercase text-white" style="margin-top: -16px;">Complete</div>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="text-white text-left col-md-3" style="padding: 5px 10px; color: #fff; margin-bottom: -10px; background-color: #013c4c;">
                                                                            Services: 
                                                                    </div>
                                                                    <div class="text-white text-left col-md-9" style="padding: 5px 10px; color: #fff; margin-bottom: -10px; background-color: #013c4c;">
                                                                        ';
                                                                        $new_space_name = substr($space_name, 0, 25); // get specific character
                                                                        if(strlen($space_name) > 25)
                                                                        {
                                                                            echo '<span data-toggle="popover" title="'.$space_name.'" data-placement="bottom">'.$new_space_name.'...</span>';
                                                                        }
                                                                        else
                                                                        {
                                                                            echo '<span>'.$new_space_name.'</span>';
                                                                        }
                                                                        echo '
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="text-white text-left col-md-3" style="padding: 5px 10px; color: #fff; margin-bottom: -10px; background-color: #013c4c;">
                                                                            Application: 
                                                                    </div>
                                                                    <div class="text-white text-left col-md-9" style="padding: 5px 10px; color: #fff; margin-bottom: -10px; background-color: #013c4c;">
                                                                        ';
                                                                        $new_name = substr($list_name, 0, 25); // get specific character
                                                                        if(strlen($list_name) > 25)
                                                                        {
                                                                            echo '<span data-toggle="popover" title="'.$list_name.'" data-placement="bottom">'.$new_name.'...</span>';
                                                                        }
                                                                        else
                                                                        {
                                                                            echo '<span>'.$new_name.'</span>';
                                                                        }
                                                                        echo '
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="row">
                                                                    <div class="text-white text-left col-md-3" style="padding: 5px 10px; color: #fff; margin-bottom: -10px; background-color: #013c4c;">
                                                                            Status: 
                                                                    </div>
                                                                    <div class="text-white text-left col-md-9" style="padding: 5px 10px; color: #fff; margin-bottom: -10px; background-color: #013c4c;">
                                                                        ';
                                                                        $select_status = mysqli_query($conn, "SELECT * FROM status WHERE status_id ='$status_id'");
                                                                        $result_select_status = mysqli_fetch_array($select_status);
                                                                        $status_name = $result_select_status['status_name'];
                                                                        $new_name = substr($status_name, 0, 25); // get specific character
                                                                        if(strlen($status_name) > 25)
                                                                        {
                                                                            echo '<span data-toggle="popover" title="'.$status_name.'" data-placement="bottom">'.$new_name.'...</span>';
                                                                        }
                                                                        else
                                                                        {
                                                                            echo '<span>'.$status_name.'</span>';
                                                                        }
                                                                        echo' 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                                   
                                        </div>';
                                    }
                                ?> 
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
<script type="text/javascript">
    count_latest_noti();

    function count_latest_noti(){

        $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: false,
        data:{
            count_latest_noti: 1,
        },
            success: function(response){
                $('#count_latest_noti').html(response);
            }
        });
    }

    function latest_noti(){
        // alert('Nag alert sya');
        $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: false,
        data:{
            latest_noti: 1,
        },
            success: function(response){
                // $('#count_latest_noti').html(response);
                if (response == 'success') {
                    count_latest_noti();
                } 
            }
        });
    }


</script>