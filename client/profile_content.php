<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content">  
        <div class="block content" style="box-shadow:0px 2px 4px #b3b3b3;">
            <!-- Personal Details -->      
            <h2 class="content-heading" style="margin-top: -40px;">
                <span id="id_contact" class="badge float-right mt-5" style="font-size: 13px; color: #fff; background-color: #0d7694;">Contact ID: <?php echo $row['contact_id'];?></span>
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
                        <div class="block-content block-content-full block-content-sm" style="background-color: #0d7694;">
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
                                <label for="crypto-settings-street-1">FB Name</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_fbname'];?>" readonly>
                             </div>
                        </div>
                        <div class="col-md-6">
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
        <!-- End Personal Details -->  
        </div> 
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->