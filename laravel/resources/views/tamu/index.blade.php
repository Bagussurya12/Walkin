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

            @if(Auth::user()->level == 'admin')
            <div class="row">
              <div class="col-sm-12">
                              <button type="button" class="btn btn-primary btn-flat btn-block mt-3 mb-3" data-toggle="modal" data-target="#modal-lg">
                                <i class="nav-icon fas fa-plus"></i> Tambah Tamu Baru
                              </button>
              </div>
              <!--
              <div class="col-sm-6">
                <button type="button" class="btn btn-default btn-flat btn-block mt-3 mb-3" data-toggle="modal" data-target="#modal-lg1">
                  <i class="nav-icon fas fa-upload"></i> Import Excel
                </button>
              </div>
            -->
            </div>
            @endif

            <div class="card mt-3">
              @if(Auth::user()->level == 'admin' || Auth::user()->level == 'manager')
              <div class="card-header">
                <form class="form-horizontal" method="GET" action="{{ route('admin.reporttamu.cari') }}">
                  <div class="form-group row">
                    <div class="col-sm-6">
                      <select class="form-control select2bs4" name="id_sales" style="width: 100%;">
                        <option value="">Pilih Sales</option>
                        @foreach($data_sales as $nmk)
                          <option value="{{ $nmk->id }}" <?php if(isset($_GET['id_sales'])){ ?> 
                            @if($nmk->id == $_GET['id_sales']) selected="selected"@endif
                            <?php } ?>>{{ $nmk->name }}</option>
                        @endforeach
                                
                      </select>
                    </div>

                    <div class="col-sm-6">
                      <select class="form-control select2bs4" name="id_sales_senior" style="width: 100%;">
                        <option value="">Pilih Sales Manager</option>
                        @foreach($sales_senior as $sl)
                          <option value="{{ $sl->id }}" <?php if(isset($_GET['id_sales_senior'])){ ?> 
                            @if($sl->id == $_GET['id_sales_senior']) selected="selected"@endif
                            <?php } ?>>{{ $sl->name }}</option>
                        @endforeach
                                
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-sm-4 mt-3">
                      <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="text" required name="tgl_awal" placeholder="Dari tanggal" <?php if(isset($_GET['tgl_awal'])){ ?> value="<?php echo $_GET['tgl_awal']; ?>" <?php } ?>  class="form-control datetimepicker-input" data-target="#reservationdate"/>
                          <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                    
                    </div>
                    <div class="col-sm-4 mt-3 mt-3">
                      <div class="input-group date" id="reservationdate1" data-target-input="nearest">
                        <input type="text" required name="tgl_akhir" placeholder="Sampai tanggal" <?php if(isset($_GET['tgl_akhir'])){ ?> value="<?php echo $_GET['tgl_akhir']; ?>" <?php } ?> class="form-control datetimepicker-input" data-target="#reservationdate1"/>
                          <div class="input-group-append" data-target="#reservationdate1" data-toggle="datetimepicker">
                              <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                          </div>
                      </div>
                    
                    </div>
                    <div class="col-lg-2 col-md-12 col-xs-12 col-sm-12 mt-3">
                     <button type="submit" class="btn btn-info btn-block  "><i class="fas fa-search"></i> Cari</button>
                    
                    </div>
                    <div class="col-lg-2 col-md-12 col-xs-12 col-sm-12 mt-3" >
                      <a href="/mastertamu" class="btn btn-warning btn-block"> Refresh</a>
                     </div>
                    
                </div>
                  
                  
                </form>
                <?php if(isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])){ ?>
                <div class="row">
                  
                  <div class="col-lg-12 col-sm-12 col-xs-12">
                    <a href="/exportexcel_tamu?id_sales=<?php echo $_GET['id_sales'];?>&tgl_awal=<?php echo $_GET['tgl_awal'];?>&tgl_akhir=<?php echo $_GET['tgl_akhir'];?>" class="btn btn-primary  btn-block float-right mt-2"><i class="far fa-copy"></i> Export Excel</a>
                  </div>
                </div>
                <?php } ?>

              </div>

              @endif

                  
                  <div class="card-body">
                    @if(Auth::user()->level == 'admin' || Auth::user()->level == 'manager')
                    <?php if(isset($_GET['tgl_awal']) && isset($_GET['tgl_akhir'])){ ?>
                    <table id="example1" class="table table-striped table-valign-middle">
                      <thead>
                        
                          <tr>
                            <th width="5%">No</th>
                            <th>Tgl</th>
                            <th>Nama Tamu</th>
                            
                            <th>Sales</th>
                            <th>No. Handphone</th>
                            <th>Sumber</th>
                            <th>Status Data</th>
                            

                            <th width="17%">
                              #
                            </th>
                          
                          </tr>
                        
                      </thead>
                      
                      <tbody>
                         @foreach ($data_user as $dt)
                         <?php 
                            $id_tamu = Crypt::encrypt($dt->id_tamu);
                             
                         ?>
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ date('d/m/Y', strtotime($dt->tgl)) }}</td>
                          <td>{{ $dt->nama }}</td>
                          

                          <td>@if($dt->nama_sale == null) Tidak ada @else {{ $dt->nama_sale->name }} @endif</td>
                          <td>{{ $dt->hp }}</td>
                          <td>{{ $dt->sumber }}</td>
                          <td>

				<button type="button" class="btn btn-default btn-sm btn-flat" data-toggle="modal" data-target="#modal-lg-edit1{{ $dt->id_tamu }}">

                            @if($dt->status == 'baru')
                            <span class="badge bg-teal">Baru</span>
                            @endif

                            @if($dt->status == 'proses')
                              
                              <span class="badge bg-primary">Proses</span>
                            @endif

                            @if($dt->status == 'closing')
                              
                              <span class="badge bg-success">Closing</span>
                            @endif

                            @if($dt->status == 'batal')
                            <span class="badge bg-warning">Batal</span>
                              
                            @endif

                            @if($dt->status == 'reserve')
                            <span class="badge bg-default">Reserve</span>
                              
                            @endif

                             <br />
                              @if($dt->keterangan_status == null)
                              -
                              @else
                              {{ $dt->keter->keterangan }}
                              @endif

                               </button>
                          </td>
                          

                          @if(Auth::user()->level == 'manager')
                          <td>
                            <center>
                              <a href="{{ route('admin.tamu.detail', ['id_tamu' => $id_tamu]) }}" class="btn btn-primary btn-sm btn-fla btn-block" >
                                <img src="{{ asset('assets_backend/img/icon/details.svg') }}" width="30px"  />
                              </a>
                            </center>
                          </td>
                          @endif

                          @if(Auth::user()->level == 'admin')
                          <td>
                            <center>
                              <button type="button" class="btn btn-success btn-sm btn-flat" data-toggle="modal" data-target="#modal-lg-edit{{ $dt->id_tamu }}">Ubah</button>
                              <button type="button" class="btn btn-warning btn-sm btn-flat" data-toggle="modal" data-target="#modal-sm-hapus{{ $dt->id_tamu }}">Hapus</button>
                            </center>
                          </td>
                          @endif
                        </tr>

