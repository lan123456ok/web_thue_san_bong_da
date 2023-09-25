@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <form class="form-inline" id="form-filter">
                        <div class="form-group">
                            <label for="role">Role</label>
                            <div class="col-3">
                                <select class="form-control select-filter" name="role" id="role">
                                    <option selected value="">All</option>
                                    @foreach ($roles as $role => $value)
                                        <option value="{{ $value }}" @if ((string)$value === $selectedRole)
                                            selected
                                        @endif>
                                            {{ $role }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pitch">Pitch</label>
                            <div class="col-3">
                                <select class="form-control select-filter" name="pitch" id="pitch">
                                    <option selected value="">All</option>
                                    @foreach ($pitches as $pitch)
                                        <option value="{{ $pitch->id }}" @if ($pitch->id === (int)$selectedPitch)
                                            selected
                                        @endif>
                                            {{ $pitch->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <table class="table table-hover table-centered mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Avatar</th>
                                <th>Info</th>
                                <th>Role</th>
                                <th>Pitch</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $each)
                                <tr>
                                    <td>
                                        <a href="{{ route("admin.$table.show", $each) }}">
                                            {{ $each->id }}
                                        </a>

                                    </td>
                                    <td><img src="{{ $each->avatar }}" height="100"></td>
                                    <td>
                                        {{ $each->name }} - {{ $each->gender_name }}
                                        <br>
                                        <a href="mailto: {{ $each->email }}">
                                            {{ $each->email }}
                                        </a>
                                        <br>
                                        <a href="tel: {{$each->phone}}">{{ $each->phone }}</a>
                                    </td>
                                    <td>
                                        {{ $each->role_name }}
                                    </td>
                                    <td>
                                        {{ optional($each->pitch)->name }}
                                    </td>
                                    <td>
                                        <form action="{{ route("admin.$table.destroy", $each) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination pagination-rounded mb-0">
                            {{ $data->links() }}
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function (){
            $(".select-filter").change(function (){
                $("#form-filter").submit();
            });
        });
    </script>
@endpush
