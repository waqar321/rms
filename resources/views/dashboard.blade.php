@extends('Admin.layout.main')

@section('styles')
    <style>
        .filter-button {
            margin-top: 19px !important;
        }

        .top-profile {
            max-height: 300px; /* Set the maximum height you desire */
            overflow-y: auto;
        }
        .summary-report{
            border-bottom: 0px;
        }
        .tiles{
            border-top: 1px solid #ccc;
            margin-top: -20px;
            padding-top: 25px;
            margin-bottom: 0;
        }
        .date-from{
            height: 33px;
        }
        .date-to{
            height: 33px;
        }
    </style>
@endsection

@section('content')

        @can('dashboard_view')
            <div class="right_col" role="main" data-screen-permission-id="53">
                <div class="row" style="display: inline-block;">
                    <div class="tile_count">
                        <div class="col-md-2 col-sm-4  tile_stats_count">
                                <span class="count_top"><i class="fa fa-users"></i> Total Users </span>
                                <div class="count">{{$Data['usersCount']}}</div>
                                <span class="count_bottom">
                                    @if($Data['lastWeekUsersCount'] > 0)
                                        <i class="green"><i class="fa fa-sort-asc"></i>{{$Data['lastWeekUsersCount']}} </i> Increase from Last Week
                                    @else
                                        0 Increase from Last Week
                                    @endif
                                </span>
                        </div>
                    
                        <div class="col-md-2 col-sm-4  tile_stats_count">
                                <span class="count_top"><i class="fa fa-users"></i> Total Instructor </span>
                                <div class="count">{{$Data['instructorCount']}}</div>
                                <span class="count_bottom">
                                    @if($Data['lastWeekinstructorCount'] > 0)
                                        <i class="green"><i class="fa fa-sort-asc"></i>{{$Data['lastWeekinstructorCount']}} </i> Increase from Last Week
                                    @else
                                        0 Increase from Last Week
                                    @endif
                                </span>
                        </div>
                        <div class="col-md-2 col-sm-4  tile_stats_count">
                                <span class="count_top"><i class="fa fa-folder"></i></i> Total Category </span>
                                <div class="count">{{$Data['instructorCount']}}</div>
                                <span class="count_bottom">
                                    @if($Data['lastWeekcategoriesCount'] > 0)
                                        <i class="green"><i class="fa fa-sort-asc"></i>{{$Data['lastWeekcategoriesCount']}} </i> Increase from Last Week
                                    @else
                                        0 Increase from Last Week
                                    @endif
                                </span>
                        </div>
                        <div class="col-md-2 col-sm-4  tile_stats_count">
                                <span class="count_top"><i class="fa fa-book"></i> Total Course </span>
                                <div class="count">{{$Data['coursesCount']}}</div>
                                <span class="count_bottom">
                                    @if($Data['lastWeekcourseCount'] > 0)
                                        <i class="green"><i class="fa fa-sort-asc"></i>{{$Data['lastWeekcourseCount']}} </i> Increase from Last Week
                                    @else
                                        0 Increase from Last Week
                                    @endif
                                </span>
                        </div>
                        <div class="col-md-2 col-sm-4  tile_stats_count">
                                <span class="count_top"><i class="fa fa-building"></i> Total Department </span>
                                <div class="count">{{$Data['departmentsCount']}}</div>
                                <span class="count_bottom">
                                    @if($Data['lastWeekdepartmentsCount'] > 0)
                                        <i class="green"><i class="fa fa-sort-asc"></i>{{$Data['lastWeekdepartmentsCount']}} </i> Increase from Last Week
                                    @else
                                        0 Increase from Last Week
                                    @endif
                                </span>
                        </div>
                        <div class="col-md-2 col-sm-4  tile_stats_count">
                            <span class="count_top"><i class="fa fa-play-circle"></i>Total Tutorials</span>
                            <div class="count">0</div>
                            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>0% </i> Increase from Last Week</span>
                        </div>
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 col-sm-4">
                        <div class="x_panel tile fixed_height_320 overflow_hidden">
                            <div class="x_title">
                                <h2>Device Usage</h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Settings 1</a>
                                            <a class="dropdown-item" href="#">Settings 2</a>
                                        </div>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <table style="width:100%">
                                    <tr>
                                        <th style="width:37%;">
                                            <p>Top 5</p>
                                        </th>
                                        <th>
                                            <div class="col-lg-7 col-md-7 col-sm-7">
                                                <p class="">Device</p>
                                            </div>
                                            <div class="col-lg-5 col-md-5 col-sm-5">
                                                <p class="">Progress</p>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <canvas class="canvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
                                        </td>
                                        <td>
                                            <table class="tile_info">
                                                <tr><td><p><i class="fa fa-square blue"></i>IOS</p></td><td>30%</td></tr>
                                                <tr><td><p><i class="fa fa-square green"></i>Android</p></td><td>10%</td></tr>
                                                <tr><td><p><i class="fa fa-square purple"></i>Blackberry</p></td><td>20%</td></tr>
                                                <tr><td><p><i class="fa fa-square aero"></i>Symbian</p></td><td>15%</td></tr>
                                                <tr><td><p><i class="fa fa-square red"></i>Others</p></td><td>30%</td></tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-sm-8">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>Visitors location <small>geo-presentation</small></h2>
                                        <ul class="nav navbar-right panel_toolbox">
                                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                            <li class="dropdown">
                                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Settings 1</a>
                                                    <a class="dropdown-item" href="#">Settings 2</a>
                                                </div>
                                            </li>
                                            <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                        </ul>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <div class="dashboard-widget-content">
                                            <div class="col-md-4 hidden-small">
                                                <h2 class="line_30">125.7k Views from 30 Cities</h2>
                                                <table class="countries_list">
                                                    <tbody>
                                                        <tr><td>Karachi </td><td class="fs15 fw700 text-right">33%</td></tr>
                                                        <tr><td>Lahore</td><td class="fs15 fw700 text-right">27%</td></tr>
                                                        <tr><td>Islamabad</td><td class="fs15 fw700 text-right">16%</td></tr>
                                                        <tr><td>Multan</td><td class="fs15 fw700 text-right">11%</td></tr>
                                                        <tr><td>Hyderabad</td><td class="fs15 fw700 text-right">10%</td></tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div id="world-map-gdp" class="col-md-8 col-sm-12" style="height:230px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Weekly Summary <small>Employee Activity</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">Settings 1</a>
                                            <a class="dropdown-item" href="#">Settings 2</a>
                                        </div>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="row" style="border-bottom: 1px solid #E0E0E0; padding-bottom: 5px; margin-bottom: 5px;">
                                    <div class="col-md-7" style="overflow:hidden;">
                                        <span class="sparkline_one" style="height: 160px; padding: 10px 25px;">
                                            <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
                                        </span>
                                        <h4 style="margin:18px">Weekly activity overview</h4>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="row" style="text-align: center;">
                                            <div class="col-md-4">
                                                <canvas class="canvasDoughnut" height="110" width="110" style="margin: 5px 10px 10px 0"></canvas>
                                                <h4 style="margin:0">Tasks Completed</h4>
                                            </div>
                                            <div class="col-md-4">
                                                <canvas class="canvasDoughnut" height="110" width="110" style="margin: 5px 10px 10px 0"></canvas>
                                                <h4 style="margin:0">Training Progress</h4>
                                            </div>
                                            <div class="col-md-4">
                                                <canvas class="canvasDoughnut" height="110" width="110" style="margin: 5px 10px 10px 0"></canvas>
                                                <h4 style="margin:0">Engagement Rate</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endcan

