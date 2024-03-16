
<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Buku Tamu Online') }}</title>
  <link rel="shortcut icon" href="{{ asset('assets_backend/img/logo/iconlogo.png') }}">

  
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
   <link rel="stylesheet" href="{{ asset('assets_backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/summernote/summernote-bs4.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_backend/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">
    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

    
   <style>
     #mapid { height: 290px; width:100% }
     </style>

     <style>
    #container {
      height: 400px;
    }

    .highcharts-figure, .highcharts-data-table table {
      min-width: 70%; 
      max-width: 100%;
      margin: 1em auto;
    }

    .highcharts-data-table table {
      font-family: Verdana, sans-serif;
      border-collapse: collapse;
      border: 1px solid #EBEBEB;
      margin: 10px auto;
      text-align: center;
      width: 100%;
      max-width: 70%;
    }
    .highcharts-data-table caption {
      padding: 1em 0;
      font-size: 1.2em;
      color: #555;
    }
    .highcharts-data-table th {
      font-weight: 600;
      padding: 0.5em;
    }
    .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
      padding: 0.5em;
    }
    .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
      background: #f8f8f8;
    }
    .highcharts-data-table tr:hover {
      background: #f1f7ff;
    }


    
    /*css3 design scrollbar*/
    ::-webkit-scrollbar {
       
        width: 20px;
    }
    
    ::-webkit-scrollbar-track {
      
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);     
        background: #666;    
    }
    
    ::-webkit-scrollbar-thumb {
      border-radius: 30px;
        background: #DAA520;
    }

   
</style>


<link rel="stylesheet" type="text/css" href="{{ asset('assets_backend/dist/loader/css/costum.css') }}">
<script type="text/javascript" src="{{ asset('assets_backend/dist/loader/js/loader.js') }}"></script>

</head>
<body class="hold-transition layout-top-nav layout-footer-fixed">
 
  
 @yield('content')



<script src="{{ asset('assets_backend/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{ asset('assets_backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/sparklines/sparkline.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('assets_backend/dist/js/adminlte.js') }}"></script>

<script src="{{ asset('assets_backend/dist/js/demo.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script src="{{ asset('assets_backend/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!--<script src="assets_backend/dist/js/adminlte.min.js"></script>-->

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $("#example3").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });


  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    $('#reservationdate1').datetimepicker({
      format: 'YYYY-MM-DD'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'YYYY-MM-DD hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'HH:mm'
    })

    $('#timepicker1').datetimepicker({
      format: 'HH:mm'
    })

    $('#timepicker2').datetimepicker({
      format: 'HH:mm'
    })

    $('#timepicker3').datetimepicker({
      format: 'HH:mm'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>

<script async src='https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js'></script>
        <script>
          var wa_btnSetting = {"btnColor":"#16BE45","ctaText":"Perlu Bantuan","cornerRadius":40,"marginBottom":65,"marginLeft":20,"marginRight":20,"btnPosition":"right","whatsAppNumber":"+6281288650512","welcomeMessage":"Hai Novan, ","zIndex":999999,"btnColorScheme":"light"};
          var wa_widgetSetting = {"title":"OCBD","subTitle":"One Central Bussiness District","headerBackgroundColor":"#231a65","headerColorScheme":"light","greetingText":"Semangat Pagi, \nPerlu Bantuan, Silahkan Chat Saja","ctaText":"Mulai Chat WA","btnColor":"#0ba82a","cornerRadius":40,"welcomeMessage":"Hello","btnColorScheme":"light","brandImage":"https://hr.ocbd.co.id/assets_backend/img/logo/ocbdnew.png","darkHeaderColorScheme":{"title":"#333333","subTitle":"#4F4F4F"}};  
          window.onload = () => {
            _waEmbed(wa_btnSetting, wa_widgetSetting);
          };
        </script>

@yield('footer')
</body>
</html>
