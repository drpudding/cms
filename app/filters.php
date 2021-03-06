<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	//
});


App::after(function($request, $response)
{
	//
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
| MAC:  add session loginRedirect (as per Confide); takes you to destination post login 
|       the 'auth' filter is applied to all /admin/ routes to verify
        Auth::guest() = true, if user is not logged in
*/

Route::filter('auth', function()
{
    if (Auth::guest()) { // If the user is not logged in
        Session::put('loginRedirect', Request::url()); // Set the loginRedirect session variable
        return Redirect::to('user/login/'); // and redirect to login
    }
});

// MAC: not in use
Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
| MAC:  changed to BSS version - redirect to login
|       Auth::check() = true, if user is logged in
*/

Route::filter('guest', function()
{

	//if (Auth::check()) return Redirect::to('/');
	if (Auth::check()) return Redirect::to('user/login/');
});

/*
|--------------------------------------------------------------------------
| Role Permissions
|--------------------------------------------------------------------------
|
| MAC: add role permissions, as per Entrust
|
| Access filters based on roles.
|
*/

// Check for 'admin' role on all admin routes
Entrust::routeNeedsRole( 'admin*', array('admin'), Redirect::to('/') );

// Check for permissions on admin actions
Entrust::routeNeedsPermission( 'admin/blogs*', 'manage_blogs', Redirect::to('/admin') );
Entrust::routeNeedsPermission( 'admin/comments*', 'manage_comments', Redirect::to('/admin') );
Entrust::routeNeedsPermission( 'admin/users*', 'manage_users', Redirect::to('/admin') );
Entrust::routeNeedsPermission( 'admin/roles*', 'manage_roles', Redirect::to('/admin') );

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
| MAC: changed to BSS filter
*/

Route::filter('csrf', function()
{

	if (Session::getToken() != Input::get('csrf_token') &&  Session::getToken() != Input::get('_token'))
	//if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/*
|--------------------------------------------------------------------------
| Language
|--------------------------------------------------------------------------
|
| MAC: add this language detection filter
|
| Detect the browser language.
|
*/

Route::filter('detectLang',  function($route, $request, $lang = 'auto')
{

    // pass a lang param ( Route::when('contact-us','detectLang:pt') ) NOT browser detection
    // requires that lang is in the language array
    if($lang != "auto" && in_array($lang , Config::get('app.available_language')))
    {
        Config::set('app.locale', $lang);
        App::setLocale($lang);

    // browser detection, with fallback to Config app.locale
    } else {
        $browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
        $browser_lang = substr($browser_lang, 0,2);
        $userLang = (in_array($browser_lang, Config::get('app.available_language'))) ? $browser_lang : Config::get('app.locale');
        Config::set('app.locale', $userLang);
        App::setLocale($userLang);

    }
});