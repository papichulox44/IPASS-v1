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
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full table-hover'.$table.'">
            <thead> 
                <tr>
                    <th class="d-none d-sm-table-cell">Name</th>
                    <th class="d-none d-sm-table-cell">DATE</th>
                    <th>Trans_no</th>
                    <th class="d-none d-sm-table-cell text-right">Total(USD)</th>
                    <th class="d-none d-sm-table-cell text-right">Total(PHP)</th>
                    <th class="text-right">Total(CLIENT)</th>
                </tr>
            </thead>
            <tbody>';
                $IPASS_total_USD = 0;
                $IPASS_total_PHP = 0;
                $CLIENT_total_PHP = 0;
                $QUERY_PER_VIEW = 'SELECT * FROM task INNER JOIN contact ON task.task_contact = contact.contact_id INNER JOIN finance_transaction ON finance_transaction.val_assign_to = task.task_id INNER JOIN finance_phase ON finance_transaction.val_phase_id = finance_phase.phase_id';
                include ('ajax_transaction_filter.php');
                while($rows = mysqli_fetch_array($results))
                {
                    $IPASS_total_USD += $rows['val_usd_total'];
                    $IPASS_total_PHP += $rows['val_php_total'];
                    $CLIENT_total_PHP += $rows['val_client_total'];
                    echo '
                    <tr class="hov_row" data-toggle="modal" data-target="#modal-large" onclick="hov_row(this.id)" id="hov_row'.$rows['val_id'].'">
                        <td class="d-none d-sm-table-cell">
                            '.$rows['contact_fname'].' '.$rows['contact_mname'].' '.$rows['contact_lname'].'
                        </td>
                        <td class="d-none d-sm-table-cell">
                            '.$rows['val_date'].'
                        </td>
                        <td>
                            '.$rows['val_transaction_no'].'
                        </td>
                        <td class="d-none d-sm-table-cell text-right">
                            '.number_format($rows['val_usd_total'],2).'
                        </td>
                        <td class="d-none d-sm-table-cell text-right">
                            '.number_format($rows['val_php_total'],2).'
                        </td>
                        <td class="text-right">
                            '.number_format($rows['val_client_total'],2).'
                        </td>
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