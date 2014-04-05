-- when referencing layouts or includes, use the full path from the views folder (dot.syntax)

@section('section_me')
 <p>I'm the parent section text.</p>
@show

@yield('yield_me', 'I\'m the default yield text.')

@include('test.include_me', array('color' => 'red'))
