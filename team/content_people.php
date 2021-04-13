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
<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content <?php echo $md_primary_darker; ?>">
        <!-- Dynamic Table Full -->
        <div class="block block-rounded shadow <?php echo $md_body; ?>">
            <div class="block-header content-heading <?php echo $md_body; ?>">
                <h3 class="block-title <?php echo $md_text; ?>">Member</h3>
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
                                    <td class="d-none d-sm-table-cell">'.$result_finduser['email'].'</td>
                                    <td class="d-none d-sm-table-cell text-center" style="font-size: 18px;">';
                                        if($result_finduser['user_type'] == 'Admin')
                                        {echo'<span class="badge badge-primary">Admin</span>';}
                                        else if($result_finduser['user_type'] == 'Supervisory')
                                        {echo'<span class="badge badge-warning">Supervisory</span>';}
                                        else if($result_finduser['user_type'] == 'Member')
                                        {echo'<span class="badge badge-success">Member</span>';}
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
                    <select id="department" class="form-control">
                        <option selected="" disabled="" value="">Select Department</option>
                        <option value="APPLICATION">APPLICATION</option>
                        <option value="Cebu">Cebu</option>
                        <option value="CES">CES</option>
                        <option value="CRM">CRM</option>
                        <option value="Customer Care">Customer Care</option>
                        <option value="DVD">DVD</option>
                        <option value="HC">HC</option>
                        <option value="Middle East">Middle East</option>
                        <option value="Finance">Finance</option>
                        <option value="TM">TM</option>
                        <option value="Manila">Manila</option>
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

<script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
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

</script>
