@extends('Admin.layout.main')
@section('title')
Support Tickets Statistics
@endsection
@section('styles')
    <style>
        .x_title {
             margin-bottom: 13px;
        }
        .tile-stats h3 {
            font-size: 16px;
        }
        .tile-stats .icon i {
            font-size: 30px;
        }
        .tile-stats .count {
            font-size: 22px;
        }
        a.tickets-list:hover {
            color: black;
            font-weight: bold;
            cursor: pointer;
        }
        a.tickets-list {
            color: #fff;
        }
    </style>
@endsection

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
                <div class="title_left">
                    <h3>Support tickets</h3>
                </div>

            </div>
            <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Statistics</h2>
                        <ul class="nav navbar-right panel_toolbox justify-content-end">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label style="margin-left: 11px;">Date</label>
                            
                                <fieldset>
                                    <div class="control-group">
                                        <div class="controls">
                                            <div class="input-prepend input-group" style="margin-left: 11px;">
                                                    <span class="add-on input-group-addon"><i
                                                                class="fa fa-calendar"></i></span>
                                                <input type="text" name="reservation"
                                                       id="reservation" class="form-control"
                                                       value="">
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Ticket Status</label>
                            <!-- <div class="col-md-12 col-sm-12"> -->
                                <select class="form-control select2" name="status" id="status" onchange="search()">
                                    <option value="0">View All</option>
                                    <?php foreach($ticketStatuses as $status){ ?>
                                        <option value="<?php echo $status['id']; ?>"><?php echo $status['title']; ?></option>
                                    <?php } ?>
                                </select>
                            <!-- </div> -->
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                                <label>Destination City</label>
                                <select class="form-control select2" id="destination_city_id" onchange="search()"></select>
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Nature Type</label>
                            
                                <select class="form-control select2" onchange="searchByNature()" name="ticket_type" id="ticket_type">
                                    <option selected disabled value="">Nature Type</option>
                                    <?php foreach($ticketTypes as $type){ ?>
                                        <option value="<?php echo $type['id']; ?>"><?php echo $type['title']; ?></option>
                                    <?php } ?>
                                </select>
                            
                        </div>

                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <label>Ticket Type Option</label>
                            <select class="form-control select2" id="support_ticket_type_id" onchange="search()"></select>
                        </div>
                    </div>
                    <hr>

                    <div class="clearfix"></div>

   

                    <div class="x_content">
                        <div class="row justify-content-center">

                                <div class="col-lg col-md-2 col-sm-6">
                                    <div class="tile-stats tile-stats-bg-3">
                                        <div class="icon"><i class="fa fa-list-ul"></i></div>
                                        <div class="count" id="total_tickets">0</div>
                                        <h3><a title="View List" data-status="0" class="tickets-list"> <i class="fa fa-eye"></i> Tickets Created </a></h3>
                                    </div>
                                </div>
                                <div class="col-lg col-md-2 col-sm-6">
                                    <div class="tile-stats tile-stats-bg-4">
                                        <div class="icon"><i class="fa fa-list-alt"></i></div>
                                        <div class="count" id="total_closed_tickets">0</div>
                                        <h3><a title="View List" data-status="3" class="tickets-list"> <i class="fa fa-eye"></i> Tickets Closed </a></h3>
                                    </div>
                                </div>
                                <div class="col-lg col-md-2 col-sm-6">
                                    <div class="tile-stats tile-stats-bg-4">
                                        <div class="icon"><i class="fa fa-list-alt"></i></div>
                                        <div class="count" id="total_completed_tickets">0</div>
                                        <h3><a title="View List" data-status="2" class="tickets-list"> <i class="fa fa-eye"></i> Tickets Completed </a></h3>
                                    </div>
                                </div>
                                <div class="col-lg col-md-2 col-sm-6">
                                    <div class="tile-stats tile-stats-bg-2">
                                        <div class="icon"><i class="fa fa-pencil-square-o"></i></div>
                                        <div class="count" id="total_pending_tickets">0</div>
                                        <h3><a title="View List" data-status="1" class="tickets-list"> <i class="fa fa-eye"></i> Tickets Under Process </a></h3>
                                    </div>
                                </div>
                                <div class="col-lg col-md-2 col-sm-6">
                                    <div class="tile-stats tile-stats-bg-2">
                                        <div class="icon"><i class="fa fa-pencil-square-o"></i></div>
                                        <div class="count" id="total_re_opened_tickets">0</div>
                                        <h3><a title="View List" data-status="7" class="tickets-list"> <i class="fa fa-eye"></i> Tickets Re-Opened </a></h3>
                                    </div>
                                </div>
                                <div class="col-lg col-md-2 col-sm-6">
                                    <div class="tile-stats tile-stats-bg-2">
                                        <div class="icon"><i class="fa fa-pencil-square-o"></i></div>
                                        <div class="count" id="total_opened_tickets">0</div>
                                        <h3><a title="View List" data-status="4" class="tickets-list"> <i class="fa fa-eye"></i> Tickets Opened </a></h3>
                                    </div>
                                </div>
                        </div> 
                        <canvas id="barChart" width="400" height="200"></canvas>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
@endsection

@section('scripts')

