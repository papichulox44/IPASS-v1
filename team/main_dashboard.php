<?php include ("session.php"); ?> 
<!doctype html>
<html lang="en" class="no-focus">
    <?php include 'head.php'; ?>
    <link rel="stylesheet" href="../assets/js/plugins/magnific-popup/magnific-popup.css">
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
          width: 30px;
          height: 30px;
          position: relative;
          border: 4px solid #Fff;
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
          <span class="loader"><span class="loader-inner"></span></span>
        </div>
        <!--<div id="page-container" class="sidebar-o sidebar-inverse enable-page-overlay side-scroll page-header-modern main-content-boxed">-->
        <!--<div id="page-container" class="sidebar-o sidebar-inverse enable-page-overlay side-scroll">-->
        <div id="page-container" class="sidebar-mini sidebar-o <?php echo $inverse; ?>">
            <?php 
                $highlight = "main_dashboard.php";
                include 'left_sidebar_menu.php';
            ?>
            <?php include 'header.php'; ?>  
            <?php include 'content_dashboard.php'; ?> 
        </div>
        <!-- END Page Container -->
        <script>
        $(window).on("load",function(){
          $(".loader-wrapper").fadeOut("slow");
        });
        </script>
        <script src="../assets/js/codebase.core.min.js"></script>
        <script src="../assets/js/codebase.app.min.js"></script>
        <script>jQuery(function () {
            Codebase.helpers('table-tools');
        });</script>
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

        <script src="../assets/js/plugins/easy-pie-chart/jquery.easypiechart.min.js"></script>
        <script>jQuery(function(){ Codebase.helpers('easy-pie-chart'); });</script>

        <!-- Page JS Plugins -->
        <script src="../assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>

        <!-- Page JS Helpers (Magnific Popup plugin) -->
        <script>jQuery(function(){ Codebase.helpers('magnific-popup'); });</script>
    </body>
</html>