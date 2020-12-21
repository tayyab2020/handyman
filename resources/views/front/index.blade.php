@extends('layouts.front')
@section('styles')
    <style type="text/css">
        /* Hide the list on focus of the input field */
        datalist {
            display: none;
        }
        /* specifically hide the arrow on focus */
        input::-webkit-calendar-picker-indicator {
            display: none;
        }

    </style>
@endsection
@section('content')


    <div class="hero-area overlay" style="background-image: url({{asset('assets/images/'.$gs->bgimg)}});z-index: auto;color: black;">

        @if(Session::has('unsuccess'))

            <div class="alert alert-danger validation" style="position: absolute;top: 0px;width: 100%;background-color: #e53333;color: white;border: none;">

                <button type="button" class="close cl-btn" data-dismiss="alert" aria-label="Close" style="text-shadow: none;opacity: 1;"><span aria-hidden="true" style="font-size: 30px;">×</span></button>

                <ul class="text-left" style="text-align: center;font-size: 21px;list-style: none;padding-left: 0;font-weight: 600;font-family: monospace;">

                    <li>{{ Session::get('unsuccess') }}</li>

                </ul>
            </div>

        @endif

            @if(Session::has('success'))

                <div class="alert alert-success validation" style="position: absolute;top: 0px;width: 100%;border: none;">

                    <button type="button" class="close cl-btn" data-dismiss="alert" aria-label="Close" style="text-shadow: none;opacity: 1;"><span aria-hidden="true" style="font-size: 30px;">×</span></button>

                    <ul class="text-left" style="text-align: center;font-size: 21px;list-style: none;padding-left: 0;font-weight: 600;font-family: monospace;">

                        <li>{{ Session::get('success') }}</li>

                    </ul>
                </div>

            @endif

            @include('includes.form-error')


        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 col-sm-6 col-sm-push-6 col-xs-12 col-xs-push-0">
                    <div class="hero-form">
                        <div class="hero-form-header">
                            <h3>{{$lang->ss}}</h3>
                            <hr>
                        </div>

                        <form action="{{route('user.search')}}" method="GET">

                            <div class="hero-form-wrapper">

                                <div class="form-group" id="zipbox">
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-fw fa-home"></i>
                                        </div>

                                        <input  type="search" name="zipcode" id="zipcode" class="form-control" placeholder="{{$lang->spzc}}" autocomplete="off" required >

                                    </div>
                                </div>

                                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNlftIg-4OOM7dicTvWaJm46DgD-Wz61Q&libraries=places&callback=initMap" async defer></script>

                                <script type="text/javascript">

                                    function initMap() {

                                        var input = document.getElementById('zipcode');

                                        var options = {
                                            componentRestrictions: {country: "nl"}
                                        };

                                        var autocomplete = new google.maps.places.Autocomplete(input,options);


                                        // Set the data fields to return when the user selects a place.
                                        autocomplete.setFields(
                                            ['address_components', 'geometry', 'icon', 'name']);


                                        autocomplete.addListener('place_changed', function() {

                                            var place = autocomplete.getPlace();


                                            if (!place.geometry) {

                                                // User entered the name of a Place that was not suggested and
                                                // pressed the Enter key, or the Place Details request failed.
                                                window.alert("No details available for input: '" + place.name + "'");
                                                return;
                                            }

                                            var city = '';

                                            for(var i=0; i < place.address_components.length; i++)
                                            {

                                                if(place.address_components[i].types[0] == 'locality')
                                                {
                                                    city = place.address_components[i].long_name;
                                                }

                                            }


                                            if(city == '')
                                            {
                                                for(var i=0; i < place.address_components.length; i++)
                                                {
                                                    if(place.address_components[i].types[0] == 'administrative_area_level_2')
                                                    {
                                                        var city = place.address_components[i].long_name;
                                                    }
                                                }
                                            }

                                        });

                                        var input1 = document.getElementById('quote-zipcode');

                                        var options1 = {
                                            componentRestrictions: {country: "nl"}
                                        };

                                        var autocomplete1 = new google.maps.places.Autocomplete(input1,options1);

                                        // Set the data fields to return when the user selects a place.
                                        autocomplete1.setFields(
                                            ['address_components', 'geometry', 'icon', 'name']);


                                        autocomplete1.addListener('place_changed', function() {


                                            var place1 = autocomplete1.getPlace();


                                            if (!place1.geometry) {

                                                // User entered the name of a Place that was not suggested and
                                                // pressed the Enter key, or the Place Details request failed.
                                                window.alert("No details available for input: '" + place1.name + "'");
                                                return;
                                            }

                                            var city1 = '';

                                            for(var i=0; i < place1.address_components.length; i++)
                                            {

                                                if(place1.address_components[i].types[0] == 'locality')
                                                {
                                                    city1 = place1.address_components[i].long_name;
                                                }

                                            }


                                            if(city1 == '')
                                            {
                                                for(var i=0; i < place1.address_components.length; i++)
                                                {
                                                    if(place1.address_components[i].types[0] == 'administrative_area_level_2')
                                                    {
                                                        var city1 = place1.address_components[i].long_name;

                                                    }
                                                }
                                            }

                                        });
                                    }

                                </script>


                                <div class="form-group" >
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-fw fa-calendar"></i>
                                        </div>

                                        <input type="text" name="from_date" id="from_date" class="form-control" placeholder="{{$lang->spdf}}" autocomplete="off" required >

                                    </div>
                                </div>


                                <div class="form-group" >
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-fw fa-calendar"></i>
                                        </div>

                                        <input  type="text" name="to_date" id="to_date" class="form-control" placeholder="{{$lang->spdt}}" autocomplete="off" required>

                                    </div>
                                </div>


                                <div class="form-group" style="height: 50px;">
                                    <div class="input-group" id="service_box">
                                        <div class="input-group-addon">
                                            <i class="fa fa-fw fa-cog"></i>
                                        </div>

                                        <select class="js-data-example-ajax form-control"  style="width: 100%" name="group" id="blood_grp" required>

                                            <option value="">{{$lang->sbg}}</option>

                                            @if($lang->lang == 'eng')

                                                @foreach($cats as $cat)
                                                    <option value="{{$cat->id}}">{{$cat->cat_slug}}</option>
                                                @endforeach

                                                @else

                                                @foreach($cats as $cat)
                                                    <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                                                @endforeach

                                                @endif

                                        </select>

                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <input type="submit" class="btn btn-block hero-btn" name="button" value="{{$lang->search}}">
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6 col-lg-pull-6 col-md-6 col-md-pull-6 col-sm-6 col-sm-pull-6 col-xs-12 col-xs-pull-0">

                    {{--<h1 style="color: black;">{{$gs->bg_title}}</h1>
                    <p>{!!$gs->bg_text!!}</p>--}}

                    <div style="background-color: #febb22;border-radius: 10px;box-shadow: 0px 0px 4px 0px #dbdbdb;">

                        <h3 style="text-align: center;padding-top: 25px;color: white;text-shadow: 1px 2px 5px #4f4f4f;font-weight: 400;">Select Service For Quotation</h3>

                        <div id="quote-box" style="display: inline-block;width: 100%;padding: 20px;">

                            <select class="js-data-example-ajax1 form-control quote-service" name="group" id="blood_grp" required>

                                <option value="">{{$lang->sbg}}</option>

                                @if($lang->lang == 'eng')

                                    @foreach($cats as $cat)
                                        <option value="{{$cat->id}}">{{$cat->cat_slug}}</option>
                                    @endforeach

                                @else

                                    @foreach($cats as $cat)
                                        <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                                    @endforeach

                                @endif

                            </select>

                            <button href="#myModal" role="button" data-toggle="modal" style="height: 45px;width: 25%;float: right;border: 0;outline: none;font-size: 18px;" class="btn btn-primary">Get Started</button>

                        </div>
                    </div>

                    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <form id="quote_form" method="post" action="{{route('user.quote')}}">

                                <input type="hidden" name="_token" value="{{@csrf_token()}}">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button style="background-color: white !important;color: black !important;" type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    <h3 id="myModalLabel">Ask for Quotation</h3>
                                </div>
                                <div class="modal-body" id="myWizard">

                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="5" style="width: 20%;line-height: 25px;font-size: 14px;font-weight: 100;">
                                            Step 1
                                        </div>
                                    </div>

                                    <div class="navbar" style="display: none;">
                                        <div class="navbar-inner">
                                            <ul class="nav nav-pills">
                                                <li class="active"><a href="#step1" data-toggle="tab" data-step="1">Step 1</a></li>
                                                <li><a href="#step2" data-toggle="tab" data-step="2">Step 2</a></li>
                                                <li><a href="#step3" data-toggle="tab" data-step="3">Step 3</a></li>
                                                <li><a href="#step4" data-toggle="tab" data-step="4">Step 4</a></li>
                                                <li><a href="#step5" data-toggle="tab" data-step="5">Step 5</a></li>
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="tab-content">

                                        <div class="tab-pane fade in active" id="step1">

                                            <div class="well">

                                                <h3 style="text-align: center;color: #4b4b4b;">Select Service</h3>

                                                <select class="js-data-example-ajax2 form-control quote-service quote_validation" style="height: 40px;" name="quote_service" id="blood_grp" required>

                                                    <option value="">{{$lang->sbg}}</option>

                                                    @if($lang->lang == 'eng')

                                                        @foreach($cats as $cat)
                                                            <option value="{{$cat->id}}">{{$cat->cat_slug}}</option>
                                                        @endforeach

                                                    @else

                                                        @foreach($cats as $cat)
                                                            <option value="{{$cat->id}}">{{$cat->cat_name}}</option>
                                                        @endforeach

                                                    @endif

                                                </select>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade" id="step2">
                                            <div class="well">

                                                <h3 style="text-align: center;color: #4b4b4b;margin-bottom: 20px;">Where do you need the job done?</h3>

                                                <input style="height: 40px;" type="search" name="quote_zipcode" id="quote-zipcode" class="form-control quote_validation" placeholder="{{$lang->spzc}}" autocomplete="off">

                                            </div>
                                        </div>


                                        <div class="tab-pane fade" id="step3">

                                            <div class="well" style="height: 300px;"></div>

                                            <div style="width: 100%;position: relative;height: 2rem;bottom: 2rem;background: linear-gradient(rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.8) 25%, rgb(255, 255, 255) 100%);"></div>

                                        </div>

                                        <div class="tab-pane fade" id="step4">

                                            <div class="well" style="height: 300px;">

                                                <h3 style="text-align: center;color: #4b4b4b;margin-bottom: 20px;">Provide a description of your job</h3>

                                                <textarea style="resize: vertical;" rows="7" name="quote_description" class="form-control quote_validation" placeholder="Providing more details increases interest from tradies"></textarea>

                                            </div>

                                            <div style="width: 100%;position: relative;height: 2rem;bottom: 2rem;background: linear-gradient(rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.8) 25%, rgb(255, 255, 255) 100%);"></div>

                                        </div>

                                        <div class="tab-pane fade" id="step5">
                                            <div class="well" style="height: 300px;">

                                                <h3 style="text-align: center;color: #4b4b4b;margin-bottom: 20px;">Please provide some contact details.</h3>

                                                <label>Name <span style="color: red;">*</span></label>
                                                <input style="height: 45px;margin-bottom: 20px;" type="text" name="quote_name" class="form-control quote_validation" placeholder="Enter Name" autocomplete="off">

                                                <label>Family Name <span style="color: red;">*</span></label>
                                                <input style="height: 45px;margin-bottom: 20px;" type="text" name="quote_familyname" class="form-control quote_validation" placeholder="Enter Family Name" autocomplete="off">

                                                <label>Email <span style="color: red;">*</span></label>
                                                <input style="height: 45px;margin-bottom: 20px" type="email" name="quote_email" class="form-control quote_validation" placeholder="Enter Email">

                                                <label>Contact Number <span style="color: red;">*</span></label>
                                                <input style="height: 45px;margin-bottom: 20px" type="text" name="quote_contact" class="form-control quote_validation" placeholder="Enter Contact Number" autocomplete="off">

                                                <small style="text-align: center;display: block;width: 95%;margin: auto;">Your details will be used to create a job post, so that you can monitor and manage the job you've posted.</small>

                                                <br>

                                                <small style="text-align: center;display: block;width: 80%;margin: auto;">By pressing Get Quotes you agree to the <a href="#">terms and conditions</a> of our website.</small>

                                            </div>
                                            <div style="width: 100%;position: relative;height: 2rem;bottom: 2rem;background: linear-gradient(rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.8) 25%, rgb(255, 255, 255) 100%);"></div>

                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button style="border: 0;display: none;outline: none;background-color: #e5e5e5 !important;color: black !important;" class="btn back">Back</button>
                                    <button style="border: 0;outline: none;background-color: #5cb85c !important;" class="btn btn-primary next">Continue</button>
                                    <button style="display: none;border: 0;outline: none;background-color: #5cb85c !important;" class="btn btn-primary next-submit">Get Quotes</button>
                                </div>

                            </div>

                            </form>
                        </div>
                    </div>

                    <style>

                        .container-checkbox {
                            display: flex;
                            position: relative;
                            padding-left: 30px;
                            margin-bottom: 12px;
                            cursor: pointer;
                            font-size: 22px;
                            font-weight: 300;
                            -webkit-user-select: none;
                            -moz-user-select: none;
                            -ms-user-select: none;
                            user-select: none;
                            align-items: center;
                            font-family: sans-serif;
                            color: #353535;
                        }

                        /* Hide the browser's default radio button */
                        .container-checkbox input {
                            position: absolute;
                            opacity: 0;
                            cursor: pointer;
                            height: 0;
                            width: 0;
                        }

                        /* Create a custom radio button */
                        .checkmark-checkbox {
                            position: absolute;
                            /*top: 6.5px;*/
                            left: 0;
                            height: 20px;
                            width: 20px;
                            background-color: transparent;
                            border: 1px solid #e5e5e5;
                            border-radius: 2px;
                        }

                        /* On mouse-over, add a grey background color */
                        .container-checkbox:hover input ~ .checkmark-checkbox {
                            background-color: #ccc;
                        }

                        /* When the radio button is checked, add a blue background */
                        .container-checkbox input:checked ~ .checkmark-checkbox {
                            background-color: #2196F3;
                        }

                        /* Create the indicator (the dot/circle - hidden when not checked) */
                        .checkmark-checkbox:after {
                            content: "";
                            position: absolute;
                            display: none;
                        }

                        /* Show the indicator (dot/circle) when checked */
                        .container-checkbox input:checked ~ .checkmark-checkbox:after {
                            display: block;
                        }

                        /* Style the indicator (dot/circle) */
                        .container-checkbox .checkmark-checkbox:after {
                            left: 7px;
                            top: 3.5px;
                            width: 5px;
                            height: 10px;
                            border: solid white;
                            border-width: 0 3px 3px 0;
                            -webkit-transform: rotate(45deg);
                            -ms-transform: rotate(45deg);
                            transform: rotate(45deg);
                        }

                        .pac-container
                        {
                            z-index: 1000000;
                        }

                        #quote-box .select2
                        {
                            width: 70% !important;float: left;border: 1px solid lightgrey;
                        }

                        .well
                        {
                            box-shadow: none;
                            margin-bottom: 0;
                            background-color: #ffffff;
                            border: 0;
                            overflow-y: auto;
                        }

                        .well .select2
                        {
                            border: 1px solid #e1e1e1;
                        }

                    </style>

                </div>
            </div>
        </div>
    </div>
    <!-- Ending of Hero area -->

    <section id="steps" class="steps steps--en">
        <div class="row row1" style="max-width: 80%;margin-left: auto;margin-right: auto;display: flex;flex-flow: row wrap;">
            <div class="small-12 columns" style="padding-top: 20px;">
                <h2 class="hiw">{{$lang->hiwh}}</h2>

                @if($language == 'eng')

                    <div id="languagePickerContainer">
                        <a class="languageSelector" onclick="changeLanguage(1)" id="dutch" title="dutch">Nederlands</a>
                        <div class="infographic__separator">·</div>
                        <a class="languageSelector languageSelector-selected" title="english" id="english" onclick="changeLanguage(0)">English</a>
                    </div>


                @else

                    <div id="languagePickerContainer">
                        <a class="languageSelector languageSelector-selected" onclick="changeLanguage(1)" id="dutch" title="dutch">Nederlands</a>
                        <div class="infographic__separator">·</div>
                        <a class="languageSelector" title="english" id="english" onclick="changeLanguage(0)">English</a>
                    </div>


                @endif

            </div>
        </div>
        <div class="row steps__items row1" style="max-width: 80%;margin-left: auto;margin-right: auto;display: flex;flex-flow: row wrap;margin-top: 35px;">
            <div class="small-12 medium-6 large-3 columns">
                <div class="step"> <img src="{{asset('assets/images/Location PNG.png')}}" class="ic-img">
                    <div class="step__header step__header_en @if($language == 'du') hide @endif"> 1. {{$hiw->heading1}}</div>
                    <div class="step__header step__header_de @if($language == 'eng') hide @endif"> 1. {{$hiw->dh1}}</div>
                    <p class="step_description step__description_en ic-p @if($language == 'du') hide @endif"> {{$hiw->desc1}} </p>
                    <p class="step_description step__description_de ic-p @if($language == 'eng') hide @endif"> {{$hiw->dd1}} </p>
                </div>
            </div>
            <div class="small-12 medium-6 large-3 columns">
                <div class="step"> <img src="{{asset('assets/images/Date PNG.png')}}" class="ic-img">
                    <div class="step__header step__header_en @if($language == 'du') hide @endif"> 2. {{$hiw->heading2}}</div>
                    <div class="step__header step__header_de @if($language == 'eng') hide @endif"> 2. {{$hiw->dh2}}</div>
                    <p class="step_description step__description_en ic-p @if($language == 'du') hide @endif"> {{$hiw->desc2}} </p>
                    <p class="step_description step__description_de ic-p @if($language == 'eng') hide @endif"> {{$hiw->dd2}} </p>
                </div>
            </div>
            <div class="small-12 medium-6 large-3 columns">
                <div class="step"> <img src="{{asset('assets/images/Profile PNG.png')}}" class="ic-img">
                    <div class="step__header step__header_en @if($language == 'du') hide @endif"> 3. {{$hiw->heading3}}</div>
                    <div class="step__header step__header_de @if($language == 'eng') hide @endif"> 3. {{$hiw->dh3}}</div>
                    <p class="step_description step__description_en ic-p @if($language == 'du') hide @endif"> {{$hiw->desc3}} </p>
                    <p class="step_description step__description_de ic-p @if($language == 'eng') hide @endif"> {{$hiw->dd3}}  </p>
                </div>
            </div>
            <div class="small-12 medium-6 large-3 columns">
                <div class="step"> <img src="{{asset('assets/images/Send Reservation PNG.png')}}" class="ic-img">
                    <div class="step__header step__header_en @if($language == 'du') hide @endif"> 4. {{$hiw->heading4}}</div>
                    <div class="step__header step__header_de @if($language == 'eng') hide @endif"> 4. {{$hiw->dh4}}</div>
                    <p class="step_description step__description_en ic-p @if($language == 'du') hide @endif"> {{$hiw->desc4}} </p>
                    <p class="step_description step__description_de ic-p @if($language == 'eng') hide @endif"> {{$hiw->dd4}}  </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Starting of All - sectors area -->
    <div class="section-padding all-sectors-wrap wow fadeInUp" style="background-color: white;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title pb_50 text-center">
                        <h2>{{$lang->bgs}}</h2>

                        <div class="section-borders">
                            <span></span>
                            <span class="black-border"></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">


                @foreach($cats as $cat)



                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                            <div class="mainflip">
                                <div class="frontside">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <p>

                                                @if($cat->photo == NULL)

                                                    <img class=" img-fluid" src="{{asset('assets/default.jpg')}}" >

                                                @else

                                                    <img class=" img-fluid" src="{{asset('assets/images/'.$cat->photo)}}" >

                                                @endif

                                            @if($lang->lang == 'eng')

                                                <h4 class="card-title" style="font-weight: 600;padding-top: 30px;font-family: monospace;font-size: 15px;">{{$cat->cat_slug}}</h4>

                                            @else

                                                <h4 class="card-title" style="font-weight: 600;padding-top: 30px;font-family: monospace;font-size: 15px;">{{$cat->cat_name}}</h4>

                                                @endif



                                        </div>
                                    </div>
                                </div>
                                <div class="backside" >
                                    <div class="card">
                                        <div class="card-body text-center mt-4">

                                            @if($lang->lang == 'eng')

                                                <h4 class="card-title">{{$cat->cat_slug}}</h4>

                                            @else

                                                <h4 class="card-title">{{$cat->cat_name}}</h4>

                                            @endif


                                            <p class="card-text">{!! $cat->description !!}</p>

                                            <a class="btn btn-primary" style="color: white !important;margin-top: 20px;" href="{{route('front.types',$cat->cat_slug)}}">View</a>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                @endforeach

            </div>
        </div>
    </div>
    <!-- Ending of All - sectors area -->

    <!-- Starting of Team area -->
    <section class="section-padding team_section team_style2 wow fadeInUp" style="background-color: #f5f5f5;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title pb_50 text-center">
                        <h2>{{$lang->rds}}</h2>

                        <div class="section-borders">
                            <span></span>
                            <span class="black-border"></span>
                            <span></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">

                <?php $i = 0;  ?>

                @foreach($rusers as $ruser)
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="team_common">
                            <a href="{{route('front.user',$ruser->id)}}">
                                <div style="width: 100%;background-color: white;">
                                    <div class="member_img" style="width: 50%;border: 0;display: inline-block;height: 210px;">

                                        <img src="{{ $ruser->photo ? asset('assets/images/'.$ruser->photo):asset('assets/default.jpg')}}" alt="member image" style="width: 65%;height: 180px;padding: 0px;border-radius: 100%;border:1px solid lightgrey;margin: auto;display: block;margin-top: 20px;">
                                    </div>

                                    <div style="display: inline-block;max-width: 45%;position: absolute;top: 80px;">
                                        <p style="font-size: 18px;font-weight: bold;color: black;">{{$ruser->name}}</p>


                                    </div>
                                </div>
                            </a>


                            <div class="member_info text-center pos_relative" style="height: 190px;">

                                <div class="overlay1" style="transform: rotate(0deg);top: 0px;"></div>
                                <div class="overlay2" style="top: 0px;transform: rotate(0deg);"></div>


                                <div class="content content1" style="top: -13px;">

                                    <div style="width: 33%;float: left;border-right: 1px solid #c7c0c0;margin-top: 20px;">


                                        <div style="font-size: 15px;font-weight: bold;">{{$lang->ratt}}</div>
                                        <div  style="padding: 10px;font-size: 17px;">{{$ruser->rating}} <span class="fa fa-star checked" style="margin-left: 7px;"></span></div>

                                    </div>

                                    <div style="width: 33%;float: left;border-right: 1px solid #c7c0c0;margin-top: 20px;">

                                        <div style="font-size: 15px;font-weight: bold;">{{$lang->jct}}</div>

                                        <div  style="padding: 10px;font-size: 17px;"><?php echo $jobs[$i][0]; ?></div>

                                    </div>

                                    <div style="width: 33%;float: left;margin-top: 20px;">

                                        <div style="font-size: 15px;font-weight: bold;">{{$lang->et}}</div>
                                        <div  style="padding: 10px;font-size: 17px;">@if($ruser->experience_years) {{ (int) $ruser->experience_years}} @if($ruser->experience_years > 1) {{$lang->yst}} @else {{$lang->yt1}} @endif @else N/A @endif </div>

                                    </div>


                                    <div style="width: 100%;display: inline-block;">


                                        <ul class="social_contact pt_10" style="padding-left: 0px;display: inline-block;padding-top: 20px;">
                                            @if($ruser->f_url != null)
                                                <li>
                                                    <a class="link1" href="{{$ruser->f_url ? $ruser->f_url:'https://www.facebook.com/'}}" title="Facebook" target="_blank" ><i class="fa fa-facebook"></i></a>
                                                </li>
                                            @endif
                                            @if($ruser->t_url != null)
                                                <li>
                                                    <a class="link1" href="{{$ruser->t_url ? $ruser->t_url:'https://twitter.com/'}}" title="Twitter" target="_blank" ><i class="fa fa-twitter"></i></a>
                                                </li>
                                            @endif
                                            @if($ruser->l_url != null)
                                                <li>
                                                    <a class="link1" href="{{$ruser->l_url ? $ruser->l_url:'https://www.linkedin.com/'}}" title="linkedin" target="_blank" ><i class="fa fa-linkedin"></i></a>
                                                </li>
                                            @endif
                                            @if($ruser->g_url != null)
                                                <li>
                                                    <a class="link1" href="{{$ruser->g_url ? $ruser->g_url:'https://plus.google.com/'}}" title="Google-plus" target="_blank" ><i class="fa fa-google-plus"></i></a>
                                                </li>
                                            @endif
                                        </ul>

                                        <a href="{{route('front.user',$ruser->id)}}" class="next1 round1" style="position: absolute;right: 80px;top: 115px;width: 8%;height: 20px;padding: 0;display: inline-table;"><span class="arrow1" style="font-size: 25px;">&#8250;</span></a>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $i++; ?>

                @endforeach

                <style type="text/css">

                    @media (max-width: 890px)
                    {
                        .next1
                        {
                            right: 35px !important;
                        }
                    }

                    @media (max-width: 550px)
                    {
                        .next1
                        {
                            width: 10% !important;
                        }
                    }

                    @media (max-width: 450px)
                    {
                        .next1
                        {
                            width: 12% !important;
                        }
                    }

                </style>



                <!--member-2-->

            </div>
            <div class="text-center">
                <a href="{{route('front.featured')}}" class="boxed-btn blog">{{$lang->vdn}}</a>
            </div>
        </div>
    </section>
    <!-- Ending of Team area -->

    <!-- Starting of Testimonial Area -->
    <!--  <div class="section-padding testimonial-wrapper mb_50 overlay" style="background-image: url({{asset('assets/images/'.$gs->bgimg)}});z-index: auto;color: black;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title pb_50 text-center">
                            <h2>{{$lang->hcs}}</h2>

                            <div class="section-borders">
                                <span></span>
                                <span class="black-border"></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="owl-carousel t_carousel10">
                            @foreach($ads as $ad)
        <div class="single_testimonial text-center">
            <div class="border_extra mb_50 pos_relative">
                <div class="author_info">
                    <h4>{{$ad->client}}</h4>
                                        <span>{{$ad->designation}}</span>
                                        <p class="author_comment color_66">{{$ad->review}}</p>
                                    </div>
                                </div>
                                <div class="author_img radius_100p pos_relative"><img src="{{asset('assets/images/'.$ad->photo)}}" class="radius_100p" alt="author"></div>
                            </div>
                            @endforeach
            </div>
        </div>
    </div>
