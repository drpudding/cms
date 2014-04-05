<?php

// VARIOUS QUERIES USING FLUENT & ELOQUENT

class TestController extends BaseController {

	public function getTest()
	{
	   $data = 'Nothing to see here.';


// $data = $user->errors()->all();

//$data = $user->save();
//$data = $user->errors()->all();


	// $data = Config::get('app.debug');
	// $data = TEST_CONSTANT;
	// 
	// 
	   // $data = Post::with(
	   // 		array('comments' => function($q)
	   // 		{
	   // 			$q->whereStatus(1);
	   // 		})
	   // 	)->whereStatus(1)->get();
	 
// PUSH
	   // $comment = Comment::find(1);
	   // $comment->content = 'fakesto';
	   // //$comment->post->title = 'fake title';
	   // $comment->save();

// SAVE comments for a $post; comment belongsTo post_id is auto-entered
	   // $post = Post::find(1);
	   // $comment = new Comment;
	   // $comment->content = 'shiter';
	   // $comment->user_id = 1;
	   // $data = $post->comments()->save($comment);

// ASSOCATE: UPDATE a belongsTo association; associate a comment with a new post
	   // $post = Post::find(1);
	   // $comment = Comment::find(1);
	   // $comment->post()->associate($post);
	   // $comment->save();

// ATTACH: MANY to MANY; insert a new pivot record user2role (assigned_roles)
	   // $user = User::find(1);
	   // $user->roles()->attach(3);
// DETACH
 		// $user->roles()->detach(3);

// SYNC, like attach & detach
 	// $user = User::find(1);
 	// $user->roles()->sync([1,2]);

// PIVOT
	   // $user = User::find(1);
	   // foreach($user->roles AS $role)
	   // {
	   // 	echo $role->pivot->foo;
	   // }

// CREATE & SAVE BY ASSOCIATION
		// $role = new Role(array('name' => 'foo'));
	 	// $data = User::find(1)->roles()->save($role);

	 //$data = Post::with('author')->get();

	// foreach ($photos AS $photo)
	// {
	// 	$data .= $photo->name . '<br>';
	// 	$data .= $photo->imageable->name . '<br>' . '<br>';
	// }
	// 
	   //$data = $data->pop();
	   //d($data);

    /*_______ ELOQUENT ORM _________*/

    // $data = Post::all(array('id', 'title', 'content'));
    // $data = Post::all(['id', 'title', 'content']);			// JSON format instead of array

 //    $user = User::with(['comments', 'comments.post'])->find(2);

    // $data = Post::get( array('id', 'title', 'content') );
    // $data = User::find(1);
    // $data = User::select('username AS name', 'email')->get(); 
    // $data = User::first();
    // $data = User::findOrFail(11);
	// $data = User::distinct()->get();
	// $data = User::whereNull('updated_at')->get();
	// // $data = User::whereNotNull('updated_at')->get();
	// $data = Post::where('id', '=', 1)->get( array('id', 'title', 'content') );
	// $data = User::whereRaw( "username LIKE ? AND email LIKE ?", array('%a%', '%n%') )->get(); // RAW
	// $data = User::whereUsername('marc')->get(); 							// WHERE SHORTCUT
	// $data = Post::lists('title', 'id'); 									// VALUE : KEY
 	// $data = User::skip(1)->take(2)->get(); 								// OFFSET & LIMIT

// EACH
    // $posts = Post::all();
    // $posts->each(function($post)
    // {
    // 	echo $post->title;

    // });

// SORT
	// $posts = Post::all();

 //    $posts->sort(function($a, $b)
 //    {
 //        $a = $a->title;
 //        $b = $b->title;
 //        if ($a === $b) {
 //            return 0;
 //        }
 //        return ($a > $b) ? 1 : -1;
 //    });

 //    $posts->each(function($post)
 //    {
 //        echo($post->title);
 //    });

// MAP
 	// $posts = Post::all();
	// $data = $posts->map(function($post)
	// {
	//     return 'TITLE: ' . $post->title;
	// });

// FILTER
	// $users = User::all();
	// $data = $users->filter(function($user)
	// {
	// 		if($user->confirmed == 1) return $user;
	// 		if($user->confirmed == 1) return true; // WORKS THE SAME
	// });

// HAS, WHEREHAS, ORWHEREHAS
	// $data = Post::has('comments')->get();

	// $data = Post::whereHas('comments', function($q)
	// 			{
	// 				$q->where('content', 'like', '%3%');
	// 			})->get();
	// 			
	// 			

// DYNAMIC PROPERTIES
// only works when getting back a single model instance not, several
	// $data = User::first()->roles;
	// $data = Role::find(2)->users;
// however, it will then know if the property it is returning is one-to-one
// or one-to-many 
// 
	// $data = Post::first();
	// $data = $data->author; // to one
	// $data = $data->comments; // to many

	// DON’T CHAIN CONDITIONS TO DYNAMIC PROPERTY; USE METHOD SYNTAX
	// $data = Post::find(2)->comments()->where('status', '=', 1)->get();

 // CALLING A STATIC MODEL METHOD
    // $data = Post::isActive()->get();

 // CALLING AN INSTANTIATED MODEL METHOD
    // $user = new User;
    // $data = $user->getUserByUsername('marc');

// APPENDING QUERY
	// $query = Post::all();
	// $data = $query->where('status', '=', 1);

// WITH -- variations

	// FIND USERS WHO HAVE COMMENTED ON GIVEN POST
	// COMMENT ID HAS USER AND THE POST FOREIGN KEYS
	// (1) as Post with details
	// $data = Post:: with(array(
	// 			'comments' => function($q)
	// 			{
	// 				$q->select('post_id', 'user_id', 'content');
	// 			},
	// 			'comments.author' => function($q)
	// 			{
	// 				$q->select('id', 'username');
	// 			}
	// 		)
	// 	)->where('id', 1)
	// 	->get( array('id', 'title') );

    // (2) as Comments with details
	// $data = Comment:: with(array(
	// 			'post' => function($q)
	// 			{
	// 				$q->select('id', 'title');
	// 			},
	// 			'author' => function($q)
	// 			{
	// 				$q->select('id', 'username');
	// 			}
	// 		)
	// 	)->where('post_id', 1)
	// 	->get( array('id', 'user_id', 'post_id', 'content') );

 // GROUP BY, HAVING, ORDER BY, and DB::raw() to boot
	// $data = User::
	// 	orderBy('username', 'desc')
	// 		->select( 
	// 			array(
	// 				DB::raw('(CASE WHEN confirmed = 1 THEN "confirmed" ELSE "unconfirmed" END) AS user_group') , 
	// 				DB::raw('COUNT(id) AS count')
	// 			) 
	// 		)
	// 	->groupBy('confirmed')
	// 	->having('count', '>', 0)
	// 	->get();

// NESTED WHERES
	// $data = User::where('username', 'admin')
	// 	->orWhere(function($query)
	// 	{
	// 		$query->where('username', 'member')
	// 		->where('confirmed', 0);
	// 	})
	// ->get();

 // INSERT using CREATE (ORM only)
	// $data = Post::create(array(
	// 	'user_id' => 1,
	//     'title'  => 'Laravel is awesome!',
	//     'content'   => 'Laravel is awesome, you should use it if you aren\'t already!'
	// ));

 // INSERT multi insert
	// $data = User::insert(array(
	// 	array('username' => 'bob', 'confirmed' => 0),
	// 	array('username' => 'fred', 'confirmed' => 1)
	// ));

 // INSERT and get back insert id
	// $data = Post::insertGetId(
	//     array('user_id' => 2, 'title' => 'foo', 'content' => 'body')
	// );

// UPDATE with WHERE
    // $data = User::where('username', 'marc')->update( array('confirmed' => 5) );

// RAW in SELECT
	// $data = User::select(
	// 			DB::raw(' (CASE WHEN confirmed = 0 THEN "unconfirmed" ELSE "confirmed" END) AS user_type '),
	// 			DB::raw('COUNT(*) AS user_count')
	// 		)
	// 	->groupBy('confirmed')
	// 	->get();

// EAGER LOADING
	// $data = Post::with( 'comments')
	// 	->where('id','>', 1)
	// 	->get(); 

	// $data = Post::with( 'author','comments.author')->first();

// EAGER LOADING vs. dynamic variable
	// $data = Post::first()->comments; 		// DV: returns just comments of the posts
	// $data = Post::with('comments')->first();	// EL: returns the posts and their comments

// get first post, it's author, it's comments, and the comment's authors
	// $data = Post::with( 'author', 'comments', 'comments.author')->first(); 

// EAGER LOADING, WITH CLOSURE
	// $data = Post::with(
	// 	array('comments' =>
	// 		function($query)
	// 		{
	// 			$query->select('post_id', 'content', 'id');
	// 		})
	// 	)->where('id','>', 1)
	// 	->get( array('id', 'title') );

    // $data = Post::with(
    //     array('comments' => 
    //         function($query)
    //         {
    //             $query->where('status', '=', 1);
    //         }
    //     )
    // )->where('status', '=' , 0)
    //  ->get(array('id', 'content', 'user_id'));
    //  

// CREATE/INSERT
    // fields must be $fillable to allow Mass Assignment in this manner
    // all required $rules must be met
    // $data = Post::create( array('title' => 'A test post.', 'content' => 'something good', 'user_id' => 1) );

// EACH
	// $users = User::with('roles.perms')->find(1);
	// $permissions = array();

	// $users->roles->each(function($role) use(&$permissions)
	// {
	// 	$permissions = array_merge($permissions, $role->perms->toArray());
	// });

	// $data =  $permissions;


/*_______ FLUENT QUERY BUILDER using the DB class _________*/
	//$data = DB::table('users')->last();

	//$data = DB::table('users')->where('id' , 4)->delete();
	//dd($data);
	 // $data = DB::select('select * from users where id = 1');            // RAW
     // $data = DB::select('select * from users where id = ?', array(2));  // PDO

     // $data = DB::table('posts')->get( array('id AS foo', 'title', 'content') );
     // $data = DB::table('users')->lists('username', 'password');
     // $data = DB::table('users')->where('username', '=', 'marc')->get(array('username', 'password'));
     // $data = DB::table('users')->whereIn('id', array(1,2))->select('username AS name')->get();
     //$data = DB::table('users')->whereRaw('username LIKE ? AND email LIKE ?', array('%a%', '%n%'))->get();

// 	ADD SELECT
	// $data = DB::table('users')->select('username');
	// $data = $data->addSelect('password')->get();

// JOINS (can be run with ORM but maybe a little slower)
	// $data = DB::table('users')
	// 	->join('posts', 'users.id', '=', 'posts.user_id')
	// 	->join('comments', 'posts.id', '=', 'comments.post_id')
	// 	->get( array('users.id AS userID', 'posts.title AS postTitle', 'comments.content AS comment') );

// JOIN WITH WHERE
	// $data = DB::table('users')
	// 	->join('posts', 'users.id', '=', 'posts.user_id')->where('posts.id', '>', 1)
	// 	->get( array('users.id AS userID', 'posts.id AS postID', 'posts.title AS postTitle') );

// JOIN WITH WHERE & CLOSURE
	// $data = DB::table('users')
	// 	->join('posts', 
	// 		function($join) 
	// 		{
	// 			$join->on('users.id', '=', 'posts.user_id')
	// 			->where('posts.id', '>', 1);
	// 		}
	// 	)
	// 	->get( array('users.id AS userID', 'posts.id AS postID', 'posts.title AS postTitle') );


	// $data = DB::table('posts')
	// 	->where('posts.id','>', 1)
	// 	->join('comments', 'posts.id', '=', 'comments.post_id')       
	// 	->get( array('comments.content', 'comments.id', 'posts.title') );

	// $data = DB::table('users')
	// 	->leftjoin('posts', 'users.id', '=', 'posts.user_id')
	// 	->whereNotNull('posts.id')
	// 	->select('users.username', 'posts.id AS postID')
	// 	->get();

// UNION
	// $string = DB::table('users')->whereNotNull('username');
	// $data   = DB::table('users')->whereNull('password')->union($string)->get();
     	
        // QBuilder returns dumb array; ORM returns Collection AS JSON using toString() 
 		
 		if (is_string($data)) {
			echo '<pre>';
			echo $data;
			echo '</pre>';
 		} else {
 			$data = (!is_array($data)) ? json_decode($data) : $data;
			echo '<pre>';
			echo json_encode($data, JSON_PRETTY_PRINT);
			echo '</pre>';
 		} 
		
	}

}