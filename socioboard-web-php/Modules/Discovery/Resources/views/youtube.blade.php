@extends('home::layouts.UserLayout')
@section('title')
    <title>{{env('WEBSITE_TITLE')}} | Discovery</title>
@endsection
@section('content')

    <!--begin::Content-->
    <div class="content  d-flex flex-column flex-column-fluid" id="Sb_content">

        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class=" container-fluid ">
                <!--begin::Profile-->
                <!--begin::Row-->
                <div class="row" data-sticky-container>
                    <div class="col-xl-4" >
                        <div class="card card-custom gutter-b sticky" data-sticky="true" data-margin-top="180px" data-sticky-for="1023" data-sticky-class="kt-sticky">
                            <div class="card-header border-0 py-5">
                                <h3 class="card-title font-weight-bolder">YouTube</h3>
                            </div>
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Form-->
                                <form action="/discovery/search-youtubes" method="post">
                                    @csrf
                                    <!--begin::search-->
                                    <div class="form-group">
                                        <select class="form-control form-control-solid form-control-lg h-auto py-4 rounded-lg font-size-h6" name="sortby" id="sortby">
                                            <option selected disabled>Sort by</option>
                                            <option value="relevance" {{ isset($sortBy) ? $sortBy === 'relevance'? 'selected' : '' : 'selected'}} selected>Relevance</option>
                                            <option value="title" {{ isset($sortBy) ? $sortBy === 'title'? 'selected' : '':''}}>Title</option>
                                            <option value="rating" {{isset($sortBy) ? $sortBy === 'rating'? 'selected' : '' :''}}>Rating</option>
                                            <option value="viewcount" {{ isset($sortBy) ? $sortBy === 'viewcount'? 'selected' : '' :''}}>Viewcount</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div class="input-icon">
                                            <input class="form-control form-control-solid h-auto py-4 rounded-lg font-size-h6" type="text" name="keyword" id="keyword" autocomplete="off" value="@if(isset($keyword)){{$keyword}} @endif" placeholder="Enter Keyword"/>
                                            <span><i class="far fa-keyboard"></i></span>
                                        </div>
                                        @if ($errors->any())
                                            <span id="validboardname" style="color: red;font-size: medium;" role="alert">{{ $errors->first('keyword') }}</span>
                                        @endif
                                    </div>


                                    <!--end::search-->
                                    <button type="reset" class="btn font-weight-bolder mr-2 px-8 ">Clear</button>
                                    <button type="submit" class="btn font-weight-bolder px-8" id="search_button">Search</button>
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Body-->
                        </div>

                    </div>
                    @if(isset($ErrorMessage))
                        <div class="card-body">
                            <div class="text-center">
                                <div class="symbol symbol-150">
                                    <img src="/media/svg/illustrations/no-feeds.svg" class="">
                                </div>
                                <h6>{{$ErrorMessage}}</h6>
                            </div>
                        </div>
                    @endif
                    <div class="col-xl-8" id="feeds" >
                        <!--begin::feeds-->
                        <div class="card-columns" id="youtubeFeeds">
                            @if(isset($responseData) && $responseData['data'] !== null)
                                <script>
                                    var feedsLength = <?php echo count($responseData['data']->youtubeDetails)  ?>;
                                    var  keywordName =  '{{$keyword}}' ;
                                </script>

                                @foreach( $responseData['data']->youtubeDetails as $account)
                                    <div class="card">
                                        <!--begin::Video-->
                                        <div class="embed-responsive embed-responsive-16by9">
                                            <iframe class="embed-responsive-item rounded"
                                                    src="{{$account->embed_url}}" allowfullscreen=""></iframe>
                                        </div>
                                        <!--end::Video-->
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-40 symbol-light-success mr-5">
                                                            <span class="symbol-label">
                                                                <img src="https://pbs.twimg.com/media/E1ggb47VEAYDQ0f.jpg"
                                                                     class="h-75 align-self-end" alt="">
                                                            </span>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Info-->
                                                <div class="d-flex flex-column flex-grow-1">
                                                    <a href="{{$account->mediaUrl}}"
                                                       class="text-hover-primary mb-1 font-size-lg font-weight-bolder"
                                                       target="_blank">{{$account->channelTitle}}</a>
                                                    <span class="text-muted font-weight-bold">{{$account->publishedDate}}</span>
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <h5 class="card-title mt-3 mb-2">{{$account->title}}</h5>
                                            <p class="card-text">
                                                {{$account->description}}<br><br>
                                            </p>
                                            <hr>
                                            <div class="d-flex justify-content-center">
                                                <a href="javascript:;" data-toggle="modal" data-target="#resocioModal" onclick="openModel('{{$account->mediaUrl}}','{{$account->channelTitle}}','{{trim(preg_replace('/\s*\([^)]*\)/', '', $account->title))}}')"
                                                   class="btn btn-hover-text-success btn-hover-icon-success rounded font-weight-bolder mr-5"><i
                                                        class="far fa-hand-point-up fa-fw"></i> 1 click</a>
                                                <a href="{{$account->mediaUrl}}"
                                                   class="btn btn-hover-text-danger btn-hover-icon-danger rounded font-weight-bolder"><i
                                                        class="fab fa-youtube fa-fw"></i> Show Original</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <!--end::feeds-->
                    </div>

                </div>
                <!--end::Row-->
                <!--end::Profile-->
            </div>
            <!--end::Container-->
        </div>
        <!--end::Entry-->
    </div>
    <!--end::Content-->

    </div>
    <!--end::Wrapper-->
    </div>
    <!--end::Page-->
    </div>
    <!--end::Main-->

    <!-- begin::Re-socio-->
    <div class="modal fade" id="resocioModal" tabindex="-1" role="dialog" aria-labelledby="resocioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resocioModalLabel">Re-Socio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form action="{{ route('publish_content.share') }}" id="publishContentForm" method="POST">
                <div class="modal-body">
                    <div class="form-group" id="normal_post_area">

                    </div>
                    <div class="form-group">
                        <div class="input-icon" id="outgoingUrl">

                        </div>
                    </div>

                    <!-- begin:Accounts list -->
                @if(isset($socialAccounts) && !empty($socialAccounts))
                    <!-- begin:Accounts list -->
                        <div>
                            <button type="button" class="btn font-weight-bolder font-size-h6 px-4 py-4 mr-3 my-3 accounts-list-btn">Select Accounts</button>
                        </div>
                        <div class="accounts-list-div">
                            <ul class="nav justify-content-center nav-pills" id="AddAccountsTab" role="tablist">
                                @foreach($socialAccounts as $key => $socialAccount)
                                    <li class="nav-item">
                                        <a class="nav-link" id="{{$key}}-tab-accounts" data-toggle="tab" href="#{{$key}}-add-accounts">
                                            <span class="nav-text"><i class="fab fa-{{$key}} fa-2x"></i></span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <span id="error-socialAccount" class="error-message form-text text-danger text-center"></span>
                            <div class="tab-content mt-5" id="AddAccountsTabContent">
                                @foreach($socialAccounts as $key => $socialAccountsGroups)
                                    <div class="tab-pane" id="{{$key}}-add-accounts" role="tabpanel" aria-labelledby="{{$key}}-tab-accounts">
                                        <div class="mt-3">
                                            @foreach($socialAccountsGroups as $group => $socialAccountArray)
                                                <div class="scroll scroll-pull" data-scroll="true" data-wheel-propagation="true" style="overflow-y: scroll;">
                                                <span>Choose {{ucwords($key)}} {{$group}} for posting</span>
                                                @foreach($socialAccountArray as $group_key => $socialAccount)


                                                        <!--begin::Page-->
                                                        <div class="d-flex align-items-center flex-grow-1">
                                                            <!--begin::Facebook Fanpage Profile picture-->
                                                            <div class="symbol symbol-45 symbol-light mr-5">
                                                                    <span class="symbol-label">
                                                                        <img src="{{isset($socialAccount->profile_pic_url) ?  $socialAccount->profile_pic_url : null}}" class="w-100 align-self-center" alt=""/>
                                                                    </span>
                                                            </div>
                                                            <!--end::Facebook Fanpage Profile picture-->
                                                            <!--begin::Section-->
                                                            <div class="d-flex flex-wrap align-items-center justify-content-between w-100">
                                                                <!--begin::Info-->
                                                                <div class="d-flex flex-column align-items-cente py-2 w-75">
                                                                    <!--begin::Title-->
                                                                    <a href="javascript:;" class="font-weight-bold text-hover-primary font-size-lg mb-1">
                                                                        {{ $socialAccount->first_name.' '. $socialAccount->last_name }}
                                                                    </a>
                                                                    <!--end::Title-->

                                                                    <!--begin::Data-->
                                                                    <span class="text-muted font-weight-bold">
                                                                            {{-- 2M followers --}}
                                                                        {{ $socialAccount->friendship_counts }} followers
                                                                        </span>
                                                                    <!--end::Data-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Section-->
                                                            <!--begin::Checkbox-->
                                                            <label class="checkbox checkbox-lg checkbox-lg flex-shrink-0 mr-4">
                                                                <input type="checkbox" name="socialAccount[]" value="{{ $socialAccount->account_id }}"/>
                                                                {{-- <input type="hidden" name="account_id[{{ $socialAccount->account_id }}]" value="{{ $socialAccount->account_id }}"> --}}
                                                                <span></span>
                                                            </label>
                                                            <!--end::Checkbox-->
                                                        </div>
                                                        <!--end::Page-->

                                                @endforeach
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <!-- end:Accounts list -->
                @endif
                    <!-- end:Accounts list -->
                </div>

                <div class="modal-footer">
                    <button type="button" name="status" value="0" class="publishContentSubmit btn font-weight-bolder font-size-h6 px-4 py-4 mr-3 my-3 ">Draft</button>
                    <button type="button" name="status" value="1" class="publishContentSubmit btn font-weight-bolder font-size-h6 px-4 py-4 mr-3 my-3 ">Post</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end::Re-socio-->
