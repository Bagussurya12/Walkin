
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
  <title>{{ config('app.name', 'Laravel') }}</title>

  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

   <link rel="stylesheet" href="{{ asset('assets_backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css') }}">
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
  
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
    
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark navbar-navy">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars white"></i></a>
        </li>
        
      </ul>

    <!-- SEARCH FORM -->
    
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar white" type="search" @keyup.enter="cari_data" v-model="cari" placeholder="Cari Karyawan" aria-label="Cari">
        <div class="input-group-append">
          <button class="btn btn-navbar" @click="cari_data">
            <i class="fas fa-search white"></i>
          </button>
        </div>
      </div>
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fas fa-bell white"></i>
            </a>
        </li>
        
      </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="{{ asset('img/logo/ocbd.png') }}" alt="" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('img/karyawan/user.png') }}" class="img-circle elevation-2" alt="">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

    
     <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item has-treeview">
                <a href="/dashboard" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt blue"></i>
                  <p>
                    Dashboard
                   
                  </p>
                </a>
                
              </li>
              
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-book teal"></i>
                  <p>
                    Master Data
                    <i class="fas fa-angle-left right"></i>
                   
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/jabatan" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Jabatan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/level" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Level</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/departemen" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Departemen</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/divisi" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Divisi</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/agama" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Agama</p>
                    </a>
                  </li>
                  
                </ul>
              </li>
              
              <li class="nav-item has-treeview">
                <a href="/karyawan_personal" class="nav-link">
                  <i class="nav-icon fas fa-users cyan"></i>
                  <p>
                    Data Karyawan
                    
                  </p>
                </a>
                
              </li>
              <li class="nav-item">
                <a href="/konfigurasi" class="nav-link">
                  <i class="nav-icon fas fa-cog orange"></i>
                  <p>
                    Konfigurasi
                    
                  </p>
                </a>
                
              </li>
              <li class="nav-item">
                <a href="/profil" class="nav-link">
                  <i class="nav-icon fas fa-user green"></i>
                  <p>
                    Profil
                    
                  </p>
                </a>
                
              </li>
              
              <li class="nav-item">
                <a href="/user" class="nav-link">
                  <i class="nav-icon fas fa-users blue"></i>
                  <p>
                    Daftar User
                    
                  </p>
                </a>
                
              </li>
              <li class="nav-item">
                <a href="/developer" class="nav-link">
                  <i class="nav-icon fas fa-cog green"></i>
                  <p>
                    Developer
                    
                  </p>
                </a>
                
              </li>
              
              <li class="nav-item">
                <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                           
                  <i class="nav-icon fas fa-power-off red"></i>
                  <p>
                    {{ __('Logout') }} 
                    
                  </p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                
              </li>

              
        
         
          
        </ul>

        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        

        @yield('content')



      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="">PT Olimpics Bangun Persada</a>.</strong>
   
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.1
    </div>
  </footer>
 
  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  
</div>
<!-- ./wrapper -->



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
<script src="{{ asset('assets_backend/dist/js/pages/dashboard.js') }}"></script>
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
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
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
      format: 'LT'
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
</body>
</html>
