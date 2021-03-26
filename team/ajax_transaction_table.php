<?php
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
        $query = mysqli_query($conn, "SELECT * FROM tbl_remarks WHERE remarks_value = '$remarks'") or die(mysqli_error());

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
 ?>
