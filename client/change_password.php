<?php include ("session.php"); ?> 
<!doctype html>
<html lang="en" class="no-focus">
    <?php include 'head.php'; ?>
    <body style="background-color: #eeeeee;">
        <!--<div id="page-container" class="sidebar-o sidebar-inverse enable-page-overlay side-scroll page-header-modern main-content-boxed">-->
        <div id="page-container" class="sidebar-o sidebar-inverse enable-page-overlay side-scroll">
            <?php 
                $highlight = "change_password.php";
                include 'left_sidebar_menu.php';
            ?>
            <?php include 'header.php'; ?>  
            <?php include 'change_password_content.php'; ?> 
        </div>
        <!-- END Page Container -->

        <script src="../assets/js/codebase.core.min.js"></script>
        <script src="../assets/js/codebase.app.min.js"></script>

        <!-- Page JS Plugins -->
        <script src="../assets/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>
        <!-- <script async src="//static.zotabox.com/a/3/a33969f630ec552131efd6c2dec61b27/widgets.js"></script> -->
        <!-- Page JS Helpers (SlimScroll plugin) -->
        <script>jQuery(function(){ Codebase.helpers(['slimscroll']); });</script>

        <!-- Page JS Plugins -->
        <script src="../assets/js/plugins/jquery-ui/jquery-ui.min.js"></script>
        <script src="../assets/js/plugins/jquery-ui/jquery.ui.touch-punch.min.js"></script>

           
        <!-- Page JS Code -->
        <script src="../assets/js/pages/be_pages_generic_scrumboard.min.js"></script>

        <!-- Page JS Plugins -->
        <script src="../assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page JS Code -->
        <script src="../assets/js/pages/be_tables_datatables.min.js"></script>
    </body>
</html>