@if(Auth::user()->level == 'manager')
<div class="modal fade" id="modal-lg-edit1{{ $dt->id_tamu }}">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <form class="form-horizontal" method="POST" action="{{ route('user.tamu.ubahstatustransaksi.status',['id_tamu' => $dt->id_tamu]) }}">
                                  @csrf
                                  @method('PUT')
  
                                  <div class="card card-info">
                                      <div class="card-header">
                                        <h3 class="card-title">Update status penjualan properti anda</h3>
                                      </div>
                                    
                                        <div class="card-body">
                                                                                    <div class="form-group row">
                                            <div class="col-sm-12">
                                              <select class="form-control select2bs4" required name="status"  style="width: 100%;">
                                                <option value="">Pilih status data</option>
                                                <option value="baru" @if('baru' == $dt->status) selected="selected"@endif>Data baru</option>
                                                <option value="proses" @if('proses' == $dt->status) selected="selected"@endif>Proses</option>
                                                <option value="reserve" @if('closing' == $dt->status) selected="selected"@endif>Reserve</option>
                                                <option value="closing" @if('closing' == $dt->status) selected="selected"@endif>Closing</option>
                                                <option value="batal" @if('batal' == $dt->status) selected="selected"@endif>Batal</option>
                                              </select>
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

@endif
                        
                        
                        @if(Auth::user()->level == 'admin')
                            <div class="modal fade" id="modal-lg-edit{{ $dt->id_tamu }}">
                              <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <form class="form-horizontal" method="POST" action="{{ route('admin.tamu.ubah',['id_tamu' => $dt->id_tamu]) }}">
                                  @csrf
                                  @method('PUT')
  
                                  <div class="card card-info">
                                      <div class="card-header">
                                        <h3 class="card-title">Form Ubah Data Tamu </h3>
                                      </div>
                                    
                                        <div class="card-body">
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <input type="text" name="nama" value="{{ $dt->nama }}" required class="form-control" placeholder="Input Nama">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <input type="number" min="0" value="{{ $dt->hp }}"  name="hp" required class="form-control" placeholder="Input handphone" >
                                            </div>
                                          </div>
                    
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <input type="email" name="email" value="{{ $dt->email }}" required class="form-control" placeholder="Input email">
                                            </div>
                                          </div>
                    
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <input type="text" value="{{ $dt->tgl_lahir }}" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" name="tgl_lahir" required class="form-control" placeholder="Input Tanggal Lahir">
                                            </div>
                                          </div>
              
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <select class="form-control select2bs4"  required name="jk"  style="width: 100%;">
                                                <option value="">Pilih</option>
                                                <option value="pria" @if('pria' == $dt->jk) selected="selected"@endif>Pria</option>
                                                <option value="wanita" @if('wanita' == $dt->jk) selected="selected"@endif>Wanita</option>
                                                
                                              </select>
                                            </div>
                                          </div>
                    
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <select class="form-control select2bs4" id="pilihsumber" required name="sumber"  style="width: 100%;">
                                                <option value="">Pilih sumber informasi</option>
                                                <option value="media_publikasi" @if('media_publikasi' == $dt->sumber) selected="selected"@endif>Media publikasi</option>
                                                <option value="website" @if('website' == $dt->sumber) selected="selected"@endif>Website</option>
                                                <option value="social_media" @if('social_media' == $dt->sumber) selected="selected"@endif>Social Media</option>
                                                <option value="database" @if('database' == $dt->sumber) selected="selected"@endif>Database</option>
                                                <option value="lain" @if('lain' == $dt->sumber) selected="selected"@endif>Lain-lain</option>
                                                
                                              </select>
                                              <input type="text" value="{{ $dt->sumberlain }}" name="sumberlain" id="sumberlain" hidden class="form-control mt-3" placeholder="Input sumber informasi lain">
                                            </div>
                                          </div>
                    
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <input type="text" name="alamat" value="{{ $dt->alamat_domisili }}" required class="form-control" placeholder="Input alamat domisili">
                                              
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <input type="text" value="{{ $dt->referensi }}" name="referensi" required class="form-control " placeholder="Input referensi">
                                            </div>
                                          </div>
                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <select class="form-control select2bs4" required name="status"  style="width: 100%;">
                                                <option value="">Pilih status data</option>
                                                <option value="baru" @if('baru' == $dt->status) selected="selected"@endif>Data baru</option>
                                                <option value="proses" @if('proses' == $dt->status) selected="selected"@endif>Proses</option>
                                                <option value="reserve" @if('closing' == $dt->status) selected="selected"@endif>Reserve</option>
                                                <option value="closing" @if('closing' == $dt->status) selected="selected"@endif>Closing</option>
                                                <option value="batal" @if('batal' == $dt->status) selected="selected"@endif>Batal</option>
                                              </select>
                                            </div>
                                          </div>

                                          <div class="form-group row">
                                            <div class="col-sm-12">
                                              <select class="form-control select2bs4" required name="sales"  style="width: 100%;">
                                                <option value="">Pilih sales</option>
                                                @foreach($data_sales as $dt1)
                                                <option value="{{ $dt1->id }}" @if($dt1->id == $dt->sales) selected="selected"@endif>{{ $dt1->name }}</option>
                                                @endforeach
                                                
                                                
                                              </select>
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
  
  
                            <div class="modal fade" id="modal-sm-hapus{{ $dt->id_tamu }}">
                              <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                  <form class="form-horizontal" method="POST" action="{{ route('admin.tamu.hapus',['id_tamu' => $dt->id_tamu]) }}">
                                      @csrf
                                      @method('delete')
  
                                    <div class="card card-danger">
                                        <div class="card-header">
                                          <h3 class="card-title">Konfirmasi</h3>
                                        </div>
                                      
                                          <div class="card-body">
                                            <center>Yakin Mau Hapus Data ini ?... 
  
                                              <br/>Nama tamu : {{ $dt->nama }}
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
                            @endif


                            @endforeach
                      </tbody>
                    </table>
                    <br /><br />
                    <?php } ?>

                    @else

                    <table id="example1" class="table table-striped table-valign-middle">
                      <thead>
                        
                          <tr>
                            <th width="5%">No</th>
                            <th>Tanggal</th>
                            <th>Nama Tamu</th>
                            <th>Status Data</th>
                            @if(Auth::user()->level == 'sales_senior')
                            <th width="17%">
                              Nama Sales
                            </th>
                            @endif
                            @if(Auth::user()->level == 'sales')
                            <th width="17%">
                              #
                            </th>
                            @endif
                          
                          </tr>
                        
                      </thead>
                      <tbody>
                        @foreach ($data_user as $dt)
                        <?php 
                              $id_tamu = Crypt::encrypt($dt->id_tamu);
                              
                              //echo $id_tamu;
                          
