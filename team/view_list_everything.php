<!-- Main Container -->
<main id="main-container" style="margin: -5px -10px 0px -10px;">
    <!-- Page Content -->
    <div class="content <?php echo $md_primary_darker; ?>">
        <!-- Dynamic Table Full -->
        <div class="block block-content block-content-full shadow <?php echo $md_body; ?>">
            <!-- DataTables functionality is initialized with .js-dataTable-full class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
            <div class="block-header content-heading">
                <h3 class="block-title" style="color: white;">All Record(s)
                </h3>

                <!-- <h5 class="float-right" style="color: white;">All Record(s)</h5> -->

                <div class="dropdown float-right">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-overview-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>Due Date</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-overview-drop" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 31px, 0px);">
                        <button class="dropdown-item" onclick="tran_all_due_date()">
                            <i class="fa fa-fw fa-circle-o mr-5"></i>All
                        </button>
                        <button class="dropdown-item" onclick="tran_today_due_date()">
                            <i class="fa fa-fw fa-calendar mr-5"></i>Today
                        </button>
                        <button class="dropdown-item" onclick="tran_week_due_date()">
                            <i class="fa fa-fw fa-calendar mr-5"></i>This Week
                        </button>
                        <button class="dropdown-item" onclick="tran_month_due_date()">
                            <i class="fa fa-fw fa-calendar mr-5"></i>This Month
                        </button>
                        <button class="dropdown-item" onclick="tran_year_due_date()">
                            <i class="fa fa-fw fa-calendar mr-5"></i>This Year
                        </button>
                        <span class="filterparent">
                            <form class="dropdown-item filterparent">
                                <i class="fa fa-fw fa-calendar mr-5"></i>Custom Date
                            </form>
                            <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 185px; right: 120px;">
                                <label for="example-datepicker4">Custom date</label>
                                <div class="form-material">
                                    <input type="date" class="js-datepicker form-control" id="txt_date_from_due_date" data-week-start="1" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                    <label for="example-datepicker4">From:</label>
                                </div>
                                <div class="form-material">
                                    <input type="date" class="js-datepicker form-control" id="txt_date_to_due_date" data-week-start="1" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                    <label for="example-datepicker4">To:</label>
                                </div>
                                <div class="form-material">
                                    <button class="btn btn-sm btn-noborder btn-alt-primary btn-block" onclick="tran_custom_due_date()"><i class="fa fa-check-square-o"></i>Go</button>
                                </div>
                            </div>
                        </span>
                    </div>
                </div>
                     |
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
                |
                <div class="dropdown float-right" id="hide_services">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-overview-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>Services</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-overview-drop" x-placement="bottom-end" style="overflow: auto; height: 300px; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 31px, 0px);">
                        <?php
                          $select_services = mysqli_query($conn, "SELECT * FROM space ORDER BY space_name");
                          while($fetch_services = mysqli_fetch_array($select_services))
                          {
                            echo '
                            <button class="dropdown-item" id="'.$fetch_services['space_id'].'" onclick="filter_services(this.id)">
                                <i class="fa fa-fw fa-th-list mr-5"></i>'.$fetch_services['space_name'].'
                            </button>
                            ';
                          }
                         ?>
                    </div>
                </div>

                <div class="dropdown float-right" id="hide_list" style="display: none;">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-overview-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>List</span>
                    </button>
                    <div id="filter_list" class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-overview-drop" x-placement="bottom-end" style="overflow: auto; height: 200px; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 31px, 0px);">
                    </div>
                </div>

                <div class="dropdown float-right" id="hide_status" style="display: none;">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-overview-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>Status</span>
                    </button>
                    <div id="filter_status" class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-overview-drop" x-placement="bottom-end" style="overflow: auto; height: 300px; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 31px, 0px);">
                    </div>
                </div>
                |
                <div class="dropdown float-right">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-overview-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>Filter</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-overview-drop" x-placement="bottom-end" style="overflow: auto; height: 300px; position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 31px, 0px);">
                        <?php
                          $user_id = $_SESSION['user'];
                          $select_filter_status = mysqli_query($conn, "SELECT * FROM filter_status WHERE user_id = $user_id");
                          if (mysqli_num_rows($select_filter_status) === 0) {
                            echo "<label>At the moment there's no batch filter in the status!</label>";
                          }
                          while($fetch_filter = mysqli_fetch_array($select_filter_status))
                          {
                            $filter_status_id = $fetch_filter['filter_status_id'];
                            $status_array = explode(",", $fetch_filter['array_status']); // convert string to array
                            $count_status = count($status_array);
                            echo '<label>List of Status Filter by Batch:</label>';
                            for ($x = 1; $x <= $count_status; $x++)
                            {
                              $y = $x - 1;
                              $final_status_id = $status_array[$y];
                              // echo $final_status_id.'<br>';
                              $get_status_name = mysqli_query($conn, "SELECT * FROM status WHERE status_id = '$final_status_id'");
                              $result = mysqli_fetch_array($get_status_name);
                              $status_name = $result['status_name'];
                              echo '
                              <button class="dropdown-item" id="'.$filter_status_id.'" onclick="delete_filter_status_id(this.id)">
                                  <i class="fa fa-fw fa-th-list mr-5"></i>'.$status_name.'
                              </button>
                              ';
                            }
                          }
                         ?>
                    </div>
                </div>

            </div>
            <table class="block table table-bordered table-striped table-hover table-vcenter js-dataTable-full <?php echo $md_body; ?>">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th class="d-none d-sm-table-cell">Due_Date</th>
                        <th class="d-none d-sm-table-cell">Date_Created</th>
                        <th class="d-none d-sm-table-cell">Priority</th>
                        <th class="d-none d-sm-table-cell text-center">Assign</th>
                        <th class="d-none d-sm-table-cell text-center">Space</th>
                        <th class="d-none d-sm-table-cell text-center">List</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        date_default_timezone_set('Asia/Manila');

                        if (isset($_GET['filter']) or isset($_GET['due_date'])) {
                                $filterby = $_GET['filter'];
                                $due_date = $_GET['due_date'];
                                $due_date_filter = '';

                                if($due_date == "All")
                                {
                                    $due_date_filter = '';
                                }
                                else if($due_date == "Today")
                                {
                                    $filter_due = date("Y-m-d");
                                    $due_date_filter = "LIKE '%".$filter_due."%'";
                                }
                                else if($due_date == "This Week")
                                {
                                    $dt = new DateTime();
                                    $dates = [];
                                    for ($d = 1; $d <= 7; $d++) {
                                        $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                                        $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
                                    }
                                    $from_due = current($dates); // monday
                                    $to_due = end($dates); // sunday

                                    $due_date_filter = "BETWEEN '".$from_due."' AND '".$to_due."'";
                                }
                                else if($due_date == "This Month")
                                {
                                    $filter_due = date("Y-m");
                                    $due_date_filter = "LIKE '%".$filter_due."%'";
                                }
                                else if($due_date == "This Year")
                                {
                                    $filter_due = date("Y");
                                    $due_date_filter = "LIKE '%".$filter_due."%'";
                                }
                                else if($due_date == "Custom Date")
                                {
                                    $get_from_due = $_GET['From_due'];
                                    $get_to_due = $_GET['To_due'];
                                    $due_date_filter = "BETWEEN '".$get_from_due."' AND '".$get_to_due."'";
                                }


                                if($filterby == "All")
                                {
                                    if($due_date == "All")
                                    {
                                        $select_task = mysqli_query($conn, "SELECT * FROM task ORDER BY task_date_created DESC");                                    }
                                    else
                                    {
                                        $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_due_date $due_date_filter ORDER BY task_date_created DESC");
                                    }
                                }
                                else if($filterby == "Today")
                                {
                                    $filter = date("Y-m-d");
                                    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created LIKE '%$filter%' AND task_due_date $due_date_filter");
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
                                    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created BETWEEN '$from' AND '$to' AND task_due_date $due_date_filter ORDER BY task_date_created DESC");
                                }
                                else if($filterby == "This Month")
                                {
                                    $filter = date("Y-m");
                                    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created LIKE '%$filter%' AND task_due_date $due_date_filter ORDER BY task_date_created DESC");
                                }
                                else if($filterby == "This Year")
                                {
                                    $filter = date("Y");
                                    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created LIKE '%$filter%' AND task_due_date $due_date_filter ORDER BY task_date_created DESC");
                                }
                                else if($filterby == "Custom Date")
                                {
                                    $get_from = $_GET['From'];
                                    $get_to = $_GET['To'];
                                    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created BETWEEN '$get_from' AND '$get_to' AND task_due_date $due_date_filter ORDER BY task_date_created DESC");
                                }
                            }

                        $count = 1;

                        while($fetch_task = mysqli_fetch_array($select_task))
                        {
                          $status_id = $fetch_task['task_status_id'];
                          $user_id = $_SESSION['user'];
                          $query_filter_status = mysqli_query($conn, "SELECT * FROM filter_status WHERE user_id = $user_id");
                          $data = mysqli_fetch_array($query_filter_status);
                          $array_status = $data['array_status'];
                          if (mysqli_num_rows($query_filter_status) === 1) {
                            $value_array = explode(",", $array_status);
                            if(count($value_array) === 1)
                            {
                              $value1 = $value_array[0];
                              if ($value1 === $status_id) {
                                include 'view_list_everything_table.php';
                              }
                            }
                            else if(count($value_array) === 2)
                            {
                              $value1 = $value_array[0];
                              $value2 = $value_array[1];
                              if ($value1 === $status_id OR $value2 === $status_id) {
                                include 'view_list_everything_table.php';
                              }
                            }
                            else if(count($value_array) === 3)
                            {
                              $value1 = $value_array[0];
                              $value2 = $value_array[1];
                              $value3 = $value_array[2];
                              if ($value1 === $status_id OR $value2 === $status_id OR $value3 === $status_id) {
                                include 'view_list_everything_table.php';
                              }
                            }
                            else if(count($value_array) === 4)
                            {
                              $value1 = $value_array[0];
                              $value2 = $value_array[1];
                              $value3 = $value_array[2];
                              $value4 = $value_array[3];
                              if ($value1 === $status_id OR $value2 === $status_id OR $value3 === $status_id OR $value4 === $status_id) {
                                include 'view_list_everything_table.php';
                              }
                            }
                            else if(count($value_array) === 5)
                            {
                              $value1 = $value_array[0];
                              $value2 = $value_array[1];
                              $value3 = $value_array[2];
                              $value4 = $value_array[3];
                              $value5 = $value_array[4];
                              if ($value1 === $status_id OR $value2 === $status_id OR $value3 === $status_id OR $value4 === $status_id OR $value5 === $status_id) {
                                include 'view_list_everything_table.php';
                              }
                            }
                            else if(count($value_array) === 6)
                            {
                              $value1 = $value_array[0];
                              $value2 = $value_array[1];
                              $value3 = $value_array[2];
                              $value4 = $value_array[3];
                              $value5 = $value_array[4];
                              $value6 = $value_array[5];
                              if ($value1 === $status_id OR $value2 === $status_id OR $value3 === $status_id OR $value4 === $status_id OR $value5 === $status_id OR $value5 === $status_id) {
                                include 'view_list_everything_table.php';
                              }
                            }
                          } else {
                            include 'view_list_everything_table.php';
                          }
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->

<script type="text/javascript">
    function view_task(id)
    {
        new_id = id.replace("taskid_", "");
        space_name = document.getElementById("spacename" + new_id).value;
        list_name = document.getElementById("listname" + new_id).value;
        list_id = document.getElementById("listid" + new_id).value;

        document.location = 'main_dashboard.php?space_name='+space_name+'&list_name='+list_name+'&list_id='+list_id+'&get_task_id='+new_id+'&b=1';
    }

    function filter_services(id)
    {
      // alert(id);
      space_id = id;
      $.ajax({
          url: 'ajax.php',
          type: 'POST',
          async: false,
          data:{
              space_id: space_id,
              filter_services:1,
          },
          success: function(data){
              alert('You can now filter list!');
              document.getElementById("hide_services").style.display = "none";
              document.getElementById("hide_list").style.display = "";
              $('#filter_list').html(data);
            }
        });
    }

    function filter_list(id)
    {
      $.ajax({
          url: 'ajax.php',
          type: 'POST',
          async: false,
          data:{
              list_id: id,
              filter_list:1,
          },
          success: function(data){
              alert('You can now filter status!');
              document.getElementById("hide_list").style.display = "none";
              document.getElementById("hide_status").style.display = "";
              $('#filter_status').html(data);
            }
        });
    }

    function filter_status()
    {
      var array = []
      var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

      for (var i = 0; i < checkboxes.length; i++) {
          array.push(checkboxes[i].value)
      }
      // alert(array);
      $.ajax({
          url: 'ajax.php',
          type: 'POST',
          async: false,
          data:{
              status_id: array,
              filter_status:1,
          },
          success: function(data){
              if (data == 'success') {
                location.reload();
              }
            }
        });
    }

    function delete_filter_status_id(id)
    {
      if(confirm("Are you sure you want to removed this batch filter?"))
      {
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: false,
            data:{
                filter_status_id: id,
                delete_filter_status_id:1,
            },
            success: function(data){
                if (data == 'success') {
                  alert('Filter batch successfully removed!!');
                  location.reload();
                }
              }
          });
      }
    }
</script>
