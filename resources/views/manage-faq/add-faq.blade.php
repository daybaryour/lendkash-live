@extends('layouts.app')
@section('content')
<main class="mainContent edit-cms">
    <div class="container-fluid">
        <!-- page title section start -->
        <div class="page-title-row d-flex">
            <div class="page-title-row__left page-title-row__left--subtittle">
                <h1 class="page-title-row__left__title text-capitalize">
                    Manage FAQ
                </h1>
                <h2>Add FAQ</h2>
            </div>
        </div>
        <!-- page title section end -->
        <div class="edit-cms__wrapper">
            <form action="{{ URL::To('admin/save-faqs')}}" method="post" id="addFaqfrm">
                @csrf
                <div class="form-group">
                    <label>Question</label>
                    <input type="text" class="form-control" placeholder="Question" name="question">
                </div>
                <div class="form-group">
                    <label>Answer</label>
                    <textarea id="answerId" class="form-control" rows="8" placeholder="Answer" name="answer"></textarea>
                </div>
                <div class="form-group mb-0">
                    <a href="{{ URL::To('admin/manage-faqs') }}" class="btn btn-outline-secondary ripple-effect text-uppercase mr-2">Cancel</a>
                    <button class="btn btn-primary ripple-effect text-uppercase ml-2" type="button" id="addFaqbtn">Add</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\AddFaqsValidation','#addFaqfrm') !!}
        </div>
    </div>
</main>
<script src="{{ url('public/js/tinymce/tinymce.min.js') }}"></script>
<script>
//=================== Add Faq =========================================
$(document).ready(function () {
    tinymceInit();
});
$("#addFaqbtn").on('click', (function (e) {
    var editorContent = tinymce.get('answerId').getContent({format: 'text'});
    if ($.trim(editorContent) == ''){
        $('#validation-error-msg').css({"color": "#dc3545", "width": "100%", "font-size": "13px", "margin-top": ".25rem"}).html("The description field is required.");
        return false;
    }
    $('#validation-error-content-msg').html('');
    if ($('#addFaqfrm').valid()) {
        showButtonLoader('addFaqbtn', 'ADD', 'disable');
        var url = "{{url('admin/save-faqs')}}";
        var formData = new FormData($('#addFaqfrm')[0]);
        formData.append('answer', tinyMCE.get('answerId').getContent());
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
                        window.location.href = "{{url('admin/manage-faqs')}}";
                    },1000);
                }
            },
            error: function (er) {
                toastr.error(er.message);
            },
            complete: function () {
                showButtonLoader('addFaqbtn', 'ADD', 'enable');
            }
        });
    }
}));
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
                var answer = tinymce.get('answerId').getContent();
            });
        }
    });
}
</script>
@endsection
