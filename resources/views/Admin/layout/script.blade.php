<script src="{{ url_secure('vendors/jquery/dist/jquery.min.js')}}"></script>
<script src="{{ url_secure('/vendors/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ url_secure('/vendors/fastclick/lib/fastclick.js')}}"></script>
<script src="{{ url_secure('vendors/nprogress/nprogress.js')}}"></script>
<script src="{{ url_secure('vendors/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<script src="{{ url_secure('vendor/Chart.js/dist/Chart.min.js')}}"></script>
<script src="{{ url_secure('/vendors/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<script src="{{ url_secure('vendors/iCheck/icheck.min.js')}}"></script>
<script src="{{ url_secure('vendors/moment/min/moment.min.js')}}"></script>
<script src="{{ url_secure('vendors/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<script src="{{ url_secure('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{ url_secure('vendors/gauge.js/dist/gauge.min.js')}}"></script>
<script src="{{ url_secure('vendors/bootstrap-progressbar/bootstrap-progressbar.min.js')}}"></script>
<script src="{{ url_secure('vendors/skycons/skycons.js')}}"></script>
<script src="{{ url_secure('vendors/Flot/jquery.flot.js')}}"></script>
<script src="{{ url_secure('vendors/Flot/jquery.flot.pie.js')}}"></script>
<script src="{{ url_secure('vendors/Flot/jquery.flot.time.js')}}"></script>
<script src="{{ url_secure('vendors/Flot/jquery.flot.stack.js')}}"></script>
<script src="{{ url_secure('vendors/Flot/jquery.flot.resize.js')}}"></script>
<script src="{{ url_secure('vendors/flot.orderbars/js/jquery.flot.orderBars.js')}}"></script>
<script src="{{ url_secure('vendors/flot-spline/js/jquery.flot.spline.min.js')}}"></script>
<script src="{{ url_secure('vendors/flot.curvedlines/curvedLines.js')}}"></script>
<script src="{{ url_secure('vendors/DateJS/build/date.js')}}"></script>
<script src="{{ url_secure('vendors/jqvmap/dist/jquery.vmap.js')}}"></script>
<script src="{{ url_secure('vendors/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
<script src="{{ url_secure('vendors/jqvmap/examples/js/jquery.vmap.sampledata.js')}}"></script>
<script src="{{ url_secure('vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js')}}"></script>
<!-- <script src="{{ url_secure('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ url_secure('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{ url_secure('vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ url_secure('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{ url_secure('vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{ url_secure('vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ url_secure('vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ url_secure('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{ url_secure('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{ url_secure('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ url_secure('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
<script src="{{ url_secure('vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
<script src="https://editor.datatables.net/extensions/Editor/js/dataTables.editor.min.js"></script> -->
<!-- <script src="{{ url_secure('vendors/select2/dist/js/select2.full.min.js')}}"></script> -->

<script src="{{ url_secure('vendors/jszip/dist/jszip.min.js')}}"></script>
<script src="{{ url_secure('vendors/pdfmake/build/pdfmake.min.js')}}"></script>
<script src="{{ url_secure('vendors/pdfmake/build/vfs_fonts.js')}}"></script>
<script src="{{ url_secure('vendors/datatable/vendors/js/tables/datatable/datatables.min.js')}}"></script>
<script src="{{ url_secure('vendors/datatable/scripts/tables/datatables/datatable-basic.js')}}"></script>
<script src="{{ url_secure('build/js/custom.min.js')}}"></script>    <!-- ok -->
<script src="{{ url_secure('build/js/main-2.2.js')}}"></script>
<script src="{{ url_secure('vendors/multi_select/jquery.multiselect.js')}}"></script>
<script src="{{ url_secure('vendors/sweet_alert/sweetalert2.all.min.js')}}"></script>   <!-- ok -->
<script src="{{ url_secure('printThis.js')}}" type="text/javascript"></script>
<script src="{{ url_secure('build/js/ScantumToken.js?id=6')}}"></script>   <!-- ok -->
<script src="{{ url_secure('build/js/jquery.toaster.js?id=2')}}"></script>
<script src="{{ url_secure('vendors/validate/jquery.validate.min.js')}}" type="text/javascript"></script>  <!-- ok -->
<script src="{{ url_secure('build/js/jquery_ui.js')}}"></script>

<!---------- for firebase token check ---------------- -->
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> -->
<!-- <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase.js"></script> -->
<!-- <script src="{{ url_secure('build/js/CheckForToken.js')}}"></script> -->
                
<script>


    $(document).ready(function () 
    {
        // $('.select2').select2();
        // CheckForToken();
    });
    const token5 = getToken();
    const headers5 = {
        "Authorization": `Bearer ${token5}`,
    };
    var myUser = JSON.parse(getUser());
    // console.log(myUser)
    // return false;

    window.onload = function () 
    {
        document.getElementById('leopard_loader').style.display = 'none';
       
        if (myUser.user_type_id != 1) 
        {
            // delayfunc();
            // $.ajax({
            //     url: '<?php echo api_url('permissions/update'); ?>',
            //     method: 'GET',
            //     data: {ajax: true, user_id: myUser.id},
            //     dataType: 'json', // Set the expected data type to JSON
            //     headers: headers5,
            //     beforeSend: function () {
            //         $('.error-container').html('');
            //     },
            //     success: function (data) {
            //         if (data && data.status == 1) {
            //             savePermissions(JSON.stringify(data.permissions));
            //             delayfunc();
            //         } else {
            //             Swal.fire(
            //                 'Error!',
            //                 'Something Went Wrong',
            //                 'error'
            //             );
            //         }
            //     },
            //     error: function (xhr, textStatus, errorThrown) {
            //         // Handle AJAX errors here
            //         Swal.fire(
            //             'Error!',
            //             'Form submission failed: ' + errorThrown,
            //             'error'
            //         );
            //     }
            // });
        }
    }

    // function delayfunc(id = 0) {
    //     if (myUser.user_type_id != 1) {
    //         console.log('here');
    //         var permissions = JSON.parse(getPermissions());

    //         var GetModules = document.querySelectorAll('[data-module-id]');
    //         var GetSubModules = document.querySelectorAll('[data-sub-module-id]');


    //         var GetClientModule = Object.values(permissions.module_id).map(String);
    //         var GetClientSubModules = Object.values(permissions.sub_module_id).map(String);


    //         GetModules.forEach(function (modules) {
    //             var module_id = `${modules.getAttribute("data-module-id")}`;

    //             if (GetClientModule.includes(module_id)) {
    //                 modules.style.display = 'block'; // Set display to 'block'
    //             } else {
    //                 modules.style.display = 'none'; // Set display to 'none'
    //             }

    //             GetSubModules.forEach(function (submodules) {
    //                 var sub_module_id = submodules.getAttribute('data-sub-module-id');
    //                 if (GetClientSubModules.includes(sub_module_id)) {
    //                     submodules.style.display = 'block'; // Set display to 'block'
    //                 } else {
    //                     submodules.style.display = 'none'; // Set display to 'none'
    //                 }
    //             });
    //         });
    //         var GetScreenPermissions = document.querySelectorAll('[data-screen-permission-id]');
    //         var GetClientScreenSubModules = Object.values(permissions.screens).map(String);

    //         GetScreenPermissions.forEach(function (screenPermission) {

    //             var screen_permission_id = `${screenPermission.getAttribute("data-screen-permission-id")}`;

    //             if (GetClientScreenSubModules.includes(screen_permission_id)) {
    //                 screenPermission.style.display = 'block'; // Set display to 'block'
    //                 screenPermission.disabled = false;
    //             } else {
    //                 screenPermission.style.display = 'none'; // Set display to 'none'
    //                 screenPermission.disabled = true;
    //             }
    //         });
    //     }
    // }
</script>

<script>
    // $('#packet_detail').on('show.bs.modal', function (event) {
    //     var button = $(event.relatedTarget); // Button that triggered the modal
    //     var booked_packet_cn = button.data('booked_packet_cn'); // Extract data from data-* attributes
    //     var is_admin = (button.data('is_admin')) ? button.data('is_admin') : 0;

    //     $.ajax({
    //         url: '<?php echo api_url('manage_booking/my_arrivals/track_packet') ?>', // Replace with your backend URL
    //         type: 'GET',
    //         headers:headers,
    //         data: {booked_packet_cn,is_admin},
    //         beforeSend: function(){
    //             $('#packet_body').html('');
    //             $('#packet_body').html(`<div class="text-center"><img src="${giff_url}" alt="Loading..."></div>`);
    //         },
    //         success: function (response) {
    //             $('#packet_body').html(response);
    //         },
    //         error: function (error) {
    //         }
    //     });
    // });
    // function printView(data) {
    //     $(data).printThis({
    //         debug: false,               // show the iframe for debugging
    //         importCSS: true,            // import parent page css
    //         importStyle: true,          // import style tags
    //         printContainer: true,       // print outer container/$.selector
    //         loadCSS: "",                // path to additional css file - use an array [] for multiple
    //         pageTitle: "",              // add title to print page
    //         removeInline: false,        // remove inline styles from print elements
    //         removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
    //         printDelay: 1000,           // variable print delay
    //         header: null,               // prefix to html
    //         footer: null,               // postfix to html
    //         base: false,                // preserve the BASE tag or accept a string for the URL
    //         formValues: true,           // preserve input/form values
    //         canvas: false,              // copy canvas content
    //         doctypeString: '...',       // enter a different doctype for older markup
    //         removeScripts: false,       // remove script tags from print content
    //         copyTagClasses: true,       // copy classes from the html & body tag
    //         copyTagStyles: true,        // copy styles from html & body tag (for CSS Variables)
    //         beforePrintEvent: null,     // function for printEvent in iframe
    //         beforePrint: null,          // function called before iframe is filled
    //         afterPrint: null            // function called before iframe is removed
    //     });
    // }
    // $('#client_view').on('show.bs.modal', function (event) {
    //     var button = $(event.relatedTarget); // Button that triggered the modal
    //     var merchant_name = button.data('merchant_name');
    //     var merchant_address1 = button.data('merchant_address1');
    //     var merchant_phone = button.data('merchant_phone');
    //     var merchant_email = button.data('merchant_email');
    //     var merchant_account_no = button.data('merchant_account_no');
    //     var merchant_account_opening_date = button.data('merchant_account_opening_date');
    //     if(merchant_account_opening_date.length == 0){
    //         merchant_account_opening_date = 'N/A';
    //     }
    //     if(merchant_email.length == 0){
    //         merchant_email = 'N/A';
    //     }

    //     $('#data_merchant_name').text(merchant_name);
    //     $('#data_merchant_address1').text(merchant_address1);
    //     $('#data_merchant_phone').text(merchant_phone);
    //     $('#data_merchant_email').text(merchant_email);
    //     $('#data_merchant_account_no').text(merchant_account_no);
    //     $('#data_merchant_account_opening_date').text(merchant_account_opening_date);

    // });
</script>
