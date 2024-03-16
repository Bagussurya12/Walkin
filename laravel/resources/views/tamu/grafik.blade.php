@extends('layouts.master')
@section('judul','Laporan Grafik tamu WI')

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
            

            <div class="card mt-3">
                <div class="card-header">
                  <form class="form-horizontal" method="GET" action="{{ route('admin.grafik_reporttamu.cari') }}">
                    <div class="form-group row">
                      <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-3">
                        <select class="form-control select2bs4" name="id_sales" style="width: 100%;">
                          <option value="">Pilih Sales</option>
                          @foreach($data_sales as $nmk)
                            <option value="{{ $nmk->id }}" <?php if(isset($_GET['id_sales'])){ ?> 
                              @if($nmk->id == $_GET['id_sales']) selected="selected"@endif
                              <?php } ?>>{{ $nmk->name }}</option>
                          @endforeach
                                  
                        </select>
                      </div>

                      <div class="col-lg-3 col-md-3 col-xs-12 col-sm-12 mt-3">
                        <select class="form-control select2bs4" name="id_sales_senior" style="width: 100%;">
                          <option value="">Pilih Sales Manager</option>
                          @foreach($sales_senior as $sl)
                            <option value="{{ $sl->id }}" <?php if(isset($_GET['id_sales_senior'])){ ?> 
                              @if($sl->id == $_GET['id_sales_senior']) selected="selected"@endif
                              <?php } ?>>{{ $sl->name }}</option>
                          @endforeach
                                  
                        </select>
                      </div>

                      <div class="col-lg-2 col-md-6 col-xs-12 col-sm-12 mt-3">
                        <select class="form-control select2bs4" name="tahun" style="width: 100%;">
                          <option value="">Pilih tahun</option>

                          <?php 
                          $tahun = date('Y');
                          $tahun_berikut = $tahun+1;
                          for($i=2017; $i<$tahun_berikut; $i++){?>
                            <option value="<?php echo $i;?>" <?php if(isset($_GET['tahun'])){ ?> 
                              @if($i == $_GET['tahun']) selected="selected"@endif
                              <?php } ?>>
                                <?php echo $i;?>
                              
                            </option>
                          <?php }?>
                                
                        </select>
                      
                      </div>
                      
                      <div class="col-lg-2 col-md-12 col-xs-12 col-sm-12 mt-3">
                        <button type="submit" class="btn btn-info btn-block  "><i class="fas fa-search"></i> Cari</button>
                      </div>
                      <div class="col-lg-2 col-md-12 col-xs-12 col-sm-12 mt-3" >
                        <a href="/mastertamu" class="btn btn-warning btn-block"> Refresh</a>
                      </div>
                    </div>
                    
                  </form>
                  
                </div>


                  <div  class="card-body" >
                    <?php if(isset($_GET['tahun'])){ ?>
                    <figure class="highcharts-figure">
                      <div id="container"></div>
                    </figure>
                    
                    <div class="table-responsive p-1" style="height: 300px;" >
                    <table class="table table-sm table-bordered table-striped table-head-fixed text-nowrap">
                      <tr>
                        <tr style="background-color: cadetblue">
                          <td>
                            <b>Total</b> 
                          </td>
                          
                        <td>Jan</td><td>Feb</td><td>Mar</td><td>Apr</td><td>Mei</td><td>Jun</td><td>Jul</td><td>Agu</td><td>Sep</td><td>Okt</td><td>Nov</td><td>Des</td>
                      
                        </tr>
                      </tr>
                      
                        <tr style="background-color: rgb(170, 231, 233)">
                          <td>
                            Total Tamu Baru
                          </td>
                          <td>{{ $total_baru_jan }}</td><td>{{ $total_baru_feb }}</td><td>{{ $total_baru_mar }}</td><td>{{ $total_baru_apr }}</td><td>{{ $total_proses_mei }}</td><td>{{ $total_baru_jun }}</td><td>{{ $total_baru_jul }}</td><td>{{ $total_baru_agu }}</td><td>{{ $total_baru_sep }}</td><td>{{ $total_baru_okt }}</td><td>{{ $total_baru_nov }}</td><td>{{ $total_baru_des }}</td>
                        </tr>
                      <tr >
                        <td>
                          Total Tamu Proses
                        </td>
                        <td>{{ $total_proses_jan }}</td><td>{{ $total_proses_feb }}</td><td>{{ $total_proses_mar }}</td><td>{{ $total_proses_apr }}</td><td>{{ $total_proses_mei }}</td><td>{{ $total_proses_jun }}</td><td>{{ $total_proses_jul }}</td><td>{{ $total_proses_agu }}</td><td>{{ $total_proses_sep }}</td><td>{{ $total_proses_okt }}</td><td>{{ $total_proses_nov }}</td><td>{{ $total_proses_des }}</td>
                      </tr>
                      <tr style="background-color: rgb(170, 231, 233)">
                        <td>
                          Total Tamu Closing
                        </td>
                         <td>{{ $total_closing_jan }}</td><td>{{ $total_closing_feb }}</td><td>{{ $total_closing_mar }}</td><td>{{ $total_closing_apr }}</td><td>{{ $total_closing_mei }}</td><td>{{ $total_closing_jun }}</td><td>{{ $total_closing_jul }}</td><td>{{ $total_closing_agu }}</td><td>{{ $total_closing_sep }}</td><td>{{ $total_closing_okt }}</td><td>{{ $total_closing_nov }}</td><td>{{ $total_closing_des }}</td>
                      </tr>
                      <tr >
                        <td>
                          Total Tamu Batal
                        </td>
                        <td>{{ $total_batal_jan }}</td><td>{{ $total_batal_feb }}</td><td> {{ $total_batal_mar }}</td><td>{{ $total_batal_apr }}</td><td>{{ $total_batal_mei }}</td><td>{{ $total_batal_jun }}</td><td>{{ $total_batal_jul }}</td><td>{{ $total_batal_agu }}</td><td>{{ $total_batal_sep }}</td><td>{{ $total_batal_okt }}</td><td>{{ $total_batal_nov }}</td><td>{{ $total_batal_des }}</td>
                      </tr>
                      <tr style="background-color: rgb(170, 231, 233)">
                        <td>
                          Total Tamu Reserve
                        </td>
                        <td>{{ $total_reserve_jan }}</td><td>{{ $total_reserve_feb }}</td><td>{{ $total_reserve_mar }}</td><td>{{ $total_reserve_apr }}</td><td>{{ $total_reserve_mei }}</td><td>{{ $total_reserve_jun }}</td><td>{{ $total_reserve_jul }}</td><td>{{ $total_reserve_agu }}</td><td>{{ $total_reserve_sep }}</td><td>{{ $total_reserve_okt }}</td><td>{{ $total_reserve_nov }}</td><td>{{ $total_reserve_des }}</td>
                      </tr>
                      <tr>
                        <td style="background-color: rgb(100, 98, 224)">
                          <b>Total Keseluruhan Tamu Datang</b>
                        </td>
                        <td @if($total_keseluruhan_jan == 0) style="background-color: rgb(194, 43, 5)" @endif>{{ $total_keseluruhan_jan }}</td><td @if($total_keseluruhan_feb == 0) style="background-color: rgb(194, 43, 5)" @endif>{{ $total_keseluruhan_feb }}</td><td @if($total_keseluruhan_mar == 0) style="background-color: rgb(194, 43, 5)" @endif>{{ $total_keseluruhan_mar }}</td><td @if($total_keseluruhan_apr == 0) style="background-color: rgb(194, 43, 5)" @endif>{{ $total_keseluruhan_apr }}</td><td @if($total_keseluruhan_mei == 0) style="background-color: rgb(194, 43, 5)" @endif>{{ $total_keseluruhan_mei }}</td><td @if($total_keseluruhan_jun == 0) style="background-color: rgb(194, 43, 5)" @endif>{{ $total_keseluruhan_jun }}</td><td @if($total_keseluruhan_jul == 0) style="background-color: rgb(194, 43, 5)" @endif>{{ $total_keseluruhan_jul }}</td><td @if($total_keseluruhan_agu == 0) style="background-color: rgb(194, 43, 5)" @endif>{{ $total_keseluruhan_agu }}</td><td @if($total_keseluruhan_sep == 0) style="background-color: rgb(194, 43, 5)" @endif>{{ $total_keseluruhan_sep }}</td><td @if($total_keseluruhan_okt == 0) style="background-color: rgb(194, 43, 5)" @endif>{{ $total_keseluruhan_okt }}</td><td @if($total_keseluruhan_nov == 0) style="background-color: rgb(194, 43, 5)" @endif>{{ $total_keseluruhan_nov }}</td><td @if($total_keseluruhan_des == 0) style="background-color: rgb(194, 43, 5)" @endif>{{ $total_keseluruhan_des }}</td>
                      </tr>
                    </table>
                    </div>


                    <?php } ?>

                    <?php if(isset($_GET['tahun'])){ ?>
                      <hr>
                      <figure class="highcharts-figure">
                        <div id="container_jk"></div>
                      </figure>
                      <div class="table-responsive p-1" style="height: 300px;" >
                      <table id="example1" class="table table-sm table-bordered table-striped table-head-fixed text-nowrap">
                        <tr>
                          <tr style="background-color: cadetblue">
                           
                          <td>Jan</td><td>Feb</td><td>Mar</td><td>Apr</td><td>Mei</td><td>Jun</td><td>Jul</td><td>Agu</td><td>Sep</td><td>Okt</td><td>Nov</td><td>Des</td>
                        
                          </tr>
                        </tr>
                        <tr>
                         
                          <td>Pria : {{ $total_keseluruhan_jan_jk_pria }}<br>Wanita : {{ $total_keseluruhan_jan_jk_wanita }}</td>
                          <td>Pria : {{ $total_keseluruhan_feb_jk_pria }}<br>Wanita : {{ $total_keseluruhan_feb_jk_wanita }}</td>
                          <td>Pria : {{ $total_keseluruhan_mar_jk_pria }}<br>Wanita : {{ $total_keseluruhan_mar_jk_wanita }}</td>
                          <td>Pria : {{ $total_keseluruhan_apr_jk_pria }}<br>Wanita : {{ $total_keseluruhan_apr_jk_wanita }}</td>
                          <td>Pria : {{ $total_keseluruhan_mei_jk_pria }}<br>Wanita : {{ $total_keseluruhan_mei_jk_wanita }}</td>
                          <td>Pria : {{ $total_keseluruhan_jun_jk_pria }}<br>Wanita : {{ $total_keseluruhan_jun_jk_wanita }}</td>
                          <td>Pria : {{ $total_keseluruhan_jul_jk_pria }}<br>Wanita : {{ $total_keseluruhan_jul_jk_wanita }}</td>
                          <td>Pria : {{ $total_keseluruhan_agu_jk_pria }}<br>Wanita : {{ $total_keseluruhan_agu_jk_wanita }}</td>
                          <td>Pria : {{ $total_keseluruhan_sep_jk_pria }}<br>Wanita : {{ $total_keseluruhan_sep_jk_wanita }}</td>
                          <td>Pria : {{ $total_keseluruhan_okt_jk_pria }}<br>Wanita : {{ $total_keseluruhan_okt_jk_wanita }}</td>
                          <td>Pria : {{ $total_keseluruhan_nov_jk_pria }}<br>Wanita : {{ $total_keseluruhan_nov_jk_wanita }}</td>
                          <td>Pria : {{ $total_keseluruhan_des_jk_pria }}<br>Wanita : {{ $total_keseluruhan_des_jk_wanita }}</td>
                          </tr>

                          <tr style="background-color: cadetblue">
                         
                            <td @if($total_keseluruhan_jan_jk_pria + $total_keseluruhan_jan_jk_wanita == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_jan_jk_pria + $total_keseluruhan_jan_jk_wanita }}</td>
                            <td @if($total_keseluruhan_feb_jk_pria + $total_keseluruhan_feb_jk_wanita == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_feb_jk_pria + $total_keseluruhan_feb_jk_wanita }}</td>
                            <td @if($total_keseluruhan_mar_jk_pria + $total_keseluruhan_mar_jk_wanita == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_mar_jk_pria + $total_keseluruhan_mar_jk_wanita }}</td>
                            <td @if($total_keseluruhan_apr_jk_pria + $total_keseluruhan_apr_jk_wanita == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_apr_jk_pria + $total_keseluruhan_apr_jk_wanita }}</td>
                            <td @if($total_keseluruhan_mei_jk_pria + $total_keseluruhan_mei_jk_wanita == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_mei_jk_pria + $total_keseluruhan_mei_jk_wanita }}</td>
                            <td @if($total_keseluruhan_jun_jk_pria + $total_keseluruhan_jun_jk_wanita == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_jun_jk_pria + $total_keseluruhan_jun_jk_wanita }}</td>
                            <td @if($total_keseluruhan_jul_jk_pria + $total_keseluruhan_jul_jk_wanita == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_jul_jk_pria + $total_keseluruhan_jul_jk_wanita }}</td>
                            <td @if($total_keseluruhan_agu_jk_pria + $total_keseluruhan_agu_jk_wanita == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_agu_jk_pria + $total_keseluruhan_agu_jk_wanita }}</td>
                            <td @if($total_keseluruhan_sep_jk_pria + $total_keseluruhan_sep_jk_wanita == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_sep_jk_pria + $total_keseluruhan_sep_jk_wanita }}</td>
                            <td @if($total_keseluruhan_okt_jk_pria + $total_keseluruhan_okt_jk_wanita == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_okt_jk_pria + $total_keseluruhan_okt_jk_wanita }}</td>
                            <td @if($total_keseluruhan_nov_jk_pria + $total_keseluruhan_nov_jk_wanita == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_nov_jk_pria + $total_keseluruhan_nov_jk_wanita }}</td>
                            <td @if($total_keseluruhan_des_jk_pria + $total_keseluruhan_des_jk_wanita == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_des_jk_pria + $total_keseluruhan_des_jk_wanita }}</td>
                            </tr>
                          
                      </table>
                      </div>

                      <hr>
                      <figure class="highcharts-figure">
                        <div id="container_umur"></div>
                      </figure>

                      <div class="table-responsive p-1" style="height: 500px;" >
                        <table id="example1" class="table table-sm table-bordered table-striped table-head-fixed text-nowrap">
                          <tr>
                            <tr style="background-color: cadetblue">
                              <td>
                                <b>Umur</b> 
                              </td>
                            <td>Jan</td><td>Feb</td><td>Mar</td><td>Apr</td><td>Mei</td><td>Jun</td><td>Jul</td><td>Agu</td><td>Sep</td><td>Okt</td><td>Nov</td><td>Des</td>
                          
                            </tr>
                          </tr>
                            <tr>
                              <td>
                                <b>18-24</b> 
                              </td>
                              <td>Pria : {{ $total_keseluruhan_jan_pria_umur_18_24 }}<br>Wanita : {{ $total_keseluruhan_jan_wanita_umur_18_24 }}</td>
                              <td>Pria : {{ $total_keseluruhan_feb_pria_umur_18_24 }}<br>Wanita : {{ $total_keseluruhan_feb_wanita_umur_18_24 }}</td>
                              <td>Pria : {{ $total_keseluruhan_mar_pria_umur_18_24 }}<br>Wanita : {{ $total_keseluruhan_mar_wanita_umur_18_24 }}</td>
                              <td>Pria : {{ $total_keseluruhan_apr_pria_umur_18_24 }}<br>Wanita : {{ $total_keseluruhan_apr_wanita_umur_18_24 }}</td>
                              <td>Pria : {{ $total_keseluruhan_mei_pria_umur_18_24 }}<br>Wanita : {{ $total_keseluruhan_mei_wanita_umur_18_24 }}</td>
                              <td>Pria : {{ $total_keseluruhan_jun_pria_umur_18_24 }}<br>Wanita : {{ $total_keseluruhan_jun_wanita_umur_18_24 }}</td>
                              <td>Pria : {{ $total_keseluruhan_jul_pria_umur_18_24 }}<br>Wanita : {{ $total_keseluruhan_jul_wanita_umur_18_24 }}</td>
                              <td>Pria : {{ $total_keseluruhan_agu_pria_umur_18_24 }}<br>Wanita : {{ $total_keseluruhan_agu_wanita_umur_18_24 }}</td>
                              <td>Pria : {{ $total_keseluruhan_sep_pria_umur_18_24 }}<br>Wanita : {{ $total_keseluruhan_sep_wanita_umur_18_24 }}</td>
                              <td>Pria : {{ $total_keseluruhan_okt_pria_umur_18_24 }}<br>Wanita : {{ $total_keseluruhan_okt_wanita_umur_18_24 }}</td>
                              <td>Pria : {{ $total_keseluruhan_nov_pria_umur_18_24 }}<br>Wanita : {{ $total_keseluruhan_nov_wanita_umur_18_24 }}</td>
                              <td>Pria : {{ $total_keseluruhan_des_pria_umur_18_24 }}<br>Wanita : {{ $total_keseluruhan_des_wanita_umur_18_24 }}</td>
                            </tr>

                            <tr>
                              <td>
                                <b>25-34</b> 
                              </td>
                              <td>Pria : {{ $total_keseluruhan_jan_pria_umur_25_34 }}<br>Wanita : {{ $total_keseluruhan_jan_wanita_umur_25_34 }}</td>
                              <td>Pria : {{ $total_keseluruhan_feb_pria_umur_25_34 }}<br>Wanita : {{ $total_keseluruhan_feb_wanita_umur_25_34 }}</td>
                              <td>Pria : {{ $total_keseluruhan_mar_pria_umur_25_34 }}<br>Wanita : {{ $total_keseluruhan_mar_wanita_umur_25_34 }}</td>
                              <td>Pria : {{ $total_keseluruhan_apr_pria_umur_25_34 }}<br>Wanita : {{ $total_keseluruhan_apr_wanita_umur_25_34 }}</td>
                              <td>Pria : {{ $total_keseluruhan_mei_pria_umur_25_34 }}<br>Wanita : {{ $total_keseluruhan_mei_wanita_umur_25_34 }}</td>
                              <td>Pria : {{ $total_keseluruhan_jun_pria_umur_25_34 }}<br>Wanita : {{ $total_keseluruhan_jun_wanita_umur_25_34 }}</td>
                              <td>Pria : {{ $total_keseluruhan_jul_pria_umur_25_34 }}<br>Wanita : {{ $total_keseluruhan_jul_wanita_umur_25_34 }}</td>
                              <td>Pria : {{ $total_keseluruhan_agu_pria_umur_25_34 }}<br>Wanita : {{ $total_keseluruhan_agu_wanita_umur_25_34 }}</td>
                              <td>Pria : {{ $total_keseluruhan_sep_pria_umur_25_34 }}<br>Wanita : {{ $total_keseluruhan_sep_wanita_umur_25_34 }}</td>
                              <td>Pria : {{ $total_keseluruhan_okt_pria_umur_25_34 }}<br>Wanita : {{ $total_keseluruhan_okt_wanita_umur_25_34 }}</td>
                              <td>Pria : {{ $total_keseluruhan_nov_pria_umur_25_34 }}<br>Wanita : {{ $total_keseluruhan_nov_wanita_umur_25_34 }}</td>
                              <td>Pria : {{ $total_keseluruhan_des_pria_umur_25_34 }}<br>Wanita : {{ $total_keseluruhan_des_wanita_umur_25_34 }}</td>
                            </tr>

                            <tr>
                              <td>
                                <b>35-44</b> 
                              </td>
                              <td>Pria : {{ $total_keseluruhan_jan_pria_umur_35_44 }}<br>Wanita : {{ $total_keseluruhan_jan_wanita_umur_35_44 }}</td>
                              <td>Pria : {{ $total_keseluruhan_feb_pria_umur_35_44 }}<br>Wanita : {{ $total_keseluruhan_feb_wanita_umur_35_44 }}</td>
                              <td>Pria : {{ $total_keseluruhan_mar_pria_umur_35_44 }}<br>Wanita : {{ $total_keseluruhan_mar_wanita_umur_35_44 }}</td>
                              <td>Pria : {{ $total_keseluruhan_apr_pria_umur_35_44 }}<br>Wanita : {{ $total_keseluruhan_apr_wanita_umur_35_44 }}</td>
                              <td>Pria : {{ $total_keseluruhan_mei_pria_umur_35_44 }}<br>Wanita : {{ $total_keseluruhan_mei_wanita_umur_35_44 }}</td>
                              <td>Pria : {{ $total_keseluruhan_jun_pria_umur_35_44 }}<br>Wanita : {{ $total_keseluruhan_jun_wanita_umur_35_44 }}</td>
                              <td>Pria : {{ $total_keseluruhan_jul_pria_umur_35_44 }}<br>Wanita : {{ $total_keseluruhan_jul_wanita_umur_35_44 }}</td>
                              <td>Pria : {{ $total_keseluruhan_agu_pria_umur_35_44 }}<br>Wanita : {{ $total_keseluruhan_agu_wanita_umur_35_44 }}</td>
                              <td>Pria : {{ $total_keseluruhan_sep_pria_umur_35_44 }}<br>Wanita : {{ $total_keseluruhan_sep_wanita_umur_35_44 }}</td>
                              <td>Pria : {{ $total_keseluruhan_okt_pria_umur_35_44 }}<br>Wanita : {{ $total_keseluruhan_okt_wanita_umur_35_44 }}</td>
                              <td>Pria : {{ $total_keseluruhan_nov_pria_umur_35_44 }}<br>Wanita : {{ $total_keseluruhan_nov_wanita_umur_35_44 }}</td>
                              <td>Pria : {{ $total_keseluruhan_des_pria_umur_35_44 }}<br>Wanita : {{ $total_keseluruhan_des_wanita_umur_35_44 }}</td>
                            </tr>

                            <tr>
                              <td>
                                <b>45-54</b> 
                              </td>
                              <td>Pria : {{ $total_keseluruhan_jan_pria_umur_45_54 }}<br>Wanita : {{ $total_keseluruhan_jan_wanita_umur_45_54 }}</td>
                              <td>Pria : {{ $total_keseluruhan_feb_pria_umur_45_54 }}<br>Wanita : {{ $total_keseluruhan_feb_wanita_umur_45_54 }}</td>
                              <td>Pria : {{ $total_keseluruhan_mar_pria_umur_45_54 }}<br>Wanita : {{ $total_keseluruhan_mar_wanita_umur_45_54 }}</td>
                              <td>Pria : {{ $total_keseluruhan_apr_pria_umur_45_54 }}<br>Wanita : {{ $total_keseluruhan_apr_wanita_umur_45_54 }}</td>
                              <td>Pria : {{ $total_keseluruhan_mei_pria_umur_45_54 }}<br>Wanita : {{ $total_keseluruhan_mei_wanita_umur_45_54 }}</td>
                              <td>Pria : {{ $total_keseluruhan_jun_pria_umur_45_54 }}<br>Wanita : {{ $total_keseluruhan_jun_wanita_umur_45_54 }}</td>
                              <td>Pria : {{ $total_keseluruhan_jul_pria_umur_45_54 }}<br>Wanita : {{ $total_keseluruhan_jul_wanita_umur_45_54 }}</td>
                              <td>Pria : {{ $total_keseluruhan_agu_pria_umur_45_54 }}<br>Wanita : {{ $total_keseluruhan_agu_wanita_umur_45_54 }}</td>
                              <td>Pria : {{ $total_keseluruhan_sep_pria_umur_45_54 }}<br>Wanita : {{ $total_keseluruhan_sep_wanita_umur_45_54 }}</td>
                              <td>Pria : {{ $total_keseluruhan_okt_pria_umur_45_54 }}<br>Wanita : {{ $total_keseluruhan_okt_wanita_umur_45_54 }}</td>
                              <td>Pria : {{ $total_keseluruhan_nov_pria_umur_45_54 }}<br>Wanita : {{ $total_keseluruhan_nov_wanita_umur_45_54 }}</td>
                              <td>Pria : {{ $total_keseluruhan_des_pria_umur_45_54 }}<br>Wanita : {{ $total_keseluruhan_des_wanita_umur_45_54 }}</td>
                            </tr>

                            <tr>
                              <td>
                                <b>55-64</b> 
                              </td>
                              <td>Pria : {{ $total_keseluruhan_jan_pria_umur_55_64 }}<br>Wanita : {{ $total_keseluruhan_jan_wanita_umur_55_64 }}</td>
                              <td>Pria : {{ $total_keseluruhan_feb_pria_umur_55_64 }}<br>Wanita : {{ $total_keseluruhan_feb_wanita_umur_55_64 }}</td>
                              <td>Pria : {{ $total_keseluruhan_mar_pria_umur_55_64 }}<br>Wanita : {{ $total_keseluruhan_mar_wanita_umur_55_64 }}</td>
                              <td>Pria : {{ $total_keseluruhan_apr_pria_umur_55_64 }}<br>Wanita : {{ $total_keseluruhan_apr_wanita_umur_55_64 }}</td>
                              <td>Pria : {{ $total_keseluruhan_mei_pria_umur_55_64 }}<br>Wanita : {{ $total_keseluruhan_mei_wanita_umur_55_64 }}</td>
                              <td>Pria : {{ $total_keseluruhan_jun_pria_umur_55_64 }}<br>Wanita : {{ $total_keseluruhan_jun_wanita_umur_55_64 }}</td>
                              <td>Pria : {{ $total_keseluruhan_jul_pria_umur_55_64 }}<br>Wanita : {{ $total_keseluruhan_jul_wanita_umur_55_64 }}</td>
                              <td>Pria : {{ $total_keseluruhan_agu_pria_umur_55_64 }}<br>Wanita : {{ $total_keseluruhan_agu_wanita_umur_55_64 }}</td>
                              <td>Pria : {{ $total_keseluruhan_sep_pria_umur_55_64 }}<br>Wanita : {{ $total_keseluruhan_sep_wanita_umur_55_64 }}</td>
                              <td>Pria : {{ $total_keseluruhan_okt_pria_umur_55_64 }}<br>Wanita : {{ $total_keseluruhan_okt_wanita_umur_55_64 }}</td>
                              <td>Pria : {{ $total_keseluruhan_nov_pria_umur_55_64 }}<br>Wanita : {{ $total_keseluruhan_nov_wanita_umur_55_64 }}</td>
                              <td>Pria : {{ $total_keseluruhan_des_pria_umur_55_64 }}<br>Wanita : {{ $total_keseluruhan_des_wanita_umur_55_64 }}</td>
                            </tr>

                            <tr>
                              <td>
                                <b> >65</b> 
                              </td>
                              <td>Pria : {{ $total_keseluruhan_jan_pria_umur_65 }}<br>Wanita : {{ $total_keseluruhan_jan_wanita_umur_65 }}</td>
                              <td>Pria : {{ $total_keseluruhan_feb_pria_umur_65 }}<br>Wanita : {{ $total_keseluruhan_feb_wanita_umur_65 }}</td>
                              <td>Pria : {{ $total_keseluruhan_mar_pria_umur_65 }}<br>Wanita : {{ $total_keseluruhan_mar_wanita_umur_65 }}</td>
                              <td>Pria : {{ $total_keseluruhan_apr_pria_umur_65 }}<br>Wanita : {{ $total_keseluruhan_apr_wanita_umur_65 }}</td>
                              <td>Pria : {{ $total_keseluruhan_mei_pria_umur_65 }}<br>Wanita : {{ $total_keseluruhan_mei_wanita_umur_65 }}</td>
                              <td>Pria : {{ $total_keseluruhan_jun_pria_umur_65 }}<br>Wanita : {{ $total_keseluruhan_jun_wanita_umur_65 }}</td>
                              <td>Pria : {{ $total_keseluruhan_jul_pria_umur_65 }}<br>Wanita : {{ $total_keseluruhan_jul_wanita_umur_65 }}</td>
                              <td>Pria : {{ $total_keseluruhan_agu_pria_umur_65 }}<br>Wanita : {{ $total_keseluruhan_agu_wanita_umur_65 }}</td>
                              <td>Pria : {{ $total_keseluruhan_sep_pria_umur_65 }}<br>Wanita : {{ $total_keseluruhan_sep_wanita_umur_65 }}</td>
                              <td>Pria : {{ $total_keseluruhan_okt_pria_umur_65 }}<br>Wanita : {{ $total_keseluruhan_okt_wanita_umur_65 }}</td>
                              <td>Pria : {{ $total_keseluruhan_nov_pria_umur_65 }}<br>Wanita : {{ $total_keseluruhan_nov_wanita_umur_65 }}</td>
                              <td>Pria : {{ $total_keseluruhan_des_pria_umur_65 }}<br>Wanita : {{ $total_keseluruhan_des_wanita_umur_65 }}</td>
                            </tr>
  
                            <tr style="background-color: cadetblue">
                              <td>
                                <b>TOTAL</b> 
                              </td>
                              <td @if($total_keseluruhan_jan_all_umur_18_24+$total_keseluruhan_jan_all_umur_25_34+$total_keseluruhan_jan_all_umur_35_44+$total_keseluruhan_jan_all_umur_45_54+$total_keseluruhan_jan_all_umur_55_64+$total_keseluruhan_jan_all_umur_65 == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_jan_all_umur_18_24+$total_keseluruhan_jan_all_umur_25_34+$total_keseluruhan_jan_all_umur_35_44+$total_keseluruhan_jan_all_umur_45_54+$total_keseluruhan_jan_all_umur_55_64+$total_keseluruhan_jan_all_umur_65 }}</td>
                              <td @if($total_keseluruhan_feb_all_umur_18_24+$total_keseluruhan_feb_all_umur_25_34+$total_keseluruhan_feb_all_umur_35_44+$total_keseluruhan_feb_all_umur_45_54+$total_keseluruhan_feb_all_umur_55_64+$total_keseluruhan_feb_all_umur_65 == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_feb_all_umur_18_24+$total_keseluruhan_feb_all_umur_25_34+$total_keseluruhan_feb_all_umur_35_44+$total_keseluruhan_feb_all_umur_45_54+$total_keseluruhan_feb_all_umur_55_64+$total_keseluruhan_feb_all_umur_65 }}</td>
                              <td @if($total_keseluruhan_mar_all_umur_18_24+$total_keseluruhan_mar_all_umur_25_34+$total_keseluruhan_mar_all_umur_35_44+$total_keseluruhan_mar_all_umur_45_54+$total_keseluruhan_mar_all_umur_55_64+$total_keseluruhan_mar_all_umur_65 == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_mar_all_umur_18_24+$total_keseluruhan_mar_all_umur_25_34+$total_keseluruhan_mar_all_umur_35_44+$total_keseluruhan_mar_all_umur_45_54+$total_keseluruhan_mar_all_umur_55_64+$total_keseluruhan_mar_all_umur_65 }}</td>
                              <td @if($total_keseluruhan_apr_all_umur_18_24+$total_keseluruhan_apr_all_umur_25_34+$total_keseluruhan_apr_all_umur_35_44+$total_keseluruhan_apr_all_umur_45_54+$total_keseluruhan_apr_all_umur_55_64+$total_keseluruhan_apr_all_umur_65 == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_apr_all_umur_18_24+$total_keseluruhan_apr_all_umur_25_34+$total_keseluruhan_apr_all_umur_35_44+$total_keseluruhan_apr_all_umur_45_54+$total_keseluruhan_apr_all_umur_55_64+$total_keseluruhan_apr_all_umur_65 }}</td>
                              <td @if($total_keseluruhan_mei_all_umur_18_24+$total_keseluruhan_mei_all_umur_25_34+$total_keseluruhan_mei_all_umur_35_44+$total_keseluruhan_mei_all_umur_45_54+$total_keseluruhan_mei_all_umur_55_64+$total_keseluruhan_mei_all_umur_65 == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_mei_all_umur_18_24+$total_keseluruhan_mei_all_umur_25_34+$total_keseluruhan_mei_all_umur_35_44+$total_keseluruhan_mei_all_umur_45_54+$total_keseluruhan_mei_all_umur_55_64+$total_keseluruhan_mei_all_umur_65 }}</td>
                              <td @if($total_keseluruhan_jun_all_umur_18_24+$total_keseluruhan_jun_all_umur_25_34+$total_keseluruhan_jun_all_umur_35_44+$total_keseluruhan_jun_all_umur_45_54+$total_keseluruhan_jun_all_umur_55_64+$total_keseluruhan_jun_all_umur_65 == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_jun_all_umur_18_24+$total_keseluruhan_jun_all_umur_25_34+$total_keseluruhan_jun_all_umur_35_44+$total_keseluruhan_jun_all_umur_45_54+$total_keseluruhan_jun_all_umur_55_64+$total_keseluruhan_jun_all_umur_65 }}</td>
                              <td @if($total_keseluruhan_jul_all_umur_18_24+$total_keseluruhan_jul_all_umur_25_34+$total_keseluruhan_jul_all_umur_35_44+$total_keseluruhan_jul_all_umur_45_54+$total_keseluruhan_jul_all_umur_55_64+$total_keseluruhan_jul_all_umur_65 == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_jul_all_umur_18_24+$total_keseluruhan_jul_all_umur_25_34+$total_keseluruhan_jul_all_umur_35_44+$total_keseluruhan_jul_all_umur_45_54+$total_keseluruhan_jul_all_umur_55_64+$total_keseluruhan_jul_all_umur_65 }}</td>
                              <td @if($total_keseluruhan_agu_all_umur_18_24+$total_keseluruhan_agu_all_umur_25_34+$total_keseluruhan_agu_all_umur_35_44+$total_keseluruhan_agu_all_umur_45_54+$total_keseluruhan_agu_all_umur_55_64+$total_keseluruhan_agu_all_umur_65 == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_agu_all_umur_18_24+$total_keseluruhan_agu_all_umur_25_34+$total_keseluruhan_agu_all_umur_35_44+$total_keseluruhan_agu_all_umur_45_54+$total_keseluruhan_agu_all_umur_55_64+$total_keseluruhan_agu_all_umur_65 }}</td>
                              <td @if($total_keseluruhan_sep_all_umur_18_24+$total_keseluruhan_sep_all_umur_25_34+$total_keseluruhan_sep_all_umur_35_44+$total_keseluruhan_sep_all_umur_45_54+$total_keseluruhan_sep_all_umur_55_64+$total_keseluruhan_sep_all_umur_65 == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_sep_all_umur_18_24+$total_keseluruhan_sep_all_umur_25_34+$total_keseluruhan_sep_all_umur_35_44+$total_keseluruhan_sep_all_umur_45_54+$total_keseluruhan_sep_all_umur_55_64+$total_keseluruhan_sep_all_umur_65 }}</td>
                              <td @if($total_keseluruhan_okt_all_umur_18_24+$total_keseluruhan_okt_all_umur_25_34+$total_keseluruhan_okt_all_umur_35_44+$total_keseluruhan_okt_all_umur_45_54+$total_keseluruhan_okt_all_umur_55_64+$total_keseluruhan_okt_all_umur_65 == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_okt_all_umur_18_24+$total_keseluruhan_okt_all_umur_25_34+$total_keseluruhan_okt_all_umur_35_44+$total_keseluruhan_okt_all_umur_45_54+$total_keseluruhan_okt_all_umur_55_64+$total_keseluruhan_okt_all_umur_65 }}</td>
                              <td @if($total_keseluruhan_nov_all_umur_18_24+$total_keseluruhan_nov_all_umur_25_34+$total_keseluruhan_nov_all_umur_35_44+$total_keseluruhan_nov_all_umur_45_54+$total_keseluruhan_nov_all_umur_55_64+$total_keseluruhan_nov_all_umur_65 == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_nov_all_umur_18_24+$total_keseluruhan_nov_all_umur_25_34+$total_keseluruhan_nov_all_umur_35_44+$total_keseluruhan_nov_all_umur_45_54+$total_keseluruhan_nov_all_umur_55_64+$total_keseluruhan_nov_all_umur_65 }}</td>
                              <td @if($total_keseluruhan_des_all_umur_18_24+$total_keseluruhan_des_all_umur_25_34+$total_keseluruhan_des_all_umur_35_44+$total_keseluruhan_des_all_umur_45_54+$total_keseluruhan_des_all_umur_55_64+$total_keseluruhan_des_all_umur_65 == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_des_all_umur_18_24+$total_keseluruhan_des_all_umur_25_34+$total_keseluruhan_des_all_umur_35_44+$total_keseluruhan_des_all_umur_45_54+$total_keseluruhan_des_all_umur_55_64+$total_keseluruhan_des_all_umur_65 }}</td>
                            </tr>
                            
                        </table>
                        </div>

                        <hr>
                      <figure class="highcharts-figure">
                        <div id="container_sumber"></div>
                      </figure>

                      <div class="table-responsive p-1" style="height: 500px;" >
                        <table id="example1" class="table table-sm table-bordered table-striped table-head-fixed text-nowrap">
                          <tr>
                            <tr style="background-color: cadetblue">
                              <td>
                                <b>Sumber Informasi</b> 
                              </td>
                            <td>Jan</td><td>Feb</td><td>Mar</td><td>Apr</td><td>Mei</td><td>Jun</td><td>Jul</td><td>Agu</td><td>Sep</td><td>Okt</td><td>Nov</td><td>Des</td>
                          
                            </tr>
                          </tr>
                            <tr>
                              <td>
                                <b>Media Publikasi</b> 
                              </td>
                              <td>{{ $total_keseluruhan_jan_sumber_informasi_media_publikasi }}</td>
                              <td>{{ $total_keseluruhan_feb_sumber_informasi_media_publikasi }}</td>
                              <td>{{ $total_keseluruhan_mar_sumber_informasi_media_publikasi }}</td>
                              <td>{{ $total_keseluruhan_apr_sumber_informasi_media_publikasi }}</td>
                              <td>{{ $total_keseluruhan_mei_sumber_informasi_media_publikasi }}</td>
                              <td>{{ $total_keseluruhan_jun_sumber_informasi_media_publikasi }}</td>
                              <td>{{ $total_keseluruhan_jul_sumber_informasi_media_publikasi }}</td>
                              <td>{{ $total_keseluruhan_agu_sumber_informasi_media_publikasi }}</td>
                              <td>{{ $total_keseluruhan_sep_sumber_informasi_media_publikasi }}</td>
                              <td>{{ $total_keseluruhan_okt_sumber_informasi_media_publikasi }}</td>
                              <td>{{ $total_keseluruhan_nov_sumber_informasi_media_publikasi }}</td>
                              <td>{{ $total_keseluruhan_des_sumber_informasi_media_publikasi }}</td>
                            </tr>

                            <tr>
                              <td>
                                <b>Website</b> 
                              </td>
                              <td>{{ $total_keseluruhan_jan_sumber_informasi_website }}</td>
                              <td>{{ $total_keseluruhan_feb_sumber_informasi_website }}</td>
                              <td>{{ $total_keseluruhan_mar_sumber_informasi_website }}</td>
                              <td>{{ $total_keseluruhan_apr_sumber_informasi_website }}</td>
                              <td>{{ $total_keseluruhan_mei_sumber_informasi_website }}</td>
                              <td>{{ $total_keseluruhan_jun_sumber_informasi_website }}</td>
                              <td>{{ $total_keseluruhan_jul_sumber_informasi_website }}</td>
                              <td>{{ $total_keseluruhan_agu_sumber_informasi_website }}</td>
                              <td>{{ $total_keseluruhan_sep_sumber_informasi_website }}</td>
                              <td>{{ $total_keseluruhan_okt_sumber_informasi_website }}</td>
                              <td>{{ $total_keseluruhan_nov_sumber_informasi_website }}</td>
                              <td>{{ $total_keseluruhan_des_sumber_informasi_website }}</td>
                            </tr>

                            <tr>
                              <td>
                                <b>Social Media</b> 
                              </td>
                              <td>{{ $total_keseluruhan_jan_sumber_informasi_social_media }}</td>
                              <td>{{ $total_keseluruhan_feb_sumber_informasi_social_media }}</td>
                              <td>{{ $total_keseluruhan_mar_sumber_informasi_social_media }}</td>
                              <td>{{ $total_keseluruhan_apr_sumber_informasi_social_media }}</td>
                              <td>{{ $total_keseluruhan_mei_sumber_informasi_social_media }}</td>
                              <td>{{ $total_keseluruhan_jun_sumber_informasi_social_media }}</td>
                              <td>{{ $total_keseluruhan_jul_sumber_informasi_social_media }}</td>
                              <td>{{ $total_keseluruhan_agu_sumber_informasi_social_media }}</td>
                              <td>{{ $total_keseluruhan_sep_sumber_informasi_social_media }}</td>
                              <td>{{ $total_keseluruhan_okt_sumber_informasi_social_media }}</td>
                              <td>{{ $total_keseluruhan_nov_sumber_informasi_social_media }}</td>
                              <td>{{ $total_keseluruhan_des_sumber_informasi_social_media }}</td>
                            </tr>

                            <tr>
                              <td>
                                <b>Database</b> 
                              </td>
                              <td>{{ $total_keseluruhan_jan_sumber_informasi_database }}</td>
                              <td>{{ $total_keseluruhan_feb_sumber_informasi_database }}</td>
                              <td>{{ $total_keseluruhan_mar_sumber_informasi_database }}</td>
                              <td>{{ $total_keseluruhan_apr_sumber_informasi_database }}</td>
                              <td>{{ $total_keseluruhan_mei_sumber_informasi_database }}</td>
                              <td>{{ $total_keseluruhan_jun_sumber_informasi_database }}</td>
                              <td>{{ $total_keseluruhan_jul_sumber_informasi_database }}</td>
                              <td>{{ $total_keseluruhan_agu_sumber_informasi_database }}</td>
                              <td>{{ $total_keseluruhan_sep_sumber_informasi_database }}</td>
                              <td>{{ $total_keseluruhan_okt_sumber_informasi_database }}</td>
                              <td>{{ $total_keseluruhan_nov_sumber_informasi_database }}</td>
                              <td>{{ $total_keseluruhan_des_sumber_informasi_database }}</td>
                             </tr>

                            <tr>
                              <td>
                                <b>Lain-lain</b> 
                              </td>
                              <td>{{ $total_keseluruhan_jan_sumber_informasi_lain }}</td>
                              <td>{{ $total_keseluruhan_feb_sumber_informasi_lain }}</td>
                              <td>{{ $total_keseluruhan_mar_sumber_informasi_lain }}</td>
                              <td>{{ $total_keseluruhan_apr_sumber_informasi_lain }}</td>
                              <td>{{ $total_keseluruhan_mei_sumber_informasi_lain }}</td>
                              <td>{{ $total_keseluruhan_jun_sumber_informasi_lain }}</td>
                              <td>{{ $total_keseluruhan_jul_sumber_informasi_lain }}</td>
                              <td>{{ $total_keseluruhan_agu_sumber_informasi_lain }}</td>
                              <td>{{ $total_keseluruhan_sep_sumber_informasi_lain }}</td>
                              <td>{{ $total_keseluruhan_okt_sumber_informasi_lain }}</td>
                              <td>{{ $total_keseluruhan_nov_sumber_informasi_lain }}</td>
                              <td>{{ $total_keseluruhan_des_sumber_informasi_lain }}</td>
                            </tr>

                            
  
                            <tr style="background-color: cadetblue">
                              <td>
                                <b>TOTAL</b> 
                              </td>
                              <td @if($total_keseluruhan_jan_sumber_informasi_media_publikasi+$total_keseluruhan_jan_sumber_informasi_website+$total_keseluruhan_jan_sumber_informasi_social_media+$total_keseluruhan_jan_sumber_informasi_database+$total_keseluruhan_jan_sumber_informasi_lain == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_jan_sumber_informasi_media_publikasi+$total_keseluruhan_jan_sumber_informasi_website+$total_keseluruhan_jan_sumber_informasi_social_media+$total_keseluruhan_jan_sumber_informasi_database+$total_keseluruhan_jan_sumber_informasi_lain }}</td>
                              <td @if($total_keseluruhan_feb_sumber_informasi_media_publikasi+$total_keseluruhan_feb_sumber_informasi_website+$total_keseluruhan_feb_sumber_informasi_social_media+$total_keseluruhan_feb_sumber_informasi_database+$total_keseluruhan_feb_sumber_informasi_lain == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_feb_sumber_informasi_media_publikasi+$total_keseluruhan_feb_sumber_informasi_website+$total_keseluruhan_feb_sumber_informasi_social_media+$total_keseluruhan_feb_sumber_informasi_database+$total_keseluruhan_feb_sumber_informasi_lain }}</td>
                              <td @if($total_keseluruhan_mar_sumber_informasi_media_publikasi+$total_keseluruhan_mar_sumber_informasi_website+$total_keseluruhan_mar_sumber_informasi_social_media+$total_keseluruhan_mar_sumber_informasi_database+$total_keseluruhan_mar_sumber_informasi_lain == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_mar_sumber_informasi_media_publikasi+$total_keseluruhan_mar_sumber_informasi_website+$total_keseluruhan_mar_sumber_informasi_social_media+$total_keseluruhan_mar_sumber_informasi_database+$total_keseluruhan_mar_sumber_informasi_lain }}</td>
                              <td @if($total_keseluruhan_apr_sumber_informasi_media_publikasi+$total_keseluruhan_apr_sumber_informasi_website+$total_keseluruhan_apr_sumber_informasi_social_media+$total_keseluruhan_apr_sumber_informasi_database+$total_keseluruhan_apr_sumber_informasi_lain == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_apr_sumber_informasi_media_publikasi+$total_keseluruhan_apr_sumber_informasi_website+$total_keseluruhan_apr_sumber_informasi_social_media+$total_keseluruhan_apr_sumber_informasi_database+$total_keseluruhan_apr_sumber_informasi_lain }}</td>
                              <td @if($total_keseluruhan_mei_sumber_informasi_media_publikasi+$total_keseluruhan_mei_sumber_informasi_website+$total_keseluruhan_mei_sumber_informasi_social_media+$total_keseluruhan_mei_sumber_informasi_database+$total_keseluruhan_mei_sumber_informasi_lain == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_mei_sumber_informasi_media_publikasi+$total_keseluruhan_mei_sumber_informasi_website+$total_keseluruhan_mei_sumber_informasi_social_media+$total_keseluruhan_mei_sumber_informasi_database+$total_keseluruhan_mei_sumber_informasi_lain }}</td>
                              <td @if($total_keseluruhan_jun_sumber_informasi_media_publikasi+$total_keseluruhan_jun_sumber_informasi_website+$total_keseluruhan_jun_sumber_informasi_social_media+$total_keseluruhan_jun_sumber_informasi_database+$total_keseluruhan_jun_sumber_informasi_lain == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_jun_sumber_informasi_media_publikasi+$total_keseluruhan_jun_sumber_informasi_website+$total_keseluruhan_jun_sumber_informasi_social_media+$total_keseluruhan_jun_sumber_informasi_database+$total_keseluruhan_jun_sumber_informasi_lain }}</td>
                              <td @if($total_keseluruhan_jul_sumber_informasi_media_publikasi+$total_keseluruhan_jul_sumber_informasi_website+$total_keseluruhan_jul_sumber_informasi_social_media+$total_keseluruhan_jul_sumber_informasi_database+$total_keseluruhan_jul_sumber_informasi_lain == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_jul_sumber_informasi_media_publikasi+$total_keseluruhan_jul_sumber_informasi_website+$total_keseluruhan_jul_sumber_informasi_social_media+$total_keseluruhan_jul_sumber_informasi_database+$total_keseluruhan_jul_sumber_informasi_lain }}</td>
                              <td @if($total_keseluruhan_agu_sumber_informasi_media_publikasi+$total_keseluruhan_agu_sumber_informasi_website+$total_keseluruhan_agu_sumber_informasi_social_media+$total_keseluruhan_agu_sumber_informasi_database+$total_keseluruhan_agu_sumber_informasi_lain == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_agu_sumber_informasi_media_publikasi+$total_keseluruhan_agu_sumber_informasi_website+$total_keseluruhan_agu_sumber_informasi_social_media+$total_keseluruhan_agu_sumber_informasi_database+$total_keseluruhan_agu_sumber_informasi_lain }}</td>
                              <td @if($total_keseluruhan_sep_sumber_informasi_media_publikasi+$total_keseluruhan_sep_sumber_informasi_website+$total_keseluruhan_sep_sumber_informasi_social_media+$total_keseluruhan_sep_sumber_informasi_database+$total_keseluruhan_sep_sumber_informasi_lain == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_sep_sumber_informasi_media_publikasi+$total_keseluruhan_sep_sumber_informasi_website+$total_keseluruhan_sep_sumber_informasi_social_media+$total_keseluruhan_sep_sumber_informasi_database+$total_keseluruhan_sep_sumber_informasi_lain }}</td>
                              <td @if($total_keseluruhan_okt_sumber_informasi_media_publikasi+$total_keseluruhan_okt_sumber_informasi_website+$total_keseluruhan_okt_sumber_informasi_social_media+$total_keseluruhan_okt_sumber_informasi_database+$total_keseluruhan_okt_sumber_informasi_lain == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_okt_sumber_informasi_media_publikasi+$total_keseluruhan_okt_sumber_informasi_website+$total_keseluruhan_okt_sumber_informasi_social_media+$total_keseluruhan_okt_sumber_informasi_database+$total_keseluruhan_okt_sumber_informasi_lain }}</td>
                              <td @if($total_keseluruhan_nov_sumber_informasi_media_publikasi+$total_keseluruhan_nov_sumber_informasi_website+$total_keseluruhan_nov_sumber_informasi_social_media+$total_keseluruhan_nov_sumber_informasi_database+$total_keseluruhan_nov_sumber_informasi_lain == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_nov_sumber_informasi_media_publikasi+$total_keseluruhan_nov_sumber_informasi_website+$total_keseluruhan_nov_sumber_informasi_social_media+$total_keseluruhan_nov_sumber_informasi_database+$total_keseluruhan_nov_sumber_informasi_lain }}</td>
                              <td @if($total_keseluruhan_des_sumber_informasi_media_publikasi+$total_keseluruhan_des_sumber_informasi_website+$total_keseluruhan_des_sumber_informasi_social_media+$total_keseluruhan_des_sumber_informasi_database+$total_keseluruhan_des_sumber_informasi_lain == 0) style="background-color: rgb(194, 43, 5)" @endif >{{ $total_keseluruhan_des_sumber_informasi_media_publikasi+$total_keseluruhan_des_sumber_informasi_website+$total_keseluruhan_des_sumber_informasi_social_media+$total_keseluruhan_des_sumber_informasi_database+$total_keseluruhan_des_sumber_informasi_lain }}</td>
                              </tr>
                            
                        </table>
                        </div>

                        <br><br><br><br><br>

                       
                    <?php } ?>




                    <br /><br /><br />
                  </div>
                  
                </div>
              </div>
        </div>
       
      </div>
    </section>


    <footer class="main-footer" style=" color:white;  background-color: #6495ED">
      <strong>Grafik Tamu WI</strong>
      <div class="float-right" >
        <a href="{{ route('user.profilkaryawan') }}"><font color="white"> Account</font>  <img src="{{ asset('assets_backend/img/icon/profile-user.svg') }}" width="30px"  /></a>
      </div>
    </footer>
  </div>


  