<script>
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`
        };

    $(document).ready(function() {
        // Remove default value from the input field
        $('#reservation').val('');
        getCitesList();
        getStatistics(headers);
    });


    function getCitesList(){
        $("#destination_city_id").select2({
                placeholder: "Search Destination City",
                minimumInputLength: 2, // Minimum characters before sending the AJAX request
                allowClear: true,
                ajax: {
                    url: "{{ api_url('get_cities') }}", // Replace with your actual server endpoint
                    dataType: "json",
                    delay: 250, // Delay before sending the request in milliseconds
                    headers: headers,
                    processResults: function (data) {
                        return {
                            results: data.map(function (item) {
                                return {
                                    id: item.id,
                                    text: item.label // 'text' property is required by Select2
                                };
                            })
                        };
                    },
                    cache: true // Enable caching of AJAX results
                }
            });
    }

    function getStatistics(headers){
        $.ajax({
            url: '<?php echo api_url('support_ticket/statistic'); ?>',
            method: 'GET',
            data: {
                ajax: true,
                date : $('#reservation').val(),
                status : $('#status').val(),
                ticket_type : $('#ticket_type').val(),
                issue_type : $('#support_ticket_type_id').val(),
                destination_city : $('#destination_city_id').val(),
            },
            headers: headers,
            dataType: 'json', // Set the expected data type to JSON
            beforeSend: function () {
                $('.error-container').html('');
            },
            success: function (data) {
                if (data) {
                    syncStatistics(data.data);
                } else {
                    Swal.fire(
                        'Error!',
                        'Something Went Wrong',
                        'error'
                    );
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                // Handle AJAX errors here
                Swal.fire(
                    'Error!',
                    'Form submission failed: ' + errorThrown,
                    'error'
                );
            }
        });
    }
    function search(){
        getStatistics(headers);
    }

    function searchByNature(){
        getStatistics(headers);

        $('#support_ticket_type_id').empty();
        var ticket_type = document.getElementById('ticket_type').value;

        $.ajax({
            url: '<?php echo api_url('support_ticket/getIssueType'); ?>',
            method: 'GET',
            data:{ ajax: true,ticket_type: ticket_type},
            dataType: 'json', // Set the expected data type to JSON
            headers: headers,
            beforeSend: function(){
                $('.error-container').html('');
            },
            success: function(data) {
                if (data && data.status == 1) {
                    $.each(data.data, function(index, item) {
                        $('#support_ticket_type_id').append($('<option>', {
                            value: item.Id,
                            text: item.Name
                        }));
                    });

                } else {
                    if(data && data.status == 0){
                        Swal.fire(
                            'Error!',
                            data.error,
                            'error'
                        );
                        document.getElementById("booking-data").style.display = "none";
                        // var errors = (data.errors) ? data.errors : {};
                        // $('.error-container').html(errors);
                    }
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                // Handle AJAX errors here
                Swal.fire(
                    'Error!',
                    'Form submission failed: ' + errorThrown,
                    'error'
                );
            }
        });

    }

    $( "body" ).delegate( ".applyBtn", "click", function() {
        getStatistics(headers);
    });

    var total_tickets,OpenedTickets,reopenedTickets,pendingTickets,completedTickets,closedTickets=0;

    function syncStatistics(data){
   
        total_tickets = data.length;
        $('#total_tickets').text(total_tickets);

        // Group the JSON array by the "status" key
        var groupedData = groupBy(data, "CurrentStatus");

        if (groupedData.Pending !== null && groupedData.Pending !== undefined) {
            pendingTickets = groupedData.Pending.length;
        }

        if (groupedData.Opened !== null && groupedData.Opened !== undefined) {
            OpenedTickets = groupedData.Opened.length;
        }
        
        if (groupedData['Completed'] !== null && groupedData['Completed'] !== undefined) {
            completedTickets = groupedData['Completed'].length;
        }

        if (groupedData['Re-Opened'] !== null && groupedData['Re-Opened'] !== undefined) {
            reopenedTickets = groupedData['Re-Opened'].length;
        }
       
        $('#total_opened_tickets').text(OpenedTickets);
        $('#total_pending_tickets').text(pendingTickets);
        $('#total_re_opened_tickets').text(reopenedTickets);
        $('#total_completed_tickets').text(completedTickets);
        if (groupedData.Closed !== null && groupedData.Closed !== undefined) {
            closedTickets = groupedData.Closed.length;
        }
        $('#total_closed_tickets').text(closedTickets);
        createchart(total_tickets,closedTickets,completedTickets,pendingTickets,OpenedTickets,reopenedTickets);
    }

    // Function to group the JSON array by a specific key
    function groupBy(array, key) {
        return array.reduce(function (acc, obj) {
            var property = obj[key];
            if (!acc[property]) {
                acc[property] = [];
            }
            acc[property].push(obj);
            return acc;
        }, {});
    }

    function createchart(total_tickets,closedTickets,completedTickets,pendingTickets,OpenedTickets,reopenedTickets){
        var data = {
            labels: ["Total Tickets", "Closed Tickets","Completed Tickets", "Pending Tickets","Opened Tickets","Re-Opened Tickets"],
            datasets: [{
                label: "Tickets Statistics",
                data: [total_tickets, closedTickets, completedTickets,pendingTickets,OpenedTickets,reopenedTickets],
                backgroundColor: ["rgba(75, 192, 192, 0.2)","rgba(75, 30, 2, 0.2)","rgba(40, 30, 2, 0.2)","rgba(40, 28, 2, 0.2)","rgba(75, 192, 192, 0.2)","rgba(75, 30, 2, 0.2)"],
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 1
            }]
        };

        var ctx = document.getElementById('barChart').getContext('2d');
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    $( "body" ).delegate( ".tickets-list", "click", function() {
        status = $(this).data('status');
        date = $('#reservation').val();
        ticket_type = $('#ticket_type').val();
        ticket_option = $('#support_ticket_type_id').val();
        window.open("<?php echo url_secure('support_ticket') ?>?status="+status+"&date="+date+"&ticket_type="+ticket_type+"&ticket_option="+ticket_option, '_blank');
    });
</script>


@endsection