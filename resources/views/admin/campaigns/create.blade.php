@extends('layout.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" class="form-horizontal">
                        <div class="form-group">
                            <label for="pitch">Pitch</label>
                            <select name="pitch" class="form-control" id="select-pitch" data-placeholder="--Select Pitch--">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="city">City</label>
                            <select name="city" class="form-control" id="select-city" data-placeholder="--Select City--">
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="district">District</label>
                            <select name="district" class="form-control" id="select-district" data-placeholder="--Select District--"></select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        async function loadDistrict(){
            $('#select-district').empty();
            const path = $('#select-city option:selected').data('path');
            const response = await fetch('{{ asset('location/') }}' + path);
            const districts = await response.json();

            $.each(districts.district ,function (index, each) {
                if(each.pre === "Quận" || each.pre === "Huyện" || each.pre === ""){
                    $('#select-district').append(`<option>
                        ${each.name}
                    </option>`);
                }
            });
        }

        $(document).ready(async function () {
            const response = await fetch('{{ asset('location/index.json') }}');
            const cities = await response.json();
            $('#select-city').select2({
                placeholder: $(this).data('placeholder'),
            }).change(function() {
                loadDistrict();
            });
            $.each(cities ,function (index, each) {
                $('#select-city').append(`<option data-path="${each.file_path}">
                    ${index}
                </option>`);
            });

            $('#select-district').select2({
                placeholder: $(this).data('placeholder'),
            });

            $("#select-pitch").select2({
                tags: true,
                ajax: {
                    url: '{{ route('api.pitches') }}',
                    data: function (params) {
                        var queryParameters = {
                            q: params.term
                        }

                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id,
                                }
                            })
                        };
                    },
                },
                placeholder: $(this).data('placeholder'),
            });
        })
    </script>
@endpush
