@extends('layouts.front')
@section('content')
<div class="section-padding contact-area-wrapper wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-title pb_50 text-center">
                            <h2>{{$lang->contacts}}</h2>

                            <div class="section-borders">
                                <span></span>
                                <span class="black-border"></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 col-sm-7">
                        <h3>{{$ps->contact_title}}</h3>
                        <p>{{$ps->contact_text}}</p>
                        <div class="comments-area">
                            <div class="comments-form">
                                <form action="{{route('front.contact.submit')}}" id="contform" method="POST">
                                    {{csrf_field()}}
                                <!-- Success message -->
                                        @include('includes.form-success')
                                <input type="hidden" name="to" value="{{$ps->contact_email}}">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input name="name" placeholder="{{$lang->con}}" required="" type="text">
                                        </div>
                                        <div class="col-md-6">
                                            <input name="phone" placeholder="{{$lang->cop}}" type="tel">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input name="email" placeholder="{{$lang->coe}}" required="" type="email">
                                        </div>
                                    </div>
                                    <p><textarea name="text" id="comment" placeholder="{{$lang->cor}}" cols="30" rows="10" style="resize: vertical;" required=""></textarea></p>

                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 col-xs-6">
                                            <img id="codeimg" src="{{url('assets/images')}}/capcha_code.png">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-2">
                                            <span style="cursor: pointer;" class="refresh_code"><i class="fa fa-refresh fa-2x" style="margin-top: 10px;"></i></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6 col-xs-8">

                                            <input name="codes" placeholder="Enter Code" required="" type="text">
                                        </div>
                                    </div>
                                    <input name="contact_btn" value="Send Message" type="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-1 col-sm-5">
                        <div class="contact-info padding-top-100">
                             @if($gs->street != null)
                          <p class="contact-info">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                              {!! $gs->street !!}
                            </p>
                            @endif

                            @if($gs->phone != null || $gs->fax != null )
                            <p class="contact-info">

                                 <i class="fa fa-phone" aria-hidden="true"></i>
                                @if($gs->phone != null && $gs->fax != null)
                                <a href="tel:{{$gs->phone}}">+{{$gs->phone}}</a>
                                <br>
                                <a href="tel:{{$gs->fax}}">+{{$gs->fax}}</a>
                                @elseif($gs->phone != null)
                            <a href="tel:{{$gs->phone}}">+{{$gs->phone}}</a>

                                @else($gs->fax != null)
                                <a href="tel:{{$gs->fax}}">+{{$gs->fax}}</a>
                                @endif

                            </p>
                            @endif

                            @if($gs->site != null || $gs->email != null )
                            <p class="contact-info">
                                <i class="fa fa-globe" aria-hidden="true"></i>
                                @if($gs->site != null && $gs->email != null)
                                <a href="{{$gs->site}}">{{$gs->site}}</a>
                                <br>
                                <a href="mailto:{{$gs->email}}">{{$gs->email}}</a>
                                @elseif($gs->site != null)
                                <a href="{{$gs->site}}">{{$gs->site}}</a>
                                @else
                                <a href="mailto:{{$gs->email}}">{{$gs->email}}</a>
                                @endif
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
    <script>
        $('.refresh_code').click(function () {
            $.get('{{url('handyman/refresh_code')}}', function(data, status){
                $('#codeimg').attr("src","{{url('assets/images')}}/capcha_code.png?time="+ Math.random());
            });
        })
    </script>
@stop
