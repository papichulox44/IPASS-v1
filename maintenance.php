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
                                        <h1 class="display-4 font-w700 text-white mb-10">We’ll be back soon!</h1>
                                        <h2 class="h4 font-w400 text-white-op pb-30 mb-20 border-white-op-b">Down for maintenance, working on it!</h2>

                                        <!-- Countdown.js functionality is initialized with .js-countdown class in js/pages/op_coming_soon.min.js which was auto compiled from _es6/pages/op_coming_soon.js -->
                                        <!-- For more info and examples you can check out https://github.com/hilios/jQuery.countdown -->
                                        <!--<div class="js-countdown mb-20"></div>-->
                                        <div class="row items-push text-center">
                                           <div class="col-6 col-sm-3">
                                              <div class="font-size-h1 font-w700 text-white"><span id="ddd"></span></div>
                                              <div class="font-size-xs font-w700 text-white-op">DAYS</div>
                                           </div>
                                           <div class="col-6 col-sm-3">
                                              <div class="font-size-h1 font-w700 text-white"><span id="hhh"></span></div>
                                              <div class="font-size-xs font-w700 text-white-op">HOURS</div>
                                           </div>
                                           <div class="col-6 col-sm-3">
                                              <div class="font-size-h1 font-w700 text-white"><span id="mmm"></span></div>
                                              <div class="font-size-xs font-w700 text-white-op">MINUTES</div>
                                           </div>
                                           <div class="col-6 col-sm-3">
                                              <div class="font-size-h1 font-w700 text-white"><span id="sss"></span></div>
                                              <div class="font-size-xs font-w700 text-white-op">SECONDS</div>
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
    // Set the date we're counting down to
    var countDownDate = new Date("07 16, 2022 15:32:00").getTime();
    // Update the count down every 1 second
    var x = setInterval(function()
        {                                            
            // Get today's date and time
            var now = new Date().getTime();
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
                                            
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                                            
            // Display the result in the element with id="demo"
            document.getElementById("ddd").innerHTML = days;
            document.getElementById("hhh").innerHTML = hours;
            document.getElementById("mmm").innerHTML = minutes;
            document.getElementById("sss").innerHTML = seconds;
                                            
            // If the count down is finished, write some text 
            if (distance < 0)
            {
                document.getElementById("ddd").innerHTML = '0';
                document.getElementById("hhh").innerHTML = '0';
                document.getElementById("mmm").innerHTML = '0';
                document.getElementById("sss").innerHTML = '0';
                location.replace("http://localhost/IPASS/index.php")
            }
        }, 1000);
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