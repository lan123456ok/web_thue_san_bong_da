@extends('layout.master')
@push('css')
{{--    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>--}}
    <style>
        .error {
            color: red;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div id="div-error" class="alert alert-danger d-none m-0"></div>
                <div class="card-body">
                    <form action="{{ route('admin.campaigns.store') }}" method="post" class="form-horizontal" id="form-create">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-4">
                                <label for="pitch_id">Pitch (*)</label>
                                <select name="pitch_id" class="form-control" id="select-pitch" data-placeholder="--Select Pitch--">
                                    <option value=""></option>
                                </select>
                            </div>
                            <div class="form-group col-4">
                                <label for="sub_pitch_id">SubPitch (*)</label>
                                <select name="sub_pitch_id" class="form-control" id="select-subpitch" data-placeholder="--Select SubPitch--">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-4">
                                <label for="date">Date (*)</label>
                                <input class="form-control date-time" type="date" name="date">
                            </div>

                            <div class="form-group col-4">
                                <label for="start-time">Start Time (*)</label>
                                <input class="form-control date-time" type="time" name="start_time" id="input_start_time">
                            </div>

                            <div class="form-group col-4">
                                <label for="end-time">End Time (*)</label>
                                <input class="form-control date-time" type="time" name="end_time" id="input_end_time">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-1">
                                <label for="is_night">Night Time</label>
                                <input class="form-control" type="checkbox" name="isNight" value="0" id="nightCheck" onclick="return false;">
                            </div>
                            <div class="form-group col-5">
                                <label for="price_per_hour">Price/Hour</label>
                                <input class="form-control" type="number" name="price_per_hour" id="price_per_hour" readonly>
                            </div>
                            <div class="form-group col-5">
                                <label for="status">Total Price</label>
                                <input class="form-control" type="number" name="total_price" id="total_price" readonly>
                            </div>
                             <div class="form-group col-1 d-flex justify-content-center">
                                <span class="mt-4 mr-3" style="font-size:16px">VND</span>
                            </div>

                        </div>

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label for="title">Campaign Title</label>
                                <input class="form-control" type="text" name="campaign_title" id="title">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <script>
        $(document).ready(function () {
            var nightBonus = 0;
            var pricePerHour = 0;
            var total = 0;


            $('#input_start_time').change(function () {
                let startTime = $('#input_start_time').val();
                let [hourStr, minuteStr] = startTime.split(':');
                let hour = parseInt(hourStr);
                let minute = Number(minuteStr);

                if(hour >= 17 && minute > 0 || hour > 17) {
                    $('#nightCheck').prop('checked', true).on('change', function() {
                        this.value = 1;
                        nightBonus = 100.000;
                    }).change();
                }
                else {
                    $('#nightCheck').prop('checked', false).on('change', function() {
                        this.value = 10;
                        if (nightBonus > 0) {
                            nightBonus = 0;
                        }
                    }).change();
                }
                $('#input_end_time').val('');
                $('#price_per_hour').val(pricePerHour + nightBonus);
            });

            $('#input_end_time').change(function () {
                let start = $('#input_start_time').val();
                let end = $('#input_end_time').val();

                start = start.split(':');
                end = end.split(':');
                let startTime = new Date(0, 0, 0, start[0], start[1], 0);
                let endTime = new Date(0, 0, 0, end[0], end[1], 0);
                var diff = endTime.getTime() - startTime.getTime();

                var hours = Math.floor(diff / 1000 / 60 / 60);
                // diff minute
                diff -= hours * 1000 * 60 * 60;
                var minutes = Math.floor(diff / 1000 / 60 % 60);
                let minuteRemainder = minutes/60;
                let usedTime = hours + minuteRemainder;

                totalPriceSum(usedTime);
            });

            function totalPriceSum(time) {
                total = (pricePerHour + nightBonus) * time;
                $('#total_price').val(total);
            }

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
                            var data =  $.map(data.data, function (item){
                                return {
                                    text: item.name,
                                    id: item.id,
                                    price: item.price_per_hour,
                                };
                            });
                            return { results: data} ;
                        },
                    },
                    placeholder: $(this).data('placeholder'),
                }).on('select2:select', function(event) {
                    $('.date-time').val('');
                    total = 0;
                    pricePerHour = 0;
                    var price = event.params.data.price;
                    pricePerHour += price;
                    $('#price_per_hour').val(price);
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
                                    text: item.name+'-'+item.city,
                                    id: item.id,
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

            $("#form-create").validate({
              rules: {
              },
              submitHandler: function() {
                  checkPitch();
              },
            });

            function checkPitch() {
                {{--const response = fetch('{{ route('api.pitches.check') }}/' + $('#select-pitch').val());--}}
                $.ajax({
                    url: '{{ route('api.pitches.check') }}/' + $('#select-pitch').val(),
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if(response.data) {
                            submitForm();
                        }
                    },
                    error: function(response) {
                        const error = response.responseJSON.message;
                        showError(error);
                    },
                })
            }

            function submitForm() {
                $.ajax({
                    url: $('#form-create').attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    data: $('#form-create').serialize(),
                    success: function () {
                        $('#div-error').hide();
                    },
                    error: function(response) {
                        const errors = Object.values(response.responseJSON.errors);
                        showError(errors);
                    },
                });
            }

            function showError(errors) {
                let stringHTML = "<ul class='m-0'>";

                if(Array.isArray(errors)){
                    errors.forEach(function(each) {
                        each.forEach(function(error) {
                            stringHTML += `<li>${error}</li>`;
                        });
                    });
                } else {
                    stringHTML += `<li>${errors}</li>`;
                }
                stringHTML += "</ul>";
                $('#div-error').html(stringHTML).removeClass('d-none').show();
            }
        })
    </script>
@endpush