@endsection

@section('footer')
<?php if(isset($_GET['tahun'])){ ?>

  
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/variable-pie.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
Highcharts.chart('container', {
    title: {
        text: 'Laporan Grafik Rekap Tamu WI'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei','Jun', 'Jul', 'Agu', 'Sept', 'Okt', 'Nov', 'Des']
    },
    labels: {
        items: [{
            
            style: {
                left: '50px',
                top: '18px',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'black'
            }
        }]
    },
    series: [{
        type: 'column',
        name: 'Total Tamu Datang',
        data: [{{ $total_keseluruhan_jan }}, {{ $total_keseluruhan_feb }}, {{ $total_keseluruhan_mar }}, {{ $total_keseluruhan_apr }}, {{ $total_keseluruhan_mei }}, {{ $total_keseluruhan_jun }}, {{ $total_keseluruhan_jul }}, {{ $total_keseluruhan_agu }}, {{ $total_keseluruhan_sep }},{{ $total_keseluruhan_okt }}, {{ $total_keseluruhan_nov }},{{ $total_keseluruhan_des }}]
    }, {
        type: 'column',
        name: 'Total Tamu Baru',
        data: [{{ $total_baru_jan }}, {{ $total_baru_feb }}, {{ $total_baru_mar }}, {{ $total_baru_apr }}, {{ $total_baru_mei }},{{ $total_baru_jun }}, {{ $total_baru_jul }}, {{ $total_baru_agu }}, {{ $total_baru_sep }}, {{ $total_baru_okt }},{{ $total_baru_nov }}, {{ $total_baru_des }}]
    }, {
        type: 'column',
        name: 'Total Tamu Proses',
        data: [{{ $total_proses_jan }}, {{ $total_proses_feb }}, {{ $total_proses_mar }}, {{ $total_proses_apr }}, {{ $total_proses_mei }},{{ $total_proses_jun }}, {{ $total_proses_jul }}, {{ $total_proses_agu }}, {{ $total_proses_sep }}, {{ $total_proses_okt }},{{ $total_proses_nov }}, {{ $total_proses_des }}]
    }, {
        type: 'column',
        name: 'Total Tamu Closing',
        data: [{{ $total_closing_jan }}, {{ $total_closing_feb }}, {{ $total_closing_mar }}, {{ $total_closing_apr }}, {{ $total_closing_mei }},{{ $total_closing_jun }}, {{ $total_closing_jul }}, {{ $total_closing_agu }}, {{ $total_closing_sep }}, {{ $total_closing_okt }},{{ $total_closing_nov }}, {{ $total_closing_des }}]
    }, {
        type: 'column',
        name: 'Total Tamu Batal',
        data: [{{ $total_batal_jan }}, {{ $total_batal_feb }}, {{ $total_batal_mar }}, {{ $total_batal_apr }}, {{ $total_batal_mei }},{{ $total_batal_jun }}, {{ $total_batal_jul }}, {{ $total_batal_agu }}, {{ $total_batal_sep }}, {{ $total_batal_okt }},{{ $total_batal_nov }}, {{ $total_batal_des }}]
    }, {
        type: 'column',
        name: 'Total Tamu Reserve',
        data: [{{ $total_reserve_jan }}, {{ $total_reserve_feb }}, {{ $total_reserve_mar }}, {{ $total_reserve_apr }}, {{ $total_reserve_mei }},{{ $total_reserve_jun }}, {{ $total_reserve_jul }}, {{ $total_reserve_agu }}, {{ $total_reserve_sep }}, {{ $total_reserve_okt }},{{ $total_reserve_nov }}, {{ $total_reserve_des }}]
    }, {
      //garis grafik tamu closing
        type: 'spline',
        name: 'Average Closing',
        data: [{{ $total_closing_jan }}, {{ $total_closing_feb }}, {{ $total_closing_mar }}, {{ $total_closing_apr }}, {{ $total_closing_mei }},{{ $total_closing_jun }}, {{ $total_closing_jul }}, {{ $total_closing_agu }}, {{ $total_closing_sep }}, {{ $total_closing_okt }},{{ $total_closing_nov }}, {{ $total_closing_des }}],
        marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }
    }]
});

