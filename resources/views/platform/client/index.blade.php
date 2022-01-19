@extends('layouts.app')

@section('content')
    <div class="container">
        @if (count($errors->all()))
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session()->has('error'))
            <div class="alert alert-danger">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        <form action="{{ route('platform.application.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">{{ trans('clients.fields.title') }}</label>
                <input type="text" name="title" value="{{ old('title') }}" id="title" class="form-control" />
            </div>
            <div class="form-group">
                <label for="message">{{ trans('clients.fields.message') }}</label>
                <input type="text" name="message" value="{{ old('message') }}" id="message" class="form-control" />
            </div>
            <div class="form-group">
                <label for="file">{{ trans('clients.fields.file') }}</label>
                <input type="file" name="attachment" value="{{ old('attachment') }}" id="attachment" class="form-control" />
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">{{ trans('clients.actions.submit') }}</button>
            </div>
        </form>
    </div>
@endsection
