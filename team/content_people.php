<?php
    $md_primary_darker = "";
    $md_text = "text-muted";
    $md_body = "";
    if($mode_type == "Dark") //insert
    {
        $md_primary_darker = "bg-primary-darker";
        $md_text = "text-white";
        $md_body = "bg-gray-darker text-body-color-light";
    }
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
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}

</style>
<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content <?php echo $md_primary_darker; ?>">
        <!-- Dynamic Table Full -->
        <div class="block block-rounded shadow <?php echo $md_body; ?>">
            <div class="block-header content-heading <?php echo $md_body; ?>">
                <h3 class="block-title <?php echo $md_text; ?>">Member / Individual Report
                  <button type="button" class="btn btn-success pull-right" name="button"><i class="fa fa-bar-chart"></i> View Summary Report</button>
                  <div class="dropdown float-right">
                      <button type="button" style="margin-top: 4px; margin-right: 2px;" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-overview-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span>Filter Report Date</span>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-overview-drop" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 31px, 0px);">
                          <button class="dropdown-item" id="all" onclick="filter_date(this.id)">
                              <i class="fa fa-fw fa-circle-o mr-5"></i>All
                          </button>
                          <button class="dropdown-item" id="today" onclick="filter_date(this.id)">
                              <i class="fa fa-fw fa-calendar mr-5"></i>Today
                          </button>
                          <button class="dropdown-item" id="this_week" onclick="filter_date(this.id)">
                              <i class="fa fa-fw fa-calendar mr-5"></i>This Week
                          </button>
                          <button class="dropdown-item" id="month" onclick="filter_date(this.id)">
                              <i class="fa fa-fw fa-calendar mr-5"></i>This Month
                          </button>
                          <button class="dropdown-item" id="year" onclick="filter_date(this.id)">
                              <i class="fa fa-fw fa-calendar mr-5"></i>This Year
                          </button>
                          <span class="filterparent">
                              <form class="dropdown-item filterparent">
                                  <i class="fa fa-fw fa-calendar mr-5"></i>Custom Date
                              </form>
                              <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 185px; right: 120px;">
                                  <label for="example-datepicker4">Custom date</label>
                                  <div class="form-material">
                                      <input type="date" class="js-datepicker form-control" id="filter_from" data-week-start="1" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                      <label for="example-datepicker4">From:</label>
                                  </div>
                                  <div class="form-material">
                                      <input type="date" class="js-datepicker form-control" id="filter_to" data-week-start="1" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                      <label for="example-datepicker4">To:</label>
                                  </div>
                                  <div class="form-material">
                                      <button class="btn btn-sm btn-noborder btn-alt-primary btn-block" id="custom" onclick="filter_date(this.id)"><i class="fa fa-check-square-o"></i>Go</button>
                                  </div>
                              </div>
                          </span>
                      </div>
                  </div>
                </h3>
            </div>
            <div class="block-content block-content-full <?php echo $md_body; ?>">
                <!-- DataTables functionality is initialized with .js-dataTable-full class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <table class="table table-striped table-bordered table-hover table-vcenter js-dataTable-full <?php echo $md_body; ?>">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Name</th>
                            <th class="d-none d-sm-table-cell">Email</th>
                            <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Type</th>
                            <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Department</th>
                            <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Category</th>
                            <th class="text-center" style="width: 15%;">Profile</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $countuser = 1;
                            $finduser = mysqli_query($conn, "SELECT * FROM user ORDER BY fname ASC");
                            while($result_finduser = mysqli_fetch_array($finduser))
                            {
                                $get_first_letter_in_fname = $result_finduser['fname'];
                                $get_first_letter_in_lname = $result_finduser['lname'];
                                echo '
                                <tr style="cursor: pointer;">
                                    <td class="text-center">'.$countuser++.'</td>
                                    <td class="font-w600">';
                                    if($row['user_id'] == $result_finduser['user_id'])
                                    {
                                        echo'<a href="main_personal_details.php">'.$result_finduser['fname'].' '.$result_finduser['mname'].' '.$result_finduser['lname'].'</a>';
                                    }
                                    else
                                    {
                                        echo'<a href="main_people_details.php?userid='.$result_finduser['user_id'].'">'.$result_finduser['fname'].' '.$result_finduser['mname'].' '.$result_finduser['lname'].'</a>';
                                    }
                                    echo'
                                    </td>
                                    <td class="d-none d-sm-table-cell" class="text-center" data-toggle="modal" data-target="#modal-report" id="'.$result_finduser['user_id'].'" onclick="show_individual_report(this.id)">'.$result_finduser['email'].'</td>
                                    <td class="d-none d-sm-table-cell text-center" style="font-size: 18px;">';
                                        if($result_finduser['user_type'] == 'Admin')
                                        {echo'<span class="badge badge-primary">Admin</span>';}
                                        else if($result_finduser['user_type'] == 'Supervisory')
                                        {echo'<span class="badge badge-warning">Supervisory</span>';}
                                        else if($result_finduser['user_type'] == 'Member')
                                        {echo'<span class="badge badge-success">Member</span>';}
                                        else if($result_finduser['user_type'] == 'Suspended')
                                        {echo'<span class="badge badge-danger">Suspended</span>';}
                                        else
                                        {echo'<span class="badge badge-danger">Invalidate</span>';}
                                    echo'
                                    </td>
                                    <td class="text-center" data-toggle="modal" data-target="#modal-small-department" id="'.$result_finduser['user_id'].'" onclick="show_department(this.id)" style="font-size: 18px;">
                                        ';
                                        if($result_finduser['user_type'] == 'Admin')
                                        {echo'<span class="badge badge-primary">'; if($result_finduser['department'] == ''){ echo 'Not yet assign!'; } else { echo $result_finduser['department']; } echo'</span>';}
                                        else if($result_finduser['user_type'] == 'Supervisory')
                                        {echo'<span class="badge badge-warning">'; if($result_finduser['department'] == ''){ echo 'Not yet assign!'; } else { echo $result_finduser['department']; } echo'</span>';}
                                        else if($result_finduser['user_type'] == 'Member')
                                        {echo'<span class="badge badge-success">'; if($result_finduser['department'] == ''){ echo 'Not yet assign!'; } else { echo $result_finduser['department']; } echo'</span>';}
                                        else if($result_finduser['user_type'] == 'Suspended')
                                        {echo'<span class="badge badge-danger">'; if($result_finduser['department'] == ''){ echo 'Not yet assign!'; } else { echo $result_finduser['department']; } echo'</span>';}
                                        else
                                        {echo'<span class="badge badge-danger">'; if($result_finduser['department'] == ''){ echo 'Not yet assign!'; } else { echo $result_finduser['department']; } echo'</span>';}
                                    echo'
                                    </td>
                                    <td class="text-center" data-toggle="modal" data-target="#modal-small-category" id="'.$result_finduser['user_id'].'" onclick="show_category(this.id)" style="font-size: 18px;">
                                        ';
                                        if($result_finduser['user_type'] == 'Admin')
                                        {echo'<span class="badge badge-primary">'; if($result_finduser['category'] == ''){ echo 'Not yet assign!'; } else { echo $result_finduser['category']; } echo'</span>';}
                                        else if($result_finduser['user_type'] == 'Supervisory')
                                        {echo'<span class="badge badge-warning">'; if($result_finduser['category'] == ''){ echo 'Not yet assign!'; } else { echo $result_finduser['category']; } echo'</span>';}
                                        else if($result_finduser['user_type'] == 'Member')
                                        {echo'<span class="badge badge-success">'; if($result_finduser['category'] == ''){ echo 'Not yet assign!'; } else { echo $result_finduser['category']; } echo'</span>';}
                                        else if($result_finduser['user_type'] == 'Suspended')
                                        {echo'<span class="badge badge-danger">'; if($result_finduser['category'] == ''){ echo 'Not yet assign!'; } else { echo $result_finduser['category']; } echo'</span>';}
                                        else
                                        {echo'<span class="badge badge-danger">'; if($result_finduser['category'] == ''){ echo 'Not yet assign!'; } else { echo $result_finduser['category']; } echo'</span>';}
                                    echo'
                                    </td>
                                    <td class="text-center">';
                                        if($result_finduser['profile_pic'] != "")
                                        {echo'<img style="width: 37px; height: 37px; border-radius:50px;" src="../assets/media/upload/'.$result_finduser['profile_pic'].'">';}
                                        else
                                        {echo '<span class="btn btn-lg btn-circle" style="color:#fff; background-color: '.$result_finduser['user_color'].'">'.$get_first_letter_in_fname[0].''.$get_first_letter_in_lname[0].'</span>';}
                                    echo'
                                    </td>
                                </tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->

<!-- Small Modal -->
<div class="modal fade" id="modal-small-department" tabindex="-1" role="dialog" aria-labelledby="modal-small" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Assign Department</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <input type="hidden" id="user_id_department">
                    <div class="row">
                      <div class="col-sm-8">
                        <input class="form-control" type="text" id="add_department_name" value="" placeholder="Add New Department">
                      </div>
                      <div class="col-sm-4">
                        <button class="form-control btn btn-success" type="button" onclick="add_department()">Add</button>
                      </div>
                    </div><br>
                    <select id="department" class="form-control">
                        <option selected="" disabled="" value="">Select Department</option>
                        <?php
                          $query = mysqli_query($conn, "SELECT * FROM tbl_department ORDER BY dep_name") or die(mysqli_error());
                          while($data = mysqli_fetch_array($query))
                          {
                            echo '
                              <option value="'.$data['dep_name'].'">'.$data['dep_name'].'</option>
                            ';
                          }
                         ?>
                    </select><br>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-success" onclick="save_department()">
                    <i class="fa fa-check"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END Small Modal -->

<!-- Small Modal -->
<div class="modal fade" id="modal-small-category" tabindex="-1" role="dialog" aria-labelledby="modal-small" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Assign Category</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <input type="hidden" id="user_id_category">
                    <div class="row">
                      <div class="col-sm-8">
                        <input class="form-control" type="text" id="add_category_name" value="" placeholder="Add New Category">
                      </div>
                      <div class="col-sm-4">
                        <button class="form-control btn btn-success" type="button" onclick="add_category()">Add</button>
                      </div>
                    </div><br>
                    <select id="category" class="form-control">
                        <option selected="" disabled="" value="">Select Category</option>
                        <?php
                          $query = mysqli_query($conn, "SELECT * FROM tbl_category ORDER BY cat_name") or die(mysqli_error());
                          while($data = mysqli_fetch_array($query))
                          {
                            echo '
                              <option value="'.$data['cat_name'].'">'.$data['cat_name'].'</option>
                            ';
                          }
                         ?>
                    </select><br>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-success" onclick="save_category()">
                    <i class="fa fa-check"></i> Update
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END Small Modal -->

<!-- Extra Large Modal -->
<div class="modal fade" id="modal-report" tabindex="-1" role="dialog" aria-labelledby="modal-extra-large" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Individual Report</h3>
                    <div class="block-options">
                        <button type="button" onclick="close_modal()" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content" id="show_individual_report">
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-alt-success" data-dismiss="modal">
                    <i class="fa fa-check"></i> Perfect
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END Extra Large Modal -->

<script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
<script src="../assets/chart/core.js"></script>
<script src="../assets/chart/charts.js"></script>
<script src="../assets/chart/animated.js"></script>
<script type="text/javascript">
    function show_department(id)
    {
        // console.log(id);
        document.getElementById("user_id_department").value = id;

    }

    function show_category(id)
    {
        // console.log(id);
        document.getElementById("user_id_category").value = id;

    }

    function save_department()
    {
        if(confirm("Are you sure?"))
        {
            user_id = document.getElementById("user_id_department").value
            department = document.getElementById("department").value

            // console.log(department);
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                async: false,
                data:{
                    user_id:user_id,
                    department:department,
                    save_department: 1,
                },
                success: function(data){
                    if(data = 'success')
                    {
                        alert('Successfully Update Department!!');
                        location.reload();
                    }
                }
            });
        }
    }

    function save_category()
    {
        if(confirm("Are you sure?"))
        {
            user_id = document.getElementById("user_id_category").value
            category = document.getElementById("category").value

            // console.log(department);
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                async: false,
                data:{
                    user_id:user_id,
                    category:category,
                    save_category: 1,
                },
                success: function(data){
                    if(data = 'success')
                    {
                        alert('Successfully Update Category!!');
                        location.reload();
                    }
                }
            });
        }
    }

    function add_category() {
      if(confirm("Are you sure?"))
      {
        cat_name = document.getElementById("add_category_name").value
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: false,
            data:{
                cat_name:cat_name,
                add_category: 1,
            },
            success: function(data){
                if(data = 'success')
                {
                    alert('Successfully Added New Category!!');
                    location.reload();
                }
            }
        });
      }
    }

    function add_department() {
      if(confirm("Are you sure?"))
      {
        dep_name = document.getElementById("add_department_name").value
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: false,
            data:{
                dep_name:dep_name,
                add_department: 1,
            },
            success: function(data){
                if(data = 'success')
                {
                    alert('Successfully Added New Department!!');
                    location.reload();
                }
            }
        });
      }
    }

    function show_individual_report(id) {
      filter_report = '<?php echo $_GET['filter_report']; ?>';
      filter_from = '<?php if(isset($_GET['filter_from'])) { echo $_GET['filter_from']; } ?>';
      filter_to = '<?php if(isset($_GET['filter_to'])) { echo $_GET['filter_to']; } ?>';
      $.ajax({
          url: 'ajax.php',
          type: 'POST',
          async: false,
          data:{
              user_id:id,
              filter_report:filter_report,
              filter_from:filter_from,
              filter_to:filter_to,
              show_individual_report: 1,
          },
          success: function(data){
              $('#show_individual_report').html(data);
          }
      });
    }

    function filter_date(id) {
      if (id == 'custom') {
        filter_from = document.getElementById("filter_from").value
        filter_to = document.getElementById("filter_to").value
        document.location='main_people.php?filter_report='+id+'&filter_from='+filter_from+'&filter_to='+filter_to;
      } else {
        document.location='main_people.php?filter_report='+id;
      }
    }

    function close_modal() {
      filter_report = '<?php echo $_GET['filter_report'] ?>';
      if (filter_report == 'custom') {
        filter_from = '<?php if(isset($_GET['filter_from'])) { echo $_GET['filter_from']; } ?>';
        filter_to = '<?php if(isset($_GET['filter_to'])) { echo $_GET['filter_to']; } ?>';
        document.location='main_people.php?filter_report='+filter_report+'&filter_from='+filter_from+'&filter_to='+filter_to;
      } else {
        document.location='main_people.php?filter_report='+filter_report;
      }
    }

    function view_task(id) {
      alert(id);
    }

</script>
