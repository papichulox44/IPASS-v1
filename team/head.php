    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>IPASS PROCESSING</title>

        <link rel="icon" type="image/png" sizes="192x192" href="../assets/media/photos/logo-ipass.png">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="../assets/css/codebase.min.css">
        <link rel="stylesheet" id="css-main" href="../assets/css/custom_style.css">
        <link rel="stylesheet" href="../assets/js/plugins/datatables/dataTables.bootstrap4.css">
    </head>
    <?php
        $user_id = $row['user_id'];
        $select_mode = mysqli_query($conn,"SELECT * FROM mode WHERE mode_user_id = '$user_id'");
        $fetch_mode = mysqli_fetch_array($select_mode);
        $mode_type = $fetch_mode['mode_type'];
        $count = mysqli_num_rows($select_mode); 
        $inverse = "";
        $body = "";
        if( $mode_type == "Dark") //insert
        { 
            $inverse = "sidebar-inverse";
            $body = "bg-primary-darker";
            $md_header = "bg-gray-darker";
            $md_ham = "text-white";
        }
        if($count == 0 || $mode_type == "Custom")
        {
            $inverse = "sidebar-inverse";
        }
    ?>