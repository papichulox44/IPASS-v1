<?php include ("session.php"); ?>
<!doctype html>
<html lang="en" class="no-focus">
    <?php include 'head.php'; ?>
    <body class="<?php echo $body; ?>">
        <div id="page-container" class="sidebar-o <?php echo $inverse; ?> enable-page-overlay side-scroll">
            <?php
                $highlight = "main_people.php";
                include 'left_sidebar_menu.php';
            ?>
            <?php include 'header.php'; ?>
            <?php include 'content_people.php'; ?>
        </div>
        <!-- Extra Large Modal -->
        <div class="modal fade" id="modal-summary-report" tabindex="-1" role="dialog" aria-labelledby="modal-extra-large" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Summary Report</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                          <select class="form-control" id="myDepartment" onchange="select_department()">
                            <option disabled selected>Select Department Summary</option>
                            <?php
                            $query_summary = mysqli_query($conn, "SELECT department FROM user WHERE department IS NOT NULL GROUP BY user.department") or die(mysqli_error());
                            while($data_summary = mysqli_fetch_array($query_summary)){
                              echo '
                              <option value="'.$data_summary['department'].'">'.$data_summary['department'].'</option>
                              ';
                            }
                             ?>
                          </select>
                          <div id="show_summary_report"></div>
                        </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <!-- END Extra Large Modal -->
        <!-- END Page Container -->
        <script>
          function select_department() {
            var x = document.getElementById("myDepartment").value;
            alert(x);
          }
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