//jenis kelamin

Highcharts.chart('container_jk', {
    title: {
        text: 'Laporan Grafik Tamu WI Berdasarkan Jenis Kelamin'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei','Jun', 'Jul', 'Agu', 'Sept', 'Okt', 'Nov', 'Des']
    },
    labels: {
        items: [{
            
            style: {
                left: '50px',
                top: '18px',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'black'
            }
        }]
    },
    series: [{
        type: 'column',
        name: 'Total Tamu Pria',
        data: [{{ $total_keseluruhan_jan_jk_pria }}, 
               {{ $total_keseluruhan_feb_jk_pria }}, 
               {{ $total_keseluruhan_mar_jk_pria }}, 
               {{ $total_keseluruhan_apr_jk_pria }}, 
               {{ $total_keseluruhan_mei_jk_pria }}, 
               {{ $total_keseluruhan_jun_jk_pria }}, 
               {{ $total_keseluruhan_jul_jk_pria }}, 
               {{ $total_keseluruhan_agu_jk_pria }}, 
               {{ $total_keseluruhan_sep_jk_pria }},
               {{ $total_keseluruhan_okt_jk_pria }}, 
               {{ $total_keseluruhan_nov_jk_pria }},
               {{ $total_keseluruhan_des_jk_pria }}]
    }, {
        type: 'column',
        name: 'Total Tamu Wanita',
        data: [{{ $total_keseluruhan_jan_jk_wanita }}, 
               {{ $total_keseluruhan_feb_jk_wanita }}, 
               {{ $total_keseluruhan_mar_jk_wanita }}, 
               {{ $total_keseluruhan_apr_jk_wanita }}, 
               {{ $total_keseluruhan_mei_jk_wanita }}, 
               {{ $total_keseluruhan_jun_jk_wanita }}, 
               {{ $total_keseluruhan_jul_jk_wanita }}, 
               {{ $total_keseluruhan_agu_jk_wanita }}, 
               {{ $total_keseluruhan_sep_jk_wanita }},
               {{ $total_keseluruhan_okt_jk_wanita }}, 
               {{ $total_keseluruhan_nov_jk_wanita }},
               {{ $total_keseluruhan_des_jk_wanita }}]
    }]
});


