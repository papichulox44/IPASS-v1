<?php   
    $user_type = $row['user_type'];
    $user_id = $row['user_id'];
?>
<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15">
            <!-- Mini Mode -->
            <div class="content-header-section sidebar-mini-visible-b">
                <!-- Logo 
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                    <span class="text-dual-primary-dark">c</span><span class="text-primary">b</span>
                </span>-->
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
            <!-- Visible only in mini mode -->
            <div class="sidebar-mini-visible-b align-v animated fadeIn">
                <a class="img-link" href="main_personal_details.php">
                    <?php if($row['profile_pic'] != ""): ?>
                        <img class="img-avatar img-avatar32" src="../assets/media/upload/<?php echo $row['profile_pic']; ?>">
                    <?php else: ?>
                        <img class="img-avatar img-avatar32" src="../assets/media/photos/avatar.jpg">
                    <?php endif; ?>                               
                </a>
            </div>
            <!-- END Visible only in mini mode -->
            <!-- Visible only in normal mode -->
            <div class="sidebar-mini-hidden-b text-center">
                <a class="img-link" href="main_personal_details.php">
                    <?php if($row['profile_pic'] != ""): ?>
                        <img class="img-avatar" src="../assets/media/upload/<?php echo $row['profile_pic']; ?>">
                    <?php else: ?>
                        <img class="img-avatar" src="../assets/media/photos/avatar.jpg">
                    <?php endif; ?>                               
                </a>
                <ul class="list-inline mt-10">
                    <li class="list-inline-item">
                            <span class="d-none d-sm-inline-block"><?php echo $row['fname'];?></span>
                        </li>
                    <li class="list-inline-item" data-toggle="popover" title="Change mode" data-placement="bottom" class="js-popover-enabled">
                        <!-- <a class="text-dual-primary-dark" onclick="mode()" href="javascript:void(0)">
                            <i class="si si-drop"></i>
                        </a> -->
                        <a class="text-dark" data-toggle="theme" data-theme="../assets/css/themes/dark.min.css" id="btn_dark" style="display: none;">
                            <i class="fa fa-2x fa-circle"></i>
                        </a>
                        <a class="text-white" data-toggle="theme" data-theme="../assets/css/themes/white.min.css" id="btn_white" style="display: none;">
                            <i class="fa fa-2x fa-circle"></i>
                        </a>
                    </li>
                    <?php 
                        if($user_type == "Admin")
                        {
                            echo '<span class="badge badge-primary text-white">'.$row['user_type'].'</span> ';
                        }   
                        else if($user_type == "Supervisory")
                        {
                            echo '<span class="badge text-white" style="background-color: #d0a218;">'.$row['user_type'].'</span> ';
                        }
                        else
                        {
                            echo '<span class="badge text-white" style="background-color: #2c8a8a;">'.$row['user_type'].'</span> ';
                        }
                    ?>
                </ul>
            </div>
            <!-- END Visible only in normal mode -->
        </div>
        <!-- END Side User -->

