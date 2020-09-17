<!-- Main Container -->
<main id="main-container">
    <div class="content bg-primary-darker">
    <!-- Page Content -->
        <div class="row">
            <div class="col-md-6">
                <div class="block block-rounded shadow bg-gray-darker">
                    <div class="block-header content-heading shadow bg-gray-darker">
                            <h3 class="block-title text-white">Due Date <span class="badge badge-danger" id="count_due_date"></span></h3>
                            <div class="block-options">
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo" onclick="update_due_date()">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                        </div>
                    </div>
                    <div class="block-content block-content-full" style="overflow: auto; height: 300px;">
                        <ul class="list list-timeline list-timeline-modern pull-t" id="view_due_date">
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="block block-rounded shadow bg-gray-darker">
                        <div class="block-header content-heading shadow bg-gray-darker">
                            <h3 class="block-title text-white">Creating Contacts <span class="badge badge-danger" id="count_creating_contacts"></span></h3>
                            <div class="block-options">
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo" onclick="update_creating_contacts()">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                        </div>
                        </div>
                    <div class="block-content" style="overflow: auto; height: 300px;">
                        <ul class="list list-timeline pull-t" id="view_creating_contacts">
                        </ul>
                    </div>
                </div>
            </div>

             <div class="col-md-6">
                <div class="block block-rounded shadow bg-gray-darker">
                        <div class="block-header content-heading shadow bg-gray-darker">
                            <h3 class="block-title text-white">Comments</h3>
                            <div class="block-options">
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                        </div>
                        </div>
                    <div class="block-content" style="overflow: auto; height: 300px;">
                        <ul class="list list-timeline pull-t">
                            <!-- Twitter Notification -->
                            <li>
                                <div class="list-timeline-time">50 min agoadas</div>
                                <i class="list-timeline-icon fa fa-twitter bg-info"></i>
                                <div class="list-timeline-content">
                                    <p class="font-w600">+ 79 Followers</p>
                                    <p>You’re getting more and more followers, keep it up!</p>
                                </div>
                            </li>
                            <!-- END Twitter Notification -->
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="block block-rounded shadow bg-gray-darker">
                        <div class="block-header content-heading shadow bg-gray-darker">
                            <h3 class="block-title text-white">Remarks</h3>
                            <div class="block-options">
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                        </div>
                        </div>
                    <div class="block-content" style="overflow: auto; height: 300px;">
                        <ul class="list list-timeline pull-t">
                            <!-- Twitter Notification -->
                            <li>
                                <div class="list-timeline-time">50 min agoadas</div>
                                <i class="list-timeline-icon fa fa-twitter bg-info"></i>
                                <div class="list-timeline-content">
                                    <p class="font-w600">+ 79 Followers</p>
                                    <p>You’re getting more and more followers, keep it up!</p>
                                </div>
                            </li>
                            <!-- END Twitter Notification -->
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="block block-rounded shadow bg-gray-darker">
                        <div class="block-header content-heading shadow bg-gray-darker">
                            <h3 class="block-title text-white">Assigned Task</h3>
                            <div class="block-options">
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                        </div>
                        </div>
                    <div class="block-content" style="overflow: auto; height: 300px;">
                        <ul class="list list-timeline pull-t">
                            <!-- Twitter Notification -->
                            <li>
                                <div class="list-timeline-time">50 min agoadas</div>
                                <i class="list-timeline-icon fa fa-twitter bg-info"></i>
                                <div class="list-timeline-content">
                                    <p class="font-w600">+ 79 Followers</p>
                                    <p>You’re getting more and more followers, keep it up!</p>
                                </div>
                            </li>
                            <!-- END Twitter Notification -->
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
        <!-- END Timeline Default Style -->
</main>
<!-- END Main Container -->

<script>
    due_date();
    count_due_date();
    creating_contacts();
    count_creating_contacts();


    //Due Date functions-----------------------------------------------------------------------------------------------------------
    function due_date(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            due_date: 1,
        },
            success: function(response){
                $('#view_due_date').html(response);
            }
        });
    }

    function count_due_date(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            count_due_date: 1,
        },
            success: function(response){
                $('#count_due_date').html(response);
            }
        });
    }

    function update_due_date(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            update_due_date: 1,
        },
            success: function(response){
                if (response == 'success') {
                    due_date();
                    count_due_date();
                }
            }
        });
    }
    //End Due Date functions---------------------------------------------------------------------------------------------------

    //Creating Contacts Function---------------------------------------------------------------------------------------------------
    function creating_contacts(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            creating_contacts: 1,
        },
            success: function(response){
                $('#view_creating_contacts').html(response);
            }
        });
    }

    function count_creating_contacts(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            count_creating_contacts: 1,
        },
            success: function(response){
                $('#count_creating_contacts').html(response);
            }
        });
    }

    function update_creating_contacts(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            update_creating_contacts: 1,
        },
            success: function(response){
                if (response == 'success') {
                    creating_contacts();
                    count_creating_contacts();
                }
            }
        });
    }
    //End Creating Contacts Function---------------------------------------------------------------------------------------------------

</script>