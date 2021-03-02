<?php
// ------------------------------------------------ SORT FUNCTION    
    $find_space_id_in_sort = mysqli_query($conn, "SELECT * FROM sort WHERE sort_space_id = '$space_id' AND sort_user_id = '$user_id'");
    $array_fetch = mysqli_fetch_array($find_space_id_in_sort);
    $sort_id = $array_fetch['sort_id'];
    //a
    if (empty($_GET['sortname'])){}
    else
    {        
        $sortname = $_GET['sortname']; 
        $Ascending = "Ascending";
        $Descending = "Descending";
        if(mysqli_num_rows($find_space_id_in_sort) == 0)
        {  
            mysqli_query($conn,"INSERT into `sort` (sort_space_id, sort_user_id, sort_name, sort_type) values ('$space_id','$user_id','$sortname','$Ascending')") or die(mysqli_error());
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";  
        }
        else
        {
            if($array_fetch['sort_name'] == $sortname)
            {
                if($array_fetch['sort_type'] == $Ascending)
                {
                    mysqli_query($conn, "UPDATE sort SET sort_name = '$sortname' , sort_type = '$Descending' WHERE sort_id = '$sort_id'") or die(mysqli_error());
                    echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
                }
                else
                {                    
                mysqli_query($conn, "UPDATE sort SET sort_name = '$sortname' , sort_type = '$Ascending' WHERE sort_id = '$sort_id'") or die(mysqli_error());
                    echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
                }
            }
            else
            {
                mysqli_query($conn, "UPDATE sort SET sort_name = '$sortname' , sort_type = '$Ascending' WHERE sort_id = '$sort_id'") or die(mysqli_error());
                    echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
            }
        }
    }
    if (empty($_GET['delete_sort'])) 
    {}
    else
    {
        mysqli_query($conn, "DELETE FROM sort WHERE sort_id='$sort_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }
?>
<!------------ SORT ------------>
    <div class="dropdown">
        <button type="button" class="btn btn-rounded btn-dual-secondary <?php echo $md_text; ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Sort"><i class="fa fa-sort"></i>
            <?php 
                if(mysqli_num_rows($find_space_id_in_sort) == 0){}
                else{echo'<span class="badge badge-primary badge-pill">1</span>';}
            ?>
        </button>                                                   
        <div class="dropdown-menu dropdown-menu-right shadow">
            <?php 
                if(mysqli_num_rows($find_space_id_in_sort) == 0){}
                else{
                    echo 'Sort by: <br>
                    <form class="dropdown-item">
                    <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&delete_sort=delete_sort"><i class="fa fa-times-rectangle text-danger mr-5"></i></a><span style="background-color:#3f9ce8; color: #fff; padding: 5px 10px 5px 10px; border-radius: 50px;">'.$array_fetch['sort_name'].' | '.$array_fetch['sort_type'].'</span></form>
                    <hr>';
                }
            ?>
            <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&sortname=Date Created">
                <i class="fa fa-calendar-plus-o mr-5"></i> Date Created
            </a>
            <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&sortname=Due Date">
                <i class="fa fa-calendar-check-o mr-5"></i> Due Date
            </a>
            <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&sortname=Priority">
                <i class="si si-flag mr-5"></i> Priority
            </a>
            <a class="dropdown-item" href="main_dashboard.php?space_name=<?php echo $space_name?>&list_name=<?php echo $list_name ?>&list_id=<?php echo $status_list_id?>&sortname=Task Name">
                <i class="si si-pencil mr-5"></i> Task Name
            </a>
        </div>
    </div>
<!------------ END SORT ------------>