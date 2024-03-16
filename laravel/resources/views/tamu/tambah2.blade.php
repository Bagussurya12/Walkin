@extends('layouts.master')
@section('judul','Daftar Tamu')

@section('content')
<!-- Navbar -->
<div style="background-color: #6495ED; padding-top:15px; padding-bottom:15px;">
  <table width="100%" border="0">
    <tr>
      <td width="10%">
        <center>
        <a onclick="goBack()" href="#">
          <img src="{{ asset('assets_backend/img/icon/previous.svg') }}" width="30px"  />
          
        </a>
        </center>

        <script>
          function goBack() {
              window.history.back();
          }
      </script>
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
        <div class="row">
          <div class="col-12">



            <div class="card mt-3">
                  
                  <div class="card-body">
                    
                    <form class="form-horizontal" method="POST" action="{{ route('user.tamu.simpan') }}">
                      @csrf
                      <div class="form-group row">
                        <div class="col-sm-10">
                          <input type="text" name="nama" required class="form-control" placeholder="Input Nama">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-10">
                          <input type="text" name="hp" required class="form-control" placeholder="Input handphone">
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-10">
                          <input type="text" name="email" required class="form-control" placeholder="Input email">
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-10">
                          <input type="text" name="sumber" required class="form-control" placeholder="Input sumber informasi">
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-10">
                          <input type="text" name="alamat" required class="form-control" placeholder="Input alamat domisili">
                          
                        </div>
                      </div>
  
                      <div class="form-group row">
                        <div class="col-sm-10">
                          <select class="form-control select2bs4" required name="sales"  style="width: 100%;">
                            <option value="">Pilih sales</option>
                            @foreach($sales as $dt)
                            <option value="{{ $dt->id }}" >{{ $dt->name }}</option>
                            @endforeach
                            
                            
                          </select>
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
        <a href=""><img src="{{ asset('assets_backend/img/icon/profile-user.svg') }}" width="30px"  /></a>
      </div>
    </footer>
  </div>
  
@endsection
