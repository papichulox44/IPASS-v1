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
        <li><a data-toggle="tab" href="#sectionA">List</a></li>
        <li><a data-toggle="tab" href="#sectionC">Box</a></li>
    </ul>
    <div class="tab-content">
        <!-- List View -->
        <div id="sectionA" class="tab-pane fade in">
            <?php include("view_list_everything.php"); ?>
        </div>
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
            document.location='main_everything.php?filter=All';
        }
        function tran_today()
        {
            document.location='main_everything.php?filter=Today';
        }
        function tran_week()
        {
            document.location='main_everything.php?filter=This Week';
        }
        function tran_month()
        {
            document.location='main_everything.php?filter=This Month';
        }
        function tran_year()
        {
            document.location='main_everything.php?filter=This Year';
        }
        function tran_custom()
        {   
            var date_from = document.getElementById('txt_date_from').value;
            var date_to = document.getElementById('txt_date_to').value;
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






