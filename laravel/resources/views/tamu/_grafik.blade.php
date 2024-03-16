@extends('layouts.master')
@section('judul','Grafik tamu WI')

@section('content')
<!-- Navbar -->
<div style="background-color: #6495ED; padding-top:15px; padding-bottom:15px;">
  <table width="100%" border="0">
    <tr>
      <td width="10%">
        <center>
          <a  href="/home">
            <img src="{{ asset('assets_backend/img/icon/previous.svg') }}" width="30px"  />
            
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
                      <div class="col-lg-4 col-md-6 col-xs-12 col-sm-12 mt-3">
                        <select class="form-control select2bs4" name="id_sales" style="width: 100%;">
                          <option value="">Pilih Sales</option>
                          @foreach($data_sales as $nmk)
                            <option value="{{ $nmk->id }}" <?php if(isset($_GET['id_sales'])){ ?> 
                              @if($nmk->id == $_GET['id_sales']) selected="selected"@endif
                              <?php } ?>>{{ $nmk->name }}</option>
                          @endforeach
                                  
                        </select>
                      </div>

                      <div class="col-lg-4 col-md-6 col-xs-12 col-sm-12 mt-3">
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


                  <div class="card-body">
                    <?php if(isset($_GET['tahun'])){ ?>
                    <figure class="highcharts-figure">
                      <div id="container"></div>
                    </figure>
                    <?php } ?>

                  
                  </div>
                  
                </div>
              </div>
        </div>
       
      </div>
    </section>


    <footer class="main-footer" style=" color:white;  background-color: #6495ED">
      <strong>Grafik Tamu WI</strong>
      <div class="float-right" >
        <a href="{{ route('user.profilkaryawan') }}"><img src="{{ asset('assets_backend/img/icon/profile-user.svg') }}" width="30px"  /></a>
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
        text: 'Grafik Tamu WI'
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
  </script>

<?php } ?>
@endsection
