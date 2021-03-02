<?php
    $md_content = "";
    $md_text = "text-muted";
    $md_block = "block-header-default";
    $md_editor = "";
    $md_table_body = "";
    $md_table_header = "";
    $table = ""; 
    if($mode_type == "Dark") //insert
    { 
        $md_content = "bg-primary-darker";
        $md_text = "text-white";
        $md_block = "bg-gray-darker";
        $md_editor = "#2d3238";
        $md_table_body = "bg-primary-darker text-body-color-light";
        $md_table_header = "bg-gray-darker";
        $table = "bg-primary-darker text-body-color-light";
    }
?>     

<!-- Main Container -->
<main id="main-container">

    <!-- Page Content -->
    <div class="content <?php echo $md_content; ?>">
        
        <!-- Email list -->
        <div class="row row-deck mt-20">
            <div class="col-lg-12">
                <div class="block block-rounded shadow <?php echo $md_table_header; ?>">
                    <div class="block-header content-heading <?php echo $md_table_header; ?>">
                        <h3 class="block-title <?php echo $md_text; ?>">Email Blasting</h3>

                        <div class="dropdown float-right">
                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-overview-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span><?php if (isset($_GET['filter'])) {echo $_GET['filter'];} else { echo "This Week";} ?></span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-overview-drop" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 31px, 0px);">  
                                <button class="dropdown-item" onclick="tran_all()">
                                    <i class="fa fa-fw fa-circle-o mr-5"></i>All
                                </button>
                                <button class="dropdown-item" onclick="tran_today()">
                                    <i class="fa fa-fw fa-calendar mr-5"></i>Today
                                </button>
                                <button class="dropdown-item" onclick="tran_week()">
                                    <i class="fa fa-fw fa-calendar mr-5"></i>This Week
                                </button>
                                <button class="dropdown-item" onclick="tran_month()">
                                    <i class="fa fa-fw fa-calendar mr-5"></i>This Month
                                </button>
                                <button class="dropdown-item" onclick="tran_year()">
                                    <i class="fa fa-fw fa-calendar mr-5"></i>This Year
                                </button>
                                <span class="filterparent">
                                    <form class="dropdown-item filterparent">
                                        <i class="fa fa-fw fa-calendar mr-5"></i>Custom Date
                                    </form>
                                    <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 185px; right: 120px;">
                                        <label for="example-datepicker4">Custom date</label>
                                        <div class="form-material">
                                            <input type="date" class="js-datepicker form-control" id="txt_date_from" data-week-start="1" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                            <label for="example-datepicker4">From:</label>
                                        </div>
                                        <div class="form-material">
                                            <input type="date" class="js-datepicker form-control" id="txt_date_to" data-week-start="1" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                            <label for="example-datepicker4">To:</label>
                                        </div>
                                        <div class="form-material">
                                            <button class="btn btn-sm btn-noborder btn-alt-primary btn-block" onclick="tran_custom()"><i class="fa fa-check-square-o"></i>Go</button>
                                        </div>
                                    </div>
                                </span> 
                            </div>
                        </div>

                        </button>
                    </div>
                    <div class="block-content <?php echo $md_text; ?> mb-20">
                        <table class="table table-bordered table-striped table-vcenter table-hover text-body-color-light js-dataTable-full">
                            <thead>
                                <tr>
                                    <th class="text-center">No.</th>
                                    <th class="d-none d-sm-table-cell">Task Name</th>
                                    <th class="d-none d-sm-table-cell">Services</th>
                                    <th class="d-none d-sm-table-cell">List</th>
                                    <th class="text-center">Date Created</th>
                                    <th class="d-none d-sm-table-cell text-center">Last Date Sent</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                if (isset($_GET['filter'])) {
                                $filterby = $_GET['filter'];
                                
                                if($filterby == "All")
                                {                    
                                    $select_task = mysqli_query($conn, "SELECT task.task_id, task.task_name, list.list_name, space.space_name, task.task_date_created, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id INNER JOIN email_send_history ON email_send_history.email_task_id = task.task_id WHERE email_send_history.email_blast = 1 GROUP BY task.task_id");
                                }
                                else if($filterby == "Today")
                                {   
                                    $filter = date("Y-m-d");
                                    $select_task = mysqli_query($conn, "SELECT task.task_id, task.task_name, list.list_name, space.space_name, task.task_date_created, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id INNER JOIN email_send_history ON email_send_history.email_task_id = task.task_id WHERE task.task_date_created LIKE '%$filter%' AND email_send_history.email_blast = 1 GROUP BY task.task_id");
                                }
                                else if($filterby == "This Week")
                                {
                                    $dt = new DateTime();
                                    $dates = []; 
                                    for ($d = 1; $d <= 7; $d++) {
                                        $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                                        $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
                                    }
                                    $from = current($dates); // monday
                                    $to = end($dates); // sunday
                                    $select_task = mysqli_query($conn, "SELECT task.task_id, task.task_name, list.list_name, space.space_name, task.task_date_created, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id INNER JOIN email_send_history ON email_send_history.email_task_id = task.task_id WHERE task.task_date_created BETWEEN '$from' AND '$to' AND email_send_history.email_blast = 1 GROUP BY task.task_id");
                                }
                                else if($filterby == "This Month")
                                {
                                    $filter = date("Y-m");
                                    $select_task = mysqli_query($conn, "SELECT task.task_id, task.task_name, list.list_name, space.space_name, task.task_date_created, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id INNER JOIN email_send_history ON email_send_history.email_task_id = task.task_id WHERE task.task_date_created LIKE '%$filter%' AND email_send_history.email_blast = 1 GROUP BY task.task_id");
                                }
                                else if($filterby == "This Year")
                                {
                                    $filter = date("Y");
                                    $select_task = mysqli_query($conn, "SELECT task.task_id, task.task_name, list.list_name, space.space_name, task.task_date_created, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id INNER JOIN email_send_history ON email_send_history.email_task_id = task.task_id WHERE task.task_date_created LIKE '%$filter%' AND email_send_history.email_blast = 1 GROUP BY task.task_id");
                                }
                                else if($filterby == "Custom Date")
                                {                    
                                    $get_from = $_GET['From'];
                                    $get_to = $_GET['To'];
                                    $select_task = mysqli_query($conn, "SELECT task.task_id, task.task_name, list.list_name, space.space_name, task.task_date_created, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id INNER JOIN email_send_history ON email_send_history.email_task_id = task.task_id WHERE task.task_date_created BETWEEN '$get_from' AND '$get_to' AND email_send_history.email_blast = 1 GROUP BY task.task_id");
                                }
                            }
                            else
                            {
                                $dt = new DateTime();
                                $dates = []; 
                                for ($d = 1; $d <= 7; $d++) {
                                    $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                                    $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
                                }
                                $from = current($dates); // monday
                                $to = end($dates); // sunday
                                $select_task = mysqli_query($conn, "SELECT task.task_id, task.task_name, list.list_name, space.space_name, task.task_date_created, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id INNER JOIN email_send_history ON email_send_history.email_task_id = task.task_id WHERE task.task_date_created BETWEEN '$from' AND '$to' AND email_send_history.email_blast = 1 GROUP BY task.task_id");
                            }
                            $count = 1;
                            while($fetch_task = mysqli_fetch_array($select_task))
                            {
                                $task_id = $fetch_task['task_id'];
                                $space_name = $fetch_task['space_name'];
                                $list_name = $fetch_task['list_name'];
                                $list_id = $fetch_task['task_list_id'];
                                echo '
                                    <tr style="cursor: pointer;" id="'.$task_id.','.$space_name.','.$list_name.','.$list_id.'" onclick="view_task_email(this.id)">
                                        <td class="text-center">'.$count++.'</td>
                                        <td>'.$fetch_task['task_name'].'</td>
                                        <td>'.$fetch_task['space_name'].'</td>
                                        <td>'.$fetch_task['list_name'].'</td>
                                        <td class="text-center">'.$fetch_task['task_date_created'].'</td>
                                        <td class="text-center">';
                                        $result_email_history = mysqli_query($conn, "SELECT email_send_date FROM email_send_history WHERE email_task_id = '$task_id' AND email_blast = 1 ORDER BY email_send_date DESC LIMIT 1");
                                        $data = mysqli_fetch_assoc($result_email_history);
                                        // echo $data['email_send_date'];
                                        if (mysqli_num_rows($result_email_history) == 1) {
                                            echo $data['email_send_date'];
                                        } else {
                                            echo 'No Records!!';
                                        }
                                        echo '</td>
                                    </tr>
                                    ';
                            }
                             ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Email list -->
    </div>
    <!-- END Page Content -->

