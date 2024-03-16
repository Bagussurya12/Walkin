@extends('layouts.master')
@section('judul', 'Profil Karyawan ')

@section('content')
<div style="background-color: #6495ED; padding-top:15px; padding-bottom:15px;">
    <table width="100%" border="0">
      <tr>
        <td width="10%">
          <center>
          <a onclick="goBack()" href="#">
            <img src="{{ asset('assets_backend/img/icon/previous.svg') }}" width="30px"  />
            <font color="white"> Back</font>
          </a>
          </center>
  
          <script>
            function goBack() {
                window.history.back();
            }
        </script>
        </td>
        <td width="80%">
          <div style="align-items: center; text-align: center; color:white; font-weight: bold;">Online Guestbook App</div>
        </td>
        <td width="80%">
          <a href="{{ route('logout') }}"  onclick="event.preventDefault();
                                              document.getElementById('logout-form').submit();">
                             <font color="white"> Logout</font>
                             <img src="{{ asset('assets_backend/img/icon/log-out.svg') }}" width="30px"  />
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
        </td>
      </tr>
    </table>
    
    
   
    
    
  </div>
  
  
  
  <div class="wrapper">

    <section class="content">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline ">
                        <div class="card-body box-profile">
                            <h3 class="profile-username text-center">{{ $personal->name }}</h3>
                            <table class="table table-striped table-valign-middle">
                                <tr>
                                    <td>Email </td>
                                    <td>:</td>
                                    <td>{{ $personal->email }}</td>
                                </tr>
                                <tr>
                                    <td>Level </td>
                                    <td>:</td>
                                    <td>@if($personal->level == 'sales') Sales @endif @if($personal->level == 'sales_senior') Sales Manager @endif @if($personal->level == 'manager') General Manager @endif @if($personal->level == 'admin') Admin @endif</td>
                                </tr>
                            </table>
                            

                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
                <!-- /.col -->
                  <div class="col-md-9">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
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
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Edit
                                        Password</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            
                            <div class="tab-content">
                              
                                

                                <div class="active tab-pane" id="settings">
                                  <form class="form-horizontal" method="POST"
                                  enctype="multipart/form-data"
                                  action="{{ route('user.password.ubah', ['id' => Auth::user()->id]) }}">
                                  @csrf
                                  @method('put')
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Password Baru</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" name="password"
                                                    placeholder="Ganti password baru anda disini">
                                                    
                                                <input type="hidden" value="{{ Auth::user()->id }}" class="form-control mt-2" name="id_user">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary btn-block">Ubah Password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>


                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                      
                    </div>
                    <!-- /.nav-tabs-custom -->
                  </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <footer class="main-footer" style=" color:white;  background-color: #6495ED">
        <strong>Informasi Akun Anda</strong>
        <div class="float-right" >
          <a href="{{ route('user.profilkaryawan') }}"><font color="white"> Account</font> <img src="{{ asset('assets_backend/img/icon/profile-user.svg') }}" width="30px"  /></a>
        </div>
      </footer>
</div>
@endsection
