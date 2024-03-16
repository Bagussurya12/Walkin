@extends('layouts.master')
@section('judul','Daftar Tamu')

@section('content')
<!-- Navbar -->
<div style="background-color: #6495ED; padding-top:15px; padding-bottom:15px;">
  <table width="100%" border="0">
    <tr>
      <td width="10%">
        @if(Auth::user()->level == 'sales')
        <center>
        <a  href="{{ route('user.tamu') }}">
          <img src="{{ asset('assets_backend/img/icon/previous.svg') }}" width="30px"  />
          <font color="white"> Back</font>
        </a>
        </center>
        @endif
        @if(Auth::user()->level == 'manager')
        <center>
        <a  href="{{ route('admin.tamu') }}">
          <img src="{{ asset('assets_backend/img/icon/previous.svg') }}" width="30px"  />
          <font color="white"> Back</font>
        </a>
        </center>
        @endif


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
     

    @if($data_tamu->sales == Auth::user()->id || Auth::user()->level == 'manager')
        <div class="row">
          <div class="col-12">
            <div class="card mt-3">
                  <div class="card-body">
                    <table class="table table-striped table-valign-middle">
                      
                      <tbody>
                       
                        <tr>
                          <td width="35%">Tanggal</td>
                          <td width="5%">:</td>
                          <td>@if($data_tamu->tgl == null) - @else {{ date('d/m/Y', strtotime($data_tamu->tgl)) }} @endif</td>
                        </tr>

                        <tr>
                          <td width="35%">Nama</td>
                          <td width="5%">:</td>
                          <td>@if($data_tamu->nama == null) - @else {{ $data_tamu->nama }} @endif</td>
                        </tr>
                        <tr>
                          <td width="35%">Jenis kelamin</td>
                          <td width="5%">:</td>
                          <td>@if($data_tamu->jk == null) - @else {{ $data_tamu->jk }} @endif</td>
                        </tr>
                        <tr>
                          <td width="35%">Tanggal lahir / Umur</td>
                          <td width="5%">:</td>
                          <td>@if($data_tamu->tgl_lahir == null) - @else {{ $data_tamu->tgl_lahir }} @endif / @if($data_tamu->umur == null) - @else {{ $data_tamu->umur }} tahun @endif</td>
                        </tr>

                        <tr>
                          <td width="35%">Nomor Hp</td>
                          <td width="5%">:</td>
                          <td>@if($data_tamu->hp == null) - @else {{ $data_tamu->hp }} @endif</td>
                        </tr>

                        <tr>
                          <td width="35%">Email</td>
                          <td width="5%">:</td>
                          <td>@if($data_tamu->email == null) - @else {{ $data_tamu->email }} @endif</td>
                        </tr>

                        <tr>
                          <td width="35%">Alamat Domisili</td>
                          <td width="5%">:</td>
                          <td>@if($data_tamu->alamat_domisili == null) - @else {{ $data_tamu->alamat_domisili }} @endif</td>
                        </tr>

                        <tr>
                          <td width="35%">Sumber informasi</td>
                          <td width="5%">:</td>
                          <td>@if($data_tamu->sumber == null) - @else {{ $data_tamu->sumber }} @endif</td>
                        </tr>

                        <tr>
                          <td width="35%">Nama Sales</td>
                          <td width="5%">:</td>
                          <td>@if($data_tamu->sales == null) - @else {{ $data_tamu->nama_sale->name }} @endif</td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                  </div>

                  
                  
                </div>
              </div>
        </div>

        <!----- pembatas -->

        <div class="row mt-3 mt-3" >
          <div class="col-12 mt-3 mt-3">
            <div class="card ">
                  <div class="card-body">
                    @if(Auth::user()->level == 'sales')
                      <button type="button" class="btn btn-primary btn-flat btn-block mt-3 mb-3" data-toggle="modal" data-target="#modal-lg">
                        <i class="nav-icon fas fa-plus"></i> Tambah History Tamu Anda
                      </button>
                    @endif

                    <table id="example1" class="table table-striped table-valign-middle mt-3 mt-3">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th>Tanggal</th>
                          <th>Keterangan</th>
                         
                          
                        </tr>
                      </thead>

                      <tbody>
                        @foreach ($data_history as $dt)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ date('d/m/Y', strtotime($dt->tgl)) }}</td>
                          <td>
                            @if($dt->status_keterangan == 'baru')
                                    
                                    <span class="badge bg-teal">Baru</span>
                                  @endif
      
                                  @if($dt->status_keterangan == 'proses')
                                    
                                    <span class="badge bg-primary">Proses</span>
                                  @endif
      
                                  @if($dt->status_keterangan == 'closing')
                                    
                                    <span class="badge bg-success">Closing</span>
                                  @endif
      
                                  @if($dt->status_keterangan == 'batal')
                                  <span class="badge bg-warning">Batal</span>
                                    
                                  @endif

                                  @if($dt->status_keterangan == 'reserve')
                                  <span class="badge bg-default">Reserve</span>
                                    
                                  @endif

                                  <br />
                                  @if($dt->keterangan == null)
                                  -
                                  @else
                                  {{ $dt->keter->keterangan }}
                                  @endif

                                  <br />
                                  @if($dt->keterangan == 'lain')
                                    {{ $dt->keterangan_lain }}
                                  @endif
                          </td>
                         
                        </tr>


                       

                        @endforeach
                      </tbody>
                    </table>
                    <br><br>
                  </div>

                  
                  
                </div>
              </div>
        </div>
        @else
          <center>        
            <img src="{{ asset('assets_backend/img/icon/warning.svg') }}" width="30%"  /><br />
            Sorry, Anda bukan pemilik data ini
          </center>
        @endif
      </div>
    </section>

    <!-- ======================================================================================= Modal -->
    <div class="modal fade" id="modal-lg">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
          <form class="form-horizontal" method="POST" action="{{ route('user.tamu.history.simpan') }}">
            @csrf

            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Form Tambah History Tamu</h3>
                </div>
               
                  <div class="card-body">
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <select class="form-control select2bs4" id="status" required name="status"  style="width: 100%;">
                          <option value="">Pilih status data</option>
                          <option value="proses" >Proses</option>
                          <option value="reserve" >Reserve</option>
                          <option value="closing" >Closing</option>
                          <option value="batal" >Batal</option>
                          
                          
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-12">
                        <select class="form-control select2bs4" id="status_keterangan" hidden required name="status_keterangan"  style="width: 100%;">
                          <option value="">Pilih Keterangan</option>
                        </select>
                        <input type="text"  name="keterangan_lain" id="lain" hidden class="form-control mt-3" placeholder="Input Keterangan lain">
                      </div>
                    </div>
                  </div>
                 
                  <div class="card-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <input type="hidden" name="id_tamu" value="{{ $data_tamu->id_tamu }}" required class="form-control">

                    <button type="submit" class="btn btn-info float-right">Simpan</button>
                  </div>
                
              </div>
             
              </form>
            </div>

          </div>
      </div>

    <footer class="main-footer mt-3" style=" color:white;  background-color: #6495ED">
      <strong>Detail Data Tamu</strong>
      <div class="float-right" >
        <a href="{{ route('user.profilkaryawan') }}"><font color="white"> Account</font> <img src="{{ asset('assets_backend/img/icon/profile-user.svg') }}" width="30px"  /></a>
      </div>
    </footer>
  </div>


  
