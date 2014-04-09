<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Using RESTful routes, model binding, grouping, filtering, and pattern constraints.
| The {param} in the route is passed on to the controller, whether a model (user), or var (postSlug)
| Note: for Blog postView (submit a comment), we want to preserve the blog/slug URL,
| not return to blog/5 ($post model), so to sync() comments we return with slug, then get post.
|
*/

/*
| ------------------------------------------
|  Route model binding
| ------------------------------------------
|  
| Example: 
| The route param {user} is bound to the User model
| When used like so -- Route::get('users/{user}/edit' ... where {user} = 3 ...
| an instance of the User model is injected into the route, rather than just the user $id
| So in a Controller, for example, we can use getEdit($user) and have the User object
| rather than simply the user $id available.
| https://tutsplus.com/lesson/route-model-binding/
|
| Understanding RESTful route
| admin/users/{user}/delete vs admin/users/delete/4


| 
*/

Route::model('user', 'User'); // route {model}, Model
Route::model('comment', 'Comment');
Route::model('post', 'Post');
Route::model('role', 'Role');

/*
|--------------------------------------------------------------------------
| Global Route filters
|--------------------------------------------------------------------------
|
*/

// Route::when('*','detectLang'); // language detection


/*
|--------------------------------------------------------------------------
| Route Constraint Patterns {param}
|--------------------------------------------------------------------------
|
*/

Route::pattern('comment', '[0-9]+');
Route::pattern('post', '[0-9]+');
Route::pattern('user', '[0-9]+');
Route::pattern('role', '[0-9]+');
Route::pattern('token', '[0-9a-z]+');

/*
| ------------------------------------------
|  ADMIN ROUTES
| ------------------------------------------
|  
| all admin/ routes are 'auth' filtered, requiring login
| all admin/ routes are restricted by Entrust, requiring admin role (filters.php)
| some admin/ routes require specific Entrust permissions (filters.php)
| 
*/

Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{

    // USER MANAGEMENT
    Route::get('users/{user}/show', 'AdminUsersController@getShow'); // not in use
    Route::get('users/{user}/edit', 'AdminUsersController@getEdit');
    Route::post('users/{user}/edit', 'AdminUsersController@postEdit');
    Route::get('users/{user}/delete', 'AdminUsersController@getDelete');
    Route::post('users/{user}/delete', 'AdminUsersController@postDelete');
    Route::controller('users', 'AdminUsersController');

    // USER ROLE MANAGEMENT
    Route::get('roles/{role}/show', 'AdminRolesController@getShow'); // not in use
    Route::get('roles/{role}/edit', 'AdminRolesController@getEdit');
    Route::post('roles/{role}/edit', 'AdminRolesController@postEdit');
    Route::get('roles/{role}/delete', 'AdminRolesController@getDelete');
    Route::post('roles/{role}/delete', 'AdminRolesController@postDelete');
    Route::controller('roles', 'AdminRolesController');

    // BLOG MANAGEMENT
    Route::get('blogs/{post}/show', 'AdminBlogsController@getShow'); // not in use
    Route::get('blogs/{post}/edit', 'AdminBlogsController@getEdit');
    Route::post('blogs/{post}/edit', 'AdminBlogsController@postEdit');
    Route::get('blogs/{post}/delete', 'AdminBlogsController@getDelete');
    Route::post('blogs/{post}/delete', 'AdminBlogsController@postDelete');
    Route::controller('blogs', 'AdminBlogsController');

    // COMMENT MANAGEMENT
    // parameter-bound or explicitly mapped routes
    Route::get('comments/{comment}/edit', 'AdminCommentsController@getEdit');
    Route::post('comments/{comment}/edit', 'AdminCommentsController@postEdit');
    Route::get('comments/{comment}/delete', 'AdminCommentsController@getDelete');
    Route::post('comments/{comment}/delete', 'AdminCommentsController@postDelete');
    // all other RESTful get/post routes with an accompnaying get/post controller action
    Route::controller('comments', 'AdminCommentsController');

    // ADMIN DASHBOARD
    Route::controller('/', 'AdminDashboardController');
});


/*
| ------------------------------------------
| FRONT-END USER ROUTES
| ------------------------------------------
*/

// USER PROFILE
Route::pattern('username', '[0-9a-z]+');
Route::get('user/profile/{username}', 'UserController@getProfile');

Route::get('user/reset/{token}', 'UserController@getReset');
Route::post('user/reset/{token}', 'UserController@postReset');

// USER ACCOUNT
Route::post('user/{user}/edit', 'UserController@postEdit');

// USER RESTful ROUTES (Login, Logout, Register, etc)
Route::controller('user', 'UserController');

/*
| ------------------------------------------
| FRONT-END ROUTES
| ------------------------------------------
*/

// BLOG
Route::get('blog/{postSlug}', 'BlogController@getView');
Route::post('blog/{postSlug}', 'BlogController@postView');
Route::controller('blog', 'BlogController');

// CONTACT US
Route::when('contact-us','detectLang');
Route::get('contact-us', function()
    {
        $data['title'] = 'Contact Us';
        return View::make('site/contact-us', $data);
    }
);

// HOME
Route::get('/', array('before' => 'detectLang', function()
    {

        $data['title'] = 'Home';
        return View::make('site/home', $data);
    })
);

// TESTERS
Route::get('/test/query', 'TestController@getTest'); // test queries
Route::get('/test/blade', function() // test blade
    {
        return View::make('test/test_blade');
    }); 
Route::get('/test/bootstrap', function() // test blade
    {
        return View::make('test/test_bootstrap');
    }); 

// CATCH-ALL
Route::any('{path?}', function($path)
    {
        //return 'Catch-all route: ' . $path;
        return View::make('error/404');
    })
    ->where('path', '.+');


/*_____________________________ SAMPLES_____________________________________

    Route::get('/', function()
    {
        return View::make('hello');
    });


    Route::get('users/{id}', function($id)
    {
        return User::find($id);

    })->where('id', '\d+');

    Route::get('users/{user}', function(User $user)
    {
        return $user;
        
    })->where('id', '\d+');


    Route::get('/test', function()
    {
       $users = DB::table('users')
                         ->select(DB::raw('count(*) as user_count, confirmed'))
                         ->where('confirmed', '<>', 0)
                         ->OrWhere(function($query)
                            {
                               $query->where('1 = 2')
                                     ->where('3 = 4');
                            })
                         ->groupBy('confirmed')
                         ->get();
       //Debugbar::info($users);
        return 'done';
    });

__________________________________________________________________*/
