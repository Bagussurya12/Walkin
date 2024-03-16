@extends('layouts.master')
@section('judul','Daftar Tamu')

@section('content')
<!-- Navbar -->
<div style="background-color: #6495ED; padding-top:15px; padding-bottom:15px;">
  <table width="100%" border="0">
    <tr>
      <td width="10%">
        <center>
          <a  href="/home">
            
            <img src="{{ asset('assets_backend/img/icon/previous.svg') }}" width="30px"  />
            <font color="white"> Back</font>
          </a>
        </center>

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
                  
                  <div class="card-body">
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
                    
                    <form class="form-horizontal" method="POST" action="{{ route('user.tamu.simpan') }}">
                      @csrf
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <input type="text" name="nama" autocomplete="off" required class="form-control" placeholder="Input Nama">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <input type="number" min="0" autocomplete="off"  name="hp" required class="form-control" placeholder="Input handphone" >
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-12">
                          <input type="email" name="email" autocomplete="off" class="form-control" placeholder="Input email">
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-12">
                          <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" name="tgl_lahir" class="form-control" placeholder="Input Tanggal Lahir">
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
                            <option value="">Pilih sumber informasi</option>
                            <option value="database" >Database</option>
                            <option value="social_media" >Social Media</option>
                            <option value="website" >Website</option>
                            <option value="media_publikasi" >Media publikasi</option>
                            <option value="bilboard" >Bilboard</option>
                            <option value="lain" >Lain-lain</option>
                            
                          </select>
                          <input type="text" name="sumberlain" autocomplete="off" id="sumberlain" hidden class="form-control mt-3" placeholder="Input sumber informasi lain">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <input type="text" name="referensi" autocomplete="off" class="form-control " placeholder="Input referensi">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12">
                          <input type="text" name="alamat" autocomplete="off" class="form-control" placeholder="Input alamat domisili">
                          <input type="hidden" name="sales" value="{{ Auth::user()->id }}" required class="form-control" >

                        </div>
                      </div>
  
                      
                        <button type="submit" class="btn btn-info btn-block">Simpan</button>
                     
                    </form>

                  
                  </div>
                  
                </div>
              </div>
        </div>
       
      </div>
    </section>


    <footer class="main-footer" style=" color:white;  background-color: #6495ED">
      <strong>Tambah Tamu WI Baru Anda</strong>
      <div class="float-right" >
        <a href="{{ route('user.profilkaryawan') }}"><font color="white"> Account</font> <img src="{{ asset('assets_backend/img/icon/profile-user.svg') }}" width="30px"  /></a>
      </div>
    </footer>
  </div>

  
  
@endsection
