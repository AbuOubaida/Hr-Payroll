<!DOCTYPE html>
<html lang="en">
<x-header_link />{{--For Style--}}
<body>
    <div class="container-scroller">
    <x-project_manager_sidebar/>{{--(x-) = components folder--}}
        <div class="container-fluid page-body-wrapper">
            <x-project_manager_header_nav />
            <div class="main-panel">
                <div class="content-wrapper">
                    {{--                For Error message Showing--}}
                    @if ($errors->any())
                        <div class="col-12">
                            <div class="alert alert-danger alert-dismissible fade show z-index-1 position-absolute w-auto error-alert" role="alert">
                                @foreach ($errors->all() as $error)
                                    <div>{{$error}}</div>
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    {{--                For Insert message Showing--}}
                    @if (session('success'))
                        <div class="col-12">
                            <div class="alert alert-success alert-dismissible fade show z-index-1 position-absolute w-auto error-alert" role="alert">
                                <div>{{session('success')}}</div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    {{--                For Insert message Showing--}}
                    @if (session('error'))
                        <div class="col-12">
                            <div class="alert alert-danger alert-dismissible fade show z-index-1 position-absolute w-auto error-alert" role="alert">
                                <div>{{session('error')}}</div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="col-12">
                            <div class="alert alert-warning alert-dismissible fade show z-index-1 position-absolute w-auto error-alert" role="alert">
                                <div>{{session('warning')}}</div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>
<x-footer_link/>{{--For javascript--}}
</body>
</html>
