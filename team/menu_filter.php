<?php
    $user_id = $row['user_id'];

    // ------------------------------------------------ for counting total filter
    $find_space_id_in_filter = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id'");

    //--------------- status query
    $filter_status = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'status'");

    //--------------- datecreated query
    $filter_date_created = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'datecreated'");
    $fetch_filter_date_created = mysqli_fetch_array($filter_date_created);
    $filter_value_created = $fetch_filter_date_created['filter_value'];

    //--------------- duedate query
    $filter_due_date = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'duedate'");
    $fetch_filter_due_date = mysqli_fetch_array($filter_due_date);
    $filter_value_due_date = $fetch_filter_due_date['filter_value'];

    //--------------- priority query
    $filter_priority = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'priority'");
    $fetch_filter_priority = mysqli_fetch_array($filter_priority);
    $filter_value_priority = $fetch_filter_priority['filter_value'];

    //--------------- tag query
    $filter_tag = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'tag'");
    $fetch_filter_tag = mysqli_fetch_array($filter_tag);
    $tag_filter_value = $fetch_filter_tag['filter_value'];
    $find_tag_name = mysqli_query($conn, "SELECT * FROM tags WHERE tag_id = '$tag_filter_value'");
    $fetch_find_tag_name = mysqli_fetch_array($find_tag_name);

    //--------------- assign query
    $filter_assign = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'assign'");
    $fetch_filter_assign = mysqli_fetch_array($filter_assign);
    $assign_filter_value = $fetch_filter_assign['filter_value'];
    $find_assign_name = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$assign_filter_value'");
    $fetch_find_assign_name = mysqli_fetch_array($find_assign_name);

    //--------------- Normal field query | textarea,text,email,phone,date,number
    $filter_field = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'field'");
    $fetch_filter_field = mysqli_fetch_array($filter_field);
    $field_filter_value = $fetch_filter_field['filter_value'];

    //--------------- location in a variable
    $echo_location = ''."<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>".'';

    if($filter_once == 1) // Allow filter once - because filter is call 3 times
    {
        if(isset($_POST['btn_filter_date_created'])) // add/update filter custom range date create  only one
        {
            $txt_date_created_from = $_POST['txt_date_created_from']; 
            $txt_date_created_to = $_POST['txt_date_created_to']; 
            $filter = "datecreated";
            $filtered_by = $txt_date_created_from .','. $txt_date_created_to;
            if(mysqli_num_rows($filter_date_created) == 0)
            {  
                mysqli_query($conn,"INSERT into `filter` (filter_space_id, filter_user_id, filter_name, filter_value) values ('$space_id','$user_id','$filter','$filtered_by')") or die(mysqli_error());
            }
            else
            {
                mysqli_query($conn, "UPDATE filter SET filter_name = '$filter' , filter_value = '$filtered_by' WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'datecreated'") or die(mysqli_error());
            }   
            echo $echo_location;
        }

        if(!empty($_GET['filter']))
        { 
            $filter = $_GET['filter'];
            $filtered_by = $_GET[$filter];

            if($filter == "status") // add filter status | multiple status selection
            {
                mysqli_query($conn,"INSERT into `filter` (filter_space_id, filter_user_id, filter_name, filter_value) values ('$space_id','$user_id','$filter','$filtered_by')") or die(mysqli_error());    
            }
            else if($filter == "datecreated") // add/update filter datecreated | only one
            {
                if(mysqli_num_rows($filter_date_created) == 0)
                {  
                    mysqli_query($conn,"INSERT into `filter` (filter_space_id, filter_user_id, filter_name, filter_value) values ('$space_id','$user_id','$filter','$filtered_by')") or die(mysqli_error());
                }
                else
                {
                    mysqli_query($conn, "UPDATE filter SET filter_name = '$filter' , filter_value = '$filtered_by' WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'datecreated'") or die(mysqli_error());
                }
            }
            else if($filter == "duedate") // add/update filter duedate | only one
            {
                if(mysqli_num_rows($filter_due_date) == 0)
                {  
                    mysqli_query($conn,"INSERT into `filter` (filter_space_id, filter_user_id, filter_name, filter_value) values ('$space_id','$user_id','$filter','$filtered_by')") or die(mysqli_error());
                }
                else
                {
                    mysqli_query($conn, "UPDATE filter SET filter_name = '$filter' , filter_value = '$filtered_by' WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'duedate'") or die(mysqli_error());
                }
            }
            else if($filter == "priority") // add/update filter priority | only one
            {
                if(mysqli_num_rows($filter_priority) == 0)
                {  
                    mysqli_query($conn,"INSERT into `filter` (filter_space_id, filter_user_id, filter_name, filter_value) values ('$space_id','$user_id','$filter','$filtered_by')") or die(mysqli_error());
                }
                else
                {
                    mysqli_query($conn, "UPDATE filter SET filter_name = '$filter' , filter_value = '$filtered_by' WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'priority'") or die(mysqli_error());
                }
            }
            else  // add/update filter tag, assign & field | only one
            {
            	if($filter == "tag") // add/update filter tag | only one
	            {
	            	$select_TAF = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id='$space_id' AND filter_user_id='$user_id' AND filter_name = 'tag' OR filter_name = 'assign' OR filter_name = 'field'");
	            	if(mysqli_num_rows($select_TAF) == 0)
	                { 
                    	mysqli_query($conn,"INSERT into `filter` (filter_space_id, filter_user_id, filter_name, filter_value) values ('$space_id','$user_id','$filter','$filtered_by')") or die(mysqli_error());
	                }
	                else
	                {
                    	mysqli_query($conn, "UPDATE filter SET filter_name = '$filter' , filter_value = '$filtered_by' WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'tag' OR filter_name = 'assign' OR filter_name = 'field'") or die(mysqli_error());
	                }
	            }
            	if($filter == "assign") // add/update filter tag | only one
	            {
	            	$select_TAF = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id='$space_id' AND filter_user_id='$user_id' AND filter_name = 'tag' OR filter_name = 'assign' OR filter_name = 'field'");
	            	if(mysqli_num_rows($select_TAF) == 0)
	                { 
                    	mysqli_query($conn,"INSERT into `filter` (filter_space_id, filter_user_id, filter_name, filter_value) values ('$space_id','$user_id','$filter','$filtered_by')") or die(mysqli_error());
	                }
	                else
	                {
                    	mysqli_query($conn, "UPDATE filter SET filter_name = '$filter' , filter_value = '$filtered_by' WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'tag' OR filter_name = 'assign' OR filter_name = 'field'") or die(mysqli_error());
	                }
	            }
            	if($filter == "field") // add/update filter tag | only one
	            {
	            	$select_TAF = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id='$space_id' AND filter_user_id='$user_id' AND filter_name = 'tag' OR filter_name = 'assign' OR filter_name = 'field'");
	            	if(mysqli_num_rows($select_TAF) == 0)
	                { 
                    	mysqli_query($conn,"INSERT into `filter` (filter_space_id, filter_user_id, filter_name, filter_value) values ('$space_id','$user_id','$filter','$filtered_by')") or die(mysqli_error());
	                }
	                else
	                {
                    	mysqli_query($conn, "UPDATE filter SET filter_name = '$filter' , filter_value = '$filtered_by' WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'tag' OR filter_name = 'assign' OR filter_name = 'field'") or die(mysqli_error());
	                }
	            }
            }
            echo $echo_location;      
        }

        if(!empty($_GET['delete_filter'])) 
        { 
            $delete_filter = $_GET['delete_filter'];
            $delete_filter_id = $_GET[$delete_filter]; 

            if($delete_filter == "status") // delete filter status 1 by 1
            {
                mysqli_query($conn, "DELETE FROM filter WHERE filter_id = '$delete_filter_id'") or die(mysqli_error());
            }
            else if($delete_filter == "status_all") // delete filter all status
            {
                mysqli_query($conn, "DELETE FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'status'") or die(mysqli_error());    
            }
            else // delete filter datecreated, duedate, priority, tag, assign, field
            {
                mysqli_query($conn, "DELETE FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = '$delete_filter'") or die(mysqli_error());   
            }
            echo $echo_location;  
        }
    }
