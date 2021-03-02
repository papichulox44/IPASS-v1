<link rel="stylesheet" href="../assets/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
<?php
    include("../conn.php");
    if(isset($_POST['fetch']))
    {
        $id = $_POST['edit_field_id'];
        $select = mysqli_query($conn, "SELECT * FROM child WHERE child_field_id = '$id' ORDER BY child_order ASC");
        while($rows = mysqli_fetch_array($select))
        {
            echo'<div class="input-group row" style="margin: 5px -20px 5px 0px;">
                    <div class="js-colorpicker input-group-append" data-format="hex">
                        <span class="input-group-text colorpicker-input-addon">
                            <i></i>
                        </span>
                        <input type="hidden" class="form-control" name="example-colorpicker2" value="'.$rows['child_color'].'" id="colorpicker'.$rows['child_id'].'" >
                    </div>
                    <input type="text" class="form-control" value="'.$rows['child_name'].'" id="option_name'.$rows['child_id'].'">
                    <button class="btn btn-primary btn-square btn-noborder" id="rename_option'.$rows['child_id'].'" onclick="rename_option(this.id)"><i class="fa fa-check"></i></button>
                    <button class="btn btn-danger btn-square btn-noborder" id="delete_option'.$rows['child_id'].'" onclick="delete_option(this.id)"><i class="fa fa-trash"></i></button>
                 </div>';
        }
    }
    if(isset($_POST['fetch_finance_child']))
    {
        $id = $_POST['finance_dropdown_field_id'];
        $select = mysqli_query($conn, "SELECT * FROM finance_child WHERE child_field_id = '$id' ORDER BY child_id ASC");
        while($rows = mysqli_fetch_array($select))
        {
            echo'<div class="input-group row" style="margin: 5px -20px 5px 0px;">
                    <div class="js-colorpicker input-group-append" data-format="hex">
                        <span class="input-group-text colorpicker-input-addon">
                            <i></i>
                        </span>
                        <input type="hidden" class="form-control" name="example-colorpicker2" value="'.$rows['child_color'].'" id="colorpicker_finance'.$rows['child_id'].'" >
                        <input type="hidden" value="finance" id="finance_child" >
                    </div>
                    <input type="text" class="form-control" value="'.$rows['child_name'].'" id="option_name_finance'.$rows['child_id'].'">
                    <button class="btn btn-primary btn-square btn-noborder" id="rename_option_finance'.$rows['child_id'].'" onclick="rename_option_finance(this.id)"><i class="fa fa-check"></i></button>
                    <button class="btn btn-danger btn-square btn-noborder" id="delete_option_finance'.$rows['child_id'].'" onclick="delete_option_finance(this.id)"><i class="fa fa-trash"></i></button>
                 </div>';
        }
    }
    if(isset($_POST['fetch_requirements_child']))
    {
        $id = $_POST['field_id'];
        $select = mysqli_query($conn, "SELECT * FROM requirement_child WHERE child_field_id = '$id' ORDER BY child_id ASC");
        while($rows = mysqli_fetch_array($select))
        {
            echo'<div class="input-group row" style="margin: 5px -20px 5px 0px;">
                    <div class="js-colorpicker input-group-append" data-format="hex">
                        <span class="input-group-text colorpicker-input-addon">
                            <i></i>
                        </span>
                        <input type="hidden" class="form-control" name="example-colorpicker2" value="'.$rows['child_color'].'" id="colorpicker_finance'.$rows['child_id'].'" >
                        <input type="hidden" value="finance" id="finance_child" >
                    </div>
                    <input type="text" class="form-control" value="'.$rows['child_name'].'" id="option_name_finance'.$rows['child_id'].'">
                    <button class="btn btn-primary btn-square btn-noborder" id="rename_option_requirements'.$rows['child_id'].'" onclick="rename_option_requirements(this.id)"><i class="fa fa-check"></i></button>
                    <button class="btn btn-danger btn-square btn-noborder" id="delete_option_requirements'.$rows['child_id'].'" onclick="delete_option_requirements(this.id)"><i class="fa fa-trash"></i></button>
                 </div>';
        }
    }
?>
<script src="../assets/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script>jQuery(function(){ Codebase.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']); });</script>