//                            $decript = Crypt::decrypt($id);
                      
  //                          echo $decript;
                          ?>
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('d/m/Y', strtotime($dt->tgl)) }}</td>
                            <td>{{ $dt->nama }}</td>
                            <td>
                              @if($dt->status == 'baru')
                              <span class="badge bg-teal">Baru</span>
                              @endif
  
                              @if($dt->status == 'proses')
                                
                                <span class="badge bg-primary">Proses</span>
                              @endif
  
                              @if($dt->status == 'closing')
                                
                                <span class="badge bg-success">Closing</span>
                              @endif
  
                              @if($dt->status == 'batal')
                              <span class="badge bg-warning">Batal</span>
                                
                              @endif

                              @if($dt->status == 'reserve')
                              <span class="badge bg-default">Reserve</span>
                                
                              @endif

                               <br />
                                @if($dt->keterangan_status == null)
                                -
                                @else
                                {{ $dt->keter->keterangan }}
                                @endif

                                 
                                
                            </td>
                            @if(Auth::user()->level == 'sales_senior')
                            <td> @if($dt->nama_sale == null) Tidak ada @else {{ $dt->nama_sale->name }} @endif</td>
                            @endif

                            @if(Auth::user()->level == 'sales')
                            <td>
                              <center>
                                <a href="{{ route('user.tamu.detail', ['id_tamu' => $id_tamu]) }}" class="btn btn-primary btn-sm btn-fla btn-block" >
                                  Detail <img src="{{ asset('assets_backend/img/icon/details.svg') }}" width="20px"  />
                                </a>
                              </center>
                            </td>

                            @endif

                          </tr>

                          

                          @endforeach
                      </tbody>
                    </table>


                    @endif


                  
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

          <form class="form-horizontal" method="POST" action="{{ route('admin.tamu.simpan') }}">
            @csrf

            <div class="card card-info">
                <div class="card-header">
                  <h3 class="card-title">Form Tambah Tamu Baru</h3>
                </div>
               
                  <div class="card-body">
                    
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <input type="text" name="nama"  required class="form-control" placeholder="Input Nama">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <input type="number" min="0"  name="hp" required class="form-control" placeholder="Input handphone" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-12">
                        <input type="email" name="email"  required class="form-control" placeholder="Input email">
                      </div>
                    </div>

                    
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="date" name="tgl_lahir" required class="form-control" placeholder="Input Tanggal Lahir">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-12">
                        <select class="form-control select2bs4"  required name="jk"  style="width: 100%;">
                          <option value="">Pilih jenis kelamin</option>
                          <option value="pria" >Pria</option>
                          <option value="wanita" >Wanita</option>
                          
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-12">
                        <select class="form-control select2bs4" id="pilihsumber" required name="sumber"  style="width: 100%;">
                          <option value="">Pilih sumber informasi</option>
                          <option value="media_publikasi" >Media publikasi</option>
                          <option value="website" >Website</option>
                          <option value="social_media" >Social Media</option>
                          <option value="database" >Database</option>
                          <option value="lain" >Lain-lain</option>
                          
                        </select>
                        <input type="text" name="sumberlain" id="sumberlain" hidden class="form-control mt-3" placeholder="Input sumber informasi lain">
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-12">
                        <input type="text" name="referensi" required class="form-control " placeholder="Input referensi">
                      </div>
                    </div>

                    <div class="form-group row">
                      <div class="col-sm-12">
                        <input type="text" name="alamat"  required class="form-control" placeholder="Input Kota">
                        

                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="col-sm-12">
                        @if(Auth::user()->level == 'admin')
                        <select class="form-control select2bs4" required name="sales"  style="width: 100%;">
                          <option value="">Pilih sales</option>
                          @foreach($data_sales as $dt)
                          <option value="{{ $dt->id }}">{{ $dt->name }}</option>
                          @endforeach
                          
                          
                        </select>
                        @endif
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



  <div class="modal fade" id="modal-lg1">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
      <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ route('admin.importexcel_tamu') }}">
        @csrf

        <div class="card card-info">
            <div class="card-header">
              <h3 class="card-title">Form Upload Excel</h3>
            </div>
           
              <div class="card-body">
                <div class="form-group row">
                  <div class="col-sm-12">
                    <input type="file" name="file"  required class="form-control" placeholder="upload file">
                  </div>
                </div>
                <hr />
                Untuk upload excel sesuaikan dengan format import file dan kode salessesuai nama sales<br />
                <a href="{{ asset('assets_backend/img/tamu/file_import.xlsx') }}" target="__BLANK">
                1. download file import 
                </a><br />
                <a href="{{ route('admin.exportexcel_sales') }}" target="__BLANK">
                2. download kode sales
                </a>
                
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
  <strong>Daftar Tamu WI</strong>
  <div class="float-right" >
    <a href="{{ route('user.profilkaryawan') }}"><font color="white"> Account</font> <img src="{{ asset('assets_backend/img/icon/profile-user.svg') }}" width="30px"  /></a>
  </div>
</footer>

</div>
  
@endsection
