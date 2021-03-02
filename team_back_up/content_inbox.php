<?php
    $md_content = "";
    $md_text = "text-muted";
    $md_table_header = "";
    $md_table_title = "";
    $table = "";
    if($mode_type == "Dark") //insert
    { 
        $md_content = "bg-primary-darker";
        $md_text = "text-white";
        $md_table_header = "bg-gray-darker";
        $md_table_body = "bg-primary-darker text-body-color-light";
        $md_table_title = "text-white";
        $table = "bg-earth-dark"; 
    }
?>
<style>
    .image-upload>input {
          display: none;
        }
    .bott{
        display: none;
    }
    .parentss:hover .bott {
    display: block;
    cursor: pointer;
    }

    .sender{background-color: #f1f4f6; border-radius: 0px 20px 20px 20px; padding: 5px 10px 5px 10px; margin: 5px 250px 5px 5px;}
    @media screen and (max-width: 1025px) 
    {.sender{margin: 5px 40px 5px 5px;}}

    .reciever{background-color: #e7eff5; border-radius: 20px 20px 0px 20px; padding: 5px 10px 5px 10px; margin: 5px 0px 5px 250px;}
    @media screen and (max-width: 1025px) 
    {.reciever{margin: 5px 5px 5px 40px;}}

    .smallim{height: 45px; width: 45px; border-radius: 100px; margin-right: 10px;}
    .contacts{cursor: pointer;}
</style>      
            <!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                <div class="content <?php echo $md_content; ?>">
                    <div class="row">
                        <div class="col-md-5 col-xl-3">
                            <!-- Recent Contacts -->
                            <div class="block d-md-block block-rounded shadow  <?php echo $md_table_header; ?>">
                                <div class="block-header content-heading">
                                    <strong class="block-title text-muted <?php echo $md_text; ?>">Contacts</strong>
                                </div>

                                <div>
                                    <div class="block-content block-content-full <?php echo $md_table_header; ?>" data-toggle="slimscroll" data-height="440px" data-color="#42a5f5" data-opacity="1" style="padding: 0px;">
                                        <?php
                                            include_once '../conn.php';
                                            $user_id = $row['user_id'];
                                        ?>
                                        <ul class="nav-users" id="contact123">
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- END Recent Contacts -->
                        </div>
                        <div class="col-md-7 col-xl-9">
                            <!-- Message List -->
                            <div class="block block-rounded shadow <?php echo $md_table_header; ?>">
                                <div class="block-header content-heading <?php echo $md_table_header; ?>">
                                    <div class="block-title">
                                        <strong class="<?php echo $md_text; ?>" id="message_to_from">Message</strong> 
                                    </div>
                                    <div class="block-options">    
                                        <button type="button" class="btn-block-option <?php echo $md_text; ?>" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                            <i class="si si-refresh"></i>
                                        </button>
                                        <button type="button" class="btn-block-option <?php echo $md_text; ?>" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                                    </div>
                                </div>

                                <div class="block-content <?php echo $md_table_header; ?>" style="overflow-y: scroll; height: 400px;" style="background-color: #e2e2e2;" id="divscroll">
                                    <table class="js-table-checkable table table-hover table-vcenter">
                                        <tbody id="messageBody">
                                        </tbody>
                                    </table>
                                </div>
                                <hr style="padding: 0px 0px 0px 0px;">  
                                <span class="parentss" id="imageparent" style="display: none; padding-top: 10px;">
                                    <button type="button" class="bott btn-block-option btn" onclick="cancel_image()" style="margin: 0px 0px -28px 0px;">
                                          <i class="si si-close btn-danger" style="border-radius: 10px; margin: 20px 0px 10px 0px;"></i>
                                    </button>
                                    <img id="blah" src="" style="width: 150px; height: auto; margin: 5px 0px 5px 10px; border-radius: 10px; box-shadow: 0 8px 6px -6px #dedede;">
                                </span>
                                <span class="parentss " id="fileparent" style="display: none;">
                                    <button type="button" class="bott btn-block-option btn" onclick="cancel_file()" style="margin: 0px 0px -28px 0px;">
                                          <i class="si si-close btn-danger" style="border-radius: 10px;"></i>
                                    </button>
                                    <span id="filename" style="padding-left: 20px"></span>
                                </span>

                                <div class="input-group block-header <?php echo $md_table_header; ?>" style="margin-top: 20px;">
                                    <div class="image-upload">
                                        <label class="btn btn-square btn-success min-width-30 btn-noborder" for="image">
                                            <i class="si si-paper-clip"></i>
                                        </label>
                                        <input type="file" id="image" onchange="showname()"/>
                                    </div>
                                    <input type="hidden" id="reciever_id" value="">
                                    <input type="hidden" id="user_id" value="<?php echo $user_id; ?>">
                                    <input type="hidden" id="code" value="">
                                    <textarea type="text" class="form-control" placeholder="Write message..." id="message" style="margin-top: -5px; height: 35px;"></textarea>
                                    <button class="btn btn-primary btn-square btn-noborder" id="send_message" style="margin-top: -5px;"><i class="fa fa-send"></i></button>
                                </div>
                            </div>
                            <!-- END Message List -->
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
    <script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
    <script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        // Send message -------------------------------
        $('#send_message').on('click', function(){
            
            var message = document.getElementById("message").value;  
            var reciever_id = document.getElementById("reciever_id").value;            
            if(reciever_id == "")
            {                
                alert('Please select contact.');
            }
            else
            {
                var image = document.getElementById("image").value;
                if(image == "")
                {
                    var reciever_id = document.getElementById("reciever_id").value;
                    var user_id = <?php echo $user_id ?>;
                    var code = user_id + "," + reciever_id;
                    var message = document.getElementById("message").value;
                    //alert(user_id +","+ reciever_id +","+ message);
                    $.ajax({
                        type: "POST",
                        url: "send_message.php",
                        data: {
                            reciever_id: reciever_id,
                            user_id: user_id,
                            code: code,
                            message: message,
                        },
                        success: function(){
                            $('#message').val("");
                            display_message();
                        }
                    });
                }
                else
                {
                    var image = $('#image');
                    var image_data = image.prop('files')[0];         
                    var formData = new FormData();
                    formData.append('image', image_data);

                    var reciever_id = $('#reciever_id').val();
                    formData.append("reciever_id", reciever_id);
                    var user_id = <?php echo $user_id ?>;
                    formData.append("user_id", user_id);
                    var message = $('#message').val();
                    formData.append("message", message);

                    $.ajax({
                        url: "send_message.php",
                        type: "POST",
                        data: formData,
                                  
                        contentType:false,
                        cache: false,
                        processData: false,
                        success: function(data){
                            if(data == "success")
                            {
                                cancel_image();
                                $('#message').val("");
                                display_message();
                            }
                            else if(data == "error2")
                            {
                                alert('Wrong file format');
                            }
                            else if(data == "error3")
                            {
                                alert('File too large to upload');
                            }
                        }
                    });
                }
            }
        });
        // END Send message -------------------------------

        // Delete message -------------------------------
        $(document).on('click', '.delete_comment', function(){
            if(confirm("Are you sure you want to delete this message?"))
            {
                $id = $(this).val();
                $.ajax({
                    type: "POST",
                    url: "delete_message.php",
                    data: {
                        id: $id,
                        del: 1,
                    },
                    success: function(data){
                        if(data != ''){}  
                        else{}
                        display_message();
                    }
                });
            } 
            else  
            {  
                return false;  
            }                 
        });
        // END delete message -------------------------------
    });

    // Display contact -------------------------------
    display_contact();
    function display_contact(){
        var user_id = <?php echo $user_id ?>;
        $.ajax({
            url: 'fetch_contact.php',
            type: 'POST', 
            async: false,
            data:{
                user_id:user_id,
                fetch: 1,
            },
                success: function(response){
                    $('#contact123').html(response);
                    $("#contact123").scrollTop($("#contact123")[0].scrollHeight);
                }
        });
    }
    // END display contact -------------------------------
    // Display message -------------------------------
    function display_message(){
        var reciever_id = document.getElementById("reciever_id").value;
        var user_id = <?php echo $user_id ?>;
        $.ajax({
            url: 'fetch_message.php',
            type: 'POST', 
            async: false,
            data:{
                user_id:user_id,
                reciever_id: reciever_id,
                fetch: 1,
            },
                success: function(response){
                    $('#messageBody').html(response);
                    $("#messageBody").scrollTop($("#messageBody")[0].scrollHeight);
                }
        });
    }
    // setInterval (display_message, 2500);
    // END display message -------------------------------

    function contact_click(id)
    {   
        var reciever_message = $('#messageBody > .reciever');
        $(reciever_message).remove();
        var sender_message = $('#messageBody > .sender');
        $(sender_message).remove(); 

        var receiver = id; // sender_id
        var sender = <?php echo $user_id ?>;
        var code1_sender_to_reciever = receiver + "," + sender;
        var code2_reciever_to_sender = sender + "," + receiver;

        
        <?php
            $selectuser = mysqli_query($conn, "SELECT * FROM user");
            while($result_selectuser = mysqli_fetch_array($selectuser))
            {?>
                var user_id = <?php echo $result_selectuser['user_id'] ?>;
                var full_name = 'To: <?php echo $result_selectuser['fname'] ?> <?php echo $result_selectuser['mname'] ?> <?php echo $result_selectuser['lname'] ?>';
                if(receiver == user_id)
                {
                    document.getElementById("message_to_from").innerHTML = full_name;
                }
            <?php
            }
        ?>

        document.getElementById("reciever_id").value = receiver;
        document.getElementById("code").value = code2_reciever_to_sender;
        document.getElementById("message").focus();

        display_message();
        display_contact();
    }
    </script>

    <script type="text/javascript">
    // For image selection -------------------------------
    function showname() {
        var name = document.getElementById('image'); 
        //alert(name.files.item(0).name); // full name of files
        finalname = (name.files.item(0).name);
        var ext = $("#image").val().split(".").pop().toLowerCase(); // get the name extention.
        //alert(ext);
        if(ext == "jpg" || ext == "jpeg" || ext == "png" || ext == "gif")
        {
           document.getElementById("imageparent").style.display='block';
           document.getElementById("fileparent").style.display='none';
        }
        else
        {
           document.getElementById("fileparent").style.display='block';
           document.getElementById("imageparent").style.display='none';
           document.getElementById("filename").innerHTML = finalname;
        }
    };

    function cancel_image() {
            document.getElementById("image").value = "";
            document.getElementById("blah").style.display='none';
            document.getElementById("fileparent").style.display='none';
            document.getElementById("imageparent").style.display='none';
    }
    function cancel_file() {
            document.getElementById("image").value = "";
            document.getElementById("fileparent").style.display='none';
            document.getElementById("imageparent").style.display='none';
    }


    let good = 'test.jpg';
    let bad = 'jpg.test';
    let re = (/\.(gif|jpg|jpeg|png)$/i).test(good);
    if (re) 
    {
        console.log('Good', good);
    }
    console.log('Bad:', bad);
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
              $('#blah').attr('src', e.target.result);
              document.getElementById("blah").style.display='block';
            }
            
            reader.readAsDataURL(input.files[0]);
          }
        }
        $("#image").change(function() {
        readURL(this);
    });        
    </script>