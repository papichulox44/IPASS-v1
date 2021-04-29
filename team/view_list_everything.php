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
                          $select_filter_status = mysqli_query($conn, "SELECT * FROM filter_status WHERE user_id = $user_id AND filter_name = 'everything'");
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
            <label style="margin-bottom: -5px;">Total Task: <label id="total_task">20</label> / <label><?php
            $count_task = mysqli_query($conn, "SELECT Count(task.task_id) AS final_total_task FROM task");
            $data = mysqli_fetch_assoc($count_task);
            $final_total_task = $data['final_total_task'];
            echo number_format($final_total_task);
             ?></label></label><br>
            <label>Total Search: <label id="total_search">0</label></label>
            <div id="search_loading" style="display: none;" class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <input style="width: 200px; float: right; margin-bottom: 5px;" id="myInput" type="text" class="form-control" placeholder="Search..">
            <table class="block table table-sort table-arrows table-bordered table-striped table-hover table-vcenter <?php echo $md_body; ?>">
                <thead>
                    <tr>
                        <th>Task No.</th>
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
                <tbody id="load_data">
                </tbody>
            </table>
            <div id="load_data_message"></div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
<script src = '../assets/table-sort.js'></script>
<script type="text/javascript">
$(document).ready(function(){

    var limit = 20;
    var start = 0;
    var action = 'inactive';
    function load_task_data(limit, start)
    {
    filter = '<?php echo $_GET['filter']; ?>';
    due_date = '<?php echo $_GET['due_date']; ?>';
    From = '<?php if(isset($_GET['From'])) { echo $_GET['From']; } ?>';
    To = '<?php if(isset($_GET['To'])) { echo $_GET['To']; } ?>';
    From_due = '<?php if(isset($_GET['From_due'])) { echo $_GET['From_due']; } ?>';
    To_due = '<?php if(isset($_GET['To_due'])) { echo $_GET['To_due']; } ?>';
    $.ajax({
        url:"view_list_everything_query.php",
        method:"POST",
        data:{limit:limit, start:start, filter:filter, due_date:due_date, From:From, To:To, From_due:From_due, To_due:To_due, load_country_data:1},
        cache:false,
        success:function(data)
        {
        $('#load_data').append(data);
        if(data == '')
        {
         $('#load_data_message').html("<button type='button' class='btn btn-info'>No More Task Found</button>");
         action = 'active';
        }
        else
        {
          var seen = {};
          table = document.getElementById("load_data");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) {
              td = tr[i].getElementsByTagName("td")[0];
              if (seen[td.textContent]) {
                  tr[i].remove();
              } else {
                  seen[td.textContent]=true;
              }
          }
          var rowCount = $("#load_data tr:visible").length;
          document.getElementById("total_task").innerHTML = rowCount;
         $('#load_data_message').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");
         action = "inactive";
        }
      }
    });
    }

    if(action == 'inactive')
      {
      action = 'active';
      load_task_data(limit, start);
      }
    $(window).scroll(function(){
    if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
      {
      action = 'active';
      start = start + limit;
      setTimeout(function(){
      load_task_data(limit, start);
      }, 1000);
      }
      });
    });

    $(document).ready(function(){
      $("#myInput").on("keyup", function() {
        var inputlength = this.value.length;
        var value = $(this).val();
        $("#load_data tr").filter(function() {
          var rowCount = $("#load_data tr:visible").length;
          if(inputlength == "0"){
              document.getElementById("total_search").innerHTML = 0;
              document.getElementById("total_task").innerHTML = rowCount;
             var seen = {};
              table = document.getElementById("load_data");
              tr = table.getElementsByTagName("tr");
              for (i = 0; i < tr.length; i++) {
                  td = tr[i].getElementsByTagName("td")[0];
                  if (seen[td.textContent]) {
                      tr[i].remove();
                  } else {
                      seen[td.textContent]=true;
                  }
              }
          } else {
              document.getElementById("total_search").innerHTML = rowCount;
          }
          $(this).toggle($(this).text().indexOf(value) > -1)

        });
      });
    });

    var limit_search = 20;
    var start_search = 0;
    var action_search = 'inactive';
    document.getElementById("myInput").onkeypress = function(event){
    if (event.keyCode == 13 || event.which == 13){
        var myInput = document.getElementById("myInput").value;
        filter = '<?php echo $_GET['filter']; ?>';
        due_date = '<?php echo $_GET['due_date']; ?>';
        From = '<?php if(isset($_GET['From'])) { echo $_GET['From']; } ?>';
        To = '<?php if(isset($_GET['To'])) { echo $_GET['To']; } ?>';
        From_due = '<?php if(isset($_GET['From_due'])) { echo $_GET['From_due']; } ?>';
        To_due = '<?php if(isset($_GET['To_due'])) { echo $_GET['To_due']; } ?>';
        $.ajax({
            url:"view_list_everything_query.php",
            method:"POST",
            data:{limit:limit_search, start:start_search, myInput:myInput, filter:filter, due_date:due_date, From:From, To:To, From_due:From_due, To_due:To_due, load_task_search_data:1},
            cache:false,
            success:function(data)
            {
            $('#load_data').append(data);
            if(data == '')
            {
             alert("No Task Found!!");
            }
            else
            {
              var seen = {};
              table = document.getElementById("load_data");
              tr = table.getElementsByTagName("tr");
              for (i = 0; i < tr.length; i++) {
                  td = tr[i].getElementsByTagName("td")[0];
                  if (seen[td.textContent]) {
                      tr[i].remove();
                  } else {
                      seen[td.textContent]=true;
                  }
              }
              var rowCount = $("#load_data tr:visible").length;
              document.getElementById("total_task").innerHTML = rowCount;
              x = document.getElementById("search_loading");
              x.style.display = "";
              setTimeout(function(){
              limit_start_search(myInput);
             }, 1000);
            }
          }
        });
        }
    };

    function limit_start_search(myInput){
      start_search = start_search + limit_search;
      load_task_search_data(myInput, limit_search, start_search);
    }

    function load_task_search_data(myInput, limit_search, start_search){
      filter = '<?php echo $_GET['filter']; ?>';
      due_date = '<?php echo $_GET['due_date']; ?>';
      From = '<?php if(isset($_GET['From'])) { echo $_GET['From']; } ?>';
      To = '<?php if(isset($_GET['To'])) { echo $_GET['To']; } ?>';
      From_due = '<?php if(isset($_GET['From_due'])) { echo $_GET['From_due']; } ?>';
      To_due = '<?php if(isset($_GET['To_due'])) { echo $_GET['To_due']; } ?>';
      $.ajax({
          url: "view_list_everything_query.php",
          type: "POST",
          async: false,
          data:{
              myInput: myInput,
              filter:filter,
              due_date:due_date,
              From:From,
              To:To,
              From_due,
              To_due:To_due,
              limit: limit_search,
              start: start_search,
              load_task_search_data:1,
          },
          cache:false,
          success: function(data){
              $('#load_data').append(data);
              if (data === "") {
                x = document.getElementById("search_loading");
                x.style.display = "none";
                alert("Task Successfully Extract from the Database!! Thank you for the Patience..");
                reset_start();
              } else {
                var seen = {};
                table = document.getElementById("load_data");
                tr = table.getElementsByTagName("tr");
                for (i = 0; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td")[0];
                    if (seen[td.textContent]) {
                        tr[i].remove();
                    } else {
                        seen[td.textContent]=true;
                    }
                }
                var rowCount = $("#load_data tr:visible").length;
                document.getElementById("total_task").innerHTML = rowCount;
                document.getElementById("total_search").innerHTML = rowCount;
                setTimeout(function(){
                limit_start_search(myInput);
               }, 1000);
              }
          }
      });
    }


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
