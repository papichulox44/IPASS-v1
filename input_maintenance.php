<html lang="en" class="no-focus">
    <?php include_once 'head.php';?>
    <body>
        <div id="page-container" class="main-content-boxed">

            <!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                <div class="bg-image" style="background-image: url('assets/media/photos/cleint_bg.jpg');">
                    <div class="hero bg-black-op">
                        <div class="hero-inner">
                            <div class="content content-full">
                                <div class="row justify-content-center">
                                    <div class="col-md-6 py-30 text-center">
                                        <h2 class="h4 font-w400 text-white-op pb-30 mb-20 border-white-op-b">Input maintenance duration!</h2>

                                        <!-- Countdown.js functionality is initialized with .js-countdown class in js/pages/op_coming_soon.min.js which was auto compiled from _es6/pages/op_coming_soon.js -->
                                        <!-- For more info and examples you can check out https://github.com/hilios/jQuery.countdown -->
                                        <!--<div class="js-countdown mb-20"></div>-->
                                        <div class="row items-push text-center">
                                           <div class="col-4 col-sm-4">
                                              <div class="font-size-h1 font-w700 text-white">
                                                  <input type="date" class="form-control" id="txt_date">
                                              </div>
                                              <div class="font-size-xs font-w700 text-white-op mt-10">DAYS</div>
                                           </div>
                                           <div class="col-4 col-sm-4">
                                              <div class="font-size-h1 font-w700 text-white">
                                                  <?php 
                                                      function get_times_array( $default = '19:00', $interval = '+30 minutes' )
                                                      {
                                                          $output = '';
                                                          $current = strtotime( '00:00' );
                                                          $end = strtotime( '23:59' );

                                                          while( $current <= $end ) {
                                                              $time = date( 'H:i:s', $current );
                                                              $sel = ( $time == $default ) ? '' : '';
                                                              //$sel = ( $time == $default ) ? ' selected' : '';   // 7:00 pm         

                                                              $output .= "<option value=\"{$time}\"{$sel}>" . date( 'h.i A', $current ) .'</option>';
                                                              $current = strtotime( $interval, $current );
                                                          }
                                                          return $output;
                                                      }
                                                  ?>
                                                  <select class="form-control" id="txt_time">
                                                      <option>...</option>
                                                      <?php echo get_times_array(); ?>
                                                  </select>
                                              </div>
                                              <div class="font-size-xs font-w700 text-white-op mt-10">TIME</div>
                                           </div>
                                           <div class="col-4 col-sm-4">
                                              <div class="font-size-h1 font-w700 text-white">
                                                  <button type="button" class="btn btn-primary btn-block" onclick="save_time()">Save</button>
                                              </div>
                                              <div class="font-size-xs font-w700 text-white-op mt-10">OPTION</div>
                                           </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->

            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->
    </body>
</html>
<script type="text/javascript">
    var currentdate = new Date(); 
    var datetime = currentdate.getFullYear() + "-"
            + (currentdate.getMonth()+1)  + "-" 
            + currentdate.getDate() + " "  
            + currentdate.getHours() + ":"  
            + currentdate.getMinutes() + ":" 
            + currentdate.getSeconds();
    alert(datetime); // 2020-7-15 16:36:15*/
    function save_time()
    {
        date = document.getElementById('txt_date').value; // 2020-07-01
        time = document.getElementById("txt_time");
        if(date == "")
        {
            alert('Please select date!');
        }
        else if(time.selectedIndex == 0)
        {
             alert('Please select time.');
        }
        else
        {           
            set_date_time = date + ' ' + time.value; // 2020-07-15 17:00:00
            alert(set_date_time);
        }
    }
</script>
<script src="assets/js/codebase.core.min.js"></script>

<!--
Codebase JS

Custom functionality including Blocks/Layout API as well as other vital and optional helpers
webpack is putting everything together at assets/_es6/main/app.js
-->
<script src="assets/js/codebase.app.min.js"></script>

<!-- Page JS Plugins -->
<script src="assets/js/plugins/jquery-countdown/jquery.countdown.min.js"></script>

<!-- Page JS Code -->
<script src="assets/js/pages/op_coming_soon.min.js"></script>