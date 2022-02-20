<!--Start of Social Link Area-->
<div class="social-link-area ptb-40 dark-blue-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-6 fix col-xs-12 col-sm-6">
                <div class="footer-logo pull-left">
                    <a href="{{url('/')}}" class="block"><img src="{{url("image/$company->comp_logo")}}" alt="" width="50%"></a>
                </div>
            </div>
            <div class="col-md-6 fix col-xs-12 col-sm-6">
                <div class="social-links pull-right">
                    <a href="#"><i class="zmdi zmdi-facebook"></i></a>
                    <a href="#"><i class="zmdi zmdi-rss"></i></a>
                    <a href="#"><i class="zmdi zmdi-google-plus"></i></a>
                    <a href="#"><i class="zmdi zmdi-pinterest"></i></a>
                    <a href="#"><i class="zmdi zmdi-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Social Link Area-->
<!--Start of Footer Widget-area-->
<div class="footer-widget-area black-bg pt-120 pb-110">
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-4">
                <div class="single-footer-widget">
                    <h3 class="text-white mb-22">About Us</h3>
                    <p class="text-white pr-10 text-justify">{{$company->comp_details}}</p>
                </div>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-md-3 col-sm-3">
                <div class="single-footer-widget">
                    <h3 class="text-white mb-26">GET IN TOUCH</h3>
                    <span class="text-white mb-9"><i class="fa fa-phone"></i>{{$company->comp_phone}} </span>
                    <span class="text-white mb-9"><i class="fa fa-envelope"></i>{{$company->comp_email}}</span>
                    <span class="text-white mb-9"><i class="fa fa-globe"></i>www.example.com</span>
                    <span class="text-white mb-9"><i class="fa fa-map-marker"></i>{{$company->comp_location}}</span>
                </div>
            </div>
            <div class="col-sm-1"></div>
            <div class="col-md-3 hidden-sm">
                <div class="single-footer-widget">
                    <h3 class="text-white mb-21">Trending Jobs</h3>
                    <ul class="footer-list">
                        <?php $i=1;?>
                        @foreach($recruitment as $r)
                            @if($i++ <= 4)
                            <li><a href="{{url("job/apply/{$r->r_id}")}}">{{$r->r_title}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Footer Widget-area-->
<!-- Start of Footer area -->
<footer class="footer-area blue-bg text-center ptb-20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footer-text">
                                    <span class="text-white block">
                                        Copyright&copy;
                                        <span>HR-PAYROLL</span>
                                        {{date('Y')}}.All right reserved.Created by
                                        <a href="#" class="text-white">Jannatul</a>
                                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- End of Footer area -->
