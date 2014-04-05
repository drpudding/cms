<?php

class AdminBlogsController extends AdminController {

    /**
     * Post Model
     * @var Post
     */
    protected $post;

    /**
     * Inject the models.
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        parent::__construct();
        $this->post = $post;
    }

    /**
     * Display Blogs List
     *
     * @return View
     */
    public function getIndex()
    {

        $section = 'blog'; // singular of URL: admin/[section]
        $title = Lang::get('admin/blogs/title.blog_management');
        $columns = array('checkbox', 'ID', 'Title', 'Comments', 'Status',  'Created', 'Actions');

        return View::make('admin/list', compact('section', 'title', 'columns', 'filters'));
    }

    /**
     * Return Blog List data, formatted for Datatable
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $query = $this->post->with('comments')
            ->orderBy('status', 'asc')
            ->get();

        $table = Datatable::collection($query);

         return $table
            
            ->addColumn('checkbox', function($model) { return '<input type="checkbox" name="ids[]" value="' . $model->id . '">'; })
            ->showColumns('id', 'title') // add these columns
            ->addColumn('comments', function($model) { return $model->comments->count(); })
            ->addColumn('status', function($model) { 

                switch($model->status) {
                    case 1: $s  = 'active'; break;
                    case 2: $s  = 'archive'; break;
                    default: $s = 'inactive';
                }
                return $s;})

            ->addColumn('created_at', function($model) { return $model->getPresenter()->created_at; })      // using Presenter
            ->addColumn('dropdown', function($model) 
            { 
                return '<div class="btn-group tr-action">
                            <a class="btn-default btn btn-xs iframe" href="' . URL::to('admin/blogs/' . $model->id . '/edit' ) . '" class="iframe">' . Lang::get('button.edit') . '</a>
                            <button class="btn-default btn btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="' . URL::to('admin/blogs/' . $model->id . '/edit' ) . '" class="iframe">' . Lang::get('button.edit') . '</a></li>
                                <li><a href="' . URL::to('admin/blogs/' . $model->id . '/delete' ) . '" class="iframe">' . Lang::get('button.delete') . '</a></li>
                            </ul>
                        </div>';
            })
            ->searchColumns('id', 'title', 'status', 'created_at')
            //->orderColumns('id', 'status', 'created_at')
            ->make();
    }

	/**
	 * Display Create New User form
	 *
	 * @return Response
	 */
	public function getCreate()
	{
        $title = Lang::get('admin/blogs/title.create_a_new_blog');

        return View::make('admin/blogs/edit', compact('title'));
	}

	/**
	 * Store the New Blog
     * $this->post is a new Blog object
	 *
	 * @return Response
	 */
	public function postCreate()
	{
        // Get the author as the logged in user
        $user = Auth::user();

        // Get the blog post data
        $this->post->title            = Input::get('title');
        $this->post->slug             = Str::slug(Input::get('title'));
        $this->post->content          = Input::get('content');
        $this->post->meta_title       = Input::get('meta_title');
        $this->post->meta_description = Input::get('meta_description');
        $this->post->meta_keywords    = Input::get('meta_keywords');
        $this->post->user_id          = $user->id;

        $this->post->save();

         // Success
        if ( $this->post->id ) {

            echo "<script>parent.location.reload(true); parent.jQuery.colorbox.close();</script>";

            return Redirect::to('admin/blogs')->with('success', Lang::get('admin/blogs/messages.create.success'));
        }

        $error = $this->post->errors()->all(); // as array, not MessageBag

        return Redirect::to('admin/blogs/create')->with( 'error', $error );
	}

    /**
     * Display the Edit Blog post form
     *
     * @param $post
     * @return Response
     */
	public function getEdit( $post )
	{
        // Title
        $title = Lang::get('admin/blogs/title.blog_update');

        // Show the page
        return View::make('admin/blogs/edit', compact('post', 'title'));
	}

    /**
     * Process the Edit Post form.
     *
     * @param $post
     * @return Response
     */
	public function postEdit( $post )
	{
        // Update the blog post data
        $post->status           = Input::get('status');
        $post->title            = Input::get('title');
        $post->slug             = Str::slug(Input::get('title'));
        $post->content          = Input::get('content');
        $post->meta_title       = Input::get('meta_title');
        $post->meta_description = Input::get('meta_description');
        $post->meta_keywords    = Input::get('meta_keywords');

        $post->save();

        // Get validation errors
        $error = $post->errors()->all(); // as array, not MessageBag

        if (empty($error)) {

            echo "<script>parent.location.reload(true); parent.jQuery.colorbox.close();</script>";

            return Redirect::to('admin/blogs')->with('success', Lang::get('admin/blogs/messages.update.success'));
        }

            // Return to Edit form, with errors
            return Redirect::to('admin/blogs/' . $post->id . '/edit')->with('error', $error);
	}

    /**
     * Display Delete Post form
     *
     * @param $post
     * @return Response
     */
    public function getDelete( $post )
    {
        // Title
        $title = Lang::get('admin/blogs/title.blog_delete');
        $section = 'post';

        return View::make('admin/delete', compact('post', 'title','section'));
    }

    /**
     * Process Delete Post form
     *
     * @param $post
     * @return Response
     */
    public function postDelete( $post )
    {

        $id = $post->id;
        $post->forceDelete();

        // Confirm Deletion
        $post = $this->post->find($id);

        if (empty($post))
        {
            echo "<script>parent.location.reload(true); parent.jQuery.colorbox.close();</script>";

            return Redirect::to('admin/blogs')->with('success', Lang::get('admin/blogs/messages.delete.success'));
        }

        // There was a problem deleting the blog post
        return Redirect::to('admin/blogs')->with('error', Lang::get('admin/blogs/messages.delete.error'));
    }

    /**
     * Display the specified resource.
     *
     * @param $post
     * @return Response
     */
    public function getShow( $post )
    {
        // redirect to the frontend
    }

    /**
     * Process the Bulk Action form
     * 
     * @return Response
     */
    public function postBulk() {

        // Get form data
        $action = Input::get('action');
        $ids    = Input::get('id') ? Input::get('id') : Input::get('ids');

        $count = Functions::bulkProcess($this->post, $ids, $action);
       
        if ($count > 0) {

             $message = $count . ($count == 1 ? ' record was ' : ' records were ') . $action . 'd.';

            // Redirect to List
            return Redirect::to('admin/blogs/')->with('success', $message);

        }
        
        return Redirect::to('admin/blogs/')->with('error', 'No records were ' . $action . 'd.');
    }
}