@endsection

@section('footer')
<script type='text/javascript'>

$('#status').change(function(){
  var status = $(this).val();    
  if(status){
      $.ajax({
         type:"GET",
         url:"/getketerangan?status="+status,
         dataType: 'JSON',
         success:function(res){               
          if(res){
              $("#status_keterangan").empty();
              //$("#status_keterangan").append('<option>---Pilih Keterangan---</option>');
              $.each(res,function(keterangan,id_keterangan){
                  $("#status_keterangan").append('<option value="'+id_keterangan+'">'+keterangan+'</option>');
                  
              });
              $("#status_keterangan").append('<option value="lain">Lain-lain</option>');


              $("#status_keterangan").change(function() {
                            console.log($("#status_keterangan option:selected").val());
                            if ($("#status_keterangan option:selected").val() == 'lain') {
                              $('#lain').prop('hidden', false);
                            } else {
                              $('#lain').prop('hidden', 'true');
                            }
                          });
              
              if ($("#status_keterangan option:selected").val() == 'lain') {
                              $('#lain').prop('hidden', false);
                            } else {
                              $('#lain').prop('hidden', 'true');
                            }
          }else{
             $("#status_keterangan").empty();
            
          }
         }
      });
  }else{
      $("#status_keterangan").empty();
    
  }      
 });

 </script>
@endsection