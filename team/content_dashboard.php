<?php
    include("../conn.php");

    if(empty($_GET))
    {}
    else
    {
        $gettask_id = "0";

        if(!empty($_GET['get_task_id']))
        {
            $gettask_id = $_GET['get_task_id'];
        }

        $space_names = $_GET['space_name'];
        $que = mysqli_query($conn,"SELECT space_id FROM space WHERE space_name='$space_names'");
        $res = mysqli_fetch_array($que);
        $space_id = $res['space_id'];

        $status_list_id = $_GET['list_id'];
        $space_name = $_GET['space_name'];
        $list_name = $_GET['list_name'];

        $res = mysqli_query($conn,"SELECT * FROM list WHERE list_space_id='$space_id'");
        $count_list = mysqli_num_rows($res);
        $res1 = mysqli_query($conn,"SELECT * FROM status WHERE status_list_id='$status_list_id'");
        $count_status = mysqli_num_rows($res1);

        $select_tag_for_modal = mysqli_query($conn,"SELECT * FROM tags WHERE tag_list_id='$status_list_id'");
        $count_tag_for_modal = mysqli_num_rows($select_tag_for_modal);

        $select_user_for_modal = mysqli_query($conn,"SELECT * FROM user");
        $count_select_user_for_modal = mysqli_num_rows($select_user_for_modal);
    }

    if(isset($_POST['btn_rename_list']))
    {
        $list_name = $_POST['list_name'];
        $status_list_id = $_GET['list_id'];
        $update = mysqli_query($conn, "UPDATE list SET list_name='$list_name' WHERE list_id='$status_list_id'") or die(mysqli_error());
        if($update)
        {
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
        else
        {
            echo "<script type='text/javascript'>alert('Cannot rename list, please contact admin.');</script>";
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
    }

    if(isset($_POST['btn_delete_list']))
    {
        $count_status = $_POST['count_status'];
        $count_list = $_POST['count_list'];
        if($count_status == 0)
        {
            if($count_list == 1)
            {
                echo "<script type='text/javascript'>alert('Note: Cannot delete this list, a space must have atleast 1 list.');</script>";
                echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
            }
            else
            {
                $delete_list = mysqli_query($conn, "DELETE FROM list WHERE list_id='$status_list_id'") or die(mysqli_error());
                if($delete_list)
                {
                    echo "<script>document.location='dashboard.php'</script>";
                }
                else
                {
                    echo "<script type='text/javascript'>alert('Cannot delete list, please contact admin.');</script>";
                    echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
                }
            }
        }
        else
        {
            echo "<script type='text/javascript'>alert('Note: Delete all status to delete this list.');</script>";
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
    }

    if(isset($_POST['btn_add_status']))
    {
        $status_name = $_POST['status_name'];

        // _______________ Objective:
        // Main: Avoid same color for every status if possible
        // 1. Get the difference of array from DEFINE Color to Database color
        // 2. Random the difference color
            $search_color = mysqli_query($conn, "SELECT status_color FROM status WHERE status_list_id='$status_list_id'");
            $color_array_from_db = array(); // ex: array("#39595C","#9000AD");
            while($fetch_color = mysqli_fetch_array($search_color))
            {
                $color = $fetch_color['status_color'];
                array_push($color_array_from_db,$color); // add the db color to array
            }

            $color_array = array("#d60606","#b90453","#ca0b85","#ce19c1","#AD00A1","#9000AD","#5600AD","#440386","#330365","#0015AD","#005FAD","#0088AD","#00ADA9","#00AD67","#038e56","#05981d","#017514","#00AD1D","#6FAD00","#8ad00c","#bfc304","#AD9000","#d47604","#e67f01","#AD5F00","#827a71","#7da6ab","#5C797C","#3a4e50","#000000");
            $difference_in_2_array = array_diff($color_array, $color_array_from_db); // get the difference of 2 array
            if(empty($difference_in_2_array)) // if true then: random the Define color
            {
                $randIndex = array_rand($color_array);
                $status_color = $color_array[$randIndex];
            }
            else // else random the difference color
            {
                $randarray_color = array_rand($difference_in_2_array);
                $status_color = $difference_in_2_array[$randarray_color];
            }
            $status_color;
        // _______________ End Objective

        $con = mysqli_query($conn, "SELECT * FROM status WHERE status_name='$status_name' AND status_list_id='$status_list_id'");
        if(mysqli_num_rows($con) == 0)
        {
            $find_status = mysqli_query($conn,"SELECT * FROM status WHERE status_list_id = '$status_list_id' ORDER BY status_order_no DESC LIMIT 1");
            $fetch_status = mysqli_fetch_array($find_status);
            if(mysqli_num_rows($find_status) == 0)
            {
                $status_order_no = 0;
            }
            else
            {
                $status_order_no = $fetch_status['status_order_no'] + 1;
            }

            $insert = mysqli_query($conn,"INSERT into `status` (status_order_no, status_name, status_color, status_list_id, status__date_created) values ('$status_order_no','$status_name','$status_color','$status_list_id', NOW())") or die(mysqli_error());
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
        else
        {
            echo "<script type='text/javascript'>alert('Status name already exists. Please try again.');</script>";
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
    }

    if(isset($_POST['btn_rename_tag']))
    {
        $tag_id = $_POST['tag_id'];
        $tag_name = $_POST['tag_name'];
        $update = mysqli_query($conn, "UPDATE tags SET tag_name='$tag_name' WHERE tag_id = '$tag_id'") or die(mysqli_error());
        if($update)
        {
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
        else
        {
            echo "<script type='text/javascript'>alert('Cannot rename tag, please contact admin.');</script>";
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
    }
    if(isset($_POST['btn_delete_tag']))
    {
        $num = 0;
        $list_id = $_GET['list_id'];
        $tag_id = $_POST['tag_id'];
        $selete_task = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id'");
        if (mysqli_num_rows($selete_task) == 0) // check if has task in list
        {
            $delete = mysqli_query($conn, "DELETE FROM tags WHERE tag_id = '$tag_id'") or die(mysqli_error());
            if($delete)
            {
                echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
            }
            else
            {
                echo "<script type='text/javascript'>alert('Cannot delete tag, please contact admin.');</script>";
                echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
            }
        }
        else
        {
            while($fetch_task = mysqli_fetch_array($selete_task))
            {
                $get_task_tag = $fetch_task['task_tag'];
                $tag_array = explode(",", $get_task_tag); // convert string to array
                if (in_array($tag_id, $tag_array))
                {
                    $num ++;
                }
            }

            if($num == "0")
            {
                $delete = mysqli_query($conn, "DELETE FROM tags WHERE tag_id = '$tag_id'") or die(mysqli_error());
                if($delete)
                {
                    echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
                }
                else
                {
                    echo "<script type='text/javascript'>alert('Cannot delete tag, please contact admin.');</script>";
                    echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
                }
            }
            else
            {
                echo "<script type='text/javascript'>alert('Cannot delete tag already assign to task, delete that tag to specific task first.');</script>";
                echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
            }
        }
    }

    if(isset($_POST['btn_rename_space']))
    {
        $name = $_POST['space_name'];
        $update = mysqli_query($conn, "UPDATE space SET space_name='$name' WHERE space_id='$space_id'") or die(mysqli_error());
        if($update)
        {
            $status_list_id = $_GET['list_id'];
            $list_name = $_GET['list_name'];
            echo "<script>document.location='main_dashboard.php?space_name=$name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
        else
        {
            echo "<script type='text/javascript'>alert('Cannot rename space, please contact admin.');</script>";
            echo "<script>document.location='main_dashboard.php?space_name=$name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
    }
    if(isset($_POST['btn_add_list']))
    {
        $add_list = $_POST['add_list'];
        $con = mysqli_query($conn, "SELECT * FROM list WHERE list_name='$add_list'");
        if(mysqli_num_rows($con) == 0)
        {
            $insert = mysqli_query($conn,"INSERT INTO `list` (list_name, list_space_id) values ('$add_list','$space_id')") or die(mysqli_error());
            if($insert)
            {
                $status_list_id = $_GET['list_id'];
                $list_name = $_GET['list_name'];
                echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
            }
            else
            {
                echo "<script type='text/javascript'>alert('Cannot add list, please contact admin.');</script>";
                echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
            }
        }
        else
        {
            echo "<script type='text/javascript'>alert('List name already exists. Please try again.');</script>";
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
    }

    if(isset($_POST['btn_delete_space']))
    {
        $count_status = $_POST['count_status'];
        $count_list = $_POST['count_list'];

        if($count_list == 1)
        {
            if($count_status == 0)
            {
                $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$space_id'");
                $fetch_select_space = mysqli_fetch_array($select_space);
                $table_name = $fetch_select_space['space_db_table'];

                $select_space_sort = mysqli_query($conn, "SELECT * FROM space_sort");
                $count_sort = mysqli_num_rows($select_space_sort);
                if($count_sort != 0) // check if has sorting in admin then delete the space sort id
                {
                    $delete_space_sort = mysqli_query($conn, "DELETE FROM space_sort WHERE sort_space_id='$space_id'") or die(mysqli_error());
                }

                $status_list_id = $_GET['list_id'];
                mysqli_query($conn, "DELETE FROM list WHERE list_id='$status_list_id'") or die(mysqli_error());
                $delete_space = mysqli_query($conn, "DELETE FROM space WHERE space_id='$space_id'") or die(mysqli_error());
                $sql = "DROP TABLE `$table_name`";
                if (mysqli_query($conn, $sql))
                {}
                else
                {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
                }
                echo "<script>document.location='dashboard.php'</script>";
            }
            else
            {
                echo "<script type='text/javascript'>alert('Note: Delete all status to delete space.');</script>";
                echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
            }
        }
        else
        {
            echo "<script type='text/javascript'>alert('Note: You can delete space if you have only one list, make sure to delete other list.');</script>";
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
    }
?>


<?php
    if(isset($_POST["btn_modal_add_tag"]))
    {
        $txt_add_tag = $_POST['txt_modal_add_tag'];
        $arrX = array("#f5b1b1","#f8bdf9","#ccb8fb","#b4c8f5","#a3d1d6","#a5d8bc","#b5e094","#e8d17b","#f5ba87","#c7a5a5");
        $randIndex = array_rand($arrX);
        $tagcolors = $arrX[$randIndex];

        mysqli_query($conn,"INSERT into `tags` (tag_name, tag_list_id, tag_color) values ('$txt_add_tag','$status_list_id','$tagcolors')") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }

    if(isset($_POST["btn_modal_status_names"]))
    {
        $modal_status_id = $_POST['modal_status_id'];
        $modal_status_names = $_POST['modal_status_names'];
        mysqli_query($conn, "UPDATE status SET status_name='$modal_status_names' WHERE status_id='$modal_status_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }

    if (empty($_GET['delete_status']))
    {}
    else
    {
        $modal_status_id = $_GET['status_id'];
        $res1 = mysqli_query($conn,"SELECT * FROM task WHERE task_status_id='$modal_status_id'");
        $count_task = mysqli_num_rows($res1);
        if($count_task == 0)
        {
            mysqli_query($conn, "DELETE FROM status WHERE status_id='$modal_status_id'") or die(mysqli_error());
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
        else
        {
            echo "<script type='text/javascript'>alert('Note: Cannot delete status with task, make sure to delete all task of the particular status.');</script>";
        }
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }

    function get_times_array( $default = '19:00', $interval = '+30 minutes' )
    {
        $output = '';
        $current = strtotime( '00:00' );
        $end = strtotime( '23:59' );

        while( $current <= $end ) {
            $time = date( 'H:i', $current );
            $sel = ( $time == $default ) ? '' : '';
            //$sel = ( $time == $default ) ? ' selected' : '';   // 7:00 pm

            $output .= "<option value=\"{$time}\"{$sel}>" . date( 'h.i A', $current ) .'</option>';
            $current = strtotime( $interval, $current );
        }
        return $output;
    }
?>
<!-- tab that fucos when page refresh -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<style>
    a{color:#575757;text-decoration:none}
    .bs-example li:hover {background-color: #fff;color: #3f9ce8;}
    .bs-example li.active {color: #fff;background-color: #abadaf;}
    .nav{padding-left:0;margin-bottom:0;list-style:none; background-color: #dedede;}
    .nav>li>a{position:relative;display:block;padding: 14px 16px;transition: 0.3s;font-size: 17px;}
    .bs-example a.active {
        color: #fff;
        background-color: #abadaf;
    }
    .tab-content {
      padding: 6px 12px;
      border-top: none;
    }
</style>
<input type="hidden" id="total_user" value="<?php echo $count_select_user_for_modal; ?>">
<input type="hidden" id="total_tag" value="<?php echo $count_tag_for_modal; ?>">
<input type="hidden" id="task_id_when_click">

<div class="bs-example">
    <ul class="nav nav-tabs" id="myTab">
        <li><a data-toggle="tab" href="#sectionA">List </a></li>
        <!-- <li><a data-toggle="tab" id="<?php echo $mode_type;?>,<?php echo $row['user_id'];?>,<?php echo $space_id;?>,<?php echo $status_list_id;?>" onclick="view_board_fetch_status(this.id)" href="#sectionB">Board <?php echo $filter_tag; ?></a></li> -->
        <li><a target="blank_" href="./main_board.php?space_name=<?php echo $_GET['space_name']; ?>&list_name=<?php echo $_GET['list_name']; ?>&list_id=<?php echo $_GET['list_id']; ?>">Board</a></li>
        <li><a target="blank_" href="./main_box.php?space_name=<?php echo $_GET['space_name']; ?>&list_name=<?php echo $_GET['list_name']; ?>&list_id=<?php echo $_GET['list_id']; ?>">Box</a></li>
        <!-- <li><a data-toggle="tab" href="#sectionC">Box</a></li> -->
    </ul>
    <div class="tab-content">
        <!-- List View -->
        <div id="sectionA" class="tab-pane fade in">
            <?php
                $status_list_id = $_GET['list_id'];
                $space_name = $_GET['space_name'];
                $list_name = $_GET['list_name'];
                $filter_once = 0;
                include('view_header_list.php');
            ?>
            <!--<div style="overflow: auto; height: 455px;">-->
            <div>
                <div id="accordion2" role="tablist" aria-multiselectable="true">
                    <?php include('view_list_fetch_status.php'); ?>
                </div>
            </div>
        </div>
        <!-- END List View -->

        <!-- Board -->
        <div id="sectionB" class="tab-pane fade">
            <?php
                $status_list_id = $_GET['list_id'];
                $space_name = $_GET['space_name'];
                $list_name = $_GET['list_name'];
                $filter_once = 0;
                //include('view_header_board.php');
            ?>
                <!-- Main Container -->
                <main id="main-container" style="margin-top: -10px;">
                    <!--<div class="scrumboard js-scrumboard" id="board_view" style="margin-left: -11px;">
                    </div>-->

                    <!-- Scrum Board -->
                    <div class="scrumboard js-scrumboard" style="overflow-y: hidden; margin: -20px 0px 0px -11px;">
                        <?php // include('view_board_fetch_status.php'); ?>
                    <?php
                    if($user_type == "Admin")
                    { ?>
                        <!-- Add Column -->
                        <div class="scrumboard-col block block-themed block-transparent">
                            <form method="post">
                                <div class="block-header bg-gray">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text border-0">
                                                <i class="fa fa-plus"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control border-0" placeholder="Add status..." name="status_name" id="status_id" required="">
                                        <button type="submit" hidden="hidden" class="btn btn-rounded btn-noborder btn-primary btn-block" name="btn_add_status"><i class="fa fa-plus"></i> Create</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- END Add Column -->
                    <?php } ?>
                    </div>
                    <!-- END Scrum Board -->
                </main>
                <!-- END Main Container -->
        </div>
        <!-- Board -->

        <!-- Box -->
        <div id="sectionC" class="tab-pane fade">
            <?php
                $status_list_id = $_GET['list_id'];
                $space_name = $_GET['space_name'];
                $list_name = $_GET['list_name'];
                $filter_once = 1;
                //include('view_header_box.php');
            ?>
                <!-- Main Container -->
                <main id="main-container" style="margin-top: -30px;">
                    <?php // include('view_box_fetch.php'); ?>
                </main>
                <!-- END Main Container -->
        </div>
        <!-- End Box -->
    </div>
</div>
<!-- End tab that fucos when page refresh -->


<?php $id = $row['user_id'];?>
<script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
<script src="../assets/js/jquery.min.js"></script>
<script>
    // function view_board_fetch_status(id){
    //     array = id.split(",")
    //     mode_type = array[0];
    //     user_id = array[1];
    //     space_id = array[2];
    //     status_list_id = array[3];

    //     $.ajax({
    //         url: 'view_board_fetch_status.php',
    //         type: 'POST',
    //         async: false,
    //         data:{
    //             mode_type: mode_type,
    //             user_id:user_id,
    //             space_id: space_id,
    //             status_list_id:status_list_id,
    //             view_board:1,
    //         },
    //             success: function(response){
    //                 $('#view_board_fetch_status').html(response);
    //             }
    //     });
    // }

$(document).ready(function(){
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e)
  {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });
  var activeTab = localStorage.getItem('activeTab');
  if(activeTab)
  {
    $('#myTab a[href="' + activeTab + '"]').tab('show');
  }
});
</script>
        <script>
            function openCity(evt, cityName) {
              var i, tabcontent, tablinks;
              tabcontent = document.getElementsByClassName("tabcontent");
              for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
              }
              tablinks = document.getElementsByClassName("tablinks");
              for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
              }
              document.getElementById(cityName).style.display = "block";
              evt.currentTarget.className += " active";
            }
            // Get the element with id="active_tab" and click on it
            //document.getElementById("active_tab").click();
        </script>

<!-- Board view modal -->
    <style type="text/css">
        .horizontal{
            border-bottom: 1px solid #e2e2e2;
        }
        .vertical{
            border-right:1px solid #e2e2e2;
        }
        .image-upload>input {
          display: none;
        }
        .bott{
            display: none;
        }
        .parentss:hover .bott {
        display: block;
        cursor: pointer;
        }
    </style>
    <script>
    // For image upload -------------------------------
        $(document).ready(function(){
            $('#send_comment').on('click', function(){
                var image = document.getElementById("image").value;
                if(image == "")
                {
                    id = <?php echo $id; ?>;
                    var task_id = document.getElementById("task_id_when_click").value;
                    $msg = $('#commentmsg').val();
                    $.ajax({
                        type: "POST",
                        url: "send_comment.php",
                        data: {
                            id: id,
                            task_id:task_id,
                            msg: $msg,
                        },
                        success: function(){
                            $('#commentmsg').val("");
                            displayChat();
                        }
                    });
                }
                else
                {
                    var image = $('#image');
                    var image_data = image.prop('files')[0];
                    var formData = new FormData();
                    formData.append('image', image_data);

                    var task_id = $('#task_id_when_click').val();
                    formData.append("task_id", task_id);
                    var msg = $('#commentmsg').val();
                    formData.append("msg", msg);

                    $.ajax({
                        url: "send_comment.php",
                        type: "POST",
                        data: formData,

                        contentType:false,
                        cache: false,
                        processData: false,
                        success: function(data){
                            if(data == "success"){
                                cancel_image();
                                $('#commentmsg').val("");
                                displayChat();
                            }else if(data == "error1"){
                                alert("Please upload file first!");
                            }else if(data == "error2"){
                                alert('Wrong file format');
                            }else{
                                alert('Upload attachment not greater than 3 MB.');
                            }
                        }
                    });
                }
            });

            //Delete
            $(document).on('click', '.delete_comment', function(){
                if(confirm("Are you sure you want to delete this comment?"))
                {
                    $id=$(this).val();
                    $.ajax({
                        type: "POST",
                        url: "ajax_delete_comment.php",
                        data: {
                            id: $id,
                            del: 1,
                        },
                        success: function(data){
                            if(data != '')
                            {}
                            else
                            {
                                alert('Comment deleted!');
                                displayChat();
                            }
                        }
                    });
                }
                else
                {
                    return false;
                }
            });
        });

        function displayChat(){
            var id = <?php echo $id; ?>;
            var task_id = document.getElementById("task_id_when_click").value;
            $.ajax({
                url: 'fetch_comment.php',
                type: 'POST',
                async: false,
                data:{
                    id: id,
                    task_id:task_id,
                    fetch: 1,
                },
                    success: function(response){
                        $('#comment_area').html(response);
                        $("#comment_area").scrollTop($("#comment_area")[0].scrollHeight);
                    }
            });
        }
    </script>
<script>
    function close_task()
    {
        var space_name = "<?php echo $space_name; ?>";
        var list_name = "<?php echo $list_name; ?>";
        var status_list_id = <?php echo $status_list_id; ?>;
        var user_type = "<?php echo $_SESSION['user_type']; ?>";

        if (user_type == "Admin") {
            document.location = 'main_dashboard.php?space_name='+space_name+'&list_name='+list_name+'&list_id='+status_list_id+'';
        } else {
            document.location = 'dashboard.php';
        }
    }

    gettask_id = <?php echo $gettask_id; ?>;
    if(gettask_id != "0") // if task is click from everything page
    {
        id = "taskmodal" + gettask_id;
        var a = id;
        var task_id = a.replace("taskmodal", ""); // Remove the string id "taskmodal";
        document.getElementById("task_id_when_click").value = task_id; // passing the task_id

        $(document).ready(function()
        {
            id = <?php echo $id; ?>;
            var task_id = document.getElementById("task_id_when_click").value;
            $.ajax({
                url: 'fetch_comment.php',
                type: 'POST',
                async: false,
                data:{
                    id: id,
                    task_id:task_id,
                    fetch: 1,
                },
                    success: function(response){
                        $('#comment_area').html(response);
                        $("#comment_area").scrollTop($("#comment_area")[0].scrollHeight);
                    }
            });
        });

        $(document).ready(function(){
            display_input_field();
            //display_finance_field();
            display_contact();
            phase_selector();
            display_requirements();
            display_requirement_comment();
            display_status();
            display_task_info();
            fill_input();
            display_email_history_table();
        });
        function display_contact()
        {
            var task_id = document.getElementById("task_id_when_click").value;
            var user_type = "<?php echo $user_type; ?>";
            $.ajax({
                url:"ajax_task_contact.php",
                method:"post",
                data:{
                    user_type:user_type,
                    task_id:task_id
                },
                success:function(response){
                    $('#contact_id').html(response);
                }
           });
        }
    }

    function fill_input()
    {
        task_id = document.getElementById("task_id_when_click").value;
        document.getElementById("txt_task_id").value = task_id;
        document.getElementById("modal_txt_due_date").value = task_id;
        document.getElementById("modal_txt_priority").value = task_id;
        document.getElementById("modal_txt_rename").value = task_id;
        var abc = document.getElementById("rename" + task_id).value;
        document.getElementById("modal_txt_task_name").value = abc;

        document.getElementById("modal_txt_delete").value = task_id;

        var total_tag =  document.getElementById("total_tag").value
        for(var i = 1; i<=total_tag; i++)
        {
            document.getElementById("modal_tag" + i).value = task_id;
        }

        var total_user =  document.getElementById("total_user").value
        for(var i = 1; i<=total_user; i++)
        {
            document.getElementById("modal_assign" + i).value = task_id;
        }
    }

    function show_task_modal(id)
    {
        var a = id;
        var task_id = a.replace("taskmodal", ""); // Remove the string id "taskmodal";
        document.getElementById("task_id_when_click").value = task_id; // passing the task_id
        fill_input();

        $(document).ready(function()
        {
            id = <?php echo $id; ?>;
            var task_id = document.getElementById("task_id_when_click").value;
            $.ajax({
                url: 'fetch_comment.php',
                type: 'POST',
                async: false,
                data:{
                    id: id,
                    task_id:task_id,
                    fetch: 1,
                },
                    success: function(response){
                        $('#comment_area').html(response);
                        $("#comment_area").scrollTop($("#comment_area")[0].scrollHeight);
                    }
            });
        });

        $(document).ready(function(){
            display_input_field();
            //display_finance_field();
            display_contact();
            phase_selector();
            display_requirements();
            display_requirement_comment();
            display_status();
            display_task_info();
            
            fill_input();
            display_email_history_table();
        });
        function display_contact()
        {
            var task_id = document.getElementById("task_id_when_click").value;
            var user_type = "<?php echo $user_type; ?>";
            $.ajax({
                url:"ajax_task_contact.php",
                method:"post",
                data:{
                    user_type:user_type,
                    task_id:task_id
                },
                success:function(response){
                    $('#contact_id').html(response);
                }
           });
        }
    }

    function phase_selector()
    {
        var space_id = <?php echo $space_id; ?>;
        $.ajax({
            url:"ajax.php",
            method:"post",
            data:{
                space_id:space_id,
                phase_select:1
            },
            success:function(response){
                $('#phase_selector').html(response);
            }
       });
    }

    function update_contact()
    {
        var admin_contact_id = document.getElementById("admin_contact_id").value;
        var admin_fname = document.getElementById("admin_fname").value;
        var admin_mname = document.getElementById("admin_mname").value;
        var admin_lname = document.getElementById("admin_lname").value;
        var admin_bdate = document.getElementById("admin_bdate").value;
        var admin_gender = document.getElementById("admin_gender").value;
        var admin_email = document.getElementById("admin_email").value;
        var admin_fbname = document.getElementById("admin_fbname").value;
        var admin_messenger = document.getElementById("admin_messenger").value;
        var admin_country = document.getElementById("admin_country").value;
        var admin_city = document.getElementById("admin_city").value;
        var admin_zip = document.getElementById("admin_zip").value;
        var admin_street = document.getElementById("admin_street").value;
        var admin_cnumber = document.getElementById("admin_cnumber").value;
        var admin_location = document.getElementById("admin_location").value;
        var admin_status = document.getElementById("admin_status").value;
        var admin_nationality = document.getElementById("admin_nationality").value;

        $.ajax({
            url:"ajax_task_contact.php",
            method:"post",
            data:{
                admin_fname:admin_fname,
                admin_mname:admin_mname,
                admin_lname:admin_lname,
                admin_bdate:admin_bdate,
                admin_gender:admin_gender,
                admin_email:admin_email,
                admin_fbname:admin_fbname,
                admin_messenger:admin_messenger,
                admin_country:admin_country,
                admin_city:admin_city,
                admin_zip:admin_zip,
                admin_street:admin_street,
                admin_cnumber:admin_cnumber,
                admin_location:admin_location,
                admin_contact_id:admin_contact_id,
                admin_status:admin_status,
                admin_nationality:admin_nationality,
                update_contact: 1,
            },
            success:function(response){
                alert('Contact updated.');
                display_contact();
            }
        });
    }

    function display_task_info(){
        var task_id = document.getElementById("task_id_when_click").value;
        $.ajax({
            url: 'ajax_task_modal.php',
            type: 'POST',
            async: false,
            data:{
                task_id:task_id,
            },
                success: function(response){
                    $('#information_id').html(response);
                }
        });
    }
</script>
<script>
// For modal information -------------------------------
    function display_requirements(){
        task_id = document.getElementById("task_id_when_click").value;
        space_id = <?php echo $space_id; ?>;
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: false,
            data:{
                task_id:task_id,
                space_id:space_id,
                display_requirements: 1,
            },
                success: function(response){
                    $('#requirements_field_in_task').html(response);
                }
        });
    }
    function display_input_field()
    {
        var task_id = document.getElementById("task_id_when_click").value;
        var space_id = <?php echo $space_id; ?>;
        list_id = <?php echo $status_list_id; ?>;
        $.ajax({
            url:"ajax_input_field.php",
            method:"post",
            data:{space_id:space_id,
                list_id:list_id,
                task_id:task_id},
            success:function(data){
                 $('#input_field_id').html(data);
                 $('#modal-extra-large').modal("show");
            }
       });
    }
    /*function display_finance_field()
    {
        var task_id = document.getElementById("task_id_when_click").value;
        var space_id = <?php echo $space_id; ?>;
        $.ajax({
            url:"ajax.php",
            method:"post",
            data:{
                task_id:task_id,
                space_id:space_id,
                display_finance_field:1,
            },
            success:function(data){
                 $('#finance_fetch_field_id').html(data);
            }
       });
    }*/
    // ----------------------- MODAL UPPER OPTION / ADD DETAILS -----------------------
    function display_status()
    {
        var task_id = document.getElementById("task_id_when_click").value;
        list_id = <?php echo $status_list_id; ?>;
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: false,
            data:{
                task_id:task_id,
                list_id:list_id,
                fetch_status: 1,
            },
            success: function(response){
                $('#view_status_id').html(response);
            }
        });
    }
    function display_email_name()
    {
        var task_id = document.getElementById("task_id_when_click").value;
        list_id = <?php echo $status_list_id; ?>;
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: false,
            data:{
                task_id:task_id,
                list_id:list_id,
                fetch_email_name: 1,
            },
            success: function(response){
                // display_email_history_table();
                $('#view_email_name').html(response);
            }
        });
    }

    function fetch_email_name(id)
    {   
        // alert ('');
        user_id = <?php echo $row['user_id']; ?>;
        var task_id = document.getElementById("task_id_when_click").value;
        var contact_email = document.getElementById("contact_email" + id).value;
        var email_subject = document.getElementById("email_subject" + id).value;
        var email_id = id;
        var email_name = document.getElementById("email_name" + id).value;
        var FirstName = document.getElementById("contact_fname" + id).value;
        // alert(FirstName);
        // modal_id = 'taskmodal'+task_id;
        // alert(modal_id);
        if(confirm("Are you sure you want to send this email?"))
        {
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                async: false,
                data:{
                    email_name:email_name,
                    get_email_content_to_be_send: 1,
                },
                success: function(data){
                    // get email content base on email name then paste to textarea id="email_content"
                    document.getElementById("email_content").value = data;
                    email_content = document.getElementById("email_content").value;
                    $.ajax({
                        url: 'ajax.php',
                        type: 'POST',
                        async: false,
                        data:{
                            test_email:contact_email,
                            email_subject:email_subject,
                            email_content:email_content,
                            FirstName:FirstName,
                            test_send_email: 1,
                        },
                        success: function(data){
                            // Send emai to specific email address
                            if (data == 'Email sent successfully.')
                            {
                                $.ajax({
                                    url: 'ajax.php',
                                    type: 'POST',
                                    async: false,
                                    data:{
                                        user_id:user_id,
                                        task_id:task_id,
                                        contact_email:contact_email,
                                        email_id:email_id,
                                        email_send_history: 1,
                                    },
                                        success: function(data){
                                            $('#modal-popout').modal("hide");
                                            $('#modal-extra-large').modal("show");
                                            $('#modal-extra-large').css('overflow-y', 'auto');
                                            // $('#modal-extra-large').focus();
                                            display_email_history_table();
                                            alert(data);
                                        }
                                });
                            }
                            else
                            {
                                alert(data);
                            }
                        }
                    });
                }
            });
        }
    }

    function move_task(id)
    {
        var status_id = id.replace("move_task", "");
        if(confirm("Are you sure you want to move this task?"))
        {
            var task_id = document.getElementById("task_id_when_click").value;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        task_id:task_id,
                        status_id:status_id,
                        move_task: 1,
                    },
                    success: function(data){
                        if(data == "move")
                        {
                            alert("Task move successfully.");
                            display_status();
                        }
                        else
                        {
                            alert("Task cant move, please contact admin.");
                        }
                    }
                });
            });
        }
        else
        {}
    }
    function btn_modal_Urgent()
    {
        var priority = "D Urgent";
        if(confirm("Are you sure you want to make this urgent?"))
        {
            var task_id = document.getElementById("task_id_when_click").value;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        priority:priority,
                        task_id:task_id,
                        add_priority: 1,
                    },
                    success: function(){
                        display_task_info();
                    }
                });
            });
        }
        else
        {}
    }
    function btn_modal_High()
    {
        var priority = "C High";
        if(confirm("Are you sure you want to make this high?"))
        {
            var task_id = document.getElementById("task_id_when_click").value;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        priority:priority,
                        task_id:task_id,
                        add_priority: 1,
                    },
                    success: function(){
                        display_task_info();
                    }
                });
            });
        }
        else
        {}
    }
    function btn_modal_Normal()
    {
        var priority = "B Normal";
        if(confirm("Are you sure you want to make this normal?"))
        {
            var task_id = document.getElementById("task_id_when_click").value;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        priority:priority,
                        task_id:task_id,
                        add_priority: 1,
                    },
                    success: function(){
                        display_task_info();
                    }
                });
            });
        }
        else
        {}
    }
    function btn_modal_Low()
    {
        var priority = "A Low";
        if(confirm("Are you sure you want to make this low?"))
        {
            var task_id = document.getElementById("task_id_when_click").value;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        priority:priority,
                        task_id:task_id,
                        add_priority: 1,
                    },
                    success: function(){
                        display_task_info();
                    }
                });
            });
        }
        else
        {}
    }
    function btn_modal_Clear()
    {
        var priority = "";
        if(confirm("Are you sure you want to clear the priority?"))
        {
            var task_id = document.getElementById("task_id_when_click").value;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        priority:priority,
                        task_id:task_id,
                        add_priority: 1,
                    },
                    success: function(){
                        display_task_info();
                    }
                });
            });
        }
        else
        {}
    }
    function assign_member(id)
    {
        var member_id = id.replace("assign_member", "");
        list_id = <?php echo $status_list_id; ?>;
        if(confirm("Are you sure you want to assign that member in this task?"))
        {
            var task_id = document.getElementById("task_id_when_click").value;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        member_id:member_id,
                        list_id:list_id,
                        task_id:task_id,
                        assign_member: 1,
                    },
                    success: function(data){
                        if(data == "error1")
                        {alert('Member already assign to that task.');}
                        else { display_task_info(); }
                    }
                });
            });
        }
        else
        {}
    }
    function add_due_date()
    {
        var txt_date = document.getElementById("txt_date").value;
        var txt_time = document.getElementById("txt_time").value;
        if(confirm("Are you sure you want to add due date in this task?"))
        {
            var task_id = document.getElementById("task_id_when_click").value;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        task_id:task_id,
                        txt_date:txt_date,
                        txt_time:txt_time,
                        add_due_date: 1,
                    },
                    success: function(){
                        display_task_info();
                    }
                });
            });
        }
        else
        {}
    }
    function assign_tag(id)
    {
        var tag_id = id.replace("assign_tag", "");
        if(confirm("Are you sure you want to add tag in this task?"))
        {
            var task_id = document.getElementById("task_id_when_click").value;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        tag_id:tag_id,
                        task_id:task_id,
                        assign_tag: 1,
                    },
                    success: function(data){
                        if(data == "error1")
                        {alert('Tag already assign to that task.');}
                        else { display_task_info(); }
                    }
                });
            });
        }
        else
        {}
    }
    function rename_task(id)
    {
        var user_type = "<?php echo $user_type; ?>";
        if(user_type == "Member")
        {
            alert('Cannot rename task by member, to rename this task please contact to admin. Thank you.')
        }
        else
        {
            if(confirm("Are you sure you want to rename this task?"))
            {
                var task_id = document.getElementById("task_id_when_click").value;
                var txt_modal_name = document.getElementById("modal_txt_task_name").value;
                $(document).ready(function(){
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            task_id:task_id,
                            txt_modal_name:txt_modal_name,
                            rename_task: 1,
                        },
                        success: function(){
                            display_task_info();
                        }
                    });
                });
            }
        }
    }
    function delete_task()
    {
        var user_type = "<?php echo $user_type; ?>";
        if(user_type == "Member")
        {
            alert('Cannot delete task by member, to delete this task please contact to admin. Thank you.')
        }
        else
        {
            if(confirm("Are you sure you want to delete this task? Contact details, profile and task will be remove to specific space."))
            {
                var task_id = document.getElementById("task_id_when_click").value;
                space_id = <?php echo $space_id; ?>;
                list_id = <?php echo $status_list_id; ?>;
                $(document).ready(function(){
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            space_id:space_id,
                            list_id:list_id,
                            task_id:task_id,
                            delete_task: 1,
                        },
                        success: function(data){
                            if(data == "error1")
                            {alert('Cannot delete task with assign contact.');}
                            else { alert('Task deleted.'); location.reload(); }
                        }
                    });
                });
            }
            else
            {}
        }
    }
    // ----------------------- END MODAL UPPER OPTION / ADD DETAILS -----------------------

    // ----------------------- MODAL REMOVE DETAILS -----------------------
    function remove_priority(id)
    {
        var task_id = id.replace("remove_priority", "");
        if(confirm("Are you sure you want to remove the priority of this task?"))
        {
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        task_id:task_id,
                        remove_priority: 1,
                    },
                    success: function(){
                        display_task_info();
                    }
                });
            });
        }
        else
        {}
    }
    function remove_assign(id)
    {
        var assign_id = id.replace("remove_assign", "");
        var list_id = <?php echo $status_list_id; ?>;
        if(confirm("Are you sure you want to remove this assign of this task?"))
        {
            var task_id = document.getElementById("task_id_when_click").value;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        list_id:list_id,
                        task_id:task_id,
                        assign_id:assign_id,
                        remove_assign: 1,
                    },
                    success: function(){
                        display_task_info();
                    }
                });
            });
        }
        else
        {}
    }
    function remove_due_date(id)
    {
        var task_id = id.replace("remove_due_date", "");
        if(confirm("Are you sure you want to remove the due date of this task?"))
        {
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        task_id:task_id,
                        remove_due_date: 1,
                    },
                    success: function(){
                        display_task_info();
                    }
                });
            });
        }
        else
        {}
    }
    function remove_tag(id)
    {
        var tag_id = id.replace("remove_tag", "");
        if(confirm("Are you sure you want to remove this assign of this task?"))
        {
            var task_id = document.getElementById("task_id_when_click").value;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        task_id:task_id,
                        tag_id:tag_id,
                        remove_tag: 1,
                    },
                    success: function(){
                        display_task_info();
                    }
                });
            });
        }
        else
        {}
    }
    // -----------------------  END MODAL REMOVE DETAILS -----------------------


    // -----------------------  CODE FOR ADDING TASK -----------------------
    function add_task_space_id(select)
    {
        $('#add_task_list_id')
            .find('option')
            .remove()
            .end()
            .append('<option value="">----- New option -----</option>')
        ;// clear and add value to list combobox

         $('#add_task_status_id')
            .find('option')
            .remove()
            .end()
            .append('<option value="">----- New option -----</option>')
        ;// clear and add value to status combobox
        space_id = (select.options[select.selectedIndex].value); // get space id
        //alert(space_id); //tester

        <?php
            include_once '../conn.php';
            $findlist = mysqli_query($conn, "SELECT * FROM list");
            while($result_findlist = mysqli_fetch_array($findlist))
            {?>
                if (space_id == '<?php echo $result_findlist['list_space_id'] ?>')
                {
                    var x = document.getElementById("add_task_list_id");
                    var option = document.createElement("option");
                    option.value = "<?php echo $result_findlist['list_id'] ?>";
                    option.text = "<?php echo $result_findlist['list_name'] ?>";
                    x.add(option);
                }
            <?php
            }
        ?>
    }
    function add_task_list_id(select)
    {
        $('#add_task_status_id')
            .find('option')
            .remove()
            .end()
            .append('<option value="">----- New option -----</option>')
        ;// clear and add value to status combobox

        list_id = (select.options[select.selectedIndex].value); // get list id
        //alert(list_id); //tester
        <?php
            include_once '../conn.php';
            $findstatus = mysqli_query($conn, "SELECT * FROM status ORDER BY status_order_no ASC");
            while($result_findstatus = mysqli_fetch_array($findstatus))
            {?>
                if (list_id == '<?php echo $result_findstatus['status_list_id'] ?>')
                {
                    var x = document.getElementById("add_task_status_id");
                    var option = document.createElement("option");
                    option.style.backgroundColor  = "<?php echo $result_findstatus['status_color'] ?>";
                    option.style.color = "#ffffff";
                    option.value = "<?php echo $result_findstatus['status_id'] ?>";
                    option.text = "<?php echo $result_findstatus['status_name'] ?>";
                    x.add(option);
                }
            <?php
            }
        ?>
    }
    function add_task_status_id(select)
    {
        status_id = (select.options[select.selectedIndex].value); // get list id
        //alert(status_id); //tester
    }
    function add_task_click_contact(id)
    {
        a = id;
        document.getElementById("add_task_contact_id").value = a;
        add_task_name = document.getElementById("add_task_name" + a).value;
        document.getElementById("add_task_task_name").value = add_task_name;
    }
    function add_task_cancel()
    {
        document.getElementById("add_task_space_id").value = "";
        document.getElementById("add_task_list_id").value = "";
        document.getElementById("add_task_status_id").value = "";
        document.getElementById("add_task_contact_id").value = "";
        document.getElementById("add_task_task_name").value = "";
    }
    function close_add_task_modal()
    {
        add_task_cancel();
    }
    function add_task_save()
    {
        user_id = <?php echo $id; ?>;
        space_id = document.getElementById("add_task_space_id").value;
        list_id = document.getElementById("add_task_list_id").value;
        status_id = document.getElementById("add_task_status_id").value;
        contact_id = document.getElementById("add_task_contact_id").value;
        task_name = document.getElementById("add_task_task_name").value;

        if(space_id == "")
        { alert("Please select space."); }
        else if(list_id == "")
        { alert("Please select list."); }
        else if(status_id == "")
        { alert("Please select status."); }
        else if (contact_id == "")
        { alert("Please select contact below."); }
        else if (task_name == "")
        {  alert("Please input task name."); }
        else
        {
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: {
                    user_id:user_id,
                    space_id:space_id,
                    list_id:list_id,
                    status_id:status_id,
                    contact_id:contact_id,
                    task_name:task_name,
                    add_task_save: 1,
                },
                success: function(){
                    alert('Task added successfully')
                    location.reload();
                }
            });
        }
    }
    // ----------------------- END CODE FOR ADDING TASK -----------------------
