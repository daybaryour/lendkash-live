@extends('layouts.app')

@section('content')
<main class="mainContent">
    <div class="container-fluid">
        <!-- page title section start -->
        <div class="page-title-row">
            <div class="page-title-row__left">
                <h1 class="page-title-row__left__title text-capitalize">
                    Manage CMS
                </h1>
            </div>
        </div>
        <div class="common-table min-h500">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th class="w_120 text-center"><span>Action</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($modal as $data)
                            <tr>
                                <td>
                                    <span class="font-md">{{ $data['title'] }}</span>
                                </td>
                                <td class="text-center">
                                    <a class="action_icon" href="{{ url('admin/edit-cms').'/'.base64_encode($data->id)}}"><i class="icon-pencil"></i></a>
                                </td>
                            </tr>
                        @empty

                        @endforelse
                        <tr>
                            <td>
                                <span class="font-md">FAQ</span>
                            </td>
                            <td class="text-center">
                                <a class="action_icon" href="{{ url('admin/manage-faqs')}}"><i class="icon-pencil"></i></a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <!-- table listing end -->
    </div>
</main>
@endsection
