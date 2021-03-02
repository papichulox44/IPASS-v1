<?php include ("session.php"); ?> 
<!doctype html>
<html lang="en" class="no-focus">
    <?php include 'head.php'; ?>
    <body class="<?php echo $body; ?>">
        <div id="page-container" class="sidebar-o <?php echo $inverse; ?> enable-page-overlay side-scroll">
            <?php 
                $highlight = "main_inbox.php";
                include 'left_sidebar_menu.php';
            ?>
            <?php include 'header.php'; ?>
            <?php include 'content_inbox.php'; ?>
        </div>        
        <!-- END Page Container -->
        
        <script src="../assets/js/codebase.core.min.js"></script>
        <script src="../assets/js/codebase.app.min.js"></script>

        <!-- Page JS Plugins -->
        <script src="../assets/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Page JS Helpers (SlimScroll plugin) -->
        <script>jQuery(function(){ Codebase.helpers(['slimscroll']); });</script>
    </body>
</html>