</div>
</div> -->
    <!-- Ending of Testimonial Area -->

    <!-- Starting of blog area -->
    <div class="section-padding blog-area-wrapper wow fadeInUp">

        <section id="usp" class="usp">
            <div class="row row1" style="max-width: 80%;margin-left: auto;margin-right: auto;display: flex;flex-flow: row wrap;margin-top: 35px;">
                <div class="small-12 medium-12 large-12 columns">
                    <h2 class="hiw">{{$lang->rtbh}}</h2>
                </div>
            </div>
            <div class="row usps__row row2" style="max-width: 60%;margin-left: auto;margin-right: auto;display: flex;flex-flow: row wrap;margin-top: 35px;">
                <div class="large-4 medium-8 small-11 columns">
                    <div class="usp__block">
                        <div>
                            <img src="{{asset('assets/images/Marketplace PNG.png')}}" class="ic-img">
                            <p class="usp__block__title step__header_en ic-p @if($language == 'du') hide @endif">{{$rtb->heading1}}</p>
                            <p class="usp__block__title step__header_de ic-p @if($language == 'eng') hide @endif">{{$rtb->dh1}}</p>
                        </div>
                        <span class="step__description_en @if($language == 'du') hide @endif">{{$rtb->desc1}} </span>
                        <span class="step__description_de @if($language == 'eng') hide @endif">{{$rtb->dd1}} </span>
                    </div>
                </div>
                <div class="large-4 medium-8 small-11 columns">
                    <div class="usp__block">
                        <div>
                            <img src="{{asset('assets/images/Payment PNG.png')}}" class="ic-img">
                            <p class="usp__block__title step__header_en ic-p @if($language == 'du') hide @endif">{{$rtb->heading2}}</p>
                            <p class="usp__block__title step__header_de ic-p @if($language == 'eng') hide @endif">{{$rtb->dh2}}</p>
                        </div>
                        <span class="step__description_en @if($language == 'du') hide @endif">{{$rtb->desc2}}</span>
                        <span class="step__description_de @if($language == 'eng') hide @endif">{{$rtb->dd2}}</span>
                    </div>
                </div>
                <div class="large-4 medium-8 small-11 columns">
                    <div class="usp__block">
                        <div>
                            <img src="{{asset('assets/images/Warranty.png')}}" class="ic-img">
                            <p class="usp__block__title step__header_en ic-p @if($language == 'du') hide @endif">{{$rtb->heading3}}</p>
                            <p class="usp__block__title step__header_de ic-p @if($language == 'eng') hide @endif">{{$rtb->dh3}}</p>
                        </div>
                        <span class="step__description_en @if($language == 'du') hide @endif">{{$rtb->desc3}}</span>
                        <span class="step__description_de @if($language == 'eng') hide @endif">{{$rtb->dd3}}</span>
                    </div>
                </div>
            </div>
        </section>


        <script type="text/javascript">

            $('.quote-service').change(function(){

                var id = $(this).val();

                $('.quote-service').val($(this).val());

                $(".quote-service").trigger('change.select2');

                $.ajax({
                    type:"GET",
                    data: "id=" + id ,
                    url: "<?php echo url('get-questions')?>",

                    success: function(data) {

                        $('#step3').children('.well').empty();

                        var index_count = 0;

                        $.each(data, function (index, val) {

                            $.each(val.answers, function (index1, val1) {
                                console.log(val1);
                            });

                            if(data.length == index + 1)
                            {
                                $('#step3').children('.well').append('<div></div>');
                            }
                            else
                            {
                                $('#step3').children('.well').append('<div style="margin-bottom: 40px;"></div>');
                            }

                            var last = $('#step3').children('.well').children().last('div');

                            last.append('<h3 style="text-align: center;color: #4b4b4b;margin-bottom: 20px;">'+val.title+'</h3><input type="hidden" name="questions[]" value="'+val.title+'">');

                            if(val.predefined)
                            {

                                last.append('<div></div>');

                                $.each(val.answers, function (index1, val1) {

                                        last.children('div').append('<hr>\n' +
                                            '                                        <label class="container-checkbox">'+val1.title+'\n' +
                                            '                                        <input name="answers'+index+'[]" type="checkbox" value="'+val1.title+'">\n' +
                                            '                                        <span class="checkmark-checkbox"></span>\n' +
                                            '                                        </label>');

                                });
                            }
                            else
                            {
                                last.append('<textarea name="answers'+index+'" style="resize: vertical;" rows="7" class="form-control" placeholder=""></textarea>');
                            }

                            index_count = index;

                            });

                        $('#step3').children('.well').append('<input type="hidden" name="index_count" value="'+index_count+'">');

                        /*$('#step3').children('div').children('h3').
                        console.log(data);*/
                    }
                });

            });

            $('.next-submit').click(function(){

                var validation = $('.tab-content').find('.active').find('.quote_validation');

                var flag = 0;

                $(validation).each(function(){

                    if(!$(this).val())
                    {
                        $(this).css('border','1px solid red');
                        flag = 1;
                    }
                    else
                    {
                        $(this).css('border','');
                    }

                });

                if(!flag)
                {
                    $('#quote_form').submit();
                }

                return false;
            });

            $('.next').click(function(){

                var validation = $('.tab-content').find('.active').find('.quote_validation');

                var flag = 0;

                $(validation).each(function(){

                    if(!$(this).val())
                    {
                        if($(this).hasClass('select2-hidden-accessible'))
                        {
                            $(this).next().css('border','1px solid red');
                        }
                        else
                        {
                            $(this).css('border','1px solid red');
                        }

                        flag = 1;
                    }
                    else
                    {
                        $('.select2').css('border','');
                        $(this).css('border','');

                    }

                });

                if(!flag)
                {
                    var nextId = $('.tab-content').find('.active').next().attr("id");
                    $('.nav-pills a[href="#' + nextId + '"]').tab('show');

                    $('.back').show();

                    if(nextId == 'step5')
                    {
                        $('.next').hide();
                        $('.next-submit').show();

                    }
                }

                return false;

            });

            $('.back').click(function(){

                $('.next').show();
                $('.next-submit').hide();

                var backId = $('.tab-content').find('.active').prev().attr("id");
                $('.nav-pills a[href="#' + backId + '"]').tab('show');

                if(backId == 'step1')
                {
                    $('.back').hide();
                }


                return false;

            });

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

                //update progress
                var step = $(e.target).data('step');
                var percent = (parseInt(step) / 5) * 100;

                $('.progress-bar').css({width: percent + '%'});
                $('.progress-bar').text("Step " + step);

                //e.relatedTarget // previous tab

            })

            $('.first').click(function(){

                $('#myWizard a:first').tab('show')

            });


            function changeLanguage(id)
            {
                if(id == 1)
                {

                    $('#dutch').addClass('languageSelector-selected');
                    $('#english').removeClass('languageSelector-selected');

                    $('.step__header_en').addClass('hide');
                    $('.step__header_de').removeClass('hide');

                    $('.step__description_en').addClass('hide');
                    $('.step__description_de').removeClass('hide');

                }
                else{

                    $('#english').addClass('languageSelector-selected');
                    $('#dutch').removeClass('languageSelector-selected');

                    $('.step__header_de').addClass('hide');
                    $('.step__header_en').removeClass('hide');


                    $('.step__description_de').addClass('hide');
                    $('.step__description_en').removeClass('hide');

                }
            }

        </script>

        <style type="text/css">

            .form-control:focus
            {
                border-color: #66afe9 !important;
            }

            #team {
                background: #eee !important;
            }

            .btn-primary:hover,
            .btn-primary:focus {
                background-color: #108d6f;
                border-color: #108d6f;
                box-shadow: none;
                outline: none;
            }

            .btn-primary {
                color: #fff;
                background-color: #007b5e;
                border-color: #007b5e;
            }

            section {
                padding: 60px 0;
            }

            section .section-title {
                text-align: center;
                color: #007b5e;
                margin-bottom: 50px;
                text-transform: uppercase;
            }

            .card {
                border: none;
                position: relative;
                display: flex;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                flex-direction: column;
                min-width: 0;
                word-wrap: break-word;
                background-clip: border-box;
                border-radius: .25rem;
            }

            .card-body
            {
                -webkit-box-flex:1;
                flex:1 1 auto;
                padding:1.25rem;
            }


            .image-flip:hover .backside,
            .image-flip.hover .backside {
                -webkit-transform: rotateY(0deg);
                -moz-transform: rotateY(0deg);
                -o-transform: rotateY(0deg);
                -ms-transform: rotateY(0deg);
                transform: rotateY(0deg);
                border-radius: .25rem;
            }

            .image-flip:hover .frontside,
            .image-flip.hover .frontside {
                -webkit-transform: rotateY(180deg);
                -moz-transform: rotateY(180deg);
                -o-transform: rotateY(180deg);
                transform: rotateY(180deg);
            }

            .mainflip {
                -webkit-transition: 1s;
                -webkit-transform-style: preserve-3d;
                -ms-transition: 1s;
                -moz-transition: 1s;
                -moz-transform: perspective(1000px);
                -moz-transform-style: preserve-3d;
                -ms-transform-style: preserve-3d;
                transition: 1s;
                transform-style: preserve-3d;
                position: relative;
                border: 1px solid #fff;
            }



            .frontside {
                position: relative;
                -webkit-transform: rotateY(0deg);
                -ms-transform: rotateY(0deg);
                z-index: 2;
                margin-bottom: 30px;
            }

            .backside {
                position: absolute;
                top: 0;
                left: 0;
                -webkit-transform: rotateY(-180deg);
                -moz-transform: rotateY(-180deg);
                -o-transform: rotateY(-180deg);
                -ms-transform: rotateY(-180deg);
                transform: rotateY(-180deg);
                -webkit-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
                -moz-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
                box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);


            }


            .frontside,
            .backside {
                -webkit-backface-visibility: hidden;
                -moz-backface-visibility: hidden;
                -ms-backface-visibility: hidden;
                backface-visibility: hidden;
                -webkit-transition: 1s;
                -webkit-transform-style: preserve-3d;
                -moz-transition: 1s;
                -moz-transform-style: preserve-3d;
                -o-transition: 1s;
                -o-transform-style: preserve-3d;
                -ms-transition: 1s;
                -ms-transform-style: preserve-3d;
                transition: 1s;
                transform-style: preserve-3d;
                padding-top: 20px;
                border:1px solid #ffffff;
                border-radius: 5%;
                width: 100%;
                background-color: #f2f4f4;
                /*background-image: linear-gradient(141deg, #d9d9d9 0%, #edf0f1 51%, #aad9ea 75%);*/
                background-image: linear-gradient(141deg, #e7e7e700 0%,  #d6ebf2a1 75%);
                opacity: 0.8;
            }

            .frontside .card,
            .backside .card {
                min-height: 312px;
            }

            .backside .card a {
                font-size: 18px;
                color: #007b5e !important;
            }

            .frontside .card .card-title,
            .backside .card .card-title {
                color: #2b2b2b !important;

            }

            .frontside .card .card-body img {
                width: 85%;
                height: 200px;
                border-radius: 7%;
            }

            .steps{

                background: #f5f5f5;

            }

            @media screen and (min-width: 1024px){

                .steps{

                    padding: 3rem;

                }

            }


            .column,.columns{-ms-flex:1 1 0px;flex:1 1 0px;padding-right:.3125rem;padding-left:.3125rem;min-width:initial}




            .hiw{-ms-flex-positive:2;flex-grow:2;color:#444;text-align:center;-ms-flex-align:center;align-items:center;font-family:"Lato",sans-serif;font-size:2.25rem;font-weight:700;line-height:1.25;padding-bottom:2.25rem;margin:0;text-align:center;font-size:2rem}



            @media screen and (min-width: 30em){

                .hiw{

                    font-size: 38px;

                }

            }

            @media screen and (min-width: 64em){

                .hiw{

                    padding-bottom: 38px;

                }

            }


            #languagePickerContainer{left:0;right:0;margin:.625rem auto;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;-ms-flex-pack:center;justify-content:center;z-index:999;padding-bottom:1rem;margin-top:-2rem}

            .languageSelector{font-size:1em;margin-right:4%;margin:0 1%;color:#666;font-weight:400;cursor:pointer}


            .infographic__separator{content:"\B7";font-family:"Fira Sans";font-size:2.25rem;line-height:1rem;color:#666}

            .languageSelector-selected{color: <?php if($gs->btn_bg == null) { if($gs->colors == null){ echo '#f3bd02 !important;'; } else {   echo $gs->colors.' !important;'; }} else { echo $gs->btn_bg. ' !important;'; } ?>}

            .steps__items {
                justify-content: center;
            }

            .steps__items{text-align:center;font-family:"Lato",sans-serif}



            .large-3{-ms-flex:0 0 25%;flex:0 0 25%;max-width:25%}

            @media print, screen and (max-width: 1600px){

                .row1{

                    max-width: 100% !important;
                }

            }


            @media print, screen and (max-width: 1300px){

                .medium-6{-ms-flex:0 0 50%;flex:0 0 50%;max-width:50%}

            }


            @media print, screen and (max-width: 760px){

                .small-12{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}

            }

            .step{margin-bottom:2.5625rem;margin-left:.9375rem;margin-right:.9375rem}

            @media screen and (min-width: 480px){
                .step img {
                    max-height: 5.375rem;
                    min-height: 80px;
                }
            }

            .step img {
                max-width: 100%;
                max-height: 80px;
            }


            .ic-img{display:inline-block;vertical-align:middle;max-width:100%;height:auto;-ms-interpolation-mode:bicubic}



            .steps--en .step__header_en{display:block}

            .step__header{font-weight:700;font-size:20px;color:#444;margin-top: 20px;}


            @media screen and (min-width: 30em){

                .step__header{

                    font-size: 20px;
                    margin-top: 20px;

                }


            }




            .steps--en .step__description_en{

                display: block;
            }

            @media screen and (min-width: 480px){

                .steps__items p{

                    font-size: 17px;
                }
            }

            .steps__items p{

                font-size: 17px;
                color: #999;
            }




            .ic-p{margin-bottom:1rem;font-size:inherit;line-height:1.6;text-rendering:optimizeLegibility}


            #usp{

                background: #fff;
            }

            .usp{padding-top:3rem;padding-bottom:3rem;background-color:#F3F3F3}

            .large-12{-ms-flex:0 0 100%;flex:0 0 100%;max-width:100%}

            @media screen and (min-width: 30em)
            {
                .usps__row{

                    padding: 1.25rem;
                }
            }

            .usps__row{-ms-flex-pack:center;justify-content:center}



            .small-11{-ms-flex:0 0 91.66667%;flex:0 0 91.66667%;max-width:91.66667%;margin-bottom: 20px;}


            @media print, screen and (min-width: 30em)
            {
                .medium-8{-ms-flex:0 0 66.66667%;flex:0 0 66.66667%;max-width:66.66667%;margin-bottom: 20px;}
            }

            @media print, screen and (min-width: 64em)
            {
                .large-4{-ms-flex:0 0 33.33333%;flex:0 0 33.33333%;max-width:33.33333%}
            }




            @media screen and (min-width: 64em)
            {
                .usp__block{min-height:26rem;padding:1.525rem}
            }


            .usp__block {
                box-shadow: 0px 0px 5px 4px #f3f3f3;
                border: 1px solid #dddddd;
                min-height: 42rem;
            }



            @media screen and (min-width: 1024px)
            {

                .usp__block
                {
                    min-height: 42rem;
                }
            }


            .usp__block{height: 100%;text-align:center;font-family:"Lato", sans-serif;border:solid;border-width:thin;border-color:#ccc;margin:0.1875rem;padding:1.525rem 1.525rem 2.525rem;min-width:8.25rem;background-color:#fff}


            .usp__block div{

                min-height: 7rem;
            }

            .usp__block div{display:block;text-decoration:none;color:#666;padding-top:0.5rem;font-weight:600;min-height:9rem;margin-bottom: 20px;}

            .usp__block img {
                max-width: 100%;
                height: 80px;
                padding-bottom:0.5rem;
            }


            .usp__block__title{margin-top:0;margin-bottom:0;font-size:20px;color:#444}

            @media screen and (min-width: 30em)
            {
                .usp__block span{

                    font-size: 13px;
                }
            }

            .usp__block span{font-weight:300;color:#666;font-size:15px;word-break: break-word;}




            @media print, screen and (max-width: 1600px){

                .row2{

                    max-width: 80% !important;
                }

            }

            @media print, screen and (max-width: 1200px){

                .row2{

                    max-width: 90% !important;
                }

            }

        </style>

    <!-- <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title pb_50 text-center">
                            <h2>{{$lang->lns}}</h2>

                            <div class="section-borders">
                                <span></span>
                                <span class="black-border"></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-md-12">
                         <div class="owl-carousel blog-area-slider">
                            @foreach($lblogs as $lblog)
        <a href="{{route('front.blogshow',$lblog->id)}}" class="single-blog-box">
                               <div class="blog-thumb-wrapper">
                                   <img src="{{asset('assets/images/'.$lblog->photo)}}" alt="Blog Image">
                               </div>
                                <div class="blog-text">
                                    <p class="blog-meta">{{date('d M, Y , H:i a',strtotime($lblog->created_at))}}
                </p>
                <h4>{{$lblog->title}}</h4>
                                    <p class="blog-meta-text">{{substr(strip_tags($lblog->details),0,250)}}</p>
                                    <span class="boxed-btn blog">{{$lang->vd}}</span>
                                </div>
                            </a>
                            @endforeach
            </div>
        </div>
   </div>
</div> -->
    </div>
    <!-- Ending of blog area -->

    <style>

        .select2-container{

            height: 100%;
        }

        .select2-container--default .select2-selection--single{
            height: 100%;
            padding: 7px;
            border: none;
            border-radius: 0;
            outline: none;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow{

            padding: 19px;
        }

        .select2-selection__clear{

            display: none;
        }

    </style>

    <style type="text/css">
        /*!
* Datepicker for Bootstrap v1.5.0 (https://github.com/eternicode/bootstrap-datepicker)
*
* Copyright 2012 Stefan Petre
* Improvements by Andrew Rowls
* Licensed under the Apache License v2.0 (http://www.apache.org/licenses/LICENSE-2.0)
*/
        .datepicker {
            padding: 4px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            direction: ltr;
        }
        .datepicker-inline {
            width: 220px;
        }
        .datepicker.datepicker-rtl {
            direction: rtl;
        }
        .datepicker.datepicker-rtl table tr td span {
            float: right;
        }
        .datepicker-dropdown {
            top: 0;

            min-width: 19.3% !important;
        }

        .table-condensed{

            width: 100%;


        }

        .datepicker td, .datepicker th
        {

            font-size: 17px;


        }
        .datepicker-dropdown:before {
            content: '';
            display: inline-block;
            border-left: 7px solid transparent;
            border-right: 7px solid transparent;
            border-bottom: 7px solid #999999;
            border-top: 0;
            border-bottom-color: rgba(0, 0, 0, 0.2);
            position: absolute;
        }
        .datepicker-dropdown:after {
            content: '';
            display: inline-block;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-bottom: 6px solid #ffffff;
            border-top: 0;
            position: absolute;
        }
        .datepicker-dropdown.datepicker-orient-left:before {
            left: 6px;
        }
        .datepicker-dropdown.datepicker-orient-left:after {
            left: 7px;
        }
        .datepicker-dropdown.datepicker-orient-right:before {
            right: 6px;
        }
        .datepicker-dropdown.datepicker-orient-right:after {
            right: 7px;
        }
        .datepicker-dropdown.datepicker-orient-bottom:before {
            display: none;
            top: -7px;
        }
        .datepicker-dropdown.datepicker-orient-bottom:after {
            display: none;
            top: -6px;
        }
        .datepicker-dropdown.datepicker-orient-top:before {
            display: none;
            bottom: -7px;
            border-bottom: 0;
            border-top: 7px solid #999999;
        }
        .datepicker-dropdown.datepicker-orient-top:after {
            display: none;
            bottom: -6px;
            border-bottom: 0;
            border-top: 6px solid #ffffff;
        }
        .datepicker > div {
            display: none;
        }
        .datepicker table {
            margin: 0;
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        .datepicker td,
        .datepicker th {
            text-align: center;
            width: 20px;
            height: 20px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            border: none;
        }
        .table-striped .datepicker table tr td,
        .table-striped .datepicker table tr th {
            background-color: transparent;
        }
        .datepicker table tr td.day:hover,
        .datepicker table tr td.day.focused {
            background: #eeeeee;
            cursor: pointer;
        }
        .datepicker table tr td.old,
        .datepicker table tr td.new {
            color: #999999;
        }
        .datepicker table tr td.disabled,
        .datepicker table tr td.disabled:hover {
            background: none;
            color: #999999;
            cursor: default;
        }
        .datepicker table tr td.highlighted {
            background: #d9edf7;
            border-radius: 0;
        }
        .datepicker table tr td.today,
        .datepicker table tr td.today:hover,
        .datepicker table tr td.today.disabled,
        .datepicker table tr td.today.disabled:hover {
            background-color: #fde19a;
            background-image: -moz-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: -ms-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#fdd49a), to(#fdf59a));
            background-image: -webkit-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: -o-linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-image: linear-gradient(to bottom, #fdd49a, #fdf59a);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#fdd49a', endColorstr='#fdf59a', GradientType=0);
            border-color: #fdf59a #fdf59a #fbed50;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #000;
        }
        .datepicker table tr td.today:hover,
        .datepicker table tr td.today:hover:hover,
        .datepicker table tr td.today.disabled:hover,
        .datepicker table tr td.today.disabled:hover:hover,
        .datepicker table tr td.today:active,
        .datepicker table tr td.today:hover:active,
        .datepicker table tr td.today.disabled:active,
        .datepicker table tr td.today.disabled:hover:active,
        .datepicker table tr td.today.active,
        .datepicker table tr td.today:hover.active,
        .datepicker table tr td.today.disabled.active,
        .datepicker table tr td.today.disabled:hover.active,
        .datepicker table tr td.today.disabled,
        .datepicker table tr td.today:hover.disabled,
        .datepicker table tr td.today.disabled.disabled,
        .datepicker table tr td.today.disabled:hover.disabled,
        .datepicker table tr td.today[disabled],
        .datepicker table tr td.today:hover[disabled],
        .datepicker table tr td.today.disabled[disabled],
        .datepicker table tr td.today.disabled:hover[disabled] {
            background-color: #fdf59a;
        }
        .datepicker table tr td.today:active,
        .datepicker table tr td.today:hover:active,
        .datepicker table tr td.today.disabled:active,
        .datepicker table tr td.today.disabled:hover:active,
        .datepicker table tr td.today.active,
        .datepicker table tr td.today:hover.active,
        .datepicker table tr td.today.disabled.active,
        .datepicker table tr td.today.disabled:hover.active {
            background-color: #fbf069 \9;
        }
        .datepicker table tr td.today:hover:hover {
            color: #000;
        }
        .datepicker table tr td.today.active:hover {
            color: #fff;
        }
        .datepicker table tr td.range,
        .datepicker table tr td.range:hover,
        .datepicker table tr td.range.disabled,
        .datepicker table tr td.range.disabled:hover {
            background: #eeeeee;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }
        .datepicker table tr td.range.today,
        .datepicker table tr td.range.today:hover,
        .datepicker table tr td.range.today.disabled,
        .datepicker table tr td.range.today.disabled:hover {
            background-color: #f3d17a;
            background-image: -moz-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: -ms-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#f3c17a), to(#f3e97a));
            background-image: -webkit-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: -o-linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-image: linear-gradient(to bottom, #f3c17a, #f3e97a);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#f3c17a', endColorstr='#f3e97a', GradientType=0);
            border-color: #f3e97a #f3e97a #edde34;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
        }
        .datepicker table tr td.range.today:hover,
        .datepicker table tr td.range.today:hover:hover,
        .datepicker table tr td.range.today.disabled:hover,
        .datepicker table tr td.range.today.disabled:hover:hover,
        .datepicker table tr td.range.today:active,
        .datepicker table tr td.range.today:hover:active,
        .datepicker table tr td.range.today.disabled:active,
        .datepicker table tr td.range.today.disabled:hover:active,
        .datepicker table tr td.range.today.active,
        .datepicker table tr td.range.today:hover.active,
        .datepicker table tr td.range.today.disabled.active,
        .datepicker table tr td.range.today.disabled:hover.active,
        .datepicker table tr td.range.today.disabled,
        .datepicker table tr td.range.today:hover.disabled,
        .datepicker table tr td.range.today.disabled.disabled,
        .datepicker table tr td.range.today.disabled:hover.disabled,
        .datepicker table tr td.range.today[disabled],
        .datepicker table tr td.range.today:hover[disabled],
        .datepicker table tr td.range.today.disabled[disabled],
        .datepicker table tr td.range.today.disabled:hover[disabled] {
            background-color: #f3e97a;
        }
        .datepicker table tr td.range.today:active,
        .datepicker table tr td.range.today:hover:active,
        .datepicker table tr td.range.today.disabled:active,
        .datepicker table tr td.range.today.disabled:hover:active,
        .datepicker table tr td.range.today.active,
        .datepicker table tr td.range.today:hover.active,
        .datepicker table tr td.range.today.disabled.active,
        .datepicker table tr td.range.today.disabled:hover.active {
            background-color: #efe24b \9;
        }
        .datepicker table tr td.selected,
        .datepicker table tr td.selected:hover,
        .datepicker table tr td.selected.disabled,
        .datepicker table tr td.selected.disabled:hover {
            background-color: #9e9e9e;
            background-image: -moz-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: -ms-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#b3b3b3), to(#808080));
            background-image: -webkit-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: -o-linear-gradient(to bottom, #b3b3b3, #808080);
            background-image: linear-gradient(to bottom, #b3b3b3, #808080);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#b3b3b3', endColorstr='#808080', GradientType=0);
            border-color: #808080 #808080 #595959;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        }
        .datepicker table tr td.selected:hover,
        .datepicker table tr td.selected:hover:hover,
        .datepicker table tr td.selected.disabled:hover,
        .datepicker table tr td.selected.disabled:hover:hover,
        .datepicker table tr td.selected:active,
        .datepicker table tr td.selected:hover:active,
        .datepicker table tr td.selected.disabled:active,
        .datepicker table tr td.selected.disabled:hover:active,
        .datepicker table tr td.selected.active,
        .datepicker table tr td.selected:hover.active,
        .datepicker table tr td.selected.disabled.active,
        .datepicker table tr td.selected.disabled:hover.active,
        .datepicker table tr td.selected.disabled,
        .datepicker table tr td.selected:hover.disabled,
        .datepicker table tr td.selected.disabled.disabled,
        .datepicker table tr td.selected.disabled:hover.disabled,
        .datepicker table tr td.selected[disabled],
        .datepicker table tr td.selected:hover[disabled],
        .datepicker table tr td.selected.disabled[disabled],
        .datepicker table tr td.selected.disabled:hover[disabled] {
            background-color: #808080;
        }
        .datepicker table tr td.selected:active,
        .datepicker table tr td.selected:hover:active,
        .datepicker table tr td.selected.disabled:active,
        .datepicker table tr td.selected.disabled:hover:active,
        .datepicker table tr td.selected.active,
        .datepicker table tr td.selected:hover.active,
        .datepicker table tr td.selected.disabled.active,
        .datepicker table tr td.selected.disabled:hover.active {
            background-color: #666666 \9;
        }
        .datepicker table tr td.active,
        .datepicker table tr td.active:hover,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active.disabled:hover {
            background-color: #006dcc;
            background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
            background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: linear-gradient(to bottom, #0088cc, #0044cc);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
            border-color: #0044cc #0044cc #002a80;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        }
        .datepicker table tr td.active:hover,
        .datepicker table tr td.active:hover:hover,
        .datepicker table tr td.active.disabled:hover,
        .datepicker table tr td.active.disabled:hover:hover,
        .datepicker table tr td.active:active,
        .datepicker table tr td.active:hover:active,
        .datepicker table tr td.active.disabled:active,
        .datepicker table tr td.active.disabled:hover:active,
        .datepicker table tr td.active.active,
        .datepicker table tr td.active:hover.active,
        .datepicker table tr td.active.disabled.active,
        .datepicker table tr td.active.disabled:hover.active,
        .datepicker table tr td.active.disabled,
        .datepicker table tr td.active:hover.disabled,
        .datepicker table tr td.active.disabled.disabled,
        .datepicker table tr td.active.disabled:hover.disabled,
        .datepicker table tr td.active[disabled],
        .datepicker table tr td.active:hover[disabled],
        .datepicker table tr td.active.disabled[disabled],
        .datepicker table tr td.active.disabled:hover[disabled] {
            background-color: #0044cc;
        }
        .datepicker table tr td.active:active,
        .datepicker table tr td.active:hover:active,
        .datepicker table tr td.active.disabled:active,
        .datepicker table tr td.active.disabled:hover:active,
        .datepicker table tr td.active.active,
        .datepicker table tr td.active:hover.active,
        .datepicker table tr td.active.disabled.active,
        .datepicker table tr td.active.disabled:hover.active {
            background-color: #003399 \9;
        }
        .datepicker table tr td span {
            display: block;
            width: 23%;
            height: 54px;
            line-height: 54px;
            float: left;
            margin: 1%;
            cursor: pointer;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
        }
        .datepicker table tr td span:hover {
            background: #eeeeee;
        }
        .datepicker table tr td span.disabled,
        .datepicker table tr td span.disabled:hover {
            background: none;
            color: #999999;
            cursor: default;
        }
        .datepicker table tr td span.active,
        .datepicker table tr td span.active:hover,
        .datepicker table tr td span.active.disabled,
        .datepicker table tr td span.active.disabled:hover {
            background-color: #006dcc;
            background-image: -moz-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -ms-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0044cc));
            background-image: -webkit-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: -o-linear-gradient(to bottom, #0088cc, #0044cc);
            background-image: linear-gradient(to bottom, #0088cc, #0044cc);
            background-repeat: repeat-x;
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#0088cc', endColorstr='#0044cc', GradientType=0);
            border-color: #0044cc #0044cc #002a80;
            border-color: rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.1) rgba(0, 0, 0, 0.25);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled=false);
            color: #fff;
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
        }
        .datepicker table tr td span.active:hover,
        .datepicker table tr td span.active:hover:hover,
        .datepicker table tr td span.active.disabled:hover,
        .datepicker table tr td span.active.disabled:hover:hover,
        .datepicker table tr td span.active:active,
        .datepicker table tr td span.active:hover:active,
        .datepicker table tr td span.active.disabled:active,
        .datepicker table tr td span.active.disabled:hover:active,
        .datepicker table tr td span.active.active,
        .datepicker table tr td span.active:hover.active,
        .datepicker table tr td span.active.disabled.active,
        .datepicker table tr td span.active.disabled:hover.active,
        .datepicker table tr td span.active.disabled,
        .datepicker table tr td span.active:hover.disabled,
        .datepicker table tr td span.active.disabled.disabled,
        .datepicker table tr td span.active.disabled:hover.disabled,
        .datepicker table tr td span.active[disabled],
        .datepicker table tr td span.active:hover[disabled],
        .datepicker table tr td span.active.disabled[disabled],
        .datepicker table tr td span.active.disabled:hover[disabled] {
            background-color: #0044cc;
        }
        .datepicker table tr td span.active:active,
        .datepicker table tr td span.active:hover:active,
        .datepicker table tr td span.active.disabled:active,
        .datepicker table tr td span.active.disabled:hover:active,
        .datepicker table tr td span.active.active,
        .datepicker table tr td span.active:hover.active,
        .datepicker table tr td span.active.disabled.active,
        .datepicker table tr td span.active.disabled:hover.active {
            background-color: #003399 \9;
        }
        .datepicker table tr td span.old,
        .datepicker table tr td span.new {
            color: #999999;
        }
        .datepicker .datepicker-switch {
            width: 145px;
        }
        .datepicker .datepicker-switch,
        .datepicker .prev,
        .datepicker .next,
        .datepicker tfoot tr th {
            cursor: pointer;
        }
        .datepicker .datepicker-switch:hover,
        .datepicker .prev:hover,
        .datepicker .next:hover,
        .datepicker tfoot tr th:hover {
            background: #eeeeee;
        }
        .datepicker .cw {
            font-size: 10px;
            width: 12px;
            padding: 0 2px 0 5px;
            vertical-align: middle;
        }
        .input-append.date .add-on,
        .input-prepend.date .add-on {
            cursor: pointer;
        }
        .input-append.date .add-on i,
        .input-prepend.date .add-on i {
            margin-top: 3px;
        }
        .input-daterange input {
            text-align: center;
        }
        .input-daterange input:first-child {
            -webkit-border-radius: 3px 0 0 3px;
            -moz-border-radius: 3px 0 0 3px;
            border-radius: 3px 0 0 3px;
        }
        .input-daterange input:last-child {
            -webkit-border-radius: 0 3px 3px 0;
            -moz-border-radius: 0 3px 3px 0;
            border-radius: 0 3px 3px 0;
        }
        .input-daterange .add-on {
            display: inline-block;
            width: auto;
            min-width: 16px;
            height: 18px;
            padding: 4px 5px;
            font-weight: normal;
            line-height: 18px;
            text-align: center;
            text-shadow: 0 1px 0 #ffffff;
            vertical-align: middle;
            background-color: #eeeeee;
            border: 1px solid #ccc;
            margin-left: -5px;
            margin-right: -5px;
        }


    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>

    <script type="text/javascript">

        $(document).ready(function() {


            $('#from_date').datepicker({

                format: 'dd-mm-yyyy',
                startDate: new Date(),

            });

            $('#to_date').datepicker({

                format: 'dd-mm-yyyy',
                startDate: new Date(),

            });

        });

    </script>

    <script>

        $(".js-data-example-ajax").select2({
            width: '100%',
            height: '200px',
            // placeholder: "City Name",
            placeholder: "<?php echo $lang->sbg; ?>",
            allowClear: true,
            dropdownParent: $('#service_box'),


        });

        $(".js-data-example-ajax1").select2({
            width: '100%',
            height: '200px',
            // placeholder: "City Name",
            placeholder: "<?php echo $lang->sbg; ?>",
            allowClear: true,


        });

        $(".js-data-example-ajax2").select2({
            width: '100%',
            height: '200px',
            // placeholder: "City Name",
            placeholder: "<?php echo $lang->sbg; ?>",
            allowClear: true,
            dropdownParent: $('#myModal'),


        });

    </script>

@endsection
