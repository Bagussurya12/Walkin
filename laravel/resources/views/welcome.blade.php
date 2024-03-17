<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Buku Tamu Online OCBD</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('assets_backend/img/logo/iconlogo.png') }}">
    <link rel="stylesheet" href="{{ asset('assets_frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_frontend/css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_frontend/css/fontAwesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_frontend/css/light-box.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_frontend/css/templatemo-style.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Kanit:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <style>
        body {
            background: #283c86; /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #45a247, #283c86); /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #45a247, #283c86); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            color: white; /* Menyesuaikan warna teks dengan gradien */
        }

        .login-btn a:hover {
            text-decoration: none;
            font-weight: bold;
        }
        .typing-animation {
            overflow: hidden; /* Agar teks tidak keluar dari kotak */
 /* Efek kursor ketik */
            white-space: nowrap; /* Agar teks tidak melompat ke baris berikutnya */
            margin: 0 auto; /* Menengahkan teks */
            letter-spacing: .15em; /* Jarak antar huruf */
            animation: typing 12s steps(40, end), blink-caret .75s step-end infinite; /* Animasi ketik */
        }

        /* Animasi ketik */
        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }
        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: orange }
        }
    </style>
    <script src="{{ asset('assets_frontend/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
</head>

<body>
    <div style="text-align: center; align-items: center; margin-top:10%; ">
        <img src="{{ asset('assets_backend/img/logo/icon.png') }}" width="200px"  style="background-color: none"/>
    </div>
    <div style="align-items: center; text-align: center; margin-top:20px" class="font-monospace">
        <h3 color="white" size="12px" class="font-monospace">WELCOME TO</h3> <br />
        <h4 color="black" class="font-monospace">Online Guestbook App</h4>
        <br /><br />
    </div>  
    <div class="row text-center">
        <div class="col-4">
            <button type="button" class="btn btn-success btn-lg">
                <a href="/login" style="color: white; text-decoration:none">LOGIN</a>
            </button>
        </div>
        <div class="col-6" style="margin-top: 10px ">
            <button type="button" class="btn btn-primary btn-lg mt-3">
                <a href="/tamuwi" style="color:white; text-decoration:none">INPUT TAMU WI</a>
            </button>
        </div>
    </div>
    <div class="text-center mt-5" style="margin-top: 50px">
        <h5 class="typing-animation"> 

            PT.Olympic Bangun Persada</h5>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="{{ asset('assets_frontend/js/vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets_frontend/js/plugins.js') }}"></script>
    <script src="{{ asset('assets_frontend/js/main.js') }}"></script>
    <script async src='https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js'></script>
    <script>
        var wa_btnSetting = {"btnColor":"#16BE45","ctaText":"Perlu Bantuan","cornerRadius":40,"marginBottom":60,"marginLeft":20,"marginRight":20,"btnPosition":"right","whatsAppNumber":"+6281288650512","welcomeMessage":"Hai Novan, ","zIndex":999999,"btnColorScheme":"light"};
        var wa_widgetSetting = {"title":"OCBD","subTitle":"One Central Bussiness District","headerBackgroundColor":"#231a65","headerColorScheme":"light","greetingText":"Semangat Pagi, \nPerlu Bantuan, Silahkan Chat Saja","ctaText":"Mulai Chat WA","btnColor":"#0ba82a","cornerRadius":40,"welcomeMessage":"Hello","btnColorScheme":"light","brandImage":"https://hr.ocbd.co.id/assets_backend/img/logo/ocbdnew.png","darkHeaderColorScheme":{"title":"#333333","subTitle":"#4F4F4F"}};  
        window.onload = () => {
            _waEmbed(wa_btnSetting, wa_widgetSetting);
        };
    </script>
</body>
</html>