<?php 
    if($user_type == "Admin")
    { ?>
        <!-- ADMIN Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <?php 
                    $user_id = $row['user_id'];

                    $findcontact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_assign_to = ''");
                    $total_unassign = mysqli_num_rows($findcontact);
                    if($highlight == "main_dashboard.php")
                    {
                        if (empty($_GET['space_name'])) 
                        {
                            $dashboard_style = "background-color: #20527b; color: #eee;";
                            $ico1 = "text-white-op";
                        }
                        else
                        {
                            $openspaces = "open";
                            $dashboard_style = "";
                        }
                    }
                    else if($highlight == "main_inbox.php")
                    {
                        $inbox_style = "background-color: #20527b; color: #eee;";
                        $ico2 = "text-white-op";
                    }
                    else if($highlight == "main_email_format.php")
                    {
                        $email_style = "background-color: #20527b; color: #eee;";
                        $ico10 = "text-white-op";
                    }
                    else if($highlight == "main_transaction.php")
                    {
                        $transaction_style = "background-color: #20527b; color: #eee;";
                        $ico9 = "text-white-op";
                    }
                    else if($highlight == "main_notification.php")
                    {
                        $notification_style = "background-color: #20527b; color: #eee;";
                        $ico3 = "text-white-op";
                    }
                    else if($highlight == "main_people.php")
                    {
                        $people_style = "background-color: #20527b; color: #eee;";
                        $ico4 = "text-white-op";
                    }
                    else if($highlight == "main_contact_add.php")
                    {
                        $opencontact = "open"; 
                        $add = "background-color: #20527b; color: #eee; padding-left: 15px; margin-left: -15px;";
                        $ico5 = "text-white-op";
                    }
                    else if($highlight == "main_contact_assign.php")
                    {
                        $opencontact = "open"; 
                        $assign = "background-color: #20527b; color: #eee; padding-left: 15px; margin-left: -15px;";
                        $ico6 = "text-white-op";
                    }
                    else if($highlight == "main_add_space.php")
                    {
                        $openspaces = "open";
                        $children_add_space = "background-color: #20527b; color: #eee; padding-left: 15px; margin-left: -15px;";
                        $ico7 = "text-white-op";
                    }
                    else if($highlight == "main_everything.php")
                    {
                        $openspaces = "open";
                        $children_everything = "background-color: #20527b; color: #eee; padding-left: 15px; margin-left: -15px;";
                        $ico8 = "text-white-op";
                    }
                    else
                    {}
                ?>

                <li>
                    <a href="dashboard.php" style="<?php echo $dashboard_style; ?>"><i class="si si-cup <?php echo $ico1; ?>"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                </li>
                <li>
                    <a href="main_inbox.php" style="<?php echo $inbox_style; ?>"><i class="si si-envelope <?php echo $ico2; ?>"></i><span class="sidebar-mini-hide">Inbox</span>
                        <small id="new_message"></small>
                    </a>                        
                </li>
                <li>
                    <a href="main_email_format.php" style="<?php echo $email_style; ?>"><i class="fa fa-send-o <?php echo $ico10; ?>"></i><span class="sidebar-mini-hide">Email format</span>   
                        <small id="new_message"></small>
                    </a>                        
                </li>
                <li>
                    <a href="main_transaction.php?view=All Remarks&filter=This Week" style="<?php echo $transaction_style; ?>"><i class="si si-wallet <?php echo $ico9; ?>"></i><span class="sidebar-mini-hide">Transaction</span>
                        <small id="new_message"></small>
                    </a>                        
                </li>
                <li>
                    <a href="main_notification.php" style="<?php echo $notification_style; ?>"><i class="si si-bell <?php echo $ico3; ?>"></i><span class="sidebar-mini-hide">Notification</span></a>
                </li>
                <li>
                    <a href="main_people.php" style="<?php echo $people_style; ?>"><i class="si si-users <?php echo $ico4; ?>"></i><span class="sidebar-mini-hide">Member 
                        <?php
                            $select_user = mysqli_query($conn, "SELECT * FROM user WHERE user_type = ''");
                            $count_user = mysqli_num_rows($select_user);
                            if($count_user == 0) {}
                            else
                            { echo '<span class="badge badge-danger">'.$count_user.'</span>'; }
                        ?>
                    </span></a>
                </li> 
                <li class="<?php echo $opencontact;?>">
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-address-book-o <?php echo $ico5; ?>"></i><span class="sidebar-mini-hide">Contact</span>
                        <?php
                            if($total_unassign == 0){}
                            else
                            {echo '<span class="badge badge-primary badge-pill">'.$total_unassign.'</span>';}
                        ?>
                    </a>
                    <ul>
                        <li>
                            
                            <a href="main_contact_add.php" style="<?php echo $add;?>">Add | Unassign 
                                <?php
                                    if($total_unassign == 0){}
                                    else
                                    {echo '<span class="badge badge-primary badge-pill">'.$total_unassign.'</span>';}
                                ?>
                            </a>
                        </li>
                        <li>
                            <a href="main_contact_assign.php" style="<?php echo $assign;?>">Assign contact</a>
                        </li>
                    </ul>
                </li> 
                <li class="<?php echo $openspaces;?>">
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-grid <?php echo $ico6; ?>"></i><span class="sidebar-mini-hide">Services</span></a>
                    <ul>
                        <li>
                            <a href="main_add_space.php" style="<?php echo $children_add_space;?>">Space</a>
                        </li>
                        <li>
                            <a href="main_everything.php" style="<?php echo $children_everything;?>">Everything</a>
                        </li>
                        <?php
                        if (empty($_GET['space_name'])) 
                        {
                            $que = mysqli_query($conn,"SELECT space_id FROM space");
                            $res = mysqli_fetch_array($que);
                            $space_id = "";
                            $list_id = "";
                        }
                        else
                        {
                            $space_names = $_GET['space_name'];
                            $que = mysqli_query($conn,"SELECT space_id FROM space WHERE space_name='$space_names'");
                            $res = mysqli_fetch_array($que);
                            $space_id = $res['space_id']; 
                            $list_id = $_GET['list_id'];
                        }

                        $select_space_sort = mysqli_query($conn, "SELECT * FROM space_sort");
                        $count_sort = mysqli_num_rows($select_space_sort);
                        if($count_sort == 0) // check if no sorting in admin
                        {  
                            $findspace = mysqli_query($conn, "SELECT * FROM space ORDER BY space_name ASC"); 
                        }
                        else // if has sorting in admin
                        {
                            $findspace = mysqli_query($conn, "SELECT * FROM space_sort ORDER BY sort_space_order ASC");
                        }
                        
                        while($result_findspace = mysqli_fetch_array($findspace))
                        {
                            if($count_sort == 0) // check if no sorting in admin
                            {  
                                $list_space_id = $result_findspace['space_id'];
                                $space_name = $result_findspace['space_name'];
                            }
                            else
                            {
                                $list_space_id = $result_findspace['sort_space_id'];
                                $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$list_space_id'");
                                $rows = mysqli_fetch_array($select_space);
                                $space_name = $rows['space_name'];
                            }

                            
                            if($list_space_id == $space_id)
                            {?>
                                <li class="open">
                                    <a class="nav-submenu"  href="#" data-toggle="nav-submenu"><?php echo $space_name; ?></a>
                                    <ul>
                                        <?php
                                        $findlist = mysqli_query($conn, "SELECT * FROM list WHERE list_space_id = '$list_space_id' ORDER BY list_name ASC");
                                        while($result_findlist = mysqli_fetch_array($findlist))
                                        {
                                            $reslist_id = $result_findlist['list_id'];
                                            if($reslist_id == $list_id)
                                            {?>
                                                <li>
                                                    <a style="background-color: #20527b; color: #eee; padding-left: 15px; margin-left: -15px;" href="main_dashboard.php?space_name=<?php echo $space_name; ?>&list_name=<?php echo $result_findlist['list_name']; ?>&list_id=<?php echo $result_findlist['list_id']; ?>"><?php echo $result_findlist['list_name']; ?></a>
                                                </li>                                            
                                        <?php 
                                            }   
                                            else
                                            {?>
                                                <li>
                                                    <a href="main_dashboard.php?space_name=<?php echo $space_name; ?>&list_name=<?php echo $result_findlist['list_name']; ?>&list_id=<?php echo $result_findlist['list_id']; ?>"><?php echo $result_findlist['list_name']; ?></a>
                                                </li> 
                                        <?php 
                                            }                                      
                                        }?> 
                                    </ul>
                                </li>
                            <?php 
                            }
                            else
                            {?>
                                <li>
                                    <a class="nav-submenu"  href="#" data-toggle="nav-submenu"><?php echo $space_name; ?></a>
                                    <ul>
                                        <?php
                                            $findlist = mysqli_query($conn, "SELECT * FROM list WHERE list_space_id = '$list_space_id' ORDER BY list_name ASC");
                                            while($result_findlist = mysqli_fetch_array($findlist))
                                        {?> 
                                        <li>
                                            <a href="main_dashboard.php?space_name=<?php echo $space_name; ?>&list_name=<?php echo $result_findlist['list_name']; ?>&list_id=<?php echo $result_findlist['list_id']; ?>"><?php echo $result_findlist['list_name']; ?></a>
                                        </li>                                            
                                        <?php                                        
                                        }?> 
                                    </ul>
                                </li>
                            <?php 
                            }                                       
                        }?>                                    
                    </ul>
                </li>   
<!--                 <li>
                    <a href="#"><i class="si si-calendar"></i><span class="sidebar-mini-hide">Calendar</span></a>
                </li> -->
<!--                 <li>
                    <a href="#"><i class="si si-trash"></i><span class="sidebar-mini-hide">Trash</span></a>
                </li>  -->                           
                <li>
                    <a href="logout.php?logout"><i class="si si-logout"></i><span class="sidebar-mini-hide">Sign Out</span></a>
                </li>                           
            </ul>
        </div>
        <!-- END ADMIN Side Navigation -->
    <?php }
    else
    { ?> 
        <!-- MEMBER Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <?php 
                    $user_id = $row['user_id'];

                    $findcontact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_assign_to = ''");
                    $total_unassign = mysqli_num_rows($findcontact);

                    if($user_type == "Supervisory") // Supervisory
                    { 
                        if($highlight == "main_dashboard.php")
                        {
                            if (empty($_GET['space_name'])) 
                            {
                                $dashboard_style = "background-color: #946401; color: #eee;";
                                $ico1 = "text-white-op";
                            }
                            else
                            {
                                $openspaces = "open";
                                $dashboard_style = "";
                            }
                        }
                        else if($highlight == "main_inbox.php")
                        {
                            $inbox_style = "background-color: #946401; color: #eee;";
                            $ico2 = "text-white-op";
                        }
                        else if($highlight == "main_notification.php")
                        {
                            $notification_style = "background-color: #946401; color: #eee;";
                            $ico3 = "text-white-op";
                        }
                        else if($highlight == "main_people.php")
                        {
                            $people_style = "background-color: #946401; color: #eee;";
                            $ico4 = "text-white-op";
                        }
                        else if($highlight == "main_contact_add.php")
                        {
                            $opencontact = "open"; 
                            $add = "background-color: #946401; color: #eee; padding-left: 15px; margin-left: -15px;";
                            $ico5 = "text-white-op";
                        }
                        else if($highlight == "main_contact_assign.php")
                        {
                            $opencontact = "open"; 
                            $assign = "background-color: #946401; color: #eee; padding-left: 15px; margin-left: -15px;";
                            $ico6 = "text-white-op";
                        }
                        else if($highlight == "main_add_space.php")
                        {
                            $openspaces = "open";
                            $children_add_space = "background-color: #946401; color: #eee; padding-left: 15px; margin-left: -15px;";
                            $ico7 = "text-white-op";
                        }
                        else if($highlight == "main_everything.php")
                        {
                            $openspaces = "open";
                            $children_everything = "background-color: #946401; color: #eee; padding-left: 15px; margin-left: -15px;";
                            $ico8 = "text-white-op";
                        }
                        else
                        {}
                    }
                    else //  Member
                    {
                        if($highlight == "main_dashboard.php")
                        {
                            if (empty($_GET['space_name'])) 
                            {
                                $dashboard_style = "background-color: #1f7575; color: #eee;";
                                $ico1 = "text-white-op";
                            }
                            else
                            {
                                $openspaces = "open";
                                $dashboard_style = "";
                            }
                        }
                        else if($highlight == "main_inbox.php")
                        {
                            $inbox_style = "background-color: #1f7575; color: #eee;";
                            $ico2 = "text-white-op";
                        }
                        else if($highlight == "main_notification.php")
                        {
                            $notification_style = "background-color: #1f7575; color: #eee;";
                            $ico3 = "text-white-op";
                        }
                        else if($highlight == "main_people.php")
                        {
                            $people_style = "background-color: #1f7575; color: #eee;";
                            $ico4 = "text-white-op";
                        }
                        else if($highlight == "main_contact_add.php")
                        {
                            $opencontact = "open"; 
                            $add = "background-color: #1f7575; color: #eee; padding-left: 15px; margin-left: -15px;";
                            $ico5 = "text-white-op";
                        }
                        else if($highlight == "main_contact_assign.php")
                        {
                            $opencontact = "open"; 
                            $assign = "background-color: #1f7575; color: #eee; padding-left: 15px; margin-left: -15px;";
                            $ico6 = "text-white-op";
                        }
                        else if($highlight == "main_add_space.php")
                        {
                            $openspaces = "open";
                            $children_add_space = "background-color: #1f7575; color: #eee; padding-left: 15px; margin-left: -15px;";
                            $ico7 = "text-white-op";
                        }
                        else if($highlight == "main_everything.php")
                        {
                            $openspaces = "open";
                            $children_everything = "background-color: #1f7575; color: #eee; padding-left: 15px; margin-left: -15px;";
                            $ico8 = "text-white-op";
                        }
                        else{}
                    }
                ?>

                <li>
                    <a href="dashboard.php" style="<?php echo $dashboard_style; ?>"><i class="si si-cup <?php echo $ico1; ?>"></i><span class="sidebar-mini-hide">Dashboard</span></a>
                </li>
                <li>
                    <a href="main_inbox.php" style="<?php echo $inbox_style; ?>"><i class="si si-envelope <?php echo $ico2; ?>"></i><span class="sidebar-mini-hide">Inbox </span>
                        <small id="new_message"></small>
                    </a>                        
                </li>
                <li>
                    <a href="main_notification.php" style="<?php echo $notification_style; ?>"><i class="si si-bell <?php echo $ico3; ?>"></i><span class="sidebar-mini-hide">Notification</span></a>
                </li>
                <li class="<?php echo $opencontact;?>">
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="fa fa-address-book-o"></i><span class="sidebar-mini-hide">Contact</span>
                        <?php
                            if($total_unassign == 0){}
                            else
                            {echo '<span class="badge badge-primary badge-pill">'.$total_unassign.'</span>';}
                        ?>
                    </a>
                    <ul>
                        <li>
                            
                            <a href="main_contact_add.php" style="<?php echo $add;?>">Add | Unassign 
                                <?php
                                    if($total_unassign == 0){}
                                    else
                                    {echo '<span class="badge badge-primary badge-pill">'.$total_unassign.'</span>';}
                                ?>
                            </a>
                        </li>
                        <li>
                            <a href="main_contact_assign.php" style="<?php echo $assign;?>">Assign contact</a>
                        </li>
                    </ul>
                </li> 
                <li class="<?php echo $openspaces;?>">
                    <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-grid"></i><span class="sidebar-mini-hide">Services</span></a>
                    <ul>
                        <li>
                            <a href="main_everything.php" style="<?php echo $children_everything;?>">Everything</a>
                        </li>
                        <?php
                        if (empty($_GET['space_name'])) 
                        {
                            $que = mysqli_query($conn,"SELECT space_id FROM space");
                            $res = mysqli_fetch_array($que);
                            $space_id = "";
                            $list_id = "";
                        }
                        else
                        {
                            $space_names = $_GET['space_name'];
                            $que = mysqli_query($conn,"SELECT space_id FROM space WHERE space_name='$space_names'");
                            $res = mysqli_fetch_array($que);
                            $space_id = $res['space_id']; 
                            $list_id = $_GET['list_id'];
                        }

                        $select_space_sort = mysqli_query($conn, "SELECT * FROM space_sort");
                        $count_sort = mysqli_num_rows($select_space_sort);
                        if($count_sort == 0) // check if no sorting in admin
                        {  
                            $findspace = mysqli_query($conn, "SELECT * FROM space WHERE space_type='IPASS Processing Workspace' ORDER BY space_name ASC");
                        }
                        else // if has sorting in admin
                        {
                            //$findspace = mysqli_query($conn, "SELECT * FROM space_sort ORDER BY sort_space_order ASC");
                            $findspace = mysqli_query($conn, "SELECT * FROM space left join space_sort on space.space_id = space_sort.sort_space_id WHERE space_type='IPASS Processing Workspace' ORDER BY sort_space_order ASC");
                        }
                        while($result_findspace = mysqli_fetch_array($findspace))
                        {
                            if($count_sort == 0) // check if no sorting in admin
                            {  
                                $list_space_id = $result_findspace['space_id'];
                                $space_name = $result_findspace['space_name'];
                            }
                            else
                            {
                                $list_space_id = $result_findspace['sort_space_id'];
                                $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_type='IPASS Processing Workspace' and space_id = '$list_space_id'");
                                $rows = mysqli_fetch_array($select_space);
                                $space_name = $rows['space_name'];
                            }

                            if($list_space_id == $space_id)
                            {?>
                                <li class="open">
                                    <a class="nav-submenu"  href="#" data-toggle="nav-submenu"><?php echo $space_name; ?></a>
                                    <ul>
                                        <?php
                                        $findlist = mysqli_query($conn, "SELECT * FROM list WHERE list_space_id = '$list_space_id' ORDER BY list_name ASC");
                                        while($result_findlist = mysqli_fetch_array($findlist))
                                        {
                                            $reslist_id = $result_findlist['list_id'];
                                            if($reslist_id == $list_id)
                                            {
                                                if($user_type == "Supervisory") { $bg = "background-color: #946401; color: #eee;"; }
                                                else { $bg = "background-color: #1f7575; color: #eee;"; }
                                                ?>
                                                <li>
                                                    <a style="<?php echo $bg; ?>; padding-left: 15px; margin-left: -15px;" href="main_dashboard.php?space_name=<?php echo $space_name; ?>&list_name=<?php echo $result_findlist['list_name']; ?>&list_id=<?php echo $result_findlist['list_id']; ?>"><?php echo $result_findlist['list_name']; ?></a>
                                                </li>                                            
                                        <?php 
                                            }   
                                            else
                                            {?>
                                                <li>
                                                    <a href="main_dashboard.php?space_name=<?php echo $space_name; ?>&list_name=<?php echo $result_findlist['list_name']; ?>&list_id=<?php echo $result_findlist['list_id']; ?>"><?php echo $result_findlist['list_name']; ?></a>
                                                </li> 
                                        <?php 
                                            }                                      
                                        }?> 
                                    </ul>
                                </li>
                            <?php 
                            }
                            else
                            {?>
                                <li>
                                    <a class="nav-submenu"  href="#" data-toggle="nav-submenu"><?php echo $space_name; ?></a>
                                    <ul>
                                        <?php
                                            $findlist = mysqli_query($conn, "SELECT * FROM list WHERE list_space_id = '$list_space_id' ORDER BY list_name ASC");
                                            while($result_findlist = mysqli_fetch_array($findlist))
                                        {?> 
                                        <li>
                                            <a href="main_dashboard.php?space_name=<?php echo $space_name; ?>&list_name=<?php echo $result_findlist['list_name']; ?>&list_id=<?php echo $result_findlist['list_id']; ?>"><?php echo $result_findlist['list_name']; ?></a>
                                        </li>                                            
                                        <?php                                        
                                        }?> 
                                    </ul>
                                </li>
                            <?php 
                            }                                       
                        }?>                                    
                    </ul>
                </li>   
                <!-- <li>
                    <a href="#"><i class="si si-calendar"></i><span class="sidebar-mini-hide">Calendar</span></a>
                </li>   -->                        
                <li>
                    <a href="logout.php?logout"><i class="si si-logout"></i><span class="sidebar-mini-hide">Sign Out</span></a>
                </li>                       
            </ul>
        </div>
        <!-- END MEMBER Side Navigation -->
    <?php }
