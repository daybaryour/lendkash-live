<div id="msg">
    @if(Session::has('success_msg'))
    <script>
        $(document).ready(function(){
                 // $.toaster({'settings' : {'timeout':5000}});
                 //  $.toaster({ priority : 'success', title : 'Success', message :  "{{Session::get('success_msg')}}"});
                 var msg = "{{Session::get('success_msg')}}";
                  toastr.success(msg);
             });
    </script>
    <!--<div class="alert alert-success">{{ Session::get('success_msg') }}</div>-->
    @endif

    @if(Session::has('error_msg'))
    <script>
        $(document).ready(function(){
                  //  $.toaster({'settings' : {'timeout':5000}});
                  // $.toaster({ priority : 'danger', title : 'Error', message :   "{{Session::get('error_msg')}}" });
                  var msg = "{{Session::get('error_msg')}}";
                  toastr.error(msg);
             });
    </script>
    <!--<div class="alert alert-danger">{{ Session::get('error_msg') }}</div>-->

    @endif
</div>
<script>
    var SITEURL = '{{ URL::to('') }}';

    function showButtonLoader(id, text, action) {
        if (action === 'disable') {
            $('#' + id).html('Processing...<i class="fa fa-spinner fa-pulse"></i>');
            $('#' + id).prop('disabled', true);
        } else {
            $('#' + id).html(text);
            $('#' + id).prop('disabled', false);
        }
    }
</script>
