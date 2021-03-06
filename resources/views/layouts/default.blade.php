<!--
______                            _              _                                     _
| ___ \                          | |            | |                                   | |
| |_/ /___ __      __ ___  _ __  | |__   _   _  | |      __ _  _ __  __ _ __   __ ___ | |
|  __// _ \\ \ /\ / // _ \| '__| | '_ \ | | | | | |     / _` || '__|/ _` |\ \ / // _ \| |
| |  | (_) |\ V  V /|  __/| |    | |_) || |_| | | |____| (_| || |  | (_| | \ V /|  __/| |
\_|   \___/  \_/\_/  \___||_|    |_.__/  \__, | \_____/ \__,_||_|   \__,_|  \_/  \___||_|
                                          __/ |
                                         |___/
  ========================================================
                                           laravel-china.org

  --------------------------------------------------------
  Laravel: v5.1 LTS
-->

<!DOCTYPE html>
<html lang="zh">
<head>

    <meta charset="UTF-8">

    <title>@section('title')PHP Laravel社区专注php框架laravel技术交流www.php-laravel.com @show</title>

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>

    <meta name="keywords"
          content="php,PL社区,laravel,php论坛,laravel论坛,php社区,laravel社区,laravel教程,php教程,laravel视频,php开源,php新手,php7,laravel5"/>
    <meta name="author" content="PHPHub"/>
    <meta name="description"
          content="@section('description') php Laravel 是php和laravel框架交流社区，致力于推动 Laravel，PHP7、php-fig 等 PHP laravel新技术，laravel是php是最流行的框架 @show"/>
    <meta name="_token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ cdn(elixir('assets/css/styles.css')) }}">

    <link rel="shortcut icon" href="{{ cdn('favicon1.png') }}"/>
    <script src="{{url('/build/assets/js/jquery.js')}}"></script>
    <script>
        Config = {
            'cdnDomain': '{{ get_cdn_domain() }}',
            'user_id': {{ $currentUser ? $currentUser->id : 0 }},
            'user_avatar': {!! $currentUser ? '"'.$currentUser->present()->gravatar() . '"' : '""' !!},
            'user_link': {!! $currentUser ? '"'. route('users.show', $currentUser->id) . '"' : '""' !!},
            'routes': {
                'notificationsCount': '{{ route('notifications.count') }}',
                'upload_image': '{{ route('upload_image') }}'
            },
            'token': '{{ csrf_token() }}',
            'environment': '{{ app()->environment() }}',
            'following_users': []
        };

        var ShowCrxHint = '{{isset($show_crx_hint) ? $show_crx_hint : 'no'}}';
    </script>

    @yield('styles')

</head>
<body id="body">

<div id="wrap">

    @include('layouts.partials.nav')

    <div class="container main-container">

        @if(\Auth::check() && !\Auth::user()->verified && !Request::is('email-verification-required'))
            <div class="alert alert-warning">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                邮箱未激活，请前往 {{ \Auth::user()->email }} 查收激活邮件，激活后才能完整地使用社区功能，如发帖和回帖。未收到邮件？请前往 <a
                        href="{{ route('email-verification-required') }}">重发邮件</a> 。
            </div>
        @endif

        @include('flash::message')

        @yield('content')

    </div>

    @include('layouts.partials.footer1')

</div>
<script src="{{ cdn(elixir('assets/js/scripts.js')) }}"></script>
<script src="{{ cdn(elixir('assets/js/posfixed.js')) }}"></script>


@yield('scripts')

@if (App::environment() == 'production')
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', '{{ getenv('GA_Tracking_ID') }}', 'auto');
        ga('send', 'pageview');
    </script>
    <script>

        // Baidu link submit
        (function () {
            var bp = document.createElement('script');
            var curProtocol = window.location.protocol.split(':')[0];
            if (curProtocol === 'https') {
                bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
            }
            else {
                bp.src = 'http://push.zhanzhang.baidu.com/push.js';
            }
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(bp, s);
        })();
    </script>
@endif

<script>
    $(document).ready(function () {
        $("#top-navbar-collapse").posfixed({
            distance: 0,
            pos: "top",
            type: "while",
            hide: false,
            left:150
        });
    });
</script>

</body>
</html>
