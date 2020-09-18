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
                            <h3 class="block-title text-white">Comments <span class="badge badge-danger" id="count_creating_comments"></span></h3>
                            <div class="block-options">
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo" onclick="update_creating_comments()">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                        </div>
                        </div>
                    <div class="block-content" style="overflow: auto; height: 300px;">
                        <ul class="list list-activity" id="view_creating_comments">
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="block block-rounded shadow bg-gray-darker">
                        <div class="block-header content-heading shadow bg-gray-darker">
                            <h3 class="block-title text-white">Remarks <span class="badge badge-danger" id="count_creating_remarks"></h3>
                            <div class="block-options">
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo" onclick="update_creating_remarks()">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                        </div>
                        </div>
                    <div class="block-content" style="overflow: auto; height: 300px;">
                        <ul class="list list-activity" id="view_creating_remarks">
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
            </div>
            <div class="col-md-6">
                <div class="block block-rounded shadow bg-gray-darker">
                        <div class="block-header content-heading shadow bg-gray-darker">
                            <h3 class="block-title text-white">Assigned Task <span class="badge badge-danger" id="count_creating_assigned_task"></h3>
                            <div class="block-options">
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo" onclick="update_creating_assigned_task()">
                                <i class="si si-refresh"></i>
                            </button>
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                        </div>
                        </div>
                    <div class="block-content" style="overflow: auto; height: 300px;">
                        <ul class="list list-activity" id="view_creating_assigned_task">
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
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

    creating_comments();
    count_creating_comments();

    creating_remarks();
    count_creating_remarks();

    creating_assigned_task();
    count_creating_assigned_task();


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

    //Creating Comments Function---------------------------------------------------------------------------------------------------
    function creating_comments(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            creating_comments: 1,
        },
            success: function(response){
                $('#view_creating_comments').html(response);
            }
        });
    }

    function count_creating_comments(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            count_creating_comments: 1,
        },
            success: function(response){
                $('#count_creating_comments').html(response);
            }
        });
    }

    function update_creating_comments(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            update_creating_comments: 1,
        },
            success: function(response){
                if (response == 'success') {
                    creating_comments();
                    count_creating_comments();
                }
            }
        });
    }
    //End Creating Comments Function---------------------------------------------------------------------------------------------------

    //Creating Remarks Function---------------------------------------------------------------------------------------------------
    function creating_remarks(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            creating_remarks: 1,
        },
            success: function(response){
                $('#view_creating_remarks').html(response);
            }
        });
    }

    function count_creating_remarks(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            count_creating_remarks: 1,
        },
            success: function(response){
                $('#count_creating_remarks').html(response);
            }
        });
    }

    function update_creating_remarks(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            update_creating_remarks: 1,
        },
            success: function(response){
                if (response == 'success') {
                    creating_remarks();
                    count_creating_remarks();
                }
            }
        });
    }
    //End Creating Remarks Function---------------------------------------------------------------------------------------------------

    //End Creating Assigned Task Function----------------------------------------------------------------------
    function creating_assigned_task(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            creating_assigned_task: 1,
        },
            success: function(response){
                $('#view_creating_assigned_task').html(response);
            }
        });
    }

    function count_creating_assigned_task(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            count_creating_assigned_task: 1,
        },
            success: function(response){
                $('#count_creating_assigned_task').html(response);
            }
        });
    }

    function update_creating_assigned_task(){

        $.ajax({
        url: 'ajax_notification.php',
        type: 'POST',
        async: false,
        data:{
            update_creating_assigned_task: 1,
        },
            success: function(response){
                if (response == 'success') {
                    creating_assigned_task();
                    count_creating_assigned_task();
                }
            }
        });
    }
    //End Creating Assigned Task Function----------------------------------------------------------------------------------

</script>