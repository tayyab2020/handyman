@extends('layouts.client')

@section('styles')

<link href="{{asset('assets/admin/css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">

  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>



@endsection

@section('content')


    <div class="right-side">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <!-- Starting of Dashboard header items area -->
                    <div class="panel panel-default admin">
                        <div class="panel-heading admin-title">{{$lang->edit}}</div>

                    </div>
                    <!-- Ending of Dashboard header items area -->

                    <!-- Starting of Dashboard Top reference + Most Used OS area -->
                    <div class="reference-OS-area">
<div class="donors-profile-top-bg overlay text-center wow fadeInUp" style="background-image: url({{asset('assets/images/'.$gs->c_dashbg)}}); visibility: visible; animation-name: fadeInUp;z-index: auto;color: black;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2>{{$user->name}} {{$user->family_name}}</h2>

                    </div>
                </div>
            </div>
        </div>

<div class="profile-fillup-wrap wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <form class="form-horizontal" id="form" action="{{route('client-profile-update',$user->id)}}" method="POST" enctype="multipart/form-data">
                            @include('includes.form-success')
                            @include('includes.form-error')
                            {{csrf_field()}}            
                            <div class="profile-filup-description-box margin-bottom-30">
                              <div class="form-group">
                                <label for="first_name" class="col-sm-3 control-label">{{$lang->suf}}*</label>
                                <div class="col-sm-8">
                                  <input class="form-control" id="first_name" name="name" placeholder="{{$lang->suf}}" type="text" value="{{$user->name}}" required="">
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="family_name" class="col-sm-3 control-label">{{$lang->fn}}*</label>
                                <div class="col-sm-8">
                                  <input class="form-control" id="family_name" name="family_name" placeholder="{{$lang->fn}}" type="text" value="{{$user->family_name}}" required="">
                                </div>
                              </div>
                              
                              <div class="form-group">
                                <label for="current_photo" class="col-sm-3 control-label">{{$lang->cup}}*</label>
                                <div class="col-sm-8">
     
                                <img width="130px" height="90px" id="adminimg" src="{{ $user->photo ? asset('assets/images/'.$user->photo):asset('assets/default.jpg')}}" alt="" id="adminimg">
                                         
                                </div>
                              </div>
                              <div class="form-group">
                                <label for="profile_photo" class="col-sm-3 control-label">{{$lang->pp}}*</label>
                                <div class="col-sm-8">
                                  <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                  <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> {{$lang->app}}</button>
                                  <p>{{$lang->size}}</p>
                                </div>
                              </div>

                                <div class="form-group">
                                    <label for="address" class="col-sm-3 control-label">{{$lang->doad}}*</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="address" id="address" placeholder="{{$lang->doad}}" type="text" value="{{$user->address}}" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="postal_code" class="col-sm-3 control-label">{{$lang->pc}}</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" id="postcode" name="postcode" placeholder="{{$lang->pc}}" type="text" value="{{$user->postcode}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="city" class="col-sm-3 control-label">{{$lang->doct}}*</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="city" id="city" placeholder="{{$lang->doct}}" type="text" value="{{$user->city}}" required="">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="phone" class="col-sm-3 control-label">{{$lang->doph}}*</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="phone" id="phone" placeholder="{{$lang->doph}}" type="number" value="{{$user->phone}}" required="">
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="phone" class="col-sm-3 control-label">Email*</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="em" id="em" placeholder="Email" type="text" value="{{$user->email}}" readonly>
                                    </div>
                                </div>


                              <div class="form-group">
                                <label for="profile_description" class="col-sm-3 control-label">{{$lang->dopd}}*</label>
                                <div class="col-sm-8">
                                  <textarea class="form-control" name="description" id="profile_description" rows="5" style="resize: vertical;">{{$user->description}}</textarea>
                                </div>
                              </div>

                      
                          </div>
           



                          <div class="profile-filup-description-box margin-bottom-30" >
                            <div class="form-group" style="display: none;">
                                <label for="age" class="col-sm-3 control-label">{{$lang->doa}}*</label>
                                <div class="col-sm-8">
                                  <input class="form-control" name="age" id="age" placeholder="{{$lang->doa}}" type="text" value="{{$user->age}}" value="0" >
                                </div>
                              </div>

                              <div class="form-group">
                                <label for="business_name" class="col-sm-3 control-label">{{$lang->bn}}</label>
                                <div class="col-sm-8">
                                  <input class="form-control" id="business_name" name="business_name" placeholder="{{$lang->bn}}" type="text" value="{{$user->business_name}}">
                                </div>
                              </div>



                            <div class="form-group">
                                <label for="edu" class="col-sm-3 control-label">{{$lang->doe}}</label>
                                <div class="col-sm-8">
                                  <input class="form-control" name="education" id="edu" placeholder="{{$lang->doe}}" type="text" value="{{$user->education}}">
                                </div>
                              </div>
                            <div class="form-group">
                                <label for="lang" class="col-sm-3 control-label">{{$lang->dol}}</label>
                                <div class="col-sm-8">
                                  <input class="form-control" name="language" id="lang" placeholder="{{$lang->dol}}" type="text" value="{{$user->language}}">
                                </div>
                              </div>
                            <div class="form-group">
                                <label for="prof" class="col-sm-3 control-label">{{$lang->dopr}}</label>
                                <div class="col-sm-8">
                                  <input class="form-control" name="profession" id="prof" placeholder="{{$lang->dopr}}" type="text" value="{{$user->profession}}" >
                                </div>
                              </div>




                              <div class="form-group">
                                <label for="email" class="col-sm-3 control-label">{{$lang->doeml}}</label>
                                <div class="col-sm-8">
                                  <input class="form-control" name="web" id="email" placeholder="{{$lang->doeml}}" type="text" value="{{$user->web}}">
                                </div>
                              </div>



                          </div>




                         <div class="submit-area margin-bottom-30">
                           <div class="row">
                               <div class="col-md-8 col-md-offset-2">
                                   <div class="form-group text-center">
                                        <button class="boxed-btn blog" type="submit">{{$lang->doupl}}</button>
                                    </div>
                               </div>
                           </div>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>

                    </div></div></div></div></div>



       

    <style>

      .container
                {
                    width: 100% !important;
                }

        #edit{
            color: #fff;
            background: {{$gs->colors == null ? 'rgba(207, 55, 58, 0.70)':$gs->colors.'c2'}};

        }


    </style>

@endsection



@section('scripts')





<script type="text/javascript">






  function uploadclick(){
    $("#uploadFile").click();
    $("#uploadFile").change(function(event) {
          readURL(this);
        $("#uploadTrigger").html($("#uploadFile").val());
    });

}


    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#adminimg').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>



<script src="{{asset('assets/admin/js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>



<script type="text/javascript">
    $(document).ready(function() {
        $("#myTags").tagit({
          fieldName: "special[]",
          allowSpaces: true 
        });
    });
</script>


<style>

    .swal2-show{
        font-size: 17px;
    }
</style>


@endsection