</script>


<!-- MODAL for adding task -->
<div class="modal" id="modal-add_task" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title text-center">Add task</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close" onclick="close_add_task_modal()"> <i class="si si-close"></i> </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label>Space</label>
                                    <select class="form-control" id="add_task_space_id" onchange="add_task_space_id(this)">
                                        <option value="">Please select</option>
                                            <?php
                                                $findspace = mysqli_query($conn, "SELECT * FROM space ORDER BY space_name ASC");
                                                while($result_findspace = mysqli_fetch_array($findspace))
                                                {
                                                    echo'<option value="'.$result_findspace['space_id'].'">'.$result_findspace['space_name'].'</option>';
                                                }
                                            ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>List</label>
                                    <select class="form-control" id="add_task_list_id" onchange="add_task_list_id(this)">
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label>Status</label>
                                    <select class="form-control" id="add_task_status_id" onchange="add_task_status_id(this)">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-15">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-md-5 col-form-label">Contact ID</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control text-center" id="add_task_contact_id" readonly="">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group-prepend">
                                        <input class="form-control" placeholder="Task name..." id="add_task_task_name" >
                                            <button type="button" class="btn btn-sm btn-danger" title="Cancel" onclick="add_task_cancel()">
                                                <i class="fa fa-eraser"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary" title="Save" onclick="add_task_save()">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <h4 class="text-muted">Assigned contact list</h4>
                            <!-- Dynamic Table Full -->
                            <table class="table table-bordered table-striped table-vcenter js-dataTable-full table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th>Name</th>
                                        <th class="d-none d-sm-table-cell">Email</th>
                                        <th class="d-none d-sm-table-cell">Number</th>
                                        <th class="text-center">Profile</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $findcontact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_assign_to != '' ORDER BY contact_fname ASC");
                                        while($result_finduser = mysqli_fetch_array($findcontact))
                                        {
                                            echo '
                                            <tr id="'.$result_finduser['contact_id'].'" onclick="add_task_click_contact(this.id)">
                                                <input type="hidden" value="'.$result_finduser['contact_fname'].' '.$result_finduser['contact_mname'].' '.$result_finduser['contact_lname'].'" id="add_task_name'.$result_finduser['contact_id'].'">
                                                <td class="text-center">'.$result_finduser['contact_id'].'</td>
                                                <td class="font-w600">';
                                                    echo''.$result_finduser['contact_fname'].' '.$result_finduser['contact_mname'].' '.$result_finduser['contact_lname'].'';
                                                    echo'
                                                </td>
                                                <td class="d-none d-sm-table-cell">'.$result_finduser['contact_email'].'</td>
                                                <td class="d-none d-sm-table-cell">'.$result_finduser['contact_cpnum'].'</td>';
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
                            <!-- END Dynamic Table Full -->
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL for adding task -->



    <!-- Task Modal -->
    <style type="text/css">
        .dark-blue{
            color: #fff;background-color: #045d71;border-color: #93d2e0;
        }
        .dark-blue:hover{
            color: #fff;background-color: #ff9b05;border-color: #fff;
        }
    </style>

    <!-- task modal -->
    <div class="modal fade" id="modal-extra-large" tabindex="-1" role="dialog" aria-labelledby="modal-extra-large" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content" style="background-color: #ffffff00;">
                <div style="margin: -10px 0px -5px 0px;">

                    <!-- Top option -->
                    <div class="row mt-5">
                        <div class="dropdown ml-15 mr-5">
                            <button type="button" class="btn btn-sm mb-5 dark-blue" data-toggle="dropdown"><i class="si si-equalizer"></i></button>
                            <div class="dropdown-menu dropdown-menu-left shadow">
                                <div data-toggle="slimscroll" data-height="350px" data-color="#42a5f5" data-opacity="1" data-always-visible="true" style="background-color: #fff; padding: 5px;">
                                    <input type="hidden" name="txt_task_ids" id="txt_task_id" value="">
                                    <input type="hidden" name="txt_status_id" id="txt_status_id" value="">
                                    <span id="view_status_id">
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown mr-5">
                            <button type="button"  data-dismiss="modal" class="btn btn-sm mb-5 dark-blue" data-toggle="modal" data-target="#modal-popout"><i class="si si-envelope"></i></button>
                            <!-- <button type="button" class="btn btn-sm mb-5 dark-blue" data-toggle="dropdown"><i class="si si-envelope"></i></button>
                            <div class="dropdown-menu dropdown-menu-left shadow">
                                <div data-toggle="slimscroll" data-height="350px" data-color="#42a5f5" data-opacity="1" data-always-visible="true" style="background-color: #fff; padding: 5px;">
                                    <textarea class="form-control mb-15" id="email_content" rows="12" style="display: none;"></textarea>
                                    <span id="view_email_name"></span>
                                </div>
                            </div> -->
                        </div>
                        <div class="dropdown mr-5">
                            <button class="btn btn-sm dark-blue" data-toggle="dropdown"><i class="si si si-flag"></i></button>
                                <div class="dropdown-menu dropdown-menu-left shadow">
                                    <input type="hidden" name="txt_modal_priority" id="modal_txt_priority" value="">
                                    <button type="button" class="dropdown-item" onclick="btn_modal_Urgent()">
                                        <i class="si si-flag text-danger mr-10"></i> Urgent
                                    </button>
                                    <button type="button" class="dropdown-item" onclick="btn_modal_High()">
                                        <i class="si si-flag text-warning mr-10"></i> High
                                    </button>
                                    <button type="button" class="dropdown-item" onclick="btn_modal_Normal()">
                                        <i class="si si-flag text-info mr-10"></i> Normal
                                    </button>
                                    <button type="button" class="dropdown-item" onclick="btn_modal_Low()">
                                        <i class="si si-flag text-gray mr-10"></i> Low
                                    </button>
                                    <button type="button" class="dropdown-item" onclick="btn_modal_Clear()">
                                        <i class="fa fa-times text-danger mr-10"></i> Clear
                                    </button>
                                </div>
                        </div>
                        <div class="dropdown mr-5">
                            <button class="btn btn-sm dark-blue" data-toggle="dropdown"><i class="si si-user-follow"></i></button>
                            <form method="post">
                                <div class="dropdown-menu dropdown-menu-left shadow">
                                    <div data-toggle="slimscroll" data-height="350px" data-color="#42a5f5" data-opacity="1" data-always-visible="true" style="background-color: #fff; padding: 5px;">
                                        <?php
                                            $assign_num = 1;
                                            $search_member = mysqli_query($conn, "SELECT * FROM user ORDER BY fname ASC");
                                            while($find_search_member = mysqli_fetch_array($search_member))
                                            {
                                                $get_first_letter_in_fname = $find_search_member['fname'];
                                                $get_first_letter_in_lname = $find_search_member['lname'];
                                                echo'
                                                <input type="hidden" name="txt_modal_assign_task_id" id="modal_assign'.$assign_num++.'" value="">
                                                <input type="hidden" name="txt_modal_user_id" value="'.$find_search_member['user_id'].'">
                                                <button type="button" class="dropdown-item" style="border-radius: 50px;" id="assign_member'.$find_search_member['user_id'].'" onclick="assign_member(this.id)">';
                                                    if($find_search_member['profile_pic'] != "")
                                                    {
                                                        echo'<img style="width:28px; height:28px; border-radius:50px; margin: 0px 10px 0px 0px;" src="../assets/media/upload/'.$find_search_member['profile_pic'].'">';
                                                    }
                                                    else
                                                    {
                                                        echo'<span class="btn btn-sm btn-circle" style="font-size: 11px; width:25px; border-radius:50px; margin: 0px 10px 0px 0px; padding: 8px 0px 0px 0px; color:#fff; background-color: '.$find_search_member['user_color'].'">'.$get_first_letter_in_fname[0].''.$get_first_letter_in_lname[0].'</span>';
                                                    }
                                                echo''.$find_search_member['fname'].' '.$find_search_member['mname'].' '.$find_search_member['lname'].'
                                                </button>';
                                            }
                                        ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="dropdown mr-5">
                            <button class="btn btn-sm dark-blue" data-toggle="dropdown"><i class="fa fa-calendar-check-o"></i></button>
                            <form method="post">
                                <div class="dropdown-menu dropdown-menu-left shadow">
                                    <div class="form-material">
                                        <input type="hidden" name="txt_modal_due_date_task_id" id="modal_txt_due_date" value="">
                                        <input type="date" class="js-datepicker form-control" id="txt_date" name="txt_modal_due_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                        <label for="example-datepicker4">Choose a date</label>
                                    </div>
                                    <div class="form-material">
                                        <select class="form-control" id="txt_time" name="txt_modal_due_time">
                                            <option>...</option>
                                            <?php echo get_times_array();?>
                                        </select>
                                        <label for="material-select">Select time</label>
                                    </div>
                                    <div class="form-material">
                                        <button type="button" class="btn btn-sm btn-noborder btn-alt-primary btn-block" onclick="add_due_date()"><i class="fa fa-calendar-check-o"></i> Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="dropdown mr-5">
                            <button class="btn btn-sm dark-blue" data-toggle="dropdown"><i class="si si-tag"></i></button>
                            <div class="dropdown-menu dropdown-menu-left shadow">
                                <?php
                                    $tag_num = 1;
                                    $search_tag = mysqli_query($conn, "SELECT * FROM tags WHERE tag_list_id = '$status_list_id' ORDER BY tag_name ASC");
                                    while($find_tag = mysqli_fetch_array($search_tag))
                                    {
                                        echo'<input type="hidden" name="txt_modal_tag_task_id" id="modal_tag'.$tag_num++.'" value="">
                                            <input type="hidden" name="txt_modal_tag_id" value="'.$find_tag['tag_id'].'">
                                            <button type="button" class="dropdown-item" style="background-color: '.$find_tag['tag_color'].'; color:#fff; border-radius: 50px;" id="assign_tag'.$find_tag['tag_id'].'" onclick="assign_tag(this.id)">'.$find_tag['tag_name'].'</button>
                                            ';
                                    }
                                ?>
                            </div>
                        </div>
                        <div class="dropdown mr-5">
                            <button class="btn btn-sm dark-blue" data-toggle="dropdown"><i class="si si-pencil"></i></button>
                                <div class="dropdown-menu dropdown-menu-left shadow">
                                    <div class="form-material">
                                        <label for="lock-password">Name: </label>
                                        <input type="hidden" name="txt_modal_task_id" id="modal_txt_rename" value="">
                                        <input type="text" name="txt_modal_name" id="modal_txt_task_name" value="" style="margin: 5px 0px; border-radius: 5px; background: #f0f2f5; color: #041b2d;" required>
                                        <button type="button" class="btn btn-sm btn-noborder btn-alt-primary btn-block" onclick="rename_task()"><i class="fa fa-check"></i> Save</button>
                                    </div>
                                </div>
                        </div>
                        <div class="dropdown mr-5">
                            <input type="hidden" name="txt_modal_delete" id="modal_txt_delete" value="">
                            <button type="button" class="btn btn-sm dark-blue" onclick="delete_task()"><i class="si si-trash"></i></button>
                        </div>
                    </div>
                    <!-- END Top option -->

                </div>

                <!-- Task information -->
                <div class="block block-themed block-transparent mb-0" id="information_id"></div>
                <!-- END Task information -->

                <!-- Task contact -->
                <div class="block-content" style="background-color: #f0f2f5;">
                    <div class="block block-mode-hidden">
                        <div class="block-header block-header-default" style="background-color: #0d7694;">
                            <h3 class="block-title text-white">Contact</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                            </div>
                        </div>
                        <div class="block-content shad" id="contact_id">
                        </div>
                    </div>
                </div>
                <!-- END Task contact -->

                <!-- Task payment -->
                <div class="block-content" style="background-color: #f0f2f5;">
                    <div class="block block-mode-hidden">
                        <div class="block-header block-header-default" style="margin-top: -20px; background-color: #0d7694;">
                            <h3 class="block-title text-white">Payment details</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                            </div>
                        </div>
                        <div class="block-content shad">
                            <h4 class="text-muted">Field area</h4>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <!-- Dropdown for list of phases -->
                                            <span id="phase_selector">
                                            </span>
                                            <input type="hidden" value="" id="txt_select_phase">
                                        </div>
                                        <div class="col-md-2">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <input type="hidden" class="form-control" id="edit_payment_id" readonly>
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control" id="edit_payment_name" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input class="form-control" style="text-align: right;" id="field_amount_per_task" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                                        <div class="input-group-prepend">
                                                            <button type="button" class="btn btn-sm btn-danger" title="Cancel" onclick="cancel_field_amount_per_task()">
                                                                <i class="fa fa-eraser"></i>
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-primary" title="Save" id="save_field_amount_per_task" onclick="save_field_amount_per_task()">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12" id="finance_container">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <h4 class="text-muted">Transaction area</h4>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <!--<input type="text" class="form-control" id="disc_id" readonly>-->
                                        <div class="col-md-4">
                                            <label for="contact1-firstname">Discount ID</label>
                                            <input type="text" class="form-control text-center" id="disc_id" readonly>
                                            <!--<select class="form-control text-muted" style="width: 100%;" id="disc_percentage" onchange="percentage_select(this)">
                                                <option></option>
                                                <?php
                                                    for($x = 1; $x <= 100; $x++)
                                                    {
                                                        echo '<option value="'.$x.'">'.$x.'%</option>';
                                                    }
                                                ?>
                                            </select>-->
                                        </div>
                                        <div class="col-md-4">
                                            <label for="contact1-firstname">Discounted amount</label>
                                            <input type="text" class="form-control text-center" id="disc_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="contact1-lastname">Option</label>
                                            <button type="button" class="btn btn-md btn-noborder btn-primary btn-block" onclick="add_discount()"><li class="fa fa-check"></li> Save</button>
                                        </div>
                                    </div>
                                    <hr style="height:1px;border-width:0;color:gray;background-color:gray">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Transaction date: <span class="text-danger" style="font-size: 12px;">(Require)</span></label>
                                                <div class="col-md-7">
                                                    <input type="hidden" class="form-control" id="disc_id" readonly>
                                                    <input type="date" class="form-control" id="tran_date" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Remittance: <span class="text-danger" style="font-size: 12px;">(Require)</span></label>
                                                <div class="col-md-7">
                                                    <select class="form-control text-muted" style="width: 100%;" id="tran_method" required>
                                                        <option disabled="" selected=""></option>
                                                        <?php 
                                                        $query = mysqli_query($conn, "SELECT * FROM tbl_remittance") or die(mysqli_error());
                                                        while ($row = mysqli_fetch_array($query)) {
                                                            echo '<option value="'.$row['remit_value'].'">'.$row['remit_name'].'</option>';
                                                        }
                                                         ?>
                                                        <!-- <option value="BDO PI">BANCO DE ORO (PESO Account) - IPASS</option>
                                                        <option value="BDO DI">BANCO DE ORO (DOLLAR Account) - IPASS</option>
                                                        <option value="BDO PJ">BANCO DE ORO (PESO Account) - Joyce O. Parungao</option>
                                                        <option value="BDO DJ">BANCO DE ORO (DOLLAR Account) - Joyce O. Parungao</option>
                                                        <option value="BPI P">BPI Savings (PESO Account)</option>
                                                        <option value="BPI D">BPI Dollar Account</option>
                                                        <option value="PAL. PAWN.">Palawan Pawnshop</option>
                                                        <option value="ML">MLhuillier</option>
                                                        <option value="PP">Paypal</option> -->
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Transaction No.: <span class="text-danger" style="font-size: 12px;">(Require)</span></label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" id="tran_transaction_no" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Payment amount: <span class="text-danger" style="font-size: 12px;">(Require)</span></label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_amount">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Bank charge:</label>
                                                <div class="col-md-4">
                                                    <?php
                                                    if($user_type == "Admin")
                                                    { ?>
                                                        <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_charge">
                                                    <?php
                                                    }
                                                    else
                                                    { ?>
                                                        <input type="text" class="form-control" readonly id="tran_charge">
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                                <div class="col-md-3">
                                                    <?php
                                                    if($user_type == "Admin")
                                                    { ?>
                                                    <select class="form-control text-muted" style="width: 100%;" id="tran_charge_type">
                                                        <option value=""></option>
                                                        <option value="PHP">Philippine peso (PHP)</option>
                                                        <option value="USD">U.S. dollar (USD)</option>
                                                    </select>
                                                    <?php
                                                    }
                                                    else
                                                    { ?>
                                                        <input type="text" class="form-control" readonly id="tran_charge_type">
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Client rate: <span class="text-danger" style="font-size: 12px;">(Require)</span></label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_client_rate">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Currency: <span class="text-danger" style="font-size: 12px;">(Require)</span></label>
                                                <div class="col-md-7">
                                                    <select class="form-control text-muted" style="width: 100%;" id="tran_currency" onchange="currency_select(this)">
                                                    <option value=""></option>
                                                    <?php
                                                        $currency_option = mysqli_query($conn, "SELECT * FROM finance_currency ORDER BY currency_name ASC");
                                                        while($fetch = mysqli_fetch_array($currency_option))
                                                        {
                                                            echo '
                                                            <option value="'.$fetch['currency_code'].'">'.$fetch['currency_name'].' ('.$fetch['currency_code'].')</option>
                                                            ';
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Note:</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" id="tran_note">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Initial amount:</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_initial" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Rate in USD(‎$):</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_usd_rate" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Amount in USD(‎$):</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_usd_total" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Rate in PHP(‎₱):</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_php_rate" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Amount in PHP(‎₱):</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_php_total" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Client amount in PHP(‎₱):</label>
                                                <div class="col-md-7">
                                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_client_php_total" readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Attachment: <span class="text-danger" style="font-size: 12px;">(Require)</span></label>
                                                <div class="col-md-7">
                                                    <input type="file" class="form-control bg-corporate inputlable" id="tran_attachment" style="padding: 3px 5px;" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-5 col-form-label">Option:</label>
                                                <div class="col-md-7">
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <button type="button" class="btn btn-md btn-noborder btn-danger btn-block" onclick="clear_transac()"><li class="fa fa-eraser"></li> Cancel</button>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <button type="button" class="btn btn-md btn-noborder btn-primary btn-block mb-15" onclick="save_transac()"><li class="fa fa-check"></li> Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                                    <div class="form-group row">
                                        <!-- Transaction Table for each finance phase -->
                                        <div class="col-md-12" id="transaction_table">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Task payment -->

                <!-- Task requirement -->
                <div class="block-content" style="background-color: #f0f2f5;">
                    <div class="block block-mode-hidden">
                        <div class="block-header block-header-default" style="margin-top: -20px; background-color: #0d7694;">
                            <h3 class="block-title text-white">Requirements</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                            </div>
                        </div>
                        <div class="block-content shad">
                            <div class="form-group row">
                                <div class="col-md-6 mb-15">
                                    <div style="background-color: #f7f7f7; padding: 15px;" class="shad" >
                                        <div data-toggle="slimscroll" data-height="280px" data-color="#42a5f5" data-opacity="1" data-always-visible="true" id="requirements_field_in_task">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div style="background-color: #f7f7f7; padding: 15px;" class="shad">
                                        <div class="form-group row">
                                            <div class="col-md-12">
                                                <textarea type="text" class="form-control" placeholder="Comment..." style="height: 35px;" id="requirement_message" ></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row" style="margin-top: -10px; margin-bottom: -5px;">
                                            <div class="col-md-6">
                                                <div class="custom-file">
                                                    <input type="file" class="form-control bg-corporate inputlable" id="requirement_attachement" style="padding: 3px 5px;">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-md btn-noborder btn-danger btn-block" onclick="cancel_requirement_comment()"><li class="fa fa-eraser"></li> Cancel</button>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-md btn-noborder btn-primary btn-block mb-15" onclick="send_requirement_comment()"><li class="fa fa-send"></li> Send</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div data-toggle="slimscroll" data-height="195px" data-color="#42a5f5" data-opacity="1" data-always-visible="true" style="background-color: #fff;">
                                            <table class="js-table-checkable table table-hover table-vcenter">
                                                <tbody id="requirement_comment_area">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Task requirement -->

                <!-- Task Email History -->
                <div class="block-content" style="background-color: #f0f2f5;">
                    <div class="block block-mode-hidden">
                        <div class="block-header block-header-default" style="margin-top: -20px; background-color: #0d7694;">
                            <h3 class="block-title text-white">Email History</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div data-toggle="slimscroll" data-height="480px">
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
                                        <tbody class="js-table-sections-header" id="email_history_table">
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Email History -->

                <!-- Hide/Show status in client Portal -->
                <div class="block-content" style="background-color: #f0f2f5;">
                    <div class="block block-mode-hidden">
                        <div class="block-header block-header-default" style="margin-top: -20px; background-color: #0d7694;">
                            <h3 class="block-title text-white">Status</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <label style="text-align: center;font-weight: bold;">List of Status</label>
                                    <div data-toggle="slimscroll" data-height="300px" data-color="#42A5F5">
                                        <table class="table table table-hover">
                                            <tbody class="js-table-sections-header" id="hide_status">
                                            </tbody>
                                        </table> 
                                    </div>
                                </div>
                                <div class="col-md-6">
                                6 ni nga ika duha   

                                </div>

                            </div>
                            
                        </div>
                    </div>
                </div>
                <!-- END Hide/Show status in client Portal -->

                <div class="block-content"  style="background-color: #f0f2f5;">
                    <div class="row items-push">

                        <!-- Task input field -->
                        <div class="col-md-6" style="margin: -20px 0px 40px 0px;">
                            <div  style="box-shadow:0px 2px 4px #b3b3b3;">
                                <div data-toggle="slimscroll" data-height="480px" data-color="#42a5f5" data-opacity="1" data-always-visible="true" style="background-color: #fff; padding: 15px;" id="input_field_id">
                                </div>
                            </div>
                        </div>
                        <!-- END Task input field -->

                        <!-- Task comment -->
                        <div class="col-md-6"  style="margin: -20px 0px 20px 0px;">
                            <div style="background-color: #fff;box-shadow:0px 2px 4px #b3b3b3;">
                                <div data-toggle="slimscroll" data-height="390px">
                                    <table class="js-table-checkable table table-hover table-vcenter">
                                        <tbody id="comment_area">
                                            <?php include('fetch_comment.php'); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <hr style="margin: 0px 0px -20px 0px; padding: 20px 0px 0px 0px;">
                                <span class="parentss" id="imageparent" style="display: none; padding-top: 10px;">
                                    <button type="button" class="bott btn-block-option btn" onclick="cancel_image()" style="margin: 0px 0px -28px 0px;">
                                          <i class="si si-close btn-danger" style="border-radius: 10px; margin: 20px 0px 10px 0px;"></i>
                                    </button>
                                    <img id="blah" src="" style="width: 150px; height: auto; margin: 5px 0px 5px 10px; border-radius: 10px; box-shadow: 0 8px 6px -6px #dedede;">
                                </span>
                                <span class="parentss" id="fileparent" style="display: none;">
                                    <button type="button" class="bott btn-block-option btn" onclick="cancel_file()" style="margin: 0px 0px -28px 0px;">
                                          <i class="si si-close btn-danger" style="border-radius: 10px;"></i>
                                    </button>
                                    <span id="filename" style="padding-left: 20px"></span>
                                </span>
                                <div class="input-group block-header bg-default-lighter" style="margin-top: 20px;">
                                    <div class="image-upload">
                                        <label class="btn btn-square btn-success min-width-30" for="image">
                                            <i class="si si-paper-clip"></i>
                                        </label>
                                        <input type="file" id="image" onchange="showname()"/>
                                    </div>
                                    <textarea type="text" class="form-control" placeholder="Comment..." id="commentmsg" style="margin-top: -5px; height: 35px;"></textarea>
                                    <div class="block-options">
                                        <button type="button" class="btn btn-rounded btn-noborder btn-primary min-width-30" id="send_comment" ><i class="fa fa-send"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Task comment -->

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Task Modal -->


<script type="text/javascript">
phase_id = document.getElementById("txt_select_phase").value;
transaction_container = document.getElementById('transaction_table');
finance_container = document.getElementById('finance_container');
if(phase_id == "")
{
    no_selected();
}
function no_selected()
{
    transaction_container.innerHTML += '<div class="table-responsive">' +
        '<table class="table table-bordered table-striped table-hover shad">' +
            '<thead>' +
                '<tr>' +
                    '<th class="text-left">Date</th>' +
                    '<th class="text-left">Remittance</th>' +
                    '<th class="text-left">Trans_no</th>' +
                    '<th class="text-center">Currency</th>' +
                    '<th class="text-center">Amount</th>' +
                    '<th class="text-center">Charge</th>' +
                    '<th class="text-center">Initial</th>' +
                    '<th class="text-center">Rate(USD | PHP)</th>' +
                    '<th class="text-right">Amount(USD)</th>' +
                    '<th class="text-right">Amount(PHP)</th>' +
                '</tr>' +
            '</thead>' +
            '<tbody>' +
                '<tr>' +
                    '<td colspan="8" class="text-right font-w600">Total Paid:</td>' +
                    '<td class="text-right font-w600">$0.00</td>' +
                    '<td class="text-right font-w600">₱0.00</td>' +
                '</tr>' +
                '<tr>' +
                    '<td colspan="8" class="text-right font-w600">Deposit:</td>' +
                    '<td class="text-right font-w600">$0.00</td>' +
                    '<td class="text-right font-w600">₱0.00</td>' +
                '</tr>' +
                '<tr class="table-success">' +
                    '<td colspan="8" class="text-right font-w600 text-uppercase">Balance:</td>' +
                    '<td class="text-right font-w600">$0.00</td>' +
                    '<td class="text-right font-w600">₱0.00</td>' +
                '</tr>' +
            '</tbody>' +
        '</table>' +
    '</div>';
    finance_container.innerHTML += '<div class="table-responsive">' +
        '<table class="table table-bordered table-striped table-hover shad">' +
            '<thead>' +
                '<tr>' +
                    '<th class="text-left">ID</th>' +
                    '<th class="text-left">Payment_name</th>' +
                    '<th class="text-right" style="width: 20%;">CURRENCY</th>' +
                    '<th class="text-right" style="width: 20%;">AMOUNT(USD)</th>' +
                '</tr>' +
            '</thead>' +
            '<tbody>' +
                '<tr class="table-success">' +
                    '<td colspan="3" class="text-right font-w600">Total Amount:</td>' +
                    '<td class="text-right font-w600">0.00</td>' +
                '</tr>' +
            '</tbody>' +
        '</table>' +
    '</div>';
}
function status3(select)
{
	clear_amount_per_task();
    var user_type = "<?php echo $user_type; ?>";
    task_id = document.getElementById("task_id_when_click").value;
    phase_id = (select.options[select.selectedIndex].value); // get phase id
    document.getElementById("txt_select_phase").value = phase_id;
    phase_id1 = document.getElementById("txt_select_phase").value;

    transaction_container.innerHTML = "";
    finance_container.innerHTML = "";

    if(phase_id1 == "")
    {
        no_selected();
    }
    else
    {
        view_field_area_table();
        display_discount();
        view_transaction_per_phase();
    }
}
function view_field_area_table()
{
    user_type = "<?php echo $user_type; ?>";
    task_id = document.getElementById("task_id_when_click").value;
    phase_id = document.getElementById("txt_select_phase").value;
    $.ajax({
        url:"ajax.php",
        method:"post",
        data:{
            user_type:user_type,
            task_id:task_id,
            phase_id:phase_id,
            fetch_finance_field_by_phase: 1,},
        success:function(response){
             $('#finance_container').html(response);
        }
    });
}
function display_discount()
{
    task_id2 = document.getElementById("task_id_when_click").value;
    phase_id2 = document.getElementById("txt_select_phase").value;
	$.ajax({
	    url: 'ajax.php',
	    type: 'POST',
	    async: false,
	    data:{
	        task_id2:task_id2,
	        phase_id2:phase_id2,
	        display_discount: 1,
	    },
	        success: function(data)
	        {
				str_to_array = data.split("|"); // string to array
				id = str_to_array[0];
				amount = str_to_array[1];
	        	document.getElementById("disc_id").value = id;
	        	document.getElementById("disc_amount").value = amount;
	        }
	});
}
function select_remarks(select)
{
    user_id = <?php echo $id; ?>;
    task_id = document.getElementById("task_id_when_click").value;
    phase_id = document.getElementById("txt_select_phase").value;
    remarks_value = (select.options[select.selectedIndex].value); // get remarks id
    $.ajax({
        url:"ajax.php",
        method:"post",
        data:{
            user_id:user_id,
            task_id:task_id,
            phase_id:phase_id,
            remarks_value:remarks_value,
            add_remarks: 1,},
        success:function(data){
            if(data == "insert")
            {
                alert("Remarks added successfully.");
            }
            else
            {
                alert("Remarks updated successfully.");
            }
            view_field_area_table();
        }
    });
}
function hide_field_per_task(id)
{
    user_id = <?php echo $id; ?>;
    task_id = document.getElementById("task_id_when_click").value;
    field_id = id.replace("hide_field_per_task", "");
    if(confirm("Are you sure you want to hide this field in this task?"))
    {
        $.ajax({
            url:"ajax.php",
            method:"post",
            data:{
                user_id:user_id,
                task_id:task_id,
                field_id:field_id,
                hide_field_per_task: 1,},
            success:function(data){
                alert('Field udpdated successfully set as "HIDE" in this task.');
                view_field_area_table();
                view_transaction_per_phase();
            }
        });
    }
}
function show_field_per_task(id)
{
    user_id = <?php echo $id; ?>;
    task_id = document.getElementById("task_id_when_click").value;
    field_id = id.replace("show_field_per_task", "");
    if(confirm("Are you sure you want to show this field in this task?"))
    {
        $.ajax({
            url:"ajax.php",
            method:"post",
            data:{
                user_id:user_id,
                task_id:task_id,
                field_id:field_id,
                show_field_per_task: 1,},
            success:function(data){
                alert('Field updated successfully set as "SHOW" in this task.');
                view_field_area_table();
                view_transaction_per_phase();
            }
        });
    }
}
function edit_amount_per_task(id)
{
    user_id = <?php echo $id; ?>;
    task_id = document.getElementById("task_id_when_click").value;
    field_id = id.replace("edit_amount_per_task", "");
    abc = document.getElementById("amount_field_per_task" + field_id);
    field_name = document.getElementById("name_field_per_task" + field_id).value;
    field_value = document.getElementById("amount_field_per_task" + field_id).value;

    document.getElementById("edit_payment_id").value = field_id;
    document.getElementById("edit_payment_name").value = field_name;
    document.getElementById("field_amount_per_task").value = field_value;
    document.getElementById("field_amount_per_task").focus();
}
function cancel_field_amount_per_task(id)
{
	clear_amount_per_task();
}
function clear_amount_per_task()
{
    document.getElementById("edit_payment_id").value = "";
    document.getElementById("edit_payment_name").value = "";
    document.getElementById("field_amount_per_task").value = "";
}
function save_field_amount_per_task(id)
{
    user_id = <?php echo $id; ?>;
    task_id = document.getElementById("task_id_when_click").value;
    field_id = document.getElementById("edit_payment_id").value;
    field_name = document.getElementById("edit_payment_name").value;
    field_amount = document.getElementById("field_amount_per_task").value;
    if(field_id == "")
    {
    	alert('Please select field first.');
    }
    else
    {
    	if(confirm('Are you sure you want to change the amount of "'+field_name+'" into '+field_amount+'?'))
	    {
	        $.ajax({
	            url:"ajax.php",
	            method:"post",
	            data:{
	                user_id:user_id,
	                task_id:task_id,
	                field_id:field_id,
	                field_amount:field_amount,
	                save_field_amount_per_task: 1,},
	            success:function(data){
	                alert(data);
	                clear_amount_per_task();
	                view_field_area_table();
	                view_transaction_per_phase();
	            }
	        });
	    }
    }
}

function add_discount()
{
    user_id = <?php echo $id; ?>;
    phase_id = document.getElementById("txt_select_phase").value;
    task_id = document.getElementById("task_id_when_click").value;
    disc_amount = document.getElementById("disc_amount").value;
    if(phase_id == "")
    {
    	alert('Please select phase first.');
    }
    else if(disc_amount == "")
    {
        alert('Discounted amount must have a value, please input discount first.');
    }
    else
    {
	    transaction_container.innerHTML = "";
	    save();
    }
}
function save()
{
    $.ajax({
        url:"ajax.php",
        method:"post",
        data:{
            user_id:user_id,
            phase_id:phase_id,
            task_id:task_id,
            disc_amount:disc_amount,
            add_discount: 1,},
        success:function(data){
            alert(data);
            display_discount();
            view_transaction_per_phase();
        }
    });
}


function save_transac()
{
    user_id = <?php echo $id; ?>;
    phase_id = document.getElementById("txt_select_phase").value;
    task_id = document.getElementById("task_id_when_click").value;

    tran_date = document.getElementById("tran_date").value;
    tran_method = document.getElementById("tran_method").value;
    tran_transaction_no = document.getElementById("tran_transaction_no").value;
    tran_currency = document.getElementById("tran_currency").value;
    tran_amount = document.getElementById("tran_amount").value;
    tran_charge = document.getElementById("tran_charge").value;
    tran_charge_type = document.getElementById("tran_charge_type").value;
    tran_client_rate = document.getElementById("tran_client_rate").value;
    tran_note = document.getElementById("tran_note").value;
    tran_initial = document.getElementById("tran_initial").value;
    tran_usd_rate = document.getElementById("tran_usd_rate").value;
    tran_usd_total = document.getElementById("tran_usd_total").value;
    tran_php_rate = document.getElementById("tran_php_rate").value;
    tran_php_total = document.getElementById("tran_php_total").value;
    tran_client_php_total = document.getElementById("tran_client_php_total").value;
    tran_file = document.getElementById("tran_attachment").value;

    tran_attachment = $('#tran_attachment');
    file_attachment = tran_attachment.prop('files')[0];
    formData = new FormData();
    formData.append('user_id', user_id);
    formData.append('phase_id', phase_id);
    formData.append('task_id', task_id);
    formData.append('tran_date', tran_date);
    formData.append('tran_method', tran_method);
    formData.append('tran_transaction_no', tran_transaction_no);
    formData.append('tran_currency', tran_currency);
    formData.append('tran_amount', tran_amount);
    formData.append('tran_charge', tran_charge);
    formData.append('tran_charge_type', tran_charge_type);
    formData.append('tran_client_rate', tran_client_rate);
    formData.append('tran_note', tran_note);
    formData.append('tran_initial', tran_initial);
    formData.append('tran_usd_rate', tran_usd_rate);
    formData.append('tran_usd_total', tran_usd_total);
    formData.append('tran_php_rate', tran_php_rate);
    formData.append('tran_php_total', tran_php_total);
    formData.append('tran_client_php_total', tran_client_php_total);
    formData.append('file_attachment', file_attachment);
    formData.append('save_transaction', 1);

    if(tran_date == "" || tran_method == "" || tran_transaction_no == "" || tran_amount == "" ||  tran_currency == "" || tran_file == "" || tran_client_rate == "")
    {
        alert('Please input value in require field.');
    }
    else if(phase_id == "")
    {
        alert('Please select phase in field area.');
    }
    else
    {
        $.ajax({
            url:"ajax.php",
            method:"post",
            data: formData,

            contentType:false,
            cache: false,
            processData: false,
            success:function(data){
                if(data == "success")
                {
                    alert("Transaction added successfully.");
                    clear_finance_field();
                    view_transaction_per_phase();
                }
                else if(data == "error2")
                {
                    alert("Attachment extension must be; jpg, jpeg, and png only.");
                    document.getElementById("tran_attachment").value = "";
                }
                else
                {
                    alert("Upload attachment not greater than 3 MB.");
                    document.getElementById("tran_attachment").value = "";
                }
            }
        });
    }
}
function clear_transac()
{
    clear_finance_field();
}
function view_transaction_per_phase()
{
    phase_id = document.getElementById("txt_select_phase").value;
    task_id = document.getElementById("task_id_when_click").value;
    $.ajax({
        url:"ajax.php",
        method:"post",
        data:{
            task_id:task_id,
            phase_id:phase_id,
            fetch_transaction_by_phase: 1,},
        success:function(response){
             $('#transaction_table').html(response);
        }
    });
}
function clear_finance_field()
{
    document.getElementById("tran_date").value = "";
    document.getElementById("tran_method").value = "";
    document.getElementById("tran_transaction_no").value = "";
    document.getElementById("tran_amount").value = "";
    document.getElementById("tran_amount").readOnly = false;
    document.getElementById("tran_charge").value = "";
    document.getElementById("tran_charge").readOnly = false;
    document.getElementById("tran_charge_type").value = "";
    document.getElementById("tran_charge_type").disabled = false;
    document.getElementById("tran_client_rate").value = "";
    document.getElementById("tran_client_rate").readOnly = false;
    document.getElementById("tran_currency").value = "";
    document.getElementById("tran_note").value = "";
    document.getElementById("tran_initial").value = "";
    document.getElementById("tran_usd_rate").value = "";
    document.getElementById("tran_usd_total").value = "";
    document.getElementById("tran_php_rate").value = "";
    document.getElementById("tran_client_php_total").value = "";
    document.getElementById("tran_php_total").value = "";
    document.getElementById("tran_attachment").value = "";
}
function currency_select(select)
{
    currency_val = (select.options[select.selectedIndex].value); // get currency

    amount = document.getElementById("tran_amount");
    tran_charge = document.getElementById("tran_charge");
    tran_charge_type = document.getElementById("tran_charge_type");
    tran_client_rate = document.getElementById("tran_client_rate");
    tran_initial = document.getElementById("tran_initial");
    tran_usd_rate = document.getElementById("tran_usd_rate");
    tran_usd_total = document.getElementById("tran_usd_total");
    tran_php_rate = document.getElementById("tran_php_rate");
    tran_php_total = document.getElementById("tran_php_total");
    tran_client_php_total = document.getElementById("tran_client_php_total");

    amount.readOnly = true;
    tran_charge.readOnly = true;
    tran_charge_type.disabled = true;
    tran_client_rate.readOnly = true;
    <?php
        $currency_option = mysqli_query($conn, "SELECT * FROM finance_currency ORDER BY currency_name ASC");
        while($fetch = mysqli_fetch_array($currency_option))
        {
            $currency_code = $fetch['currency_code'];
            $currency_val_usd = $fetch['currency_val_usd'];
            $currency_val_php = $fetch['currency_val_php'];
            ?>
            var code = "<?php echo $currency_code; ?>";
            if(currency_val == code)
            {
                document.getElementById("tran_usd_rate").value = "<?php echo $currency_val_usd; ?>";
                document.getElementById("tran_php_rate").value = "<?php echo $currency_val_php; ?>";

                if(tran_charge_type.value == "PHP") // if charge type == PHP
                {
                    if(code == "PHP")
                    {
                        tran_initial.value = (amount.value - tran_charge.value).toFixed(2);
                    }
                    else
                    {
                        tran_initial.value = (amount.value - (tran_charge.value / tran_php_rate.value)).toFixed(2);
                    }
                }
                else if(tran_charge_type.value == "USD")// else if charge type == USD
                {
                    if(code == "USD")
                    {
                        tran_initial.value = (amount.value - tran_charge.value).toFixed(2);
                    }
                    else if(code == "PHP")
                    {
                        tran_initial.value = (amount.value - (tran_charge.value * tran_usd_rate.value)).toFixed(2);
                    }
                    else
                    {
                        tran_initial.value = (amount.value - (tran_charge.value / tran_usd_rate.value)).toFixed(2);
                    }
                }
                else
                {
                    tran_initial.value = (amount.value - tran_charge.value).toFixed(2);
                }

                tran_client_php_total.value = (tran_initial.value * tran_client_rate.value).toFixed(2);
                if(code == "PHP")
                {
                    tran_usd_total.value = (tran_initial.value / tran_usd_rate.value).toFixed(2);
                    tran_php_total.value = (tran_initial.value * tran_php_rate.value).toFixed(2);
                }
                else
                {
                    tran_usd_total.value = (tran_initial.value * tran_usd_rate.value).toFixed(2);
                    tran_php_total.value = (tran_initial.value * tran_php_rate.value).toFixed(2);
                }
            }
            if(currency_val == "")
            {
                clear_tran();
                amount.readOnly = false;
                tran_client_rate.readOnly = false;
    			tran_charge_type.disabled = false;
                <?php
                if($user_type == "Admin")
                { ?> tran_charge.readOnly = false; <?php } ?>
            }
            <?php
        }
    ?>
}
function clear_tran()
{
    document.getElementById("tran_amount").value = "";
    document.getElementById("tran_charge").value = "";
    document.getElementById("tran_charge_type").value = "";
    document.getElementById("tran_client_rate").value = "";
    document.getElementById("tran_initial").value = "";
    document.getElementById("tran_usd_rate").value = "";
    document.getElementById("tran_usd_total").value = "";
    document.getElementById("tran_php_rate").value = "";
    document.getElementById("tran_php_total").value = "";
    document.getElementById("tran_client_php_total").value = "";
}
</script>
    <script type="text/javascript">
    function showname() {
        var name = document.getElementById('image');
        finalname = (name.files.item(0).name);
        var ext = $("#image").val().split(".").pop().toLowerCase(); // get the name extention.
        if(ext == "jpg" || ext == "jpeg" || ext == "png" || ext == "gif")
        {
           document.getElementById("imageparent").style.display='block';
           document.getElementById("fileparent").style.display='none';
        }
        else
        {
           document.getElementById("fileparent").style.display='block';
           document.getElementById("imageparent").style.display='none';
           document.getElementById("filename").innerHTML = finalname;
        }
    };

    function cancel_image() {
            document.getElementById("image").value = "";
            document.getElementById("blah").style.display='none';
            document.getElementById("fileparent").style.display='none';
            document.getElementById("imageparent").style.display='none';
    }
    function cancel_file() {
            document.getElementById("image").value = "";
            document.getElementById("fileparent").style.display='none';
            document.getElementById("imageparent").style.display='none';
    }
    </script>
    <script type="text/javascript">
    // For image selection -------------------------------
    let good = 'test.jpg';
    let bad = 'jpg.test';
    let re = (/\.(gif|jpg|jpeg|png)$/i).test(good);
    if (re)
    {
        console.log('Good', good);
    }

    console.log('Bad:', bad);

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                  $('#blah').attr('src', e.target.result);
                  document.getElementById("blah").style.display='block';
                }

                reader.readAsDataURL(input.files[0]);
              }
            }
            $("#image").change(function() {
            readURL(this);
        });
    </script>
    <script>
    // For input fields -------------------------------
        function btn_save_input_field()
        {
            var task_id = document.getElementById("task_id_when_click").value;
            var space_id = <?php echo $space_id; ?>;
            var user_id = <?php echo $id; ?>;
        // CODE in getting all value in input field by element id
            <?php
                $field_array = array();
                $radio_btn_array = array();
                $email_array = array();
                $field = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id ='$space_id' ORDER BY field_order ASC");
                while($fetch_field = mysqli_fetch_array($field))
                {
                    $field_id = $fetch_field['field_id'];
                    array_push($field_array,$field_id); // add value to array $field_array

                    // checking field_type, if true, then add to specific array
                    $field_type = $fetch_field['field_type'];
                    if($field_type == "Radio")
                    {
                        array_push($radio_btn_array,$field_id); // add value to array $radio_btn_array
                    }
                    if($field_type == "Email")
                    {
                        array_push($email_array,$field_id); // add value to array $email_array
                    }
                }
                $finalarray = implode(",",$field_array); // convert array to string
                $radio_btn_id = implode(",",$radio_btn_array); // convert array to string
                $email_id = implode(",",$email_array); // convert array to string
            ?>
            var field_id = "<?php echo $finalarray; ?>"; // ex: 243,251,244,245,246,247,248,249,250
        // END CODE in getting all value in input field by element id

        // CODE for in getting all input_value and identifying radio botton
            var str_to_array = field_id.split(","); //convert string to array ex: "243,251,..." => ["243","251",...]
            var count_field = str_to_array.length; // count array value

            var radio_btn_id = "<?php echo $radio_btn_id; ?>"; // ex: 243,251
            var radio_btn_array = radio_btn_id.split(","); //convert string to array
            //var count_radio button = radio_btn_array.length;

            var array12 = [];
            for(a = 0; a < count_field; a++)
            {
                var field_id_in_array = str_to_array[a];

                var search = radio_btn_array.includes(field_id_in_array); //search in array
                if(search == true)
                {
                    var yes = document.getElementById("input_field_yes" + field_id_in_array);
                    var yes_value = document.getElementById("input_field_yes" + field_id_in_array).value;
                    var no = document.getElementById("input_field_no" + field_id_in_array);
                    var no_value = document.getElementById("input_field_no" + field_id_in_array).value;
                    var reset = document.getElementById("input_field_yes" + field_id_in_array);
                    if (yes.checked == true && no.checked == true)
                    { array12.push(""); }
                    else if (yes.checked == true)
                    { array12.push(yes_value); }
                    else if (no.checked == true)
                    { array12.push(no_value); }
                    else { array12.push(""); }
                }
                else
                {
                    var field_value = document.getElementById("input_field" + field_id_in_array).value; // get value by field_id
                    array12.push(field_value);
                }
            }
            var input_value = array12.toString(); //array to string
        // END CODE for identifying radio botton

        // CODE in checking input field email
            var email_id = "<?php echo $email_id; ?>"; // ex: 243,251
            if(email_id == "") //check if no email
            {
                $(document).ready(function(){
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            user_id:user_id,
                            space_id:space_id,
                            task_id:task_id,
                            field_id:field_id,
                            input_value:input_value,
                            save_input_in_task: 1,
                        },
                        success: function(data){
                            if(data == "error1")
                            {alert('Space id not found.');}
                            if(data == "update")
                            {alert('Task updated.'); display_input_field(); displayChat();}
                            else {display_input_field();}
                        }
                    });
                });
            }
            else // if has email, then do
            {
                var email_id_array = email_id.split(","); //convert string to array
                var count_email_id_array = email_id_array.length; // count array value
                for(b = 0; b < count_email_id_array; b++)
                {
                    var email_value = document.getElementById("input_field" + email_id_array[b]).value; // get value by field_id
                    var search1 = email_value.includes("@"); //search character in string
                    var search2 = email_value.includes("."); //search character in string

                    if(count_email_id_array == b + 1) // identify if last array
                    {
                        if(search1 == true && search2 == true || email_value == "")
                        {
                            $(document).ready(function(){
                                $.ajax({
                                    type: "POST",
                                    url: "ajax.php",
                                    data: {
                                        user_id:user_id,
                                        space_id:space_id,
                                        task_id:task_id,
                                        field_id:field_id,
                                        input_value:input_value,
                                        save_input_in_task: 1,
                                    },
                                    success: function(data){
                                        if(data == "error1")
                                        {alert('Space id not found.');}
                                        if(data == "update")
                                        {alert('Task updated.'); display_input_field(); displayChat();}
                                        else {display_input_field();}
                                    }
                                });
                            });
                        }
                        else
                        {
                            alert('Email format must contain character: \n * @ \n * .');
                            document.getElementById("input_field" + email_id_array[b]).focus();
                            return false;
                        }
                    }
                    else
                    {
                        // check if input value has character "@" and "." or empty
                        if(search1 == true && search2 == true || email_value == "") {}
                        else
                        {
                            alert('Email format must contain character: \n * @ \n * .');
                            document.getElementById("input_field" + email_id_array[b]).focus();
                            return false;
                        }
                    }
                }
            }
        // DONE CODE in checking input field email
        }
    </script>

    <!-- Dropdown Modal -->
    <div class="modal" id="modal-filterdropdown" tabindex="-1" role="dialog" aria-labelledby="modal-small" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-10">
                    <div class="block-header bg-gd-corporate">
                        <h3 class="block-title">Dropdown</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content" id="field_dropdown">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Radio Modal -->
    <div class="modal" id="modal-filterradio" tabindex="-1" role="dialog" aria-labelledby="modal-small" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-10">
                    <div class="block-header bg-gd-corporate">
                        <h3 class="block-title">Radio</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content" id="field_radio">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function filter_dropdown(id)
        {
            var field_id = id.replace("filter_dropdown", "");
            var space_id = <?php echo $space_id; ?>;
            var list_id = <?php echo $status_list_id; ?>;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        space_id:space_id,
                        list_id:list_id,
                        field_id:field_id,
                        fetch_field_dropdown:1,
                    },
                    success: function(response){
                        $('#field_dropdown').html(response);
                    }
                });
            });
        }

        function filter_radio(id)
        {
            var field_id = id.replace("filter_radio", "");
            var space_id = <?php echo $space_id; ?>;
            var list_id = <?php echo $status_list_id; ?>;
            $(document).ready(function(){
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        space_id:space_id,
                        list_id:list_id,
                        field_id:field_id,
                        fetch_field_radio:1,
                    },
                    success: function(response){
                        $('#field_radio').html(response);
                    }
                });
            });
        }
        function filter_yes(value)
        {
            var space_name = "<?php echo $space_name; ?>";
            var list_name = "<?php echo $list_name; ?>";
            var status_list_id = <?php echo $status_list_id; ?>;
            document.location = 'main_dashboard.php?space_name='+space_name+'&list_name='+list_name+'&list_id='+status_list_id+'&filter=field&field=yes,,'+value+',,radio';
        }
        function filter_no(value)
        {
            var space_name = "<?php echo $space_name; ?>";
            var list_name = "<?php echo $list_name; ?>";
            var status_list_id = <?php echo $status_list_id; ?>;
            document.location = 'main_dashboard.php?space_name='+space_name+'&list_name='+list_name+'&list_id='+status_list_id+'&filter=field&field=no,,'+value+',,radio';
        }
    </script>
    <!-- END Dropdown Modal -->

    <!-- List Modal -->
    <div class="modal fade" id="modal-list" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    <form method="post">
                        <div class="block block-themed block-transparent mb-0">
                            <div class="block-header bg-gd-corporate">
                                <h3 class="block-title">List Editor</h3>
                                <div class="block-options">
                                    <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close"> <i class="si si-close"></i> </button>
                                </div>
                            </div>
                            <input type="hidden" name="count_list" value="<?php echo $count_list; ?>">
                            <input type="hidden" name="count_status" value="<?php echo $count_status; ?>">
                            <div class="block-content">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="List name here..." name="list_name" value="<?php echo $list_name;?>" required>
                                    <div class="input-group-prepend">
                                        <button type="submit" class="btn btn-danger btn-noborder mr-5 mb-5" name="btn_delete_list" title="Delete list."> <i class="fa fa-times"></i> </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary min-width-125 js-click-ripple-enabled" name="btn_rename_list"> <i class="fa fa-check"></i> Save </button>
                        </div>
                    </form>
                </div>
            </form>
        </div>
    </div>
    <!-- END List Modal -->

    <!-- Status Modal -->
    <style type="text/css">
        .statusss{width: 450px; padding: 0px;}
        @media screen and (max-width: 600px){
            .statusss{width: 375px;
            }
        }
        @media screen and (max-width: 375px){
            .statusss{width: 338px;
            }
        }
        @media screen and (max-width: 360px){
            .statusss{width: 323px;
            }
        }
        @media screen and (max-width: 320px){
            .statusss{width: 283px; margin: 0px 0px 0px 0px;
            }
        }
    </style>
    <div class="modal fade" id="modal-status" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0" style="background-color: #efeeee;">
                    <div class="block-header bg-gd-corporate">
                        <h3 class="block-title">Status Editor</h3>
                    </div>
                    <!-- Content -- >
                    <div class="block-content">
                        <!-- Design Column -->
                        <form method="post">
                            <div class="input-group">
                                <input type="text" class="form-control text-muted" name="status_name" placeholder="Add status..." style="border-radius: 5px; margin: 20px 25px 0px 25px;" required>
                                <button type="submit" hidden="hidden" class="btn btn-alt-secondary btn-noborder mr-5 mb-5" name="btn_add_status"><i class="fa fa-plus"></i></button>
                            </div>
                        </form>
                        <div class="scrumboard js-scrumboard">
                            <form method="post">
                                <div class="scrumboard-col">
                                    <ul class="scrumboard-items block-content list-unstyled statusss" id="sortables" class="connectedSortable">
                                        <?php
                                        include("../conn.php");
                                        $status_list_id = $_GET['list_id'];
                                        $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' ORDER BY status_order_no ASC");
                                        while($result_findstatus = mysqli_fetch_array($findstatus))
                                        {
                                            echo'
                                            <form method="post">
                                                <li class="scrumboard-item" id="entry_' . $result_findstatus['status_id'] . '" style="background-color: #fff;box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27); height: 20px;">
                                                    <div class="scrumboard-item-options">
                                                        <a class="scrumboard-item-handler btn btn-sm btn-alt-warning" href="javascript:void(0)">
                                                            <i class="fa fa-hand-grab-o"></i>
                                                        </a>
                                                        <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&delete_status=delete_status&status_id='.$result_findstatus['status_id'].'" class="btn btn-sm btn-alt-warning"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                    <div class="scrumboard-item-content" style="margin: -5px 0px 0px 0px;">
                                                        <a class="btn btn-sm btn-circle mr-5" href="javascript:void(0)" style="background-color: '.$result_findstatus['status_color'].';" style="height:10px;"></a>
                                                        <input type="hidden" value="'.$result_findstatus['status_id'].'" name="modal_status_id">
                                                        <input type="text" placeholder="Status name..." style="margin: 0px 0px 0px 0px; padding: 5px; width:70%; border: 1px solid #d4dae3; border-radius: .25rem;" value="'.$result_findstatus['status_name'].'" name="modal_status_names" required>
                                                        <button type="submit" hidden="hidden" class="btn btn-primary btn-noborder mr-1 mb-5" name="btn_modal_status_names"><i class="fa fa-check"></i></button>
                                                    </div>
                                                </li>
                                            </form>';
                                        }?>
                                    </ul>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-alt-primary" onClick="window.location.reload();" data-dismiss="modal">
                            <i class="fa fa-check"></i> Done
                        </button>
                    </div>
                        <!-- END Design Column -->
                    </div>
                    <!-- End Content -->
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <script type="text/javascript">
    function modal_show_status_rename(id)
    {
        var a = id;
        $("#modalstatusid" + a).toggle();
    }
    $(function()
    {
        space_id = <?php echo $space_id; ?>;
        list_id = <?php echo $status_list_id; ?>;
        $("#sortables").sortable(
        {
            connectWith: '.connectedSortable',
            update : function ()
            {
                $.ajax(
                {
                    type: "POST",
                    url: "update_status_order.php",
                    data:
                    {
                        space_id:space_id,
                        list_id:list_id,
                        sort1:$("#sortables").sortable('serialize')
                    },
                    success: function(html)
                    {
                    }
                });
            }
        }).disableSelection();
    });
    </script>
    <!-- END Status Modal -->

    <!-- Tag Modal -->
    <div class="modal fade" id="modal-tag" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gd-corporate">
                        <h3 class="block-title">Tag Editor</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close"> <i class="si si-close"></i> </button>
                        </div>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <form method="post">
                            <div class="input-group">
                                <input type="text" class="form-control text-muted" name="txt_modal_add_tag" placeholder="Add tag..." style="border-radius: 5px;" required>
                                <button type="submit" hidden="hidden" class="btn btn-alt-secondary btn-noborder mr-5 mb-5" name="btn_modal_add_tag"><i class="fa fa-plus"></i></button>
                            </div>
                        </form>
                        <div class="dropdown-divider" style="margin: 15px 0px;"></div>

                        <?php
                            $get_list_id = $_GET['list_id'];
                            $find_tags = mysqli_query($conn, "SELECT * FROM tags WHERE tag_list_id = '$get_list_id'");
                            while($fetch_find_tags = mysqli_fetch_array($find_tags))
                            {
                                echo'
                                <form method="post">
                                    <input type="hidden" placeholder="Tag name..." value="'.$fetch_find_tags['tag_id'].'" name="tag_id">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button type="submit" hidden="hidden" class="btn btn-primary btn-noborder mr-1 mb-5" name="btn_rename_tag"><i class="fa fa-check"></i></button>
                                        </div>
                                        <input type="text" class="form-control" style="border-left: 10px solid '.$fetch_find_tags['tag_color'].';" placeholder="Tag name..." value="'.$fetch_find_tags['tag_name'].'" name="tag_name" required>
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-danger btn-noborder mr-5 mb-5" name="btn_delete_tag"><i class="fa fa-trash"></i></button>
                                        </div>
                                    </div>
                                </form>';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Tag -->
    <script>
        function edit_field(id)
        {
            var a = id;
            var field_id = a.replace("edit_field", ""); // Remove the string id "delete_field";
            var abc = document.getElementById("field_name" + field_id).value;
            document.getElementById("edit_field_name").value = abc;
            document.getElementById("edit_field_id").value = field_id;
            var field_type = document.getElementById("field_type" + field_id).value;

            if(field_type == "Dropdown")
            {
                $(document).ready(function(){
                    var space_id = <?php echo $space_id; ?>;
                    edit_field_id = document.getElementById("edit_field_id").value;
                    $.ajax({
                        url: 'fetch_option.php',
                        type: 'POST',
                        async: false,
                        data:{
                            space_id:space_id,
                            edit_field_id:edit_field_id,
                            fetch: 1,
                        },
                            success: function(response){
                                $('#dropdown_option').html(response);
                            }
                    });
                });
                document.getElementById("containerid").style.display = 'block';
            }
            else
            {
                document.getElementById("containerid").style.display = 'none';
            }
        }
        function delete_field(id)
        {
            var a = id;
            var space_id = <?php echo $space_id; ?>;
            var field_id = a.replace("delete_field", ""); // Remove the string id "delete_field";
            if(confirm("Are you sure you want to delete this field?"))
            {
                $(document).ready(function(){
                    $.ajax({
                        type: "POST",
                        url: "delete_field.php",
                        data: {
                            space_id:space_id,
                            field_id:field_id,
                            del: 1,
                        },
                        success: function(data){
                            if(data == 'Has')
                            { alert("Cannot delete field with value."); }
                            else
                            {
                                alert('Field deleted.');
                                document.getElementById('btn_refresh').click();
                            }
                        }
                    });
                });
            }
            else
            {
                return false;
            }
        }
        function delete_option(id)
        {
            var a = id;
            var option_id = a.replace("delete_option", ""); // Remove the string id "delete_field";
            edit_field_id = document.getElementById("edit_field_id").value;
            if(confirm("Are you sure you want to delete this option?"))
            {
                $(document).ready(function(){
                    $.ajax({
                        type: "POST",
                        url: "delete_option.php",
                        data: {
                            option_id: option_id,
                            edit_field_id: edit_field_id,
                            del: 1,
                        },
                        success: function(){
                            $.ajax({
                                url: 'fetch_option.php',
                                type: 'POST',
                                async: false,
                                data:{
                                    edit_field_id:edit_field_id,
                                    fetch: 1,
                                },
                                    success: function(response){
                                        alert('Option deleted.');
                                        $('#dropdown_option').html(response);
                                    }
                            });
                        }
                    });
                });
            }
            else
            {
                return false;
            }
        }
        function rename_option(id)
        {
            var a = id;
            var option_id = a.replace("rename_option", ""); // Remove the string id "delete_field";
            option_name = document.getElementById("option_name" + option_id).value;
            colorpicker = document.getElementById("colorpicker" + option_id).value;
            if(confirm("Are you sure you want to update this option?"))
            {
                $(document).ready(function(){
                    $.ajax({
                        type: "POST",
                        url: "rename_option.php",
                        data: {
                            option_id:option_id,
                            option_name:option_name,
                            colorpicker:colorpicker,
                            edit: 1,
                        },
                        success: function(){
                            $.ajax({
                                url: 'fetch_option.php',
                                type: 'POST',
                                async: false,
                                data:{
                                    edit_field_id:edit_field_id,
                                    fetch: 1,
                                },
                                    success: function(response){
                                        alert('Update successfully.')
                                        $('#dropdown_option').html(response);
                                    }
                            });
                        }
                    });
                });
            }
            else
            {
                return false;
            }
        }

        $(document).ready(function(){
            displayfield();
            $('#btn_add_option_id').on('click', function(){
                edit_field_id = document.getElementById("edit_field_id").value;
                $.ajax({
                    type: "POST",
                    url: "add_option.php",
                    data: {
                        edit_field_id: edit_field_id,
                    },
                    success: function(){
                        $.ajax({
                            url: 'fetch_option.php',
                            type: 'POST',
                            async: false,
                            data:{
                                edit_field_id:edit_field_id,
                                fetch: 1,
                            },
                                success: function(response){
                                    $('#dropdown_option').html(response);
                                }
                        });
                    }
                });
            });

            $('#btn_save_edit_field').on('click', function(){
                edit_field_id = document.getElementById("edit_field_id").value;
                edit_field_name = document.getElementById("edit_field_name").value;
                var space_id = <?php echo $space_id; ?>;
                if(edit_field_name == "")
                {
                    alert('Please input a field name and try again.');
                    document.getElementById("edit_field_name").focus();
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "update_field.php",
                        data: {
                            space_id:space_id,
                            edit_field_id: edit_field_id,
                            edit_field_name: edit_field_name,
                            edit: 1,
                        },
                        success: function(){
                            displayfield();
                            alert('Update successfully.');
                        }
                    });
                }
            });


            $('#create_textarea').on('click', function(){
                space_id = <?php echo $space_id; ?>;
                textarea_name = $('#textarea_name').val();
                type = "Textarea";
                if(textarea_name == "")
                {
                    alert('Please input field name and try again. ');
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "create_field.php",
                        data: {
                            space_id:space_id,
                            type:type,
                            textarea_name: textarea_name,
                            create: 1,
                        },
                        success: function(){
                            $('#textarea_name').val("");
                                displayfield();
                        }
                    });
                }
            });
            $('#create_text').on('click', function(){
                space_id = <?php echo $space_id; ?>;
                text_name = $('#text_name').val();
                type = "Text";
                if(text_name == "")
                {
                    alert('Please input field name and try again. ');
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "create_field.php",
                        data: {
                            space_id:space_id,
                            type:type,
                            text_name: text_name,
                            create: 1,
                        },
                        success: function(){
                            $('#text_name').val("");
                            displayfield();
                        }
                    });
                }
            });
            $('#create_email').on('click', function(){
                space_id = <?php echo $space_id; ?>;
                email_name = $('#email_name').val();
                type = "Email";
                if(email_name == "")
                {
                    alert('Please input field name and try again. ');
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "create_field.php",
                        data: {
                            space_id:space_id,
                            type:type,
                            email_name: email_name,
                            create: 1,
                        },
                        success: function(){
                            $('#email_name').val("");
                            displayfield();
                        }
                    });
                }
            });
            $('#create_dropdown').on('click', function(){
                space_id = <?php echo $space_id; ?>;
                dropdown_name = $('#dropdown_name').val();
                type = "Dropdown";
                if(dropdown_name == "")
                {
                    alert('Please input field name and try again. ');
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "create_field.php",
                        data: {
                            space_id:space_id,
                            type:type,
                            dropdown_name: dropdown_name,
                            create: 1,
                        },
                        success: function(){
                            $('#dropdown_name').val("");
                            displayfield();
                        }
                    });
                }
            });
            $('#create_phone').on('click', function(){
                space_id = <?php echo $space_id; ?>;
                phone_name = $('#phone_name').val();
                type = "Phone";
                if(phone_name == "")
                {
                    alert('Please input field name and try again. ');
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "create_field.php",
                        data: {
                            space_id:space_id,
                            type:type,
                            phone_name: phone_name,
                            create: 1,
                        },
                        success: function(){
                            $('#phone_name').val("");
                            displayfield();
                        }
                    });
                }
            });
            $('#create_date').on('click', function(){
                space_id = <?php echo $space_id; ?>;
                date_name = $('#date_name').val();
                type = "Date";
                if(date_name == "")
                {
                    alert('Please input field name and try again. ');
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "create_field.php",
                        data: {
                            space_id:space_id,
                            type:type,
                            date_name: date_name,
                            create: 1,
                        },
                        success: function(){
                            $('#date_name').val("");
                            displayfield();
                        }
                    });
                }
            });
            $('#create_number').on('click', function(){
                space_id = <?php echo $space_id; ?>;
                number_name = $('#number_name').val();
                type = "Number";
                if(number_name == "")
                {
                    alert('Please input field name and try again. ');
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "create_field.php",
                        data: {
                            space_id:space_id,
                            type:type,
                            number_name: number_name,
                            create: 1,
                        },
                        success: function(){
                            $('#number_name').val("");
                            displayfield();
                        }
                    });
                }
            });
            $('#create_radio').on('click', function(){
                space_id = <?php echo $space_id; ?>;
                radio_name = $('#radio_name').val();
                type = "Radio";
                if(radio_name == "")
                {
                    alert('Please input field name and try again. ');
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "create_field.php",
                        data: {
                            space_id:space_id,
                            type:type,
                            radio_name: radio_name,
                            create: 1,
                        },
                        success: function(){
                            $('#radio_name').val("");
                            displayfield();
                        }
                    });
                }
            });

            $('#btn_change_field').on('click', function(){
                space_id = <?php echo $space_id; ?>;
                $.ajax({
                    url: 'fetch_field_for_order.php',
                    type: 'POST',
                    async: false,
                    data:{
                        space_id:space_id,
                        fetch: 1,
                    },
                        success: function(response){
                            $('#change_field').html(response);
                            $("#change_field").scrollTop($("#change_field")[0].scrollHeight);
                        }
                });
            });

            $('#btn_refresh').on('click', function(){
                displayfield();
            });

            function displayfield()
            {
                space_id = <?php echo $space_id; ?>;
                $.ajax({
                    url: 'fetch_field.php',
                    type: 'POST',
                    async: false,
                    data:{
                        space_id:space_id,
                        fetch: 1,
                    },
                        success: function(response){
                            $('#field_area').html(response);
                            $("#field_area").scrollTop($("#field_area")[0].scrollHeight);
                        }
                });
            }
        });


