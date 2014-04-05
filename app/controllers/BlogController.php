<?php

class BlogController extends BaseController {

    /**
     * Post Model
     * @var Post
     */
    protected $post;

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Inject the models.
     * @param Post $post
     * @param User $user
     */
    public function __construct(Post $post, User $user)
    {
        parent::__construct();

        $this->post = $post;
        $this->user = $user;
    }
    
	/**
	 * Display Blog Posts list
	 *
	 * @return View
	 */
	public function getIndex()
	{
		$title = 'Blog';
		// MAC: out -- see my more efficient Eager Loading 
		// $posts = $this->post->orderBy('created_at', 'DESC')->paginate(10);

		/*
			Eager Loading Posts
			- with comments, since Post has hasMany comments relationship
			- with comments.author, since Comment has belongTo user relationship
			- and that relationship is defined as 'author'
			- using closure for comments to include BOTH a where & an orderBy clause
		 */
		$posts = $this->post
			->with(
				array(
					'comments' => function($query)
						{
    						$query
    							->where('status', '=', 1)
    							->orderBy('created_at', 'DESC');
						},
					'comments.author'
				)
			)
			->where('status', '=', 1)
			->orderBy('created_at', 'DESC')->paginate(10);

		return View::make('site/blog/index', compact('posts','title'));
	}

	/**
	 * Display a blog post.
	 *
	 * @param  string  $slug
	 * @return View
	 * @throws NotFoundHttpException
	 */
	public function getView( $slug )
	{
		//$post = $this->post->where('slug', '=', $slug)->first();

		// Eager Loading Posts
		$post = $this->post->with(
				array('comments' => function($query)
						{
    						$query->where('status', '=', 1)
    							->orderBy('created_at', 'DESC');
						},
					'comments.author'
				)
			)
			->where('status', '=', 1)
			->where('slug', '=', $slug)->first();

		// Check if the blog post exists
		if (is_null($post)) {

			return View::make('error/404');
		}

		$title = $post->title;
		// Get this post comments
		// MAC: out (see Eager Loading above))
		// $comments = $post->comments()->orderBy('created_at', 'ASC')->get();

        // canComment? Will allow commenting, if true
		$canComment = false;
		$user       = $this->user->currentUser(); // Get current user, if log in

        if(!empty($user)) {
            $canComment = $user->can('post_comment'); // check permission
        }

		//return Response::json($post);
		return View::make('site/blog/view_post', compact('post', 'canComment', 'title'));
	}

	/**
	 * Store a Comment.
	 *
	 * @param  string  $slug
	 * @return Redirect
	 */
	public function postView( $slug )
	{
		// can this user Commit?
		$user       = $this->user->currentUser(); //get the user
		$canComment = $user->can('post_comment'); // check their permissions

		if (!$canComment) {

			return Redirect::to('blog/' . $slug . '#commentsubmit')
				->with('error', 'You need to be logged in to post comments!');
		}

		// Return post using slug from /blog/slug URL
		$post = $this->post->where('slug', '=', $slug)->first();

		// Save the new comment
		$comment = new Comment;
		$comment->user_id = Auth::user()->id;
		$comment->content = Input::get('content');

		// Attaching a related model, by first getting the post
		// This will auto add the post_id to this comment record
		if ( $post->comments()->save($comment) ) {
			
			return Redirect::to('blog/' . $slug)->with('success', 'Your comment has been submitted and will be posted shortly.');
		}

		$error = $comment->errors()->all();

		return Redirect::to('blog/' . $slug . '#commentsubmit')->with('error', $error);
	}
}