//umur

Highcharts.chart('container_umur', {
    title: {
        text: 'Laporan Grafik Tamu WI Berdasarkan Umur'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei','Jun', 'Jul', 'Agu', 'Sept', 'Okt', 'Nov', 'Des']
    },
    labels: {
        items: [{
            
            style: {
                left: '50px',
                top: '18px',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'black'
            }
        }]
    },
    series: [{
        type: 'column',
        name: 'Umur 18-24',
        data: [{{ $total_keseluruhan_jan_all_umur_18_24 }}, 
               {{ $total_keseluruhan_feb_all_umur_18_24 }}, 
               {{ $total_keseluruhan_mar_all_umur_18_24 }}, 
               {{ $total_keseluruhan_apr_all_umur_18_24 }}, 
               {{ $total_keseluruhan_mei_all_umur_18_24 }}, 
               {{ $total_keseluruhan_jun_all_umur_18_24 }}, 
               {{ $total_keseluruhan_jul_all_umur_18_24 }}, 
               {{ $total_keseluruhan_agu_all_umur_18_24 }}, 
               {{ $total_keseluruhan_sep_all_umur_18_24 }},
               {{ $total_keseluruhan_okt_all_umur_18_24 }}, 
               {{ $total_keseluruhan_nov_all_umur_18_24 }},
               {{ $total_keseluruhan_des_all_umur_18_24 }}]
    }, {
        type: 'column',
        name: 'Umur 25-34',
        data: [{{ $total_keseluruhan_jan_all_umur_25_34 }}, 
               {{ $total_keseluruhan_feb_all_umur_25_34 }}, 
               {{ $total_keseluruhan_mar_all_umur_25_34 }}, 
               {{ $total_keseluruhan_apr_all_umur_25_34 }}, 
               {{ $total_keseluruhan_mei_all_umur_25_34 }}, 
               {{ $total_keseluruhan_jun_all_umur_25_34 }}, 
               {{ $total_keseluruhan_jul_all_umur_25_34 }}, 
               {{ $total_keseluruhan_agu_all_umur_25_34 }}, 
               {{ $total_keseluruhan_sep_all_umur_25_34 }},
               {{ $total_keseluruhan_okt_all_umur_25_34 }}, 
               {{ $total_keseluruhan_nov_all_umur_25_34 }},
               {{ $total_keseluruhan_des_all_umur_25_34 }}]
    }, {
        type: 'column',
        name: 'Umur 35-44',
        data: [{{ $total_keseluruhan_jan_all_umur_35_44 }}, 
               {{ $total_keseluruhan_feb_all_umur_35_44 }}, 
               {{ $total_keseluruhan_mar_all_umur_35_44 }}, 
               {{ $total_keseluruhan_apr_all_umur_35_44 }}, 
               {{ $total_keseluruhan_mei_all_umur_35_44 }}, 
               {{ $total_keseluruhan_jun_all_umur_35_44 }}, 
               {{ $total_keseluruhan_jul_all_umur_35_44 }}, 
               {{ $total_keseluruhan_agu_all_umur_35_44 }}, 
               {{ $total_keseluruhan_sep_all_umur_35_44 }},
               {{ $total_keseluruhan_okt_all_umur_35_44 }}, 
               {{ $total_keseluruhan_nov_all_umur_35_44 }},
               {{ $total_keseluruhan_des_all_umur_35_44 }}]
    }, {
        type: 'column',
        name: 'Umur 45-54',
        data: [{{ $total_keseluruhan_jan_all_umur_45_54 }}, 
               {{ $total_keseluruhan_feb_all_umur_45_54 }}, 
               {{ $total_keseluruhan_mar_all_umur_45_54 }}, 
               {{ $total_keseluruhan_apr_all_umur_45_54 }}, 
               {{ $total_keseluruhan_mei_all_umur_45_54 }}, 
               {{ $total_keseluruhan_jun_all_umur_45_54 }}, 
               {{ $total_keseluruhan_jul_all_umur_45_54 }}, 
               {{ $total_keseluruhan_agu_all_umur_45_54 }}, 
               {{ $total_keseluruhan_sep_all_umur_45_54 }},
               {{ $total_keseluruhan_okt_all_umur_45_54 }}, 
               {{ $total_keseluruhan_nov_all_umur_45_54 }},
               {{ $total_keseluruhan_des_all_umur_45_54 }}]
    }, {
        type: 'column',
        name: 'Umur 55-64',
        data: [{{ $total_keseluruhan_jan_all_umur_55_64 }}, 
               {{ $total_keseluruhan_feb_all_umur_55_64 }}, 
               {{ $total_keseluruhan_mar_all_umur_55_64 }}, 
               {{ $total_keseluruhan_apr_all_umur_55_64 }}, 
               {{ $total_keseluruhan_mei_all_umur_55_64 }}, 
               {{ $total_keseluruhan_jun_all_umur_55_64 }}, 
               {{ $total_keseluruhan_jul_all_umur_55_64 }}, 
               {{ $total_keseluruhan_agu_all_umur_55_64 }}, 
               {{ $total_keseluruhan_sep_all_umur_55_64 }},
               {{ $total_keseluruhan_okt_all_umur_55_64 }}, 
               {{ $total_keseluruhan_nov_all_umur_55_64 }},
               {{ $total_keseluruhan_des_all_umur_55_64 }}]
    }, {
        type: 'column',
        name: 'Umur >= 65',
        data: [{{ $total_keseluruhan_jan_all_umur_65 }}, 
               {{ $total_keseluruhan_feb_all_umur_65 }}, 
               {{ $total_keseluruhan_mar_all_umur_65 }}, 
               {{ $total_keseluruhan_apr_all_umur_65 }}, 
               {{ $total_keseluruhan_mei_all_umur_65 }}, 
               {{ $total_keseluruhan_jun_all_umur_65 }}, 
               {{ $total_keseluruhan_jul_all_umur_65 }}, 
               {{ $total_keseluruhan_agu_all_umur_65 }}, 
               {{ $total_keseluruhan_sep_all_umur_65 }},
               {{ $total_keseluruhan_okt_all_umur_65 }}, 
               {{ $total_keseluruhan_nov_all_umur_65 }},
               {{ $total_keseluruhan_des_all_umur_65 }}]
    }]
});


