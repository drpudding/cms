{{-- DISPLAYS NOTIFICATIONS: FRONT & BACK END, and MODALS --}}

{{-- Inline Errors: when passing $errors Message Bag object to view --}}
{{-- errors are returned in JSON as key:value (e.g. {"password":["error1", "error2"]) --}}
@if (count($errors->all()) > 0)
<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Error</strong>
	Please check the form below for errors.
</div>
@endif

{{----------------------------- SESSION-BASED (FLASH) NOTIFICATIONS -----------------------------}}

{{-- Bulk Errors: when passing errors-()>all() array or var to view --}}
{{-- Flashed Messages: when flashing a message (error, success, etc.) --}}
{{-- errors are returned as array, and parsed to single message at top --}}
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissable">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Error. </strong>
    @if(is_array($message))
        <p>
        @foreach ($message as $m)
            {{ $m }}<br>
        @endforeach
        </p>
    @else
        {{ $message }}
    @endif
</div>
@endif

{{-- SUCCESS --}}
@if ($message = Session::get('success'))
<div class="alert alert-success alert-dismissable">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Success. </strong>
    @if(is_array($message))
        <p>
        @foreach ($message as $m)
            {{ $m }}<br>
        @endforeach
    </p>
    @else
        {{ $message }}
    @endif
</div>
@endif

{{-- WARNING --}}
@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-dismissable">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Warning. </strong>
    @if(is_array($message))
        <p>
        @foreach ($message as $m)
            {{ $m }}
        @endforeach
        </p>
    @else
        {{ $message }}
    @endif
</div>
@endif

{{-- NOTICE --}}
@if ($message = Session::get('notice'))
<div class="alert alert-warning alert-dismissable">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Notice. </strong>
    @if(is_array($message))
        <p>
        @foreach ($message as $m)
            {{ $m }}
        @endforeach
        </p>
    @else
        {{ $message }}
    @endif
</div>
@endif

{{-- INFO --}}
@if ($message = Session::get('info'))
<div class="alert alert-info alert-dismissable">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Info. </strong>
    @if(is_array($message))
        <p>
        @foreach ($message as $m)
            {{ $m }}
        @endforeach
        </p>
    @else
        {{ $message }}
    @endif
</div>
@endif