// FINANCE FIELD & PHASE
        $(document).ready(function(){
            display_finance_field();
            display_finance_phase();
            $('#create_finance_phase').on('click', function(){
                space_id = <?php echo $space_id; ?>;
                finance_phase_name = $('#finance_phase_name').val();
                if(finance_phase_name == "")
                {
                    alert('Please input phase name.');
                    $('#finance_phase_name').focus();
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            space_id:space_id,
                            finance_phase_name: finance_phase_name,
                            create_finance_phase: 1,
                        },
                        success: function(data){
                            alert('Phase added successfully.');
                            $('#finance_phase_name').val("");
                            display_finance_phase();
                        }
                    });
                }
            });
            $('#btn_refresh').on('click', function(){
                display_finance_phase();
            });
            function display_finance_phase()
            {
                space_id = <?php echo $space_id; ?>;
                $.ajax({
                    url: 'ajax.php',
                    type: 'POST',
                    async: false,
                    data:{
                        space_id:space_id,
                        fetch_finance_phase: 1,
                    },
                        success: function(response){
                            $('#finance_phase_id').html(response);
                        }
                });
            }
            $('#btn_save_edit_finance_phase').on('click', function(){
                edit_finance_phase_id = document.getElementById("edit_finance_phase_id").value;
                edit_finance_phase_name = document.getElementById("edit_finance_phase_name").value;
                if(edit_finance_phase_name == "")
                {
                    alert('Please input phase name and try again.');
                    document.getElementById("edit_finance_phase_name").focus();
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            edit_finance_phase_id: edit_finance_phase_id,
                            edit_finance_phase_name: edit_finance_phase_name,
                            edit_finance_phase: 1,
                        },
                        success: function(){
                            display_finance_phase();
                            alert('Update successfully.');
                        }
                    });
                }
            });
            $('#create_finance_field_text').on('click', function(){
                space_id = <?php echo $space_id; ?>;
                field_id = document.getElementById("edit_finance_phase_id").value;
                finance_text_field_id = $('#finance_text_field_id').val();
                finance_field_name = $('#finance_text_field_name').val();
                finance_privacy_text = $('#finance_text_privacy').val();
                finance_currency_text = $('#tran_finance_currency').val();
                finance_value_text = $('#finance_text_value').val();
                finance_converter_value = $('#finance_converter_value').val();

                if(finance_field_name == "")
                {
                    alert('Please input field name.');
                    $('#finance_text_field_name').focus();
                }
                else if (finance_privacy_text == "")
                {
                    alert('Please select privacy.');
                    $('#finance_text_privacy').focus();
                }
                else if (finance_value_text == "")
                {
                    alert('Please input value.');
                    document.getElementById("tran_finance_currency").selectedIndex = "0";
                    document.getElementById("finance_converter_value").value = "";
                    $('#finance_text_value').focus();
                }
                else if (finance_currency_text == "")
                {
                    alert('Please select currency.');
                    $('#tran_finance_currency').focus();
                }
                else if (finance_converter_value == "")
                {
                    alert('Amount(USD) is empty. Please re-select currency.');
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            space_id:space_id,
                            field_id:field_id,
                            finance_text_field_id: finance_text_field_id,
                            finance_field_name: finance_field_name,
                            finance_privacy_text: finance_privacy_text,
                            finance_currency_text: finance_currency_text,
                            finance_converter_value: finance_converter_value,
                            create_finance_field_text: 1,
                        },
                        success: function(data)
                        {
                            display_finance_field();
                            $('#finance_field_name').val("");
                            $('#finance_privacy_text').val("");
                            $('#finance_currency_text').val("");
                            $('#finance_value_text').val("");
                            $('#finance_converter_value').val("");
                            $('#modal-financetext').modal("hide");
                            $('#modal-editfinancephase').modal("show");
                            document.getElementById("tran_finance_currency").selectedIndex = "0";
                            alert(data);
                        }
                    });
                }
            });
            $('#create_finance_field_dropdown').on('click', function(){
                space_id = <?php echo $space_id; ?>;
                field_id = document.getElementById("edit_finance_phase_id").value;
                finance_text_field_id = $('#finance_dropdown_field_id').val();
                finance_field_name = $('#finance_dropdown_field_name').val();
                finance_privacy_text = $('#finance_dropdown_privacy').val();
                if(finance_field_name == "")
                {
                    alert('Please input field name.');
                    $('#finance_dropdown_field_name').focus();
                }
                else if (finance_privacy_text == "")
                {
                    alert('Please select privacy.');
                    $('#finance_dropdown_privacy').focus();
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            space_id:space_id,
                            field_id:field_id,
                            finance_text_field_id: finance_text_field_id,
                            finance_field_name: finance_field_name,
                            finance_privacy_text: finance_privacy_text,
                            create_finance_field_dropdown: 1,
                        },
                        success: function(data)
                        {
                            display_finance_field();
                            $('#finance_dropdown_field_name').val("");
                            $('#finance_dropdown_privacy').val("");
                            $('#modal-financedropdown').modal("hide");
                            $('#modal-editfinancephase').modal("show");

                            if(data == "insert")
                            { alert('Field added successfully.'); }
                            else
                            { alert('Field updated successfully.'); }
                        }
                    });
                }
            });
            $('#finance_btn_add_option_id').on('click', function(){
                finance_dropdown_field_id = document.getElementById("finance_dropdown_field_id").value;
                $.ajax({
                    type: "POST",
                    url: "ajax.php",
                    data: {
                        finance_dropdown_field_id: finance_dropdown_field_id,
                    },
                    success: function(){
                        view_dropdown_option();
                    }
                });
            });

            $('#btn_refresh').on('click', function(){
                display_finance_field();
            });
            function display_finance_field()
            {
                field_id = document.getElementById("edit_finance_phase_id").value;
                space_id = <?php echo $space_id; ?>;
                $.ajax({
                    url: 'ajax.php',
                    type: 'POST',
                    async: false,
                    data:{
                        space_id:space_id,
                        field_id:field_id,
                        fetch_finance_field: 1,
                    },
                        success: function(response){
                            $('#finance_field_id').html(response);
                            $("#finance_field_id").scrollTop($("#finance_field_id")[0].scrollHeight);
                        }
                });
            }
            $('#btn_save_edit_finance_field').on('click', function(){
                edit_finance_field_id = document.getElementById("edit_finance_field_id").value;
                edit_finance_field_name = document.getElementById("edit_finance_field_name").value;
                finance_currency = document.getElementById("finance_currency").value;
                finance_value = document.getElementById("finance_value").value;
                if(edit_finance_field_name == "")
                {
                    alert('Please input field name and try again.');
                    document.getElementById("edit_finance_field_name").focus();
                }
                else if(finance_currency == "")
                {
                    alert('Please select currency and try again.');
                    document.getElementById("finance_currency").focus();
                }
                else if(finance_value == "")
                {
                    alert('Please input value and try again.');
                    document.getElementById("finance_value").focus();
                }
                else
                {
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            edit_finance_field_id: edit_finance_field_id,
                            edit_finance_field_name: edit_finance_field_name,
                            finance_currency:finance_currency,
                            finance_value:finance_value,
                            edit_finance_field: 1,
                        },
                        success: function(){
                            display_finance_field();
                            alert('Update successfully.');
                        }
                    });
                }
            });
        });
        function finance_text_value_click()
        {
            document.getElementById("tran_finance_currency").selectedIndex = "0";
            document.getElementById("finance_converter_value").value = "";
        }
        function currency_select_for_finance(select)
        {
            currency_val = (select.options[select.selectedIndex].value); // get currency
            finance_text_value = document.getElementById("finance_text_value");
            finance_converter_value = document.getElementById("finance_converter_value");
            if(finance_text_value.value == "")
            {
                alert('Please input initital amount.');
                finance_text_value.focus();
                document.getElementById("tran_finance_currency").selectedIndex = "0";
            }
            else if(currency_val == "")
            {
                finance_converter_value.value = "";
            }
            else
            {
                <?php
                $currency_option1 = mysqli_query($conn, "SELECT * FROM finance_currency ORDER BY currency_name ASC");
                while($fetch1 = mysqli_fetch_array($currency_option1))
                {
                    $currency_code1 = $fetch1['currency_code'];
                    $currency_val_usd1 = $fetch1['currency_val_usd'];
                    $currency_val_php1 = $fetch1['currency_val_php'];
                    ?>
                        code = "<?php echo $currency_code1; ?>";
                        if(currency_val == code)
                        {
                            usd_val = "<?php echo $currency_val_usd1; ?>";
                            php_val = "<?php echo $currency_val_php1; ?>";

                            if(currency_val == "PHP")
                            {
                                finance_converter_value.value = (finance_text_value.value / usd_val).toFixed(2);
                            }
                            else
                            {
                                finance_converter_value.value = (finance_text_value.value * usd_val).toFixed(2);
                            }
                        }
                    <?php
                } ?>
            }
        }
        function add_field()
        {
            document.getElementById("finance_text_field_id").value = "";
            document.getElementById("finance_text_field_name").value = "";
            document.getElementById("finance_text_privacy").value = "";
            //document.getElementById("finance_text_currency").value = "";
            document.getElementById("finance_text_value").value = "";

            document.getElementById("finance_dropdown_field_id").value = "";
            document.getElementById("finance_dropdown_field_name").value = "";
            document.getElementById("finance_dropdown_privacy").value = "";

            document.getElementById("containerid_dropdown").style.display = 'none';
            document.getElementById("tran_finance_currency").selectedIndex = "0";
            document.getElementById("finance_converter_value").value = "";
        }
        function edit_finance_field(id)
        {
            document.getElementById("finance_converter_value").value = "";
            var field_id = id.replace("edit_finance_field", ""); // Remove the string id "delete_field";
            document.getElementById("finance_text_field_id").value = field_id;
            var abc = document.getElementById("finance_field_name" + field_id).value;
            document.getElementById("finance_text_field_name").value = abc;
            var def = document.getElementById("finance_field_privacy" + field_id).value;
            document.getElementById("finance_text_privacy").value = def;
            var jkl = document.getElementById("finance_value" + field_id).value;
            document.getElementById("finance_text_value").value = jkl;
            var ghi = document.getElementById("finance_currency" + field_id).value;
            document.getElementById("tran_finance_currency").value = ghi;
        }
        function edit_finance_field_dropdown(id)
        {
            var field_id = id.replace("edit_finance_field_dropdown", ""); // Remove the string id "delete_field";
            document.getElementById("finance_dropdown_field_id").value = field_id;
            var abc = document.getElementById("finance_field_name" + field_id).value;
            document.getElementById("finance_dropdown_field_name").value = abc;
            var def = document.getElementById("finance_field_privacy" + field_id).value;
            document.getElementById("finance_dropdown_privacy").value = def;

            $(document).ready(function(){
                view_dropdown_option();
            });
            document.getElementById("containerid_dropdown").style.display = 'block';
        }
        function view_dropdown_option()
        {
            finance_dropdown_field_id = document.getElementById("finance_dropdown_field_id").value;
            $.ajax({
                url: 'fetch_option.php',
                type: 'POST',
                async: false,
                data:{
                    finance_dropdown_field_id:finance_dropdown_field_id,
                    fetch_finance_child: 1,
                },
                    success: function(response){
                        $('#finance_dropdown_option').html(response);
                    }
            });
        }
        function rename_option_finance(id)
        {
            option_id = id.replace("rename_option_finance", ""); // Remove the string id "rename_option_finance";
            option_name = document.getElementById("option_name_finance" + option_id).value;
            colorpicker = document.getElementById("colorpicker_finance" + option_id).value;
            if(confirm("Are you sure you want to update this option?"))
            {
                $(document).ready(function(){
                    $.ajax({
                        type: "POST",
                        url: "rename_option.php",
                        data: {
                            option_id:option_id,
                            option_name:option_name,
                            colorpicker:colorpicker,
                            edit_finance: 1,
                        },
                        success: function(){
                            view_dropdown_option();
                            alert('Option updated successfully.');
                        }
                    });
                });
            }
            else
            {
                return false;
            }
        }
        function delete_option_finance(id)
        {
            option_id = id.replace("delete_option_finance", ""); // Remove the string id "delete_option_finance";
            if(confirm("Are you sure you want to delete this option?"))
            {
                $(document).ready(function(){
                    $.ajax({
                        type: "POST",
                        url: "delete_option.php",
                        data: {
                            option_id: option_id,
                            del_finance: 1,
                        },
                        success: function(){
                            view_dropdown_option();
                            alert('Option deleted successfully.');
                        }
                    });
                });
            }
            else
            {
                return false;
            }
        }
        function edit_finance_phase(id)
        {
            var field_id = id.replace("edit_finance_phase", ""); // Remove the string id "delete_field";
            document.getElementById("edit_finance_phase_id").value = field_id;
            var abc = document.getElementById("phase_name" + field_id).value;
            document.getElementById("edit_finance_phase_name").value = abc;

            space_id = <?php echo $space_id; ?>;
            $.ajax({
                url: 'ajax.php',
                type: 'POST',
                async: false,
                data:{
                    space_id:space_id,
                    field_id:field_id,
                    fetch_finance_field: 1,
                },
                    success: function(response){
                        $('#finance_field_id').html(response);
                        $("#finance_field_id").scrollTop($("#finance_field_id")[0].scrollHeight);
                    }
            });
        }
        function delete_finance_phase(id)
        {
            var field_id = id.replace("delete_finance_phase", ""); // Remove the string id "delete_field";
            if(confirm("Are you sure you want to delete this phase?"))
            {
                $(document).ready(function(){
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            field_id:field_id,
                            delete_finance_phase: 1,
                        },
                        success: function(data){
                            alert(data);
                            document.getElementById('btn_refresh').click();
                        }
                    });
                });
            }
        }
        function delete_finance_field(id)
        {
            var field_id = id.replace("delete_finance_field", ""); // Remove the string id "delete_field";
            if(confirm("Are you sure you want to delete this field?"))
            {
                $(document).ready(function(){
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            field_id:field_id,
                            delete_finance_field: 1,
                        },
                        success: function(data){
                            alert(data);
                            document.getElementById('btn_refresh').click();
                        }
                    });
                });
            }
        }
