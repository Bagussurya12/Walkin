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

        <script src="{{ asset('assets_frontend/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>
    </head>

<body style="background-color: #d8f3dc;">
    <div style="text-align: center; align-items: center; margin-top:10%; ">
        <img src="{{ asset('assets_backend/img/logo/iconlogo.png') }}" width="200px"  />
    </div>
    <div style="align-items: center; text-align: center; text-shadow: 1px 1px;">
        <font color="black" size="9px">WELCOME TO</font> <br /><font color="purple">Online Guestbook App</font>
        <br /><br />
        <a href="/login" style=" background: rgb(138, 137, 135); color:white; padding: 3px 25px 3px 25px;">LOGIN</a>
        <a href="/tamuwi" style=" background: rgb(9, 30, 223); color:white; padding: 3px 25px 3px 25px;">INPUT TAMU WI</a>
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
