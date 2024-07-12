@extends('Admin.layout.main')
@section('title')
Video Tutorials
@endsection
@section('styles')
<style>
    .api-key-input{
        padding-left: 10px!important;
        padding-right: 5px!important;
    }
    .api-password-input{
        text-align: left!important;
    }
    .caption {
        padding: 8px 13px 4px;
        background: #ffcb05;
        color: #000;
        font-weight: 600;
    }
    .thumbnail {
         border-radius: 10px;
    }
</style>
@endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3> Tutorials <small> Videos</small> </h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Tutorials <small> Videos </small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <!-- <div class="col-md-4">
                        <div class="thumbnail" style="height: 260px;">
                          <div class="image view view-first" style="height: 185px;">
                            <video style="width: 100%; display: block;" controls controlsList="nodownload">
                              <source src="https://www.leopardscourier.com/cod_videos/Ecom-Portal-Video.mp4" type="video/mp4">
                              Your browser does not support the video tag.
                            </video>
                          </div>
                          <div class="caption">
                            <p>1 - Ecom Portal Video</p>
                          </div>
                        </div>
                      </div> -->
                      <!-- <div class="col-md-4">
                        <div class="thumbnail" style="height: 260px;">
                          <div class="image view view-first" style="height: 185px;">
                            <video style="width: 100%; display: block;" controls controlsList="nodownload">
                              <source src="https://www.leopardscourier.com/cod_videos/How-to-generate-load-sheet.mp4" type="video/mp4">
                              Your browser does not support the video tag.
                            </video>
                          </div>
                          <div class="caption">
                            <p>2 - How to generate load sheet</p>
                          </div>
                        </div>
                      </div> -->
                      <div class="col-md-4">
                        <div class="thumbnail" style="height: 260px;">
                          <div class="image view view-first" style="height: 185px;">
                            <video style="width: 100%; display: block;" controls controlsList="nodownload">
                              <source src="https://www.leopardscourier.com/cod_videos/How-to-do-CSV-or-bulk-booking.mp4" type="video/mp4">
                              Your browser does not support the video tag.
                            </video>
                          </div>
                          <div class="caption">
                            <p>1 - How To Assign Course</p>
                          </div>
                        </div>
                      </div>
                      <!-- <div class="col-md-4">
                        <div class="thumbnail" style="height: 260px;">
                          <div class="image view view-first" style="height: 185px;">
                            <video style="width: 100%; display: block;" controls controlsList="nodownload">
                              <source src="https://www.leopardscourier.com/cod_videos/API-Documentation.mp4" type="video/mp4">
                              Your browser does not support the video tag.
                            </video>
                          </div>
                          <div class="caption">
                            <p>4 - API Documentation</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="thumbnail" style="height: 260px;">
                          <div class="image view view-first" style="height: 185px;">
                            <video style="width: 100%; display: block;" controls controlsList="nodownload">
                              <source src="https://www.leopardscourier.com/cod_videos/Report-Manager.mp4" type="video/mp4">
                              Your browser does not support the video tag.
                            </video>
                          </div>
                          <div class="caption">
                            <p>5 - Report Manager</p>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="thumbnail" style="height: 260px;">
                          <div class="image view view-first" style="height: 185px;">
                            <video style="width: 100%; display: block;" controls>
                              <source src="https://www.leopardscourier.com/cod_videos/Shipper-Advice.mp4" type="video/mp4" controlsList="nodownload">
                              Your browser does not support the video tag.
                            </video>
                          </div>
                          <div class="caption">
                            <p>6 - Shipper Advice</p>
                          </div>
                        </div>
                      </div> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>

    <!-- /page content -->
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.9-1/crypto-js.js"></script>

<script>

    const token = getToken();
    const getUserData = JSON.parse(getUser());

    const headers = {
        "Authorization": `Bearer ${token}`
    };

    function key_gen(){
        var currentTimestamp = Math.floor(Date.now() / 1000);
        var key = (CryptoJS.MD5(getUserData.id).toString() + currentTimestamp).toUpperCase();
        // $('#key-gen').val("<?php echo strtoupper(md5(auth()->user()->id. time())); ?>");
        $('#key-gen').val(key);
    }
    function checkPassword(){
        if($('#api_password_confirm').val()!=''){
            if($('#api_password').val() != $('#api_password_confirm').val()){
                $('#api_password_confirm').attr('style','border-color:red;text-transform:uppercase');
            //  alert("password should be same");
            }
            else{
                $('#api_password_confirm').attr('style','text-transform:uppercase');
            }
        }
    }

</script>
@endsection
