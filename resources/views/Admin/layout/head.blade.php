
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{ url_secure('build/images/logo/logo-removebg-preview.png')}}">
    <title> @yield('title') | Title  ADMIN</title>

    <!-- Bootstrap -->
    <link href="{{ url_secure('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ url_secure('vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ url_secure('vendors/nprogress/nprogress.css')}}" rel="stylesheet">

    <link href="{{ url_secure('vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.min.css')}}" rel="stylesheet">
    <!-- iCheck -->
    <link href="{{ url_secure('vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ url_secure('vendors/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-datetimepicker -->
    <link href="{{ url_secure('vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')}}" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="{{ url_secure('vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css')}}" rel="stylesheet">
    <!-- JQVMap -->
    <link href="{{ url_secure('vendors/jqvmap/dist/jqvmap.min.css')}}" rel="stylesheet"/>

    <!-- Datatables -->
    <!-- <link href="{{ url_secure('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url_secure('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url_secure('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url_secure('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url_secure('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ url_secure('vendors/select2/dist/css/select2.min.css')}}" rel="stylesheet">
    <link href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css" rel="stylesheet"> -->
    <!--    additional datatables-->
    <!-- <link href="{{ url_secure('vendors/datatable/vendors/css/tables/datatable/datatables.min.css')}}" rel="stylesheet"/> -->

    <!-- Custom Theme Style -->
    <link href="{{ url_secure('build/css/custom.min.css?id=6')}}" rel="stylesheet">

    <!--    multiselect-->
    <link href="{{ url_secure('vendors/multi_select/jquery.multiselect.css')}}" rel="stylesheet"/>
    <link href="{{ url_secure('vendors/sweet_alert/sweetalert2.min.css')}}"  rel="stylesheet"/>


    <style>
        .debug-bar-ndisplay{
            display: none!important;
        }
        .w-100 {
            width: 100% !important;
        }
        .float-right{
            float: right;
            padding: 0px 1px 12px 0px;
        }
        .animated {
            min-width: 100px;
            margin-left: -50px;
            right: 0; /* Add this line to move the ul towards the opposite direction */
        }
        .animated li a {
            white-space: nowrap; /* Add this line to prevent text from wrapping */
            overflow: hidden; /* Add this line to hide any overflow */
            text-overflow: ellipsis; /* Add this line to show ellipsis (...) for overflowing text */
        }
        .animated li button {
            white-space: nowrap; /* Add this line to prevent text from wrapping */
            overflow: hidden; /* Add this line to hide any overflow */
            text-overflow: ellipsis; /* Add this line to show ellipsis (...) for overflowing text */
            display: block;
            padding: 1px 36px;
            margin-bottom: 0px;
        }
        .limited{
            max-width: 100px;
            overflow-x: auto;
        }
        .d-none{
            display: none;
        }
        .leopard_loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .dataTables_wrapper {
            min-height: 500px!important;
        }
        div.dataTables_wrapper div.dataTables_processing {
            background: transparent!important;
            border: transparent!important;
        }


        .leopard_loader img {
            width: 120px;
            height: 100px;
        }


    </style>

    <style>
        .corier_van {
            background: url({{ url_secure('build/images/van.png') }}) no-repeat;
            height: 140px;
            width: 260px;
            background-size: 100% 100%;
            display: table-cell;
            text-align: left;
            font-size: 10px;
            font-weight: bold;
            font-size: 12px;
        }

        .custom-button {
            background: none;
            border: none;
            text-decoration: underline;
            cursor: pointer;
        }

        .custom-button:hover {
            text-decoration: none; /* Remove underline on hover */
        }

        #bgSetter {
            background:url({{url_secure('build/images/track_bg.png')}}) center center no-repeat;
            background-size: 60%;
        }
        .corier_van p {
            padding-left: 50px;
            text-align: center;
            width: 135px;
            display: inline;
        }
        .corier_van input[type=text] {
            width:110px;
            font-size:12px;
            font-weight:bold;
            border:none;
            background:none;
        }
        .modal-lg {
            width: 900px;
        }
        .modal-lg, .modal-xl {
            max-width: 900px;!important;
        }
    </style>


