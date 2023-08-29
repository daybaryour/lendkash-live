<!-- Edit profile -->
<div class="modal fade changePassword" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog"
    id="updateProfile" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded">
            <div class="modal-body">
                <div class="modal-heading">
                    <h2>Update Profile</h2>
                </div>
                <form action="{{URL('admin/update-profile')}}" method="post" id="updateProfilefrm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group text-center">
                                <div class="upload">
                                  <div class="upload__img">
                                      <img src="{{ getUserInfo('admin')->user_image }}" alt="user-img"
                                        class="img-fluid rounded-circle" id="preview-img">
                                      </div>
                                    <label class="mb-0 ripple-effect" for="uploadImage">
                                      <input type="file" onchange="readURL(this);"  id="uploadImage"  name="profile_image">
                                     <i class="icon-pencil"></i>
                                  </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                              <label>Name</label>
                                <input type="text" value="{{ getUserInfo('admin')->name }}" class="form-control" name="name">
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="form-group">
                              <label>Email Address</label>
                              <input type="email" value="{{ getUserInfo('admin')->email }}" class="form-control" readonly="">
                          </div>
                        </div>
                    </div>
                    <div class="btn-row text-center">
                        <button class="btn btn-outline-secondary width-120 ripple-effect text-uppercase"
                            data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary width-120 ripple-effect text-uppercase" type="button" id="updateProfilebtn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--Edit Profile -->
<!-- Edit Category -->
<div class="modal fade changePassword" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog"
    id="changePassword" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded">
            <div class="modal-body">
                <div class="modal-heading">
                    <h2>Change Your Password</h2>
                </div>
                <form id="change_password"  method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Current Password</label>
                        <input type="password" class="form-control" placeholder="Current Password" name="current_password">
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control" placeholder="New Password" name="new_password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" placeholder="Confirm password" name="confirm_password">
                    </div>
                    <div class="btn-row text-center">
                        <button class="btn btn-outline-secondary width-120 ripple-effect text-uppercase"
                            data-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary width-120 ripple-effect text-uppercase" data-url="{{URL::To('admin/change-password')}}" type="button" id="change-button">Update</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\ChangePasswordValidation','#change_password') !!}
            </div>

        </div>
    </div>
</div>
<!--End Edit Category -->
<!-- change active status -->
<div class="modal fade trending" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" id="changeStatus" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body text-center">
                <div class="modal-heading">
                    <h4>Are you sure you want to change status.</h4>
                </div>
                <div class="btn-row mt-30">
                    <button class="btn btn-outline-secondary width-120 ripple-effect text-uppercase"
                        data-dismiss="modal">NO</button>
                    <button class="btn btn-primary width-120 ripple-effect text-uppercase">YES</button>
                </div>
            </div>

        </div>
    </div>
</div>
<!--End Trending -->
<div class="modal fade" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" id="readMore" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="icon-cross"></i>
                </button>
            </div>
            <div class="modal-body text-center pt-3">
                <p class="mb-0" id="readMoreText"></p>
            </div>
        </div>
    </div>
</div>

