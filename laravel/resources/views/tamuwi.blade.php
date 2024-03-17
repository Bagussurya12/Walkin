
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


    
    /*css3 design scrollbar*/
    ::-webkit-scrollbar {
        width: 10px;
    }
    
    ::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);     
        background: #666;    
    }
    
    ::-webkit-scrollbar-thumb {
        background: #DAA520;
    }

   
</style>


<link rel="stylesheet" type="text/css" href="{{ asset('assets_backend/dist/loader/css/costum.css') }}">
<script type="text/javascript" src="{{ asset('assets_backend/dist/loader/js/loader.js') }}"></script>

</head>
<body class="hold-transition layout-top-nav layout-footer-fixed">
 
  
    <div style="background-color: #6495ED; padding-top:15px; padding-bottom:15px;">
        <table width="100%" border="0">
          <tr>
            <td width="10%">
                <center>
                  <a  href="/">
                    <img src="{{ asset('assets_backend/img/icon/previous.svg') }}" width="30px"  />
                    
                  </a>
                </center>
        
              </td>
            <td width="90%">
              <div style="align-items: center; text-align: center; color:white; font-weight: bold;">Online Guestbook App</div>
            </td>
           
          </tr>
        </table>
        
        
       
        
        
      </div>
      
      
      
      <div class="wrapper">
      
        <section class="content">
          <div class="container-fluid">
              <div class="row mt-3">
                <div class="col-12">
      
                  @if ($message = Session::get('success'))
                  <div class="alert alert-success alert-block mt-3">
                      <button type="button" class="close" data-dismiss="alert">×</button>
                      <strong>{{ $message }}</strong>
                  </div>
                  @endif
      
                  @if ($message = Session::get('error'))
                      <div class="alert alert-danger alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <strong>{{ $message }}</strong>
                      </div>
                  @endif
      
                  @if ($message = Session::get('warning'))
                      <div class="alert alert-warning alert-block">
                          <button type="button" class="close" data-dismiss="alert">×</button>
                          <strong>{{ $message }}</strong>
                      </div>
                  @endif
      
                  <div class="card mt-3">
                    <script type='text/javascript'>
                      $(window).load(function(){
                      $("#pilihsumber").change(function() {
                            console.log($("#pilihsumber option:selected").val());
                            if ($("#pilihsumber option:selected").val() == 'lain') {
                              $('#sumberlain').prop('hidden', false);
                            } else {
                              $('#sumberlain').prop('hidden', 'true');
                            }
                          });
                      });
                      </script>
                        <div class="card-body">
                          
                          <form class="form-horizontal" method="POST" action="{{ route('user.buattamuwi') }}">
                            @csrf
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <input type="text" name="nama" autocomplete="off" required class="form-control" placeholder="Input Nama">
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <input type="number" min="0" autocomplete="off" name="hp" required class="form-control" placeholder="Input handphone" >
                              </div>
                            </div>
      
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <input type="email" name="email" autocomplete="off" class="form-control" placeholder="Input email">
                              </div>
                            </div>
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" name="tgl_lahir"  class="form-control" placeholder="Input Tanggal Lahir">
                              </div>
                            </div>

                            <div class="form-group row">
                              <div class="col-sm-12">
                                <select class="form-control select2bs4"  required name="jk"  style="width: 100%;">
                                  <option value="">Pilih Jenis Kelamin</option>
                                  <option value="pria" >Pria</option>
                                  <option value="wanita" >Wanita</option>
                                  
                                </select>
                              </div>
                            </div>
      
                           
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <select class="form-control select2bs4" id="pilihsumber" required name="sumber"  style="width: 100%;">
                            <option value="">Pilih Sumber Informasi</option>
                            <option value="billboard tol">Billboard Tol</option>
                            <option value="billboard jalan raya bogor">Billboard Jalan Raya Bogor</option>
                            <option value="database" >Database</option>
                            <option value="flyer">Flyer</option>
                            <option value="media publikasi">Media Publikasi (Koran/Majalah/Radio/TV)</option>
                            <option value="social media">Social Media (IG/FB/Tik-Tok/Linkedin)</option>
                            <option value="t-banner">T-Banner</option>
                            <option value="sign-board">Sign-Board</option>
                            <option value="website" >Website</option>
                            <option value="lain-lain" >Lain-lain</option>
                            
                          </select>
                          <input type="text" name="sumberlain" autocomplete="off" id="sumberlain" hidden class="form-control mt-3" placeholder="Input sumber informasi lain">
                        </div>
                      </div>
      
                            <div class="form-group row">
                              <div class="col-sm-12">
                                <input type="text" name="referensi" autocomplete="off" class="form-control" placeholder="Input referensi">
                              </div>
                            </div>

                            <div class="form-group row">
                              <div class="col-sm-12">
                                <input type="text" name="alamat" autocomplete="off" class="form-control" placeholder="Input alamat domisili">
                              </div>
                            </div>
        
                            <div class="form-group row">
                                <div class="col-sm-12">
                                  <select class="form-control select2bs4" required name="sales"  style="width: 100%;">
                                    <option value="">Pilih sales</option>
                                    @foreach($data_sales as $dt)
                                     <option value="{{ $dt->id }}" >{{ $dt->name }}</option>
                                    @endforeach
                                  </select>
                                </div>
                              </div>
                            
                              <button type="submit" class="btn btn-info btn-block">Simpan</button>
                           
                          </form>
      <br><br><br>
                        
                        </div>
                        
                      </div>
                    </div>
              </div>
             
            </div>
          </section>
      
      
          <footer class="main-footer" style=" color:white;  background-color: #6495ED">
            <center>
            <strong>Input Data Tamu WI</strong>
            </center>
          </footer>
        </div>
      
        
      



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
<script async src='https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js'></script>
        <script>
          var wa_btnSetting = {"btnColor":"#16BE45","ctaText":"Perlu Bantuan","cornerRadius":40,"marginBottom":60,"marginLeft":20,"marginRight":20,"btnPosition":"right","whatsAppNumber":"+6281288650512","welcomeMessage":"Hai Novan, ","zIndex":999999,"btnColorScheme":"light"};
          var wa_widgetSetting = {"title":"OCBD","subTitle":"One Central Bussiness District","headerBackgroundColor":"#231a65","headerColorScheme":"light","greetingText":"Semangat Pagi, \nPerlu Bantuan, Silahkan Chat Saja","ctaText":"Mulai Chat WA","btnColor":"#0ba82a","cornerRadius":40,"welcomeMessage":"Hello","btnColorScheme":"light","brandImage":"https://hr.ocbd.co.id/assets_backend/img/logo/ocbdnew.png","darkHeaderColorScheme":{"title":"#333333","subTitle":"#4F4F4F"}};  
          window.onload = () => {
            _waEmbed(wa_btnSetting, wa_widgetSetting);
          };
        </script>

@yield('footer')
</body>
</html>
