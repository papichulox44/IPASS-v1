<style type="text/css">
tbody > tr:hover {
    cursor: pointer;
}
</style>
<?php
    $a = 1;
    $b = 1;
    $c = 1;
    $d = 1;
    $e = 1;
    $f = 1;
    $g = 1;
    $h = 1;
    $i = 1;
    $j = 1;
    $k = 1;
    $l = 1;
    $m = 1;
    $n = 1;
    $o = 1;
    $p = 1;
    $q = 1;
    $r = 1;
    $s = 1;
    $t = 1;
    $u = 1;
    $v = 1;

    $limit = 'limit';
    $limit1 = 1;
    $limit2 = 1;
    $limit3 = 1;
    $limit4 = 1;

    $start = 'start';
    $start1 = 1;
    $start2 = 1;
    $start3 = 1;
    $start4 = 1;
    $start5 = 1;

    $show_steps = 'show_steps';
    $show_steps1 = 1;
    $show_steps2 = 1;

    $see_more = 'see_more';
    $see_more1 = 1;
    $see_more2 = 1;
    $see_more3 = 1;

    $show_step_more = 'show_step_more';
    $show_step_more1 = 1;
    $show_step_more2 = 1;


//_______________________________ FILTER STATUS Query
    $filter_status = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'status'");
    if(mysqli_num_rows($filter_status) != 0)
    {
        $filter_status_id_array = 'status_id = '.implode(" OR status_id = ", $status_array).'';
        $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' AND $filter_status_id_array");
    }
    else
    {
        $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' ORDER BY status_order_no ASC");
        // echo '
        // <div class="text-center"></div>
        // <div class="text-center">
        // <img src="./services.gif">
        // </div>
        // ';
    }