?>
<!------------ FILTER ------------>
    <div class="dropdown">
        <button type="button" class="btn btn-rounded btn-dual-secondary <?php echo $md_text; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Filter">
            <i class="fa fa-filter"></i>
            <?php 
                if(mysqli_num_rows($find_space_id_in_filter) == 0){}
                else{echo'<span class="badge badge-primary badge-pill">'.mysqli_num_rows($find_space_id_in_filter).'</span>';}
            ?>
        </button>
        <div class="dropdown-menu dropdown-menu-right shadow">
            Filter By:
            <?php 
                    if(mysqli_num_rows($filter_status) != 0)
                    {
                        echo '
                        <form class="dropdown-item">
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&delete_filter=status_all"><i class="fa fa-times-rectangle text-danger mr-5"></i></a>
                            <span style="background-color:#3f9ce8; color: #fff; padding: 3px 10px 3px 10px; border-radius: 50px;">Status = '.mysqli_num_rows($filter_status).'</span>
                        </form>';
                    }
                    if(mysqli_num_rows($filter_date_created) != 0)
                    {
                        echo '
                        <form class="dropdown-item">
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&delete_filter=datecreated"><i class="fa fa-times-rectangle text-danger mr-5"></i></a>
                            <span style="background-color:#3f9ce8; color: #fff; padding: 3px 10px 3px 10px; border-radius: 50px;">Created = '.$fetch_filter_date_created['filter_value'].'</span>
                        </form>';
                    }
                    if(mysqli_num_rows($filter_due_date) != 0)
                    {
                        echo '
                        <form class="dropdown-item">
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&delete_filter=duedate"><i class="fa fa-times-rectangle text-danger mr-5"></i></a>
                            <span style="background-color:#3f9ce8; color: #fff; padding: 3px 10px 3px 10px; border-radius: 50px;">Due date = '.$fetch_filter_due_date['filter_value'].'</span>
                        </form>';
                    }
                    if(mysqli_num_rows($filter_priority) != 0)
                    {
                        echo '
                        <form class="dropdown-item">
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&delete_filter=priority"><i class="fa fa-times-rectangle text-danger mr-5"></i></a>
                            <span style="background-color:#3f9ce8; color: #fff; padding: 3px 10px 3px 10px; border-radius: 50px;">Priority = '.$fetch_filter_priority['filter_value'].'</span>
                        </form>';
                    }
                    if(mysqli_num_rows($filter_tag) != 0)
                    {
                        echo '
                        <form class="dropdown-item">
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&delete_filter=tag"><i class="fa fa-times-rectangle text-danger mr-5"></i></a>
                            <span style="background-color:#3f9ce8; color: #fff; padding: 3px 10px 3px 10px; border-radius: 50px;">Tag = '.$fetch_find_tag_name['tag_name'].'</span>
                        </form>';
                    }
                    if(mysqli_num_rows($filter_assign) != 0)
                    {
                        echo '
                        <form class="dropdown-item">
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&delete_filter=assign"><i class="fa fa-times-rectangle text-danger mr-5"></i></a>
                            <span style="background-color:#3f9ce8; color: #fff; padding: 3px 10px 3px 10px; border-radius: 50px;">Assign = '.$fetch_find_assign_name['fname'].'</span>
                        </form>';
                    }
                    if(mysqli_num_rows($filter_field) != 0)
                    {
                        $value_array = explode(",,", $field_filter_value); // convert string to array

                        echo '
                            <form class="dropdown-item">
                                <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&delete_filter=field"><i class="fa fa-times-rectangle text-danger mr-5"></i></a>';
                        if(count($value_array) == 1) // Normal field | textarea,text,email,phone,date,number
                        {
                            $find_field_name = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id' AND field_col_name = '$field_filter_value'");
                            $fetch_find_field_name = mysqli_fetch_array($find_field_name);
                            $field_name = $fetch_find_field_name['field_name'];
                            echo '<span style="background-color:#3f9ce8; color: #fff; padding: 3px 10px 3px 10px; border-radius: 50px;">Field = '.$field_name.'</span>';
                        }
                        else
                        {   
                            $field_value = $value_array[0]; // get only the id
                            $field_col_name = $value_array[1]; // get field column name
                            $field_type = $value_array[2]; // get field type

                            if($field_type == "dropdown") // Dropdown
                            {
                                $select_child_name = mysqli_query($conn, "SELECT * FROM child WHERE child_id = '$field_value'");
                                $fetch_child_name = mysqli_fetch_array($select_child_name);
                                $child_name = $fetch_child_name['child_name'];

                                $find_field_name = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id' AND field_col_name = '$field_col_name'");
                                $fetch_find_field_name = mysqli_fetch_array($find_field_name);
                                $field_name = $fetch_find_field_name['field_name'];

                                echo '<span style="background-color:#3f9ce8; color: #fff; padding: 3px 10px 3px 10px; border-radius: 50px;">Field = '.$field_name.' |
                                        <span style="color: #fff; padding: 1px 5px; border-radius: 5px; background-color: '.$fetch_child_name['child_color'].'">'.$child_name.'</span>
                                      </span>';
                            }
                            if($field_type == "radio") // Dropdown
                            {
                                $find_field_name = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id' AND field_col_name = '$field_col_name'");
                                $fetch_find_field_name = mysqli_fetch_array($find_field_name);
                                $field_name = $fetch_find_field_name['field_name'];

                                if($field_value == "yes"){ $bg_color = "#00ad1d"; } 
                                else { $bg_color = "#ef5350"; }   

                                echo '<span style="background-color:#3f9ce8; color: #fff; padding: 3px 10px 3px 10px; border-radius: 50px;">Field = '.$field_name.' |
                                        <span style="color: #fff; padding: 1px 5px; border-radius: 5px; background-color: '.$bg_color.';">'.$field_value.'</span>
                                      </span>';
                            }
                        }
                        echo '</form>';
                    }
            ?>
            <hr>