@endsection

@section('scripts')
    <script src="{{asset('js/contentStudio/publishContent.js')}}"></script>
@endsection

@section('page-scripts')

    <script>

        // begin::sticky
        var sticky = new Sticky('.sticky');
        // end::sticky
        // accounts list div open
            $(document).ready(function(){
                $("#boards").trigger('click');
            });

        $(".accounts-list-div").css({
            display: "none"
        });
        $(".accounts-list-btn").click(function() {
            $(".accounts-list-div").css({
                display: "block"
            });
        });

        // youtube predefined date ranges
        var start = moment().subtract(29, 'days');
        var end = moment();

        $('#yt-daterange').daterangepicker({
            buttonClasses: ' btn',
            applyClass: 'btn-primary',
            cancelClass: 'btn-secondary',

            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, function(start, end, label) {
            $('#yt-daterange .form-control').val( start.format('MM/DD/YYYY') + ' / ' + end.format('MM/DD/YYYY'));
        });

        // Views count
        $('#view-counts').ionRangeSlider({
            type: "double",
            min: 0,
            max: 10000,
            from: 1500,
            to: 5000
        });

        function getScrollXY() {
            var scrOfX = 0, scrOfY = 0;
            if (typeof (window.pageYOffset) == 'number') {
                //Netscape compliant
                scrOfY = window.pageYOffset;
                scrOfX = window.pageXOffset;
            } else if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
                //DOM compliant
                scrOfY = document.body.scrollTop;
                scrOfX = document.body.scrollLeft;
            } else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
                //IE6 standards compliant mode
                scrOfY = document.documentElement.scrollTop;
                scrOfX = document.documentElement.scrollLeft;
            }
            return [scrOfX, scrOfY];
        }

        function getDocHeight() {
            var D = document;
            return Math.max(
                D.body.scrollHeight, D.documentElement.scrollHeight,
                D.body.offsetHeight, D.documentElement.offsetHeight,
                D.body.clientHeight, D.documentElement.clientHeight
            );
        }

        document.addEventListener("scroll", function (event) {
            if (feedsLength >= 15) {
                if (getDocHeight() == getScrollXY()[1] + window.innerHeight) {
                    getNextYotubefeeds(pageid,keywordName);
                    pageid++;
                }
            }
        });

        function getNextYotubefeeds(pageid,keywordName) {
            $.ajax({
                type: 'post',
                url: '/discovery/search-more-youtubes',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data :{
                    pageid:pageid,
                    keyword:keywordName
                },
                beforeSend: function () {
                    $('#feeds').append('<div class="d-flex justify-content-center" >\n' +
                        '        <div class="spinner-border" role="status"  id="' + pageid + '" style="display: none;">\n' +
                        '            <span class="sr-only">Loading...</span>\n' +
                        '        </div>\n' +
                        '\n' +
                        '        </div>');
                    $(".spinner-border").css("display", "block");
                },
                success: function (response) {
                    if(response.code === 200 ){
                        let appendData = '';
                        $(".spinner-border").css("display", "none");
                        feedsLength = response.data.youtubeDetails.length;
                        let url;
                        let chaneltitle;
                        let title;
                        response.data.youtubeDetails.map(element => {
                             url = "'" + element.mediaUrl + "'";
                             chaneltitle = "'" + element.channelTitle + "'";
                             title = "'" + element.title + "'";
                            appendData = '<div class="card">'+
                                '<div class="embed-responsive embed-responsive-16by9">'+
                                '<iframe class="embed-responsive-item rounded" src="'+element.embed_url+'" allowfullscreen=""></iframe>'+
                                '</div>'+
                                '<div class="card-body">'+
                                '<div class="d-flex align-items-center">'+
                                '<div class="symbol symbol-40 symbol-light-success mr-5">'+
                                '<span class="symbol-label">'+
                                '<img src="/media/svg/avatars/011-boy-5.svg"class="h-75 align-self-end" alt=""> </span> </div>'+
                                '<div class="d-flex flex-column flex-grow-1">'+
                                '<a href="'+element.embed_url+'" class="text-hover-primary mb-1 font-size-lg font-weight-bolder" target="_blank">re</a>'+
                                '<span class="text-muted font-weight-bold">'+element.publishedDate+'</span>'+
                                '</div>'+
                                '</div>'+
                                '<h5 class="card-title mt-3 mb-2">'+element.title+'</h5>'+
                                '<p class="card-text">'+element.description+'<br><br></p><hr>'+
                                '<div class="d-flex justify-content-center">'+
                                '<a href="javascript:;" data-toggle="modal" data-target="#resocioModal"class="btn btn-hover-text-success btn-hover-icon-success rounded font-weight-bolder mr-5" onclick="openModel('+url+','+chaneltitle+','+title.replace(/[{()}]/g, '')+')">'+
                                '<iclass="far fa-hand-point-up fa-fw"></i> 1 click</a>'+
                                '<a href="'+element.embed_url+'" class="btn btn-hover-text-danger btn-hover-icon-danger rounded font-weight-bolder">'+
                                '<i class="fab fa-youtube fa-fw"></i> Show Original</a>'+
                                '</div>'+
                                '</div>'+
                                '</div>';
                            $('#youtubeFeeds').append(appendData);
                        })
                    }
                }
            });
        }

        $(document).ready(function(){
            $("#discovery").trigger('click');
        });
            $(document).on('click','#search_button',function (e) {
                $('#search_button').empty().append('<i class="fa fa-spinner fa-spin"></i>Searching');
            })
        //

        function openModel(id, cheaneltitle, title ) {
                    $('#normal_post_area').empty().append(' <textarea class="form-control border border-light h-auto py-4 rounded-lg font-size-h6" id="normal_post_area" name="content" rows="3" placeholder="Write something !" required >'+title +'</textarea>');
                    $('#outgoingUrl').empty().append(' <input class="form-control form-control-solid h-auto py-4 rounded-lg font-size-h6" type="text" name="outgoingUrl" autocomplete="off" placeholder="Enter Outgoing url" value="'+id+'"/><span><i class="fas fa-link"></i></span>');
        }
    </script>
@endsection


