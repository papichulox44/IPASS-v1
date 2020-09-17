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
                <h3 class="block-title <?php echo $md_text; ?>">Assign contact</h3>
            </div>
            <div class="block-content block-content-full <?php echo $md_body; ?>">
                <!-- DataTables functionality is initialized with .js-dataTable-full class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <table class="table table-striped table-vcenter js-dataTable-full <?php echo $md_body; ?>">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th class="d-none d-sm-table-cell text-center">Task</th>
                            <th class="d-none d-sm-table-cell">Email</th>
                            <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Number</th>
                            <th class="text-center" style="width: 15%;">Profile</th>
                            <!--<th class="d-none d-sm-table-cell text-center">Tools</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $countuser = 1;
                            $findcontact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_assign_to != '' ORDER BY contact_fname ASC");
                            while($result_finduser = mysqli_fetch_array($findcontact))
                            {
                                $contact_id = $result_finduser['contact_id'];
                                $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_contact = '$contact_id'");
                                $count_task = mysqli_num_rows($select_task);
                                echo '
                                <tr>
                                    <td>'.$result_finduser['contact_id'].'</td>
                                    <td class="font-w600 ">';
                                        echo'<a href="main_contact_details.php?contact_id='.$contact_id.'">'.$result_finduser['contact_fname'].' '.$result_finduser['contact_mname'].' '.$result_finduser['contact_lname'].'</a>';
                                        echo'
                                    </td>
                                    <td class="d-none d-sm-table-cell text-center">'.$count_task.'</td>
                                    <td class="d-none d-sm-table-cell">'.$result_finduser['contact_email'].'</td>
                                    <td class="d-none d-sm-table-cell text-center">'.$result_finduser['contact_cpnum'].'</td>';
                                    if($result_finduser['contact_profile'] == "")
                                    {
                                        echo '<td class="text-center "><img style="width: 37px; border-radius:50px;" src="../assets/media/photos/avatar.jpg"></td>';
                                    }
                                    else
                                    {
                                        echo '<td class="text-center "><img style="width: 37px; height: 37px; border-radius:50px;" src="../client/client_profile/'.$result_finduser['contact_profile'].'"></td>';
                                    }
                                    echo'
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