<!------------ Status / Step ------------>
                <span class="filterparent">
                    <form class="dropdown-item filterparent" style="margin-right: -10px;">
                        <i class="si si-equalizer mr-5"></i> Status / Step
                    </form>
                    <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 5px; right: 130px;">
                        <label for="example-datepicker4">Select step</label>
                        <div class="dropdown-divider"></div>                        
                            <div data-toggle="slimscroll" data-height="350px" data-color="#42a5f5" data-opacity="1" data-always-visible="true" style="background-color: #fff; padding: 5px;">
                            <?php
                                $status_array = array();
                                while($fetch_filter_status = mysqli_fetch_array($filter_status))
                                {  
                                    array_push($status_array,$fetch_filter_status['filter_value']);
                                } 
                                // echo ''.implode(",", $status_array).''; //tester

                                $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' ORDER BY status_order_no ASC");
                                while($result_findstatus = mysqli_fetch_array($findstatus))
                                {   
                                    if (in_array($result_findstatus['status_id'], $status_array))
                                    {
                                        $filter_status_value = $result_findstatus['status_id'];
                                        $select_filter_id = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'status' AND filter_value = '$filter_status_value'");
                                        $status_filter_id = mysqli_fetch_array($select_filter_id);
                                        echo '
                                            <button type="button" class="dropdown-item" style="background-color: '.$result_findstatus['status_color'].'; color: #fff">
                                                <a class="btn btn-sm btn-danger" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&delete_filter=status&status='.$status_filter_id['filter_id'].'"><i class="fa fa-times"></i></a>
                                                <i class="fa fa-square mr-5"></i>'.$result_findstatus['status_name'].'
                                            </button>';
                                    }
                                    else
                                    {
                                        echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&filter=status&status='.$result_findstatus['status_id'].'">
                                                <i class="fa fa-square mr-5" style="color: '.$result_findstatus['status_color'].';"></i>'.$result_findstatus['status_name'].'
                                            </a>'; 
                                    }                               
                                }
                            ?>
                        </div>
                    </div>
                </span>
