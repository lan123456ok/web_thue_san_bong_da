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
            {{--$.ajax({--}}
            {{--    url: '{{ route('api.campaigns') }}',--}}
            {{--    dataType: 'json',--}}
            {{--    data: {--}}
            {{--        param1: 'value1',--}}
            {{--    },--}}
            {{--})--}}
            {{--.success(function(respone) {--}}
            {{--    // $('#table-data').--}}
            {{--})--}}
            {{--.error(function(respone) {--}}
            {{--})--}}
            {{--;--}}
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
                    success: function(respone) {
                        $.toast({
                            heading: 'Import Success',
                            text: 'Your data has been imported successfully',
                            showHideTransition: 'slide',
                            position: 'bottom-right',
                            icon: 'success'
                        });
                    },
                    // error: function(respone) {
                    //     //console.log(respone);
                    // }
                });
            });
        })
    </script>
@endpush
