@extends('layouts.front')
@section('content')

<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.8.10/css/mdb.min.css" rel="stylesheet">



<div class="donors-profile-top-bg overlay text-center wow fadeInUp" style="background-image: url({{asset('assets/images/'.$gs->bgimg)}}); visibility: visible; animation-name: fadeInUp;z-index: auto;color: black;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{$user->name}}</h2>
                        <p>{{$lang->bg}}
                            <?php $count = count($services); $i=1; ?>
                            @foreach($services as $key)

                                @if($i == $count)

                                    @if($lang->lang == 'eng')

                                        {{$key->cat_slug}}

                                        @else

                                        {{$key->cat_name}}

                                        @endif


                                @else

                                    @if($lang->lang == 'eng')

                                        {{$key->cat_slug}},

                                    @else

                                        {{$key->cat_name}},

                                    @endif

                                    @endif

                                <?php $i++; ?>

                         @endforeach</p>
                    </div>
                </div>
            </div>
        </div>

           @if(Session::has('success'))


        <div  class="alert alert-success" style="text-align: center;font-size: 20px;font-weight: 600;font-family: sans-serif;">
  <strong>Success!</strong> {{ Session::get('success') }}
</div>

    @endif

     <div id="msg" class="alert alert-success" style="text-align: center;font-size: 20px;font-weight: 600;font-family: monospace;display: none;">
        </div>

        <div id="errmsg" class="alert alert-danger" style="text-align: center;font-size: 20px;font-weight: 600;font-family: monospace;display: none;">
</div>


<div class="donors-profile-wrap wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">


                        <div class="profile-description-box margin-bottom-30">
                            <h2 class="ut">{{$lang->dopd}}</h2>
                            <hr>


                            <p>{!!$user->description!!}</p>


                        </div>


                        @if($user->special != null)

                            <div class="other-description-box margin-bottom-30">
                                <h2 class="ut">{{$lang->doo}}</h2>
                                <hr>
                                <div class="table-responsive" style="overflow: hidden;">

                                    @php
                                        $specials = explode(',', $user->special);
                                    @endphp

                                    <ul class="row">
                                        @foreach($specials as $special)
                                            <li class="col-md-6 col-sm-6">{{$special}}</li>
                                        @endforeach
                                    </ul>

                                </div>
                            </div>

                        @endif

                        <div class="other-description-box margin-bottom-30" style="display: none;">
                            <h2 class="ut">{{$lang->binfo}}</h2>
                            <hr>
                            <div class="table-responsive" style="text-align: center;">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <th>{{$lang->dol}}</th>
                                        <td>{{$user->language}}</td>
                                    </tr>

                                    <tr>
                                        <th>{{$lang->doe}}</th>
                                        <td>{{$user->education}}</td>
                                    </tr>

                                    @if($bookings != '')

                                    <tr>
                                        <th>{{$lang->dor}}</th>
                                        <td>{{$user->residency}}</td>
                                    </tr>
                                    <tr>
                                        <th>{{$lang->dopr}}</th>
                                        <td>{{$user->profession}}</td>
                                    </tr>



                                    @endif


                                </tbody></table>

                                @if($bookings == '')

                                    <h2>{{$lang->yhtb}}</h2>

                                    @endif
                            </div>
                        </div>

                        <div class="other-description-box margin-bottom-30">
                            <h2 class="ut">{{$lang->sat}}</h2>
                            <hr>

    <div style="height:auto;width:100%;display:inline-block;">


<?php $x = 0; ?>
@foreach($services as $temp)


@if( $x%2 == 0 )

<div class="wrapper" style="margin-bottom: 35px;float: left;">

@else

<div class="wrapper" style="margin-bottom: 35px;float: right;">

@endif

    <div class="container" style="padding: 0px;">

        <div class="top" <?php if($temp->cat_photo){ ?> style="background: url(<?php echo asset('assets/images/'.$temp->cat_photo) ?>) no-repeat center center;background-size: 100%;" <?php } else{ ?> style="background: url(<?php echo asset('assets/default.jpg') ?>) no-repeat center center;background-size: 100%;" <?php } ?> ></div>

        <div class="bottom<?php echo $x; ?>">

            <div class="left">

                <div class="details" style="width: 75%;padding-right: 0;cursor: pointer;">

                    @if($lang->lang == 'eng')

                        <h3>{{$temp->cat_slug}}</h3>

                    @else

                        <h3>{{$temp->cat_name}}</h3>

                    @endif

                    <?php if($temp->service_id == 1){ $service_type = $lang->servT1; $service_placeholder = $lang->servP1; }

                    elseif($temp->service_id == 2){ $service_type = $lang->servT2; $service_placeholder = $lang->servP2; }

                    elseif($temp->service_id == 3){ $service_type = $lang->servT3; $service_placeholder = $lang->servP3; }

                    elseif($temp->service_id == 4){ $service_type = $lang->servT4; $service_placeholder = $lang->servP4; }

                    else{$service_type = ""; $service_placeholder = "";}

                    ?>

                        <p style="font-size: 13.5pt;">€ {{$temp->rate}} {{$service_type}}</p>

                </div>


                <div class="buy<?php echo $x; ?>" style="padding-top: 20px;"><a href="" class="openModal" data-toggle="modal" data-target="#modalLoginAvatar" data-value="{{$temp->id}}" data-type="{{$service_placeholder}}" @if($lang->lang == 'eng') data-main="{{$temp->cat_slug}}" @else data-main="{{$temp->cat_name}}" @endif  data-stype="{{$service_type}}" data-service="{{$temp->service_id}}" data-questions="{{$temp->variable_questions}}" data-vat="{{$temp->vat_percentage}}" data-sellRate="{{$temp->sell_rate}}" data-rate="{{$temp->rate}}" data-description="{{$temp->description}}"><i class="material-icons">add_shopping_cart</i></a></div>

            </div>


            <div class="right">

                <div class="done" style="padding-top: 20px;"><i class="material-icons">done</i></div>

                <div class="details" style="width: 75%;padding-left: 10px;padding-right: 0;cursor: pointer;">

                    @if($lang->lang == 'eng')

                        <h3>{{$temp->cat_slug}}</h3>

                    @else

                        <h3>{{$temp->cat_name}}</h3>

                    @endif

                        <p>{{$lang->rtac}}</p>

                </div>


                <div class="remove<?php echo $x; ?>" style="padding-top: 20px;"><i class="material-icons">clear</i></div>

            </div>
        </div>
    </div>


    <div class="inside">

        <div class="icon" style="width: 13%;"><i class="material-icons">info_outline</i></div>

        <div class="contents">
            <table>
                <tr>
                    <th style="font-size: 20px;">{{$lang->st}}</th>
                </tr>

                <tr>
                    <td style="font-size: 14pt;padding: 10px;">{{$service_type}}</td>
                </tr>

                <tr>
                    <th style="font-size: 20px;">{{$lang->sr}}</th>
                </tr>

                <tr>
                    <td style="font-size: 14pt;padding: 10px;">€ {{$temp->rate}}</td>
                </tr>

                <tr>
                    <th style="font-size: 20px;">{{$lang->dt}}</th>
                </tr>

                <tr>
                    <td style="padding: 0px;"><p style="font-size: 11pt;word-break: break-word;">{!!$temp->description!!}</p></td>
                </tr>

            </table>
        </div>
    </div>