// END FINANCE FIELD & PHASE

// ADD REQUIREMENT FIELD
function clear_requrements_field()
{
    document.getElementById("requirement_type").value = "";
    document.getElementById("requirement_privacy").value = "";
    document.getElementById("requirement_name").value = "";
}
function requirements_add_field()
{
    clear_requrements_field();
}
$(document).ready(function(){
    fetch_requirements_field();
    $('#create_requirement_field').on('click', function(){
        space_id = <?php echo $space_id; ?>;
        type = document.getElementById("requirement_type").value;
        privacy = document.getElementById("requirement_privacy").value;
        name = document.getElementById("requirement_name").value;

        if(type == "" || privacy == "" || name == "")
        {
            alert('Please input value in all field first.');
        }
        else
        {
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: {
                    space_id:space_id,
                    type:type,
                    privacy:privacy,
                    name:name,
                    create_requirement_field: 1,
                },
                success: function(data){
                    alert('Field added successfully.');
                    clear_requrements_field();
                    $('#modal-requirementstext').modal("hide");
                    $('#modal-requirementsmodal').modal("show");
                    fetch_requirements_field();
                }
            });
        }
    });
});
function fetch_requirements_field()
{
    space_id = <?php echo $space_id; ?>;
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: false,
        data:{
            space_id:space_id,
            fetch_requirements_field: 1,
        },
            success: function(response){
                $('#fetch_requirements_field').html(response);
                $("#fetch_requirements_field").scrollTop($("#fetch_requirements_field")[0].scrollHeight);
            }
    });
}
function edit_requirement_field_text(id)
{
    field_id = id.replace("edit_requirement_field_text", ""); // Remove the string id "taskmodal";
    name = document.getElementById("requirement_name" + field_id).value;
    privacy = document.getElementById("requirement_privacy" + field_id).value;

    document.getElementById("requirements_text_field_id").value = field_id;
    document.getElementById("requirements_text_field_name").value = name;
    document.getElementById("requirements_text_field_privacy").value = privacy;
}
function delete_requirement_field(id)
{
    field_id = id.replace("delete_requirement_field", ""); // Remove the string id "taskmodal";
    type = document.getElementById("requirement_type" + field_id).value;
    if(confirm("Are you sure you want to delete this field?"))
    {
        $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: {
                    field_id:field_id,
                    type:type,
                    delete_requirement_field: 1,
                },
                success: function(data){
                    alert(data);
                    fetch_requirements_field();
                }
            });
        });
    }
}
function requirements_update_text_field()
{
    field_id = document.getElementById("requirements_text_field_id").value;
    name = document.getElementById("requirements_text_field_name").value;
    privacy = document.getElementById("requirements_text_field_privacy").value;
    if(name == "" || privacy == "")
    {
        alert('Please input value in all field first.');
    }
    else
    {
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                field_id:field_id,
                name:name,
                privacy:privacy,
                update_requirements_text_field: 1,
            },
            success: function(data){
                alert('Field updated successfully.');
                $('#modal-requirementtext').modal("hide");
                $('#modal-requirementsmodal').modal("show");
                fetch_requirements_field();
            }
        });
    }
}
function edit_requirement_field_dropdown(id)
{
    field_id = id.replace("edit_requirement_field_dropdown", ""); // Remove the string id "taskmodal";
    name = document.getElementById("requirement_name" + field_id).value;
    privacy = document.getElementById("requirement_privacy" + field_id).value;

    document.getElementById("requirements_dropdown_field_id").value = field_id;
    document.getElementById("requirements_dropdown_field_name").value = name;
    document.getElementById("requirements_dropdown_field_privacy").value = privacy;
    fetch_requirements_child();
}
function requirements_update_dropdown_field()
{
    field_id = document.getElementById("requirements_dropdown_field_id").value;
    name = document.getElementById("requirements_dropdown_field_name").value;
    privacy = document.getElementById("requirements_dropdown_field_privacy").value;
    if(name == "" || privacy == "")
    {
        alert('Please input value in all field first.');
    }
    else
    {
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                field_id:field_id,
                name:name,
                privacy:privacy,
                update_requirements_text_field: 1,
            },
            success: function(data){
                alert('Field updated successfully.');
                $('#modal-requirementdropdown').modal("hide");
                $('#modal-requirementsmodal').modal("show");
                fetch_requirements_field();
            }
        });
    }
}
function requirements_add_dropdown_option()
{
    field_id = document.getElementById("requirements_dropdown_field_id").value;
    $.ajax({
        type: "POST",
        url: "ajax.php",
        data: {
            field_id: field_id,
            requirements_add_dropdown_option: 1,
        },
        success: function(){
            fetch_requirements_child();
        }
    });
}
function fetch_requirements_child()
{
    field_id = document.getElementById("requirements_dropdown_field_id").value;
    $.ajax({
        url: 'fetch_option.php',
        type: 'POST',
        async: false,
        data:{
            field_id:field_id,
            fetch_requirements_child: 1,
        },
            success: function(response){
                $('#requirement_dropdown_option').html(response);
            }
    });
}
function rename_option_requirements(id)
{
    option_id = id.replace("rename_option_requirements", ""); // Remove the string id "rename_option_finance";
    option_name = document.getElementById("option_name_finance" + option_id).value;
    colorpicker = document.getElementById("colorpicker_finance" + option_id).value;
    if(confirm("Are you sure you want to update this option?"))
    {
        $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: "rename_option.php",
                data: {
                    option_id:option_id,
                    option_name:option_name,
                    colorpicker:colorpicker,
                    edit_requirements: 1,
                },
                success: function(){
                    fetch_requirements_child();
                    alert('Option updated successfully.');
                }
            });
        });
    }
    else
    {
        return false;
    }
}
function delete_option_requirements(id)
{
    option_id = id.replace("delete_option_requirements", ""); // Remove the string id "delete_option_finance";
    if(confirm("Are you sure you want to delete this option?"))
    {
        $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: "delete_option.php",
                data: {
                    option_id: option_id,
                    del_requirements: 1,
                },
                success: function(){
                    fetch_requirements_child();
                    alert('Option deleted successfully.');
                }
            });
        });
    }
    else
    {
        return false;
    }
}
function btn_save_requirements_field()
{
    user_id = <?php echo $id; ?>;
    task_id = document.getElementById("task_id_when_click").value;
    space_id = <?php echo $space_id; ?>;

    $(document).ready(function(){
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                space_id: space_id,
                requirements_get_field_id: 1,
            },
            success: function(data){
                field_id = data; // ex: 243,251,244,245,246,247,248,249,250
                str_to_array = field_id.split(","); //convert string to array ex: "243,251,..." => ["243","251",...]
                count_field = str_to_array.length; // count array value

                for(a = 0; a < count_field; a++)
                {
                    field_id_in_array = str_to_array[a]; // field id
                    field_value = document.getElementById("requirement_input_field" + field_id_in_array).value; // value per field
                    $.ajax({
                        type: "POST",
                        url: "ajax.php",
                        data: {
                            user_id:user_id,
                            task_id:task_id,
                            field_id_in_array: field_id_in_array,
                            field_value: field_value,
                            save_requirements_field_value: 1,
                        },
                        success: function(){
                        }
                    });
                }
                alert('Requirements updated successfully.');
                display_requirements();
                display_requirement_comment();
            }
        });
    });
}

