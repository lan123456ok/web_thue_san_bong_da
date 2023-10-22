@extends('layout.master')
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.campaigns.store') }}" method="post" class="form-horizontal">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label for="pitch">Pitch</label>
                                <select name="pitch" class="form-control" id="select-pitch" data-placeholder="--Select Pitch--">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="subpitch">SubPitch</label>
                                <select name="subpitch" class="form-control" id="select-subpitch" data-placeholder="--Select SubPitch--">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-4">
                                <label for="date">Date</label>
                                <input class="form-control" type="date" name="date">
                            </div>

                            <div class="form-group col-4">
                                <label for="start-time">Start Time</label>
                                <input class="form-control" type="time" name="start_time">
                            </div>

                            <div class="form-group col-4">
                                <label for="end-time">End Time</label>
                                <input class="form-control" type="time" name="end_time">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-1">
                                <label for="is_night">Night Time</label>
                                <input class="form-control" type="checkbox" name="is_night" value="0" id="nightCheck">
                            </div>
                            <div class="form-group col-5">
                                <label for="price_per_hour">Price/Hour</label>
                                <input class="form-control" type="number" name="price_per_hour">
                            </div>
                            <div class="form-group col-5">
                                <label for="status">Total Price</label>
                                <input class="form-control" type="number" name="total_price">
                            </div>
                             <div class="form-group col-1 d-flex justify-content-center">
                                <span class="mt-4 mr-3" style="font-size:16px">VND</span>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="title">Campaign Title</label>
                                <input class="form-control" type="text" name="title" id="title">
                            </div>

                            <div class="form-group col-6">
                                <label for="slug">Slug</label>
                                <input class="form-control" type="text" name="slug" id="slug">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" id="btn-submit" disabled>Create</button>
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
        $(document).ready(function () {
            $('#nightCheck').on('change', function(){
               this.value = this.checked ? 1 : 0;
            }).change();

            function generateTitle() {
                const selectedPitch = $('#select-pitch option:selected').text();
                const selectedSubPitch = $('#select-subpitch option:selected').text();

                let title = `(${selectedPitch})`;
                if(selectedSubPitch){
                    title += '-' + selectedSubPitch;
                }
                $('#title').val(title);
                generateSlug(title);
            }

            function generateSlug(title) {
                $.ajax({
                    url: '{{ route('api.campaigns.slug.generate') }}',
                    type: 'POST',
                    dataType: 'json',
                    data: {title},
                    success: function (response) {
                        $('#slug').val(response.data);
                        $('#slug').trigger('change');
                    },
                    error: function (response) {

                    },
                })
            }

            function loadSubPitch() {
                $('#select-subpitch').empty();
                const pitch_id = $('#select-pitch option:selected').val();

                $('#select-subpitch').select2({
                    delay: 250,
                    tags: true,
                    ajax: {
                        url: '{{ route('api.subpitches') }}',
                        data: function(params) {
                            var queryParameters = {
                                q: params.term,
                                pitch_id: pitch_id,
                            }

                            return queryParameters;
                        },
                        processResults: function (data) {
                            return {
                                results: $.map(data.data, function (item){
                                    return {
                                        text: item.name,
                                        id: item.id,
                                    };
                                })
                            };
                        },
                    },
                    placeholder: $(this).data('placeholder'),
                });
            }

            $("#select-pitch").select2({
                tags: true,
                ajax: {
                    url: '{{ route('api.pitches') }}',
                    data: function (params) {
                        var queryParameters = {
                            q: params.term,
                        }
                        return queryParameters;
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: item.name+'-'+item.city ,
                                    id: item.name,
                                }
                            })
                        };
                    },
                },
                placeholder: $(this).data('placeholder'),
            }).change(function () {
                loadSubPitch();
            });

            $(document).on('change', '#select-pitch, #select-subpitch', function () {
                generateTitle();
            });

            $('#slug').change(function () {
                $('#btn-submit').attr('disabled', true);
                $.ajax({
                    url: '{{ route('api.campaigns.slug.check') }}',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        slug : $(this).val(),
                    },
                    success: function (response) {
                        if(response.success) {
                            $('#btn-submit').attr('disabled', false);
                        }
                    },
                })
            });
        })
    </script>
@endpush