</div>


<style type="text/css">


.wrapper {
    width: 50%;
    height: 635px;
    background: white;
    margin: auto;
    position: relative;
    overflow: hidden;
    border-radius: 10px 10px 10px 10px;
    box-shadow: 0;
    transform: scale(0.95);
    -webkit-transform: scale(0.95);
    transition: box-shadow 0.5s, transform 0.5s;
    -webkit-transition: box-shadow 0.5s, -webkit-transform 0.5s;


}

.wrapper:hover {
    transform: scale(1);
    -webkit-transform: scale(1);
    box-shadow: 5px 20px 30px rgba(0, 0, 0, 0.2);
}

.wrapper .container {
    width: 100%;
    height: 100%;
}

.wrapper .container .top {
    height: 80%;
    width: 100%;
    border: 1px solid #ededed;
    background: url(https://s-media-cache-ak0.pinimg.com/736x/49/80/6f/49806f3f1c7483093855ebca1b8ae2c4.jpg) no-repeat center center;
    -webkit-background-size: 100%;
    -moz-background-size: 100%;
    -o-background-size: 100%;
    background-size: 100%;
}

.wrapper .container .bottom<?php echo $x; ?> {
    width: 200%;
    height: 20%;
    transition: transform 0.5s;
    -webkit-transition: -webkit-transform 0.5s;
}

.wrapper .container .bottom<?php echo $x; ?>.clicked {
    transform: translateX(-50%);
    -webkit-transform: translateX(-50%);
}

.wrapper .container .bottom<?php echo $x; ?> h1 {
    margin: 0;
    padding: 0;
}

.wrapper .container .bottom<?php echo $x; ?> p {
    margin: 0;
    padding: 0;
}

.wrapper .container .bottom<?php echo $x; ?> .left {
    height: 100%;
    width: 50%;
    background: #f4f4f4;
    position: relative;
    float: left;
}

.wrapper .container .bottom<?php echo $x; ?> .left .details {
    padding: 20px;
    float: left;
    width: 70%;

}

.wrapper .container .bottom<?php echo $x; ?> .left .buy<?php echo $x; ?> {
    float: right;
    width: 25%;
    height: 100%;
    background: #f1f1f1;
    transition: background 0.5s;
    -webkit-transition: background 0.5s;
    border-left: solid thin rgba(0, 0, 0, 0.1);
}

.wrapper .container .bottom<?php echo $x; ?> .left .buy<?php echo $x; ?> i {
    font-size: 30px;
    color: #254053;
    transition: transform 0.5s;
    -webkit-transition: -webkit-transform 0.5s;
    width: 100%;
    padding: 25px 18px;
    text-align: center;
}

.wrapper .container .bottom<?php echo $x; ?> .left .buy<?php echo $x; ?>:hover {
    background: #A6CDDE;
}

.wrapper .container .bottom<?php echo $x; ?> .left .buy<?php echo $x; ?>:hover i {
    transform: translateY(5px);
    -webkit-transform: translateY(5px);
    color: #00394B;
}

.wrapper .container .bottom<?php echo $x; ?> .right {
    width: 50%;
    background: #A6CDDE;
    color: white;
    float: right;
    height: 100%;
    overflow: hidden;
    position: relative;
}

.wrapper .container .bottom<?php echo $x; ?> .right .details {
    padding: 20px;
    float: right;
    width: auto;
}

.wrapper .container .bottom<?php echo $x; ?> .right .done {
    width: 25%;
    float: left;
    transition: transform 0.5s;
    -webkit-transition: -webkit-transform 0.5s;
    border-right: solid thin rgba(255, 255, 255, 0.3);
    height: 100%;
}

.wrapper .container .bottom<?php echo $x; ?> .right .done i {
    font-size: 30px;
    padding: 30px;
    color: white;
}

.wrapper .container .bottom<?php echo $x; ?> .right .remove<?php echo $x; ?> {
    width: 25%;
    float: left;
    clear: both;
    border-right: solid thin rgba(255, 255, 255, 0.3);
    height: 100%;
    background: #BC3B59;
    transition: transform 0.5s, background 0.5s;
    -webkit-transition: -webkit-transform 0.5s, background 0.5s;
}

.wrapper .container .bottom<?php echo $x; ?> .right .remove<?php echo $x; ?>:hover {
    background: #9B2847;
}

.wrapper .container .bottom<?php echo $x; ?> .right .remove<?php echo $x; ?>:hover i {
    transform: translateY(5px);
    -webkit-transform: translateY(5px);
}

.wrapper .container .bottom<?php echo $x; ?> .right .remove<?php echo $x; ?> i {
    transition: transform 0.5s;
    -webkit-transition: -webkit-transform 0.5s;
    font-size: 30px;
    padding: 25px 18px;
    color: white;
    width: 100%;
    text-align: center;
}

.wrapper .container .bottom<?php echo $x; ?> .right:hover .remove<?php echo $x; ?>, .wrapper .container .bottom<?php echo $x; ?> .right:hover .done {
    transform: translateY(-100%);
    -webkit-transform: translateY(-100%);
    cursor: pointer;
}

.wrapper .inside {
    z-index: 9;
    background: #37a2ba;
    width: 140px;
    height: 140px;
    position: absolute;
    top: -70px;
    right: -70px;
    border-radius: 0px 0px 200px 200px;
    transition: all 0.5s, border-radius 2s, top 1s;
    -webkit-transition: all 0.5s, border-radius 2s, top 1s;
    overflow-x: hidden;
    overflow-y: auto;
}

.wrapper .inside .icon {
    position: fixed;
    right: 8px;
    text-align: center;
    top: 17px;
    color: white;
    opacity: 1;
}

.wrapper .inside:hover {
    width: 100%;
    right: 0;
    top: 0;
    border-radius: 0;
    height: 80%;
}

.wrapper .inside:hover .icon {
    opacity: 0;
    right: 15px;
    top: 15px;
}

.wrapper .inside:hover .contents {
    opacity: 1;
    transform: scale(1);
    transform: translateY(0);
    -webkit-transform: scale(1);
    -webkit-transform: translateY(0);
}

.wrapper .inside .contents {
    padding: 5%;
    opacity: 0;
    transform: scale(0.5);
    transform: translateY(-200%);
    transition: opacity 0.2s, transform 0.8s;
    -webkit-transform: scale(0.5);
    -webkit-transform: translateY(-200%);
    -webkit-transition: opacity 0.2s, -webkit-transform 0.8s;
}

.wrapper .inside .contents table {
    text-align: left;
    width: 100%;
}

.wrapper .inside .contents h1, .wrapper .inside .contents p, .wrapper .inside .contents table {
    color: white;
}

.wrapper .inside .contents p {
    font-size: 13px;
}

.material-icons {
  font-family: 'Material Icons';
  font-weight: normal;
  font-style: normal;
  font-size: 24px;
  line-height: 1;
  letter-spacing: normal;
  text-transform: none;
  display: inline-block;
  white-space: nowrap;
  word-wrap: normal;
  direction: ltr;
  -webkit-font-feature-settings: 'liga';
  -webkit-font-smoothing: antialiased;
}



</style>

<script type="text/javascript">

    $('.buy<?php echo $x; ?>').click(function(){
  $('.bottom<?php echo $x; ?>').addClass("clicked");
  $('.donors-profile-wrap').css('display','inline');
});

$('.remove<?php echo $x; ?>').click(function(){
  $('.bottom<?php echo $x; ?>').removeClass("clicked");

});



</script>

<?php $x = $x + 1; ?>

@endforeach

</div>
</div>

<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">




                        @if(!empty($ad728x90))
                        @if($ad728x90->type == "banner")
                        <div class="add-area margin-bottom-30">
                            <a href="{{route('front.ads',$ad728x90->id)}}">
                            <img src="{{  asset('assets/images/'.$ad728x90->photo) }}" alt="{{$ad728x90->alt}}">
                            </a>
                        </div>
                        @else
                            {!! $ad728x90->script !!}
                        @endif
                        @endif

                        <div class="ajax-loader">

  <img src="{{ asset('assets/images/Double Ring-1s-200px.gif') }}" class="img-responsive" />

  <h2 style="text-align: center;position: relative;top: 48%;font-weight: 500;">{{$lang->pwt}}</h2>
  <p style="text-align: center;position: relative;top: 48%;font-size: 19px;font-weight: 500;">{{$lang->pwm}}</p>

</div>


<style type="text/css">

    .ajax-loader {
  visibility: hidden;
  background-color: rgba(255, 255, 255, 0.86);
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000000 !important;
  width: 100%;
  height:100%;
}

.ajax-loader img {
  position: relative;
  top:45%;
  left:0;
  width: 12%;
  height: 23%;
  margin: auto;
}

</style>
                        <!--Modal: Login with Avatar Form-->
                            <div class="modal fade" id="modalLoginAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                 aria-hidden="true">
                                <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document" style="width: 700px;height: auto;">

                                     <form class="form-horizontal" action="{{route('book-handyman')}}" id="form" method="POST" enctype="multipart/form-data">


                                           <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                                            <input type="hidden" name="handyman_id" id="handyman_id" value="{{$id}}">
                                    <!--Content-->
                                    <div class="modal-content" style="height: 100%;display: flex;">

                                        <!--Header-->
                                        <div class="modal-header">

                                             @if($bookings == '')

                                             <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG" alt="avatar" class="rounded-circle img-responsive" style="border-radius: 50%!important;height: 120px;">


                                             @else

                                             <img src="{{ $user->photo ? asset('assets/images/'.$user->photo):asset('assets/default.jpg')}}" alt="avatar" class="rounded-circle img-responsive" style="border-radius: 50%!important;height: 120px;">

                                             @endif

                                        </div>

                                        <!--Body-->

                                        <div class="modal-body text-center mb-1" style="width: 65%;">

                                            <h2 class="mt-1 mb-2">{{$user->name}} {{$user->family_name}}</h2>

                                            <div class="md-form" style="margin-top: 65px;">

                                                <div class="form-group" style="width: 100%;margin-right: 0px;margin-left: 0;"><div class="input-group">

                                                        <div class="input-group-addon">
                                                            <i class="fa fa-fw fa-calendar"></i>
                                                        </div>

                                                        <input placeholder="Selected date and time" name="date" type="text" id='datetimepicker4'  class="form-control" onkeydown="return false;" autocomplete="off"  style="width: 95%;padding-left: 15px;border: 1px solid #ced4da;margin: 0;" required>

                                                    </div>
                                                </div>
                                            </div>


                                            <input type="hidden" name="service" id="service"  class="form-control form-control-sm service" required>

                                            <input type="hidden" name="noUpdate" id="noUpdate"  class="form-control form-control-sm service" value="0">

                                            <div class="md-form ml-0 mr-0" style="margin-top: 50px;">

                                                <div class="form-group" style="width: 100%;margin-right: 0px;margin-left: 0;">

                                                    <div class="col-sm-12" style="padding-left: 0;padding-right: 0;">

                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fas fa-hammer"></i>
                                                            </div>

                                                            <input type="text" id="main_service" readonly placeholder="Main Service" class="form-control" style="width: 95%;padding-left: 15px;border: 1px solid #ced4da;margin: 0;">

                                                        </div>
                                                    </div>

                                                    <div class="col-sm-12" style="padding-right: 0;padding-left: 0;margin-top: 50px;">

                                                        <div class="input-group">
                                                            <div class="input-group-addon">
                                                                <i class="fa fa-fw fa-tags"></i>
                                                            </div>

                                                            <input type="text" id="main_price" readonly placeholder="Main Service Price" class="form-control" style="width: 95%;padding-left: 15px;border: 1px solid #ced4da;margin: 0;">

                                                        </div>
                                                    </div>

                                                    <dfn style="right: -258px;top:-75px;position:relative;display:inline-block;" data-info="" id="main_description"><span class="ui-close"  style="margin:0;position:relative;padding: 7px 14px;background-color: #febb22 !important;font-family: monospace;">i</span></dfn>

                                                </div>
                                            </div>

                                            <div class="md-form ml-0 mr-0" id="rqb" style="margin-top: 30px;">

                                                <div class="form-group" style="width: 100%;margin-right: 0px;margin-left: 0;">

                                                    <div class="input-group">

                                                        <div class="input-group-addon">
                                                            <i class="fa fa-fw fa-sort"></i>
                                                        </div>

                                                        <input type="number" onkeypress="return event.charCode >= 48 && event.charCode <= 57" name="rate" id="rate" autocomplete="off" placeholder="Rate" class="form-control" style="width: 95%;padding-left: 15px;border: 1px solid #ced4da;margin: 0;" required>
                                                        <input type="hidden" name="rate_id" id="rate_id" class="form-control">
                                                        <input type="hidden" name="service_rate" id="service_rate" class="form-control">
                                                        <input type="hidden" name="service_questions" id="service_questions" class="form-control">
                                                        <input type="hidden" name="cart_count" id="cart_count" value="{{$cart_count}}" class="form-control">

                                                    </div>
                                                </div>

                                            </div>


                                            <div class="md-form ml-0 mr-0" >

                                                <div class="add-sub" style="margin-top: 75px;"></div>

                                                <div class="form-group s_box" style="margin-top: 40px;">

                                                    <label class="control-label col-sm-3" for=""></label>

                                                    <div class="col-sm-12 text-center">
                                                        <button class="btn btn-default featured-btn" type="button" name="add-field-btn" id="add-field-btn" style="font-size: 13px;background-color: #febb22 !important;"><i class="fa fa-plus" ></i> {{$lang->asst}}</button>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="md-form ml-0 mr-0" style="margin-top: 50px;margin-bottom: 45px;">
                                                <textarea name="description" id="description" placeholder="{{$lang->bdp}}" style="width: 100%;resize: vertical;padding: 10px;border-top: 1px solid #bdbdbd;"></textarea>
                                            </div>

                                            <div class="file-field" style="margin-top: 50px;">
                                                <div class="btn btn-primary btn-sm" style="width: 100%;">
                                                    <span style="font-size: 16px;">{{$lang->uit}}</span>
                                                    <input name="file[]" id="file" type="file" multiple style="font-size: 12px;padding: 20px;">
                                                </div>
                                            </div>

                                            <div class="text-center mt-4" style="margin-top: 50px;">
                                                <button type="button" class="btn btn-default" style="font-size: 15px;background-color: #febb22 !important;" id="btnclose" data-dismiss="modal">{{$lang->clt}}</button>
                                                <button type="submit" class="btn btn-cyan mt-1" style="font-size: 15px;">{{$lang->cnf_btn}} </button>
                                            </div>

                                        </div>
                                    </div>

                                     </form>
                                    <!--/.Content-->
                                </div>
                            </div>
                            <!--Modal: Login with Avatar Form-->

                            <div class="text-center" style="padding-bottom: 40px;">
                                <!-- <a href="" class="btn btn-default btn-rounded" data-toggle="modal" data-target="#modalLoginAvatar" style="font-size: 19px;">Book Now</a> -->

                                 @if($bookings != '')

                                <div class="add-area margin-bottom-30" style="margin-top: 50px;">
                                    <iframe width="340" height="350" frameborder="0" style="border:0;width: 100%;" src="https://www.google.com/maps/embed/v1/place?key={{$gs->map_key}}&q={{$user->address == null ? '@':$user->address}}" allowfullscreen></iframe>
                                </div>

                                @endif

                            </div>





{{--                        <div class="profile-contact-area margin-bottom-30" >--}}
{{--                            <h2>{{$lang->doc}}</h2>--}}
{{--                            <hr>--}}
{{--                             @include('includes.form-success')--}}
{{--                            <form action="{{route('front.user.submit')}}" method="POST">--}}
{{--                                <input type="hidden" name="to" value="{{$user->email}}">--}}
{{--                                {{csrf_field()}}--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="name">{{$lang->don}}</label>--}}
{{--                                    <input class="form-control" name="name" placeholder="" required="" type="text">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="email">{{$lang->doem}}</label>--}}
{{--                                    <input class="form-control" name="email" placeholder="" required="" type="email">--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="message">{{$lang->dom}}</label>--}}
{{--                                    <textarea name="message" class="form-control" id="message" rows="5" style="resize: vertical;" required=""></textarea>--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <button class="btn btn-primary btn-block" type="submit">{{$lang->sm}}</button>--}}
{{--                                </div>--}}
{{--                            </form>--}}
{{--                        </div>--}}

                    </div>



                    <div class="col-md-4">

                        <div class="profile-right-side">
                            @if($bookings != '')


                            <div class="profile-img">
                                <img width="130px" height="90px" id="adminimg" src="{{ $user->photo ? asset('assets/images/'.$user->photo):asset('assets/default.jpg')}}" alt="" id="adminimg">
                            </div>

                            @endif

                            <div class="profile-contact-info">
                                <h2>{{$lang->doci}}</h2>
                                <hr>

                                @if($bookings == '')

                                    <h4>{{$lang->yhtb}}</h4>


                                @else

                                <p><i class="fa fa-home fa-1x"></i>&nbsp;{{$user->address}}</p>
                                @if($user->fax != null)
                                <p><i class="fa fa-fax fa-1x"></i>&nbsp;{{$user->fax}}</p>
                                @endif
                                <p><i class="fa fa-phone fa-1x"></i>&nbsp;{{$user->phone}}</p>
                                <p><i class="fa fa-envelope fa-1x"></i>&nbsp;{{$user->email}}</p>
                                @if($user->web != null)
                                <p><i class="fa fa-globe fa-1x"></i>&nbsp;{{$user->web}}</p>
                                @endif

                                    @endif
                            </div>

                                @if($bookings != '')



                            <div class="share-profile-info" style="margin-top: 30px;padding-top: 20px;">
                                <h2>{{$lang->dosp}}</h2>
                                <hr>

                                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                    <a class="a2a_dd" href=""></a>
                                    <a class="a2a_button_facebook" href=""></a>
                                    <a class="a2a_button_twitter" href=""></a>
                                    <a class="a2a_button_google_plus" href=""></a>
                                    <a class="a2a_button_linkedin" href=""></a>
                                </div>
                                <script async src="https://static.addtoany.com/menu/page.js"></script>
                                <!-- AddToAny END -->
                            </div>

                                @endif

                        @if(!empty($ad300x250))
                        @if($ad300x250->type == "banner")
                        <br>
                        <div class="add-area margin-bottom-30">
                            <a href="{{route('front.ads',$ad300x250->id)}}">
                            <img src="{{  asset('assets/images/'.$ad300x250->photo) }}" alt="{{$ad300x250->alt}}">
                            </a>
                        </div>
                        @else
                            {!! $ad300x250->script !!}
                        @endif
                        @endif



                        </div>

                    </div>
                </div>
            </div>
        </div>

<style type="text/css">

    @media only screen and (max-width: 550px){

        .modal-dialog
        {

            width: 90% !important;
        }
    }

    .pulse_start{
  animation: pulse 1s;
  animation-timing-function: linear;
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(2.1);
  100% { transform: scale(2); }
  }
}


    .icon
    {
        width: 11% !important;
    }




