<footer class="footer">
      <div class="container">
        <div class="row footer-top">

          <div class="col-sm-5 col-lg-5">

              <p class="padding-top-xsm">这里是php laravel 交流社区,php是世界上最好的编程语言之一，laravel是世界上最好的php框架(没有之一)，欢迎大家交流学习</p>
              <br>
              <span style="font-size:0.9em">
                  Powered by <a href="https://github.com/summerblue/phphub5" target="_blank" style="color:inherit">PHPHub</a>
              </span>
          </div>

          <div class="col-sm-6 col-lg-6 col-lg-offset-1">

              <div class="row">
                <div class="col-sm-4">
                  <h4>赞助商</h4>
                  <ul class="list-unstyled">
                      @if(isset($banners['footer-sponsor']))
                          @foreach($banners['footer-sponsor'] as $banner)
                              <a href="{{ $banner->link }}" target="_blank"><img src="{{ $banner->image_url }}" class="popover-with-html footer-sponsor-link" width="98" data-placement="top" data-content="{{ $banner->title }}"></a>
                          @endforeach
                      @endif
                  </ul>
                </div>

                {{--  <div class="col-sm-4">
                    <h4>{{ lang('Site Status') }}</h4>
                    <ul class="list-unstyled">
                        <li>{{ lang('Total User') }}: {{ $siteStat->user_count }} </li>
                        <li>{{ lang('Total Topic') }}: {{ $siteStat->topic_count }} </li>
                        <li>{{ lang('Total Reply') }}: {{ $siteStat->reply_count }} </li>
                    </ul>
                  </div>--}}
                  <div class="col-sm-4">
                    <h4>其他信息</h4>
                    <ul class="list-unstyled">
                       {{-- <li><a href="/about">关于我们</a></li>
                        <li><a href="{{ route('hall_of_fames') }}"><i class="fa fa-star" aria-hidden="true"></i> {{ lang('Hall of Fame') }}</a></li>
                       --}} <li class="popover-with-html" data-content="新手 QQ 群">Q 群：583048387</li>
                    </ul>
                  </div>

                </div>

          </div>
        </div>
        <br>
        <br>
      </div>
    </footer>
