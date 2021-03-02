<?php         
    if($filterby == "All")
    {                    
        $results = mysqli_query($conn, "$QUERY_PER_VIEW ORDER BY finance_transaction.val_date DESC");
    }
    else if($filterby == "Today")
    {
        $filter = date("Y-m-d");
        $results = mysqli_query($conn, "$QUERY_PER_VIEW WHERE finance_transaction.val_date LIKE '%$filter%' ORDER BY finance_transaction.val_date DESC");
    }
    else if($filterby == "This Week")
    {
        $dt = new DateTime();
        $dates = []; 
        for ($d = 1; $d <= 7; $d++) {
            $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
            $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
        }
        $from = current($dates); // monday
        $to = end($dates); // sunday
        $results = mysqli_query($conn, "$QUERY_PER_VIEW WHERE finance_transaction.val_date BETWEEN '$from' AND '$to' ORDER BY finance_transaction.val_date DESC");
    }
    else if($filterby == "This Month")
    {
        $filter = date("Y-m");
        $results = mysqli_query($conn, "$QUERY_PER_VIEW WHERE finance_transaction.val_date LIKE '%$filter%' ORDER BY finance_transaction.val_date DESC");
    }
    else if($filterby == "This Year")
    {
        $filter = date("Y");
        $results = mysqli_query($conn, "$QUERY_PER_VIEW WHERE finance_transaction.val_date LIKE '%$filter%' ORDER BY finance_transaction.val_date DESC");
    }
    else // Custom Date
    {                    
        $results = mysqli_query($conn, "$QUERY_PER_VIEW WHERE finance_transaction.val_date BETWEEN '$get_from' AND '$get_to' ORDER BY finance_transaction.val_date DESC");
    }
?>