@media (max-width: 768px){
.wrapper{

    float: none !important;
    margin: auto !important;
    width: 70%;
}


}

    @media (max-width: 600px){
        .wrapper{

            width: 90%;
            height: 585px;
        }

        .icon {

            width: 13% !important;
        }
    }





@media (min-width: 1390px)
{
  .container{
    width: 90%;
  }
}


@media (min-width: 1700px)
{
  .container{
    width: 80%;
  }
}

button[type="submit"]:hover
{
    border: none !important;

}

</style>


    <script src="https://malsup.github.io/jquery.form.js"></script>

    <script type="text/javascript">

        $("#add-field-btn").on('click',function() {

            var parent = this;
            var service = $('#service').val();
            var handyman_id = $('#handyman_id').val();
            var options = "";

            $.ajax({
                type:"GET",
                data: "handyman_id=" + handyman_id + "&service=" + service,
                url: "<?php echo url('/user-subservices')?>",
                success: function(data) {

                    $.each(data, function(index, value) {

                            <?php if($lang->lang == 'eng'){ ?>

                        var opt = '<option value="'+value.id+'" >'+value.cat_slug+'</option>';

                            <?php } else { ?>

                        var opt = '<option value="'+value.id+'" >'+value.cat_name+'</option>';

                        <?php } ?>

                            options = options + opt;

                    });


                    $(parent).parent().parent().parent().children('.add-sub').append('<div class="form-group" style="margin-bottom:45px;">'+
                        '<div class="col-sm-12"><h5 style="font-weight: bold;text-align:left;margin-bottom:22px;"><?php echo $lang->msnt; ?></h5><div class="input-group"><div class="input-group-addon"><i class="fas fa-hammer"></i></div><select class="js-data-example-ajax sub_service" style="width:100%;padding:10px;" name="sub_service[]" id="sub_service" required><option value=""><?php echo $lang->ssstf; ?></option>'+options+'</select></div></div>'+
                        '<div class="col-sm-12" id="service_rate_box" style="margin-top:20px;"><h5 style="font-weight: bold;text-align:left;margin-bottom:22px;margin-top:10px;"><?php echo $lang->mput; ?></h5><div class="input-group"><div class="input-group-addon"><i class="fa fa-fw fa-tags"></i></div><p style="width:100%;height:27px;border:1px solid #a9a9a9;margin:0;" id="sub_type">{{$lang->sr}}</p><input type="hidden" class="sub_rate_id" name="sub_rate_id[]" id="sub_rate_id" ><input class="sub_service_rate" type="hidden" name="sub_service_rate[]" id="sub_service_rate" ></div></div>'+
                        '<div class="col-sm-12" id="rate_box" style="margin-top:20px;"><h5 style="font-weight: bold;text-align:left;margin-bottom:22px;margin-top:10px;"><?php echo $lang->mrt; ?></h5><div class="input-group"><div class="input-group-addon"><i class="fa fa-fw fa-sort"></i></div><input type="number" class="sub_rate" placeholder="{{$lang->mrt}}" required style="width: 96%;height:22.9999999px;padding-left: 15px;border: 1px solid #ced4da;margin: 0;" id="sub_rate" name="sub_rate[]"></div></div>'+
                        '<span class="ui-close remove-ui1"  style="margin:0;left:-285px;top:-130px;position:relative;padding:7.5px 13px;padding-top:5px;font-family: monospace;">x</span>'+
                        '<dfn style="right: -258px;top:-135px;position:relative;display:inline-block;" data-info="" id="sub_description"><span class="ui-close"  style="margin:0;position:relative;padding: 7px 14px;background-color: #febb22 !important;font-family: monospace;">i</span></dfn>'+
                        '</div>');

                    var $selects = $('.js-data-example-ajax').change(function() {

                        var id = this.value;
                        var handyman_id = $('#handyman_id').val();
                        var service = $('#service').val();
                        var selector = this;

                        if ($selects.find('option[value=' + id + ']:selected').length > 1) {

                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: '<?php echo $lang->sast; ?>',
                            });

                            this.options[0].selected = true;
                            $(selector).val('');
                        }

                        if(id)
                        {

                            $.ajax({
                                type:"GET",
                                data: "id=" + id + "&handyman_id=" + handyman_id + "&main=" + service,
                                url: "<?php echo url('/sub-services')?>",

                                success: function(data) {

                                    if(data.type == "Per Hour Rate"){

                                        var type = <?php echo "'".$lang->servT1."'" ?>;
                                        var text = <?php echo "'".$lang->servP1."'" ?>;

                                    }

                                    else if(data.type == "Per Meter Rate")
                                    {

                                        var type = <?php echo "'".$lang->servT2."'" ?>;
                                        var text = <?php echo "'".$lang->servP2."'" ?>;

                                    }

                                    else if(data.type == "Per Foot Rate")
                                    {

                                        var type = <?php echo "'".$lang->servT3."'" ?>;
                                        var text = <?php echo "'".$lang->servP3."'" ?>;

                                    }

                                    else if(data.type == "Per Piece Rate")
                                    {

                                        var type = <?php echo "'".$lang->servT4."'" ?>;
                                        var text = <?php echo "'".$lang->servP4."'" ?>;

                                    }

                                    else
                                    {

                                        var type = "";
                                        var text = "";

                                    }


                                    $(selector).parent().parent().parent().children('#service_rate_box').children().children("#sub_type").text("€ " + data.rate + " - " + type);
                                    $(selector).parent().parent().parent().children('#service_rate_box').children().children("#sub_rate_id").val(data.rate_id);
                                    $(selector).parent().parent().parent().children('#service_rate_box').children().children("#sub_service_rate").val(data.rate);
                                    $(selector).parent().parent().parent().children('#rate_box').children().children("#sub_rate").attr("placeholder", text);
                                    $(selector).parent().parent().parent().children('#sub_description').attr("data-info", data.description);

                                }
                            });
                        }
                    });
                }
            });
        });


        $(document).on('click', '.remove-ui1' ,function() {

            var parent = this.parentNode;
            $(parent).hide();
            $(parent).remove();

        });


        $('.openModal').click(function(){

            $('#rate').val("");
            $('#description').val("");
            $('#file').val("");
            $('.add-sub').html("");
            $('#main_service').val("");
            $('#main_price').val("");
            $('#main_description').attr("data-info","");

            var cart_count = $('#cart_count').val();
            var noUpdate = $('#noUpdate').val();

            if(noUpdate == 1)
            {

                $('#datetimepicker4').attr("readonly",true);

            }
            else
            {

                if(cart_count != 0)
                {
                    $('#datetimepicker4').attr("readonly",true);
                    $('#datetimepicker4').val(<?php echo "'".$booking_date."'"; ?>);
                }

            }

            var id  = $(this).attr('data-value');
            var type  = $(this).attr('data-type');
            var s_id  = $(this).attr('data-service');
            var rate  = $(this).attr('data-rate');
            var questions  = $(this).attr('data-questions');
            var main =  $(this).attr('data-main');
            var stype = $(this).attr('data-stype');
            var description = $(this).attr('data-description');

            $('#service').val(id);
            $('#rate').attr("placeholder", type);
            $('#rate_id').val(s_id);
            $('#service_rate').val(rate);
            $('#service_questions').val(questions);
            $('#main_service').val(main);
            $('#main_price').val("€ " + rate + " - " + stype);
            $('#main_description').attr("data-info",description);

            $('#question_box').remove();
            $('#question_box1').remove();

            if(questions == 1)
            {
                $('#rqb').append('<div class="form-group" id="question_box" style="width: 100%;margin-right: 0px;margin-left: 0;margin-top: 50px;">\n' +
                    '                                                    <div class="col-sm-12" style="padding: 0;">\n' +
                    '\n' +
                    '                                                        <h5 style="font-weight: bold;text-align:left;">Purpose</h5>\n' +
                    '\n' +
                    '                                                        <div class="input-group" style="width: 100%;">\n' +
                    '                                                            <select class="js-data-example-ajax" style="width:100%;padding:10px;" name="purpose" id="purpose" required>\n' +
                    '                                                                <option value="">Select Purpose</option>\n' +
                    '                                                                <option value="1">Business</option>\n' +
                    '                                                                <option value="2">Private</option>\n' +
                    '                                                            </select>\n' +
                    '                                                        </div>\n' +
                    '\n' +
                    '                                                    </div>\n' +
                    '                                                </div>');

                $('#purpose').change(function() {

                    var purpose = $('#purpose').val();

                    if(purpose == 2)
                    {
                        $('#rqb').append('<div class="form-group" id="question_box1" style="width: 100%;margin-right: 0px;margin-left: 0;margin-top: 50px;">\n' +
                            '                                                    <div class="col-sm-12" style="padding: 0;">\n' +
                            '\n' +
                            '                                                        <h5 style="font-weight: bold;text-align:left;">How old is your house is?</h5>\n' +
                            '\n' +
                            '                                                        <div class="input-group" style="width: 100%;">\n' +
                            '                                                            <select class="js-data-example-ajax" style="width:100%;padding:10px;" name="purpose_type" id="purpose_type" required>\n' +
                            '                                                                <option value="1">Less than 2 years</option>\n' +
                            '                                                                <option value="2">More than 2 years</option>\n' +
                            '                                                            </select>\n' +
                            '                                                        </div>\n' +
                            '\n' +
                            '                                                    </div>\n' +
                            '                                                </div>');
                    }
                    else
                    {
                        $('#question_box1').remove();
                    }

                });
            }

        });


        $("#form").submit(function(e){

            e.preventDefault();

            var fd = new FormData();
            var date = $('#datetimepicker4').val();
            var service = $('#service').val();
            var rate = $('#rate').val();
            var service_questions = $('#service_questions').val();
            var purpose = $('#purpose').val();
            var purpose_type = $('#purpose_type').val();
            var rate_id = $('#rate_id').val();
            var service_rate = $('#service_rate').val();
            var handyman_id = $('#handyman_id').val();
            var description = $('#description').val();
            var token = $('#token').val();
            var subs_length = $('.sub_service').length;
            var length = $('#file')[0].files.length;


            fd.append("handyman_id",handyman_id);
            fd.append("date",date);
            fd.append("service",service);
            fd.append("rate",rate);
            fd.append("service_questions",service_questions);
            fd.append("purpose",purpose);
            fd.append("purpose_type",purpose_type);
            fd.append("rate_id",rate_id);
            fd.append("service_rate",service_rate);
            fd.append("description",description);


            for(var i=0; i<length; i++)
            {
                var files = $('#file')[0].files[i];
                fd.append('file[]',files);
            }

            for(var i=0; i<subs_length; i++)
            {

                var sub_service = $('.sub_service').eq(i).val();
                fd.append('sub_service[]',sub_service);

                var sub_rate_id = $('.sub_rate_id').eq(i).val();
                fd.append('sub_rate_id[]',sub_rate_id);

                var sub_rate = $('.sub_rate').eq(i).val();
                fd.append('sub_rate[]',sub_rate);

                var sub_service_rate = $('.sub_service_rate').eq(i).val();
                fd.append('sub_service_rate[]',sub_service_rate);

            }

            $.ajax({

                beforeSend: function(){
                    $('.modal').modal('hide');
                    $('.ajax-loader').css("visibility", "visible");

                },

                url: "<?php echo url('/handyman/add-cart') ?>",
                type: 'post',
                data: fd,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': token,
                },
                success: function ( data ) {

                    $('html, body').animate({
                        scrollTop: $("html").offset().top
                    }, 2000);

                    $('.modal').modal('hide');

                    if(data.type == 1)
                    {

                        $('#errmsg').html(data.msg).fadeIn('slow');
                        //$('#msg').html("data insert successfully").fadeIn('slow') //also show a success message
                        $('#errmsg').delay(5000).fadeOut('slow');
                    }
                    else
                    {
                        $('.has-badge').addClass('pulse_start');
                        $(".has-badge").attr("data-count", data.count);
                        $('#msg').html(data.msg).fadeIn('slow');
                        //$('#msg').html("data insert successfully").fadeIn('slow') //also show a success message
                        $('#msg').delay(5000).fadeOut('slow');
                        $('#cart_count').val(data.count);
                        $('#noUpdate').val(1);
                    }

                },
                error: function(data){

                    $('html, body').animate({
                        scrollTop: $("html").offset().top
                    }, 2000);

                    $('.modal').modal('hide');
                    $('#errmsg').html(data.statusText).fadeIn('slow');
                    //$('#msg').html("data insert successfully").fadeIn('slow') //also show a success message
                    $('#errmsg').delay(5000).fadeOut('slow');

                },

                complete: function(){
                    $('.ajax-loader').css("visibility", "hidden");
                }

            });


            $('.has-badge').removeClass('pulse_start');


        });


