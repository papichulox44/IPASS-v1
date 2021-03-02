<?php
    include("../conn.php");
    // ----------------------- FETCH ALL TRANSACTION -----------------------
    if(isset($_POST['view_all_transaction']))
    {
        $md_mode = $_POST['md_mode'];
        $filterby = $_POST['filterby'];

        $get_from = $_POST['get_from'];
        $get_to = $_POST['get_to'];

        $table = "";
        $total = "bg-gray-lighter";
        $text = "text-muted";
        $text2 = "text-success";
        if($md_mode == "Dark") //insert
        {
            $total = "bg-black-op text-body-color-light";
            $table = "bg-primary-darker text-body-color-light";
            $text = "text-white";
            $text2 = "text-white";
        }
        echo '
        <table class="js-table-sections table table-bordered table-striped table-vcenter js-dataTable-full table-hover'.$table.'">
            <thead>
                <tr>
                    <th>No.</th>
                    <th class="d-none d-sm-table-cell">Name</th>
                    <th class="d-none d-sm-table-cell text-right">Total(USD)</th>
                    <th class="d-none d-sm-table-cell text-right">Total(PHP)</th>
                    <th class="text-right">Total(CLIENT)</th>
                    <th class="text-center">Remarks</th>
                </tr>
            </thead>
            <tbody>
            ';
                $IPASS_total_USD = 0;
                $IPASS_total_PHP = 0;
                $CLIENT_total_PHP = 0;
                $count = 1;

                // $QUERY_PER_VIEW = 'SELECT * FROM task INNER JOIN contact ON task.task_contact = contact.contact_id INNER JOIN finance_transaction ON finance_transaction.val_assign_to = task.task_id INNER JOIN finance_phase ON finance_transaction.val_phase_id = finance_phase.phase_id';
                // include ('ajax_transaction_filter.php');
                // $results = mysqli_query($conn, "SELECT * FROM task INNER JOIN finance_transaction ON finance_transaction.val_assign_to = task.task_id GROUP BY task.task_name");
                $results = mysqli_query($conn, "SELECT task.task_name, Sum(finance_transaction.val_usd_total) AS usd_total, Sum(finance_transaction.val_php_total) AS php_total, Sum(finance_transaction.val_client_total) AS client_total FROM task INNER JOIN finance_transaction ON finance_transaction.val_assign_to = task.task_id GROUP BY task.task_name");

                while($rows = mysqli_fetch_array($results))
                {
                    $task_name = $rows['task_name'];
                    $IPASS_total_USD += $rows['usd_total'];
                    $IPASS_total_PHP += $rows['php_total'];
                    $CLIENT_total_PHP += $rows['client_total'];
                    echo '
                    <tr>
                        <td>'.$count++.'</td>
                        <td style="font-weight: bold;" class="d-none d-sm-table-cell">
                            '.$rows['task_name'].'
                        </td>
                        <td class="d-none d-sm-table-cell text-right">
                            '.number_format($rows['usd_total'],2).'
                        </td>
                        <td class="d-none d-sm-table-cell text-right">
                            '.number_format($rows['php_total'],2).'
                        </td>
                        <td class="text-right">
                            '.number_format($rows['client_total'],2).'
                        </td>
                        <td class="text-right">
                        </td>
                    </tr>';
                    $results_phase = mysqli_query($conn, "SELECT space.space_name, task.task_name, list.list_name, list.list_id, space.space_id, task.task_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE task.task_name = '$task_name' ORDER BY list_name");

                    while($rows_phase = mysqli_fetch_array($results_phase))
                    {

                    $task_id = $rows_phase['task_id'];
                    echo '
                    <tbody class="js-table-sections-header">
                        <tr>
                            <td style="font-weight: bold;" class="text-success text-right">Services:</td>
                            <td style="font-weight: bold;" class="text-primary" colspan="5">'.$rows_phase['space_name'].' ('.$rows_phase['list_name'].')</td>
                        </tr>
                    </tbody>
                    <tbody>';
                                $space_id = $rows_phase['space_id'];
                                // $list = $rows_phase['list_name'];

                                // $results_status = mysqli_query($conn, "SELECT * FROM finance_phase WHERE phase_space_id = $space_id");
                                $results_status = mysqli_query($conn, "SELECT finance_phase.phase_name, finance_transaction.val_usd_total, finance_transaction.val_php_total, finance_transaction.val_client_total, finance_transaction.val_transaction_no, finance_phase.phase_id FROM finance_phase INNER JOIN finance_transaction ON finance_transaction.val_phase_id = finance_phase.phase_id WHERE finance_phase.phase_space_id = $space_id AND finance_transaction.val_assign_to = $task_id");
                                while($rows_status = mysqli_fetch_array($results_status))
                                {
                                    $phase_id = $rows_status['phase_id'];
                                echo '
                                    <tr>
                                        <td class="text-right">'.$rows_status['val_transaction_no'].'</td>
                                        <td class="text-left">'.$rows_status['phase_name'].'</td>
                                        <td class="text-right">'.$rows_status['val_usd_total'].'</td>
                                        <td class="text-right">'.$rows_status['val_php_total'].'</td>
                                        <td class="text-right">'.$rows_status['val_client_total'].'</td>
                                        ';
                                        $results_remarks = mysqli_query($conn, "SELECT * FROM finance_remarks WHERE remarks_to = $task_id and remarks_phase_id = $phase_id");
                                        $rows_remarks = mysqli_num_rows($results_remarks);
                                        if ($rows_remarks) {
                                            while($rows_remarks = mysqli_fetch_array($results_remarks))
                                            {
                                                $phase_id = $rows_remarks['remarks_phase_id'];
                                                $remarks = $rows_remarks['remarks_value'];
                                                if ($remarks == 'Payment received') {
                                                    $color = 'green';
                                                }
                                                if ($remarks == 'On hold') {
                                                    $color = '#c7c10c';
                                                }
                                                if ($remarks == 'Pending') {
                                                    $color = '#b4c04c';
                                                }
                                                if ($remarks == 'Waiting to be received') {
                                                    $color = 'blue';
                                                }
                                                if ($remarks == 'Refunded') {
                                                    $color = '#1db394';
                                                }
                                            echo '<td class="text-center" data-toggle="modal" data-target="#modal-remarks" style="background-color: '.$color.'; cursor: pointer;" id="'.$phase_id.','.$task_id.','.$remarks.'" onclick="update_remarks(this.id)">'.$remarks.'
                                                </td>';
                                            }
                                         }
                                         else
                                         {
                                                echo '<td class="text-center" data-toggle="modal" data-target="#modal-remarks" style="background-color: red; cursor: pointer;" id="'.$phase_id.','.$task_id.'" onclick="add_remarks(this.id)">No Remarks</td>';
                                         }
                                        echo '
                                    </tr>
                                ';
                                }
                    echo '</tbody>';
            ;}  }
                echo'
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-4">
                <div class="'.$total.' mt-20 shadow" style="padding: 0px 10px;">
                    <div class="float-left mt-15 d-sm-block">
                        <i class="fa fa-money fa-2x '.$text2.'"></i>
                    </div>
                    <div class="font-size-h3 font-w600 '.$text2.' text-right">₱'.number_format($IPASS_total_USD,2).'</div>
                    <div class="font-size-sm font-w600 text-uppercase text-right '.$text.'">IPASS TOTAL(USD)</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="'.$total.' mt-20 shadow" style="padding: 0px 10px;">
                    <div class="float-left mt-15 d-sm-block">
                        <i class="fa fa-money fa-2x '.$text2.'"></i>
                    </div>
                    <div class="font-size-h3 font-w600 '.$text2.' text-right">₱'.number_format($IPASS_total_PHP,2).'</div>
                    <div class="font-size-sm font-w600 text-uppercase text-right '.$text.'">IPASS TOTAL(PHP)</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="'.$total.' mt-20 shadow" style="padding: 0px 10px;">
                    <div class="float-left mt-15 d-sm-block">
                        <i class="fa fa-money fa-2x '.$text2.'"></i>
                    </div>
                    <div class="font-size-h3 font-w600 '.$text2.' text-right">₱'.number_format($CLIENT_total_PHP,2).'</div>
                    <div class="font-size-sm font-w600 text-uppercase text-right '.$text.'">CLIENT TOTAL(PHP)</div>
                </div>
            </div>
        </div>
        ';
    }
    // ----------------------- END FETCH ALL TRANSACTION  -----------------------
    // ----------------------- FETCH SPACE TRANSACTION -----------------------
    if(isset($_POST['view_space_transaction']))
    {
        $md_mode = $_POST['md_mode'];
        $filterby = $_POST['filterby'];

        $get_from = $_POST['get_from'];
        $get_to = $_POST['get_to'];

        $table = "";
        $total = "bg-gray-lighter";
        $text = "text-muted";
        $text2 = "text-success";
        if($md_mode == "Dark") //insert
        {
            $total = "bg-black-op text-body-color-light";
            $table = "bg-primary-darker text-body-color-light";
            $text = "text-white";
            $text2 = "text-white";
        }
        echo '
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full table-hover'.$table.'">
            <thead>
                <tr>
                    <th class="d-none d-sm-table-cell">ID</th>
                    <th>SPACE NAME</th>
                    <th class="d-none d-sm-table-cell text-right">Total(USD)</th>
                    <th class="d-none d-sm-table-cell text-right">Total(PHP)</th>
                    <th class="text-right">Total(CLIENT)</th>
                </tr>
            </thead>
            <tbody>';
                $IPASS_total_USD = 0;
                $IPASS_total_PHP = 0;
                $CLIENT_total_PHP = 0;
                /*$QUERY_PER_VIEW = 'SELECT
                space.space_id,
                space.space_name,
                Sum(finance_transaction.val_usd_total) AS usd_total,
                Sum(finance_transaction.val_php_total) AS php_total,
                Sum(finance_transaction.val_client_total) AS client_total,
                finance_transaction.val_date
                FROM
                space
                INNER JOIN list ON space.space_id = list.list_space_id
                INNER JOIN task ON task.task_list_id = list.list_id
                INNER JOIN finance_transaction ON task.task_id = finance_transaction.val_assign_to
                ';*/
                include ('ajax_transaction_filter.php');
                while($rows = mysqli_fetch_array($results))
                {
                    $IPASS_total_USD += $rows['usd_total'];
                    $IPASS_total_PHP += $rows['php_total'];
                    $CLIENT_total_PHP += $rows['client_total'];
                    echo '
                    <tr class="hov_row">
                        <td class="d-none d-sm-table-cell">'.$rows['space_id'].'</td>
                        <td>'.$rows['space_name'].'</td>
                        <td class="d-none d-sm-table-cell text-right">'.number_format($rows['usd_total'],2).'</td>
                        <td class="d-none d-sm-table-cell text-right">'.number_format($rows['php_total'],2).'</td>
                        <td class="text-right">'.number_format($rows['client_total'],2).'</td>
                    </tr>';
                }
                echo'
            </tbody>
        </table>

        <div class="row">
            <div class="col-md-4">
                <div class="'.$total.' mt-20 shadow" style="padding: 0px 10px;">
                    <div class="float-left mt-15 d-sm-block">
                        <i class="fa fa-money fa-2x '.$text2.'"></i>
                    </div>
                    <div class="font-size-h3 font-w600 '.$text2.' text-right">₱'.number_format($IPASS_total_USD,2).'</div>
                    <div class="font-size-sm font-w600 text-uppercase text-right '.$text.'">IPASS TOTAL(USD)</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="'.$total.' mt-20 shadow" style="padding: 0px 10px;">
                    <div class="float-left mt-15 d-sm-block">
                        <i class="fa fa-money fa-2x '.$text2.'"></i>
                    </div>
                    <div class="font-size-h3 font-w600 '.$text2.' text-right">₱'.number_format($IPASS_total_PHP,2).'</div>
                    <div class="font-size-sm font-w600 text-uppercase text-right '.$text.'">IPASS TOTAL(PHP)</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="'.$total.' mt-20 shadow" style="padding: 0px 10px;">
                    <div class="float-left mt-15 d-sm-block">
                        <i class="fa fa-money fa-2x '.$text2.'"></i>
                    </div>
                    <div class="font-size-h3 font-w600 '.$text2.' text-right">₱'.number_format($CLIENT_total_PHP,2).'</div>
                    <div class="font-size-sm font-w600 text-uppercase text-right '.$text.'">CLIENT TOTAL(PHP)</div>
                </div>
            </div>
        </div>
        ';
    }
    // ----------------------- END FETCH SPACE TRANSACTION -----------------------

    //Remarks Content
    if (isset($_POST['update_remarks'])) {

        $phase_id = $_POST['phase_id'];
        $task_id = $_POST['task_id'];
        $remarks = $_POST['remarks'];
        $user_id = $_POST['user_id'];
        $total_usd_amount = 0;
        $update_remarks = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_phase_id = '$phase_id' ORDER BY finance_order") or die(mysqli_error());
        echo '
            <p>Remark Status: <b>'.$remarks.'</b></p>
            <select class="form-control text-muted" id="update_remarks_selected" onchange="update_remarks_selected(this)">
                <option disabled value="" selected>Select Remarks</option>
                <option value="Payment received">Payment received</option>
                <option value="On hold">On hold</option>
                <option value="Pending">Pending</option>
                <option value="Waiting to be received">Waiting to be received</option>
                <option value="Refunded">Refunded</option>
            </select>
            <input id="phase_id" type="hidden" value="'.$phase_id.'"></input>
            <input id="task_id" type="hidden" value="'.$task_id.'"></input><br>
            <table class="table table-bordered table-hover">
                <tr>
                    <th class="text-center">Tools</th>
                    <th>Payment Name</th>
                    <th class="text-right">Currency</th>
                    <th class="text-center">Amount(USD)</th>
                    <th class="text-center">Action</th>
                </tr>
                <tbody>
                ';
                while ($data  = mysqli_fetch_array($update_remarks)) {
                    $total_usd_amount += $data['finance_value'];
                    $task_id = $_POST['task_id'];
                    $finance_id = $data['finance_id'];
                    $table_row = '';

                    $select_hide_show = mysqli_query($conn, "SELECT * FROM finance_field_hide WHERE hideshow_task_id = '$task_id' and hideshow_field_id = '$finance_id'") or die(mysqli_error());
                    $row = mysqli_num_rows($select_hide_show);
                    if ($row)
                    {
                        $table_row = 'class="table-danger"';
                    }
                    echo '
                    <tr '.$table_row.'>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-secondary" id="'.$phase_id.','.$task_id.','.$remarks.','.$data['finance_id'].','.$user_id.'" onclick="hide_show(this.id)"><i class="fa fa-eye-slash"></i>
                        </button></td>
                        <td>'.$data['finance_name'].'</td>
                        <td class="text-right">'.$data['finance_currency'].'</td>
                        <td><center><input class="form-control" style="width: 90px;" type="text" id="amount_usd'.$phase_id.','.$task_id.','.$remarks.','.$data['finance_id'].','.$user_id.'" value="'.$data['finance_value'].'"></center></td>
                        <td class="text-center"><button class="btn btn-success" type="button" id="'.$phase_id.','.$task_id.','.$remarks.','.$data['finance_id'].','.$user_id.'" onclick="update_amount_usd(this.id)">Update</button</td>
                    <tr
                    ';
                }
                // <td id="amount_usd" style="cursor: pointer;" class="text-right" contenteditable="true">'.$data['finance_value'].'</td>
                echo '
                </tr>
                    <td class="table-success text-right font-w600" colspan="5">Total Amount: '.number_format($total_usd_amount,2).'</td>
                </tr>
                </tbody>
            </table>
            ';

        $select_discount = mysqli_query($conn, "SELECT * FROM finance_discount WHERE discount_phase_id = '$phase_id' AND discount_assign_to = '$task_id'");
        $fetch_select_discount = mysqli_fetch_array($select_discount);
        $discount_amount = $fetch_select_discount['discount_amount'] == 0 ? '' : number_format((float)$fetch_select_discount['discount_amount'],2,".",'');

        $select_field = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_phase_id = '$phase_id' AND finance_type = 'text' ORDER BY finance_order ASC");
        $total_amount = 0;
        while($fetch_select_field = mysqli_fetch_array($select_field))
        {
            $field_id = $fetch_select_field['finance_id'];
            //$total_amount += $fetch_select_field['finance_value'] == 0 ? '' : number_format((float)$fetch_select_field['finance_value'],2,".",'');
            $select_custom_amount = mysqli_query($conn, "SELECT * FROM finance_field_ca WHERE custom_amount_task_id = '$task_id' AND custom_amount_field_id = '$field_id'");
            $fetch_custom_amount = mysqli_fetch_array($select_custom_amount);
            $count1 = mysqli_num_rows($select_custom_amount);

            $select_finance_field_hs = mysqli_query($conn, "SELECT * FROM finance_field_hide WHERE hideshow_task_id = '$task_id' AND hideshow_field_id = '$field_id'");
            $fetch_hs = mysqli_fetch_array($select_finance_field_hs);
            $count = mysqli_num_rows($select_finance_field_hs);
            if($count == 0) // check if this field is visible in this task
            {
                if($count1 == 1) // if has custom amount
                {
                    $amount = $fetch_custom_amount['custom_amount_value'] == 0 ? '' : number_format((float)$fetch_custom_amount['custom_amount_value'],2,".",'');
                    $total_amount += $amount;
                }
                else
                {
                    $amount = $fetch_select_field['finance_value'] == 0 ? '' : number_format((float)$fetch_select_field['finance_value'],2,".",'');
                    $total_amount += $amount;
                }
            }
        }

        echo'
        <div class="table-responsive">
            <table class="js-table-sections table table-bordered table-striped table-hover table-vcenter shad">
                <thead>
                    <tr>
                        <th class="text-left">Date</th>
                        <th class="text-left">Remittance</th>
                        <th class="text-left">Trans_no</th>
                        <th class="text-center">Currency</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Charge</th>
                        <th class="text-center">Initial</th>
                        <th class="text-center">Rate(UPC)</th>
                        <th class="text-right">Amount(USD)</th>
                        <th class="text-right">Amount(PHP)</th>
                        <th class="text-right">Amount(PAID)</th>
                    </tr>
                </thead>
                <tbody>';
                    $USD_tot = 0;
                    $PHP_tot = 0;
                    $PHP_tot_client = 0;
                    $transaction = mysqli_query($conn, "SELECT * FROM finance_transaction WHERE val_phase_id = '$phase_id' AND val_assign_to = '$task_id' ORDER BY val_date DESC");
                    while($rows = mysqli_fetch_array($transaction))
                    {
                        $USD_tot += $rows['val_usd_total'];
                        $PHP_tot += $rows['val_php_total'];
                        $PHP_tot_client += $rows['val_client_total'];

                        $val_php_total = $rows['val_php_total'];
                        $val_client_total = $rows['val_client_total'];
                        echo '
                        <tr>
                            <td>'.$rows['val_date'].'</td>
                            <td>'.$rows['val_method'].'</td>
                            <td>'.$rows['val_transaction_no'].'</td>
                            <td class="text-center">'.$rows['val_currency'].'</td>
                            <td class="text-center">'.number_format($rows['val_amount'],2).'</td>
                            <td class="text-center">'.$rows['val_charge'].'</td>
                            <td class="text-center">'.number_format($rows['val_initial_amount'],2).'</td>
                            <td class="text-center">'.$rows['val_usd_rate'].'|'.$rows['val_php_rate'].'|'.$rows['val_client_rate'].'</td>
                            <td class="text-right">$'.number_format($rows['val_usd_total'],2).'</td>
                            <td class="text-right">₱'.number_format($val_php_total,2).'</td>
                            <td class="text-right">‭₱'.number_format($val_client_total,2).'</td>
                        </tr>
                        ';
                    }
                    $USD_paid = $USD_tot;
                    $PHP_paid = $PHP_tot;
                    $PHP_paid_client = $PHP_tot_client;

                    $USD_depo = 0.00;
                    $PHP_depo = 0.00;
                    $PHP_depo_client = 0.00;

                    if($discount_amount == "") // check if no discount
                    {
                        $USD_bal = $total_amount;
                        $USD_bal = $total_amount - $USD_paid;
                        if($USD_bal < 0)
                        {
                            $USD_depo = $USD_bal * (-1);
                            if($USD_tot == 0)
                            {
                                $PHP_depo = 0.00;
                            }
                            else
                            {
                                $PHP_depo = $USD_depo * $PHP_tot / $USD_tot;
                            }
                            $USD_bal = 0.00;
                        }
                    }
                    else // has discount
                    {
                        if($USD_paid == "0") // if USD paid == 0
                        {
                            $USD_bal = $total_amount - $discount_amount;
                        }
                        else // else USD paid != 0
                        {
                            $deduct = $discount_amount + $USD_paid;
                            $USD_bal = $total_amount - $deduct;
                        }

                        if($USD_bal < 0) // if USD Balace is negative
                        {
                            $USD_depo = $USD_bal * (-1);
                            $PHP_depo = $USD_depo * $PHP_tot / $USD_tot;
                            $USD_bal = 0.00;
                        }
                    }

                    // Code in getting client BALANCE & DEPOSIT
                    if($USD_tot == 0) // check if no USD paid or payment
                    {
                        $PHP_bal = 0;
                        $PHP_bal_client = 0;
                    }
                    else // else has payment
                    {
                        $PHP_bal = $USD_bal * $PHP_tot / $USD_tot;// apply ratio and proportion formula
                        $difference = $PHP_paid - $PHP_paid_client;
                        $PHP_bal_client = $difference + $PHP_bal;// apply ratio and proportion formula
                        if($PHP_depo != 0) // if IPASS php deposit is not equal to 0
                        {
                            $PHP_depo_client = $PHP_depo - $PHP_bal_client;
                            if($PHP_depo_client < 0) // if Client deposit is negative
                            {
                                $PHP_bal_client = $PHP_depo_client * (-1);
                                $PHP_depo_client = 0;
                            }
                            else
                            {
                                $PHP_bal_client = 0;
                            }
                        }

                        if($PHP_bal_client < 0)// if Client balance is negative, meaninng client rate is greater than IPASS rate
                        {
                            $PHP_depo_client = $PHP_bal_client * (-1);
                            $PHP_bal_client = 0;
                        }
                    }
    // END IPASS Total amount, Deposit, Balance
                    echo'
                </tbody>
                    <tr>
                        <td colspan="8" class="text-right font-w600">Total Amount:</td>
                        <td class="text-right font-w600">$'.number_format($USD_paid,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_paid,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_paid_client,2).'</td>
                    </tr>
                    <tr>
                        <td colspan="8" class="text-right font-w600">Deposit:</td>
                        <td class="text-right font-w600">$'.number_format($USD_depo,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_depo,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_depo_client,2).'</td>
                    </tr>
                    <tr class="table-success">
                        <td colspan="7" class="font-w600 text-uppercase">';
                        if($discount_amount == "")
                        {
                            echo 'No discount';
                        }
                        else
                        {
                            echo 'Less '.$discount_amount.' discount';
                        }
                        echo '
                        </td>
                        <td class="text-right font-w600 text-uppercase">Balance:</td>
                        <td class="text-right font-w600">$'.number_format($USD_bal,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_bal,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_bal_client,2).'</td>
                    </tr>
            </table>
        </div>
        ';

    }
    //End Remarks Content

    //ADD Remarks Content
    if (isset($_POST['add_remarks'])) {

        $phase_id = $_POST['phase_id'];
        $task_id = $_POST['task_id'];
        $user_id = $_POST['user_id'];
        $total_usd_amount = 0;

        $update_remarks = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_phase_id = '$phase_id' ORDER BY finance_order") or die(mysqli_error());
        echo '
            <p>Remark Status: <b>No Remarks</b></p>
            <select class="form-control text-muted" id="add_remarks_selected" onchange="add_remarks_selected(this)">
                <option disabled value="" selected>Select Remarks</option>
                <option value="Payment received">Payment received</option>
                <option value="On hold">On hold</option>
                <option value="Pending">Pending</option>
                <option value="Waiting to be received">Waiting to be received</option>
                <option value="Refunded">Refunded</option>
            </select>
            <input id="phase_id" type="hidden" value="'.$phase_id.'"></input>
            <input id="task_id" type="hidden" value="'.$task_id.'"></input><br>
            <input id="user_id" type="hidden" value="'.$user_id.'"></input><br>
            <table class="table table-bordered table-hover">
                <tr>
                    <th class="text-center">Tools</th>
                    <th>Payment Name</th>
                    <th class="text-right">Currency</th>
                    <th class="text-right">Amount(USD)</th>
                </tr>
                ';
                while ($data  = mysqli_fetch_array($update_remarks)) {
                    $total_usd_amount += $data['finance_value'];
                    $task_id = $_POST['task_id'];
                    $finance_id = $data['finance_id'];
                    $table_row = '';

                    $select_hide_show = mysqli_query($conn, "SELECT * FROM finance_field_hide WHERE hideshow_task_id = '$task_id' and hideshow_field_id = '$finance_id'") or die(mysqli_error());
                    $row = mysqli_num_rows($select_hide_show);
                    if ($row)
                    {
                        $table_row = 'class="table-danger"';
                    }
                    echo '
                    <tr '.$table_row.'>
                        <td class="text-center"><button type="button" class="btn btn-sm btn-secondary" title="Edit amount" id="'.$phase_id.','.$task_id.',No Remarks,'.$data['finance_id'].','.$user_id.'" onclick="hide_show(this.id)"><i class="fa fa-eye-slash"></i>
                        </button></td>
                        <td>'.$data['finance_name'].'</td>
                        <td class="text-right">'.$data['finance_currency'].'</td>
                        <td style="cursor: pointer;" class="text-right" contenteditable="true">'.$data['finance_value'].'</td>
                    </tr>
                    ';
                }
                echo '
                </tr>
                    <td class="table-success text-right font-w600" colspan="4">Total Amount: '.number_format($total_usd_amount,2).'</td>
                </tr>
            </table>
            ';

        $select_discount = mysqli_query($conn, "SELECT * FROM finance_discount WHERE discount_phase_id = '$phase_id' AND discount_assign_to = '$task_id'");
        $fetch_select_discount = mysqli_fetch_array($select_discount);
        $discount_amount = $fetch_select_discount['discount_amount'] == 0 ? '' : number_format((float)$fetch_select_discount['discount_amount'],2,".",'');

        $select_field = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_phase_id = '$phase_id' AND finance_type = 'text' ORDER BY finance_order ASC");
        $total_amount = 0;
        while($fetch_select_field = mysqli_fetch_array($select_field))
        {
            $field_id = $fetch_select_field['finance_id'];
            //$total_amount += $fetch_select_field['finance_value'] == 0 ? '' : number_format((float)$fetch_select_field['finance_value'],2,".",'');
            $select_custom_amount = mysqli_query($conn, "SELECT * FROM finance_field_ca WHERE custom_amount_task_id = '$task_id' AND custom_amount_field_id = '$field_id'");
            $fetch_custom_amount = mysqli_fetch_array($select_custom_amount);
            $count1 = mysqli_num_rows($select_custom_amount);

            $select_finance_field_hs = mysqli_query($conn, "SELECT * FROM finance_field_hide WHERE hideshow_task_id = '$task_id' AND hideshow_field_id = '$field_id'");
            $fetch_hs = mysqli_fetch_array($select_finance_field_hs);
            $count = mysqli_num_rows($select_finance_field_hs);
            if($count == 0) // check if this field is visible in this task
            {
                if($count1 == 1) // if has custom amount
                {
                    $amount = $fetch_custom_amount['custom_amount_value'] == 0 ? '' : number_format((float)$fetch_custom_amount['custom_amount_value'],2,".",'');
                    $total_amount += $amount;
                }
                else
                {
                    $amount = $fetch_select_field['finance_value'] == 0 ? '' : number_format((float)$fetch_select_field['finance_value'],2,".",'');
                    $total_amount += $amount;
                }
            }
        }

        echo'
        <div class="table-responsive">
            <table class="js-table-sections table table-bordered table-striped table-hover table-vcenter shad">
                <thead>
                    <tr>
                        <th class="text-left">Date</th>
                        <th class="text-left">Remittance</th>
                        <th class="text-left">Trans_no</th>
                        <th class="text-center">Currency</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Charge</th>
                        <th class="text-center">Initial</th>
                        <th class="text-center">Rate(UPC)</th>
                        <th class="text-right">Amount(USD)</th>
                        <th class="text-right">Amount(PHP)</th>
                        <th class="text-right">Amount(PAID)</th>
                    </tr>
                </thead>
                <tbody>';
                    $USD_tot = 0;
                    $PHP_tot = 0;
                    $PHP_tot_client = 0;
                    $transaction = mysqli_query($conn, "SELECT * FROM finance_transaction WHERE val_phase_id = '$phase_id' AND val_assign_to = '$task_id' ORDER BY val_date DESC");
                    while($rows = mysqli_fetch_array($transaction))
                    {
                        $USD_tot += $rows['val_usd_total'];
                        $PHP_tot += $rows['val_php_total'];
                        $PHP_tot_client += $rows['val_client_total'];

                        $val_php_total = $rows['val_php_total'];
                        $val_client_total = $rows['val_client_total'];
                        echo '
                        <tr>
                            <td>'.$rows['val_date'].'</td>
                            <td>'.$rows['val_method'].'</td>
                            <td>'.$rows['val_transaction_no'].'</td>
                            <td class="text-center">'.$rows['val_currency'].'</td>
                            <td class="text-center">'.number_format($rows['val_amount'],2).'</td>
                            <td class="text-center">'.$rows['val_charge'].'</td>
                            <td class="text-center">'.number_format($rows['val_initial_amount'],2).'</td>
                            <td class="text-center">'.$rows['val_usd_rate'].'|'.$rows['val_php_rate'].'|'.$rows['val_client_rate'].'</td>
                            <td class="text-right">$'.number_format($rows['val_usd_total'],2).'</td>
                            <td class="text-right">₱'.number_format($val_php_total,2).'</td>
                            <td class="text-right">‭₱'.number_format($val_client_total,2).'</td>
                        </tr>
                        ';
                    }
                    $USD_paid = $USD_tot;
                    $PHP_paid = $PHP_tot;
                    $PHP_paid_client = $PHP_tot_client;

                    $USD_depo = 0.00;
                    $PHP_depo = 0.00;
                    $PHP_depo_client = 0.00;

                    if($discount_amount == "") // check if no discount
                    {
                        $USD_bal = $total_amount;
                        $USD_bal = $total_amount - $USD_paid;
                        if($USD_bal < 0)
                        {
                            $USD_depo = $USD_bal * (-1);
                            if($USD_tot == 0)
                            {
                                $PHP_depo = 0.00;
                            }
                            else
                            {
                                $PHP_depo = $USD_depo * $PHP_tot / $USD_tot;
                            }
                            $USD_bal = 0.00;
                        }
                    }
                    else // has discount
                    {
                        if($USD_paid == "0") // if USD paid == 0
                        {
                            $USD_bal = $total_amount - $discount_amount;
                        }
                        else // else USD paid != 0
                        {
                            $deduct = $discount_amount + $USD_paid;
                            $USD_bal = $total_amount - $deduct;
                        }

                        if($USD_bal < 0) // if USD Balace is negative
                        {
                            $USD_depo = $USD_bal * (-1);
                            $PHP_depo = $USD_depo * $PHP_tot / $USD_tot;
                            $USD_bal = 0.00;
                        }
                    }

                    // Code in getting client BALANCE & DEPOSIT
                    if($USD_tot == 0) // check if no USD paid or payment
                    {
                        $PHP_bal = 0;
                        $PHP_bal_client = 0;
                    }
                    else // else has payment
                    {
                        $PHP_bal = $USD_bal * $PHP_tot / $USD_tot;// apply ratio and proportion formula
                        $difference = $PHP_paid - $PHP_paid_client;
                        $PHP_bal_client = $difference + $PHP_bal;// apply ratio and proportion formula
                        if($PHP_depo != 0) // if IPASS php deposit is not equal to 0
                        {
                            $PHP_depo_client = $PHP_depo - $PHP_bal_client;
                            if($PHP_depo_client < 0) // if Client deposit is negative
                            {
                                $PHP_bal_client = $PHP_depo_client * (-1);
                                $PHP_depo_client = 0;
                            }
                            else
                            {
                                $PHP_bal_client = 0;
                            }
                        }

                        if($PHP_bal_client < 0)// if Client balance is negative, meaninng client rate is greater than IPASS rate
                        {
                            $PHP_depo_client = $PHP_bal_client * (-1);
                            $PHP_bal_client = 0;
                        }
                    }
    // END IPASS Total amount, Deposit, Balance
                    echo'
                </tbody>
                    <tr>
                        <td colspan="8" class="text-right font-w600">Total Amount:</td>
                        <td class="text-right font-w600">$'.number_format($USD_paid,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_paid,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_paid_client,2).'</td>
                    </tr>
                    <tr>
                        <td colspan="8" class="text-right font-w600">Deposit:</td>
                        <td class="text-right font-w600">$'.number_format($USD_depo,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_depo,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_depo_client,2).'</td>
                    </tr>
                    <tr class="table-success">
                        <td colspan="7" class="font-w600 text-uppercase">';
                        if($discount_amount == "")
                        {
                            echo 'No discount';
                        }
                        else
                        {
                            echo 'Less '.$discount_amount.' discount';
                        }
                        echo '
                        </td>
                        <td class="text-right font-w600 text-uppercase">Balance:</td>
                        <td class="text-right font-w600">$'.number_format($USD_bal,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_bal,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_bal_client,2).'</td>
                    </tr>
            </table>
        </div>
        ';
    }
    //End ADD Remarks Content

    //Update Remarks Content
    if (isset($_POST['update_remarks_selected'])) {

        $phase_id = $_POST['phase_id'];
        $task_id = $_POST['task_id'];
        $remarks_value = $_POST['remarks_value'];

        $update_remarks = mysqli_query($conn, "UPDATE finance_remarks SET remarks_value = '$remarks_value' WHERE remarks_to = '$task_id' and remarks_phase_id = '$phase_id'") or die(mysqli_error());

    }
    //End Update Remarks Content

    //Add Remarks Content
    if (isset($_POST['add_remarks_selected'])) {

        $phase_id = $_POST['phase_id'];
        $task_id = $_POST['task_id'];
        $user_id = $_POST['user_id'];
        $remarks_value = $_POST['remarks_value'];

        // echo $remarks_value;
        $update_remarks = mysqli_query($conn, "INSERT INTO finance_remarks values ('', '$user_id', '$task_id', '$phase_id', '$remarks_value')") or die(mysqli_error());

    }
    //End add Remarks Content

    //Start Hide Show in finance_field_hide insert and update table
    if (isset($_POST['hide_show'])) {

        $user_id = $_POST['user_id'];
        $task_id = $_POST['task_id'];
        $field_id = $_POST['field_id'];

        $query_hide_show = mysqli_query($conn, "SELECT * FROM finance_field_hide WHERE hideshow_user_id = '$user_id' and hideshow_task_id = '$task_id' and hideshow_field_id = '$field_id'") or die(mysqli_error());
        $row = mysqli_num_rows($query_hide_show);
        if ($row)
            {
                $query_delete = mysqli_query($conn, "DELETE from finance_field_hide WHERE hideshow_user_id = '$user_id' and hideshow_task_id = '$task_id' and hideshow_field_id = '$field_id'") or die(mysqli_error());
                echo 'Unhide';
            }
        else
            {
                $query_insert = mysqli_query($conn, "INSERT INTO finance_field_hide values ('', '$user_id', '$task_id', '$field_id')") or die(mysqli_error());
                echo 'Hide';
            }
    }
    //End add Remarks Content

    //Start update/add amount_usd in finance_field_ca
    // if (isset($_POST['update_amount_usd'])) {
    //
    //     $user_id = $_POST['user_id'];
    //     $task_id = $_POST['task_id'];
    //     $field_id = $_POST['field_id'];
    //     $amount_usd = $_POST['amount_usd'];
    //
    //     $query_update_amount_usd = mysqli_query($conn, "SELECT * FROM finance_field_ca WHERE hideshow_user_id = '$user_id' and hideshow_task_id = '$task_id' and hideshow_field_id = '$field_id'") or die(mysqli_error());
    //     $row = mysqli_num_rows($query_update_amount_usd);
    //     if ($row)
    //         {
    //             $query_delete = mysqli_query($conn, "DELETE from finance_field_hide WHERE hideshow_user_id = '$user_id' and hideshow_task_id = '$task_id' and hideshow_field_id = '$field_id'") or die(mysqli_error());
    //             echo 'Unhide';
    //         }
    //     else
    //         {
    //             $query_insert = mysqli_query($conn, "INSERT INTO finance_field_hide values ('', '$user_id', '$task_id', '$field_id')") or die(mysqli_error());
    //             echo 'Hide';
    //         }
    // }
    //End update/add amount_usd in finance_field_ca

    // ----------------------- MODAL PER TRANSACTION -----------------------
    if(isset($_POST['fetch_per_transaction']))
    {
        $val_id = $_POST['transaction_id'];
        $select_fetch_id = mysqli_query($conn, "SELECT * FROM finance_transaction LEFT JOIN finance_discount ON val_phase_id = discount_phase_id WHERE val_id = '$val_id'");
        $fetch_col_name = mysqli_fetch_array($select_fetch_id);
        ?>
            <div class="form-group row">
                <div class="col-md-6">
                    <h4 class="text-muted">Transaction area</h4>
                </div>
                <div class="col-md-6">
                    <div class="form-group row">
                        <!--<input type="text" class="form-control" id="disc_id" readonly>-->
                        <div class="col-md-4">
                            <label for="contact1-firstname">Discount ID</label>
                            <input type="text" class="form-control text-center" id="disc_id" readonly value="<?php echo $fetch_col_name['discount_id']; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="contact1-firstname">Discounted amount</label>
                            <input type="text" class="form-control text-center" id="disc_amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo $fetch_col_name['discount_amount']; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="contact1-lastname">Option</label>
                            <button type="button" class="btn btn-md btn-noborder btn-primary btn-block" onclick="update_discount()"><li class="fa fa-check"></li> Update</button>
                        </div>
                    </div>
                    <hr style="height:1px;border-width:0;color:gray;background-color:gray">
                </div>
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Transaction date: <span class="text-danger" style="font-size: 12px;" >(Require)</span></label>
                                <div class="col-md-7">
                                    <input type="hidden" class="form-control" id="val_id" readonly value="<?php echo $val_id; ?>">
                                    <input type="date" class="form-control" id="tran_date" value="<?php echo $fetch_col_name['val_date']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Remittance: <span class="text-danger" style="font-size: 12px;">(Require)</span></label>
                                <div class="col-md-7">
                                    <select class="form-control text-muted" style="width: 100%;" id="tran_method" required>
                                        <option></option>
                                        <option value="BDO PI" <?php if($fetch_col_name['val_method'] == "BDO PI") echo 'selected="selected"'; ?> >BANCO DE ORO (PESO Account) - IPASS</option>
                                        <option value="BDO DI" <?php if($fetch_col_name['val_method'] == "BDO DI") echo 'selected="selected"'; ?> >BANCO DE ORO (DOLLAR Account) - IPASS</option>
                                        <option value="BDO PJ" <?php if($fetch_col_name['val_method'] == "BDO PJ") echo 'selected="selected"'; ?> >BANCO DE ORO (PESO Account) - Joyce O. Parungao</option>
                                        <option value="BDO DJ" <?php if($fetch_col_name['val_method'] == "BDO DJ") echo 'selected="selected"'; ?> >BANCO DE ORO (DOLLAR Account) - Joyce O. Parungao</option>
                                        <option value="BPI P">BPI Savings (PESO Account)</option>
                                        <option value="BPI D">BPI Dollar Account</option>
                                        <option value="PAL. PAWN.">Palawan Pawnshop</option>
                                        <option value="ML">MLhuillier</option>
                                        <option value="PP">Paypal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Transaction No.: <span class="text-danger" style="font-size: 12px;">(Require)</span></label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="tran_transaction_no" value="<?php echo $fetch_col_name['val_transaction_no']; ?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Payment amount: <span class="text-danger" style="font-size: 12px;">(Require)</span></label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_amount" value="<?php echo $fetch_col_name['val_amount']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Bank charge:</label>
                                <div class="col-md-2">
                                    <?php
                                        $val_charge = explode("|", $fetch_col_name['val_charge']);
                                        $charge = $val_charge[1];
                                        $currency = $val_charge[0];

                                    ?>
                                   <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_charge" value="<?php echo $charge; ?> ">
                                </div>
                                <div class="col-md-3">
                                  <select class="form-control text-muted" style="width: 185%;" id="tran_charge_type" >
                                        <!-- <option value=""></option> -->
                                        <option value="PHP" <?php if($currency == "PHP") echo 'selected="selected"'; ?> >Philippine peso (PHP)</option>
                                        <option value="USD" <?php if($currency == "USD") echo 'selected="selected"'; ?>>U.S. dollar (USD)</option>
                                    </select>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Client rate: <span class="text-danger" style="font-size: 12px;">(Require)</span></label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_client_rate" value="<?php echo $fetch_col_name['val_client_rate']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Currency: <span class="text-danger" style="font-size: 12px;">(Require)</span></label>
                                <div class="col-md-7">
                                    <?php $currency_code = $fetch_col_name['val_currency']; ?>
                                    <select class="form-control text-muted" style="width: 100%;" id="tran_currency" onchange="currency_select(this)">
                                    <option value="PHP" <?php if($currency_code == "PHP") echo 'selected="selected"'; ?>>Philippine peso (PHP)</option>
                                    <option value="USD" <?php if($currency_code == "USD") echo 'selected="selected"'; ?>>U.S. dollar (USD)</option>
                                    <option value="CAD" <?php if($currency_code == "CAD") echo 'selected="selected"'; ?>>Canadian dollar (CAD)</option>
                                    <option value="EUR" <?php if($currency_code == "EUR") echo 'selected="selected"'; ?>>Euro (EUR)</option>
                                    <option value="GBP" <?php if($currency_code == "GBP") echo 'selected="selected"'; ?>>British pound (GBP)</option>
                                    <option value="CHF" <?php if($currency_code == "CHF") echo 'selected="selected"'; ?>>Swiss franc (CHF)</option>
                                    <option value="NZD" <?php if($currency_code == "NZD") echo 'selected="selected"'; ?>>New Zealand dollar (NZD)</option>
                                    <option value="AUD" <?php if($currency_code == "AUD") echo 'selected="selected"'; ?>>Australian dollarr (AUD)</option>
                                    <option value="JPY" <?php if($currency_code == "JPY") echo 'selected="selected"'; ?>>Japanese yen (JPY)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Note:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" id="tran_note" value="<?php echo $fetch_col_name['val_note']; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Initial amount:</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_initial" readonly value="<?php echo $fetch_col_name['val_initial_amount']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Rate in USD(‎$):</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_usd_rate" readonly value="<?php echo $fetch_col_name['val_usd_rate']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Amount in USD(‎$):</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_usd_total" readonly value="<?php echo $fetch_col_name['val_usd_total']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Rate in PHP(‎₱):</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_php_rate" readonly value="<?php echo $fetch_col_name['val_php_rate']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Amount in PHP(‎₱):</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_php_total" readonly value="<?php echo $fetch_col_name['val_php_total']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Client amount in PHP(‎₱):</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" id="tran_client_php_total" readonly value="<?php echo $fetch_col_name['val_client_total']; ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Attachment: </label>
                                <div class="col-md-7">
                                    <input type="file" class="form-control bg-corporate inputlable" id="tran_attachment" style="padding: 3px 5px;" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5 col-form-label">Option:</label>
                                <div class="col-md-7">
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-md btn-noborder btn-primary btn-block mb-15" onclick="update_transac()"><li class="fa fa-check"></li> Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <input type="hidden" class="form-control" id="val_attachment" readonly value="<?php echo $fetch_col_name['val_attachment']; ?>">
                    <img src="../assets/media/transaction/<?php echo $fetch_col_name['val_attachment']; ?>" style= "width: 100%;">
                </div>
            </div>
        <?php
    }
    // ----------------------- END MODAL PER TRANSACTION --------------------------
