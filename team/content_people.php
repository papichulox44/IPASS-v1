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
                <table class="table table-striped table-vcenter js-dataTable-full <?php echo $md_body; ?>">
                    <thead>
                        <tr>
                            <th class="text-center">No.</th>
                            <th>Name</th>
                            <th class="d-none d-sm-table-cell">Email</th>
                            <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Type</th>
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
                                <tr>
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
                                    <td class="d-none d-sm-table-cell text-center">';
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