//         var date = $('#datetimepicker4').val();
//         var service = $('#service').val();
//         var rate = $('#rate').val();
//         var rate_id = $('#rate_id').val();
//         var service_rate = $('#service_rate').val();
//         var handyman_id = $('#handyman_id').val();
//         var token = $('#token').val();


//                 $.ajax({
//                     type:"POST",
//                     data: "id=" + handyman_id + "&date=" + date + "&service=" + service + "&rate=" + rate + "&rate_id=" + rate_id + "&service_rate=" + service_rate + "&_token=" + token,
//                     url: "<?php echo url('/handyman/add-cart')?>",
//                     success: function(data) {



// //                         $.each(data, function (key, val) {

// //                         $('#rate').attr("placeholder", val.service.text);
// //                             $('#rate_id').val(val.service.id);
// //                             $('#service_rate').val(val.service_rate.rate);
// // });




// $('html, body').animate({
//     scrollTop: $("html").offset().top
// }, 2000);

// $('.modal').modal('hide');

// if(data.type == 1)
// {

//  $('#errmsg').html(data.msg).fadeIn('slow');
//      //$('#msg').html("data insert successfully").fadeIn('slow') //also show a success message
//      $('#errmsg').delay(5000).fadeOut('slow');

// }

// else
// {

//     $('.has-badge').addClass('pulse_start');
// $(".has-badge").attr("data-count", data.count);

