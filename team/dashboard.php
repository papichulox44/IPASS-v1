<?php include ("session.php"); ?> 
<!doctype html>
<html lang="en" class="no-focus">
    <?php include 'head.php'; ?>
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
    <style type="text/css">
        .filterchild{
            display: none;
        }
        .filterparent
        {
          cursor: pointer;
        }
        .filterparent:hover .filterchild {
            display: block;
        }
        .hov_row:hover{
            cursor: pointer;
        }
    </style>
    <body class="<?php echo $body; ?>">
        <div id="page-container" class="sidebar-o <?php echo $inverse; ?> enable-page-overlay side-scroll page-header-glass page-header-inverse">
            <?php 
                $highlight = "main_dashboard.php";
                include 'left_sidebar_menu.php';
            ?>
            <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="content-header-section">
                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                            <i class="fa fa-navicon"></i>
                        </button>
                        <!-- END Toggle Sidebar -->
                    </div>
                    <!-- END Left Section -->
                </div>
                <!-- END Header Content -->
            </header>
            <!-- END Header --> 
            <?php include 'content_home_dashboard.php'; ?> 
        </div>
        <!-- END Page Container -->
        <!-- <script>(function(d,t,u,s,e){e=d.getElementsByTagName(t)[0];s=d.createElement(t);s.src=u;s.async=1;e.parentNode.insertBefore(s,e);})(document,'script','//localhost/livechat/php/app.php?widget-init.js');</script> -->
        <!-- <script async src="//static.zotabox.com/a/3/a33969f630ec552131efd6c2dec61b27/widgets.js"></script> -->
        <!-- <script async src="//static.zotabox.com/e/b/eb26987429915b2f833da87153511859/widgets.js"></script> -->

        <script src="../assets/js/codebase.core.min.js"></script>
        <script src="../assets/js/codebase.app.min.js"></script>        
        <!-- Page JS Plugins -->
        <script src="../assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page JS Code -->
        <script src="../assets/js/pages/be_tables_datatables.min.js"></script>
                <!-- Page JS Plugins -->
        <script src="../assets/js/plugins/chartjs/Chart.bundle.min.js"></script>
        <script src="../assets/js/plugins/slick/slick.min.js"></script>

        <!-- Page JS Code -->
        <script src="../assets/js/pages/be_pages_dashboard.min.js"></script>
        <script src="../assets/js/pages/db_dark.min.js"></script>
    </body>
</html>