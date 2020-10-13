<?php
	$user_type = $row['user_type'];
    if($mode_type == "Dark") //insert
	{ 
		$md_content = "bg-primary-darker";
		$md_text = "text-white";
    	$sq_inbox = "bg-black-op text-body-color-light"; 
    	$sq_member = "bg-black-op text-body-color-light"; 
    	$sq_contact = "bg-black-op text-body-color-light"; 
    	$sq_task = "bg-black-op text-body-color-light"; 
		$md_modal_body = "bg-primary-darker text-body-color-light";
		$md_modal_footer = "bg-dark";
		$md_table_header = "bg-gray-darker";
		$md_table_body = "bg-gray-darker text-body-color-light";
		$md_table_title = "text-white";
		$table = "bg-gray-darker text-body-color-light"; 
        $graph_bg = "block-transparent bg-black-op text-white";
        $canvas = "dark";
	}
	else
	{ 
		$md_content = "";
		$md_text = "text_muted";
    	$sq_inbox = "bg-gd-elegance";
    	$sq_member = "bg-gd-dusk";
    	$sq_contact = "bg-gd-sea";
    	$sq_task = "bg-gd-aqua";
		$md_modal_body = "";
		$md_modal_footer = "";
		$md_table_header = "";
		$md_table_title = "";
		$table = "";
        $canvas = "dashboard";
	}

	if($user_type == "Admin")
	{ ?>
		<?php
			$user_id = $row['user_id'];
	        $select_new_message = mysqli_query($conn, "SELECT * FROM message WHERE reciever_id = '$user_id' AND status = '1'");
	        $count_new_message = mysqli_num_rows($select_new_message);

			$select_member = mysqli_query($conn, "SELECT * FROM user");
			$member = mysqli_num_rows($select_member);

			$select_task = mysqli_query($conn, "SELECT * FROM task");
			$task = mysqli_num_rows($select_task);

			$select_contact = mysqli_query($conn, "SELECT * FROM contact");
			$contact = mysqli_num_rows($select_contact);
		?>

		<!-- Main Container -->
		<main id="main-container">
		    <!-- Hero -->
		    <div class="bg-image" style="background-image: url('../assets/media/photos/Team.jpg');">
		        <div class="bg-black-op">
		            <div class="content content-top content-full text-center">
		                <h2 class="h4 text-white-op mb-0 mt-0">IPASS processing..</h2>
		            </div>
		        </div>
		    </div>
		    <!-- END Hero -->
		    <!-- Page Content -->
				<div class="content <?php echo $md_content; ?>">
					<!-- Statistics -->
		        <div class="row gutters-tiny">
		            <!-- Earnings -->
		            <div class="col-md-6 col-xl-3">
		                <a class="block block-rounded block-transparent <?php echo $sq_inbox; ?>" href="main_inbox.php">
		                    <div class="block-content block-content-full block-sticky-options">
		                        <div class="block-options">
		                            <div class="block-options-item">
		                                <i class="fa fa-folder-open fa-2x text-white-op"></i>
		                            </div>
		                        </div>
		                        <div class="py-20 text-center">
		                            <div class="font-size-h2 font-w700 mb-0 text-white" data-toggle="countTo" data-to="<?php echo $count_new_message; ?>">0</div>
		                            <div class="font-size-sm font-w600 text-uppercase text-white-op">Inbox</div>
		                        </div>
		                    </div>
		                </a>
		            </div>
		            <!-- END Earnings -->

		            <!-- Orders -->
		            <div class="col-md-6 col-xl-3">
		                <a class="block block-rounded block-transparent <?php echo $sq_member; ?>" href="main_people.php">
		                    <div class="block-content block-content-full block-sticky-options">
		                        <div class="block-options">
		                            <div class="block-options-item">
		                                <i class="fa fa-users fa-2x text-white-op"></i>
		                            </div>
		                        </div>
		                        <div class="py-20 text-center">
		                            <div class="font-size-h2 font-w700 mb-0 text-white" data-toggle="countTo" data-to="<?php echo $member; ?>">0</div>
		                            <div class="font-size-sm font-w600 text-uppercase text-white-op">Member</div>
		                        </div>
		                    </div>
		                </a>
		            </div>
		            <!-- END Orders -->

		            <!-- New Customers -->
		            <div class="col-md-6 col-xl-3">
		                <a class="block block-rounded block-transparent <?php echo $sq_contact; ?>" href="main_everything.php">
		                    <div class="block-content block-content-full block-sticky-options">
		                        <div class="block-options">
		                            <div class="block-options-item">
		                                <i class="fa fa-tasks fa-2x text-white-op"></i>
		                            </div>
		                        </div>
		                        <div class="py-20 text-center">
		                            <div class="font-size-h2 font-w700 mb-0 text-white" data-toggle="countTo" data-to="<?php echo $task; ?>">0</div>
		                            <div class="font-size-sm font-w600 text-uppercase text-white-op">Task</div>
		                        </div>
		                    </div>
		                </a>
		            </div>
		            <!-- END New Customers -->

		            <!-- Conversion Rate -->
		            <div class="col-md-6 col-xl-3">
		                <a class="block block-rounded block-transparent <?php echo $sq_task; ?>" href="main_contact_assign.php">
		                    <div class="block-content block-content-full block-sticky-options">
		                        <div class="block-options">
		                            <div class="block-options-item">
		                                <i class="fa fa-address-book fa-2x text-white-op"></i>
		                            </div>
		                        </div>
		                        <div class="py-20 text-center">
		                            <div class="font-size-h2 font-w700 mb-0 text-white" data-toggle="countTo" data-to="<?php echo $contact; ?>">0</div>
		                            <div class="font-size-sm font-w600 text-uppercase text-white-op">Contact</div>
		                        </div>
		                    </div>
		                </a>
		            </div>
		            <!-- END Conversion Rate -->
		        </div>
		        <!-- END Statistics -->

                <!-- Currency -->
                <div class="row row-deck mt-20">
                    <div class="col-lg-12">
                        <div class="block block-rounded shadow <?php echo $md_table_header; ?>">
                            <div class="block-header content-heading <?php echo $md_table_header; ?>">
                                <h3 class="block-title <?php echo $md_table_title; ?>">Currency list</h3>
                                <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#modal-currency">
			                        <i class="fa fa-plus mr-5"></i>Add currency
			                    </button>
                            </div>
                            <div class="block-content <?php echo $md_table_body; ?> mb-20" id="fetch_currency"></div>

                            
					        <div class="row row-deck">
					            <div class="col-lg-12">
					                <div class="block block-rounded shadow bg-gray-darker">
					                    <div class="block-header content-heading bg-gray-darker">
					                        <h3 class="block-title text-white d-none d-sm-block" style="cursor: pointer;" id="hide_show_remittance">Remittance <i class="si si-arrow-down"></i></h3>
					                    </div>
					                </div>
					            </div>
					        </div>
                            <!-- Remittance table -->
                            <div class="block-content <?php echo $md_table_body;?> mb-20" id="view_remittance"></div>
                            <!-- End Remittance table -->

                            <div class="row row-deck">
					            <div class="col-lg-12">
					                <div class="block block-rounded shadow bg-gray-darker">
					                    <div class="block-header content-heading bg-gray-darker">
					                        <h3 class="block-title text-white d-none d-sm-block" style="cursor: pointer;" id="hide_show_company_information">Company Information <i class="si si-arrow-down"></i> </h3>
					                        <button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#modal-information">
						                        <i class="fa fa-plus mr-5"></i>Add
						                    </button>
					                    </div>
					                </div>
					            </div>
					        </div>

                            <div class="block-content <?php echo $md_table_body;?> mb-20" id="view_company_information"></div>

                            <div class="row row-deck">
					            <div class="col-lg-12">
					                <div class="block block-rounded shadow bg-gray-darker">
					                    <div class="block-header content-heading bg-gray-darker">
					                        <h3 class="block-title text-white d-none d-sm-block" style="cursor: pointer;" id="hide_show_list_of_email">List of Email <i class="si si-arrow-down"></i> </h3>
					                    </div>
					                </div>
					            </div>
					        </div>

                            <div class="block-content <?php echo $md_table_body;?> mb-20" id="list_of_email"></div>

                            <div class="row row-deck">
					            <div class="col-lg-12">
					                <div class="block block-rounded shadow bg-gray-darker">
					                    <div class="block-header content-heading bg-gray-darker">
					                        <h3 class="block-title text-white d-none d-sm-block" style="cursor: pointer;" id="hide_show_list_of_remarks">List of Remarks <i class="si si-arrow-down"></i> </h3>
					                    </div>
					                </div>
					            </div>
					        </div>

                            <div class="block-content <?php echo $md_table_body;?> mb-20" id="list_of_remarks"></div>

                        </div>
                    </div>
                </div>
                <!-- END Currency -->
                

                <!-- Fade In Modal -->
		        <div class="modal fade" id="modal-currency" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
		            <div class="modal-dialog" role="document">
		                <div class="modal-content">
		                    <div class="block block-themed block-transparent mb-0">
		                        <div class="block-header bg-primary-dark">
		                            <h3 class="block-title">Currency Editor</h3>
		                            <div class="block-options">
		                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
		                                    <i class="si si-close"></i>
		                                </button>
		                            </div>
		                        </div>
		                        <div class="block-content <?php echo $md_modal_body; ?>">
									<div class="row">
			                            <div class="col-md-6">
			                                <div class="form-group">
			                                    <label for="wizard-simple-firstname">Currency name</label>
			                                    <input type="hidden" class="form-control" id="currency_id">
			                                    <input type="text" class="form-control" id="currency_name">
			                                </div>
			                            </div>
			                            <div class="col-md-6">
			                                <div class="form-group">
			                                    <label for="wizard-simple-firstname">Code</label>
			                                    <input type="text" class="form-control" id="currency_code">
			                                </div>
			                            </div>
			                        </div>
			                        <div class="row">
			                            <div class="col-md-6">
			                                <div class="form-group">
			                                    <label for="wizard-simple-firstname">Value (USD)</label>
			                                    <input type="text" class="form-control" id="currency_val_usd" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
			                                </div>
			                            </div>
			                            <div class="col-md-6">
			                                <div class="form-group">
			                                    <label for="wizard-simple-firstname">Value (PHP)</label>
			                                    <input type="text" class="form-control" id="currency_val_php" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
			                                </div>
			                            </div>
			                        </div>
		                        </div>
		                        <div class="modal-footer <?php echo $md_modal_footer; ?>">
			                        <button type="button" class="btn btn-noborder bg-primary btn-block text-white" id="create_currency">
			                            <i class="fa fa-check"></i> Save
			                        </button>
			                    </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		        <!-- END Fade In Modal -->

		        <!-- Fade In Modal -->
		        <div class="modal fade" id="modal-information" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
		            <div class="modal-dialog" role="document">
		                <div class="modal-content">
		                    <div class="block block-themed block-transparent mb-0">
		                        <div class="block-header bg-primary-dark">
		                            <h3 class="block-title">Add Information</h3>
		                            <div class="block-options">
		                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
		                                    <i class="si si-close"></i>
		                                </button>
		                            </div>
		                        </div>
		                        <div class="block-content <?php echo $md_modal_body; ?>">
									<div class="row">
			                            <div class="col-md-12">
			                                <div class="form-group">
			                                    <label for="wizard-simple-firstname">Title:</label>
			                                    <input type="text" class="form-control" id="info_title">
			                                </div>
			                            </div>
			                        </div>
			                        <div class="row">
			                            <div class="col-md-12">
			                                <div class="form-group">
			                                    <label for="wizard-simple-firstname">Content:</label>
			                                    <textarea rows="15" class="form-control" id="info_text"></textarea>
			                                    <!-- <input type="text" rows="15" class="form-control" id="info_text"> -->
			                                </div>
			                            </div>
			                        </div>
			                        <div class="row">
			                            <div class="col-md-12">
			                                <div class="form-group">
			                                	<label for="wizard-simple-firstname">Status:</label>
			                                    <!-- <input type="file" id="info_image"> -->
			                                    <select id="info_status" class="form-control">
			                                    	<option selected="" disabled=""> Select Status</option>
			                                    	<option value="0">Hide in Client Portal</option>
			                                 		<option value="1">Show in Client Portal</option>
			                                    </select>
			                                </div>
			                            </div>
			                        </div>
			                        <div class="row">
			                            <div class="col-md-12">
			                                <div class="form-group">
			                                    <input type="file" id="info_image">
			                                </div>
			                            </div>
			                        </div>
		                        </div>
		                        <div class="modal-footer <?php echo $md_modal_footer; ?>">
			                        <!-- <button type="button" class="btn btn-noborder bg-primary btn-block text-white" id="create_information"> -->
			                        <button type="button" class="btn btn-noborder bg-primary btn-block text-white" onclick="create_information()">
			                            <i class="fa fa-check"></i> Save
			                        </button>
			                    </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		        <!-- END Fade In Modal -->

		        <div class="modal fade" id="modal-information-update" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
		            <div class="modal-dialog" role="document">
		                <div class="modal-content">
		                    <div class="block block-themed block-transparent mb-0">
		                        <div class="block-header bg-primary-dark">
		                            <h3 class="block-title">Update Information</h3>
		                            <div class="block-options">
		                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
		                                    <i class="si si-close"></i>
		                                </button>
		                            </div>
		                        </div>
		                        <div class="block-content <?php echo $md_modal_body; ?>" id="view_update_information">
									
		                    </div>
		                </div>
		            </div>
		        </div>
		        
		    </div>
		    <!-- END Page Content -->
		</main>
		<!-- END Main Container -->

	<script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
	<script>
		$(document).ready(function(){
			display_currency();
			view_remittance();
			view_company_information();
			view_list_of_email();
			view_remarks();

			$('#create_currency').on('click', function(){
				currency_id = document.getElementById("currency_id").value;
				currency_name = document.getElementById("currency_name").value;
				currency_code = document.getElementById("currency_code").value;
				currency_val_usd = document.getElementById("currency_val_usd").value;
				currency_val_php = document.getElementById("currency_val_php").value;

				if(currency_name == "" || currency_code == "" || currency_val_usd == "" ||currency_val_php == "")
				{
					alert('Please insert value in all field.');
				}
				else
				{
					$.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {	
                        	currency_id:currency_id,
                            currency_name: currency_name,
                            currency_code: currency_code,
                            currency_val_usd: currency_val_usd,
                            currency_val_php: currency_val_php,
                            create_currency: 1,
                        },
                        success: function(data){
                        	if(data == "Insert")
                        	{
								alert('Currency added successfully.');
                        	}
                        	else
                        	{
                        		alert('Currency updated successfully.');
                        	}
                            clear_input();
                            $('#modal-currency').modal("hide");
                            display_currency(); 
                        }
                    });
				}
			});
		});

		function create_information(){
			info_title = document.getElementById("info_title").value;
			info_text = document.getElementById("info_text").value;
			info_status = document.getElementById("info_status").value;
			info_image = document.getElementById("info_image").value;
			image = info_image.replace(/^.*\\/, "");

				if (info_image) {
					if (info_title == "" || info_text == "" || info_status == "") {
						alert('Please fill up all the field!!');
					}
					else {
					tran_attachment = $('#info_image');
                    file_attachment = tran_attachment.prop('files')[0];

                    formData = new FormData();
                    formData.append('info_title', info_title);
                    formData.append('info_text', info_text);
                    formData.append('info_status', info_status);
                    formData.append('info_image', image);
                    formData.append('file_attachment', file_attachment);
                    formData.append('save_company_information', 1);

                    $.ajax({
		                url: 'ajax_transaction.php',
		                type: 'POST', 
		                async: false,
		                data: formData,
		                contentType:false,
                        cache: false,
                        processData: false,
		                    success: function(response){
		                    	if (response == 'success') {
		                    		alert('Information Successfully Added!');
		                    		$('#modal-information').modal('hide');
		                    		view_company_information();
		                    	}
		                    }
		            }); }
				}
				else {
					if (info_title == "" || info_text == "" || info_status == "") {
						alert('Please fill up all the field!!');
					}
					else {
					$.ajax({
		                url: 'ajax_transaction.php',
		                type: 'POST', 
		                async: false,
		                data:{
		                	info_title:info_title,
		                	info_text:info_text,
		                	info_status:info_status,
		                    save_company_information: 1,
		                },
		                    success: function(response){
		                    	if (response == 'success') {
		                    		alert('Information Successfully Added!');
		                    		$('#modal-information').modal('hide');
		                    		view_company_information();
		                    	}
		                    }
		            }); }
				}
		}

		function update_information_company(){
			info_title = document.getElementById("info_title_update").value;
			info_text = document.getElementById("info_text_update").value;
			info_status = document.getElementById("info_status_update").value;
			info_image = document.getElementById("info_image_update").value;
			unlink_image = document.getElementById("unlink_image").value;
			info_id = document.getElementById("info_id").value;

			image = info_image.replace(/^.*\\/, "");

				if (info_image) {
					if (info_title == "" || info_text == "" || info_status == "") {
						alert('Please fill up all the field!!');
					}
					else {
					tran_attachment = $('#info_image_update');
                    file_attachment = tran_attachment.prop('files')[0];

                    formData = new FormData();
                    formData.append('unlink_image', unlink_image);
                    formData.append('info_id', info_id);
                    formData.append('info_title', info_title);
                    formData.append('info_text', info_text);
                    formData.append('info_status', info_status);
                    formData.append('info_image', image);
                    formData.append('file_attachment', file_attachment);
                    formData.append('update_company_information', 1);

                    $.ajax({
		                url: 'ajax_transaction.php',
		                type: 'POST', 
		                async: false,
		                data: formData,
		                contentType:false,

                        cache: false,
                        processData: false,
		                    success: function(response){
		                    		alert('Information Successfully Update!');
		                    		$('#modal-information-update').modal('hide');
		                    		view_company_information();
		                    }
		            }); }
				}
				else {
					if (info_title == "" || info_text == "" || info_status == "") {
						alert('Please fill up all the field!!');
					}
					else {
					$.ajax({
		                url: 'ajax_transaction.php',
		                type: 'POST', 
		                async: false,
		                data:{
		                	info_id:info_id,
		                	info_title:info_title,
		                	info_text:info_text,
		                	info_status:info_status,
		                    update_company_information: 1,
		                },
		                    success: function(response){
		                    	if (response == 'success') {
		                    		alert('Information Successfully Update!');
		                    		$('#modal-information-update').modal('hide');
		                    		view_company_information();
		                    	}
		                    }
		            }); }
				}
		}

		function display_currency()
		{
			md_mode = "<?php echo $mode_type; ?>";
            $.ajax({
                url: 'ajax.php',
                type: 'POST', 
                async: false,
                data:{
                	md_mode:md_mode,
                    fetch_currency: 1,
                },
                    success: function(response){
                    	// $("#fetch_currency").fadeIn(3000);
                        $('#fetch_currency').html(response);
                    }
            });
		}

		$(document).ready(function(){
		  $("#hide_show_remittance").click(function(){
		    $("#view_remittance").slideToggle("slow");
		  });
		});

		$(document).ready(function(){
		  $("#hide_show_company_information").click(function(){
		    $("#view_company_information").slideToggle("slow");
		  });
		});

		

		// VIEW ALL Remittance --------------------------
        function view_remittance()
        {
            $.ajax({
                url: 'ajax_transaction.php',
                type: 'POST',
                async: false,
                data:{
                    view_remittance: 1,
                },
                    success: function(response){
                        $('#view_remittance').html(response);
                    }
            });
        }
        // END VIEW ALL Remittance -------------------------

        function view_company_information()
        {

            $.ajax({
                url: 'ajax_transaction.php',
                type: 'POST',
                async: false,
                data:{
                    view_company_information: 1,
                },
                    success: function(response){
                        $('#view_company_information').html(response);
                    }
            });
        }

        //  All function list email -------------------------------------------------------------------------------------------------
        $(document).ready(function(){
		  $("#hide_show_list_of_email").click(function(){
		    $("#list_of_email").slideToggle("slow");
		  });
		});

        function view_list_of_email()
        {
            $.ajax({
                url: 'ajax_transaction.php',
                type: 'POST',
                async: false,
                data:{
                    view_list_of_email: 1,
                },
                    success: function(response){
                        $('#list_of_email').html(response);
                    }
            });
        }

        function add_email()
        {   
            add_email_value = document.getElementById("add_email_value").value;

            if (add_email_value == '') {
            	alert('Please inpute email!');
            } else {
	            if (confirm('Are you sure?')) {
	                $.ajax({
	                    url: 'ajax_transaction.php',
	                    type: 'POST',
	                    async: false,
	                    data:{
	                        add_email_value:add_email_value,
	                        add_email: 1,
	                    },
	                        success: function(response){
	                            if (response == 'success') {
	                                alert('Successfully Added!');
	                                view_list_of_email();
	                            }
	                        }
	                });
	            }
	        }
        }

        function delete_list_of_email(id)
        {   
            // alert(id);
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        list_of_email_id:id,
                        delete_list_of_email: 1,
                    },
                        success: function(response){
                            // $('#view_remittance').html(response);
                            if (response == 'success') {
                                alert('Successfully Deleted!');
                                view_list_of_email();
                            }
                        }
                });
            }
        }

        function update_list_of_email(id)
        {   
            list_email_name = document.getElementById("list_email_name" + id).value;

            // alert(id);
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        list_email_id:id,
                        list_email_name:list_email_name,
                        update_list_of_email: 1,
                    },
                        success: function(response){
                            // $('#view_remittance').html(response);
                            if (response == 'success') {
                                alert('Successfully Update!');
                                view_list_of_email();
                            }
                        }
                });
            }
        }

        function set_list_of_email(id)
        {
        	// alert(id);
        	if (confirm('Are you sure?')) {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        set_email:id,
                        set_list_of_email: 1,
                    },
                        success: function(response){
                            // $('#view_remittance').html(response);
                            if (response == 'success') {
                                alert('Successfully Set!');
                                view_list_of_email();
                            }
                        }
                });
            }
        }
        // END  All function list email -------------------------------------------------------------------------------------------------

        // All fucntion for remarks ------------------------------------------------------------------------------------------------------
        $(document).ready(function(){
		  $("#hide_show_list_of_remarks").click(function(){
		    $("#list_of_remarks").slideToggle("slow");
		  });
		});

        function view_remarks()
        {
            $.ajax({
                url: 'ajax_transaction.php',
                type: 'POST',
                async: false,
                data:{
                    view_list_of_remarks: 1,
                },
                    success: function(response){
                        $('#list_of_remarks').html(response);
                    }
            });
        }

        function add_remarks_data()
        {   
            add_remarks_value = document.getElementById("add_remarks_value").value;
            add_color = document.getElementById("add_color").value;

            // alert(add_color);

            if (add_remarks_value == '') {
            	alert('Please input remarks!');
            } else {
	            if (confirm('Are you sure?')) {
	                $.ajax({
	                    url: 'ajax_transaction.php',
	                    type: 'POST',
	                    async: false,
	                    data:{
	                        add_remarks_value:add_remarks_value,
	                        add_color:add_color,
	                        add_remarks_data: 1,
	                    },
	                        success: function(response){
	                            if (response == 'success') {
	                                alert('Successfully Added!');
	                                view_remarks();
	                            }
	                        }
	                });
	            }
	        }
        }

        function delete_remarks_data(id)
        {   
            // alert(id);
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        remarks_id:id,
                        delete_remarks_data: 1,
                    },
                        success: function(response){
                            // $('#view_remittance').html(response);
                            if (response == 'success') {
                                alert('Successfully Deleted!');
                                view_remarks();
                            }
                        }
                });
            }
        }

        function update_list_remarks_value(id)
        {   
            list_remarks_value = document.getElementById("list_remarks_value" + id).value;
            remarks_color = document.getElementById("remakrs_color" + id).value;

            // alert(id);
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        remarks_id:id,
                        list_remarks_value:list_remarks_value,
                        remarks_color:remarks_color,
                        update_list_remarks_value: 1,
                    },
                        success: function(response){
                            // $('#view_remittance').html(response);
                            if (response == 'success') {
                                alert('Successfully Update!');
                                view_remarks();
                            }
                        }
                });
            }
        }

        //END All fucntion for remarks ------------------------------------------------------------------------------------------------------

        function update_remittance(id)
        {   
            // remit_value = document.getElementById("remit_value" + id).value;
            remit_name = document.getElementById("remit_name" + id).value;

            // alert(remit_name);
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        remit_id:id,
                        remit_name:remit_name,
                        update_remittance: 1,
                    },
                        success: function(response){
                            // $('#view_remittance').html(response);
                            if (response == 'success') {
                                alert('Successfully Update!');
                                view_remittance();
                            }
                        }
                });
            }
        }

        function delete_remittance(id)
        {   
            // alert(remit_name);
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        remit_id:id,
                        delete_remittance: 1,
                    },
                        success: function(response){
                            // $('#view_remittance').html(response);
                            if (response == 'success') {
                                alert('Successfully Deleted!');
                                view_remittance();
                            }
                        }
                });
            }
        }

        function update_information(id)
        {   
            // alert(id);
            $.ajax({
                url: 'ajax_transaction.php',
                type: 'POST',
                async: false,
                data:{
                    info_id:id,
                    update_information: 1,
                },
                    success: function(response){
                        $('#view_update_information').html(response);
                    }
            });
        }

        function delete_information(id)
        {   
            // alert(remit_name);
            if (confirm('Are you sure?')) {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        info_id:id,
                        delete_information: 1,
                    },
                        success: function(response){
                            // $('#view_remittance').html(response);
                            if (response == 'success') {
                                alert('Successfully Deleted!');
                                view_company_information();
                            }
                        }
                });
            }
        }

        function add_remittance()
        {   
            add_remittance_value = document.getElementById("add_remittance_value").value;
            add_remittance_name = document.getElementById("add_remittance_name").value;
            // alert(add_remittance_value + ' ' + add_remittance_name);

            if (confirm('Are you sure?')) {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        add_remittance_value:add_remittance_value,
                        add_remittance_name:add_remittance_name,
                        add_remittance: 1,
                    },
                        success: function(response){
                            // $('#view_remittance').html(response);
                            if (response == 'success') {
                                alert('Successfully Added!');
                                view_remittance();
                            }
                        }
                });
            }
        }

		function clear_input()
		{
			document.getElementById("currency_id").value = "";
			document.getElementById("currency_name").value = "";
			document.getElementById("currency_code").value = "";
			document.getElementById("currency_val_usd").value = "";
			document.getElementById("currency_val_php").value = "";
		}

		function edit_currency(id)
        {
            var currency_id = id.replace("edit_currency", ""); // Remove the string id "edit_currency";
			document.getElementById("currency_id").value = currency_id;
            var currency_name = document.getElementById("currency_name" + currency_id).value;
            document.getElementById("currency_name").value = currency_name; 
            var currency_code = document.getElementById("currency_code" + currency_id).value;
            document.getElementById("currency_code").value = currency_code; 
            var currency_val_usd = document.getElementById("currency_val_usd" + currency_id).value;
            document.getElementById("currency_val_usd").value = currency_val_usd; 
            var currency_val_php = document.getElementById("currency_val_php" + currency_id).value;
            document.getElementById("currency_val_php").value = currency_val_php; 
        }
        function delete_currency(id)
        {        	
            var currency_id = id.replace("delete_currency", ""); // Remove the string id "edit_currency";
            if(confirm("Are you sure you want to delete this currency?"))
            {
            	$(document).ready(function(){
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            currency_id:currency_id,
                            delete_currency: 1,
                        },
                        success: function(data){
                            alert('Currency deleted.');
                            display_currency();
                        }
                    });                
                }); 
            } 
            else  
            {  
                return false;  
            } 
        }
	</script>
	<?php }
	else
	{ ?>
		<?php
			$user_id = $row['user_id'];
			$select_contact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_created_by = '$user_id'");
			$create = mysqli_num_rows($select_contact);

			$select_assign = mysqli_query($conn, "SELECT * FROM task");
			$assign = 0;
			$finish = 0;
			while($fetct_assign = mysqli_fetch_array($select_assign))
			{				
				$str_to_array = explode(",",$fetct_assign['task_assign_to']);
				if(in_array($user_id,$str_to_array))
				{
					$assign++; // end of counting task assign to user
					$list_id = $fetct_assign['task_list_id']; // get list id
					$select_list = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$list_id' ORDER BY status_order_no DESC LIMIT 1");	
					$last = mysqli_fetch_array($select_list);
					$last_id = $last['status_id'];
					if($last_id == $fetct_assign['task_status_id']) // identify if task is done
					{
						$finish++;
					}
				}
			}

			$unfinish = $assign - $finish;
		?>

		<!-- Main Container -->
		<main id="main-container">
		    <!-- Hero -->
		    <div class="bg-image" style="background-image: url('../assets/media/photos/Team.jpg');">
		        <div class="bg-black-op">
		            <div class="content content-top content-full text-center">
		                <h2 class="h4 text-white-op mb-0 mt-0">IPASS processing..</h2>
		            </div>
		        </div>
		    </div>
		    <!-- END Hero -->
		    <!-- Page Content -->
		    <div class="content <?php echo $md_content; ?>">
		        <!-- Statistics -->
		        <div class="row gutters-tiny">
		            <!-- Orders -->
		            <div class="col-md-6 col-xl-3">
		                <a class="block block-rounded block-transparent <?php echo $sq_member; ?>" href="javascript:void(0)">
		                    <div class="block-content block-content-full block-sticky-options">
		                        <div class="block-options">
		                            <div class="block-options-item">
		                                <i class="fa fa-tasks fa-2x text-white-op"></i>
		                            </div>
		                        </div>
		                        <div class="py-20 text-center">
		                            <div class="font-size-h2 font-w700 mb-0 text-white" data-toggle="countTo" data-to="<?php echo $assign; ?>">0</div>
		                            <div class="font-size-sm font-w600 text-uppercase text-white-op">Assigned task</div>
		                        </div>
		                    </div>
		                </a>
		            </div>
		            <!-- END Orders -->

		            <!-- Earnings -->
		            <div class="col-md-6 col-xl-3">
		                <a class="block block-rounded block-transparent <?php echo $sq_inbox; ?>" href="javascript:void(0)">
		                    <div class="block-content block-content-full block-sticky-options">
		                        <div class="block-options">
		                            <div class="block-options-item">
		                                <i class="fa fa-address-card-o fa-2x text-white-op"></i>
		                            </div>
		                        </div>
		                        <div class="py-20 text-center">
		                            <div class="font-size-h2 font-w700 mb-0 text-white" data-toggle="countTo" data-to="<?php echo $create; ?>">0</div>
		                            <div class="font-size-sm font-w600 text-uppercase text-white-op">Contact created</div>
		                        </div>
		                    </div>
		                </a>
		            </div>
		            <!-- END Earnings -->

		            <!-- Conversion Rate -->
		            <div class="col-md-6 col-xl-3">
		                <a class="block block-rounded block-transparent <?php echo $sq_task; ?>" href="javascript:void(0)">
		                    <div class="block-content block-content-full block-sticky-options">
		                        <div class="block-options">
		                            <div class="block-options-item">
		                            	<i class="fa fa-spinner fa-2x fa-spin text-white-op"></i>
		                            </div>
		                        </div>
		                        <div class="py-20 text-center">
		                            <div class="font-size-h2 font-w700 mb-0 text-white" data-toggle="countTo" data-to="<?php echo $unfinish; ?>">0</div>
		                            <div class="font-size-sm font-w600 text-uppercase text-white-op">Unfinish task</div>
		                        </div>
		                    </div>
		                </a>
		            </div>
		            <!-- END Conversion Rate -->

		            <!-- New Customers -->
		            <div class="col-md-6 col-xl-3">
		                <a class="block block-rounded block-transparent <?php echo $sq_contact; ?>" href="javascript:void(0)">
		                    <div class="block-content block-content-full block-sticky-options">
		                        <div class="block-options">
		                            <div class="block-options-item">
		                                <i class="fa fa-flag-checkered fa-2x text-white-op"></i>
		                            </div>
		                        </div>
		                        <div class="py-20 text-center">
		                            <div class="font-size-h2 font-w700 mb-0 text-white" data-toggle="countTo" data-to="<?php echo $finish; ?>">0</div>
		                            <div class="font-size-sm font-w600 text-uppercase text-white-op">Finish task</div>
		                        </div>
		                    </div>
		                </a>
		            </div>
		            <!-- END New Customers -->
		        </div>
		        <!-- END Statistics -->
		        <h2 class="content-heading <?php echo $md_text; ?>">Table</h2>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="block block-rounded shadow">
                                <div class="block-header block-header-default <?php echo $md_table_header; ?>">
                                    <h3 class="block-title <?php echo $md_text; ?>">Contact Created</h3>
                                    <div class="block-options">
                                        <!-- To toggle block's content, just add the following properties to your button: data-toggle="block-option" data-action="content_toggle" -->
                                        <button type="button" class="btn-block-option <?php echo $md_text; ?>" data-toggle="block-option" data-action="content_toggle"></button>
                                    </div>
                                </div>
                                <div class="block-content block-content-full <?php echo $md_table_body; ?>">
                                	<table class="table table-bordered table-striped table-vcenter js-dataTable-full <?php echo $table; ?>">
		                                <thead>
		                                    <tr>
		                                        <th class="text-center">ID</th>
		                                        <th>Name</th>
		                                        <th class="d-none d-sm-table-cell">Email</th>
		                                        <th class="d-none d-sm-table-cell">Contact</th>
		                                        <th class="text-center" style="width: 15%;">Profile</th>
		                                    </tr>
		                                </thead>
		                                <tbody>
		                                	<?php
		                                		while($fetch_contact = mysqli_fetch_array($select_contact))
		                                		{
		                                			echo '		                                			
				                                    <tr>
				                                        <td class="text-center">'.$fetch_contact['contact_id'].'</td>
				                                        <td class="font-w600">
															<a href="main_contact_details.php?contact_id='.$fetch_contact['contact_id'].'">'.$fetch_contact['contact_fname'].' '.$fetch_contact['contact_mname'].' '.$fetch_contact['contact_lname'].'</a>
				                                        </td>
				                                        <td class="d-none d-sm-table-cell">'.$fetch_contact['contact_email'].'</td>
				                                        <td class="d-none d-sm-table-cell">'.$fetch_contact['contact_cpnum'].'</td>
				                                        <td class="text-center">';
				                                        if($fetch_contact['contact_profile'] != "")
				                                        {
				                                        	echo'<img style="width: 37px; border-radius:50px;" src="../client/client_profile/'.$fetch_contact['contact_profile'].'">';
				                                        }
				                                    	else
				                                    	{
				                                    		echo'<img style="width: 37px; border-radius:50px;" src="../assets/media/photos/avatar.jpg">';
				                                    	}
				                                        echo'
				                                        </td>
				                                    </tr>
		                                			';
		                                		}
		                                	?>
		                                </tbody>
		                            </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="block block-rounded shadow">
                                <div class="block-header block-header-default <?php echo $md_table_header; ?>">
                                    <h3 class="block-title <?php echo $md_text; ?>">Assigned task</h3>
                                    <div class="block-options">
                                        <!-- To toggle block's content, just add the following properties to your button: data-toggle="block-option" data-action="content_toggle" -->
                                        <button type="button" class="btn-block-option <?php echo $md_text; ?>" data-toggle="block-option" data-action="content_toggle"></button>
                                    </div>
                                </div>
                                <div class="block-content block-content-full <?php echo $md_table_body; ?>">
                                	<table class="table table-bordered table-striped table-vcenter js-dataTable-full <?php echo $table; ?>">
		                                <thead>
		                                    <tr>
		                                        <th class="text-center">ID</th>
		                                        <th>Name</th>
		                                        <th class="d-none d-sm-table-cell">Due_Date</th>
		                                        <th class="d-none d-sm-table-cell">Priority</th>
		                                        <th class="d-none d-sm-table-cell">Space</th>
		                                        <th class="d-none d-sm-table-cell">List</th>
		                                        <th class="text-center" style="width: 15%;">Status</th>
		                                    </tr>
		                                </thead>
		                                <tbody>
		                                	<?php
		                                		$select_task_assign = mysqli_query($conn, "SELECT * FROM task");
		                                		while($fetct_task_assign = mysqli_fetch_array($select_task_assign))
												{
													$task_status_id = $fetct_task_assign['task_status_id'];
						                            $task_list_id = $fetct_task_assign['task_list_id']; // get list id
						                            $task_id = $fetct_task_assign['task_id'];

													$select_list = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$task_list_id'");
                            						$list_name = mysqli_fetch_array($select_list);

													$str_to_array = explode(",",$fetct_task_assign['task_assign_to']);
													if(in_array($user_id,$str_to_array))
													{
			                                			echo '		                                			
					                                    <tr style="cursor: pointer;" id="taskid_'.$fetct_task_assign['task_id'].'" onclick="view_task(this.id)">
					                                        <td class="text-center">'.$fetct_task_assign['task_id'].'</td>
					                                        <td class="font-w600">'.$fetct_task_assign['task_name'].'';
														    	$total_tag_per_task = $fetct_task_assign['task_tag'];
														        $tag_array = explode(",", $total_tag_per_task); // convert string to array
														        $count_tag = count($tag_array);
														        if ($total_tag_per_task == "") 
														        {}
														        else
														        {                
														            for ($x = 1; $x <= $count_tag; $x++)
														            {
														                $y = $x - 1;
														                $final_tag_name = $tag_array[$y];
														                $get_tag_color = mysqli_query($conn, "SELECT * FROM tags WHERE tag_id = '$final_tag_name'");
														                $result_get_tag_color = mysqli_fetch_array($get_tag_color);
														                echo'<span style="background-color: '.$result_get_tag_color['tag_color'].'; color:#fff; padding:2px 7px 2px 5px; border-top-right-radius: 25px; border-bottom-right-radius: 25px; font-size: 11px; margin: 0px 0px 0px 5px;">'.$result_get_tag_color['tag_name'].' </span>'; 
														            }                                                        
														        }
															    echo '
															</td>
					                                        <td class="d-none d-sm-table-cell">'.$fetct_task_assign['task_due_date'].'</td>
					                                        <td class="d-none d-sm-table-cell">';
					                                        if($fetct_task_assign['task_priority'] == "D Urgent")
					                                        {
					                                        	echo '<span style="display: none;">D</span><span class="badge badge-danger">Urgent</span>';
					                                        }
					                                        else if($fetct_task_assign['task_priority'] == "C High")
					                                        {
					                                        	echo '<span style="display: none;">C</span><span class="badge badge-warning">High</span>';
					                                        }	
					                                        else if($fetct_task_assign['task_priority'] == "B Normal")
					                                        {
					                                        	echo '<span style="display: none;">B</span><span class="badge badge-primary">Normal</span>';
					                                        }
					                                        else if($fetct_task_assign['task_priority'] == "A Low")
					                                        {
					                                        	echo '<span style="display: none;">A</span><span class="badge badge-secondary">Low</span>';
					                                        }
					                                        else
					                                        {}
					                                        echo'
					                                        <td class="d-none d-sm-table-cell">';
								                                $list_space_id = $list_name['list_space_id'];
								                                $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$list_space_id'");
								                                $fetch_space = mysqli_fetch_array($select_space);

								                                $space_name = $fetch_space['space_name'];
								                                echo '<input type="hidden" id="spacename'.$task_id.'" value="'.$space_name.'">';

								                                $new_name = substr($space_name, 0, 15); // get only 10 character
								                                if(strlen($space_name) > 15)
								                                {
								                                    echo $new_name."...";
								                                }
								                                else
								                                {
								                                    echo $space_name;
								                                }
								                                echo'
								                            </td>
					                                        <td class="d-none d-sm-table-cell">';
								                                $list_name = $list_name['list_name'];
								                                echo '<input type="hidden" id="listname'.$task_id.'" value="'.$list_name.'">';
                                								echo '<input type="hidden" id="listid'.$task_id.'" value="'.$task_list_id.'">';

								                                $new__list_name = substr($list_name, 0, 12); // get only 10 character
								                                if(strlen($list_name) > 12)
								                                {
								                                    echo $new__list_name."...";
								                                }
								                                else
								                                {
								                                    echo $list_name;
								                                }
								                                echo'
					                                        </td>';
															$task_status_id = $fetct_task_assign['task_status_id'];
															$select_status = mysqli_query($conn, "SELECT * FROM status WHERE status_id = '$task_status_id'");
															$fetch_status_name = mysqli_fetch_array($select_status);

															$task_list_id = $fetct_task_assign['task_list_id']; // get list id
															$select_task_list_id = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$task_list_id' ORDER BY status_order_no DESC LIMIT 1");	
															$last_status = mysqli_fetch_array($select_task_list_id);
															$last_status_id = $last_status['status_id'];
															if($last_status_id == $fetct_task_assign['task_status_id']) // identify if task is done
															{
																echo '<td class="text-center text-white bg-gd-sea">Finish</td>';
															}
															else
															{
																echo '<td class="text-center text-white" style="background-color: '.$fetch_status_name['status_color'].';">'.$fetch_status_name['status_name'].'</td>';
															}
					                                        echo'
					                                    </tr>
			                                			';
		                                			}
		                                		}
		                                	?>
		                                </tbody>
		                            </table>                                	
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div class="row row-deck">
			            <div class="col-lg-12">
			                <div class="block block-rounded shadow bg-gray-darker">
			                    <div class="block-header content-heading bg-gray-darker">
			                        <h3 class="block-title text-white d-none d-sm-block" style="cursor: pointer;" id="hide_show_list_of_email_member">List of Email <i class="si si-arrow-down"></i> </h3>
			                    </div>
			                </div>
			            </div>
			        </div>

                    <div class="block-content <?php echo $md_table_body;?> mb-20" id="list_of_email_member"></div> -->
		    </div>
		    <!-- END Page Content -->
		</main>
		<!-- END Main Container -->
	<?php }
