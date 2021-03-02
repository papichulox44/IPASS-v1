<?php
    $user_id = $row['user_id'];

    $select_tb_column = mysqli_query($conn, "SELECT * FROM add_column WHERE column_space_id = '$space_id' AND column_user_id = '$user_id'");
    $count = mysqli_num_rows($select_tb_column);

    if (empty($_GET['column'])){}
    else
    { 
        $column = $_GET['column'];
         mysqli_query($conn,"INSERT into `add_column` (column_space_id, column_user_id, column_name) values ('$space_id','$user_id','$column')") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>"; 
    }


    if (empty($_GET['delete_column_id'])) 
    {}
    else
    {
        $column_id = $_GET['delete_column_id'];
        mysqli_query($conn, "DELETE FROM add_column WHERE column_id='$column_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }
?>
<!------------ ADD COLUMN ------------>
    <div class="dropdown">
        <button type="button" class="btn btn-rounded btn-dual-secondary <?php echo $md_text; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Add column">
            <i class="fa fa-columns"></i>
            <?php 
                if($count == 0){}
                else{echo'<span class="badge badge-primary badge-pill">'.$count.'</span>';}
            ?>
        </button>
        <div class="dropdown-menu dropdown-menu-right shadow">
            <div data-toggle="slimscroll" data-height="400px" data-color="#42a5f5" data-opacity="1" data-always-visible="true" style="background-color: #fff; padding: 5px;">
                <span>Note: Add only the must important field, to avoid table overlap.</span><div class="dropdown-divider"></div>
                <?php
                    if($count == 0)
                    {
                        echo '<span>Field added: <strong>None</strong></span><div class="dropdown-divider"></div>';
                    }
                    else
                    {
                        echo '<span>Field added: </span><br><div class="dropdown-divider"></div>';
                        while($fetch_select_tb_column = mysqli_fetch_array($select_tb_column))
                        {
                            $column_name = $fetch_select_tb_column['column_name'];
                            $field_select = mysqli_query($conn,"SELECT * FROM field WHERE field_col_name = '$column_name'");
                            $field_col_name = mysqli_fetch_array($field_select);
                            echo '<form class="dropdown-item" style ="border: 1px solid #8fd6ff;">
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&delete_column_id='.$fetch_select_tb_column['column_id'].'"><i class="fa fa-times-rectangle text-danger mr-10"></i>'.$field_col_name['field_name'].'</a></form>';
                        }
                    }
                ?>                            
                <br><span>Available: </span>
                <div class="dropdown-divider"></div>
            <?php
                $select_field = mysqli_query($conn,"SELECT * FROM field WHERE field_space_id = '$space_id' ORDER BY field_order ASC");
                while($fetch_field = mysqli_fetch_array($select_field))
                {
                    $column_name = $fetch_field['field_col_name'];
                    $select_add_column = mysqli_query($conn, "SELECT * FROM add_column WHERE column_space_id = '$space_id' AND column_user_id = '$user_id' AND column_name = '$column_name'");
                    if(mysqli_num_rows($select_add_column) == 0)
                    { 
                        if($fetch_field['field_type'] == "Textarea")
                        {
                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&column='.$fetch_field['field_col_name'].'">
                                    <i class="fa fa-text-width mr-5"></i> '.$fetch_field['field_name'].'
                            </a>';
                        }
                        else if($fetch_field['field_type'] == "Text")
                        {
                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&column='.$fetch_field['field_col_name'].'">
                                    <i class="fa fa-text-height mr-5"></i> '.$fetch_field['field_name'] .'
                            </a>';
                        }
                        else if($fetch_field['field_type'] == "Email")
                        {
                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&column='.$fetch_field['field_col_name'].'">
                                    <i class="fa fa-envelope-o mr-5"></i> '.$fetch_field['field_name'] .'
                            </a>';
                        }
                        else if($fetch_field['field_type'] == "Dropdown")
                        {
                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&column='.$fetch_field['field_col_name'].'">
                                    <i class="fa fa-angle-double-down mr-5"></i> '.$fetch_field['field_name'] .'
                            </a>';
                        }
                        else if($fetch_field['field_type'] == "Phone")
                        {
                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&column='.$fetch_field['field_col_name'].'">
                                    <i class="fa fa-phone mr-5"></i> '.$fetch_field['field_name'] .'
                            </a>';
                        }
                        else if($fetch_field['field_type'] == "Date")
                        {
                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&column='.$fetch_field['field_col_name'].'">
                                    <i class="fa fa-calendar-o mr-5"></i> '.$fetch_field['field_name'] .'
                            </a>';
                        }
                        else if($fetch_field['field_type'] == "Number")
                        {
                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&column='.$fetch_field['field_col_name'].'">
                                    <i class="fa fa-hashtag mr-5"></i> '.$fetch_field['field_name'] .'
                            </a>';
                        }
                        else
                        {
                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&column='.$fetch_field['field_col_name'].'">
                                    <i class="fa fa-dot-circle-o mr-5"></i> '.$fetch_field['field_name'] .'
                            </a>';
                        }
                    }
                    else
                    { }
                }
            ?>
            </div>
        </div>
    </div>
<!------------ END ADD COLUMN ------------>