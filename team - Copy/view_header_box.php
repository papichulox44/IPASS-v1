<?php 
    $md_primary_darker = "";
    $md_text = "text-muted";
    $md_body = "";
    if($mode_type == "Dark") //insert
    { 
        $md_primary_darker = "bg-primary-darker";
        $md_text = "text-white-op";
        $md_body = "bg-gray-darker text-body-color-light";
    }
?>
<style type="text/css">
    .filterchild{
        display: none;
    }
    .filterparent:hover .filterchild {
        display: block;
    }


    .dropbtn {
  background-color: #4CAF50;
  color: white;
  padding: 16px;
  font-size: 16px;
  border: none;
  cursor: pointer;
}
</style>
<div class="block-content"> 
    <div class="scrumboard-col">
        <div class="block-header" style="margin: -35px 0px 0px 0px;">
            <h4 class="<?php echo $md_text; ?>" style="margin-left: -20px;"><?php echo $space_name; ?></h4>
            <div class="block-options" style="margin-right: -30px;">
        <?php include("menu_filter.php"); ?>
<?php
    if($user_type == "Admin")
    {?>
        <?php include("menu_hamburger.php"); ?>
    <?php }
?>      
            </div>
        </div>
        <p class="<?php echo $md_text; ?>" style="margin: -35px 0px 10px 0px;"><?php echo $list_name;?></p><hr style="margin-top: -5px;">
    </div>
</div> 