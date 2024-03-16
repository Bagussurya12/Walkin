@extends('layouts.master')
@section('judul','Setting Akun')

@section('content')
<!-- Navbar -->
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

  <section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-12">
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


            <div class="card mt-3">
                  
                  <div class="card-body">
                    
                    
                    <table id="example1" class="table table-striped table-valign-middle">
                      <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>Nama</th>
                        <th>Level</th>
                        <th width="17%">
                          
                          <button type="button" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modal-lg">
                            <i class="nav-icon fas fa-plus"></i> Tambah User
                          </button>
                        </th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach ($data_user as $dt)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $dt->name }}</td>
                          <td>@if($dt->level == 'sales') Sales @endif @if($dt->level == 'sales_senior') Sales Manager @endif @if($dt->level == 'manager') General Manager @endif @if($dt->level == 'admin') Admin @endif  </td>
                          <td>
                            <center>
                              <button type="button" class="btn btn-success btn-sm btn-flat" data-toggle="modal" data-target="#modal-lg-edit{{ $dt->id }}">Ubah</button>
                              <button type="button" class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#modal-sm-hapus{{ $dt->id }}">Hapus</button>
                            </center>
                          </td>
                          
                        </tr>
                        
  
                            <div class="modal fade" id="modal-lg-edit{{ $dt->id }}">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <form class="form-horizontal" method="POST" action="/userlogin/ubah/{{ $dt->id }}">
                                  @csrf
                                  @method('PUT')
  
                                  <div class="card card-info">
                                      <div class="card-header">
                                        <h3 class="card-title">Form Ubah </h3>
                                      </div>
                                    
                                        <div class="card-body">
                                          <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Nama</label>
                                            <div class="col-sm-10">
                                              <input type="text" value="{{ $dt->name }}" name="nama" class="form-control" placeholder="Input Nama">
                                            </div>
                                          </div>
  
                                          <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                              <input type="text" value="{{ $dt->email }}" name="email" class="form-control" placeholder="Input email">
                                            </div>
                                          </div>
  
                                          <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Level</label>
                                            <div class="col-sm-10">
                                              <select class="form-control select2bs4" name="level" style="width: 100%;">
                                                <option value="">Pilih</option>
                                                <option value="admin" @if($dt->level == 'admin') selected="selected" @endif>Administrator</option>
                                                <option value="sales" @if($dt->level == 'sales') selected="selected" @endif>Sales</option>
                                                <option value="sales_senior" @if($dt->level == 'sales_senior') selected="selected" @endif>Sales Manager</option>
                                                <option value="manager" @if($dt->level == 'manager') selected="selected" @endif>General Manager</option>
                                              </select>
                                            </div>
                                          </div>
  
                                          <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Status User</label>
                                            <div class="col-sm-10">
                                              <select class="form-control select2bs4" name="status_user"  style="width: 100%;">
                                                <option value="">Pilih</option>
                                                <option value="1" @if($dt->status_user == '1') selected="selected" @endif>Aktiv</option>
                                                <option value="0" @if($dt->status_user == '0') selected="selected" @endif>Tidak Aktiv</option>
                                              </select>
                                            </div>
                                          </div>

                                          <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Sales Manager</label>
                                            <div class="col-sm-10">
                                              <select class="form-control select2bs4" name="id_sales_senior"  style="width: 100%;">
                                                <option value="">Pilih</option>
                                                @foreach($data_sales_senior as $salessenior)
                                                  <option value="{{ $salessenior->id }}" @if($salessenior->id == $dt->id_sales_senior) selected="selected" @endif>{{ $salessenior->name }}</option>
                                                @endforeach
                                              </select>
                                            </div>
                                          </div>
  
                                          <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Password Baru </label>
                                            <div class="col-sm-10">
                                              <input type="password" name="password" class="form-control" placeholder="Input password">
                                              Kosongkan jika tidak diganti
                                            </div>
                                          </div>
                                          
                                        </div>
                                      
                                        <div class="card-footer">
                                          
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                                          <button type="submit" class="btn btn-info float-right">Simpan</button>
                                        </div>
                                      
                                    </div>
                                  
                                    </form>
                                  </div>
  
                                </div>
                            </div>
  
  
                            <div class="modal fade" id="modal-sm-hapus{{ $dt->id }}">
                              <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                  <form class="form-horizontal" method="POST" action="/userlogin/hapus/{{ $dt->id }}">
                                      @csrf
                                      @method('delete')
  
                                    <div class="card card-danger">
                                        <div class="card-header">
                                          <h3 class="card-title">Konfirmasi</h3>
                                        </div>
                                      
                                          <div class="card-body">
                                            <center>Yakin Mau Hapus Data ini ?... 
  
                                              <br/>{{ $dt->name }}
                                            </center>
                                            
                                          </div>
                                        
                                          <div class="card-footer">
                                            
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger float-right">Hapus</button>
                                          </div>
                                        
                                      </div>
  
                                      </form>
                                </div>
                                <!-- /.modal-content -->
                              </div>
                              <!-- /.modal-dialog -->
                            </div>
  
                            @endforeach
                      </tbody>
                    </table>
                    <br><br><br><br>

                  
                  </div>
                  
                </div>
              </div>
        </div>
       
      </div>
    </section>

<!-- ======================================================================================= Modal -->
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
          <form class="form-horizontal" method="POST" action="/userlogin/simpan">
            @csrf

            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Form Tambah </h3>
                </div>
               
                  <div class="card-body">
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Nama</label>
                      <div class="col-sm-10">
                        <input type="text" name="nama" class="form-control" placeholder="Input Nama">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Email</label>
                      <div class="col-sm-10">
                        <input type="text" name="email" class="form-control" placeholder="Input email">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Level</label>
                      <div class="col-sm-10">
                        <select class="form-control select2bs4" name="level"  style="width: 100%;">
                          <option value="">Pilih</option>
                          <option value="admin" >Administrator</option>
                          <option value="sales" >Sales</option>
                          <option value="sales_senior" >Sales Manager</option>
                          <option value="manager" >General Manager</option>
                          
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Sales Manager</label>
                      <div class="col-sm-10">
                        <select class="form-control select2bs4" name="id_sales_senior"  style="width: 100%;">
                          <option value="">Pilih</option>
                          @foreach($data_sales_senior as $salessenior)
                            <option value="{{ $salessenior->id }}">{{ $salessenior->name }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                    
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Status User</label>
                      <div class="col-sm-10">
                        <select class="form-control select2bs4" name="status_user" style="width: 100%;">
                          <option value="">Pilih</option>
                          <option value="1" >Aktiv</option>
                          <option value="0" >Tidak Aktiv</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Password  </label>
                      <div class="col-sm-10">
                        Default : 12345
                        
                      </div>
                    </div>
                    
                  </div>
                 
                  <div class="card-footer">
                    
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-info float-right">Simpan</button>
                  </div>
                
              </div>
             
              </form>
            </div>

          </div>
      </div>

    <footer class="main-footer" style=" color:white;  background-color: #6495ED">
      <strong>Setting Akun Login</strong>
      <div class="float-right" >
        <a href="{{ route('user.profilkaryawan') }}"><font color="white"> Account</font> <img src="{{ asset('assets_backend/img/icon/profile-user.svg') }}" width="30px"  /></a>
      </div>
    </footer>
  </div>
  
@endsection
