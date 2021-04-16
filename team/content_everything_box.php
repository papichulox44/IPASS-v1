<?php
    $md_primary_darker = "";
    $md_text = "text-muted";
    $md_body = "";
    if($mode_type == "Dark") //insert
    {
        $md_primary_darker = "bg-primary-darker";
        $md_text = "text-white";
        $md_body = "bg-gray-darker text-body-color-light";
    }
?>
<!-- tab that fucos when page refresh -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<style>
    a{color:#575757;text-decoration:none}
    .bs-example li:hover {background-color: #fff;color: #3f9ce8;}
    .bs-example li.active {color: #fff;background-color: #abadaf;}
    .nav{padding-left:0;margin-bottom:0;list-style:none; background-color: #dedede;}
    .nav>li>a{position:relative;display:block;padding: 14px 16px;transition: 0.3s;font-size: 17px;}
    .bs-example a.active {
        color: #fff;
        background-color: #abadaf;
    }
    .tab-content {
      padding: 6px 12px;
      border-top: none;
    }
</style>
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
<div class="bs-example">
    <ul class="nav nav-tabs" id="myTab">
        <li><a data-toggle="tab" href="#sectionC">Box</a></li>
    </ul>
    <div class="tab-content">
        <!-- END List View -->
        <!-- Box -->
        <div id="sectionC" class="tab-pane fade">
            <?php include("view_box_everything.php"); ?>
        </div>
        <!-- End Box -->
    </div>
</div>
<script src="../assets/js/jquery.min.js"></script>
<script>
    $(document).ready(function(){
      $('a[data-toggle="tab"]').on('show.bs.tab', function(e)
      {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
      });
      var activeTab = localStorage.getItem('activeTab');
      if(activeTab)
      {
        $('#myTab a[href="' + activeTab + '"]').tab('show');
      }
    });
</script>
<script>
    function openCity(evt, cityName) {
      var i, tabcontent, tablinks;
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
      }
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
      }
      document.getElementById(cityName).style.display = "block";
      evt.currentTarget.className += " active";
    }
    // Get the element with id="active_tab" and click on it
    //document.getElementById("active_tab").click();
        function tran_all()
        {
            due_date = '<?php echo $_GET['due_date']; ?>';
            if (due_date == 'Custom Date')
            {
                due_date_custom = '<?php echo $_GET['due_date']; ?>&From_due=<?php if(isset($_GET['From_due'])) { echo $_GET['From_due']; } ?>&To_due=<?php if(isset($_GET['To_due'])) { echo $_GET['To_due']; } ?>';
            }
            else
            {
                due_date_custom = due_date;
            }
            document.location='main_everything.php?filter=All&due_date='+due_date_custom;
        }
        function tran_today()
        {
            due_date = '<?php echo $_GET['due_date']; ?>';
            if (due_date == 'Custom Date')
            {
                due_date_custom = '<?php echo $_GET['due_date']; ?>&From_due=<?php if(isset($_GET['From_due'])) { echo $_GET['From_due']; } ?>&To_due=<?php if(isset($_GET['To_due'])) { echo $_GET['To_due']; } ?>';
            }
            else
            {
                due_date_custom = due_date;
            }
            document.location='main_everything.php?filter=Today&due_date='+due_date_custom;
        }
        function tran_week()
        {
            due_date = '<?php echo $_GET['due_date']; ?>';
            if (due_date == 'Custom Date')
            {
                due_date_custom = '<?php echo $_GET['due_date']; ?>&From_due=<?php if(isset($_GET['From_due'])) { echo $_GET['From_due']; } ?>&To_due=<?php if(isset($_GET['To_due'])) { echo $_GET['To_due']; } ?>';
            }
            else
            {
                due_date_custom = due_date;
            }
            document.location='main_everything.php?filter=This Week&due_date='+due_date_custom;
        }
        function tran_month()
        {
            due_date = '<?php echo $_GET['due_date']; ?>';
            if (due_date == 'Custom Date')
            {
                due_date_custom = '<?php echo $_GET['due_date']; ?>&From_due=<?php if(isset($_GET['From_due'])) { echo $_GET['From_due']; } ?>&To_due=<?php if(isset($_GET['To_due'])) { echo $_GET['To_due']; } ?>';
            }
            else
            {
                due_date_custom = due_date;
            }
            document.location='main_everything.php?filter=This Month&due_date='+due_date_custom;
        }
        function tran_year()
        {
            due_date = '<?php echo $_GET['due_date']; ?>';
            if (due_date == 'Custom Date')
            {
                due_date_custom = '<?php echo $_GET['due_date']; ?>&From_due=<?php if(isset($_GET['From_due'])) { echo $_GET['From_due']; } ?>&To_due=<?php if(isset($_GET['To_due'])) { echo $_GET['To_due']; } ?>';
            }
            else
            {
                due_date_custom = due_date;
            }
            document.location='main_everything.php?filter=This Year&due_date='+due_date_custom;
            // document.location='main_everything.php?filter=This Year&due_date=<?php echo $_GET['due_date']; ?>';
        }
        function tran_custom()
        {
            var date_from = document.getElementById('txt_date_from').value;
            var date_to = document.getElementById('txt_date_to').value;
            due_date = '<?php echo $_GET['due_date']; ?>';
            if (due_date == 'Custom Date')
            {
                due_date_custom = '<?php echo $_GET['due_date']; ?>&From_due=<?php if(isset($_GET['From_due'])) { echo $_GET['From_due']; } ?>&To_due=<?php if(isset($_GET['To_due'])) { echo $_GET['To_due']; } ?>';
            }
            else
            {
                due_date_custom = due_date;
            }

            if(date_from == "")
            {
              alert("Please select date range from.");
            }
            else if(date_to == "")
            {
              alert("Please select date range to.");
            }
            else
            {

              document.location='main_everything.php?filter=Custom Date&From='+date_from+'&To='+date_to+'&due_date='+due_date_custom;
            }
        }

        function tran_all_due_date()
        {
            filter = '<?php echo $_GET['filter']; ?>';
            if (filter == 'Custom Date')
            {
                created_date_custom = '<?php echo $_GET['filter']; ?>&From=<?php if(isset($_GET['From'])) { echo $_GET['From']; } ?>&To=<?php if(isset($_GET['To'])) { echo $_GET['To']; } ?>';
            }
            else
            {
                created_date_custom = filter;
            }
            document.location='main_everything.php?filter='+created_date_custom+'&due_date=All';
        }
        function tran_today_due_date()
        {
            filter = '<?php echo $_GET['filter']; ?>';
            if (filter == 'Custom Date')
            {
                created_date_custom = '<?php echo $_GET['filter']; ?>&From=<?php if(isset($_GET['From'])) { echo $_GET['From']; } ?>&To=<?php if(isset($_GET['To'])) { echo $_GET['To']; } ?>';
            }
            else
            {
                created_date_custom = filter;
            }
            document.location='main_everything.php?filter='+created_date_custom+'&due_date=Today';
        }
        function tran_week_due_date()
        {
            filter = '<?php echo $_GET['filter']; ?>';
            if (filter == 'Custom Date')
            {
                created_date_custom = '<?php echo $_GET['filter']; ?>&From=<?php if(isset($_GET['From'])) { echo $_GET['From']; } ?>&To=<?php if(isset($_GET['To'])) { echo $_GET['To']; } ?>';
            }
            else
            {
                created_date_custom = filter;
            }
            document.location='main_everything.php?filter='+created_date_custom+'&due_date=This Week';
        }
        function tran_month_due_date()
        {
            filter = '<?php echo $_GET['filter']; ?>';
            if (filter == 'Custom Date')
            {
                created_date_custom = '<?php echo $_GET['filter']; ?>&From=<?php if(isset($_GET['From'])) { echo $_GET['From']; } ?>&To=<?php if(isset($_GET['To'])) { echo $_GET['To']; } ?>';
            }
            else
            {
                created_date_custom = filter;
            }
            document.location='main_everything.php?filter='+created_date_custom+'&due_date=This Month';
            document.location='main_everything.php?filter=<?php echo $_GET['filter']; ?>&due_date=This Month';
        }
        function tran_year_due_date()
        {
            document.location='main_everything.php?filter=<?php echo $_GET['filter']; ?>&due_date=This Year';
        }
        function tran_custom_due_date()
        {
            var date_from_due = document.getElementById('txt_date_from_due_date').value;
            var date_to_due = document.getElementById('txt_date_from_due_date').value;
            filter = '<?php echo $_GET['filter']; ?>';
            if (filter == 'Custom Date')
            {
                created_date_custom = '<?php echo $_GET['filter']; ?>&From=<?php if(isset($_GET['From'])) { echo $_GET['From']; } ?>&To=<?php if(isset($_GET['To'])) { echo $_GET['To']; } ?>';
            }
            else
            {
                created_date_custom = filter;
            }

            if(date_from_due == "")
            {
              alert("Please select date range from.");
            }
            else if(date_to_due == "")
            {
              alert("Please select date range to.");
            }
            else
            {

              document.location='main_everything.php?filter='+created_date_custom+'&due_date=Custom Date&From_due='+date_from_due+'&To_due='+date_to_due;
            }
        }


        function tran_custom_box()
        {
            var date_from = document.getElementById('date_from').value;
            var date_to = document.getElementById('date_to').value;
            if(date_from == "")
            {
              alert("Please select date range from.");
            }
            else if(date_to == "")
            {
              alert("Please select date range to.");
            }
            else
            {

              document.location='main_everything.php?filter=Custom Date&From='+date_from+'&To='+date_to;
            }
        }
</script>