?>
    </div>
    <!-- Sidebar Content -->
</nav>
<!-- END Sidebar -->

<script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //display_new_message();
        // Display new message -------------------------------
        var user_id = <?php echo $user_id ?>;
        $.ajax({
            url: 'fetch_contact.php',
            type: 'POST', 
            async: false,
            data:{
                user_id:user_id,
                menu_new_message: 1,
            },
                success: function(response){
                    $('#new_message').html(response);
                    $("#new_message").scrollTop($("#new_message")[0].scrollHeight);
                }
        });

        /*function display_new_message(){
            
        }setInterval (display_new_message, 1000);
        // END display new message -------------------------------
    });

    // Change mode -------------------------------
    function mode()
    {
        user_id = <?php echo $user_id; ?>;
        $.ajax({
            type: "POST",
            url: "ajax.php",
            data: {
                user_id:user_id,
                change_mode: 1,
            },
            success: function(data){
                if(data == "Dark") { alert("Dark Mode."); }
                else if(data == "Custom") { alert("Custom Mode."); }
                else { alert("White Mode."); }
                location.reload();
            }
        });
    }
    // END Change mode -------------------------------
    
    // Toogle the color theme
    /*window.onload=function(){
        mode_type = "<?php echo $mode_type ?>";
        if(mode_type == "Dark")
        {
            document.getElementById('btn_dark').click();
        }
        else
        {
            document.getElementById('btn_white').click();
        }
    };*/
</script>