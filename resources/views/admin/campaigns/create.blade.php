@extends('layout.master')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="" class="form-horizontal">
                        <div class="form-group">
                            <label for="pitch">Pitch</label>
                            <select name="pitch" class="form-control">
                                @foreach($pitches as $pitch)
                                    <option value="{{ $pitch->id }}">{{ $pitch->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