?>

<script type="text/javascript">
	view_list_of_email_member();

    function view_task(id)
    {
        new_id = id.replace("taskid_", "");
        space_name = document.getElementById("spacename" + new_id).value;
        list_name = document.getElementById("listname" + new_id).value;
        list_id = document.getElementById("listid" + new_id).value;

        document.location = 'main_dashboard.php?space_name='+space_name+'&list_name='+list_name+'&list_id='+list_id+'&get_task_id='+new_id+'';
    }

     $(document).ready(function(){
		  $("#hide_show_list_of_email_member").click(function(){
		    $("#list_of_email_member").slideToggle("slow");
		  });
		});

        function view_list_of_email_member()
        {
            $.ajax({
                url: 'ajax_transaction.php',
                type: 'POST',
                async: false,
                data:{
                    view_list_of_email_member: 1,
                },
                    success: function(response){
                        $('#list_of_email_member').html(response);
                    }
            });
        }

       	function set_list_of_email_member(id)
        {
        	// alert(id);
        	if (confirm('Are you sure?')) {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        set_email:id,
                        set_list_of_email: 1,
                    },
                        success: function(response){
                            // $('#view_remittance').html(response);
                            if (response == 'success') {
                                alert('Successfully Set!');
                                view_list_of_email_member();
                            }
                        }
                });
            }
        }
</script>