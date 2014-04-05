@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
    {{{ Lang::get('user/user.profile') }}} ::
    @parent
@stop

{{-- Content --}}
@section('content')
    <div class="page-header">
        <h1>User Profile</h1>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Signed Up</th>
                {{-- <th>Comments</th> --}}
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{{$user->id}}}</td>
                <td>{{{$user->username}}}</td>
                <td>{{{$user->created_at}}}</td>
            {{-- MAC: added as test
            <td>
            @foreach ($user->comments as $comment)
            {{ $comment->content . '<br>' }}
            @endforeach
            </td>
            --}}
            </tr>
        </tbody>
    </table>
@stop
