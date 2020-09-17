<?php
    $md_primary_darker = "";
    $md_text = "text-muted";
    $md_body = "bg-gd-default";
    $md_stat = "";
    $md_heading = "bg-gd-corporate";
    if($mode_type == "Dark") //insert
    { 
        $md_primary_darker = "bg-primary-darker";
        $md_text = "text-white";
        $md_body = "bg-gray-darker text-body-color-light";
        $md_stat = "bg-gray-darker text-body-color-light";
        $md_heading = "bg-gray-darker text-body-color-light";
    }

    $select_space_sort = mysqli_query($conn, "SELECT * FROM space_sort");
    $fetch_space_sort = mysqli_fetch_array($select_space_sort);
    $sort_user_id = $fetch_space_sort['sort_user_id'];

    $select_from_user = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$sort_user_id'");
    $fetch_user_id = mysqli_fetch_array($select_from_user);
    $full_name = $fetch_user_id['fname'].' '.$fetch_user_id['mname'].' '.$fetch_user_id['lname'];

    if(isset($_POST['btn_add_space']))
    {
        $space_name     = $_POST['space_name'];
        $space_type     = $_POST['space_type'];          
        $list_name     = $_POST['list_name'];

        date_default_timezone_set('Asia/Manila');
        $date = date("mdis"); // for unique file name
        //$todays_date = date("y-m-d H:i:sa"); //  original format

        $con = mysqli_query($conn, "SELECT * FROM space WHERE space_name='$space_name'");
        if(mysqli_num_rows($con) == 0)
        {
            // --------------- Get first 3 letter in first and secod word. ex: 'Endorsement Hawaii'
            $words = explode(' ',trim($space_name));
            $total_words = str_word_count($space_name);
            if($total_words == 1)
            {
                $get_name = strtolower('z'.$date.'_'.substr($words[0], 0, 3)); 
                // ------- result = "Space_End"                            
            }
            else
            {
                $get_name = strtolower('z'.$date.'_'.substr($words[0], 0, 3).'_'.substr($words[1], 0, 3)); 
                // ------- result = "Space_End_Haw"
            }

            $sql = "CREATE TABLE IF NOT EXISTS `$get_name` (
                `id` int(11) AUTO_INCREMENT PRIMARY KEY,
                `task_id` int(11) NOT NULL
                ) ENGINE=InnoDB DEFAULT CHARSET=latin2";
            if (mysqli_query($conn, $sql))
            {}
            else 
            {
                echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
            }

            $insert = mysqli_query($conn, "INSERT INTO space(space_name,space_type,space_date_created,space_db_table) VALUES('$space_name','$space_type',NOW(),'$get_name')") or die(mysqli_error());
            if($insert)
            {
                $que = mysqli_query($conn, "SELECT * FROM space WHERE space_name='$space_name'");
                $res = mysqli_fetch_array($que);
                $space_id = $res['space_id'];

                $insert = mysqli_query($conn, "INSERT INTO list(list_name,list_space_id,list_date_created) VALUES('$list_name','$space_id',NOW())") or die(mysqli_error());

                $select_list = mysqli_query($conn, "SELECT * FROM list WHERE list_space_id='$space_id'");
                $fetch_select_list = mysqli_fetch_array($select_list);
                $list_id = $fetch_select_list['list_id'];

                // code to add the space in sorting per admin user
                $select_space_sort = mysqli_query($conn, "SELECT * FROM space_sort ORDER BY sort_id ASC");
                $count = mysqli_num_rows($select_space_sort);
                if($count != 0) // check if no sort
                {
                    $user_id_array = array();
                    while($rows = mysqli_fetch_array($select_space_sort))
                    {
                        $user_id = $rows['sort_user_id'];
                        if (in_array($user_id, $user_id_array)) // check if user_id is in array
                        {}
                        else
                        {
                            array_push($user_id_array,$user_id); // add user_id in array
                        }
                    }

                    $select_space = mysqli_query($conn, "SELECT * FROM space");
                    $count1 = mysqli_num_rows($select_space);

                    $count_user_array = count($user_id_array);
                    for($x = 0; $x < $count_user_array; $x++)
                    {
                        $user_id_in_array = $user_id_array[$x];
                        mysqli_query($conn,"INSERT into space_sort values ('', '$user_id_in_array', '$space_id', '$count1')") or die(mysqli_error());
                    }
                }
                // end

                echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$list_id'</script>";
            }
            else
            {
                echo "<script type='text/javascript'>alert('Opps error found please contact admin.');</script>";
            }
        }
        else
        { 
        echo "<script type='text/javascript'>alert('Space name already exists. Please try again.');</script>";
        }
    }
?>

<script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
<script src="../assets/js/jquery.min.js"></script>  

