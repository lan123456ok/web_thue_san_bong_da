@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('admin.campaigns.create') }}" class="btn btn-success">
                        Create
                    </a>
                    <label for="csv" class="btn btn-info m-0">
                        Import CSV
                    </label>
                    <input type="file" name="csv" id="csv" class="d-none" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                    <nav class="float-right">
                        <ul class="pagination pagination-rounded mb-0" id="pagination">
                        </ul>
                    </nav>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table-data">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Pitch</th>
                                <th>SubPitch</th>
                                <th>Date</th>
                                <th>Start time</th>
                                <th>End time</th>
                                <th>Is Night</th>
                                <th>Total price</th>
                                <th>Status</th>
                                <th>Created at</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            // crawl data
            $.ajax({
                url: '{{ route('api.campaigns') }}',
                data: { page: {{ request()->get('page') ?? 1 }} },
                dataType: 'json',
                success: function (response) {
                    response.data.data.forEach(function(each) {
                        // console.log(each);
                        let created_at = formatDateTimeToDate(each.created_at);
                        $('#table-data').append($('<tr>')
                            .append($('<td>').append(each.id))
                            .append($('<td>').append(each.user_id))
                            .append($('<td>').append(each.pitch_id))
                            .append($('<td>').append(each.sub_pitch_id))
                            .append($('<td>').append(each.date))
                            .append($('<td>').append(each.start_time))
                            .append($('<td>').append(each.end_time))
                            .append($('<td>').append((each.isNight > 0) ? 'x' : ''))
                            .append($('<td>').append(each.total_price))
                            .append($('<td>').append(each.status))
                            .append($('<td>').append(created_at))
                        );
                    });
                    renderPagination(response.data.pagination);
                },
                error : function(response) {
                    $.toast({
                            heading: 'Error !!!',
                            text: response.responseJSON.message,
                            showHideTransition: 'slide',
                            position: 'bottom-right',
                            icon: 'error'
                    });
                },
            });
            $(document).on('click', '#pagination > li > a' ,function (event) {
                event.preventDefault();
                let page = $(this).text();

                let urlParams = new URLSearchParams(window.location.search);
                urlParams.set('page', page);
                window.location.search = urlParams;
            });
            $('#csv').change(function (event) {
                var formData = new FormData();
                formData.append('file', $(this)[0].files[0]);
                $.ajax({
                    url: '{{ route('admin.campaigns.import_csv') }}',
                    type: 'POST',
                    dataType: 'json',
                    enctype: 'multipart/form-data',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function() {
                        $.toast({
                            heading: 'Import Success',
                            text: 'Your data has been imported successfully',
                            showHideTransition: 'slide',
                            position: 'bottom-right',
                            icon: 'success'
                        });
                    },
                    // error: function() {
                    //     //console.log();
                    // }
                });
            });
        })
    </script>
@endpush
