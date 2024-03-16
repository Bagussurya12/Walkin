<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  		<title>OCBD HR-SYSTEM</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.jpg">

        <link rel="stylesheet" href="{{ asset('assets_frontend/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets_frontend/css/bootstrap-theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets_frontend/css/fontAwesome.css') }}">
        <link rel="stylesheet" href="{{ asset('assets_frontend/css/light-box.css') }}">
        <link rel="stylesheet" href="{{ asset('assets_frontend/css/templatemo-style.css') }}">

        <link href="https://fonts.googleapis.com/css?family=Kanit:100,200,300,400,500,600,700,800,900" rel="stylesheet">

        <script src="{{ asset('assets_frontend/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
        <style>
            .coba{
                align-items: center;
                margin-top: 200px;
                margin-top: 100px;
                padding: 10px;
                text-align: center;
                color: white;
                
            }
            .bt{
                margin-top: 35px;
            }
        </style>
    </head>

<body style="background-image: url('{{ asset('assets_backend/img/background/ocbd2.jpg') }}')">

    <div class="coba">
                
                <font size="6px"> Selamat Datang</font>   <br />
                <font size="4px">    One Central Bussiness District </font>
                
                

                <div class="bt">
                    
                    @if (Route::has('login'))
                        <a class="btn btn-primary btn-lg" href="{{ route('login') }}">LOGIN</a>
                    @endif
                </div>
                  
            
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    
    <script src="{{ asset('assets_frontend/js/vendor/bootstrap.min.js') }}"></script>
    
    <script src="{{ asset('assets_frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('assets_frontend/js/main.js') }}"></script>

    <script language="javascript">
        if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)){
            
        }else{
            window.location.replace("/");
        }
    </script>
</body>
</html>