@endsection



@section('scripts')

    <script>
        // authorization headers
        const token = getToken();
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        // document ready for city dropdown
        $(document).ready(function () {

            // $("#city_id").select2({
                
            //     // console.log('yes coming');
            //     // return false;

            //     placeholder: "Search Origin City",
            //     // minimumInputLength: 2, // Minimum characters before sending the AJAX request
            //     allowClear: true,
            //     ajax: {
            //         url: "{{ api_url('rights/city') }}", // Replace with your actual server endpoint
            //         dataType: "json",
            //         delay: 250, // Delay before sending the request in milliseconds
            //         headers: headers,
            //         processResults: function (data) {
            //             return {
            //                 results: data.map(function (item) {
            //                     return {
            //                         id: item.id,
            //                         text: item.label // 'text' property is required by Select2
            //                     };
            //                 })
            //             };
            //         },
            //         cache: true // Enable caching of AJAX results
            //     }
            // });

            // ============= check for device token ============= 



            // $("#client_id").select2({
            //     placeholder: "Search By Client",
            //     minimumInputLength: 2, // Minimum characters before sending the AJAX request
            //     allowClear: true,
            //     ajax: {
            //         url: "{{ api_url('clients_list') }}", // Replace with your actual server endpoint
            //         dataType: "json",
            //         delay: 250, // Delay before sending the request in milliseconds
            //         headers: headers,
            //         processResults: function (data) {
            //             return {
            //                 results: data.map(function (item) {
            //                     return {
            //                         id: item.id,
            //                         text: item.label // 'text' property is required by Select2
            //                     };
            //                 })
            //             };
            //         },
            //         cache: true // Enable caching of AJAX results
            //     }
            // });

            // @if(auth()->user()->role_id == 1)
            //     submitFilterForm();
            //     setTimeout(function() {successRateDounutAndRatePerShipment();}, 2000);
            //     setTimeout(function() {noOfShipmentGraph();}, 4000);
            //     setTimeout(function() {firstMileSummary();}, 6000);
            //     setTimeout(function() {reversePickupSummary();}, 8000);
            //     setTimeout(function() {summaryReport();}, 10000);
            //     setTimeout(function() {weeklySummaryReport();}, 12000);
            //     setTimeout(function() {topTenDestinationAndOrders();}, 14000);
            //     setTimeout(function() {newsFeeds();}, 1000);
            // @endif
            // ticketSummary(headers);
            // topTenDestinationAndOrders();
            // newsFeeds();
        });

        // get client by city wise
        // function getClientByCity() {
        //     $("#merchant_id").select2({
        //         placeholder: "Search By Client",
        //         minimumInputLength: 2, // Minimum characters before sending the AJAX request
        //         allowClear: true,
        //         ajax: {
        //             {{--url: "{{ api_url('clients_list') }}?city_id=" + $('#city_id').val(), // Replace with your actual server endpoint--}}
        //             url: "{{ api_url('clients_list') }}", // Replace with your actual server endpoint
        //             dataType: "json",
        //             delay: 250, // Delay before sending the request in milliseconds
        //             headers: headers,
        //             processResults: function (data) {
        //                 return {
        //                     results: data.map(function (item) {
        //                         return {
        //                             id: item.id,
        //                             text: item.label // 'text' property is required by Select2
        //                         };
        //                     })
        //                 };
        //             },
        //             cache: true // Enable caching of AJAX results
        //         }
        //     });
        // }

        //Function to show loading message
        function showLoading() {
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                showConfirmButton: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
        }

        // Function to hide loading message
        function hideLoading() {
            Swal.close();
        }

        $("body").delegate(".applyBtn", "click", function () {
            var dates = document.getElementById('reservation').value;
            document.getElementById('date').value = dates;
        })
    </script>

    {{-- date rage script --}}
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });
        });
    </script>

    {{--  order counts on dashboard ajax data --}}
    <script>
        //filter form on dashboard for counts data


        function submitFilterForm() 
        {
            
            var data = $('#filter-form').serialize();


            showLoading();
            $.ajax({
                url: '<?php echo api_url('dashboard_data'); ?>',
                method: 'POST',
                data: data,
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    hideLoading();
                    // console.log(data.data.total_shipment)
                    if (data && data.status == 1) {

                        document.getElementById('total_shipment').innerText = data.data.total_shipment;
                        document.getElementById('delivered-payment-transfer').innerText = data.data.delivered_and_payment_transfer;
                        document.getElementById('delivered-ready-payment').innerText = data.data.delivered_and_ready_for_payment;
                        document.getElementById('in-process').innerText = data.data.total_in_process;
                        document.getElementById('being-return').innerText = data.data.total_being_return;
                        document.getElementById('return-to-shipper').innerText = data.data.total_return_to_shipper;

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
    </script>

    {{--  success rate and rate Per shipment ajax data  --}}
    <script>
        function successRateDounutAndRatePerShipment() {
            var successRateDateFrom = document.getElementById('success-rate-from').value;
            var successRateDateTo = document.getElementById('success-rate-to').value;
            //showLoading();

            //ticketSummary(headers);

            $.ajax({
                url: '<?php echo api_url('success_rate_and_rate_per_shipment'); ?>',
                method: 'POST',
                data: {datefrom:successRateDateFrom, dateto: successRateDateTo},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (result) {
                    hideLoading();

                    var data = {
                        labels: ["Success Rate", "Un Success Rate"],
                        datasets: [{
                            data: [result['success_rate'], result['un_success_rate']],
                            backgroundColor: ["#36A2EB", "#c71515"], // Color of the completed and remaining sections
                            hoverBackgroundColor: ["#36A2EB", "#EDEDED"]
                        }]
                    };

                    var options = {
                        cutoutPercentage: result['success_rate'], // Adjust this value to control the size of the hole in the donut
                        responsive: true,
                        legend: {
                            display: false // Hide the legend if not needed
                        }
                    };

                    // Get the canvas element
                    var successRateRatio = document.getElementById("doughnutChart1").getContext("2d");

                    // Create the percentage donut chart
                    var successRateRatioInit = new Chart(successRateRatio, {
                        type: 'doughnut',
                        data: data,
                        options: options
                    });


                    // doughnutChart1Init.data.labels[0] = 'Success Rate' + data['success_rate'] + '%';
                    // doughnutChart1Init.data.labels[1] = 'Un-Success Rate' + data['y1'] + '%';
                    // doughnutChart1Init.data.datasets[0].data[0] = data['total_delivered'];
                    // doughnutChart1Init.data.datasets[0].data[1] = data['total_count'];
                    // doughnutChart1Init.update();
                    $('#total-delivered').text(result['total_delivered']);
                    $('#total-packets').text(result['total_count']);
                    $('#doughnutChart1_percentage').text(result['success_rate'] + '%');
                    // document.getElementById('rate_per_shipment').innerText = result['rate_per_shipment'];

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
    </script>

    {{--  No Of Shippment ajax data  --}}
    <script>
        // No of shipment data
        var noOfShipmentlineChart;
        function noOfShipmentGraph() {
            //showLoading();

            // Get the no of shipment filter element by its ID
            var noOfShipmentDateFrom = document.getElementById('no_of_shipment_from').value;
            var noOfShipmentDateTo = document.getElementById('no_of_shipment_to').value;
            $.ajax({
                url: '<?php echo api_url('no_of_shipment'); ?>',
                method: 'POST',
                data: {datefrom: noOfShipmentDateFrom, dateto: noOfShipmentDateTo},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (noOfShipmentsData) {
                    var chartData = {
                        labels: [],
                        data: []
                    };
                    hideLoading();
                    // Iterate through the noOfShipmentsData and push data to chartData
                    noOfShipmentsData.data.forEach(function (item) {
                        chartData.data.push(item.bookings_count);
                        chartData.labels.push(item.booked_packet_date);
                    });

                    var ctx = document.getElementById('lineChart1').getContext('2d');

                    if(noOfShipmentlineChart){
                        noOfShipmentlineChart.destroy();
                    }

                    // Create line chart
                    noOfShipmentlineChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: chartData.labels,
                            datasets: [{
                                label: 'No Of Shipment',
                                data: chartData.data,
                                borderColor: 'yellow',
                                backgroundColor: 'rgba(0, 0, 255, 0.1)',
                                borderWidth: 1,
                                pointRadius: 5,
                                pointBackgroundColor: 'yellow',
                            }],
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });

                    noOfShipmentlineChart.update();
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
    </script>

    {{--  top ten destination and orders ajax data  --}}
    <script>
        function topTenDestinationAndOrders() {
            //showLoading();
            var date = document.getElementById('top-10-dest-daterange').value;
            $.ajax({
                url: '<?php echo api_url('top_ten_destination_and_orders'); ?>',
                method: 'POST',
                data: {date: date},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    hideLoading();
                    if (data && data.status == 1) {
                        var orderAndDestination = '';
                        var successRateTopTenDest = document.getElementById("success-rate-top-ten-dest");
                        data.data.forEach(function (item) {
                            topTenDestAndOrders = `<article class="media event mt-3" >
                                                        <a class="pull-left date">
                                                            <p class="month">April</p>
                                                            <p class="day">23</p>
                                                        </a>
                                                        <div class="media-body">
                                                            <a class="title" href="#">`+ item.city_name +`</a>
                                                            <p>` + item.bookings_count + `</p>
                                                        </div>
                                                    </article>`;
                            orderAndDestination += topTenDestAndOrders;
                        });
                        successRateTopTenDest.innerHTML = orderAndDestination;
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
    </script>

    {{--  summary report of client wise  --}}
    <script>
        function summaryReport(){
           //showLoading();
            var date = document.getElementById('summary-report-daterange').value;
            var client = document.getElementById('client_id').value;

            $.ajax({
                url: '<?php echo api_url('summary_report'); ?>',
                method: 'POST',
                data: {date: date, client: client},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (result) {
                    hideLoading();
                    barChartZoneWise(result.total_shipment, result.total_shipment_count);
                    lineChartZoneWise(result.total_shipment_zone_wise, result.total_shipment_zone_wise_count);
                    barChartCodAmountZoneWise(result.total_cod_amount_zone_wise, result.total_cod_amount);
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
        var totalShipmentBarChart;
        var lineChart;
        var myChartCod;
        function barChartZoneWise(shipments, shipmentCounts){
            
            var chartData = {
                labels: [],
                data: []
            };
            hideLoading();
            // Iterate through the noOfShipmentsData and push data to chartData
            shipments.forEach(function (item, index) {
                chartData.data.push(item.bookings_count);
                chartData.labels.push(item.city_name);
            });
            document.getElementById('total_shipment_client_wise').innerText = shipmentCounts;
            var ctx = document.getElementById('barCharts').getContext('2d');

            if (totalShipmentBarChart) {
                totalShipmentBarChart.destroy();
            }

            // Create a bar chart
            totalShipmentBarChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Bookings Count',
                        data: chartData.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: [{
                            display: false // Hide x-axis labels
                        }],
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            totalShipmentBarChart.update();
        }
        function lineChartZoneWise(totalShipments, totalShipmentCount){

            const xValues = [];
            const yValues = [];

            hideLoading();
            // Iterate through the noOfShipmentsData and push data to chartData
            totalShipments.forEach(function (item, index) {
                xValues.push(item.zone);
                yValues.push(item.bookings_count);
            });


            document.getElementById('total_shipment_zone_wise').innerText = totalShipmentCount;
            var ctx = document.getElementById('lineChartClientWise').getContext('2d');

            if (lineChart) {
                lineChart.destroy();
            }

            lineChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: xValues,
                    datasets: [{
                        label: "Shipment Count",
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "rgba(0,0,255,1.0)",
                        borderColor: "rgba(0,0,255,0.1)",
                        data: yValues
                    }]
                },
                options: {
                    legend: {display: false},
                    scales: {
                        x: [{
                            display: false // Hide x-axis labels
                        }],
                    }
                }
            });
            lineChart.update();
        }
        function barChartCodAmountZoneWise(CodAmountsZoneWise, totalCodAmount){
            var chartData = {
                labels: [],
                data: []
            };
            hideLoading();
            // Iterate through the noOfShipmentsData and push data to chartData
            CodAmountsZoneWise.forEach(function (item, index) {
                chartData.data.push(item.cod_amount);
                chartData.labels.push(item.zone);
            });
            document.getElementById('total_cod_amount').innerText = totalCodAmount;
            var ctx = document.getElementById('barChartCodAmount').getContext('2d');

            if (myChartCod) {
                myChartCod.destroy();
            }

            // Create a bar chart
            myChartCod = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Cod Amount',
                        data: chartData.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: [{
                            display: false // Hide x-axis labels
                        }],
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            myChartCod.update();
        }
    </script>

    {{--  weekly summary report script  --}}
    <script>
        function weeklySummaryReport(){
            //showLoading();
            var date = document.getElementById('weekly-summary-daterange').value;

            $.ajax({
                url: '<?php echo api_url('weekly_summary_report'); ?>',
                method: 'POST',
                data: {date: date},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (result) {
                    hideLoading();
                    weeklySummaryBarChart(result.summaryReport);
                    deliveryRatioDonut(result);
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
        var summaryBarChart; // Declare the global variable
        function weeklySummaryBarChart(summaryReports) {
            var chartData = {
                labels: [],
                data: []
            };

            hideLoading();

            // Iterate through the noOfShipmentsData and push data to chartData
            summaryReports.forEach(function (item, index) {
                chartData.data.push(item.bookings_count);
                chartData.labels.push(item.zone);
            });

            var summaryBarChartGraph = document.getElementById('WeeklySummarybarChart').getContext('2d');

            // Destroy the existing chart if it exists
            if (summaryBarChart) {
                summaryBarChart.destroy();
            }

            // Create a new bar chart
            summaryBarChart = new Chart(summaryBarChartGraph, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Bookings Count',
                        data: chartData.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: [{
                            display: false // Hide x-axis labels
                        }],
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        function deliveryRatioDonut(deliveryRatioData){

            var data = {
                labels: ["Delivery Ratio", "Remaining Ratio"],
                datasets: [{
                    data: [deliveryRatioData['delivery_ratio'], deliveryRatioData['undelivered_ratio']],
                    backgroundColor: ["#36A2EB", "#c71515"], // Color of the completed and remaining sections
                    hoverBackgroundColor: ["#36A2EB", "#EDEDED"]
                }]
            };

            var options = {
                cutoutPercentage: deliveryRatioData['delivery_ratio'], // Adjust this value to control the size of the hole in the donut
                responsive: true,
                legend: {
                    display: false // Hide the legend if not needed
                }
            };

            // Get the canvas element
            var donutDeliveryRatio = document.getElementById("percentageDonutChart").getContext("2d");

            // Create the percentage donut chart
            var donutDeliveryRatioInit = new Chart(donutDeliveryRatio, {
                type: 'doughnut',
                data: data,
                options: options
            });

            hideLoading();

            $('#total-delivered-ratio').text(deliveryRatioData['total_delivered']);
            $('#total-packets-ratio').text(deliveryRatioData['total_count']);
            $('#doughnut_percentage_delivery_ratio').text(deliveryRatioData['delivery_ratio'] + '%');

        }
    </script>

    {{--  ticket Summary bar chart  --}}
    <script>
        function ticketSummary(headers){
            showLoading();
            var dateFrom = $('#success-rate-from').val();
            var dateTo = $('#success-rate-to').val();
            $.ajax({
                url: '<?php echo api_url('support_ticket/statistic'); ?>',
                method: 'GET',
                data: {
                    ajax: true,
                    dateFrom : dateFrom,
                    dateTo: dateTo,
                    status : 0,
                    ticket_type : '',
                    issue_type : '',
                    destination_city : '',
                },
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    if (data) {
                        hideLoading();
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

        var ticketSummaryBarChart;
        function createchart(total_tickets,closedTickets,completedTickets,pendingTickets,OpenedTickets,reopenedTickets){
            var data = {
                labels: ["Total", "Closed","Completed", "Pending","Opened","Re-Opened"],
                datasets: [{
                    label: "Tickets Statistics",
                    data: [total_tickets, closedTickets, completedTickets,pendingTickets,OpenedTickets,reopenedTickets],
                    backgroundColor: ["rgba(75, 192, 192, 0.2)","rgba(75, 30, 2, 0.2)","rgba(40, 30, 2, 0.2)","rgba(40, 28, 2, 0.2)","rgba(75, 192, 192, 0.2)","rgba(75, 30, 2, 0.2)"],
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }]
            };

            var ctx = document.getElementById('ticketSummaryBarChart').getContext('2d');

            if (ticketSummaryBarChart) {
                ticketSummaryBarChart.destroy();
            }


            ticketSummaryBarChart = new Chart(ctx, {
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

    </script>

    {{--  first mile bar chart  --}}
    <script>

        function firstMileSummary(){
            //showLoading();
            var dateFrom = document.getElementById('first_mile_summary_from').value;
            var dateTo = document.getElementById('first_mile_summary_to').value;

            $.ajax({
                url: '<?php echo api_url('first_mile_summary'); ?>',
                method: 'POST',
                data: {dateFrom: dateFrom, dateTo: dateTo},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (result) {
                    // console.log(result)
                    hideLoading();
                    firstMileSummaryBarChart(result.result);
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
        var firstMileSummaryBar; // Declare the global variable
        function firstMileSummaryBarChart(summaryReports) {
            var chartData = {
                labels: [],
                data: []
            };

            hideLoading();
            // Iterate through the noOfShipmentsData and push data to chartData
            summaryReports.forEach(function (item, index) {
                chartData.data.push(item.bookings_count);
                chartData.labels.push(item.code);
            });

            var firstMileSummaryBarChartGraph = document.getElementById('firstMileSummaryBarChart').getContext('2d');

            // Destroy the existing chart if it exists
            if (firstMileSummaryBar) {
                firstMileSummaryBar.destroy();
            }

            // Create a new bar chart
            firstMileSummaryBar = new Chart(firstMileSummaryBarChartGraph, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Bookings Count',
                        data: chartData.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: [{
                            display: false, // Hide x-axis labels
                            ticks: {
                                stepSize: 2,    // Display even numbers only
                                max: Math.ceil(chartData.max / 2) * 2  // Ensure the maximum value is even
                            }
                        }],
                        y: {
                            beginAtZero: 1,

                        }
                    }
                }
            });
        }
    </script>

    {{--  reverse pickup summary bar chart  --}}
    <script>

        function reversePickupSummary(){
            //showLoading();
            var dateFrom = document.getElementById('reverse_pickup_summary_from').value;
            var dateTo = document.getElementById('reverse_pickup_summary_to').value;

            $.ajax({
                url: '<?php echo api_url('reverse_pickup_summary'); ?>',
                method: 'POST',
                data: {dateFrom: dateFrom, dateTo: dateTo},
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (result) {
                    // console.log(result)
                    hideLoading();
                    reversePickupSummaryBarChart(result.result);
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
        var reversePickupSummaryBar; // Declare the global variable
        function reversePickupSummaryBarChart(summaryReports) {
            var chartData = {
                labels: [],
                data: []
            };

            hideLoading();
            // Iterate through the noOfShipmentsData and push data to chartData
            summaryReports.forEach(function (item, index) {
                chartData.data.push(item.bookings_count);
                chartData.labels.push(item.code);
            });

            var reversePickupSummaryBarChartGraph = document.getElementById('reversePickupSummaryBarChart').getContext('2d');

            // Destroy the existing chart if it exists
            if (reversePickupSummaryBar) {
                reversePickupSummaryBar.destroy();
            }

            // Create a new bar chart
            reversePickupSummaryBar = new Chart(reversePickupSummaryBarChartGraph, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Bookings Count',
                        data: chartData.data,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: [{
                            display: false // Hide x-axis labels
                        }],
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    </script>

    {{--  news feeds section  --}}
    <script>
        function newsFeeds() {
            //showLoading();
            $.ajax({
                url: '<?php echo api_url('news_feeds'); ?>',
                method: 'POST',
                data: '',
                headers: headers,
                dataType: 'json', // Set the expected data type to JSON
                beforeSend: function () {
                    $('.error-container').html('');
                },
                success: function (data) {
                    hideLoading();
                    if (data && data.status == 1) {
                        var news = '';
                        var newsElement = document.getElementById("news-feeds");
                        data.data.forEach(function (item) {
                            const parts = item.created_at.split('-');
                            newsData = `<article class="media event">
                                                        <a class="pull-left date">
                                                            <p class="month">`+parts[0]+`</p>
                                                            <p class="day">`+parts[1]+`</p>
                                                        </a>
                                                        <div class="media-body">
                                                            <a class="title" href="#">`+item.news_title+`</a>
                                                            <p>`+item.news_content+`</p>
                                                        </div>
                                                    </article>`;
                            news += newsData;
                        });
                        newsElement.innerHTML = news;
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
    </script>

@endsection
