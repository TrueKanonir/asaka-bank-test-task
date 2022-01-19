@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex align-items-center justify-content-center" style="height: 100vh">
            <div class="card">
                <h1>{{ trans('register.title') }}</h1>
                @if (count($errors->all()))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
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
                <form action="{{ route('register') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="name">{{ trans('register.fields.name') }}</label>
                        <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}" required />
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email') }}" id="email" required />
                    </div>
                    <div class="form-group">
                        <label for="password">{{ trans('login.fields.password') }}</label>
                        <input class="form-control" type="password" name="password" id="password" required />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ trans('register.actions.submit') }}</button>
                    </div>
                    <div class="form-group">
                        <a href="{{ route('login.form') }}">{{ trans('login.title') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