<!------------ Date Created ------------>
                <span class="filterparent">
                    <form class="dropdown-item filterparent" style="margin-right: -10px;">
                        <i class="fa fa-calendar-plus-o mr-5"></i> Date Created
                    </form>
                    <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 40px; right: 130px;">
                        <label for="example-datepicker4">Custom date</label>
                        <form method="post">
                            <div class="form-material">
                                <input type="date" class="js-datepicker form-control" id="example-datepicker4" name="txt_date_created_from" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                <label for="example-datepicker4">From:</label>
                            </div>
                            <div class="form-material">
                                <input type="date" class="js-datepicker form-control" id="example-datepicker4" name="txt_date_created_to" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                <label for="example-datepicker4">To:</label>
                            </div>
                            <div class="form-material">
                                <button class="btn btn-sm btn-noborder btn-alt-primary btn-block" name="btn_filter_date_created"><i class="fa fa-check-square-o"></i> Save</button>
                            </div>
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&filter=datecreated&datecreated=Today">
                            <i class="si si-calendar mr-5"></i> Today
                        </a>
                        <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&filter=datecreated&datecreated=This week">
                            <i class="si si-calendar mr-5"></i> This week
                        </a>
                        <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&filter=datecreated&datecreated=This month">
                            <i class="si si-calendar mr-5"></i> This month
                        </a>
                    </div>
                </span>