function display_requirement_comment(){
    id = <?php echo $id; ?>;
    task_id = document.getElementById("task_id_when_click").value;
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: false,
        data:{
            id: id,
            task_id:task_id,
            display_requirement_comment: 1,
        },
            success: function(response){
                $('#requirement_comment_area').html(response);
            }
    });
}
function cancel_requirement_comment()
{
    document.getElementById("requirement_message").value = "";
    document.getElementById("requirement_attachement").value = "";
}
function send_requirement_comment()
{
    task_id = document.getElementById("task_id_when_click").value;
    user_id = <?php echo $id; ?>;
    message = document.getElementById("requirement_message").value;
    attachment = document.getElementById("requirement_attachement").value;
    if(attachment == "")
    {
        $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: "ajax.php",
                data: {
                    task_id:task_id,
                    user_id:user_id,
                    message:message,
                    send_requirement_comment:1,
                },
                success: function(response){
                    cancel_requirement_comment();
                    display_requirement_comment();
                }
            });
        });
    }
    else
    {
        tran_attachment = $('#requirement_attachement');
        file_attachment = tran_attachment.prop('files')[0];
        formData = new FormData();
        formData.append('task_id', task_id);
        formData.append('user_id', user_id);
        formData.append('message', message);
        formData.append('file_attachment', file_attachment);
        formData.append('send_requirement_comment', 1);

        $.ajax({
            url:"ajax.php",
            method:"post",
            data: formData,

            contentType:false,
            cache: false,
            processData: false,
            success:function(data){
                if(data == "success")
                {
                    cancel_requirement_comment();
                    display_requirement_comment();
                }
                else if(data == "format")
                {
                    alert("Wrong file format.");
                    document.getElementById("requirement_attachement").value = "";
                }
                else
                {
                    alert("Upload attachment not greater than 3 MB.");
                    document.getElementById("requirement_attachement").value = "";
                }
            }
        });
    }
}
function delete_requirement_comment(id)
{
    if(confirm("Are you sure you want to delete this comment?"))
    {
        id = id;
        $.ajax({
            type: "POST",
            url: "ajax_delete_comment.php",
            data: {
                id: id,
                delete_requirement_comment: 1,
            },
            success: function(data){
                alert('Comment deleted!');
                display_requirement_comment();
            }
        });
    }
    else
    {
        return false;
    }
}
// END ADD REQUIREMENT FIELD

