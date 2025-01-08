<!DOCTYPE html>
<html lang="en">

<head>
    @push('meta')
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    @endpush

    @stack('meta')
    @stack('title')

    {{-- <link href="{{ asset('/images/favicon.ico') }}" rel="shortcut icon" type="image/vnd.microsoft.icon"> --}}
    <link rel="stylesheet" href="{{ asset('css/default.min.css') }}">

    <!-- jQuery -->
    <script src="//code.jquery.com/jquery-2.2.4.min.js"></script>

    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-11548587-20']);
        _gaq.push(['_trackPageview']);
        (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        $(document).ready(function(){
            $('.mm_dd').hide();
            $('#mm_btn').click(function(){
                $('.mm_dd').slideToggle();
            });
        });

    </script>
</head>

<body>
    <div id="wrapper">
        <div id="header">
            <div id="nav">
                <a href="/" title="After School Programs"><h1>After School <br/> Programs</h1></a>
    
                <ul class="dt_menu">
                    <li><a href="/">After School Programs</a></li>
                    <li><a href="/martial-arts">Martial Arts</a></li>
                    <li><a href="/youth-sports">Youth Sports</a></li>
                    <li><a href="/search">Search</a></li>
                    <li><a href="/contact">Contact</a></li>
    
                    <?php if(!isset($user->type)): ?>
                        <li><a href="/user/login">User Login</a></li>
                        <li><a href="/user/new">User Registration</a></li>
                    <?php else: ?>
                        <li style="color: #FFE5C3;font-size: 16px;text-decoration: none;">Welcome, <?php echo $user->first_name . " " . $user->last_name; ?></li>
                        <li><a href="/user/logout">Logout</a></li>
                    <?php endif ?>
                </ul>
    
                <div class="mobile_menu">
                    <a href="#" id="mm_btn"></a>
                    <ul class="mm_dd">
                        <li><a href="/">After School Programs</a></li>
                        <li><a href="/martial-arts">Martial Arts</a></li>
                        <li><a href="/youth-sports">Youth Sports</a></li>
                        <li><a href="/search">Search</a></li>
                        <li><a href="/contact">Contact</a></li>
    
                        <?php if (!isset($user->type)): ?>
                            <li><a href="/user/login">User Login</a></li>
                            <li><a href="/user/new">User Registration</a></li>
                        <?php else: ?>
                            <li style="color: #FFE5C3;font-size: 16px;text-decoration: none;">Welcome, <?php echo $user->first_name . " " . $user->last_name;?></li>
                            <li><a href="/user/logout">Logout</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="clear"> </div>
        </div>
    
        <div id="content">
            @if (Request::path() != 'user/login' && Request::path() != 'user/new' && Request::path() != 'contact' && Request::path() != 'user/reset' && strpos(Request::path(), 'user/pwdreset?') === false)
                <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
                <!-- AfterschoolProgram All Pages Responsive Top -->
                <style type="text/css">
                    .adslot_1 { display:inline-block; height: 90px; }
                    @media (max-width:600px) { .adslot_1 { width: 320px; height: 100px; } }
                </style>
                <ins class="adsbygoogle adslot_1"
                     style="display:block"
                     data-ad-client="ca-pub-8651736830870146"
                     data-ad-slot="7856152776"></ins>
                <script>
                    (adsbygoogle = window.adsbygoogle || []).push({});
                </script>
            @endif
            <!-- content -->
            @yield('content')
            <div class="clear"></div>
        </div>
    
        <div id="footer">
            After School Programs .us &copy;<?php echo date("Y")?>
        </div>
    </div>
</body>

</html>
