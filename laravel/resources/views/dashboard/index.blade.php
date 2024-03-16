@extends('layouts.master')
@section('judul','Dashboard Menu')

@section('content')
<div style="background-color: #6495ED; padding-top:15px; padding-bottom:15px;">
  <table width="100%" border="0">
    <tr>
      <td width="90%">
        <div style="align-items: center; text-align: center; color:white; font-weight: bold;">Online Guestbook App</div>
      </td>
      <td width="10%">
        
        <center>
        <a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                           <font color="white"> Logout</font>
                                  <img src="{{ asset('assets_backend/img/icon/log-out.svg') }}" width="30px"  />
                               
                          </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </center>
      </td>
    </tr>
  </table>
  
</div>

<div class="wrapper">
  @if ($message = Session::get('success'))
  <div class="alert alert-success alert-block mt-3">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{{ $message }}</strong>
  </div>
  @endif

  @if ($message = Session::get('error'))
    <div class="alert alert-danger alert-block mt-3">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
  @endif

  @if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block mt-3">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
  @endif
<div class="content-wrapper">
  <div class="content">
    <div class="container-fluid">
      
      @if(Auth::user()->level == 'sales')
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2" >
          <a href="{{ route('user.buattamu') }}">
            <div class="callout callout-info text-center" style="background-color: #20B2AA">
              <img src="{{ asset('assets_backend/img/icon/notebook.svg') }}" width="200px"  /><br />
              <div style="font-family: sans-serif; color:white; font-size: 40px;">Catat Tamu Baru</div>
            </div>
          </a>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2">
          <a href="{{ route('user.tamu') }}">
            <div class="callout callout-info text-center" style="background-color: #20B2AA">
              <img src="{{ asset('assets_backend/img/icon/guests.svg') }}" width="200px"  /><br />
             <div style="font-family: sans-serif; color:white; font-size: 40px;">Daftar Tamu Anda</div>
            </div>
          </a>
        </div>
      </div>
      @endif

      @if(Auth::user()->level == 'sales_senior')
      <div class="row">
        
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2">
          <a href="{{ route('user.tamu') }}">
            <div class="callout callout-info text-center" style="background-color: #20B2AA">
              <img src="{{ asset('assets_backend/img/icon/guests.svg') }}" width="200px"  /><br />
             <div style="font-family: sans-serif; color:white; font-size: 40px;">Daftar Tamu Sales</div>
            </div>
          </a>
        </div>
      </div>
      @endif

      @if(Auth::user()->level == 'manager')
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2" >
          <a href="{{ route('admin.tamu') }}">
            <div class="callout callout-info text-center" style="background-color: #20B2AA">
              <img src="{{ asset('assets_backend/img/icon/guests.svg') }}" width="200px"  /><br />
              <div style="font-family: sans-serif; color:white; font-size: 40px;">Daftar Tamu</div>
            </div>
          </a>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-2">
          <a href="{{ route('admin.grafik_reporttamu') }}">
            <div class="callout callout-info text-center" style="background-color: #20B2AA">
              <img src="{{ asset('assets_backend/img/icon/seo-report.svg') }}" width="200px"  /><br />
             <div style="font-family: sans-serif; color:white; font-size: 40px;">Laporan</div>
            </div>
          </a>
        </div>
      </div>
      @endif

      @if(Auth::user()->level == 'admin')
      <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2" >
          <a href="/userlogin">
            <div class="callout callout-info text-center" style="background-color: #20B2AA">
              <img src="{{ asset('assets_backend/img/icon/notebook.svg') }}" width="200px"  /><br />
              <div style="font-family: sans-serif; color:white; font-size: 40px;">Setting Akun</div>
            </div>
          </a>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt-2" >
          <a href="{{ route('admin.tamu') }}">
            <div class="callout callout-info text-center" style="background-color: #20B2AA">
              <img src="{{ asset('assets_backend/img/icon/guests.svg') }}" width="200px"  /><br />
              <div style="font-family: sans-serif; color:white; font-size: 40px;">Daftar Tamu</div>
            </div>
          </a>
        </div>
        
      </div>
      @endif


    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>

<!-- /.content-wrapper -->
<footer class="main-footer" style=" color:white;  background-color: #6495ED">
  <strong>Catat Semua Tamu Secara Online</strong>
  <div class="float-right" >
   
          <a href="{{ route('user.profilkaryawan') }}"><font color="white"> Account</font> <img src="{{ asset('assets_backend/img/icon/profile-user.svg') }}" width="30px"  /></a>
         
    
  </div>
</footer>

</div>
@endsection
