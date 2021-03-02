<?php include ("session.php"); ?> 
<!doctype html>
<html lang="en" class="no-focus">
    <?php include 'head.php'; ?>
    <style type="text/css">
        .loader-wrapper {
          width: 100%;
          height: 100%;
          position: absolute;
          top: 0;
          left: 0;
          background-color: #242f3f;
          display:flex;
          justify-content: center;
          align-items: center;
        }
        .loader {
          display: inline-block;
          width: 50px;
          height: auto;
          position: relative;
          animation: loader 2s infinite ease;
        }
        .loader-inner {
          vertical-align: top;
          display: inline-block;
          width: 100%;
          background-color: #fff;
          animation: loader-inner 2s infinite ease-in;
        }
        @keyframes loader {
          0% { transform: rotate(0deg);}
          25% { transform: rotate(180deg);}
          50% { transform: rotate(180deg);}
          75% { transform: rotate(360deg);}
          100% { transform: rotate(360deg);}
        }
        @keyframes loader-inner {
          0% { height: 0%;}
          25% { height: 0%;}
          50% { height: 100%;}
          75% { height: 100%;}
          100% { height: 0%;}
        }
    </style>
    <body class="<?php echo $body; ?>">
        <div class="loader-wrapper">
          <img src="../assets/media/photos/logo-ipass.png" class="loader">
        </div>
        <!--<div id="page-container" class="sidebar-o sidebar-inverse enable-page-overlay side-scroll page-header-modern main-content-boxed">-->
        <div id="page-container" class="sidebar-o <?php echo $inverse; ?> enable-page-overlay side-scroll">
            <?php 
                $highlight = "main_notification.php";
                include 'left_sidebar_menu.php';
            ?>
            <?php include 'header.php'; ?>  
            <?php include 'content_notification.php'; ?> 
        </div>
        <!-- END Page Container -->

        <script>
        $(window).on("load",function(){
          $(".loader-wrapper").fadeOut('slow');
        });
        </script>

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
    </body>
</html>