//_______________________________ END FILTER STATUS Query

    while($result_findstatus = mysqli_fetch_array($findstatus))
    {
        /*$status_name = $result_findstatus['status_name'];
        $que = mysqli_query($conn, "SELECT * FROM status WHERE status_name='$status_name' AND status_list_id='$status_list_id'");*/
        $status_id = $result_findstatus['status_id'];
        $que = mysqli_query($conn, "SELECT * FROM status WHERE status_id='$status_id' AND status_list_id='$status_list_id'");
        $res = mysqli_fetch_array($que);
        $final_status_id = $res['status_id'];

        $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' AND task_list_id = '$status_list_id'");
        $count = mysqli_num_rows($select_task);
        ?>
        <div class="block block-bordered block-rounded <?php echo $md_body; ?>" style="width: 100%; border-left: 5px solid <?php echo $result_findstatus['status_color'];?>; box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.35);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.35);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.35);">
            <div class="block-header" role="tab" id="accordion2_h<?php echo $a++;?>">
                <span style="background-color: <?php echo $result_findstatus['status_color'];?>; padding: 3px 10px; border-radius: 3px;"><a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q<?php echo $c++;?>" aria-expanded="true" aria-controls="accordion2_q<?php echo $d++;?>" style="color: #fff;" id="<?php echo $space_id.','.$user_id.','.$final_status_id.','.$g++.','.$md_body.','.$i++.','.$j++.','.$k++.','.$l++; ?>" onclick="<?php echo strval($show_steps).''.strval($show_steps1++) ?>(this.id)"><?php echo $result_findstatus['status_name'];?></a>
                    <div id="steps_lods<?php echo $h++;?>" style="display: none;" class="spinner-grow spinner-grow-sm text-white" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </span>

                <div class="block-options">
                    <!--<span class="btn btn-sm btn-secondary" style="background-color: <?php echo $result_findstatus['status_color'];?>; color: #fff;">
                        Task: <?php echo $count; ?>
                    </span>-->
                        <!-- <button style="margin-right: 5px;" id="<?php echo $final_status_id; ?>" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-blast" onclick="get_status_id(this.id)"> -->
                        <button style="margin-right: 5px;" id="<?php echo $final_status_id; ?>" type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-blast" onclick="get_status_id(this.id)">
                            Email Blast
                        </button>
                        <button type="button" class="btn btn-sm btn-secondary float-right" data-toggle="modal" data-target="#modal-add_task">
                            <i class="fa fa-plus text-success mr-5"></i>Add
                        </button>
                </div>

            </div>
            <div id="accordion2_q<?php echo $e++;?>" class="collapse" role="tabpanel" aria-labelledby="accordion2_h<?php echo $b++;?>" style="width: 100%; padding:0px 20px 20px 20px;"> <!-- put "show" in class if you want an active-->


                    <label style="margin-bottom: -5px;">Total Task: <label id="total_task<?php echo $p++;?>">0</label> / <label id="final_total_task<?php echo $q++;?>">0</label></label><br>
                    <label>Total Search: <label id="total_search<?php echo $r++;?>">0</label></label>
                    <input type="hidden" id="search_value<?php echo $s++; ?>" value="<?php echo $space_id.','.$user_id.','.$final_status_id.','.$md_body.','.$t++; ?>">
                    <div style="margin-bottom: -30px;" id="load_data_message<?php echo $m++; ?>"></div>
                    <input style="width: 200px; float: right" id="myInput<?php echo $o++;?>" type="text" class="form-control" placeholder="Search..">
                    <select class="pull-right form-control" style="width: 200px;" id="custom_field<?php echo $v++;?>">
                      <option selected value="">Search Custom Field</option>
                      <?php
                      $select_field = mysqli_query($conn,"SELECT * FROM field WHERE field_space_id = '$space_id' ORDER BY field_order ASC");
                      while($fetch_field = mysqli_fetch_array($select_field))
                      {
                        echo '
                        <option value="'.$fetch_field['field_col_name'].'">'.$fetch_field['field_name'].'</option>
                        ';
                      }
                       ?>
                    </select>
                    <br>
                    <div style="overflow: scroll; width: 100%; height: 1000px;" >
                    <table class="table table-striped table-hover table-bordered table-vcenter <?php echo $md_body; ?>" id="remove_duplicate<?php echo $u++; ?>">
                    <thead>
                        <tr>
                            <th class="text-center">Task</th>
                            <th>NAME</th>
                            <th class="d-none d-sm-table-cell">DUE</th>
                            <th>PRIORITY</th>
                            <th class="d-none d-sm-table-cell text-center">Date Updated</th>
                            <th class="d-none d-sm-table-cell text-center">ASSIGN</th>
                            <?php
                            $select_db_tb_column = mysqli_query($conn, "SELECT * FROM add_column WHERE column_space_id = '$space_id' AND column_user_id = '$user_id'");
                                while($fetch_select_column = mysqli_fetch_array($select_db_tb_column))
                                {
                                    $col_name = $fetch_select_column['column_name'];
                                    $select_tb_field = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id ='$space_id' AND field_col_name = '$col_name'");
                                    $fetch_name = mysqli_fetch_array($select_tb_field);

                                    $field_name = $fetch_name['field_name']; // get the name
                                    echo '<th class="d-none d-sm-table-cell text-center">'.$field_name.'</th>';
                                }
                             ?>
                        </tr>
                        <tbody id="service_list<?php echo $f++;?>">
                        </tbody>

                        </table>
                </div>
            </div>
        </div>
        <script>
            var <?php echo $limit.''.$limit1++ ?> = 10;
            var <?php echo $start.''.$start1++ ?> = 0;
            function <?php echo strval($show_steps).''.strval($show_steps2++) ?>(id)
            {
                array = id.split(",")
                space_id = array[0];
                user_id = array[1];
                final_status_id = array[2];
                g = array[3];
                md_body = array[4];
                i = array[5];
                j = array[6];
                k = array[7];
                l = array[8];

                x = document.getElementById("steps_lods"+g);
                x.style.display = "";
                // // alert(limit);

                $.ajax({
                    url: 'ajax_services.php',
                    type: 'POST',
                    async: false,
                    data:{
                        space_id: space_id,
                        user_id:user_id,
                        final_status_id: final_status_id,
                        md_body: md_body,
                        i: i,
                        j: j,
                        k: k,
                        l: l,
                        limit: limit<?php echo strval($limit2++) ?>,
                        start: start<?php echo strval($start2++) ?>,
                        show_steps:1,
                    },
                    cache:false,
                    success: function(data){
                        $('#service_list'+g).append(data);
                            // $('#service_list'+g).html(response);
                        if(data == '')
                            {
                             $('#load_data_message'+g).html("<button type='button' class='btn btn-info'>No Task Found</button>");
                            }
                            else
                            {
                             $('#load_data_message'+g).html("<button type='button' class='btn btn-warning' id='"+space_id+','+user_id+','+final_status_id+','+g+','+md_body+','+i+','+j+','+k+','+l+"' onclick='<?php echo strval($see_more).''.strval($see_more1++) ?>(this.id)'>See More..</button>");
                            }
                        }

                });
            }

            function <?php echo strval($show_step_more).''.strval($show_step_more2++) ?>(id)
            {
                array = id.split(",")
                space_id = array[0];
                user_id = array[1];
                final_status_id = array[2];
                g = array[3];
                md_body = array[4];
                i = array[5];
                j = array[6];
                k = array[7];
                l = array[8];
                limit = array[9];
                start = array[10];

                x = document.getElementById("steps_lods"+g);
                x.style.display = "";

                $.ajax({
                    url: 'ajax_services.php',
                    type: 'POST',
                    async: false,
                    data:{
                        space_id: space_id,
                        user_id:user_id,
                        final_status_id: final_status_id,
                        md_body: md_body,
                        i: i,
                        j: j,
                        k: k,
                        l: l,
                        limit: limit,
                        start: start,
                        show_steps:1,
                    },
                    cache:false,
                    success: function(data){
                        $('#service_list'+g).append(data);
                            // $('#service_list'+g).html(response);
                        if(data == '')
                            {
                             $('#load_data_message'+g).html("<button type='button' class='btn btn-info'>No More Task</button>");
                            }
                            else
                            {
                            $('#load_data_message'+g).html("<button type='button' class='btn btn-warning' id='"+space_id+','+user_id+','+final_status_id+','+g+','+md_body+','+i+','+j+','+k+','+l+"' onclick='<?php echo strval($see_more).''.strval($see_more3++) ?>(this.id)'>See More..</button>");
                            }
                        }

                });
            }

             function <?php echo strval($see_more).''.strval($see_more2++) ?>(id)
             {
                // alert('Nag alert');
                <?php echo strval($start).''.strval($start4++) ?> = <?php echo strval($start).''.strval($start3++) ?> + <?php echo strval($limit).''.strval($limit3++) ?>;
                see_more_id = id+','+10+','+<?php echo strval($start).''.strval($start5++) ?>;
                // alert(see_more_id);
                <?php echo $show_step_more.''.$show_step_more1++ ?>(see_more_id);
             }



        </script>
    <?php
    }
?>

<script>
    // function <?php echo $show_steps.''.$show_steps2++ ?>(id)
    // {
    //     alert('Nag alert sya!');
    // }

    function get_status_id(id)
    {
        document.getElementById("task_status_id").value = id;
    }

    function show_step(id)
    {
        alert(id);
    }


</script>
