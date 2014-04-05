@extends('site.layouts.default')

{{-- Content --}}
@section('content')
<br>
{{ json_encode($data, JSON_PRETTY_PRINT) }}
<br><br>
<pre>{{ print_r($data) }}</pre>
<br><br>

@stop