?>
    <script type="text/javascript">
        function update_discount()
        {
            disc_id = document.getElementById("disc_id").value;
            disc_amount = document.getElementById("disc_amount").value;

            if (disc_id)
            {
                $.ajax({
                url: 'ajax.php',
                type: 'POST',
                async: false,
                data:{
                    disc_id:disc_id,
                    disc_amount:disc_amount,
                },
                    success: function(response){
                        alert("Discount Successfully Update");
                    }
                });
            }
        }

        function update_transac()
        {
            val_id = document.getElementById("val_id").value;
            tran_date = document.getElementById("tran_date").value;
            tran_method = document.getElementById("tran_method").value;
            tran_transaction_no = document.getElementById("tran_transaction_no").value;
            tran_amount = document.getElementById("tran_amount").value;
            tran_charge = document.getElementById("tran_charge").value;
            tran_charge_type = document.getElementById("tran_charge_type").value;
            tran_client_rate = document.getElementById("tran_client_rate").value;
            tran_currency = document.getElementById("tran_currency").value;
            tran_note = document.getElementById("tran_note").value;
            file_trans = document.getElementById("tran_attachment").value;
            val_attachment = document.getElementById("val_attachment").value;
            update_transaction = 1;

            tran_initial = document.getElementById("tran_initial").value;
            tran_usd_rate = document.getElementById("tran_usd_rate").value;
            tran_usd_total = document.getElementById("tran_usd_total").value;
            tran_php_rate = document.getElementById("tran_php_rate").value;
            tran_php_total = document.getElementById("tran_php_total").value;
            tran_client_php_total = document.getElementById("tran_client_php_total").value;

            if (file_trans == "")
                {
                    $.ajax({
                    url: 'ajax.php',
                    type: 'POST',
                    async: false,
                    data:{
                        val_id:val_id,
                        tran_date:tran_date,
                        tran_method:tran_method,
                        tran_transaction_no:tran_transaction_no,
                        tran_amount:tran_amount,
                        tran_charge:tran_charge,
                        tran_charge_type:tran_charge_type,
                        tran_client_rate:tran_client_rate,
                        tran_currency:tran_currency,
                        tran_note:tran_note,
                        update_transaction:update_transaction,
                        file_attachment:file_trans,
                        tran_initial:tran_initial,
                        tran_usd_rate:tran_usd_rate,
                        tran_usd_total:tran_usd_total,
                        tran_php_rate:tran_php_rate,
                        tran_php_total:tran_php_total,
                        tran_client_php_total:tran_client_php_total,
                    },
                        success: function(data)
                        {
                            if(data == "success")
                            {
                                alert("Transaction Details Successfully Update!");
                                location.reload();
                            }
                        }
                    });
                }
            else
                {

                    tran_attachment = $('#tran_attachment');
                    file_attachment = tran_attachment.prop('files')[0];

                    formData = new FormData();
                    formData.append('val_id', val_id);
                    formData.append('tran_date', tran_date);
                    formData.append('tran_method', tran_method);
                    formData.append('tran_transaction_no', tran_transaction_no);
                    formData.append('tran_amount', tran_amount);
                    formData.append('tran_charge', tran_charge);
                    formData.append('tran_charge_type', tran_charge_type);
                    formData.append('tran_client_rate', tran_client_rate);
                    formData.append('tran_currency', tran_currency);
                    formData.append('tran_note', tran_note);
                    formData.append('file_attachment', file_attachment);
                    formData.append('tran_initial', tran_initial);
                    formData.append('tran_usd_rate', tran_usd_rate);
                    formData.append('tran_usd_total', tran_usd_total);
                    formData.append('tran_php_rate', tran_php_rate);
                    formData.append('tran_php_total', tran_php_total);
                    formData.append('tran_client_php_total', tran_client_php_total);
                    formData.append('val_attachment', val_attachment);
                    formData.append('update_transaction_with_picture', 1);

                     $.ajax({
                        url: 'ajax.php',
                        type: 'POST',
                        async: false,
                        data: formData,

                        contentType:false,
                        cache: false,
                        processData: false,
                            success: function(response)
                            {
                                if(response == "success")
                                {
                                    alert("Transaction Details Successfully Update!");
                                    location.reload();
                                }
                            }
                        });
                }
        }

        function currency_select(select)
        {
            currency_val = (select.options[select.selectedIndex].value); // get currency

            amount = document.getElementById("tran_amount");
            tran_charge = document.getElementById("tran_charge");
            tran_charge_type = document.getElementById("tran_charge_type");
            tran_client_rate = document.getElementById("tran_client_rate");
            tran_initial = document.getElementById("tran_initial");
            tran_usd_rate = document.getElementById("tran_usd_rate");
            tran_usd_total = document.getElementById("tran_usd_total");
            tran_php_rate = document.getElementById("tran_php_rate");
            tran_php_total = document.getElementById("tran_php_total");
            tran_client_php_total = document.getElementById("tran_client_php_total");

            // amount.readOnly = true;
            // tran_charge.readOnly = true;
            // tran_charge_type.disabled = true;
            // tran_client_rate.readOnly = true;
            <?php
                $currency_option = mysqli_query($conn, "SELECT * FROM finance_currency ORDER BY currency_name ASC");
                while($fetch = mysqli_fetch_array($currency_option))
                {
                    $currency_code = $fetch['currency_code'];
                    $currency_val_usd = $fetch['currency_val_usd'];
                    $currency_val_php = $fetch['currency_val_php'];
                    ?>
                    var code = "<?php echo $currency_code; ?>";
                    if(currency_val == code)
                    {
                        document.getElementById("tran_usd_rate").value = "<?php echo $currency_val_usd; ?>";
                        document.getElementById("tran_php_rate").value = "<?php echo $currency_val_php; ?>";

                        if(tran_charge_type.value == "PHP") // if charge type == PHP
                        {
                            if(code == "PHP")
                            {
                                tran_initial.value = (amount.value - tran_charge.value).toFixed(2);
                            }
                            else
                            {
                                tran_initial.value = (amount.value - (tran_charge.value / tran_php_rate.value)).toFixed(2);
                            }
                        }
                        else if(tran_charge_type.value == "USD")// else if charge type == USD
                        {
                            if(code == "USD")
                            {
                                tran_initial.value = (amount.value - tran_charge.value).toFixed(2);
                            }
                            else if(code == "PHP")
                            {
                                tran_initial.value = (amount.value - (tran_charge.value * tran_usd_rate.value)).toFixed(2);
                            }
                            else
                            {
                                tran_initial.value = (amount.value - (tran_charge.value / tran_usd_rate.value)).toFixed(2);
                            }
                        }
                        else
                        {
                            tran_initial.value = (amount.value - tran_charge.value).toFixed(2);
                        }

                        tran_client_php_total.value = (tran_initial.value * tran_client_rate.value).toFixed(2);
                        if(code == "PHP")
                        {
                            tran_usd_total.value = (tran_initial.value / tran_usd_rate.value).toFixed(2);
                            tran_php_total.value = (tran_initial.value * tran_php_rate.value).toFixed(2);
                        }
                        else
                        {
                            tran_usd_total.value = (tran_initial.value * tran_usd_rate.value).toFixed(2);
                            tran_php_total.value = (tran_initial.value * tran_php_rate.value).toFixed(2);
                        }
                    }
                    <?php
                }
            ?>
        }
    </script>