// EMAIL HISTORY
function display_email_history_table(){
    task_id = document.getElementById("task_id_when_click").value;
    $.ajax({
        // url: 'ajax_email_history.php',
        url: 'ajax.php',
        type: 'POST',
        async: false,
        data:{
            task_id:task_id,
            display_email_history_table: 1,
        },
            success: function(response){
                $('#email_history_table').html(response);
            }
    });
}
// END EMAIL HISTORY
    </script>

    <!-- ADD Finance phase -->
    <div class="modal" id="modal-addfinancephase" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gd-sun">
                        <h3 class="block-title text-center">Add phase</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close"> <i class="si si-close"></i> </button>
                        </div>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-md-6" style="padding: 5px 10px;">
                                <input type="text" class="form-control" placeholder="Enter phase name.." id="finance_phase_name">
                            </div>
                            <div class="col-md-6" style="padding: 5px 10px;">
                                <button type="button" class="btn btn-noborder bg-primary btn-block text-white" id="create_finance_phase"><li class="fa fa-plus"></li> Add Phase</button>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="scrumboard js-scrumboard" style="margin: -40px -43px 0px -43px;">
                            <div class="scrumboard-col" style="width: 100%;">
                                <ul class="scrumboard-items block-content list-unstyled">
                                    <span id="finance_phase_id">
                                    </span>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ADD Finance phase -->

    <script>
        $(function()
        {
            space_id = <?php echo $space_id; ?>;
            $("#finance_field_sort").sortable(
            {
                connectWith: '.connectedSortable2',
                update : function ()
                {
                    $.ajax(
                    {
                        type: "POST",
                        url: "ajax.php",
                        data:
                        {
                            space_id:space_id,
                            sort1:$("#finance_field_sort").sortable('serialize'),
                            sort_finance: 1,
                        },
                        success: function(data)
                        {
                            //document.getElementById('btn_refresh').click();
                            if(data == "update")
                            {
                                alert('Order change.');
                            }
                        }
                    });
                }
            }).disableSelection();
        });
    </script>
    <!-- Edit Finance phase -->
    <div class="modal" id="modal-editfinancephase" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gd-sun">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-addfinancephase" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Phase editor</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-md-6" style="padding: 5px 10px;">
                                <input type="hidden" class="form-control text-muted" style="border-radius: 5px;" id="edit_finance_phase_id" readonly>
                                <input type="text" class="form-control" placeholder="Enter phase name.." id="edit_finance_phase_name">
                            </div>
                            <div class="col-md-6" style="padding: 5px 10px;">
                                <button type="button" class="btn btn-noborder bg-primary btn-block text-white" id="btn_save_edit_finance_phase"><li class="fa fa-check"></li> Update</button>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row">
                            <div class="col-md-12" style="padding: 5px 10px;">
                                <button type="button" class="btn btn-noborder bg-success btn-block text-white" data-toggle="modal" data-target="#modal-financetext" data-dismiss="modal" onclick="add_field()"><li class="fa fa-plus"></li> Add Field</button>
                            </div>
                        </div>
                        <div class="scrumboard js-scrumboard" style="margin: -40px -43px 0px -43px;">
                            <div class="scrumboard-col" style="width: 100%;">
                                <ul class="scrumboard-items block-content list-unstyled" id="finance_field_sort" class="connectedSortable2">
                                    <span id="finance_field_id">
                                    </span>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Edit Finance phase -->
    <!-- ADD Field selecter -->
    <div class="modal" id="modal-fieldselector" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gd-sun">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-editfinancephase" data-dismiss="modal" aria-label="Close" id="back_to_finance_editor">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Field selector</h3>
                    </div>
                    <style type="text/css">
                        .cf{border: solid 1px #efefef; border-radius: 5px; padding-top: 10px; cursor: pointer;}
                        .cf:hover{border: solid 1px #3f9ce8;}
                    </style>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="row items-push" style="margin: 0px 3px">
                            <div class="col-md-6 cf" data-toggle="modal" data-target="#modal-financetext" data-dismiss="modal">
                                <div class="cfchild text-center">
                                    <i class="fa fa-text-height fa-2x text-gray mb-15"></i>
                                    <h5 class="text-muted">Text</h5>
                                    <p>Capture short text for things like names, locations, or anything you want in just one line.</p>
                                </div>
                            </div>
                            <div class="col-md-6 cf" data-toggle="modal" data-target="#modal-financedropdown" data-dismiss="modal">
                                <div class="cfchild text-center">
                                    <i class="fa fa-angle-double-down fa-2x text-gray mb-15"></i>
                                    <h5 class="text-muted">Dropdown</h5>
                                    <p>Use dropdowns to give consistent options - even use colors!</p>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Field selecter -->
    <!-- ADD Text Finance field-->
    <div class="modal" id="modal-financetext" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gd-sun">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-editfinancephase" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Text</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Field Name</label>
                                    <input type="hidden" class="form-control" id="finance_text_field_id">
                                    <input type="text" class="form-control" placeholder="Enter field name.." id="finance_text_field_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Privacy</label>
                                    <select class="form-control" id="finance_text_privacy">
                                        <option value="">Select...</option>
                                        <option value="Public">Public</option>
                                        <option value="Private">Private</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Amount</label>
                                    <input class="form-control" type="text" id="finance_text_value" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" onchange="finance_text_value_click()" required="">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Currency</label>
                                    <select class="form-control text-muted" style="width: 100%;" id="tran_finance_currency" onchange="currency_select_for_finance(this)">
                                        <option value=""></option>
                                        <?php
                                            $currency_option = mysqli_query($conn, "SELECT * FROM finance_currency ORDER BY currency_name ASC");
                                            while($fetch = mysqli_fetch_array($currency_option))
                                            {
                                                echo '
                                                <option value="'.$fetch['currency_code'].'">'.$fetch['currency_name'].' ('.$fetch['currency_code'].')</option>
                                                ';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Amount (USD)</label>
                                    <input class="form-control" type="text" id="finance_converter_value" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-noborder bg-primary btn-block text-white" id="create_finance_field_text">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ADD Text Finance field-->
    <!-- ADD Dropdown Finance field -->
    <div class="modal" id="modal-financedropdown" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gd-sun">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-editfinancephase" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Dropdown</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Field Name</label>
                                    <input type="hidden" class="form-control" id="finance_dropdown_field_id">
                                    <input type="text" class="form-control" placeholder="Enter field name.." id="finance_dropdown_field_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Privacy</label>
                                    <select class="form-control" id="finance_dropdown_privacy">
                                        <option value="">Select...</option>
                                        <option value="Public">Public</option>
                                        <option value="Private">Private</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <button type="button" class="btn btn-noborder bg-primary btn-block text-white" id="create_finance_field_dropdown">
                            <i class="fa fa-check"></i> Save
                        </button>
                        <div id="containerid_dropdown" style="display: none;">
                            <button class="add_form_field btn btn-noborder btn-success btn-block mb-5 mt-10" id="finance_btn_add_option_id"><i class="fa fa-plus"></i> Add option
                            </button>
                            <span id="finance_dropdown_option">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ADD Dropdown Finance field -->





    <!-- ADD Requirements builder -->
    <div class="modal" id="modal-requirementsmodal" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gd-primary">
                        <h3 class="block-title text-center">Requirements builder</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close"> <i class="si si-close"></i> </button>
                        </div>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-md-12" style="padding: 5px 10px;">
                                <button type="button" class="btn btn-noborder bg-primary btn-block text-white" data-toggle="modal" data-target="#modal-requirementstext" data-dismiss="modal" onclick="requirements_add_field()"><li class="fa fa-plus"></li> Add Field</button>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="scrumboard js-scrumboard" style="margin: -40px -43px 0px -43px;">
                            <div class="scrumboard-col" style="width: 100%;">
                                <ul class="scrumboard-items block-content list-unstyled" id="requirement_field_sort" class="connectedSortable3">
                                    <span id="fetch_requirements_field">
                                    </span>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Requirements builder -->
    <!-- ADD Text Finance field-->
    <div class="modal" id="modal-requirementstext" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gd-primary">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-requirementsmodal" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Add field</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Type</label>
                                    <select class="form-control" id="requirement_type">
                                        <option value="">Select...</option>
                                        <option value="Text">Text</option>
                                        <option value="Dropdown">Dropdown</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Privacy</label>
                                    <select class="form-control" id="requirement_privacy">
                                        <option value="">Select...</option>
                                        <option value="Public">Public</option>
                                        <option value="Private">Private</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Field Name</label>
                                    <input type="text" class="form-control" placeholder="Enter field name.." id="requirement_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Option</label>
                                        <button type="button" class="btn btn-noborder bg-primary btn-block text-white" id="create_requirement_field">
                                            <i class="fa fa-check"></i> Save
                                        </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END ADD Text Finance field-->
    <!-- Requirements edit text field-->
    <div class="modal" id="modal-requirementtext" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gd-primary">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-requirementsmodal" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Text editor</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Field Name</label>
                                    <input type="hidden" class="form-control" id="requirements_text_field_id">
                                    <input type="text" class="form-control" placeholder="Enter field name.." id="requirements_text_field_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Privacy</label>
                                    <select class="form-control" id="requirements_text_field_privacy">
                                        <option value="">Select...</option>
                                        <option value="Public">Public</option>
                                        <option value="Private">Private</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row">
                            <div class="col-md-12" style="padding: 5px 10px;">
                                <button type="button" class="btn btn-noborder bg-primary btn-block text-white" onclick="requirements_update_text_field()"><li class="fa fa-check"></li> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Requirements edit text field -->
    <!-- Requirements edit dropdown field-->
    <div class="modal" id="modal-requirementdropdown" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gd-primary">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-requirementsmodal" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Dropdown editor</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Field Name</label>
                                    <input type="hidden" class="form-control" id="requirements_dropdown_field_id">
                                    <input type="text" class="form-control" placeholder="Enter field name.." id="requirements_dropdown_field_name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="wizard-simple-firstname">Privacy</label>
                                    <select class="form-control" id="requirements_dropdown_field_privacy">
                                        <option value="">Select...</option>
                                        <option value="Public">Public</option>
                                        <option value="Private">Private</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-noborder bg-primary btn-block text-white" onclick="requirements_update_dropdown_field()"><li class="fa fa-check"></li> Save</button>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-noborder bg-success btn-block text-white" onclick="requirements_add_dropdown_option()"><li class="fa fa-plus"></li> Add option</button>
                            </div>
                        </div>
                        <span id="requirement_dropdown_option">
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Requirements edit dropdown field -->

    <script>
        $(function()
        {
            space_id = <?php echo $space_id; ?>;
            $("#requirement_field_sort").sortable(
            {
                connectWith: '.connectedSortable3',
                update : function ()
                {
                    $.ajax(
                    {
                        type: "POST",
                        url: "ajax.php",
                        data:
                        {
                            space_id:space_id,
                            sort1:$("#requirement_field_sort").sortable('serialize'),
                            sort_requirement: 1,
                        },
                        success: function(data)
                        {
                            if(data == "update")
                            {
                                alert('Order change.');
                            }
                        }
                    });
                }
            }).disableSelection();
        });
    </script>






    <!-- Textarea -->
    <button type="submit" hidden="hidden" id="btn_refresh"></li>Refresh</button>
    <div class="modal" id="modal-textarea" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Textarea</h3>
                    </div>
                    <!--<form method="post">-->
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="input-group">
                            <input type="text" class="form-control text-muted" placeholder="Field name..." style="border-radius: 5px;" id="textarea_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-noborder" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-noborder" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" id="create_textarea">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                    <!--</form>-->
                </div>
            </div>
        </div>
    </div>
    <!-- END Textarea -->
    <!-- Text -->
    <div class="modal" id="modal-text" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Text</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <form method="post">
                            <div class="input-group">
                                <input type="text" class="form-control text-muted" placeholder="Field name..." style="border-radius: 5px;" id="text_name" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-noborder" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-noborder" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" id="create_text">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Text -->
    <!-- Email -->
    <div class="modal" id="modal-email" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Email</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <form method="post">
                            <div class="input-group">
                                <input type="text" class="form-control text-muted" placeholder="Field name..." style="border-radius: 5px;" id="email_name" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-noborder" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-noborder" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" id="create_email">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Email -->
    <!-- Dropdown -->
    <div class="modal" id="modal-dropdown" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Dropdown</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="input-group" style="margin-bottom: 25px;">
                            <input type="text" class="form-control text-muted" placeholder="Field name..." style="border-radius: 5px;" id="dropdown_name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-noborder" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-noborder" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" id="create_dropdown">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Dropdown -->
    <!-- Phone -->
    <div class="modal" id="modal-phone" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Phone</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <form method="post">
                            <div class="input-group">
                                <input type="text" class="form-control text-muted" placeholder="Field name..." style="border-radius: 5px;" id="phone_name" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-noborder" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-noborder" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" id="create_phone">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Phone -->
    <!-- Date -->
    <div class="modal" id="modal-date" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Date</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <form method="post">
                            <div class="input-group">
                                <input type="text" class="form-control text-muted" placeholder="Field name..." style="border-radius: 5px;" id="date_name" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-noborder" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-noborder" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" id="create_date">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Date -->
    <!-- Number -->
    <div class="modal" id="modal-number" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Number</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <form method="post">
                            <div class="input-group">
                                <input type="text" class="form-control text-muted" placeholder="Field name..." style="border-radius: 5px;" id="number_name" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-noborder" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-noborder" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" id="create_number">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Number -->
    <!-- Radio -->
    <div class="modal" id="modal-radio" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Radio</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <form method="post">
                            <div class="input-group">
                                <input type="text" class="form-control text-muted" placeholder="Field name..." style="border-radius: 5px;" id="radio_name" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-noborder" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary btn-noborder" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" id="create_radio">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Radio -->




    <!-- Edit field -->
    <div class="modal" id="modal-editfield" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Edit field</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="input-group" style="margin-bottom: 25px;">
                            <input type="hidden" class="form-control text-muted" style="border-radius: 5px;" id="edit_field_id" readonly>
                            <input type="text" class="form-control text-muted" placeholder="Field name..." style="border-radius: 5px;" id="edit_field_name" required>
                        </div>
                        <div id="containerid">
                            <button class="add_form_field btn btn-sm btn-hero btn-noborder btn-success btn-block mb-5" id="btn_add_option_id"><i class="fa fa-plus"></i> Add option
                            </button>
                            <span id="dropdown_option">
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-noborder" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" >Cancel</button>
                        <button type="button" class="btn btn-primary btn-noborder" id="btn_save_edit_field">
                            <i class="fa fa-check"></i> Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Edit field -->
    <!-- Change Field -->
    <div class="modal" id="modal-changefield" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Change order</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="text-muted" style="padding: 0px;"><?php echo $space_name; ?></h3>
                            </div>
                        </div>
                        <div class="dropdown-divider" style="margin-bottom: 20px;"></div>
                        <div class="scrumboard js-scrumboard" style="margin: -40px -43px 0px -43px;">
                            <div class="scrumboard-col" style="width: 100%;">
                                <ul class="scrumboard-items block-content list-unstyled" id="field_sort" class="connectedSortable1">
                                    <span id="change_field">
                                    </span>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Change Field -->
    <!-- Assign Field -->
    <div class="modal" id="modal-assigfield" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Assign field</h3>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="text-muted" style="padding: 0px;"><?php echo $space_name; ?></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-5">
                                <label for="crypto-settings-street-1">Field</label>
                                <select class="form-control text-muted" id="field_select" onchange="field(this)" style="width: 100%;" data-placeholder="Choose one.."> <!-- add "js-select2" to class to have a search input -->
                                </select>
                                <input type="hidden" value="" id="txt_assign_field">
                            </div>
                            <div class="col-md-2 text-center">
                                <label for="crypto-settings-street-1" style="margin: 1.5em 0em;">to</label>
                            </div>
                            <div class="form-group col-sm-5">
                                <label for="crypto-settings-street-1">Status</label>
                                <select class="form-control text-muted" id="status_select" onchange="status(this)" style="width: 100%;" data-placeholder="Choose one.."> <!-- add "js-select2" to class to have a search input -->
                                    <option></option>
                                    <?php
                                        include_once '../conn.php';
                                        $select_status = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id ='$status_list_id' ORDER BY status_order_no ASC");
                                        while($result_select_status = mysqli_fetch_array($select_status))
                                        {
                                            echo '<option style="background-color: '.$result_select_status['status_color'].'; color: #fff;" value="'.$result_select_status['status_id'].'">'.$result_select_status['status_name'].'</option>';
                                        }
                                    ?>
                                </select>
                                <input type="hidden" value="" id="txt_assign_status">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-sm btn-hero bg-corporate btn-noborder btn-block text-white" onclick="click_assign()"><li class="fa fa-check"></li> Assign</button>
                            </div>
                        </div>
                        <div class="dropdown-divider" style="margin-bottom: 10px;"></div>
                        <!-- Status -->
                        <div data-toggle="slimscroll" data-height="280px" data-color="#42a5f5" data-opacity="1" data-always-visible="true" style="background-color: #fff;" id="display_assign_field_status">
                        </div>
                        <!-- End Status -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Assign Field -->
<script>
function click_assign_field()
{
    display_field();
    display_assign_field_status();

    display_finance_field1();
    display_assign_field_phase();
}
function click_assign()
{
    var list_id = <?php echo $status_list_id; ?>;
    var assign_field_id = document.getElementById("txt_assign_field").value;
    var assign_status_id = document.getElementById("txt_assign_status").value;
    if(assign_field_id == "") { alert('Please select field.'); }
    else if(assign_status_id == "") { alert('Please select status.'); }
    else
    {
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: false,
            data:{
                list_id:list_id,
                assign_field_id:assign_field_id,
                assign_status_id:assign_status_id,
                update_field_assign: 1,
              },
                success: function(response){
                    display_field();
                }
        });
    }
    display_assign_field_status();
}
function field(select)
{
    field_id = (select.options[select.selectedIndex].value); // get field id
    document.getElementById("txt_assign_field").value = field_id;

}
function status(select)
{
    status_id = (select.options[select.selectedIndex].value); // get field id
    document.getElementById("txt_assign_status").value = status_id;
}
function remove_assign_field(id)
{
    var list_id = <?php echo $status_list_id; ?>;
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: false,
        data:{
            list_id:list_id,
            id:id,
            remove_assign_field: 1,
        },
            success: function(response){
                display_field();
                display_assign_field_status();
            }
    });
}
function display_field()
{
    document.getElementById("txt_assign_field").value = "";
    var space_id = <?php echo $space_id; ?>;
    var list_id = <?php echo $status_list_id; ?>;
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: false,
        data:{
            space_id:space_id,
            list_id:list_id,
            display_field: 1,
        },
            success: function(response){
                $('#field_select').html(response);
            }
    });
}
function display_assign_field_status(){
    var space_id = <?php echo $space_id; ?>;
    var list_id = <?php echo $status_list_id; ?>;
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: false,
        data:{
            space_id:space_id,
            list_id:list_id,
            display_assign_status: 1,
        },
            success: function(response){
                $('#display_assign_field_status').html(response);
            }
    });
}

