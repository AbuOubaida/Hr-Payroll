@extends('layouts/home/main')
@section('home')
<body>
<!--Main Wrapper Start-->
<div class="as-mainwrapper">
    <!--Bg White Start-->
    <div class="bg-dark">
        @include('layouts.home.navbar')
    <!--Start of Slider Area-->
    <div class="slider-area">
        <div class="preview-2">
            <div id="nivoslider" class="slides">
                <img src="{{url("assets/home/images/slider/1.jpg")}}" alt="" title="#slider-1-caption1"/>
                <img src="{{url("assets/home/images/slider/2.jpg")}}" alt="" title="#slider-1-caption2"/>
            </div>
            <div id="slider-1-caption1" class="nivo-html-caption nivo-caption">
                <div class="banner-content slider-1">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-content-wrapper">
                                    <div class="text-content">
                                        <h1 class="title1 wow bounceInDown text-uppercase text-white mb-16" data-wow-duration="3s" data-wow-delay="0s">LOOKING FOR A JOB?</h1>
                                        <p class="sub-title wow bounceInRight hidden-xs" data-wow-duration="3s" data-wow-delay="1s"> There are many variations of passages of Lorem Ipsum available, but the majority<br> have suffered alteration in some form, by injected humour, or randomised words<br> which don't look even slightly believable.</p>
                                        <div class="banner-readmore wow bounceInUp mt-35" data-wow-duration="3s" data-wow-delay="2s">
                                            <a class="button slider-btn" href="#">Find a job</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="slider-1-caption2" class="nivo-html-caption nivo-caption">
                <div class="banner-content slider-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-content-wrapper">
                                    <div class="text-content slide-2">
                                        <h1 class="title1 wow flipInX text-uppercase text-white mb-16" data-wow-duration="1s" data-wow-delay="0s">LOOKING FOR A JOB?</h1>
                                        <p class="sub-title wow lightSpeedIn hidden-xs" data-wow-duration="1s" data-wow-delay=".2s"> There are many variations of passages of Lorem Ipsum available, but the majority<br> have suffered alteration in some form, by injected humour, or randomised words<br> which don't look even slightly believable.</p>
                                        <div class="banner-readmore wow bounceInUp mt-35" data-wow-duration="1s" data-wow-delay=".6s">
                                            <a class="button slider-btn" href="#">Find a job</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Slider Area-->
    <!--Start of Job Post Area-->
    <div class="job-post-area ptb-120">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center ">
                        <h2 class="uppercase">Recent Jobs</h2>
                        <div class="separator mt-35 mb-77">
                            <span><img src="{{url("assets/home/images/company-logo/1.png")}}" alt=""></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="job-post-container fix mb-70">
                    @if(@$recruitment && count(@$recruitment))
                        <?php $i=1;?>
                        @foreach($recruitment as $r)
                        <div class="single-job-post fix">
                            <div class="job-title col-3 pl-30">
                                            <span class="pull-left block mtb-17">
                                                <img src="{{url("assets/home/images/company-logo/".$i++.".png")}}" alt="">
                                            </span>
                                <div class="fix pl-30 mt-29">
                                    <h4 class="mb-5 text-capitalize">{{$r->r_title}}</h4>
                                    <h5><a href="#">{{$r->dep_name}}</a></h5>
                                </div>
                            </div>
                            <div class="address col-3 pl-50">
                                            <span class="mtb-30 block"><h3 class="d-inline-block"><i class="fa fa-map-marker"></i></h3> {{$r->location}}</span>
                            </div>
                            <div class="address col-2 pl-50">
                                            <span class="mtb-30 block"> Vacancy {{$r->r_vacancies}}</span>
                            </div>

                            <div class="time-payment col-2 pl-60 text-center pt-22">
                                <span class="block mb-6">BDT-{{$r->salary_range}}/=</span>
                                <a href="{{url("job/apply/{$r->r_id}")}}" class="button btn-success">Apply now</a>
                            </div>
                        </div>
                            <?php $i>4?$i=1:'';?>
                        @endforeach
                    @endif
                    </div>
                </div>
                <div class="col-sm-12">
                    @if($recruitment->links())
                        {{$recruitment->links()}}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End of Job Post Area -->
    @include('layouts.home.footer')
@stop
