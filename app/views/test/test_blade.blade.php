@extends('test.layout')

@section('section_me')
 <p>I'm the custom section text, with my parent text appended.</p>
 @parent
@stop

@section('yield_me')
 <p>I'm the custom yield text. Comment my section out and you'll get my default text.</p>
@stop


