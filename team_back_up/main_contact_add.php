<?php include ("session.php"); ?> 
<!doctype html>
<html lang="en" class="no-focus">
    <link rel="stylesheet" href="../assets/js/plugins/select2/css/select2.min.css">
    <?php include 'head.php'; ?>
    <body class="<?php echo $body; ?>">
        <!--<div id="page-container" class="sidebar-o sidebar-inverse enable-page-overlay side-scroll page-header-modern main-content-boxed">-->
        <div id="page-container" class="sidebar-o <?php echo $inverse; ?> enable-page-overlay side-scroll">
            <?php 
                $highlight = "main_contact_add.php";
                include 'left_sidebar_menu.php';
            ?>
            <?php include 'header.php'; ?>  
            <?php include 'content_contact_add.php'; ?> 
        </div>
        <!-- END Page Container -->

        <script src="../assets/js/codebase.core.min.js"></script>
        <script src="../assets/js/codebase.app.min.js"></script>

        <!-- Page JS Plugins -->
        <script src="../assets/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>

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


        <!-- Page JS Code -->
        <script src="../assets/js/plugins/select2/js/select2.full.min.js"></script>
        <script src="../assets/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js"></script>
        <script>jQuery(function(){ Codebase.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']); });</script>
    </body>
</html>