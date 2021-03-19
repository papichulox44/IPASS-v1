<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15">
            <!-- Mini Mode -->
            <div class="content-header-section sidebar-mini-visible-b">
                <!-- Logo -->
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                    <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                </span>
                <!-- END Logo -->
            </div>
            <!-- END Mini Mode -->

            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->

        <!-- Side User -->
        <div class="content-side content-side-full content-side-user px-10 align-parent">
            <!-- Visible only in normal mode -->
            <div class="sidebar-mini-hidden-b text-center">
                <a class="img-link" href="profile.php">
                    <?php if($row['contact_profile'] != ""): ?>
                        <img class="img-avatar" src="client_profile/<?php echo $row['contact_profile']; ?>">
                    <?php else: ?>
                        <img class="img-avatar" src="../assets/media/photos/avatarpic.jpg">
                    <?php endif; ?>
                </a>
                <ul class="list-inline mt-10">
                    <li class="list-inline-item">
                        <span class="d-none d-sm-inline-block"><?php echo $row['contact_fname'].' '.$row['contact_mname'].' '.$row['contact_lname'];?></span>
                    </li>
                </ul>
            </div>
            <!-- END Visible only in normal mode -->
        </div>
        <!-- END Side User -->

        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <?php
                    $user_id = $row['contact_id'];

                    $findcontact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_assign_to = ''");
                    $total_unassign = mysqli_num_rows($findcontact);
                    if($highlight == "dashboard.php")
                    {
                        if (empty($_GET['space_name']))
                        {
                            $dashboard_style = "background-color: #20527b;";
                        }
                        else
                        {
                            $openspaces = "open";
                            $dashboard_style = "";
                        }
                    }
                    else if($highlight == "status.php")
                    {
                        $status_style = "background-color: #20527b;";
                    }
                    else if($highlight == "admin_main_notification.php")
                    {
                        $notification_style = "background-color: #20527b;";
                    }
                    else if($highlight == "admin_main_people.php")
                    {
                        $people_style = "background-color: #20527b;";
                    }
                    else if($highlight == "personal_details.php")
                    {
                        $opencontact = "open";
                        $add = "background-color: #20527b; padding-left: 15px; margin-left: -15px;";
                    }
                    else if($highlight == "change_password.php")
                    {
                        $opencontact = "open";
                        $assign = "background-color: #20527b; padding-left: 15px; margin-left: -15px;";
                    }
                    else if($highlight == "space.php")
                    {
                        $openspaces = "open";
                        $children_add_space = "background-color: #20527b; padding-left: 15px; margin-left: -15px;";
                    }
                    else
                    {}
                ?>

                <li>
                    <a href="dashboard.php" style="<?php echo $dashboard_style; ?>"><i class="si si-cup"></i>Dashboard</a>
                </li>
                <li class="nav-main-heading"><span class="sidebar-mini-visible">MG</span><span class="sidebar-mini-hidden">Manage</span>
                </li>
                <li class="<?php echo $opencontact;?>">
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-settings"></i><span class="sidebar-mini-hide">Account</span>
                    </a>
                    <ul>
                        <li>
                            <a href="personal_details.php" style="<?php echo $add;?>">Personal details
                            </a>
                        </li>
                        <li>
                            <a href="change_password.php" style="<?php echo $assign;?>">Change password</a>
                        </li>
                    </ul>
                </li>

                <li class="<?php echo $openspaces;?>">
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-grid"></i><span class="sidebar-mini-hide">Services </span>
                      <small style="color: green; font-size: 14px;">
                        <?php
                        $contact_id = $row['contact_id'];
                        $select_movement = mysqli_query($conn, "SELECT Count(tbl_movement.contact_id) AS movement FROM tbl_movement WHERE contact_id = $contact_id AND status = 0");
                        $data = mysqli_fetch_assoc($select_movement);
                        echo $data['movement'];
                         ?>
                      </small>
                    </a>
                    <ul>
<?php
    $contact_assign_to = $row['contact_assign_to'];
    $assign_array = explode(",", $contact_assign_to);
    $count = count($assign_array);
    for($x = 0; $x < $count; $x+=3)
    {
        $y = $x;
        $space_id = $assign_array[$y];
        $list_id = $assign_array[$y + 1];
        $status_id = $assign_array[$y + 2]; // get the value of array per key

        $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$space_id'");
        $fetch_select_space = mysqli_fetch_array($select_space);
        $select_list = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$list_id'");
        $fetch_select_list = mysqli_fetch_array($select_list);
        $select_status = mysqli_query($conn, "SELECT * FROM status WHERE status_id = '$status_id'");
        $fetch_select_status = mysqli_fetch_array($select_status);

        if (empty($_GET['space']))
        {
            $space_id = "";
            $list_id = "";
        }
        else
        {
            $space_id = $_GET['space'];
            $list_id = $_GET['list'];
        }
        if($fetch_select_list['list_id'] == $list_id)
        { ?>
            <li class="open">
                <a class="nav-submenu" href="#" data-toggle="nav-submenu"><?php echo $fetch_select_space['space_name'];?></a>
                <ul>
                    <li>
                        <a style="background-color: #20527b; padding-left: 15px; margin-left: -15px;" href="space.php?space=<?php echo $fetch_select_space['space_id'];?>&list=<?php echo $fetch_select_list['list_id'];?>&status=<?php echo $fetch_select_status['status_id'];?>"><?php echo $fetch_select_list['list_name'];?></a>
                    </li>
                </ul>
            </li>
        <?php }
        else
        { ?>
            <li>
                <a class="nav-submenu" href="#" data-toggle="nav-submenu"><?php echo $fetch_select_space['space_name'];?></a>
                <ul>
                    <li>
                        <a href="space.php?space=<?php echo $fetch_select_space['space_id'];?>&list=<?php echo $fetch_select_list['list_id'];?>&status=<?php echo $fetch_select_status['status_id'];?>"><?php echo $fetch_select_list['list_name'];?></a>
                    </li>
                </ul>
            </li>
        <?php }
        ?>
    <?php
    }
?>
                    </ul>
                </li>


                <li>
                    <a href="logout.php?logout"><i class="si si-logout"></i><span class="sidebar-mini-hide">Sign Out</span></a>
                </li>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- Sidebar Content -->
</nav>
<!-- END Sidebar -->
<script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
