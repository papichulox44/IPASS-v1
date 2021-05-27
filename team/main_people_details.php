<?php include ("session.php");
if ($_SESSION['user_type'] == 'Admin') {
} else{
  echo '
  <script>
    alert("Your not allowed to access this file!!");
    window.location.href = "./logout.php?logout";
  </script>
  ';
}
?>
<!doctype html>
<html lang="en" class="no-focus">
    <?php include 'head.php'; ?>
    <body class="<?php echo $body; ?>">
        <!--<div id="page-container" class="sidebar-o sidebar-inverse enable-page-overlay side-scroll page-header-modern main-content-boxed">-->
        <div id="page-container" class="sidebar-o <?php echo $inverse; ?> enable-page-overlay side-scroll">
            <?php
                $highlight = "";
                include 'left_sidebar_menu.php';
            ?>
            <?php include 'header.php'; ?>
            <?php include 'content_people_details.php'; ?>
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
    </body>
</html>
