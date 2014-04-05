<?php

class AdminCommentsController extends AdminController
{

    /**
     * Comment Model
     * @var Comment
     */
    protected $comment;

    /**
     * Inject the models.
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        parent::__construct();
        $this->comment = $comment;
    }

    /**
     * Display Comments List
     *
     * @return View
     */
    public function getIndex()
    {

        $section = 'comment'; // singular of URL: admin/[section]
        $title = Lang::get('admin/comments/title.comment_management');
        $columns = array('checkbox', 'ID', 'Comment', 'Status', 'Author', 'Post', 'Created', 'Actions');

        return View::make('admin/list', compact('section', 'title', 'columns', 'filters'));
    }

    /**
     * Return Comments List data, formatted for Datatable
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $query = $this->comment->with('author', 'post')
                ->orderBy('status', 'asc')
                ->get();

         return Datatable::collection($query)
            
            ->addColumn('checkbox', function($model) { return '<input type="checkbox" name="ids[]" value="' . $model->id . '">'; })
            ->showColumns('id') // add these columns
            ->addColumn('comment', function($model) { return Str::limit($model->content, 40, '&hellip;'); })
            ->addColumn('status', function($model) { return ($model->status > 0) ? 'active' : 'inactive'; })   // conditional
            ->addColumn('author', function($model) // with link to comment author
            { 
                return '<a href="' . URL::to('admin/users/'. $model->author->id .'/edit')  . '" class="iframe cboxElement">' . 
                    $model->author->username . '</a>';
            })
            ->addColumn('post', function($model)  // with link to comment's post
            { 
                return '<a href="' . URL::to('admin/blogs/'. $model->post->id .'/edit')  . '" class="iframe cboxElement">' . 
                    Str::limit($model->post->slug, 40, '&hellip;') . '</a>';
             }) 
            ->addColumn('created_at', function($model) { return $model->getPresenter()->created_at; })  // using Presenter
            ->addColumn('dropdown', function($model) 
            { 
                return '<div class="btn-group tr-action">
                            <a class="btn-default btn btn-xs iframe" href="' . URL::to('admin/comments/' . $model->id . '/edit' ) . '" class="iframe">' . Lang::get('button.edit') . '</a>
                            <button class="btn-default btn btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="' . URL::to('admin/comments/' . $model->id . '/edit' ) . '" class="iframe">' . Lang::get('button.edit') . '</a></li>
                                <li><a href="' . URL::to('admin/comments/' . $model->id . '/delete' ) . '" class="iframe">' . Lang::get('button.delete') . '</a></li>
                            </ul>
                        </div>';
            })
            ->searchColumns('id','comment','status','author', 'created_at')
            //->orderColumns('id', 'status', 'created_at')
            ->setSearchStrip() // strips html/php tags before search
            //->setOrderStrip() // strips html/php tags before order
            ->make();
    }

    /**
     * Display Edit Comment form
     *
     * @param $comment
     * @return Response
     */
	public function getEdit( $comment )
	{

        $title = Lang::get('admin/comments/title.comment_update');

        return View::make('admin/comments/edit', compact('comment', 'title'));
	}

    /**
     * Process Edit Comment form
     *
     * @param $comment
     * @return Response
     */
	public function postEdit( $comment )
	{

        // Update the comment post data
        $comment->content = Input::get('content');
        $comment->status  = Input::get('status');

        $comment->save();

        $error = $comment->errors()->all(); // as array, not MessageBag

        // Was the comment post updated?
        if(empty($error))
        {
            echo "<script>parent.location.reload(true); parent.jQuery.colorbox.close();</script>";

            return Redirect::to('admin/comments')->with('success', Lang::get('admin/comments/messages.update.success'));
        }
 
         return Redirect::to('admin/comments/' . $comment->id . '/edit')->with('error', $error);
	}

    /**
     * Display Delete Comment form
     *
     * @param $comment
     * @return Response
     */
	public function getDelete( $comment )
	{
        $title = Lang::get('admin/comments/title.comment_delete');
        $section = 'comment';
        return View::make('admin/delete', compact('comment', 'title', 'section'));
	}

    /**
     * Process Delete Comment form
     *
     * @param $comment
     * @return Response
     */
	public function postDelete( $comment )
	{

        $id = $comment->id;
        $comment->forceDelete();

        $comment = $this->comment->find($id);

        if(empty($comment))
        {
            echo "<script>parent.location.reload(true); parent.jQuery.colorbox.close();</script>";

            return Redirect::to('admin/comments')->with('success', Lang::get('admin/comments/messages.delete.success'));
        }
            // There was a problem deleting the comment post
            return Redirect::to('admin/comments')->with('error', Lang::get('admin/comments/messages.delete.error'));
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

        $count = Functions::bulkProcess($this->comment, $ids, $action);
       
        if ($count > 0) {

             $message = $count . ($count == 1 ? ' record was ' : ' records were ') . $action . 'd.';

            // Redirect to List
            return Redirect::to('admin/comments/')->with('success', $message);

        }
        
        return Redirect::to('admin/comments/')->with('error', 'No records were ' . $action . 'd.');
    }
}
