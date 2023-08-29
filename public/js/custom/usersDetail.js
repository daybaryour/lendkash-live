 //===================load user list=========================================
function fillDatatable() {

    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#users_datatable').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            lengthMenu: false,
            lengthChange: false,
            "info":     false,
            responsive: true,
            oLanguage: {
                sProcessing: '<tr><td class="listloader text-center" colspan="6"><div class="spinner-border" role="status"></div> </td></tr>',
                oPaginate: {
                    sNext: '<i class="icon-right-arrow"></i>',
                    sPrevious: '<i class="icon-left-arrow"></i>'
                },
                sEmptyTable: '<div class="alert alert-danger" role="alert">No Data Found</div>'
            },
            ajax: {
                url: SITEURL + "/admin/users",
                data: {
                    filter_name: $('#filter_name').val(),
                    filter_email: $('#filter_email').val(),
                    filter_mobile: $('#filter_mobile').val()
                },
                // beforeSend: function(){
                //     $('#userList').html('');
                // },
                type: 'GET',
            },
            columns: [
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'mobile_number',
                    name: 'mobile_number'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            order: [
                [0, 'desc']
            ]
        });

    });

}

$(document).ready(function () {
    $(".table-responsive").mCustomScrollbar();
    fillDatatable();
    $('#filter_search').click(function () {
        $('#users_datatable').DataTable().destroy();
        fillDatatable();
    });
    $('#reset').click(function () {
        $('#filter_name').val('');
        $('#filter_email').val('');
        $('#filter_mobile').val('');
        $('#users_datatable').DataTable().destroy();
        fillDatatable();
    });
});
//===================Update KYC status=========================================

function updateKycStatus(id, status) {
    url = $('#myonoffswitch' + id).data('url') + '/' + id + '/' + status;
    $.ajax({
        type: 'get',
        url: url,
        dataType: "json",
        success: function (data) {
            if (data.success == 'yes') {
                toastr.success(data.message, '', {
                    timeOut: 1000
                });
                $('#myonoffswitch' + id).attr('onChange', 'updateKycStatus(' + id + ', ' + data.status + ')');
                $('#users_datatable').DataTable().destroy();
                fillDatatable();
            } else {
                toastr.error(data.message);
            }
        }
    });
}

//===================delete user=========================================
function askDeleteModal() {
    $("#deleteCustomer").modal('show');
}

function confirmDelete(){
    $('#deleteCustomer').modal('hide');
}
function deleteUser() {
    url = $("#deleteuser").data('deleteurl');
    $.ajax({
        url: url,
        type: 'post',
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function (res) {
            $("#deleteCustomer").modal('hide');
            if (res.success == 'false') {
                toastr.error(res.message);
            } else {
                toastr.success(res.message);
                var oTable = $('#users_datatable').dataTable();
                oTable.fnDraw(false);

            }
        }
    });
}
