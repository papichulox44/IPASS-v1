<?php include ("session.php"); ?> 
<!doctype html>
<html lang="en" class="no-focus">
    <?php include 'head.php'; ?>
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="../assets/js/plugins/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="../assets/js/plugins/simplemde/simplemde.min.css">
    <link rel="stylesheet" href="../assets/js/plugins/datatables/dataTables.bootstrap4.css">
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
        <div id="page-container" class="sidebar-o <?php echo $inverse; ?> enable-page-overlay side-scroll">
            <?php 
                $highlight = "email_blasting.php";
                include 'left_sidebar_menu.php';
            ?>
            <?php include 'header.php'; ?>
            <?php include 'email_blasting_content.php'; ?>
        </div>        
        <!-- END Page Container -->

        <script src="../assets/js/codebase.core.min.js"></script>
        <script src="../assets/js/codebase.app.min.js"></script>

        <!-- Page JS Plugins -->
        <script src="../assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page JS Code -->
        <script src="../assets/js/pages/be_tables_datatables.min.js"></script>
        
        <!-- Page JS Plugins -->
        <script src="../assets/js/plugins/summernote/summernote-bs4.min.js"></script>
        <script src="../assets/js/plugins/ckeditor/ckeditor.js"></script>
        <script src="../assets/js/plugins/simplemde/simplemde.min.js"></script>

        <!-- Page JS Helpers (Summernote + CKEditor + SimpleMDE plugins) -->
        <script>jQuery(function(){ Codebase.helpers(['summernote', 'ckeditor', 'simplemde']); });</script>

        
        <!-- Page JS Plugins -->
        <script src="../assets/js/plugins/jquery-slimscroll/jquery.slimscroll.min.js"></script>

        <!-- Page JS Helpers (SlimScroll plugin) -->
        <script>jQuery(function(){ Codebase.helpers(['slimscroll']); });</script>
        <!-- Page JS Code -->
        <script src="../assets/js/pages/be_pages_generic_scrumboard.min.js"></script>
    </body>
</html>