<!------------ Duedate ------------>
                <span class="filterparent">
                    <form class="dropdown-item filterparent" style="margin-right: -10px;">
                        <i class="fa fa-calendar-check-o mr-5"></i> Due Date
                    </form>
                    <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 75px; right: 130px;">
                        <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&filter=duedate&duedate=Today">
                            <i class="si si-calendar mr-5"></i> Today
                        </a>
                        <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&filter=duedate&duedate=This week">
                            <i class="si si-calendar mr-5"></i> This week
                        </a>
                        <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&filter=duedate&duedate=This month">
                            <i class="si si-calendar mr-5"></i> This month
                        </a>
                    </div>
                </span>
<!------------ Priority ------------>
                <span class="filterparent">
                    <form class="dropdown-item filterparent" style="margin-right: -10px;">
                        <i class="si si-flag mr-5"></i> Priority
                    </form>
                    <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 110px; right: 130px;">
                        <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&filter=priority&priority=Urgent">
                            <i class="si si-flag text-danger mr-5"></i> Urgent
                        </a>
                        <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&filter=priority&priority=High">
                            <i class="si si-flag text-warning mr-5"></i> High
                        </a>
                        <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&filter=priority&priority=Normal">
                            <i class="si si-flag text-info mr-5"></i> Normal
                        </a>
                        <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&filter=priority&priority=Low">
                            <i class="si si-flag text-gray mr-5"></i> Low
                        </a>
                    </div>
                </span>
<!------------ Tag ------------>
                <span class="filterparent">
                    <form class="dropdown-item filterparent" style="margin-right: -10px;">
                        <i class="si si-tag mr-5"></i> Tag
                    </form>
                    <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 148px; right: 130px;">
                        <?php
                            $que_find_tag = mysqli_query($conn, "SELECT * FROM tags WHERE tag_list_id = '$status_list_id'");
                            while($res_que_find_tag = mysqli_fetch_array($que_find_tag))
                            {
                                echo'<a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&filter=tag&tag='.$res_que_find_tag['tag_id'].'" class="dropdown-item">
                                    <i class="si si-tag mr-5"></i>
                                    <span style="background-color: '.$res_que_find_tag['tag_color'].'; color:#fff; padding:5px 10px; border-radius:50px; font-size: 12px;">
                                        '.$res_que_find_tag['tag_name'].'
                                    </span>
                                </a>';
                            }
                        ?>
                    </div>
                </span>