<!--read-more-->
<div class="overlay-screen"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<!-- <script src="{{ url('public/js/datepicker.min.js') }}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha18/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="{{ url('/public/js/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ url('public/js/jsvalidation.js') }}"></script>

{{-- DataTable Js --}}
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script defer src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
<script defer src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
<script defer src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script defer src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script defer src="https://cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>
{{-- DataTable Js --}}


<script>
    //use for read more
    function readMoreModel(reviews){
        $('#readMoreText').html(reviews);
        $("#readMore").modal('show');
    }
    $(".c-sidemenu__wrapper").mCustomScrollbar();
    //ripple-effect for button
    $('.ripple-effect, .ripple-effect-dark').on('click', function (e) {
        var rippleDiv = $('<span class="ripple-overlay">'),
            rippleOffset = $(this).offset(),
            rippleY = e.pageY - rippleOffset.top,
            rippleX = e.pageX - rippleOffset.left;

        rippleDiv.css({
            top: rippleY - (rippleDiv.height() / 2),
            left: rippleX - (rippleDiv.width() / 2),
            // background: $(this).data("ripple-color");
        }).appendTo($(this));

        window.setTimeout(function () {
            rippleDiv.remove();
        }, 800);
    });
    //Date Picker
    $('#SelectDate, #SelectDate01, #SelectDate02, #SelectDate03, #SelectDate04, #SelectDate05').datetimepicker({
        focusOnShow: false,
        format: 'L',
        //debug:true
    });
    //time Picker
    $('#SelectTime, #SelectTime01').datetimepicker({
        focusOnShow: false,
        format: 'LT',
        // debug:true,

    });

    //select picker
    $('.selectpicker').selectpicker();


    //Change Password
    function changePassword() {
        $("#change_password")[0].reset();
        $(".error-help-block").hide();

        $("#changePassword").modal('show');
    }
    //use for show update profile popup
    function updateProfile() {
        $("#updateProfile").modal('show');
    }
    /*=====================edit profile===================== */

    $("#updateProfilebtn").on('click', (function (e) {
        // e.preventDefault();
        var frm = $('#updateProfilefrm');
        if (frm.valid()) {
            showButtonLoader('updateProfilebtn', 'UPDATE', 'disable');
            $.ajax({
                url: "{{url('admin/update-profile')}}",
                type: "POST",
                data: new FormData(frm[0]),
                contentType: false,
                cache: false,
                processData: false,
                success: function (response)
                {
                    showButtonLoader('updateProfilebtn', 'UPDATE', 'enable');
                    var result =  JSON.parse(response);
                    if(result.success == true){
                        toastr.success(result.message, '', {timeOut: 2000});
                        setTimeout(function(){
                                location.reload();
                            }, 1000);
                    }else{
                        toastr.error(result.message, '', {timeOut: 2000});
                    }
                },
                error: function (response) {
                    showButtonLoader('updateProfilebtn', 'UPDATE', 'enable');
                },
            });
        }
    }));
    function readURL(input) {
		if (input.files && input.files[0]) {

            var file = input.files[0];
            var fileType = file["type"];
            var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
            var imgSize = input.files[0].size;
            if(imgSize > 2000000) {
                toastr.error("Profile image size should not be greater than 2MB.");
                return false;
            };
            if ($.inArray(fileType, validImageTypes) < 0) {
                toastr.error("Please select only gif, jpeg and png image.");
                return false;
            }

			var reader = new FileReader();

			reader.onload = function (e) {
				$('#preview-img').attr('src', e.target.result)
				$('#profileImage').attr('src', e.target.result)
			};
			reader.readAsDataURL(input.files[0]);
		}

	}

    /*=====================change password===================== */
    $('#change-button').click(function () {
        if ($('#change_password').valid()) {
            showButtonLoader('change-button', 'ADD', 'disable');
            url = $(this).data('url');
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: $('#change_password').serialize(),
                success: function (result) {
                    if (result.success == 'false') {
                        toastr.error(result.message);
                        setTimeout(function(){
                                location.reload();
                            }, 1000);
                    } else {
                        $("#change_password")[0].reset();
                           toastr.success(result.message);
                           setTimeout(function(){
                                location.reload();
                            }, 1000);
                    }
                },
                error: function (er) {
                    toastr.error(er.message);
                },
                complete: function () {
                    showButtonLoader('change-button', 'Update', 'enable');
                }
            });
        }
    });

    $('#menu').on('click', function (e) {
        $('body').toggleClass("menu-open");
        e.preventDefault();
    });
    $('.overlay-screen').on('click', function () {
        $('body').removeClass('menu-open');
    });
//tooltip
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    })
    // Load Notification list
    $(document).ready(function () {
        loadNotification();
        setInterval(function(){ loadNotification(); }, 60000);
    });
    function loadNotification() {
        $.ajax({
            type: 'get',
            url: "{{url('admin/load-notification')}}",
            success: function (response) {
                // alert(response);
                if(response.success == true){
                    $('#notificationDiv').html(response.html);
                    $('#notificationCount').html(response.notificationCount);
                }
            }
        });
    }
    //sidemenu scrollbar
    if (screen.width < 992) {
        $("#sidemenu").mCustomScrollbar();
    }
    //filter scroolbar
    // if($(window).width() < 992){
    //     $(".form_field").mCustomScrollbar();
    // }
</script>