<!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                <div class="content <?php echo $md_primary_darker; ?>">
                    <!-- Form Wizards functionality is initialized in js/pages/be_forms_wizard.min.js which was auto compiled from _es6/pages/be_forms_wizard.js -->
                    <!-- For more info and examples you can check out https://github.com/VinceG/twitter-bootstrap-wizard -->

 
                    <!-- Validation Wizards -->
                    <h2 class="content-heading <?php echo $md_text; ?>">Space Builder</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Colorful Scrollbar -->
                            <div class="block shadow <?php echo $md_stat; ?>">
                                <div class="block-header content-heading <?php echo $md_heading; ?>">
                                    <h3 class="block-title text-white">Space List | Sort by: <span style="background-color: <?php echo $fetch_user_id['user_color']; ?>; padding: 3px 10px; border-radius: 3px;"><?php echo $full_name; ?></span></h3>
                                </div>
                                <!--<div class="block-content" data-toggle="slimscroll" data-height="225px" data-color="#42a5f5" data-opacity="1" data-always-visible="true" style="padding-bottom: 40px;">-->
                                <div class="block-content <?php echo $md_stat; ?>">
                                    <div class="scrumboard js-scrumboard" style="margin: -50px -43px 0px -43px;">
                                        <div class="scrumboard-col" style="width: 100%;">
                                            <ul class="scrumboard-items block-content list-unstyled" id="requirement_field_sort" class="connectedSortable3">
                                                <span id="fetch_space_for_sort">
                                                </span>
                                            </ul>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                            <!-- END Colorful Scrollbar -->
                        </div>
                        <div class="col-md-6">
                            <!-- Validation Wizard Classic -->
                            <div class="js-wizard-validation-classic block">
                                <!-- Wizard Progress Bar -->
                                <div class="progress rounded-0" data-wizard="progress" style="height: 8px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 30%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!-- END Wizard Progress Bar -->
                                <!-- Step Tabs -->
                                <ul class="nav nav-tabs nav-tabs-alt nav-fill <?php echo $md_stat; ?>" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active <?php echo $md_text; ?>" href="#wizard-progress2-step1" data-toggle="tab" id="btnStartVisit" onclick="StartVisit(1)">Space</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo $md_text; ?>" href="#wizard-progress2-step2" data-toggle="tab">List</a>
                                    </li>         
                                </ul>
                                <!-- END Step Tabs -->

                                <!-- Form -->
                                <form class="js-wizard-validation-classic-form" method="post">
                                    <!-- Steps Content -->
                                    <div class="block-content block-content-full tab-content shadow <?php echo $md_stat; ?>" style="min-height: 274px;">
                                        <!-- Step 1 -->
                                        <div class="tab-pane active " id="wizard-progress2-step1" role="tabpanel">   
                                            <div class="form-group">
                                                <div class="form-material floating">
                                                    <input class="form-control <?php echo $md_text; ?>" type="text" name="space_name" required>
                                                    <label for="wizard-simple2-location">Space name</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="form-material floating">
                                                    <select class="form-control <?php echo $md_text; ?>" name="space_type" size="1" required>
                                                        <option value=""></option><!-- Empty value for demostrating material select box -->
                                                        <option class="text-muted" value="IPASS Processing Workspace">IPASS Processing Workspace</option>
                                                        <option class="text-muted" value="Private">Private</option>
                                                    </select required>
                                                    <label for="wizard-progress2-skills">Who is this space for?</label>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <p>Spaces can be shared with Members. You can add Guests to Folders, Lists, and Tasks after creating a space.</p>
                                            </div>
                                        </div>
                                        <!-- END Step 1 -->

                                        <!-- Step 2 -->
                                        <div class="tab-pane" id="wizard-progress2-step2" role="tabpanel">
                                            <div class="form-group">
                                                <div class="form-material floating">
                                                    <input class="form-control <?php echo $md_text; ?>" type="text" name="list_name" required>
                                                    <label for="wizard-simple2-location">List Name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END Step 2 -->
                                    </div>
                                    <!-- END Steps Content -->


                                    <!-- Steps Navigation -->
                                    <div class="block-content block-content-sm block-content-full bg-body-light <?php echo $md_stat; ?>">
                                        <div class="row">
                                            <div class="col-6">
                                                <button type="button" class="btn btn-alt-secondary" data-wizard="prev">
                                                    <i class="fa fa-angle-left mr-5"></i> Previous
                                                </button>
                                            </div>
                                            <div class="col-6 text-right">
                                                <button type="button" class="btn btn-alt-secondary" data-wizard="next">
                                                    Next <i class="fa fa-angle-right ml-5"></i>
                                                </button>
                                                <button type="submit" class="btn btn-alt-primary d-none" data-wizard="finish" name="btn_add_space">
                                                    <i class="fa fa-check mr-5"></i> Submit
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Steps Navigation -->
                                </form>
                                <!-- END Form -->
                            </div>
                            <!-- END Validation Wizard Classic -->
                        </div>
                    </div>
                    <!-- END Validation Wizards -->
                </div>
                <!-- END Page Content -->

            </main>
            <!-- END Main Container -->

            

<script type="text/javascript">
    $(document).ready(function(){
        fetch_space_for_sort();
    });
    function fetch_space_for_sort()
    {
        user_id = <?php echo $row['user_id']; ?>;
        $.ajax({
            url: 'ajax.php',
            type: 'POST', 
            async: false,
            data:{
                fetch_space_for_sort: 1,
            },
                success: function(response){
                    $('#fetch_space_for_sort').html(response);
                    $("#fetch_space_for_sort").scrollTop($("#fetch_space_for_sort")[0].scrollHeight);
                }
        });
    }

    $(function() 
    {
        user_id = <?php echo $row['user_id']; ?>;
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
                        user_id:user_id,
                        sort1:$("#requirement_field_sort").sortable('serialize'),
                        sort_space_per_user: 1,
                    },
                    success: function(data)
                    {                            
                        if(data == "update")
                        {   
                            alert('Sort updated.');
                        }
                        else
                        {
                            alert('New sort created.');                            
                        }
                        location.reload();
                    }
                });
            } 
        }).disableSelection();
    });
</script>

