@extends('layouts.app')
@section('content')
<main class="mainContent edit-cms">
    <div class="container-fluid">
        <!-- page title section start -->
        <div class="page-title-row d-flex">
            <div class="page-title-row__left page-title-row__left--subtittle">
                <h1 class="page-title-row__left__title text-capitalize">
                    Manage CMS
                </h1>
                <h2>Edit {{ $data['title'] }} CMS</h2>
            </div>
        </div>
        <!-- page title section end -->
        <div class="edit-cms__wrapper">
            <form action="{{URL('admin/update-cms')}}" method="post" id="updateCmsfrm">
                {{ csrf_field() }}
                <input type="hidden" name="pageId" value="{{ $data['id'] }}">
                <div class="form-group">
                    <label>Title</label>
                        <input type="text" class="form-control" placeholder="Title" value="{{ $data['title'] }}" name="title">
                </div>
                <div class="form-group">
                    <label>Content</label>
                    <textarea id="content" class="form-control" rows="8" placeholder="content" name="content">{{ ($data['content'])?$data['content']:"" }}</textarea>
                </div>
                <div class="form-group mb-0">
                    <a href="{{ URL('admin/manage-cms') }}" class="btn btn-outline-secondary ripple-effect text-uppercase mr-2">Cancel</a>
                    <button class="btn btn-primary ripple-effect text-uppercase ml-2" type="button" id="updateCmsbtn">Update</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\CmsValidation','#updateCmsfrm') !!}
        </div>
    </div>
</main>
<script src="{{ url('public/js/tinymce/tinymce.min.js') }}"></script>
<script>
    $(document).ready(function () {
        tinymceInit();
    });
    // function using for show tinymce text editor
    function tinymceInit() {
        tinymce.init({
            theme: "modern",
            selector: "textarea",
            relative_urls: false,
            remove_script_host: true,
            convert_urls: false,
            plugins: 'code searchreplace autolink directionality table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern',
            toolbar: 'undo redo | formatselect | bold italic strikethrough forecolor backcolor | link | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent  | removeformat | code',
            height: 200,
            init_instance_callback: function (editor) {
                editor.on('keyup', function (e) {
                    var contentEng = tinymce.get('content').getContent();
                });
            }
        });
    }
//=================== Update CMS =========================================
$("#updateCmsbtn").on('click', (function (e) {
    var editorContent = tinymce.get('content').getContent({format: 'text'});
    if ($.trim(editorContent) == ''){
        $('#validation-error-msg').css({"color": "#dc3545", "width": "100%", "font-size": "13px", "margin-top": ".25rem"}).html("The description field is required.");
        return false;
    }
    $('#validation-error-content-msg').html('');
    if ($('#updateCmsfrm').valid()) {
        showButtonLoader('updateCmsBtn', 'UPDATE', 'disable');
        var url = "{{url('admin/update-cms')}}";
        var formData = new FormData($('#updateCmsfrm')[0]);
        formData.append('content', tinyMCE.get('content').getContent());
        $.ajax({
            type: "POST",
            url: url,
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (result) {
                if (result.success == 'false') {
                    toastr.error(result.message);
                } else {
                        toastr.success(result.message);
                        setTimeout(function(){
                            window.location.href = "{{url('admin/manage-cms')}}";
                        },1000);
                }
            },
            error: function (er) {
                toastr.error(er.message);
            },
            complete: function () {
                showButtonLoader('updateCmsBtn', 'UPDATE', 'enable');
            }
        });
    }

}));
</script>
@endsection
