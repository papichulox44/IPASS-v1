<?php
    $user_type = $row['user_type'];
    $filter = $_GET['filter'];
    $view = $_GET['view'];

    if($filter == "Custom Date")
    {
        $from = $_GET['From'];
        $to = $_GET['To'];
    }
    else
    {
        $from = "";
        $to = "";
    }

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

<style type="text/css">
    .filterchild{
        display: none;
    }
    .filterparent
    {
        cursor: pointer;
    }
    .filterparent:hover .filterchild {
        display: block;
    }
    .hov_row:hover{
        cursor: pointer;
    }
</style>

        <!-- Main Container -->
        <main id="main-container">
            <!-- Page Content -->
            <div class="content">
                <!-- ALL transaction -->
                <div class="row row-deck">
                    <div class="col-lg-12">
                        <div class="block block-rounded shadow <?php echo $md_table_header; ?>">
                            <div class="block-header content-heading <?php echo $md_table_header; ?>">
                                <h3 class="block-title <?php echo $md_table_title; ?> d-none d-sm-block">Transaction</h3>

                                <div class="dropdown float-right">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle mr-5" id="ecom-orders-overview-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="View">
                                        <span id="view_by">View</span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-overview-drop" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 31px, 0px);">
                                        <button class="dropdown-item" id="All Remarks" onclick="view_remarks(this.id)">
                                           All Remarks
                                            <!-- <i class="fa fa-fw fa-check mr-5"></i>All Remarks -->
                                        </button>
                                        <button class="dropdown-item" id="No Remarks" onclick="view_remarks(this.id)">
                                           No Remarks
                                            <!-- <i class="fa fa-fw fa-check mr-5"></i>All Remarks -->
                                        </button>
                                        <?php 
                                        $query = mysqli_query($conn, "SELECT * FROM tbl_remarks");

                                        while ($data = mysqli_fetch_array($query)) {
                                         ?>
                                        <button class="dropdown-item" id="<?php echo $data['remarks_value']; ?>" onclick="view_remarks(this.id)">
                                           <?php echo $data['remarks_value']; ?>
                                            <!-- <i class="fa fa-fw fa-check mr-5"></i>All Remarks -->
                                        </button>
                                        <?php } ?>
                                        <!-- <button class="dropdown-item" onclick="view_no_remarks()">
                                            <i class="fa fas fa-times mr-5"></i>No Remarks
                                        </button>
                                        <button class="dropdown-item" onclick="view_payment()">
                                            <i class="fa fa-credit-card mr-5"></i>Payment Received
                                        </button>
                                        <button class="dropdown-item" onclick="view_encoded()">
                                            <i class="fa fa-credit-card-alt mr-5"></i>Payment encoded
                                        </button>
                                        <button class="dropdown-item" onclick="view_on_hold()">
                                            <i class="fa fa-tasks mr-5"></i>On Hold
                                        </button>
                                        <button class="dropdown-item" onclick="view_pending()">
                                            <i class="fa fa-square mr-5"></i>Pending
                                        </button>
                                        <button class="dropdown-item" onclick="view_waiting()">
                                            <i class="fa fa-sliders mr-5"></i>Waiting to be Received
                                        </button>
                                        <button class="dropdown-item" onclick="view_refunded()">
                                            <i class="fa fa-folder-open mr-5"></i>Refunded
                                        </button> -->
                                    </div>
                                </div>

                                <div class="dropdown float-right">
                                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-overview-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Filter">
                                        <span id="filterby"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-overview-drop" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 31px, 0px);">
                                        <button class="dropdown-item" onclick="filter_tran_all()">
                                            <i class="fa fa-fw fa-circle-o mr-5"></i>All
                                        </button>
                                        <span class="filterparent">
                                            <form class="dropdown-item filterparent">
                                                <i class="fa fa-fw fa-calendar mr-5"></i>Custom Date
                                            </form>
                                            <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 45px; right: 120px;">
                                                <label for="example-datepicker4">Custom date</label>
                                                <div class="form-material">
                                                    <input type="date" class="js-datepicker form-control" id="txt_date_from" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                                    <label for="example-datepicker4">From:</label>
                                                </div>
                                                <div class="form-material">
                                                    <input type="date" class="js-datepicker form-control" id="txt_date_to" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                                    <label for="example-datepicker4">To:</label>
                                                </div>
                                                <div class="form-material">
                                                    <button class="btn btn-sm btn-noborder btn-alt-primary btn-block" onclick="filter_tran_custom()"><i class="fa fa-check-square-o"></i> Go</button>
                                                </div>
                                            </div>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Transaction Page table -->
                            <div style="overflow-x:auto;" class="block-content <?php echo $md_table_body;?> mb-20" id="view_transaction"></div>
                            <!-- End Transaction Page table -->


                             <div class="modal fade" id="modal-remarks" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
                                <div class="modal-dialog modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="block block-themed block-transparent mb-0">
                                            <div class="block-header bg-primary-dark">
                                                <h3 class="block-title">Remarks</h3>
                                                <div class="block-options">
                                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                        <i class="si si-close"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div  class="block-content" id="fetch_remarks" style="height: 100%;">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="modal-trans-details" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true" data-backdrop="static">
                               <div class="modal-dialog modal-xl" role="document">
                                   <div class="modal-content">
                                       <div class="block block-themed block-transparent mb-0">
                                           <div class="block-header bg-primary-dark">
                                               <h3 class="block-title">Transaction Details</h3>
                                               <div class="block-options">
                                                   <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                                       <i class="si si-close"></i>
                                                   </button>
                                               </div>
                                           </div>
                                           <div class="block-content" id="fetch_per_transaction">

                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
        <!-- END Large Modal -->



                        </div>
                    </div>
                </div>
                <!-- END ALL transaction -->

            </div>
            <!-- END Page Content -->
        </main>
        <!-- END Main Container -->

    <script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
    <script>
        document.getElementById("view_by").innerHTML = "<?php echo $view;?>";
        var view_by = document.getElementById("view_by").innerHTML;
        document.getElementById("filterby").innerHTML = "<?php echo $filter;?>";
        var filterby = document.getElementById("filterby").innerHTML;
        var get_from = "<?php echo $from; ?>";
        var get_to = "<?php echo $to; ?>";

        if(view_by == "All Remarks")
        { 
            view_all_transaction();
        }
        else
        { 
            view_all_transaction(); 
        }


        // VIEW ALL TRANSACTION --------------------------
        function view_all_transaction()
        {
            md_mode = "<?php echo $mode_type; ?>";
            filterby = document.getElementById("filterby").innerHTML;


            $.ajax({
                url: 'ajax_transaction.php',
                type: 'POST',
                async: false,
                data:{
                    view_by:view_by,
                    md_mode:md_mode,
                    filterby:filterby,
                    get_from:get_from,
                    get_to:get_to,
                    view_all_transaction: 1,
                },
                    success: function(response){
                        $('#view_transaction').html(response);
                    }
            });
        }
        // END VIEW ALL TRANSACTION -------------------------

        // VIEW BY --------------------------
        function view_remarks(id)
        {
            document.getElementById("view_by").innerHTML = "id";
            if(filterby == "Custom Date")
            { document.location='main_transaction.php?view=All Remarks&filter='+filterby+'&From='+get_from+'&To='+get_to+''; }
            else { document.location='main_transaction.php?view='+id+'&filter=' + filterby + ''; }
        }
        // function view_all_remarks()
        // {
        //     document.getElementById("view_by").innerHTML = "All Remarks";
        //     if(filterby == "Custom Date")
        //     { document.location='main_transaction.php?view=All Remarks&filter='+filterby+'&From='+get_from+'&To='+get_to+''; }
        //     else { document.location='main_transaction.php?view=All Remarks&filter=' + filterby + ''; }
        // }
        // function view_no_remarks()
        // {
        //     document.getElementById("view_by").innerHTML = "No Remarks";
        //     if(filterby == "Custom Date")
        //     { document.location='main_transaction.php?view=No Remarks&filter='+filterby+'&From='+get_from+'&To='+get_to+''; }
        //     else { document.location='main_transaction.php?view=No Remarks&filter=' + filterby + ''; }
        // }
        // function view_payment()
        // {
        //     document.getElementById("view_by").innerHTML = "Payment Received";
        //     if(filterby == "Custom Date")
        //     { document.location='main_transaction.php?view=Payment Received&filter='+filterby+'&From='+get_from+'&To='+get_to+''; }
        //     else { document.location='main_transaction.php?view=Payment Received&filter=' + filterby + ''; }
        // }
        // function view_on_hold()
        // {
        //     document.getElementById("view_by").innerHTML = "On Hold";
        //     if(filterby == "Custom Date")
        //     { document.location='main_transaction.php?view=On Hold&filter='+filterby+'&From='+get_from+'&To='+get_to+''; }
        //     else { document.location='main_transaction.php?view=On Hold&filter=' + filterby + ''; }
        // }
        // function view_pending()
        // {
        //     document.getElementById("view_by").innerHTML = "Pending";
        //     if(filterby == "Custom Date")
        //     { document.location='main_transaction.php?view=Pending&filter='+filterby+'&From='+get_from+'&To='+get_to+''; }
        //     else { document.location='main_transaction.php?view=Pending&filter=' + filterby + ''; }
        // }
        // function view_waiting()
        // {
        //     document.getElementById("view_by").innerHTML = "Waiting to be Received";
        //     if(filterby == "Custom Date")
        //     { document.location='main_transaction.php?view=Waiting to be Received&filter='+filterby+'&From='+get_from+'&To='+get_to+''; }
        //     else { document.location='main_transaction.php?view=Waiting to be Received&filter=' + filterby + ''; }
        // }
        // function view_refunded()
        // {
        //     document.getElementById("view_by").innerHTML = "Refunded";
        //     if(filterby == "Custom Date")
        //     { document.location='main_transaction.php?view=Refunded&filter='+filterby+'&From='+get_from+'&To='+get_to+''; }
        //     else { document.location='main_transaction.php?view=Refunded&filter=' + filterby + ''; }
        // }
        // function view_encoded()
        // {
        //     document.getElementById("view_by").innerHTML = "Payment encoded";
        //     if(filterby == "Custom Date")
        //     { document.location='main_transaction.php?view=Payment encoded&filter='+filterby+'&From='+get_from+'&To='+get_to+''; }
        //     else { document.location='main_transaction.php?view=Payment encoded&filter=' + filterby + ''; }
        // }
        // END VIEW BY --------------------------

        // FILTER BY --------------------------
        function filter_tran_all()
        {
            document.getElementById("filterby").innerHTML = "All";
            document.location='main_transaction.php?view=' + view_by + '&filter=All';
        }
        function filter_tran_custom()
        {
            document.getElementById("filterby").innerHTML = "Custom Date";
            date_from = document.getElementById("txt_date_from").value;
            date_to = document.getElementById("txt_date_to").value;
            if(date_from == "")
            {
                alert("Please select date range from.");
            }
            else if(date_to == "")
            {
                alert("Please select date range to.");
            }
            else
            {
                document.location='main_transaction.php?view=' + view_by + '&filter=Custom Date&From='+date_from+'&To='+date_to;
            }
        }
        // END FILTER BY --------------------------

        function update_remarks(id)
        {

            array_id = id.split(",");

            phase_id = array_id[0];
            task_id = array_id[1];
            remarks = array_id[2];
            val_id = array_id[3];
            user_id = <?php echo $_SESSION['user']; ?>

            // alert(val_id);
            $.ajax({
                url: 'ajax_transaction.php',
                type: 'POST',
                async: false,
                data:{
                    phase_id: phase_id,
                    task_id: task_id,
                    remarks:remarks,
                    user_id:user_id,
                    val_id:val_id,
                    update_remarks: 1,
                },
                    success: function(response){
                        $('#fetch_remarks').html(response);
                    }
            });
        }

        function update_remarks_selected(select)
        {

            remarks_value = (select.options[select.selectedIndex].value);
            val_id = document.getElementById("val_id").value;
            // task_id = document.getElementById("task_id").value;

            // alert(val_id);
            $.ajax({
                url: 'ajax_transaction.php',
                type: 'POST',
                async: false,
                data:{
                    val_id: val_id,
                    remarks_value: remarks_value,
                    update_remarks_selected: 1,
                },
                    success: function(response){
                        // view_all_transaction();
                        alert('Update Successfully');
                        location.reload()
                        // $('#modal-remarks').modal('hide');
                        // view_all_transaction();
                    }
            });
        }

        function add_remarks(id)
        {

            array_id = id.split(",");

            phase_id = array_id[0];
            task_id = array_id[1];
            user_id = <?php echo $_SESSION['user']; ?>

            $.ajax({
                url: 'ajax_transaction.php',
                type: 'POST',
                async: false,
                data:{
                    phase_id: phase_id,
                    task_id: task_id,
                    user_id:user_id,
                    add_remarks: 1,
                },
                    success: function(response){
                        $('#fetch_remarks').html(response);
                    }
            });
        }

        function add_remarks_selected(select)
        {

            remarks_value = (select.options[select.selectedIndex].value);
            phase_id = document.getElementById("phase_id").value;
            task_id = document.getElementById("task_id").value;
            user_id = document.getElementById("user_id").value;

            $.ajax({
                url: 'ajax_transaction.php',
                type: 'POST',
                async: false,
                data:{
                    phase_id: phase_id,
                    task_id: task_id,
                    remarks_value: remarks_value,
                    user_id:user_id,
                    add_remarks_selected: 1,
                },
                    success: function(response){
                        alert('Add Successfully');
                        location.reload()
                    }
            });
        }

        function hide_show(id)
        {
            array_id = id.split(",");

            phase_id = array_id[0];
            task_id = array_id[1];
            remarks = array_id[2];
            field_id = array_id[3];
            user_id = array_id[4];

            if(confirm("Are you sure?"))
            {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        user_id: user_id,
                        task_id: task_id,
                        field_id: field_id,
                        hide_show: 1,
                    },
                        success: function(response){

                          if (remarks == 'No Remarks') {
                            add_remarks(id)
                          }
                          else
                          {
                            update_remarks(id);
                          }
                        }
                });
            }
        }

        function update_amount_usd(id)
        {
            array_id = id.split(",");

            phase_id = array_id[0];
            task_id = array_id[1];//2
            remarks = array_id[2];
            field_id = array_id[3];//3
            user_id = array_id[4];//1

            amount_usd = document.getElementById("amount_usd" + id).value;//4

            // alert(user_id+' '+task_id+' '+field_id+' '+amount_usd);
            if(confirm("Are you sure?"))
            {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        user_id: user_id,
                        task_id: task_id,
                        field_id: field_id,
                        amount_usd:amount_usd,
                        update_amount_usd: 1,
                    },
                        success: function(response){

                          if (remarks == 'No Remarks') {
                            add_remarks(id)
                          }
                          else
                          {
                            update_remarks(id);
                          }
                        }
                });
            }
        }

        function transaction_details(id)
        {
          transaction_id = id;
          $.ajax({
              url: 'ajax_transaction.php',
              type: 'POST',
              async: false,
              data:{
                  transaction_id: transaction_id,
                  fetch_per_transaction: 1,
              },
                  success: function(response){
                      $('#fetch_per_transaction').html(response);
                  }
          });
        }

        function update_discount()
        {
            disc_id = document.getElementById("disc_id").value;
            disc_amount = document.getElementById("disc_amount").value;
            user_id = <?php echo $_SESSION['user'] ?>;
            phase_id = document.getElementById("phase_id").value;
            task_id = document.getElementById("task_id").value;

            // alert(phase_id+' '+task_id+' '+user_id);
            $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: false,
            data:{
                disc_id:disc_id,
                disc_amount:disc_amount,
                user_id:user_id,
                phase_id:phase_id,
                task_id:task_id,
                add_discount:1,
            },
                success: function(response){
                  alert(response);
                }
            });
        }

        function update_transac()
        {
            val_id = document.getElementById("val_id").value;
            tran_date = document.getElementById("tran_date").value;
            tran_method = document.getElementById("tran_method").value;
            tran_transaction_no = document.getElementById("tran_transaction_no").value;
            tran_amount = document.getElementById("tran_amount").value;
            tran_charge = document.getElementById("tran_charge").value;
            tran_charge_type = document.getElementById("tran_charge_type").value;
            tran_client_rate = document.getElementById("tran_client_rate").value;
            tran_currency = document.getElementById("tran_currency").value;
            tran_note = document.getElementById("tran_note").value;
            file_trans = document.getElementById("tran_attachment").value;
            val_attachment = document.getElementById("val_attachment").value;
            update_transaction = 1;

            tran_initial = document.getElementById("tran_initial").value;
            tran_usd_rate = document.getElementById("tran_usd_rate").value;
            tran_usd_total = document.getElementById("tran_usd_total").value;
            tran_php_rate = document.getElementById("tran_php_rate").value;
            tran_php_total = document.getElementById("tran_php_total").value;
            tran_client_php_total = document.getElementById("tran_client_php_total").value;

            if (file_trans == "")
                {
                    $.ajax({
                    url: 'ajax.php',
                    type: 'POST',
                    async: false,
                    data:{
                        val_id:val_id,
                        tran_date:tran_date,
                        tran_method:tran_method,
                        tran_transaction_no:tran_transaction_no,
                        tran_amount:tran_amount,
                        tran_charge:tran_charge,
                        tran_charge_type:tran_charge_type,
                        tran_client_rate:tran_client_rate,
                        tran_currency:tran_currency,
                        tran_note:tran_note,
                        update_transaction:update_transaction,
                        file_attachment:file_trans,
                        tran_initial:tran_initial,
                        tran_usd_rate:tran_usd_rate,
                        tran_usd_total:tran_usd_total,
                        tran_php_rate:tran_php_rate,
                        tran_php_total:tran_php_total,
                        tran_client_php_total:tran_client_php_total,
                    },
                        success: function(data)
                        {
                            if(data == "success")
                            {
                                alert("Transaction Details Successfully Update!");
                                location.reload();
                            }
                        }
                    });
                }
            else
                {

                    tran_attachment = $('#tran_attachment');
                    file_attachment = tran_attachment.prop('files')[0];

                    formData = new FormData();
                    formData.append('val_id', val_id);
                    formData.append('tran_date', tran_date);
                    formData.append('tran_method', tran_method);
                    formData.append('tran_transaction_no', tran_transaction_no);
                    formData.append('tran_amount', tran_amount);
                    formData.append('tran_charge', tran_charge);
                    formData.append('tran_charge_type', tran_charge_type);
                    formData.append('tran_client_rate', tran_client_rate);
                    formData.append('tran_currency', tran_currency);
                    formData.append('tran_note', tran_note);
                    formData.append('file_attachment', file_attachment);
                    formData.append('tran_initial', tran_initial);
                    formData.append('tran_usd_rate', tran_usd_rate);
                    formData.append('tran_usd_total', tran_usd_total);
                    formData.append('tran_php_rate', tran_php_rate);
                    formData.append('tran_php_total', tran_php_total);
                    formData.append('tran_client_php_total', tran_client_php_total);
                    formData.append('val_attachment', val_attachment);
                    formData.append('update_transaction_with_picture', 1);

                     $.ajax({
                        url: 'ajax.php',
                        type: 'POST',
                        async: false,
                        data: formData,

                        contentType:false,
                        cache: false,
                        processData: false,
                            success: function(response)
                            {
                                if(response == "success")
                                {
                                    alert("Transaction Details Successfully Update!");
                                    location.reload();
                                }
                            }
                        });
                }
        }

        function currency_select(select)
        {
            currency_val = (select.options[select.selectedIndex].value); // get currency

            amount = document.getElementById("tran_amount");
            tran_charge = document.getElementById("tran_charge");
            tran_charge_type = document.getElementById("tran_charge_type");
            tran_client_rate = document.getElementById("tran_client_rate");
            tran_initial = document.getElementById("tran_initial");
            tran_usd_rate = document.getElementById("tran_usd_rate");
            tran_usd_total = document.getElementById("tran_usd_total");
            tran_php_rate = document.getElementById("tran_php_rate");
            tran_php_total = document.getElementById("tran_php_total");
            tran_client_php_total = document.getElementById("tran_client_php_total");

            // amount.readOnly = true;
            // tran_charge.readOnly = true;
            // tran_charge_type.disabled = true;
            // tran_client_rate.readOnly = true;
            <?php
                $currency_option = mysqli_query($conn, "SELECT * FROM finance_currency ORDER BY currency_name ASC");
                while($fetch = mysqli_fetch_array($currency_option))
                {
                    $currency_code = $fetch['currency_code'];
                    $currency_val_usd = $fetch['currency_val_usd'];
                    $currency_val_php = $fetch['currency_val_php'];
                    ?>
                    var code = "<?php echo $currency_code; ?>";
                    if(currency_val == code)
                    {
                        document.getElementById("tran_usd_rate").value = "<?php echo $currency_val_usd; ?>";
                        document.getElementById("tran_php_rate").value = "<?php echo $currency_val_php; ?>";

                        if(tran_charge_type.value == "PHP") // if charge type == PHP
                        {
                            if(code == "PHP")
                            {
                                tran_initial.value = (amount.value - tran_charge.value).toFixed(2);
                            }
                            else
                            {
                                tran_initial.value = (amount.value - (tran_charge.value / tran_php_rate.value)).toFixed(2);
                            }
                        }
                        else if(tran_charge_type.value == "USD")// else if charge type == USD
                        {
                            if(code == "USD")
                            {
                                tran_initial.value = (amount.value - tran_charge.value).toFixed(2);
                            }
                            else if(code == "PHP")
                            {
                                tran_initial.value = (amount.value - (tran_charge.value * tran_usd_rate.value)).toFixed(2);
                            }
                            else
                            {
                                tran_initial.value = (amount.value - (tran_charge.value / tran_usd_rate.value)).toFixed(2);
                            }
                        }
                        else
                        {
                            tran_initial.value = (amount.value - tran_charge.value).toFixed(2);
                        }

                        tran_client_php_total.value = (tran_initial.value * tran_client_rate.value).toFixed(2);
                        if(code == "PHP")
                        {
                            tran_usd_total.value = (tran_initial.value / tran_usd_rate.value).toFixed(2);
                            tran_php_total.value = (tran_initial.value * tran_php_rate.value).toFixed(2);
                        }
                        else
                        {
                            tran_usd_total.value = (tran_initial.value * tran_usd_rate.value).toFixed(2);
                            tran_php_total.value = (tran_initial.value * tran_php_rate.value).toFixed(2);
                        }
                    }
                    <?php
                }
            ?>
        }

        function zoomin() {
            // alert('Nag zoom in');
          var myImg = document.getElementById("map");
          var currWidth = myImg.clientWidth;
          if (currWidth == 2500) return false;
          else {
            myImg.style.width = (currWidth + 100) + "px";
            // myImg.style.height = (currWidth + 100) + "px";
          }
        }

        function zoomout() {
            // alert('Nag zoom out');
          var myImg = document.getElementById("map");
          var currWidth = myImg.clientWidth;
          if (currWidth == 100) return false;
          else {
            myImg.style.width = (currWidth - 100) + "px";
            // myImg.style.height = (currWidth - 100) + "px";
          }
        } 

        function rotateImage() {
            // alert('Nag rotate');
          myImg = document.getElementById("map");
          // var currRotate = getCurrentRotation(myImg);


          currRotate = 0;
          currRotate = myImg.style.transform;
          if (currRotate == 'rotate(90deg)'){
            currRotate = 90;
          }
          if (currRotate == 'rotate(180deg)'){
            currRotate = 180;
          }
          if (currRotate == 'rotate(270deg)'){
            currRotate = 270;
          }
          if (currRotate == 'rotate(360deg)'){
            currRotate = 360;
          }
          if (currRotate == 'rotate(450deg)'){
            currRotate = 0;
          }
          total = (currRotate + 90);
          if (currRotate == 10000) return false;
          else {

            myImg.style.transform = "rotate("+(total) + "deg)";
            // myImg.style.height = (currWidth - 100) + "px";
          }
        } 

        function delete_transaction(id)
        {
          array_id = id.split(",");
          val_id = array_id[0];
          phase_id = array_id[1];
          transaction_no = array_id[2];
          task_id = array_id[3];

          // alert(id);

          if(confirm("Are you sure you want to delete this transaction?"))
            {
                $.ajax({
                    url: 'ajax_transaction.php',
                    type: 'POST',
                    async: false,
                    data:{
                        val_id:val_id,
                        phase_id:phase_id,
                        transaction_no:transaction_no,
                        task_id:task_id,
                        delete_transaction:1,
                    },
                        success: function(response){
                          if (response == 'success') {
                            alert('Transaction Successfully Deleted!!');
                            $("#modal-trans-details").modal('hide');
                            view_all_transaction(); 
                          }
                        }
                    });
            }
        }
    </script>
