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
                  
                  <div class="card-body">
                    
                    <figure class="highcharts-figure">
                      <div id="container"></div>
                      
                    </figure>
                    

                  
                  </div>
                  
                </div>
              </div>
        </div>
       
      </div>
    </section>


    <footer class="main-footer" style=" color:white;  background-color: #6495ED">
      <strong>Grafik Tamu WI</strong>
      <div class="float-right" >
        <a href=""><img src="{{ asset('assets_backend/img/icon/profile-user.svg') }}" width="30px"  /></a>
      </div>
    </footer>
  </div>


  
@endsection

@section('footer')
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
            html: 'Total Tamu',
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
        data: [3, 2, 1, 3, 4,3, 2, 1, 3, 4,3, 4]
    }, {
        type: 'column',
        name: 'Total Tamu Proses',
        data: [2, 3, 5, 7, 6,2, 3, 5, 7, 6,7, 6]
    }, {
        type: 'column',
        name: 'Total Tamu Closing',
        data: [4, 3, 3, 9, 0,4, 3, 3, 9, 0,9, 0]
    }, {
        type: 'column',
        name: 'Total Tamu Batal',
        data: [4, 3, 3, 9, 6,4, 3, 3, 9, 5,9, 3]
    }, {
      //garis grafik tamu closing
        type: 'spline',
        name: 'Average Closing',
        data: [4, 3, 3, 9, 0,4, 3, 3, 9, 0,9, 0],
        marker: {
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[3],
            fillColor: 'white'
        }
    }]
});
  </script>
@endsection