//  $('#msg').html(data.msg).fadeIn('slow');
//      //$('#msg').html("data insert successfully").fadeIn('slow') //also show a success message
//      $('#msg').delay(5000).fadeOut('slow');

//      $('#cart_count').val(data.count);

//      $('#noUpdate').val(1);





// }





//                     },

//                     error: function(data){



// $('html, body').animate({
//     scrollTop: $("html").offset().top
// }, 2000);

// $('.modal').modal('hide');

//  $('#errmsg').html(data.statusText).fadeIn('slow');
//      //$('#msg').html("data insert successfully").fadeIn('slow') //also show a success message
//      $('#errmsg').delay(5000).fadeOut('slow');


// }

//                 });

//                 $('.has-badge').removeClass('pulse_start');


        $(document).ready(function() {

            var $selects = $('.service').change(function() {

                var id = this.value;
                var h_id = $('#handyman_id').val();
                var selector = this;

                $.ajax({
                    type:"GET",
                    data: "id=" + id + "&h_id=" + h_id,
                    url: "<?php echo url('/user-services')?>",

                    success: function(data) {

                        $.each(data, function (key, val) {

                            $('#rate').attr("placeholder", val.service.text);
                            $('#rate_id').val(val.service.id);
                            $('#service_rate').val(val.service_rate.rate);

                        });
                    }
                });
            });

            $(function () {

                var js_array = [<?php echo '"'.implode('","', array_column($dates_array, 'notAvailable_date')).'"' ?>];
                console.log(js_array);
                var datesForDisable = js_array;
                var now = new Date();

                now.setDate(now.getDate()+1);
                var year=now.getFullYear();
                var month=now.getMonth()+1 //getMonth is zero based;
                var day=now.getDate();

                formatted = ('0' + month).slice(-2) + '-'
                    + ('0' + day).slice(-2) + '-'
                    + year;

                console.log(formatted);


                function SortByDate(a, b){

                    var amyDate = a.split("-");
                    var aNewDate=new Date(amyDate[0]+"/"+amyDate[1]+"/"+amyDate[2]).getTime();
                    var bmyDate = b.split("-");
                    var bNewDate=new Date(bmyDate[0]+"/"+bmyDate[1]+"/"+bmyDate[2]).getTime();

                    return ((aNewDate < bNewDate) ? -1 : ((aNewDate > bNewDate) ? 1 : 0));
                }

                datesForDisable.sort(SortByDate);
                console.log(datesForDisable);

                for (var i = 0; i < datesForDisable.length; ++i) {

                    if (datesForDisable[i] != "") {

                        if (datesForDisable[i] == formatted) {

                            now.setDate(now.getDate() + 1);
                            var year = now.getFullYear();
                            var month = now.getMonth() + 1 //getMonth is zero based;
                            var day = now.getDate();
                            formatted = ('0' + month).slice(-2) + '-'
                                + ('0' + day).slice(-2) + '-'
                                + year;
                        }
                    }
                }


                for (var i = 0; i < datesForDisable.length; ++i) {

                    if (datesForDisable[i] != "") {

                        var dateAr = datesForDisable[i].split('-');
                        var newDate = dateAr[0] + '/' + dateAr[1] + '/' + dateAr[2].slice(-2);
                        datesForDisable[i] = newDate;

                    }
                }

                console.log(datesForDisable);
                console.log(now);

                var hours_array = [<?php echo '"'.implode('","', array_column($hours, 'notAvailable_hour')).'"' ?>];
                var hoursForDisable = hours_array;


                $('#datetimepicker4').datetimepicker({
                format: 'DD-MM-YYYY hh:mm a',
                minDate: now,
                disabledDates: datesForDisable,
                disabledHours: hoursForDisable,

                });

                $('#datetimepicker4').data('DateTimePicker').keyBinds();

            });
        });

    </script>

        <style>

            dfn {

  cursor: help;
  font-style: normal;
  position: relative;

}
dfn::after {
  content: attr(data-info);
  display: none;
  position: absolute;
  top: 22px; left: 0;
  opacity: 0;
  width: 230px;
  font-size: 13px;
  font-weight: 700;
  line-height: 1.5em;
  padding: 0.5em 0.8em;
  background: rgba(0,0,0,0.8);
  color: #fff;
  pointer-events: none; /* This prevents the box from apearing when hovered. */
  transition: opacity 250ms, top 250ms;
}
dfn::before {
  content: '';
  display: none;
  position: absolute;
  top: 12px; left: 20px;
  opacity: 0;
  width: 0; height: 0;
  border: solid transparent 5px;
  border-bottom-color: rgba(0,0,0,0.8);
  transition: opacity 250ms, top 250ms;
}
dfn:hover {z-index: 2;} /* Keeps the info boxes on top of other elements */
dfn:hover::after,
dfn:hover::before {opacity: 1;display:inline;}
dfn:hover::after {top: 45px;}
dfn:hover::before {top: 35px;}

        .bootstrap-datetimepicker-widget table td.disabled  {
            background: rgb(255, 166, 166) !important;
            color: black;
            border-radius: 0;


        }

        .bootstrap-datetimepicker-widget table td.disabled:not(.old):hover:before {
    content: <?php echo "'".$lang->nad."'" ?>;
    cursor: not-allowed !important;
    font-size: 12px;
    color: red;
    background-color: white;
    position: absolute;
    width: 150px;
    z-index: 1000;
    text-align: center;
    padding: 2px;
}



        .disabled, :disabled{

            pointer-events: auto !important;
        }


.bootstrap-datetimepicker-widget table td, .bootstrap-datetimepicker-widget table th
{

    border-radius: 0;

}




            table td{
                font-size: 1.2rem;
            }

            .table-condensed th{

                font-size: 14px;
            }

            .table-condensed .btn{
                font-size: 14px;
                background-color: white;
                box-shadow: none;
            }

            .table-condensed .btn:active, .btn:focus, .btn:hover
            {
                box-shadow: none;
            }

            .bootstrap-datetimepicker-widget table td.day
            {
                color: #3a3939;
                font-weight: 500;

            }



        </style>


@endsection
