@extends('layouts.admin')

@section('styles')

<link href="{{asset('assets/admin/css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">
<link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">

@endsection

@section('content')

<div class="right-side">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <!-- Starting of Dashboard area -->
                        <div class="section-padding add-product-1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="add-product-box">
                                        <div class="add-product-header">
                                            <h2>Edit Handyman</h2>
                                            <a href="{{route('admin-user-index')}}" class="btn add-back-btn"><i class="fa fa-arrow-left"></i> Back</a>
                                        </div>
                                        <hr>
                                        <form class="form-horizontal" action="{{route('admin-user-update',$user->id)}}" method="POST" enctype="multipart/form-data">
                                          @include('includes.form-error')
                                          @include('includes.form-success')
                                          {{csrf_field()}}
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_full_name">Full Name*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="name" id="edit_full_name" placeholder="Enter Full Name" required="" type="text" value="{{$user->name}}">
                                            </div>
                                          </div>
                                          {{--<div class="form-group" style="display: none;">
                                            <label class="control-label col-sm-4" for="edit_blood_group">Category*</label>
                                            <div class="col-sm-6">
                                              <select class="form-control" name="category_id" id="edit_blood_group" required="">
                                                  <option value="">Select Category</option>
                                                  @foreach($cats as $cat)
                                                      <option value="{{$cat->id}}" {{$cat->cat_name == $user->category->cat_name?"selected":""}}>{{$cat->cat_name}}</option>
                                                  @endforeach
                                              </select>
                                            </div>
                                          </div>--}}
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_current_photo">Current Photo*</label>
                                            <div class="col-sm-6">

                                              <img width="130px" height="90px" id="adminimg" src="{{ $user->photo ? asset('assets/images/'.$user->photo):'https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcSCM_FnlKpZr_N7Pej8GA40qv63zVgNc0MFfejo35drsuxLUcYG'}}" alt="" id="adminimg">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_profile_photo">Profile Photo *</label>
                                            <div class="col-sm-6">
                                    <input type="file" id="uploadFile" class="hidden" name="photo" value="">
                                              <button type="button" id="uploadTrigger" onclick="uploadclick()" class="form-control"><i class="fa fa-download"></i> Edit Profile Photo</button>
                                              <p>Prefered Size: (600x600) or Square Sized Image</p>
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_profile_description">Profile Description*</label>
                                            <div class="col-sm-6">
                                              <textarea class="form-control" name="description" id="edit_profile_description" rows="5" style="resize: vertical;" placeholder="Enter Profile Description">{{$user->description}}</textarea>
                                            </div>
                                          </div>

                                         <div class="form-group">
                                            <label class="control-label col-sm-4" for="phone">Specialities * <span>Separated By Comma (,)</span></label>
                                            <div class="col-sm-6">
                                              <ul id="myTags">
                                              @if($specials)
                                              @foreach($specials as $parea)
                                              <li>{{$parea}}</li>
                                              @endforeach
                                              @endif
                                              </ul>
                                            </div>
                                          </div>

                          <div class="profile-filup-description-box margin-bottom-30" style="display: none;">
                            <h2 class="text-center">{{$lang->md}}</h2>
                            <div class="qualification" id="q">
                              @if($user->title!=null && $user->details!=null)
                              @foreach(array_combine($title,$details) as $ttl => $dtl)
                              <div class="qualification-area">
                                  <div class="form-group">
                                      <div class="col-sm-5 col-md-offset-1">
                                        <input class="form-control" name="title[]" id="title" placeholder="{{$lang->dttl}}" type="text" value="{{$ttl}}">
                                      </div>
                                      <div class="col-sm-5">
                                        <input class="form-control" name="details[]" id="text_details" placeholder="{{$lang->ddesc}}" type="text" value="{{$dtl}}">
                                      </div>
                                </div>
                                <span class="ui-close">X</span>
                              </div>
                              @endforeach
                              @else
                              <div class="qualification-area" >
                                  <div class="form-group">
                                      <div class="col-sm-5 col-md-offset-1">
                                        <input class="form-control" name="title[]" id="title" placeholder="{{$lang->dttl}}" type="text" value="">
                                      </div>
                                      <div class="col-sm-5">
                                        <input class="form-control" name="details[]" id="text_details" placeholder="{{$lang->ddesc}}" type="text">
                                      </div>
                                </div>
                                <span class="ui-close" id="parentclose">X</span>
                              </div>
                              @endif

    </div>
                            <div class="form-group">
                                <label class="control-label col-sm-3" for=""></label>
                                <div class="col-sm-12 text-center">
                                  <input type="hidden" id="tttl" value="{{$lang->dttl}}">
                                  <input type="hidden" id="dddc" value="{{$lang->ddesc}}">
                                  <button class="btn btn-default featured-btn" type="button" name="add-field-btn" id="add-field-btn"><i class="fa fa-plus"></i> {{$lang->amf}}</button>
                                </div>
                              </div>
                          </div>


                          <br>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_language">Language*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="language" id="edit_language" placeholder="Enter Language" required="" type="text" value="{{$user->language}}">
                                            </div>
                                          </div>
                                          <div class="form-group" style="display: none;">
                                            <label class="control-label col-sm-4" for="edit_age">Age*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="age" id="edit_age" placeholder="Enter Age"  type="text" value="0">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_education">Education*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="edit_education" id="education" placeholder="Enter Education" required="" type="text" value="{{$user->education}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_residency">Residency*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="residency" id="edit_residency" placeholder="Enter Residency" required="" type="text" value="{{$user->residency}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_profession">Profession</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="profession" id="edit_profession" placeholder="Enter Profession" required="" type="text"  value="{{$user->profession}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_city">City</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="city" id="edit_city" placeholder="Enter City" required="" type="text"  value="{{$user->city}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_address">Address*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="address" id="edit_address" placeholder="Enter Address" required="" type="text" value="{{$user->address}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="edit_phone">Phone*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="phone" id="edit_phone" placeholder="Enter Phone" required="" type="text" value="{{$user->phone}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="fax">Fax*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="fax" id="edit_fax" placeholder="Enter Fax" type="text" value="{{$user->fax}}">
                                            </div>
                                          </div>
                                       <div class="form-group">
                                            <label class="control-label col-sm-4" for="ff">Facebook Profile Link*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="f_url" id="ff" placeholder="Enter Facebook Profile Link"  type="text" value="{{$user->f_url}}">
                                            </div>
                                          </div>
                                      <div class="form-group">
                                            <label class="control-label col-sm-4" for="tt">Twitter Profile Link*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="t_url" id="tt" placeholder="Enter Twitter Profile Link"  type="text" value="{{$user->t_url}}">
                                            </div>
                                          </div>
                                      <div class="form-group">
                                            <label class="control-label col-sm-4" for="gg">Google+ Profile Link*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="g_url" id="gg" placeholder="Enter Google+ Profile Link"  type="text" value="{{$user->g_url}}">
                                            </div>
                                          </div>
                                      <div class="form-group">
                                            <label class="control-label col-sm-4" for="li">Linkedin Profile Link*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="l_url" id="li" placeholder="Enter Linkedin Profile Link"  type="text" value="{{$user->l_url}}">
                                            </div>
                                          </div>
                                          <div class="form-group">
                                            <label class="control-label col-sm-4" for="email">Website*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="web" id="email" placeholder="Enter Website" type="text" value="{{$user->web}}">
                                          </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-4" for="pass">Password*</label>
                                            <div class="col-sm-6">
                                              <input class="form-control" name="password" id="pass" placeholder="Enter Password"  type="password">
                                            </div>                                              </div>
                                         <div class="form-group" style="display: none;">
                                            <label class="control-label col-sm-4" for="check1"></label>
                                            <div class="col-sm-6">
<div class="btn btn-default checkbox1">
                                    <input type="checkbox" id="check1" name="featured" value="1"  {{$user->featured == 1 ? "checked":"" }}>
                                    <label for="check1">Add to Featured Handyman</label>
                                  </div>
                                            </div>                                              </div>
                                            <hr>
                                            <div class="add-product-footer">
                                                <button name="addProduct_btn" type="submit" class="btn add-product_btn">Update Handyman</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <!-- Ending of Dashboard area -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')

<script type="text/javascript" src="{{asset('assets/admin/js/nicEdit.js')}}"></script>
<script type="text/javascript">
//<![CDATA[
        bkLib.onDomLoaded(function() { nicEditors.allTextAreas() });
  //]]>
</script>

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

    $("#add-field-btn").on('click',function() {
      var title = $('#tttl').val();
      var desc = $('#dddc').val();

        $(".qualification").append('<div class="qualification-area">'+
                '<div class="form-group">'+
                 '<div class="col-sm-5 col-md-offset-1">'+
'<input type="text" class="form-control" name="title[]" id="title" placeholder="'+title+'" required="">'+
                   '</div>'+
                   '<div class="col-sm-5">'+
'<input type="text" class="form-control" name="details[]" id="text_details" placeholder="'+desc+'" required="">'+
                  '</div>'+
                  '</div>'+
                  '<span class="ui-close">X</span>'+
                 '</div>');

    });

  function isEmpty(el){
      return !$.trim(el.html())
  }


  $(document).on('click', '.ui-close' ,function() {
    $(this.parentNode).hide();
    $(this.parentNode).remove();
    if (isEmpty($('#q'))) {
      var title = $('#tttl').val();
      var desc = $('#dddc').val();
        $(".qualification").append('<div class="qualification-area">'+
                '<div class="form-group">'+
                 '<div class="col-sm-5 col-md-offset-1">'+
'<input type="text" class="form-control" name="title[]" id="title" placeholder="'+title+'">'+
                   '</div>'+
                   '<div class="col-sm-5">'+
'<input type="text" class="form-control" name="details[]" id="text_details" placeholder="'+desc+'">'+
                  '</div>'+
                  '</div>'+
                  '<span class="ui-close">X</span>'+
                 '</div>');
    }
  });



</script>

<script src="{{asset('assets/admin/js/jquery152.min.js')}}"></script>
<script src="{{asset('assets/admin/js/jqueryui.min.js')}}"></script>
<script src="{{asset('assets/admin/js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>



<script type="text/javascript">
    $(document).ready(function() {
        $("#myTags").tagit({
          fieldName: "special[]",
          allowSpaces: true
        });
    });
</script>

@endsection