</main>
<!-- END Main Container -->

<script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>

<!-- task modal -->
    <div class="modal fade" id="modal-extra-large" tabindex="-1" role="dialog" aria-labelledby="modal-extra-large" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header" style="background-color: #045d71;">
                        <h3 class="block-title">Email Blasting Details</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content" data-toggle="slimscroll" data-height="700px" data-color="#42A5F5">
                    <div class="block-content">
                        <div class="block block-mode">
                            <div class="block-header block-header-default" style="margin-top: -20px; background-color: #0d7694;">
                                <h3 class="block-title text-white">Email History</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                                </div>
                            </div>
                            <div class="block-content">
                                <div data-toggle="slimscroll" data-height="600px">
                                    <table class="js-table-sections table table-hover">
                                            <thead>
                                                <tr>
                                                    <th class="d-none d-sm-table-cell" style="text-align: inherit;font-weight: bold;">Details</th>
                                                    <th></th>
                                                    <th class="d-none d-sm-table-cell"></th>
                                                    <th class="d-none d-sm-table-cell"></th>
                                                    <th class="d-none d-sm-table-cell" style="text-align: center;font-weight: bold;">Email Content</th>
                                                    <th class="d-none d-sm-table-cell"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="js-table-sections-header" id="show_email_blasting_details">
                                            </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END Email History -->
                    </div>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    // function email_blasting_details(id)
    // {
    //     // alert(id);
    //     $.ajax({
    //         url:"ajax.php",
    //         method:"post",
    //         data:{
    //             task_id:id,
    //             email_blasting_details: 1,
    //         },
    //         success:function(response){
    //              $('#show_email_blasting_details').html(response);
    //         }
    //     });
    // }

    function view_task_email(id)
    {
        array_id = id.split(",");
        task_id = array_id[0];
        space_name = array_id[1];
        list_name = array_id[2];
        list_id = array_id[3];

        document.location = 'main_dashboard.php?space_name='+space_name+'&list_name='+list_name+'&list_id='+list_id+'&get_task_id='+task_id+'&email=1';
    }

    function tran_all()
    {
        document.location='email_blasting.php?filter=All';
    }
    function tran_today()
    {
        document.location='email_blasting.php?filter=Today';
    }
    function tran_week()
    {
        document.location='email_blasting.php?filter=This Week';
    }
    function tran_month()
    {
        document.location='email_blasting.php?filter=This Month';
    }
    function tran_year()
    {
        document.location='email_blasting.php?filter=This Year';
    }
    function tran_custom()
    {   
        var date_from = document.getElementById('txt_date_from').value;
        var date_to = document.getElementById('txt_date_to').value;
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

          document.location='email_blasting.php?filter=Custom Date&From='+date_from+'&To='+date_to;
        }
    }

</script>