function click_assign1()
{
    var assign_field_id = document.getElementById("txt_assign_phase_field").value;
    var assign_status_id = document.getElementById("txt_assign_phase").value;
    if(assign_field_id == "") { alert('Please select field.'); }
    else if(assign_status_id == "") { alert('Please select phase.'); }
    else
    {
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            async: false,
            data:{
                assign_field_id:assign_field_id,
                assign_status_id:assign_status_id,
                assign_field_phase: 1,
              },
                success: function(response){
                    display_finance_field1();
                }
        });
    }
    display_assign_field_phase();
}
function field1(select)
{
    field_id = (select.options[select.selectedIndex].value); // get field id
    document.getElementById("txt_assign_phase_field").value = field_id;
}
function status1(select)
{
    status_id = (select.options[select.selectedIndex].value); // get field id
    document.getElementById("txt_assign_phase").value = status_id;
}
function remove_assign_field_phase(id)
{
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: false,
        data:{
            id:id,
            remove_assign_field_phase: 1,
        },
            success: function(response){
                display_finance_field1();
                display_assign_field_phase();
            }
    });
}
function display_finance_field1()
{
    document.getElementById("txt_assign_phase_field").value = "";
    var space_id = <?php echo $space_id; ?>;
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: false,
        data:{
            space_id:space_id,
            display_finance_field1: 1,
        },
            success: function(response){
                $('#field_select1').html(response);
            }
    });
}
function display_assign_field_phase(){
    var space_id = <?php echo $space_id; ?>;
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: false,
        data:{
            space_id:space_id,
            display_assign_phase: 1,
        },
            success: function(response){
                $('#display_assign_field_phase').html(response);
            }
    });
}
</script>

    <!-- Custom Field -->
    <div class="modal" id="modal-customfield" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <h3 class="block-title">Custom field editor</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option"  data-dismiss="modal" aria-label="Close"> <i class="si si-close"></i> </button>
                            <!-- <button type="button" class="btn-block-option" onClick="window.location.reload();"  data-dismiss="modal" aria-label="Close"> <i class="si si-close"></i> </button> -->
                        </div>
                    </div>
                    <div class="block-content" style="margin-bottom: 15px;">
                        <div class="row">
                            <div class="col-12">
                                <h3 class="text-muted" style="padding: 0px;"><?php echo $space_name; ?></h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6" style="padding: 5px 10px;">
                                <button type="submit" name="save" class="btn btn-sm btn-hero btn-noborder btn-primary btn-block" data-toggle="modal" data-target="#modal-createfield" data-dismiss="modal"><li class="fa fa-plus"></li> Add field</button>
                            </div>
                            <div class="col-md-6" style="padding: 5px 10px;">
                                <button type="submit" name="save" class="btn btn-sm btn-hero btn-noborder btn-success btn-block" data-toggle="modal" data-target="#modal-changefield" data-dismiss="modal" id="btn_change_field"><li class="fa fa-sort"></li> Change order</button>
                            </div>
                        </div>
                        <div class="dropdown-divider"></div>
                        <div class="row">
                            <div class="col-md-12" style="padding: 5px 10px;">
                                <button type="submit" name="save" class="btn btn-sm btn-hero btn-noborder bg-corporate btn-block text-white" data-toggle="modal" data-target="#modal-assigfield" data-dismiss="modal" id="btn_change_field" onclick="click_assign_field()"><li class="fa fa-object-ungroup"></li> Assign field</button>
                            </div>
                        </div>
                        <div class="scrumboard js-scrumboard" style="margin: -40px -43px 0px -43px;">
                            <div class="scrumboard-col" style="width: 100%;">
                                <ul class="scrumboard-items block-content list-unstyled" class="connectedSortable1">
                                    <span id="field_area">
                                    </span>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Custom Field -->

    <script>
        $(function()
        {
            space_id = <?php echo $space_id; ?>;
            $("#field_sort").sortable(
            {
                connectWith: '.connectedSortable1',
                update : function ()
                {
                    $.ajax(
                    {
                        type: "POST",
                        url: "update_field_order.php",
                        data:
                        {
                            space_id:space_id,
                            sort1:$("#field_sort").sortable('serialize')
                        },
                        success: function(html)
                        {
                            document.getElementById('btn_refresh').click();
                        }
                    });
                }
            }).disableSelection();
        });
    </script>
    <!-- Custom Field ADD -->
    <div class="modal" id="modal-createfield" tabindex="-1" role="dialog" aria-labelledby="modal-large" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-corporate">
                        <div class="block-options" style="margin-left: -15px;">
                            <button type="button" class="btn-block-option" data-toggle="modal" data-target="#modal-customfield" data-dismiss="modal" aria-label="Close">
                                <i class="si si-arrow-left"></i> Back
                            </button>
                        </div>
                        <h3 class="block-title text-center">Create field</h3>
                    </div>
                    <style type="text/css">
                        .cf{border: solid 1px #efefef; border-radius: 5px; padding-top: 10px; cursor: pointer;}
                        .cf:hover{border: solid 1px #3f9ce8;}
                    </style>
                    <div class="block-content">
                        <div class="row items-push" style="margin: 0px 3px">
                            <div class="col-md-6 col-xl-3 cf" data-toggle="modal" data-target="#modal-textarea" data-dismiss="modal">
                                <div class="cfchild text-center">
                                    <i class="fa fa-text-width fa-2x text-gray mb-15"></i>
                                    <h5 class="text-muted">Text area (Long text)</h5>
                                    <p>Capture lots of text for things like notes, descriptions, addresses, or anything that takes up more than one line.</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3 cf" data-toggle="modal" data-target="#modal-text" data-dismiss="modal">
                                <div class="cfchild text-center">
                                    <i class="fa fa-text-height fa-2x text-gray mb-15"></i>
                                    <h5 class="text-muted">Text</h5>
                                    <p>Capture short text for things like names, locations, or anything you want in just one line.</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3 cf" data-toggle="modal" data-target="#modal-email" data-dismiss="modal">
                                <div class="cfchild text-center">
                                    <i class="fa fa-envelope-o fa-2x text-gray mb-15"></i>
                                    <h5 class="text-muted">Email</h5>
                                    <p>Track clients, vendors, leads, and more by entering emails.</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3 cf" data-toggle="modal" data-target="#modal-dropdown" data-dismiss="modal">
                                <div class="cfchild text-center">
                                    <i class="fa fa-angle-double-down fa-2x text-gray mb-15"></i>
                                    <h5 class="text-muted">Dropdown</h5>
                                    <p>Use dropdowns to give consistent options - even use colors!</p>
                                </div>
                            </div>
                        </div>
                        <div class="row items-push" style="margin: 0px 3px">
                            <div class="col-md-6 col-xl-3 cf" data-toggle="modal" data-target="#modal-phone" data-dismiss="modal">
                                <div class="cfchild text-center">
                                    <i class="fa fa-phone fa-2x text-gray mb-15"></i>
                                    <h5 class="text-muted">Phone</h5>
                                    <p>Use this in adding phone numbers.</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3 cf" data-toggle="modal" data-target="#modal-date" data-dismiss="modal">
                                <div class="cfchild text-center">
                                    <i class="fa fa-calendar-o fa-2x text-gray mb-15"></i>
                                    <h5 class="text-muted">Date</h5>
                                    <p>Add any date to your task.</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3 cf" data-toggle="modal" data-target="#modal-number" data-dismiss="modal">
                                <div class="cfchild text-center">
                                    <i class="fa fa-hashtag fa-2x text-gray mb-15"></i>
                                    <h5 class="text-muted">Number</h5>
                                    <p>Use number fields for accounting, inventory, or tracking.</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-3 cf" data-toggle="modal" data-target="#modal-radio" data-dismiss="modal">
                                <div class="cfchild text-center">
                                    <i class="fa fa-dot-circle-o fa-2x text-gray mb-15"></i>
                                    <h5 class="text-muted">Radio</h5>
                                    <p>Add a simple true or false condition or yes or no? using radio button.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-alt-success" data-dismiss="modal">
                        <i class="fa fa-check"></i> Perfect
                    </button>
                </div>-->
            </div>
        </div>
    </div>
    <!-- END Custom Field ADD -->

    <!-- Rename Space Modal -->
    <div class="modal fade" id="modal-rename" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gd-corporate">
                        <h3 class="block-title">Space Editor</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close"> <i class="si si-close"></i> </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <label class="text-muted">Space Name</label>
                        <form method="post">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Space name here..." name="space_name" value="<?php echo $space_name;?>" required>
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-primary min-width-125 js-click-ripple-enabled" name="btn_rename_space"> <i class="fa fa-check"></i> Save </button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <form method="post">
                            <label class="text-muted">Add list here</label>
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Add List..." name="add_list" required>
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-success btn-noborder mr-5 mb-5" name="btn_add_list"> <i class="fa fa-plus"></i> Add</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
    <!-- END Rename Modal -->

    <!-- Delete Space Modal -->
    <div class="modal fade" id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form method="post">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-danger">
                            <h3 class="block-title">Delete Space</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close"> <i class="si si-close"></i> </button>
                            </div>
                        </div>
                        <input type="hidden" name="count_list" value="<?php echo $count_list; ?>">
                        <input type="hidden" name="count_status" value="<?php echo $count_status; ?>">
                        <div class="block-content">
                            <div class="form-material floating" style="margin: -30px 0px 20px 0px;">
                                <p class="text-center"> <i class="fa fa-warning text-danger mr-5 fa-4x"></i> </p>
                                <h5 class="text-muted text-center" style="margin: -20px 0px 0px 0px;">Are you sure you want to delete this space?</h5>
                                <h3 class="text-muted text-center"><?php echo $space_name;?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class=" row">
                            <button type="submit" name="btn_delete_space" class="btn btn-sm btn-hero btn-noborder btn-danger btn-block"> <i class="fa fa-exclamation-triangle mr-5"></i>Yes </button>
                        </div>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Delete Modal -->

    <!-- Pop Out Modal -->
        <div class="modal fade" id="modal-popout" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog modal-dialog-popout" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <!-- <div class="block-header bg-primary-dark"> -->
                        <div class="block-header" style="background-color: #045D71;">
                            <h3 class="block-title"><button style="background-color: #045D71;" onclick="go_back()"><</button> Select Email Sender</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            
                        </div>
                    </div>
                            <div class="col-md-12">
                                <select class="form-control" id="email_name" onchange="email_selection(this)">
                                    <option disabled="" selected="">Please select email</option>
                                    <?php 
                                    $query = mysqli_query($conn, "SELECT * FROM tbl_list_email ORDER BY list_email_name");

                                    while ($data = mysqli_fetch_array($query)) {
                                        echo '
                                            <option value="'.$data['list_email_name'].'">'.$data['list_email_name'].'</option>
                                        ';
                                    }
                                     ?>
                                    <!-- <option value="1">Option #1</option>
                                    <option value="2">Option #2</option>
                                    <option value="3">Option #3</option> -->
                                </select>
                            </div><br>
                            <textarea class="form-control mb-15" id="email_content" rows="12" style="display: none;"></textarea>
                            <span id="view_email_name"></span>
                    <div class="modal-footer">
                        <!-- <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-alt-success" data-dismiss="modal">
                            <i class="fa fa-check"></i> Perfect
                        </button> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END Pop Out Modal -->

<script>
    function email_selection(select)
    {   
        email_name = (select.options[select.selectedIndex].value);
        // alert(email_name);
        // task_id = document.getElementById("task_id_when_click").value;

        // alert(task_id);
        $.ajax({
        url: 'ajax_transaction.php',
        type: 'POST',
        async: false,
        data:{
            set_email:email_name,
            set_list_of_email: 1,
        },
            success: function(response){
                if (response == 'success') {
                    // alert('Na save ang session');
                    display_email_name();
                }
            }
        });
    }

    function go_back()
    {
        $('#modal-popout').modal("hide");
        $('#modal-extra-large').modal("show");
        $('#modal-extra-large').css('overflow-y', 'auto');
    }

    hide_status()
    function hide_status(){
        list_id = <?php echo $_GET['list_id']; ?>

        // alert(list_id);
        $.ajax({
        url: 'ajax.php',
        type: 'POST',
        async: false,
        data:{
            list_id:list_id,
            hide_status: 1,
        },
            success: function(response){
                $('#hide_status').html(response);
            }
        });
    }

</script>

<!-- End board view modal -->
 