@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>{{ trans('clients.fields.title') }}</th>
                <th>{{ trans('clients.fields.message') }}</th>
                <th>{{ trans('register.fields.name') }}</th>
                <th>E-mail</th>
                <th>{{ trans('clients.fields.file') }}</th>
                <th>{{ trans('applications.fields.created_at') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($applications as $application)
                <td>{{ $application->id }}</td>
                <td>{{ $application->title }}</td>
                <td>{{ $application->message }}</td>
                <td>{{ $application->user->name }}</td>
                <td>{{ $application->user->email }}</td>
                <td>
                    @if ($application->attachment)
                        <a href="{{ $application->attachment }}" target="_blank">Attachment</a>
                    @else - @endif
                </td>
                <td>{{ $application->created_at }}</td>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