<!------------ Assign ------------>
                <span class="filterparent">
                    <form class="dropdown-item filterparent" style="margin-right: -10px;">
                        <i class="si si-users mr-5"></i> Assign
                    </form>
                    <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 183px; right: 130px;">

                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text border-0">
                                    <i class="fa fa-search"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control border-0" placeholder="Search.." id="search" onkeyup="filterFunction()">
                        </div>  

                        <div id="myDropdown">
                            <div data-toggle="slimscroll" data-height="350px" data-color="#42a5f5" data-opacity="1" data-always-visible="true" style="background-color: #fff; padding: 5px;">
                                <?php
                                    $search_member = mysqli_query($conn, "SELECT * FROM user ORDER BY fname ASC");
                                    while($find_search_member = mysqli_fetch_array($search_member))
                                    {
                                        $get_first_letter_in_fname = $find_search_member['fname'];                                                               
                                        $get_first_letter_in_lname = $find_search_member['lname'];                                                            
                                        $id_of_user = $find_search_member['user_id'];
                                        echo'
                                        <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&filter=assign&assign='.$find_search_member['user_id'].'" class="dropdown-item">';

                                        if($find_search_member['profile_pic'] != "")
                                        {
                                            echo'<img style="width:28px; border-radius:50px; margin: 0px 10px 0px 0px;" src="../assets/media/upload/'.$find_search_member['profile_pic'].'">';
                                            if($user_id == $id_of_user)
                                            {echo "<span class='text-danger'>Me</span>";}
                                            else
                                            {echo''.$find_search_member['fname'].' '.$find_search_member['mname'].' '.$find_search_member['lname'].'';}
                                        }
                                        else
                                        {
                                            //echo'<img style="width:25px; border-radius:50px; margin: 0px 10px 0px 0px;" src="../assets/media/upload/avatar.jpg">';
                                            echo'<span class="btn btn-sm btn-circle" style="font-size: 11px; width:25px; border-radius:50px; margin: 0px 10px 0px 0px; padding: 8px 0px 0px 0px; color:#fff; background-color: '.$find_search_member['user_color'].'">'.$get_first_letter_in_fname[0].''.$get_first_letter_in_lname[0].'</span>'; 
                                            if($user_id == $id_of_user)
                                            {echo "<span class='text-danger'>Me</span>";}
                                            else
                                            {echo''.$find_search_member['fname'].' '.$find_search_member['mname'].' '.$find_search_member['lname'].'';}
                                        }
                                        echo'</a>'; 
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </span>
<!------------ Custom Field ------------>
                <span class="filterparent">
                    <form class="dropdown-item filterparent" style="margin-right: -10px;">
                        <i class="si si-note mr-5"></i>Custom Field
                    </form>
                    <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 220px; right: 130px;">
                            <span><strong>Note:</strong> Field type: <span class="text-primary">Textarea, Text, Email, Phone, Date & Number</span> will filter task if task has value.</span>
                            <div class="dropdown-divider"></div>
                            <div data-toggle="slimscroll" data-height="350px" data-color="#42a5f5" data-opacity="1" data-always-visible="true" style="background-color: #fff; padding: 5px;">
                                <?php
                                    $select_field = mysqli_query($conn,"SELECT * FROM field WHERE field_space_id = '$space_id' ORDER BY field_order ASC");
                                    while($fetch_field = mysqli_fetch_array($select_field))
                                    {
                                        if($fetch_field['field_type'] == "Textarea")
                                        {
                                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&filter=field&field='.$fetch_field['field_col_name'].'">
                                                    <i class="fa fa-text-width mr-5"></i> '.$fetch_field['field_name'].'
                                            </a>';
                                        }
                                        else if($fetch_field['field_type'] == "Text")
                                        {
                                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&filter=field&field='.$fetch_field['field_col_name'].'">
                                                    <i class="fa fa-text-height mr-5"></i> '.$fetch_field['field_name'] .'
                                            </a>';
                                        }
                                        else if($fetch_field['field_type'] == "Email")
                                        {
                                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&filter=field&field='.$fetch_field['field_col_name'].'">
                                                    <i class="fa fa-envelope-o mr-5"></i> '.$fetch_field['field_name'] .'
                                            </a>';
                                        }
                                        else if($fetch_field['field_type'] == "Dropdown")
                                        {
                                            echo '<button class="dropdown-item" data-toggle="modal" data-target="#modal-filterdropdown" id="filter_dropdown'.$fetch_field['field_id'].'" onclick="filter_dropdown(this.id)">
                                                    <i class="fa fa-angle-double-down mr-5"></i> '.$fetch_field['field_name'] .'
                                            </button>';
                                        }
                                        else if($fetch_field['field_type'] == "Phone")
                                        {
                                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&filter=field&field='.$fetch_field['field_col_name'].'">
                                                    <i class="fa fa-phone mr-5"></i> '.$fetch_field['field_name'] .'
                                            </a>';
                                        }
                                        else if($fetch_field['field_type'] == "Date")
                                        {
                                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&filter=field&field='.$fetch_field['field_col_name'].'">
                                                    <i class="fa fa-calendar-o mr-5"></i> '.$fetch_field['field_name'] .'
                                            </a>';
                                        }
                                        else if($fetch_field['field_type'] == "Number")
                                        {
                                            echo '<a class="dropdown-item" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&filter=field&field='.$fetch_field['field_col_name'].'">
                                                    <i class="fa fa-hashtag mr-5"></i> '.$fetch_field['field_name'] .'
                                            </a>';
                                        }
                                        else // radio
                                        {
                                            echo '<button class="dropdown-item" data-toggle="modal" data-target="#modal-filterradio" id="filter_radio'.$fetch_field['field_id'].'" onclick="filter_radio(this.id)">
                                                    <i class="fa fa-dot-circle-o mr-5"></i> '.$fetch_field['field_name'] .'
                                            </button>';
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                </span>


                <script>
                /*window.onload=function(){
                  document.getElementById("modal").click();
                };*/
                function myFunction() {
                  document.getElementById("myDropdown").classList.toggle("show");
                }

                function filterFunction() {
                  var input, filter, ul, li, a, i;
                  //input = document.getElementById("myInput");
                  input = document.getElementById("search");
                  filter = input.value.toUpperCase();
                  div = document.getElementById("myDropdown");
                  a = div.getElementsByTagName("a");
                  for (i = 0; i < a.length; i++) {
                    txtValue = a[i].textContent || a[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                      a[i].style.display = "";
                    } else {
                      a[i].style.display = "none";
                    }
                  }
                }
                </script>
            <!--<a class="dropdown-item" href="javascript:void(0)">
                <i class="si si-users mr-5"></i> Assign
            </a>-->
        </div>
    </div>

<!------------ END FILTER ------------>