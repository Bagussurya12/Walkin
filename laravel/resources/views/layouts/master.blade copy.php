
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
  <title>{{ config('app.name', 'HR-SYSTEM') }}</title>

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
      min-width: 420px; 
      max-width: 700px;
      margin: 1em auto;
    }

    .highcharts-data-table table {
      font-family: Verdana, sans-serif;
      border-collapse: collapse;
      border: 1px solid #EBEBEB;
      margin: 10px auto;
      text-align: center;
      width: 100%;
      max-width: 500px;
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


</style>
</head>
<body class="hold-transition sidebar-mini">
    
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars white"></i></a>
        </li>
        
      </ul>

    <!-- SEARCH FORM -->
    
      
    

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
        <img src="{{ asset('assets_backend/img/logo/ocbd.png') }}" alt=""  class="brand-image img-circle elevation-3"
             style="background-color:white;">
        <span class="brand-text font-weight-light">{{ config('app.name', 'HR-SYSTEM') }}</span>
      </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="info">
          <center> <a href="" class="d-block">{{ Auth::user()->name }} </a></center>
        </div>
      </div>

    
     <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               
              @if(Auth::user()->level == 'karyawan')
              <li class="nav-item has-treeview">
                <a href="/dashboard" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt blue"></i>
                  <p>
                    Dashboard
                   
                  </p>
                </a>
                
              </li>
              <li class="nav-item">
                <a href="{{ route('user.absenonline') }}" class="nav-link">
                  <i class="nav-icon fas fa-clock"></i>
                  <p>
                    Absen Online
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('user.formkaryawan') }}" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                    Form Karyawan
                    
                   
                  </p>
                </a>
                
              </li>

              @else
              
              <li class="nav-item has-treeview">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                  <i class="nav-icon fas fa-tachometer-alt blue"></i>
                  <p>
                    Dashboard Info
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
                    <a href="/golongan" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Golongan</p>
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
                    <a href="/agama" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Agama</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="/jatahcuti" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>
                        Jatah Cuti Karyawan
                        
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/jamkerja" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Jam Kerja</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/kategoriabsen" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Kategori Absen</p>
                    </a>
                  </li>
                  
                </ul>
              </li>
              
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-users cyan"></i>
                  <p>
                    Data Karyawan
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Sinc. Karyawan Baru</p>
                    </a>
                  </li>
                  
                  <li class="nav-item">
                    <a href="/karyawan_personal" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Input Data Karyawan</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Report
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/reportkaryawan1" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Semua Data</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/reportpendidikankaryawan" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Filter By Pendidikan</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/reportgolongankaryawan" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Filter By Golongan</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/reportjabatankaryawan" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Filter By Jabatan</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/reportlevelkaryawan" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Filter By Level</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/reportdepartemenkaryawan" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Filter By Departemen</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/reportagamakaryawan" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Filter By Agama</p>
                        </a>
                      </li>
                      
                    </ul>
                  </li>
                 
                  
                </ul>
                
              
                
              </li>
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-clock"></i>
                  <p>
                    Data Absensi
                    <i class="fas fa-angle-left right"></i>
                   
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  
                  <li class="nav-item">
                    <a href="/absenharian" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p> Data Absensi
                        
                      </p>
                    </a>
                    
                  </li>
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Report
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="/reportabsenharian" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Absensi Harian</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/reportabsenbulanan" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Absensi Bulanan</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/reportabsentahunan" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Absensi Tahunan</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="/reportabsenterlambat" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Datang Terlambat</p>
                        </a>
                      </li>
                      
                    </ul>
                  </li>
                  
                  
                </ul>
              </li>

              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                     Form Karyawan
                    <i class="fas fa-angle-left right"></i>
                   
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.pengajuankaryawan') }}" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Pengajuan Form
                        
                      </p>
                    </a>
                    
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Penilaian Karyawan
                        
                      </p>
                    </a>
                    
                  </li>
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Report
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Lembur Karyawan</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Cuti, Ijin dll</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Penilaian Karyawan</p>
                        </a>
                      </li>
                      
                      
                    </ul>
                  </li>
                  
                  
                </ul>
              </li>

              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-credit-card"></i>
                  <p>
                    Payroll Karyawan
                    <i class="fas fa-angle-left right"></i>
                   
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Input Gaji 
                        
                      </p>
                    </a>
                    
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Cetak SLip Gaji
                        
                      </p>
                    </a>
                    
                  </li>
                  
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="fa fa-circle nav-icon"></i>
                      <p>Report
                        <i class="fas fa-angle-left right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Gaji Perbulan</p>
                        </a>
                      </li>

                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="fa fa-circle nav-icon"></i>
                          <p>Tunjangan, asuransi</p>
                        </a>
                      </li>
                      
                      
                      
                    </ul>
                  </li>
                  
                  
                </ul>
              </li>



              <li class="nav-item has-treeview">
                <a href="/userlogin" class="nav-link">
                  <i class="nav-icon fas fa-cog"></i>
                  <p>
                    Akun Karyawan
                    
                  </p>
                </a>
              </li>

              @endif
              

              
              

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
        <div class="content-header">
          <div class="container-fluid">
            @if(Auth::user()->level == 'hrd' || Auth::user()->level == 'admin')
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">@yield('judul')</h1>
                
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">HR System</a></li>
                  <li class="breadcrumb-item active">@yield('judul')</li>
                </ol>
              </div><!-- /.col -->
              
            </div><!-- /.row -->
            <hr/>
            @endif
           
          </div><!-- /.container-fluid -->
        </div>

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
@yield('footer')
</body>
</html>
