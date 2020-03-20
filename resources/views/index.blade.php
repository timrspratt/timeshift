@extends('admin::layouts.main')

@section('content')
    <h2>
        <a href="{{ route('admin.modules', request()->all()) }}" class="btn mr-4">« Back</a>
        Timeshift
    </h2>
    @include('admin::partials.alerts')
    <form action="{{ route('admin.modules.timeshift.set') }}" method="post">
        @csrf
        <div class="card">
            <div class="w-64">
                <label class="block">Date and time</label>
                <date-picker
                    formatted="llll"
                    name="timestamp"
                    :auto-close="false"
                    value="{{ $stamp }}">
                </date-picker>
            </div>
        </div>
        <div class="card mt-4 p-4 w-full flex flex-wrap">
            <button class="btn btn-secondary" type="submit">Save</button>
        </div>
    </form>
@endsection