//sumber informasi

Highcharts.chart('container_sumber', {
    title: {
        text: 'Laporan Grafik Tamu WI Berdasarkan Sumber Informasi'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei','Jun', 'Jul', 'Agu', 'Sept', 'Okt', 'Nov', 'Des']
    },
    labels: {
        items: [{
            
            style: {
                left: '50px',
                top: '18px',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'black'
            }
        }]
    },
    series: [{
        type: 'column',
        name: 'Media Publikasi',
        data: [{{ $total_keseluruhan_jan_sumber_informasi_media_publikasi }}, 
               {{ $total_keseluruhan_feb_sumber_informasi_media_publikasi }}, 
               {{ $total_keseluruhan_mar_sumber_informasi_media_publikasi }}, 
               {{ $total_keseluruhan_apr_sumber_informasi_media_publikasi }}, 
               {{ $total_keseluruhan_mei_sumber_informasi_media_publikasi }}, 
               {{ $total_keseluruhan_jun_sumber_informasi_media_publikasi }}, 
               {{ $total_keseluruhan_jul_sumber_informasi_media_publikasi }}, 
               {{ $total_keseluruhan_agu_sumber_informasi_media_publikasi }}, 
               {{ $total_keseluruhan_sep_sumber_informasi_media_publikasi }},
               {{ $total_keseluruhan_okt_sumber_informasi_media_publikasi }}, 
               {{ $total_keseluruhan_nov_sumber_informasi_media_publikasi }},
               {{ $total_keseluruhan_des_sumber_informasi_media_publikasi }}]
    }, {
        type: 'column',
        name: 'Website',
        data: [{{ $total_keseluruhan_jan_sumber_informasi_website }}, 
               {{ $total_keseluruhan_feb_sumber_informasi_website }}, 
               {{ $total_keseluruhan_mar_sumber_informasi_website }}, 
               {{ $total_keseluruhan_apr_sumber_informasi_website }}, 
               {{ $total_keseluruhan_mei_sumber_informasi_website }}, 
               {{ $total_keseluruhan_jun_sumber_informasi_website }}, 
               {{ $total_keseluruhan_jul_sumber_informasi_website }}, 
               {{ $total_keseluruhan_agu_sumber_informasi_website }}, 
               {{ $total_keseluruhan_sep_sumber_informasi_website }},
               {{ $total_keseluruhan_okt_sumber_informasi_website }}, 
               {{ $total_keseluruhan_nov_sumber_informasi_website }},
               {{ $total_keseluruhan_des_sumber_informasi_website }}]
    }, {
        type: 'column',
        name: 'Social Media',
        data: [{{ $total_keseluruhan_jan_sumber_informasi_social_media }}, 
               {{ $total_keseluruhan_feb_sumber_informasi_social_media }}, 
               {{ $total_keseluruhan_mar_sumber_informasi_social_media }}, 
               {{ $total_keseluruhan_apr_sumber_informasi_social_media }}, 
               {{ $total_keseluruhan_mei_sumber_informasi_social_media }}, 
               {{ $total_keseluruhan_jun_sumber_informasi_social_media }}, 
               {{ $total_keseluruhan_jul_sumber_informasi_social_media }}, 
               {{ $total_keseluruhan_agu_sumber_informasi_social_media }}, 
               {{ $total_keseluruhan_sep_sumber_informasi_social_media }},
               {{ $total_keseluruhan_okt_sumber_informasi_social_media }}, 
               {{ $total_keseluruhan_nov_sumber_informasi_social_media }},
               {{ $total_keseluruhan_des_sumber_informasi_social_media }}]
    }, {
        type: 'column',
        name: 'Database',
        data: [{{ $total_keseluruhan_jan_sumber_informasi_database }}, 
               {{ $total_keseluruhan_feb_sumber_informasi_database }}, 
               {{ $total_keseluruhan_mar_sumber_informasi_database }}, 
               {{ $total_keseluruhan_apr_sumber_informasi_database }}, 
               {{ $total_keseluruhan_mei_sumber_informasi_database }}, 
               {{ $total_keseluruhan_jun_sumber_informasi_database }}, 
               {{ $total_keseluruhan_jul_sumber_informasi_database }}, 
               {{ $total_keseluruhan_agu_sumber_informasi_database }}, 
               {{ $total_keseluruhan_sep_sumber_informasi_database }},
               {{ $total_keseluruhan_okt_sumber_informasi_database }}, 
               {{ $total_keseluruhan_nov_sumber_informasi_database }},
               {{ $total_keseluruhan_des_sumber_informasi_database }}]
    }, {
        type: 'column',
        name: 'Lain-lain',
        data: [{{ $total_keseluruhan_jan_sumber_informasi_lain }}, 
               {{ $total_keseluruhan_feb_sumber_informasi_lain }}, 
               {{ $total_keseluruhan_mar_sumber_informasi_lain }}, 
               {{ $total_keseluruhan_apr_sumber_informasi_lain }}, 
               {{ $total_keseluruhan_mei_sumber_informasi_lain }}, 
               {{ $total_keseluruhan_jun_sumber_informasi_lain }}, 
               {{ $total_keseluruhan_jul_sumber_informasi_lain }}, 
               {{ $total_keseluruhan_agu_sumber_informasi_lain }}, 
               {{ $total_keseluruhan_sep_sumber_informasi_lain }},
               {{ $total_keseluruhan_okt_sumber_informasi_lain }}, 
               {{ $total_keseluruhan_nov_sumber_informasi_lain }},
               {{ $total_keseluruhan_des_sumber_informasi_lain }}]
    }]
});
  </script>

<?php } ?>
@endsection
