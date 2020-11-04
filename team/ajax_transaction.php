<?php
    session_start();
    include("../conn.php");
    // ----------------------- FETCH ALL TRANSACTION -----------------------
    if(isset($_POST['view_all_transaction']))
    {
        $md_mode = $_POST['md_mode'];
        $filterby = $_POST['filterby'];
        $view_by = $_POST['view_by'];

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
        <table class="table table-hover table-bordered table-striped table-vcenter js-dataTable-full '.$table.'">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th class="text-center">NAME</th>
                    <th class="text-center">Services</th>
                    <th class="text-center">Phase Name</th>
                    <th class="text-center">DATE</th>
                    <th class="text-center">REMITTANCE</th>
                    <th class="text-center">TRANSACTION NO</th>
                    <th class="text-center">CURRENCY</th>
                    <th class="text-center">CHARGE</th>
                    <th class="text-center">RATE UPC</th> 
                    <th class="text-center">AMOUNT (USD)</th>
                    <th class="text-center">AMOUNT (PHP)</th>
                    <th class="text-center">AMOUNT (PAID)</th>
                    <th class="text-center">TOTAL AMOUNT</th>
                    <th class="text-center">DEPOSIT</th>
                    <th class="text-center">BALANCE</th>
                    <th class="text-center">REMARKS</th>
                </tr>
            </thead>
            <tbody>
            ';
                $IPASS_total_USD = 0;
                $IPASS_total_PHP = 0;
                $CLIENT_total_PHP = 0;
                
            if (isset($filterby) or isset($get_from)) 
                {
                    if($filterby == "All")
                    {               
                        if ($view_by == 'All Remarks') {
                            $remarks = "";
                        }  
                        else if ($view_by == 'No Remarks') {
                            $remarks = "WHERE finance_transaction.val_remarks = ''";
                        }  
                        else {
                            $remarks = "WHERE finance_transaction.val_remarks = '$view_by'";
                        }

                        $results_total= mysqli_query($conn, "SELECT task.task_name, Sum(finance_transaction.val_usd_total) AS usd_total, Sum(finance_transaction.val_php_total) AS php_total, Sum(finance_transaction.val_client_total) AS client_total, finance_transaction.val_date FROM task INNER JOIN finance_transaction ON finance_transaction.val_assign_to = task.task_id GROUP BY task.task_name");

                        $results = mysqli_query($conn, "SELECT task.task_name, space.space_name, list.list_name, finance_phase.phase_name, finance_transaction.val_date, finance_transaction.val_method, finance_transaction.val_transaction_no, finance_transaction.val_currency, finance_transaction.val_charge, finance_transaction.val_amount, finance_transaction.val_initial_amount, finance_transaction.val_usd_rate, finance_transaction.val_usd_total, finance_transaction.val_php_rate, finance_transaction.val_php_total, finance_transaction.val_client_rate, finance_transaction.val_client_total, finance_remarks.remarks_value,finance_transaction.val_assign_to, finance_transaction.val_phase_id, finance_transaction.val_id, finance_transaction.val_remarks FROM finance_phase INNER JOIN finance_transaction ON finance_transaction.val_phase_id = finance_phase.phase_id INNER JOIN task ON finance_transaction.val_assign_to = task.task_id LEFT JOIN finance_remarks ON finance_remarks.remarks_phase_id = finance_transaction.val_phase_id AND finance_remarks.remarks_to = finance_transaction.val_assign_to INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id $remarks ORDER BY task.task_name ASC, finance_phase.phase_name ASC, list.list_name ASC");
                    }
                    else if($filterby == "This Week")
                    {
                        if ($view_by == 'All Remarks') {
                            $remarks = "";
                        }
                        else if ($view_by == 'No Remarks') {
                            $remarks = "WHERE finance_transaction.val_remarks = ''";
                        }  
                        else {
                            $remarks = "WHERE finance_transaction.val_remarks = '$view_by'";
                        }

                        $dt = new DateTime();
                        $dates = []; 
                        for ($d = 1; $d <= 7; $d++) {
                            $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                            $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
                        }
                        $from = current($dates); // monday
                        $to = end($dates); // sunday

                        $results_total= mysqli_query($conn, "SELECT task.task_name, Sum(finance_transaction.val_usd_total) AS usd_total, Sum(finance_transaction.val_php_total) AS php_total, Sum(finance_transaction.val_client_total) AS client_total, finance_transaction.val_date FROM task INNER JOIN finance_transaction ON finance_transaction.val_assign_to = task.task_id WHERE finance_transaction.val_date BETWEEN '$from' AND '$to' GROUP BY task.task_name");

                        $results = mysqli_query($conn, "SELECT task.task_name, space.space_name, list.list_name, finance_phase.phase_name, finance_transaction.val_date, finance_transaction.val_method, finance_transaction.val_transaction_no, finance_transaction.val_currency, finance_transaction.val_charge, finance_transaction.val_amount, finance_transaction.val_initial_amount, finance_transaction.val_usd_rate, finance_transaction.val_usd_total, finance_transaction.val_php_rate, finance_transaction.val_php_total, finance_transaction.val_client_rate, finance_transaction.val_client_total, finance_remarks.remarks_value,finance_transaction.val_assign_to, finance_transaction.val_phase_id, finance_transaction.val_id, finance_transaction.val_remarks FROM finance_phase INNER JOIN finance_transaction ON finance_transaction.val_phase_id = finance_phase.phase_id INNER JOIN task ON finance_transaction.val_assign_to = task.task_id LEFT JOIN finance_remarks ON finance_remarks.remarks_phase_id = finance_transaction.val_phase_id AND finance_remarks.remarks_to = finance_transaction.val_assign_to INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id $remarks AND finance_transaction.val_date BETWEEN '$from' AND '$to' ORDER BY task.task_name ASC, finance_phase.phase_name ASC, list.list_name ASC");

                    }
                    else if($filterby == "Custom Date")
                    {          
                        if ($view_by == 'All Remarks') {
                            $remarks = "";
                        }  
                        else if ($view_by == 'No Remarks') {
                            $remarks = "WHERE finance_transaction.val_remarks = ''";
                        }  
                        else {
                            $remarks = "WHERE finance_transaction.val_remarks = '$view_by'";
                        }

                        $results_total= mysqli_query($conn, "SELECT task.task_name, Sum(finance_transaction.val_usd_total) AS usd_total, Sum(finance_transaction.val_php_total) AS php_total, Sum(finance_transaction.val_client_total) AS client_total, finance_transaction.val_date FROM task INNER JOIN finance_transaction ON finance_transaction.val_assign_to = task.task_id WHERE finance_transaction.val_date BETWEEN '$get_from' AND '$get_to' GROUP BY task.task_name");

                        $results = mysqli_query($conn, "SELECT task.task_name, space.space_name, list.list_name, finance_phase.phase_name, finance_transaction.val_date, finance_transaction.val_method, finance_transaction.val_transaction_no, finance_transaction.val_currency, finance_transaction.val_charge, finance_transaction.val_amount, finance_transaction.val_initial_amount, finance_transaction.val_usd_rate, finance_transaction.val_usd_total, finance_transaction.val_php_rate, finance_transaction.val_php_total, finance_transaction.val_client_rate, finance_transaction.val_client_total, finance_remarks.remarks_value,finance_transaction.val_assign_to, finance_transaction.val_phase_id, finance_transaction.val_id, finance_transaction.val_remarks FROM finance_phase INNER JOIN finance_transaction ON finance_transaction.val_phase_id = finance_phase.phase_id INNER JOIN task ON finance_transaction.val_assign_to = task.task_id LEFT JOIN finance_remarks ON finance_remarks.remarks_phase_id = finance_transaction.val_phase_id AND finance_remarks.remarks_to = finance_transaction.val_assign_to INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id $remarks AND finance_transaction.val_date BETWEEN '$get_from' AND '$get_to' ORDER BY task.task_name ASC, finance_phase.phase_name ASC, list.list_name ASC");
                    }
                }

                // $results = mysqli_query($conn, "SELECT task.task_name, space.space_name, list.list_name, finance_phase.phase_name, finance_transaction.val_date, finance_transaction.val_method, finance_transaction.val_transaction_no, finance_transaction.val_currency, finance_transaction.val_charge, finance_transaction.val_amount, finance_transaction.val_initial_amount, finance_transaction.val_usd_rate, finance_transaction.val_usd_total, finance_transaction.val_php_rate, finance_transaction.val_php_total, finance_transaction.val_client_rate, finance_transaction.val_client_total, finance_remarks.remarks_value,finance_transaction.val_assign_to, finance_transaction.val_phase_id, finance_transaction.val_id FROM finance_phase INNER JOIN finance_transaction ON finance_transaction.val_phase_id = finance_phase.phase_id INNER JOIN task ON finance_transaction.val_assign_to = task.task_id LEFT JOIN finance_remarks ON finance_remarks.remarks_phase_id = finance_transaction.val_phase_id AND finance_remarks.remarks_to = finance_transaction.val_assign_to INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id ORDER BY task.task_name ASC, finance_phase.phase_name ASC, list.list_name ASC");

                $counts = '1';
                while($rows = mysqli_fetch_array($results))
                {   
                    $count = $counts++;
                    $task_id = $rows['val_assign_to'];
                    $phase_id = $rows['val_phase_id'];
                    // $remarks = $rows['remarks_value'];  
                    $remarks = $rows['val_remarks'];  
                    $val_id = $rows['val_id'];
                    echo '
                    <tr>
                        <td>'.$count.'</td>
                        <td style="font-weight: bold; cursor: pointer;" class="d-none d-sm-table-cell" class="text-left" onclick="transaction_details(this.id)" data-toggle="modal" data-target="#modal-trans-details" id="'.$rows['val_id'].'">
                            '.$rows['task_name'].'
                        </td>
                        <td style="font-weight: bold; cursor: pointer;" class="text-success" class="text-left" onclick="transaction_details(this.id)" data-toggle="modal" data-target="#modal-trans-details" id="'.$rows['val_id'].'">
                            '.$rows['space_name'].' ('.$rows['list_name'].')
                        </td>
                        <td style="font-weight: bold; cursor: pointer;" class="text-primary" class="text-left" onclick="transaction_details(this.id)" data-toggle="modal" data-target="#modal-trans-details" id="'.$rows['val_id'].'">
                            '.$rows['phase_name'].'
                        </td>
                        <td style="font-weight: bold;" class="text-center">
                            '.$rows['val_date'].'
                        </td>
                        <td style="font-weight: bold;" class="text-center">
                            '.$rows['val_method'].'
                        </td>
                        <td style="font-weight: bold;" class="text-center">
                            '.$rows['val_transaction_no'].'
                        </td>
                        <td style="font-weight: bold;" class="text-center">
                            '.$rows['val_currency'].'
                        </td>
                        <td style="font-weight: bold;" class="text-center">
                            '.$rows['val_charge'].'
                        </td>
                        <td style="font-weight: bold;" class="text-center">
                            '.'|'.$rows['val_usd_rate'].'|<br>|'.$rows['val_php_rate'].'|<br>|'.$rows['val_client_rate'].'
                        </td>
                        <td style="font-weight: bold;" class="text-center">
                            $'.number_format($rows['val_usd_total'],2).'
                        </td>
                        <td style="font-weight: bold;" class="text-center">
                            ₱'.number_format($rows['val_php_total'],2).'
                        </td>
                        <td style="font-weight: bold;" class="text-center">
                            ₱'.number_format($rows['val_client_total'],2).'
                        </td>';

                        $USD_tot = 0;
                        $PHP_tot = 0;
                        $PHP_tot_client = 0;
                        $total_client_amount = mysqli_query($conn, "SELECT Sum(finance_transaction.val_client_total) AS total_amount_client, Sum(finance_transaction.val_usd_total) AS total_usd, Sum(finance_transaction.val_php_total) AS total_php FROM finance_transaction WHERE val_phase_id = '$phase_id' AND val_assign_to = '$task_id'");
                        while($result = mysqli_fetch_array($total_client_amount))
                        {
                            $USD_tot = $result['total_usd'];
                            $PHP_tot = $result['total_php'];
                            $total_amount_client = $result['total_amount_client'];
                            echo '<td class="text-center">₱'.number_format($total_amount_client,2).'</td>';
                        }

                        // -------------------------------------------------------------------------
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

                        $USD_paid = $USD_tot;
                        $PHP_paid = $PHP_tot;
                        $PHP_paid_client = $total_amount_client;

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
                        echo '
                        <td style="font-weight: bold;" class="text-center">
                            ₱'.number_format($PHP_depo_client,2).'
                        </td>
                        <td style="font-weight: bold;" class="text-center">
                            ₱'.number_format($PHP_bal_client,2).'
                        </td>';
                        //Remarks value for each transaction
                        if (!empty($remarks)) {
                            $query = mysqli_query($conn, "SELECT * FROM tbl_remarks WHERE remarks_value LIKE '%$remarks%'") or die(mysqli_error());

                            while($data = mysqli_fetch_array($query)) {
                                echo '<td class="text-center" data-toggle="modal" data-target="#modal-remarks" style="background-color: '.$data['remarks_color'].'; cursor: pointer;" id="'.$phase_id.','.$task_id.','.$remarks.','.$val_id.'" onclick="update_remarks(this.id)">'.$remarks.'
                                </td>';
                            }
                            // if ($remarks == 'Payment received') {
                            //     $color = 'green';
                            // }
                            // if ($remarks == 'On hold') {
                            //     $color = '#c7c10c';
                            // }
                            // if ($remarks == 'Pending') {
                            //     $color = '#b4c04c';
                            // }
                            // if ($remarks == 'Waiting to be received') {
                            //     $color = 'blue';
                            // }
                            // if ($remarks == 'Refunded') {
                            //     $color = '#1db394';
                            // }
                            // if ($remarks == 'Payment encoded') {
                            //     $color = '#45A4AB';
                            // }
                            // echo '<td class="text-center" data-toggle="modal" data-target="#modal-remarks" style="background-color: '.$color.'; cursor: pointer;" id="'.$phase_id.','.$task_id.','.$remarks.','.$val_id.'" onclick="update_remarks(this.id)">'.$remarks.'
                            // </td>';
                        }
                        else {
                            echo '<td class="text-center" data-toggle="modal" data-target="#modal-remarks" style="background-color: red; cursor: pointer;" id="'.$phase_id.','.$task_id.',No Remarks,'.$val_id.'" onclick="update_remarks(this.id)">No Remarks</td>';
                        }
                        echo '
                    </tr>'; 
                }
                
                while($rows = mysqli_fetch_array($results_total))
                { 
                    $IPASS_total_USD += $rows['usd_total'];
                    $IPASS_total_PHP += $rows['php_total'];
                    $CLIENT_total_PHP += $rows['client_total'];
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
                    <div class="font-size-h3 font-w600 '.$text2.' text-right">$'.number_format($IPASS_total_USD,2).'</div>
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

    //Remarks Content
    if (isset($_POST['update_remarks'])) {

        $phase_id = $_POST['phase_id'];
        $task_id = $_POST['task_id'];
        // $remarks = $_POST['remarks'];
        $user_id = $_POST['user_id'];
        $val_id = $_POST['val_id'];

        $total_usd_amount = 0;
        if ($_POST['remarks'] == 'No Remarks') {
            $remarks = 'No Remarks';
        } else {
            $remarks = $_POST['remarks'];
        }

        $update_remarks = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_phase_id = '$phase_id' ORDER BY finance_order") or die(mysqli_error());

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

        echo '
            <p>Remark Status: <b>'.$remarks.'</b></p>
            <select class="form-control text-muted" id="update_remarks_selected" onchange="update_remarks_selected(this)">
                <option disabled value="" selected>Select Remarks</option>';
                $query = mysqli_query($conn, "SELECT * FROM tbl_remarks") or die(mysqli_error());

                while($data = mysqli_fetch_array($query)) {
                    echo '<option value="'.$data['remarks_value'].'">'.$data['remarks_value'].'</option>';
                }
                // <option value="Payment received">Payment received</option>
                // <option value="Payment encoded">Payment encoded</option>
                // <option value="On hold">On hold</option>
                // <option value="Pending">Pending</option>
                // <option value="Waiting to be received">Waiting to be received</option>
                // <option value="Refunded">Refunded</option>
                echo '
            </select>
            <input id="val_id" type="hidden" value="'.$val_id.'"></input>
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
                        <td class="text-right">'.$data['finance_currency'].'</td>';
                        $select_ca = mysqli_query($conn, "SELECT * FROM finance_field_ca WHERE custom_amount_task_id = '$task_id' and custom_amount_field_id = '$finance_id'") or die(mysqli_error());
                        $row_ca = mysqli_num_rows($select_ca);
                        $ca_amount = 0;
                        if ($row_ca)
                        {
                          while($fetch_custom_amount = mysqli_fetch_array($select_ca))
                          {
                            $ca_amount = 0;
                            $ca_amount = $fetch_custom_amount['custom_amount_value'];
                            echo '<td><center><input class="form-control" style="width: 90px;" type="text" id="amount_usd'.$phase_id.','.$task_id.','.$remarks.','.$data['finance_id'].','.$user_id.'" value="'.$fetch_custom_amount['custom_amount_value'].'"></center></td>';
                          }
                        }
                        else
                        {
                          echo '<td><center><input class="form-control" style="width: 90px;" type="text" id="amount_usd'.$phase_id.','.$task_id.','.$remarks.','.$data['finance_id'].','.$user_id.'" value="'.$data['finance_value'].'"></center></td>';
                        }
                        echo '
                        <td class="text-center"><button class="btn btn-success" type="button" id="'.$phase_id.','.$task_id.','.$remarks.','.$data['finance_id'].','.$user_id.'" onclick="update_amount_usd(this.id)">Update</button</td>
                    <tr
                    ';
                }
                echo '
                </tr>
                    <td class="table-success text-right font-w600" colspan="5">Total Amount: '.number_format($total_amount,2).'</td>
                </tr>
                </tbody>
            </table>
            ';


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
                        $finance_val_id = $rows['val_id'];
                        $val_remarks = $rows['val_remarks'];
                        if ($val_id == $finance_val_id) {

                            $query_remarks = mysqli_query($conn, "SELECT * FROM tbl_remarks WHERE remarks_value = '$val_remarks'");
                            $num = mysqli_num_rows($query_remarks);
                            if ($num) {
                                while($row = mysqli_fetch_array($query_remarks))
                                {   
                                    $color = $row["remarks_color"];
                                    $text = 'text-white';
                                }
                            } else {
                                    $color = 'red';
                                    $text = 'text-white';
                                
                            // $table = 'class="table-info"';
                            // if ($_POST['remarks'] == 'Payment received') {
                            //     $color = 'green';
                            //     $text = 'text-white';
                            // }
                            // if ($_POST['remarks'] == 'On hold') {
                            //     $color = '#c7c10c';
                            //     $text = 'text-white';
                            // }
                            // if ($_POST['remarks'] == 'Pending') {
                            //     $color = '#b4c04c';
                            //     $text = 'text-white';
                            // }
                            // if ($_POST['remarks'] == 'Waiting to be received') {
                            //     $color = 'blue';
                            //     $text = 'text-white';
                            // }
                            // if ($_POST['remarks'] == 'Refunded') {
                            //     $color = '#1db394';
                            //     $text = 'text-white';
                            // }
                            // if ($_POST['remarks'] == 'Payment encoded') {
                            //     $color = '#45A4AB';
                            //     $text = 'text-white';
                            // }
                            // if ($_POST['remarks'] == 'No Remarks') {
                            //     $color = 'red';
                            //     $text = 'text-white';
                            // }
                            }
                        } else {
                            $color = '';
                            $text = '';
                        }
                        echo '
                        <tr style="background-color:'.$color.'" class="'.$text.'">
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

        echo '
            <p>Remark Status: <b>No Remarks</b></p>
            <select class="form-control text-muted" id="add_remarks_selected" onchange="add_remarks_selected(this)">
                <option disabled value="" selected>Select Remarks</option>
                <option value="Payment received">Payment received</option>
                <option value="Payment encoded">Payment encoded</option>
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
                    <th class="text-center">Amount(USD)</th>
                    <th class="text-center">Action</th>
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
                        <td class="text-center"><button type="button" class="btn btn-sm btn-secondary" id="'.$phase_id.','.$task_id.',No Remarks,'.$data['finance_id'].','.$user_id.'" onclick="hide_show(this.id)"><i class="fa fa-eye-slash"></i>
                        </button></td>
                        <td>'.$data['finance_name'].'</td>
                        <td class="text-right">'.$data['finance_currency'].'</td>';
                        $select_ca = mysqli_query($conn, "SELECT * FROM finance_field_ca WHERE custom_amount_task_id = '$task_id' and custom_amount_field_id = '$finance_id'") or die(mysqli_error());
                        $row_ca = mysqli_num_rows($select_ca);
                        if ($row_ca)
                        {
                          while($fetch_custom_amount = mysqli_fetch_array($select_ca))
                          {
                            echo '<td><center><input class="form-control" style="width: 90px;" type="text" id="amount_usd'.$phase_id.','.$task_id.',No Remarks,'.$data['finance_id'].','.$user_id.'" value="'.$fetch_custom_amount['custom_amount_value'].'"></center></td>';
                          }
                        }
                        else
                        {
                          echo '<td><center><input class="form-control" style="width: 90px;" type="text" id="amount_usd'.$phase_id.','.$task_id.',No Remarks,'.$data['finance_id'].','.$user_id.'" value="'.$data['finance_value'].'"></center></td>';
                        }
                        echo '
                        <td class="text-center"><button class="btn btn-success" type="button" id="'.$phase_id.','.$task_id.',No Remarks,'.$data['finance_id'].','.$user_id.'" onclick="update_amount_usd(this.id)">Update</button</td>
                    <tr
                    ';
                }
                // <td id="amount_usd" style="cursor: pointer;" class="text-right" contenteditable="true">'.$data['finance_value'].'</td>

                echo '
                </tr>
                    <td class="table-success text-right font-w600" colspan="5">Total Amount: '.number_format($total_amount,2).'</td>
                </tr>
                </tbody>
            </table>
            ';

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

        $val_id = $_POST['val_id'];
        // $task_id = $_POST['task_id'];
        $remarks_value = $_POST['remarks_value'];

        $update_remarks = mysqli_query($conn, "UPDATE finance_transaction SET val_remarks = '$remarks_value' WHERE val_id = $val_id") or die(mysqli_error());

    }
    //End Update Remarks Content

    //Add Remarks Content
    if (isset($_POST['add_remarks_selected'])) {

        $phase_id = $_POST['phase_id'];
        $task_id = $_POST['task_id'];
        $user_id = $_POST['user_id'];
        $remarks_value = $_POST['remarks_value'];

        // echo $remarks_value;
        $update_remarks = mysqli_query($conn, "INSERT INTO finance_remarks values ('', '$user_id', '$task_id', '$phase_id', '$remarks_value','','')") or die(mysqli_error());

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
                $query_delete = mysqli_query($conn, "DELETE from finance_field_hide WHERE hideshow_task_id = '$task_id' and hideshow_field_id = '$field_id'") or die(mysqli_error());
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
    if (isset($_POST['update_amount_usd'])) {

        $user_id = $_POST['user_id'];
        $task_id = $_POST['task_id'];
        $field_id = $_POST['field_id'];
        $amount_usd = $_POST['amount_usd'];

        $query_update_amount_usd = mysqli_query($conn, "SELECT * FROM finance_field_ca WHERE custom_amount_task_id = '$task_id' and custom_amount_field_id = '$field_id'") or die(mysqli_error());
        $row = mysqli_num_rows($query_update_amount_usd);

        if ($row)
            {
                $query_update = mysqli_query($conn, "UPDATE finance_field_ca SET custom_amount_value = '$amount_usd' WHERE custom_amount_task_id = '$task_id' and custom_amount_field_id = '$field_id'") or die(mysqli_error());
            }
        else
            {
                $query_insert = mysqli_query($conn, "INSERT INTO finance_field_ca values ('', '$user_id', '$task_id', '$field_id','$amount_usd')") or die(mysqli_error());
            }
    }
    //End update/add amount_usd in finance_field_ca

    // ----------------------- MODAL PER TRANSACTION -----------------------
    if(isset($_POST['fetch_per_transaction']))
    {
        $val_id = $_POST['transaction_id'];
        $select_fetch_id = mysqli_query($conn, "SELECT * FROM finance_transaction LEFT JOIN finance_discount ON val_phase_id = discount_phase_id AND finance_transaction.val_assign_to = finance_discount.discount_assign_to WHERE val_id = '$val_id'");
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
                            <input type="hidden" class="form-control text-center" id="phase_id" readonly value="<?php echo $fetch_col_name['val_phase_id']; ?>">
                            <input type="hidden" class="form-control text-center" id="task_id" readonly value="<?php echo $fetch_col_name['val_assign_to']; ?>">
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
                                        <?php 
                                        $select_remittance = mysqli_query($conn, "SELECT * FROM tbl_remittance");
                                        while ($data = mysqli_fetch_array($select_remittance)) {
                                            echo '<option value="'.$data['remit_value'].'"'; if($fetch_col_name['val_method'] == $data['remit_value']) { echo 'selected="selected"'; } echo '>'.$data['remit_name'].'</option>';
                                        }
                                         ?>
                                        <!-- <option></option>
                                        <option value="BDO PI" <?php if($fetch_col_name['val_method'] == "BDO PI") echo 'selected="selected"'; ?> >BANCO DE ORO (PESO Account) - IPASS</option>
                                        <option value="BDO DI" <?php if($fetch_col_name['val_method'] == "BDO DI") echo 'selected="selected"'; ?> >BANCO DE ORO (DOLLAR Account) - IPASS</option>
                                        <option value="BDO PJ" <?php if($fetch_col_name['val_method'] == "BDO PJ") echo 'selected="selected"'; ?> >BANCO DE ORO (PESO Account) - Joyce O. Parungao</option>
                                        <option value="BDO DJ" <?php if($fetch_col_name['val_method'] == "BDO DJ") echo 'selected="selected"'; ?> >BANCO DE ORO (DOLLAR Account) - Joyce O. Parungao</option>
                                        <option value="BPI P">BPI Savings (PESO Account)</option>
                                        <option value="BPI D">BPI Dollar Account</option>
                                        <option value="PAL. PAWN.">Palawan Pawnshop</option>
                                        <option value="ML">MLhuillier</option>
                                        <option value="PP">Paypal</option> -->
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
                <div class="col-md-10">
                    <input type="hidden" class="form-control" id="val_attachment" readonly value="<?php echo $fetch_col_name['val_attachment']; ?>">
                    <div style="overflow-y:scroll; height: 500px;" class="main dragscroll">
                        <img id="map" src="../assets/media/transaction/<?php echo $fetch_col_name['val_attachment']; ?>" style="width: 100%">
                    </div>
                </div>
                <div class="col-md-2">
                     <div id="navbar">
                        <button class="btn btn-success" type="button" onclick="zoomin()">Zoom In</button>
                        <button style="margin-top: 5px;" class="btn btn-danger" type="button" onclick="zoomout()">Zoom Out</button>
                        <button style="margin-top: 5px;" class="btn btn-primary" type="button" onclick="rotateImage()">Rotate</button>
                      </div>
                </div>
            </div>
            <script type="text/javascript" src="https://cdn.rawgit.com/asvd/dragscroll/master/dragscroll.js">   
            </script>
        <?php
    }
    // ----------------------- END MODAL PER TRANSACTION --------------------------

    if (isset($_POST['view_remittance'])) {
        
        echo '
        
        <div class="col-lg-12" style="overflow: auto; height: 877px;">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-white">
                    <tr>
                        <th class="text-right">Add Remittance:</th>
                        <th class="text-center"><input class="text-center form-control" placeholder="Remittance Value" id="add_remittance_value"></input></th>
                        <th class="text-center"><input class="text-center form-control" placeholder="Remittance Name" id="add_remittance_name"></input></th>
                        <th class="text-center"><button class="btn btn-primary" onclick="add_remittance()">Add</button></th>
                    </tr>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-white">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th class="text-center">Remittance Value</th>
                        <th class="text-center">Remittance Name</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                    <tbody>';
                        $select_remittance = mysqli_query($conn, "SELECT * FROM tbl_remittance ORDER BY remit_value");
                        $count = 1;
                        while ($data = mysqli_fetch_array($select_remittance)) {
                            $remit_id = $data['remit_id'];
                            echo '
                                <tr style="cursor: pointer;">
                                    <td class="text-left">'.$count++.'</td>
                                    <td class="text-center">'.$data['remit_value'].'</td>
                                    <td class="text-center">
                                    <textarea rows="2" class="form-control text-center" id="remit_name'.$remit_id.'">'.$data['remit_name'].'</textarea>
                                    </td>
                                    <td class="text-center"><button class="btn btn-success" id="'.$remit_id.'" onclick="update_remittance(this.id)">Update</button>
                                        <button class="btn btn-danger" id="'.$remit_id.'" onclick="delete_remittance(this.id)">Delete</button>
                                    </td>
                                </tr>
                            ';       
                        }
                    echo '
                    </tbody>
                </table>
            </div>
        </div>
        ';
    }

    if (isset($_POST['view_company_information'])) {
        
        echo '
            <div class="table-responsive" style="overflow: auto; height: 250px;">
                <table class="table table-bordered table-striped text-white">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th class="text-center">Title Content</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                    <tbody>';
                        $select_information = mysqli_query($conn, "SELECT * FROM tbl_information ORDER BY info_id");
                        $row = mysqli_num_rows($select_information);
                        $count = 1;
                        if ($row) {
                            while ($data = mysqli_fetch_array($select_information)) {
                                $info_id = $data['info_id'];
                                $info_status = $data['info_status'];
                                echo '
                                    <tr style="cursor: pointer;">
                                        <td class="text-left">'.$count++.'</td>
                                        <td class="text-center">'.$data['info_title'].'</td>
                                        ';
                                        if ($info_status == 0) {
                                            echo '
                                            <td class="text-center"><span class="badge badge-warning">Hide in Client Portal</span></td>
                                            ';
                                        } else {
                                            echo '
                                            <td class="text-center"><span class="badge badge-success">Show in Client Portal</span></td>
                                            ';
                                        }
                                        echo '
                                        <td class="text-center"><button class="btn btn-primary" data-toggle="modal" data-target="#modal-information-update" id="'.$info_id.'" onclick="update_information(this.id)">View</button>
                                            <button class="btn btn-danger" id="'.$info_id.'" onclick="delete_information(this.id)">Delete</button>
                                        </td>
                                    </tr>
                                ';       
                            }
                        }
                        else
                        {
                            echo '
                                <tr style="cursor: pointer;">
                                    <td colspan="4" class="text-center">No Records..</td>
                                </tr>
                            ';
                        }
                    echo '
                    </tbody>
                </table>
            </div>
        ';
    }

    // All query for list of email ------------------------------------------------------------------------------------------------------
    if (isset($_POST['view_list_of_email'])) {
        if (isset($_SESSION['set_email'])) {
            $set_email = $_SESSION['set_email'];
        } else {
            $set_email = '';
        }
        echo '
        <div class="col-lg-12" style="overflow: auto; height: 500px;">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-white">
                    <tr>
                        <th class="text-right">Add Email:</th>
                        <th class="text-center"><input type="email" class="text-center form-control" placeholder="Email Name" id="add_email_value"></input></th>
                        <th class="text-center"><button class="btn btn-primary" onclick="add_email()">Add</button></th>
                    </tr>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-white">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                    <tbody>';
                        $select_remittance = mysqli_query($conn, "SELECT * FROM tbl_list_email ORDER BY list_email_name");
                        $count = 1;
                        while ($data = mysqli_fetch_array($select_remittance)) {
                            $list_email_id = $data['list_email_id'];
                            echo '
                                <tr style="cursor: pointer;">
                                    <td class="text-left">'.$count++.'</td>
                                    <td class="text-center">
                                    <textarea rows="2" class="form-control text-center" id="list_email_name'.$list_email_id.'">'.$data['list_email_name'].'</textarea>
                                    </td>
                                    <td class="text-center"><button class="btn btn-success" id="'.$list_email_id.'" onclick="update_list_of_email(this.id)">Update</button>
                                        <button class="btn btn-danger" id="'.$list_email_id.'" onclick="delete_list_of_email(this.id)">Delete</button>
                                    </td>
                                </tr>
                            ';       
                        }
                    echo '
                    </tbody>
                </table>
            </div>
        </div>
        ';
    }

    if (isset($_POST['view_list_of_email_member'])) {
        if (isset($_SESSION['set_email'])) {
            $set_email = $_SESSION['set_email'];
        } else {
            $set_email = '';
        }
        echo '
        <div class="col-lg-12" style="overflow: auto; height: 500px;">
        <label>Email: '.$set_email.'</label>
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-white">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                    <tbody>';
                        $select_remittance = mysqli_query($conn, "SELECT * FROM tbl_list_email ORDER BY list_email_name");
                        $count = 1;
                        while ($data = mysqli_fetch_array($select_remittance)) {
                            $list_email_id = $data['list_email_id'];
                            echo '
                                <tr style="cursor: pointer;">
                                    <td class="text-left">'.$count++.'</td>
                                    <td class="text-center">
                                    <textarea readonly rows="2" class="form-control text-center" id="list_email_name'.$list_email_id.'">'.$data['list_email_name'].'</textarea>
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-primary" id="'.$data['list_email_name'].'" onclick="set_list_of_email_member(this.id)">Set Email</button>
                                    </td>
                                </tr>
                            ';       
                        }
                    echo '
                    </tbody>
                </table>
            </div>
        </div>
        ';
    }

    if (isset($_POST['add_email'])) {

        $add_email_value = $_POST['add_email_value'];

        $add_email = mysqli_query($conn, "INSERT INTO tbl_list_email VALUES ('', '$add_email_value')") or die(mysqli_error());
        if ($add_email) {
            echo 'success';
        }
        mysqli_close($conn);
    }

    if (isset($_POST['delete_list_of_email'])) {

        $list_of_email_id = $_POST['list_of_email_id'];

        $delete_email = mysqli_query($conn, "DELETE from tbl_list_email WHERE list_email_id = '$list_of_email_id'") or die(mysqli_error());
        if ($delete_email) {
            echo 'success';
        }
        mysqli_close($conn);
    }

     if (isset($_POST['update_list_of_email'])) {

        $list_email_id = $_POST['list_email_id'];
        $list_email_name = $_POST['list_email_name'];

        $update_email = mysqli_query($conn, "UPDATE tbl_list_email SET list_email_name = '$list_email_name' WHERE list_email_id = '$list_email_id'") or die(mysqli_error());
        if ($update_email) {
            echo 'success';
        }
        mysqli_close($conn);
    }

    if (isset($_POST['set_list_of_email'])) {

        $_SESSION['set_email'] = $_POST['set_email'];

        // echo $_SESSION['set_email'];
        if ($_SESSION['set_email']) {
            echo 'success';
        }
        mysqli_close($conn);
    }
    //END All query for list of email ------------------------------------------------------------------------------------------------------

    // All query for list of remarks --------------------------------------------------------------------------------------------------------
    if (isset($_POST['view_list_of_remarks'])) {

        echo '
        <div class="col-lg-12" style="overflow: auto; height: 500px;">
            <div class="table-responsive">
                <table class="table table-bordered table-striped text-white">
                    <tr>
                        <th class="text-right">Add Remarks:</th>
                        <th class="text-center"><input type="email" class="text-center form-control" placeholder="Remarks" id="add_remarks_value"></input></th>
                        <th class="text-center"><input type="color" class="text-center form-control" id="add_color"></input></th>
                        <th class="text-center"><button class="btn btn-primary" onclick="add_remarks_data()">Add</button></th>
                    </tr>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped text-white">
                <thead>
                    <tr>
                        <th>NO.</th>
                        <th class="text-center">Remarks</th>
                        <th class="text-center">Color</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                    <tbody>';
                        $select_remittance = mysqli_query($conn, "SELECT * FROM tbl_remarks");
                        $count = 1;
                        while ($data = mysqli_fetch_array($select_remittance)) {
                            $remarks_id = $data['remarks_id'];
                            echo '
                                <tr style="cursor: pointer;">
                                    <td class="text-left">'.$count++.'</td>
                                    <td class="text-center">
                                    <textarea rows="2" class="form-control text-center" id="list_remarks_value'.$remarks_id.'">'.$data['remarks_value'].'</textarea>
                                    </td>
                                    <td class="text-left"><input type="color" class="form-control" id="remakrs_color'.$remarks_id.'" value="'.$data['remarks_color'].'"></input></td>
                                    <td class="text-center"><button class="btn btn-success" id="'.$remarks_id.'" onclick="update_list_remarks_value(this.id)">Update</button>
                                        <button class="btn btn-danger" id="'.$remarks_id.'" onclick="delete_remarks_data(this.id)">Delete</button>
                                    </td>
                                </tr>
                            ';       
                        }
                    echo '
                    </tbody>
                </table>
            </div>
        </div>
        ';
        mysqli_close($conn);
    }

    if (isset($_POST['add_remarks_data'])) {

        $add_remarks_value = $_POST['add_remarks_value'];
        $add_color = $_POST['add_color'];

        $add_remarks = mysqli_query($conn, "INSERT INTO tbl_remarks VALUES ('', '$add_remarks_value','$add_color')") or die(mysqli_error());
        if ($add_remarks) {
            echo 'success';
        }
        mysqli_close($conn);
    }

    if (isset($_POST['delete_remarks_data'])) {

        $remarks_id = $_POST['remarks_id'];

        $delete_email = mysqli_query($conn, "DELETE from tbl_remarks WHERE remarks_id = '$remarks_id'") or die(mysqli_error());
        if ($delete_email) {
            echo 'success';
        }
        mysqli_close($conn);
    }

    if (isset($_POST['update_list_remarks_value'])) {

        $remarks_id = $_POST['remarks_id'];
        $list_remarks_value = $_POST['list_remarks_value'];
        $remarks_color = $_POST['remarks_color'];

        $update_remarks = mysqli_query($conn, "UPDATE tbl_remarks SET remarks_value = '$list_remarks_value', remarks_color = '$remarks_color' WHERE remarks_id = '$remarks_id'") or die(mysqli_error());
        if ($update_remarks) {
            echo 'success';
        }
        mysqli_close($conn);
    }

    //END All query for list of remarks --------------------------------------------------------------------------------------------------------

    if (isset($_POST['update_remittance'])) {

        $remit_id = $_POST['remit_id'];
        $remit_name = $_POST['remit_name'];

        $update_remittance = mysqli_query($conn, "UPDATE tbl_remittance SET remit_name = '$remit_name' WHERE remit_id = '$remit_id'") or die(mysqli_error());
        if ($update_remittance) {
            echo 'success';
        }
        mysqli_close($conn);
    }

    if (isset($_POST['add_remittance'])) {

        $add_remittance_value = $_POST['add_remittance_value'];
        $add_remittance_name = $_POST['add_remittance_name'];

        $add_remittance = mysqli_query($conn, "INSERT INTO tbl_remittance VALUES ('', '$add_remittance_value', '$add_remittance_name')") or die(mysqli_error());
        if ($add_remittance) {
            echo 'success';
        }
        mysqli_close($conn);
    }
    if (isset($_POST['delete_remittance'])) {

        $remit_id = $_POST['remit_id'];

        $delete_remittance = mysqli_query($conn, "DELETE from tbl_remittance WHERE remit_id = '$remit_id'") or die(mysqli_error());
        if ($delete_remittance) {
            echo 'success';
        }
        mysqli_close($conn);
    }

    if(isset($_POST['save_company_information']))
    {
        $info_title = $_POST['info_title'];
        $info_text = $_POST['info_text'];
        $info_status = $_POST['info_status'];

        if (isset($_POST['info_image'])) {
            $info_image = $_POST['info_image'];

            $attachment_name = $_FILES['file_attachment']['name'];
            $attachment_temp = $_FILES['file_attachment']['tmp_name'];
            $attachment_size = $_FILES['file_attachment']['size'];
            $exp = explode(".", $attachment_name);
            $ext = end($exp);
            $allowed_ext = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');
                if(in_array($ext, $allowed_ext)) // check the file extension
                {
                    date_default_timezone_set('Asia/Manila');
                    //$todays_date = date("y-m-d H:i:sa"); //  original format
                    $date = date("His"); // for unique file name

                    $words = explode(' ',trim($attachment_name)); // convert name to array
                    $get_name = substr($words[0], 0, 6); // get only 6 character of the name

                    $image = $date.'-'.$get_name.'.'.$ext;
                    $location = "../assets/media/information/".$image; // upload location

                    if($attachment_size < 3000000) // Maximum 3 MB
                    {
                        // unlink('../assets/media/transaction/'.$info_image);
                        move_uploaded_file($attachment_temp, $location);
                        $save_data = mysqli_query($conn, "INSERT into tbl_information values ('', '$info_title', '$info_text', '$image' , '$info_status', '')") or die(mysqli_error());
                        $info_id = $conn->insert_id;

                        $query_contact = mysqli_query($conn,"SELECT * FROM contact") or die(mysqli_error());
                            while($rows = mysqli_fetch_array($query_contact))
                                {
                                    $contact_id = $rows['contact_id'];
                                    $insert_noti = mysqli_query($conn,"INSERT INTO tbl_information_noti (info_id, contact_id) VALUES ($info_id, $contact_id)") or die(mysqli_error());
                                }
                        if ($save_data) {
                            echo "success";
                        }
                    }
                }
        }
        else
        {
            // echo $info_text;
            $insert = mysqli_query($conn,"INSERT INTO tbl_information (info_title, info_text, info_status) values ('$info_title', '$info_text', '$info_status')") or die(mysqli_error());
            $info_id = $conn->insert_id;

            $query_contact = mysqli_query($conn,"SELECT * FROM contact") or die(mysqli_error());
                while($rows = mysqli_fetch_array($query_contact))
                    {
                        $contact_id = $rows['contact_id'];
                        $insert_noti = mysqli_query($conn,"INSERT INTO tbl_information_noti (info_id, contact_id) VALUES ($info_id, $contact_id)") or die(mysqli_error());
                    }
            if ($insert) {
                echo "success";
                // echo $info_id;
            }
            
        }
    }

    if(isset($_POST['update_company_information']))
    {
        $info_title = $_POST['info_title'];
        $info_text = $_POST['info_text'];
        $info_status = $_POST['info_status'];
        $info_id = $_POST['info_id'];

        if (isset($_POST['info_image'])) {
            $info_image = $_POST['info_image'];
            $unlink_image = $_POST['unlink_image'];-
            // $_FILES['file_attachment'] = $_POST['file_attachment'];

            $attachment_name = $_FILES['file_attachment']['name'];
            $attachment_temp = $_FILES['file_attachment']['tmp_name'];
            $attachment_size = $_FILES['file_attachment']['size'];
            $exp = explode(".", $attachment_name);
            $ext = end($exp);
            $allowed_ext = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');
                if(in_array($ext, $allowed_ext)) // check the file extension
                {
                    date_default_timezone_set('Asia/Manila');
                    //$todays_date = date("y-m-d H:i:sa"); //  original format
                    $date = date("His"); // for unique file name

                    $words = explode(' ',trim($attachment_name)); // convert name to array
                    $get_name = substr($words[0], 0, 6); // get only 6 character of the name

                    $image = $date.'-'.$get_name.'.'.$ext;
                    
                    $location = "../assets/media/information/".$image; // upload location

                    if($attachment_size < 3000000) // Maximum 3 MB
                    {
                        unlink("../assets/media/information/".$unlink_image);
                        move_uploaded_file($attachment_temp, $location);
                        $save_data = mysqli_query($conn, "UPDATE tbl_information set info_title = ' $info_title', info_text = '$info_text', info_image = '$image', info_status = '$info_status' WHERE info_id = '$info_id'") or die(mysqli_error());
                        if ($save_data) {
                            echo "success";
                        }
                    }
                }
        }
        else
        {
            mysqli_query($conn,"UPDATE tbl_information set info_title = ' $info_title', info_text = '$info_text', info_status = '$info_status' WHERE info_id = '$info_id'") or die(mysqli_error());
            echo "success";
        }
    }

    if (isset($_POST['delete_information'])) {

        $info_id = $_POST['info_id'];

        $delete_remittance = mysqli_query($conn, "DELETE from tbl_information WHERE info_id = '$info_id'") or die(mysqli_error());
        if ($delete_remittance) {
            echo 'success';
        }
        mysqli_close($conn);
    }

    if (isset($_POST['update_information'])) {

        $info_id = $_POST['info_id'];

        $query = mysqli_query($conn, "SELECT * FROM tbl_information WHERE info_id = '$info_id'") or die(mysqli_error());
        while ($data = mysqli_fetch_array($query)) {
            echo '
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="wizard-simple-firstname">Title:</label>
                            <input type="text" class="form-control" id="info_title_update" value="'.$data['info_title'].'">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="wizard-simple-firstname">Content:</label>
                            <textarea rows="15" class="form-control" id="info_text_update">'.$data['info_text'].'</textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="wizard-simple-firstname">Status:</label>
                            <select id="info_status_update" class="form-control">
                                <option selected="" disabled=""> Select Status</option>
                                <option ';

                                if ($data['info_status'] == 0) {
                                    echo 'selected';
                                }
                                echo ' value="0">Hide in Client Portal</option>
                                <option ';

                                if ($data['info_status'] == 1) {
                                    echo 'selected';
                                }
                                echo ' value="1">Show in Client Portal</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="file" id="info_image_update">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <img style="height: auto; width: 100%;" src="../assets/media/information/'.$data['info_image'].'">
                            <input type="hidden" class="form-control" id="unlink_image" value="'.$data['info_image'].'">
                            <input type="hidden" class="form-control" id="info_id" value="'.$info_id.'">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-dark">
                <button type="button" class="btn btn-noborder bg-primary btn-block text-white" onclick="update_information_company()">
                    <i class="fa fa-check"></i> Update
                </button>
            </div>
            ';
        }
        mysqli_close($conn);
    }
?>
