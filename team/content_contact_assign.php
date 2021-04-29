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
<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content <?php echo $md_primary_darker; ?>">

        <!-- Dynamic Table Full -->
        <div class="block block-rounded shadow <?php echo $md_body; ?>">
            <div class="block-header content-heading <?php echo $md_body; ?>">
                <h3 class="block-title <?php echo $md_text; ?>">Assign contact</h3>
            </div>
            <div class="block-content block-content-full <?php echo $md_body; ?>">
                <!-- DataTables functionality is initialized with .js-dataTable-full class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
                <label style="margin-bottom: -5px;">Total Task: <label id="total_task">20</label> / <label><?php
                $count_contact = mysqli_query($conn, "SELECT Count(contact.contact_id) AS final_total_contact FROM contact");
                $data = mysqli_fetch_assoc($count_contact);
                $final_total_contact = $data['final_total_contact'];
                echo number_format($final_total_contact);
                 ?></label></label><br>
                <label>Total Search: <label id="total_search">0</label></label>
                <div id="search_loading" style="display: none;" class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <input style="width: 200px; float: right; margin-bottom: 5px;" id="myInput" type="text" class="form-control" placeholder="Search..">
                <table id="example" class="table table-bordered table-striped table-vcenter <?php echo $md_body; ?>  table-sort table-arrows">
                    <thead>
                        <tr>
                            <th>Contact ID:</th>
                            <th>Name</th>
                            <th class="d-none d-sm-table-cell text-center">Total Task</th>
                            <th class="d-none d-sm-table-cell">Email</th>
                            <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Number</th>
                            <th class="text-center" style="width: 15%;">Profile</th>
                            <!--<th class="d-none d-sm-table-cell text-center">Tools</th>-->
                        </tr>
                    </thead>
                    <tbody id="load_data">
                    </tbody>
                </table>
                <div id="load_data_message"></div>
            </div>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src = '../assets/table-sort.js'></script>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var inputlength = this.value.length;
    var value = $(this).val();
    $("#load_data tr").filter(function() {
      var rowCount = $("#load_data tr:visible").length;
      if(inputlength == "0"){
          document.getElementById("total_search").innerHTML = 0;
          document.getElementById("total_task").innerHTML = rowCount;
         var seen = {};
          table = document.getElementById("load_data");
          tr = table.getElementsByTagName("tr");
          for (i = 0; i < tr.length; i++) {
              td = tr[i].getElementsByTagName("td")[0];
              if (seen[td.textContent]) {
                  tr[i].remove();
              } else {
                  seen[td.textContent]=true;
              }
          }
      } else {
          document.getElementById("total_search").innerHTML = rowCount;
      }
      $(this).toggle($(this).text().indexOf(value) > -1)

    });
  });
});

  var limit = 20;
  var start = 0;
  var action = 'inactive';
  function load_task_data(limit, start)
  {
  $.ajax({
      url:"content_contact_assign_data_table.php",
      method:"POST",
      data:{limit:limit, start:start, load_country_data:1},
      cache:false,
      success:function(data)
      {
      $('#load_data').append(data);
      if(data == '')
      {
       $('#load_data_message').html("<button type='button' class='btn btn-info'>No More Task Found</button>");
       action = 'active';
      }
      else
      {
        var seen = {};
        table = document.getElementById("load_data");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[0];
            if (seen[td.textContent]) {
                tr[i].remove();
            } else {
                seen[td.textContent]=true;
            }
        }
        var rowCount = $("#load_data tr:visible").length;
        document.getElementById("total_task").innerHTML = rowCount;
       $('#load_data_message').html("<button type='button' class='btn btn-warning'>Please Wait....</button>");
       action = "inactive";
      }
    }
  });
  }

  if(action == 'inactive')
    {
    action = 'active';
    load_task_data(limit, start);
    }
  $(window).scroll(function(){
  if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
    {
    action = 'active';
    start = start + limit;
    setTimeout(function(){
    load_task_data(limit, start);
    }, 1000);
    }
  });

  var limit_search = 20;
  var start_search = 0;
  var action_search = 'inactive';
  document.getElementById("myInput").onkeypress = function(event){
  if (event.keyCode == 13 || event.which == 13){
      var myInput = document.getElementById("myInput").value;
      $.ajax({
          url:"content_contact_assign_data_table.php",
          method:"POST",
          data:{limit:limit_search, start:start_search, myInput:myInput, load_task_search_data:1},
          cache:false,
          success:function(data)
          {
          $('#load_data').append(data);
          if(data == '')
          {
           alert("No Task Found!!");
          }
          else
          {
            var seen = {};
            table = document.getElementById("load_data");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (seen[td.textContent]) {
                    tr[i].remove();
                } else {
                    seen[td.textContent]=true;
                }
            }
            var rowCount = $("#load_data tr:visible").length;
            document.getElementById("total_task").innerHTML = rowCount;
            x = document.getElementById("search_loading");
            x.style.display = "";
            setTimeout(function(){
            limit_start_search(myInput);
           }, 1000);
          }
        }
      });
      }
  };

  function limit_start_search(myInput){
    start_search = start_search + limit_search;
    load_task_search_data(myInput, limit_search, start_search);
  }

  function load_task_search_data(myInput, limit_search, start_search){
    $.ajax({
        url: "content_contact_assign_data_table.php",
        type: "POST",
        async: false,
        data:{
            myInput: myInput,
            limit: limit_search,
            start: start_search,
            load_task_search_data:1,
        },
        cache:false,
        success: function(data){
            $('#load_data').append(data);
            if (data === "") {
              x = document.getElementById("search_loading");
              x.style.display = "none";
              alert("Task Successfully Extract from the Database!! Thank you for the Patience..");
              reset_start();
            } else {
              var seen = {};
              table = document.getElementById("load_data");
              tr = table.getElementsByTagName("tr");
              for (i = 0; i < tr.length; i++) {
                  td = tr[i].getElementsByTagName("td")[0];
                  if (seen[td.textContent]) {
                      tr[i].remove();
                  } else {
                      seen[td.textContent]=true;
                  }
              }
              var rowCount = $("#load_data tr:visible").length;
              document.getElementById("total_task").innerHTML = rowCount;
              document.getElementById("total_search").innerHTML = rowCount;
              setTimeout(function(){
              limit_start_search(myInput);
             }, 1000);
            }
        }
    });
  }
</script>
