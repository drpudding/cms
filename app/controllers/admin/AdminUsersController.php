<?php

/*
|--------------------------------------------------------------------------
| Overview
|--------------------------------------------------------------------------
|
| Uses Dependency Injection to inject required objects
| All admin routes require login and permissions (see, routes & filters).
| Colorbox modal is in use for all forms.
| User list is gotten using DataTable, using common list & datatable view templates (see, $section var)
| Pass $section to a common delete template, as well. 
| This user controller does not manage role permissions; so removed
| User role is a required field. (sync would otherwise break if empty)
|
| Datatable debugging options:
    1. return print_r($model, true) in an addColumn function to see what the model is returning
    2. If a column is missing data, do this -

    ->addColumn('post', function($model) {
            return empty($model->post) ? 'No post' : $model->post->title;
        })
*/

class AdminUsersController extends AdminController {

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Role Model
     * @var Role
     */
    protected $role;

    /**
     * Inject the objects
     * @param User $user
     * @param Role $role
     */
    public function __construct(User $user, Role $role)
    {
        parent::__construct();
        $this->user       = $user;
        $this->role       = $role;
    }

    /**
     * Display Users List
     * uses Ajax getData to return the list in DataTable
     *
     * @return Response
     */
    public function getIndex()
    {

        $section = 'user'; // singular of URL: admin/[section]
        $title = Lang::get('admin/users/title.user_management');
        $columns = array('checkbox', 'ID', 'Username', 'Email', 'Roles', 'Status', 'Created', 'Actions');

        return View::make('admin/list', compact('section', 'title', 'columns', 'filters'));
    }

     /**
     * Return Users List data, formatted for Datatable
     * 
     * @return Datatables JSON
     */
    public function getData()
    {
  
        $query = DB::table('users')
            ->select(array('users.id AS user_id', 'users.username','users.email',  DB::raw('GROUP_CONCAT( roles.name SEPARATOR \'<br>\') AS roles'), 'users.confirmed', 'users.created_at AS user_created_at'))
            ->leftjoin('assigned_roles', 'assigned_roles.user_id', '=', 'users.id')
            ->leftjoin('roles', 'roles.id', '=', 'assigned_roles.role_id')
            ->groupBy('users.id');

         return Datatable::query($query) // as COLLECTION
         
            ->addColumn('checkbox', function($model) { return '<input type="checkbox" name="ids[]" value="' . $model->user_id . '">'; })
            ->showColumns('user_id', 'username', 'email', 'roles') // add these columns
            ->addColumn('confirmed', function($model) { return ($model->confirmed > 0) ? 'active' : 'inactive'; })   // conditional
            ->addColumn('user_created_at', function($model) { return String::date(Carbon::createFromFormat('Y-m-d H:i:s', $model->user_created_at)); })
            ->addColumn('dropdown', function($model) // some action items, wrapped in a dropdown
            { 

                return '<div class="btn-group tr-action">
                            <a class="btn-default btn btn-xs iframe" href="' . URL::to('admin/users/' . $model->user_id . '/edit' ) . '" class="iframe">' . Lang::get('button.edit') . '</a>
                            <button class="btn-default btn btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="' . URL::to('admin/users/' . $model->user_id . '/edit' ) . '" class="iframe">' . Lang::get('button.edit') . '</a></li>' .  
                            ($model->username != 'admin' ? 
                            '<li><a href="' . URL::to('admin/users/' . $model->user_id . '/delete' ) . '" class="iframe">' . Lang::get('button.delete') . '</a></li>' : '');
                            '</ul>
                        </div>';
            })
            ->searchColumns('user_id', 'username') // server side (required)
            //->orderColumns('username') // server side (use to restrict; otherwise all are sortable)
            ->make();
    }

    /**
     * Return Users List data, formatted for Datatable
     * 
     * @return Datatables JSON
     */
    public function getDataSavw()
    {
            
        $query = $this->user->with('roles')
        ->orderBy('confirmed', 'asc')
        ->orderBy('created_at', 'desc')
        ->get(); // use eager loading (use relationship names)

         return Datatable::query($query) // as COLLECTION
         
            ->addColumn('checkbox', function($model) { return '<input type="checkbox" name="ids[]" value="' . $model->id . '">'; })
            ->showColumns('id', 'username', 'email') // add these columns
            ->addColumn('roles', function($model) {  // get data via realtionship

                $roles = '';

                $model->roles->each(function($role) use (&$roles)
                    {
                        $roles .= $role->name . '<br>';
                    });

                return $roles;
            })
            ->addColumn('status', function($model) { return ($model->confirmed > 0) ? 'active' : 'inactive'; })   // conditional
            ->addColumn('created_at', function($model) { return $model->getPresenter()->created_at; })      // using Presenter
            ->addColumn('dropdown', function($model) // some action items, wrapped in a dropdown
            { 

                return '<div class="btn-group tr-action">
                            <a class="btn-default btn btn-xs iframe" href="' . URL::to('admin/users/' . $model->id . '/edit' ) . '" class="iframe">' . Lang::get('button.edit') . '</a>
                            <button class="btn-default btn btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="' . URL::to('admin/users/' . $model->id . '/edit' ) . '" class="iframe">' . Lang::get('button.edit') . '</a></li>' .  
                            ($model->username != 'admin' ? 
                            '<li><a href="' . URL::to('admin/users/' . $model->id . '/delete' ) . '" class="iframe">' . Lang::get('button.delete') . '</a></li>' : '');
                            '</ul>
                        </div>';
            })
            ->searchColumns('id', 'username', 'email', 'created_at')    // server side; add bSearchable to client-side (optional)
            //->orderColumns('id', 'username', 'confirmed', 'created_at') // server side; add bSortable to client-side (yes!)r
            ->make();
    }

    /**
     * Display Create New User form
     * Displayed in ColorBox
     *
     * @return Response
     */
    public function getCreate()
    {
        $title = Lang::get('admin/users/title.create_a_new_user');

        // Get all roles
        $roles = $this->role->orderBy('name', 'ASC')->get();

        // Get selected (if validation fails)
        $selectedRoles = Input::old('roles', array());

		// Mode
		$mode = 'create';

		// Show the form
		return View::make('admin/users/edit', compact('title', 'roles', 'selectedRoles', 'mode'));
    }

    /**
     * Store the New User
     * $this->user is a new user object
     *
     * @return Response
     */
    public function postCreate()
    {
        // Get form data and set to a user object
        $this->user->username  = Input::get( 'username' );
        $this->user->email     = Input::get( 'email' );
        $this->user->confirmed = Input::get( 'confirmed' );
        $roles                 = Input::get( 'roles' ); // saved later

        // Test for password & confirmation
        if (Input::get('password')) {

            $this->user->password = Input::get('password');
            $this->user->password_confirmation = Input::get('password_confirmation'); // removed from model before saving
        }

        // Test for roles
        if (empty($roles)) {

            return Redirect::to('admin/users/create')
                ->withInput()
                ->with('error', Lang::get('admin/users/messages.create.role_required'));
        }

        // Save 
        $this->user->save(); // incl. password hash

        // Success
        if ( $this->user->id ) {

            // Reload list view & close Colorbox
            echo "<script>parent.location.reload(true); parent.jQuery.colorbox.close();</script>";

            // Save selected user roles (since nothing to detach, see options)
            // $this->user->saveRoles($roles); works, but unecessary
            // $this->user->roles()->attach($roles); // works, since add only
            $this->user->roles()->sync($roles); // works to attach & detach

            // Redirect to List View, with success
            return Redirect::to('admin/users/')->with('success', Lang::get('admin/users/messages.create.success'));
            // return Redirect::to('admin/users/' . $this->user->id . '/edit')
            //     ->with('success', Lang::get('admin/users/messages.create.success'));
        }

        // Fail: get validation errors
        $error = $this->user->errors()->all(); // as array to show at top, not MessageBag to show inline
        //$errors = $this->user->errors(); // as a MessageBag to show inline, not at top

        // Return to Create, with error array
        return Redirect::to('admin/users/create')->withInput(Input::except('password'))->with( 'error', $error ); // error array
        //return Redirect::to('admin/users/create')->withInput(Input::except('password'))->withErrors( $errors ); // error Message Bag
    }

    /**
     * Display the Edit User form
     * $user is an existing user object
     * @param $user
     * @return Response
     */
    public function getEdit( $user )
    {
        // We have a User
        if ( $user->id ) {
            // Title
            $title = Lang::get('admin/users/title.user_update');

            // Get all roles (using Role model)
            $roles = $this->role->orderBy('name', 'ASC')->get();

            // Get this user's roles, as an array
            $currentRoleIds = $user->currentRoleIds();

            // Get selected roles
            $selectedRoles = Input::old('roles', array());

        	// Mode
        	$mode = 'edit';

        	return View::make('admin/users/edit', compact('user', 'title', 'roles', 'currentRoleIds', 'selectedRoles', 'mode'));
        }

            return Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.does_not_exist'));
    }

    /**
     * Process the Edit User form.
     * 
     * MAC -- removed the BSS Laravel validation, as it seemed to be a problem
     * @param $user
     * @return Response
     */
    public function postEdit( $user )
    {
        // Get form data
        $user->username     = Input::get('username');
        $user->email        = Input::get('email');
        $user->confirmed    = Input::get('confirmed');
        $roles              = Input::get( 'roles' );

        if (Input::get('password')) {

            $user->password = Input::get('password');
            $user->password_confirmation = Input::get('password_confirmation');
        }

        // Test for roles
        if (empty($roles)) {
            return Redirect::to('admin/users/' . $user->id . '/edit')
                ->withInput()
                ->with('error', Lang::get('admin/users/messages.update.role_required'));
        }

         // Save (using Ardent method)
        $user->updateUniques();

        // Get validation errors
        $error = $user->errors()->all(); // as array, not MessageBag

        if (empty($error)) {

            // Reload list & close Colorbox
             echo "<script>parent.location.reload(true); parent.jQuery.colorbox.close();</script>";

            // Save selected user roles (since possible detach, see options)
            // $user->saveRoles($roles); works, but unecessary
            // $user->roles()->attach($roles); // wont't work to detach
            $user->roles()->sync($roles); // works to attach & detach

            // Redirect to List
            return Redirect::to('admin/users/')->with('success', Lang::get('admin/users/messages.update.success'));
            // return Redirect::to('admin/users/' . $user->id . '/edit')
            //     ->with('success', Lang::get('admin/users/messages.update.success'));
        }

            // Return to Edit form, with errors
            return Redirect::to('admin/users/' . $user->id . '/edit')->with('error', $error);
    }

    /**
     * Display Delete User form
     *
     * @param $user
     * @return Response
     */
    public function getDelete( $user )
    {
        // Title
        $title = Lang::get('admin/users/title.user_delete');
        $section = 'user';
        return View::make('admin/delete', compact('user', 'title', 'section'));
    }

    /**
     * Process Delete User form
     *
     * @param $user
     * @return Response
     */
    public function postDelete( $user )
    {
        // Prevent self-deletion
        if ($user->id === Confide::user()->id) {

            // Reload list & close Colorbox
            echo "<script>parent.location.reload(true); parent.jQuery.colorbox.close();</script>";

            return Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.delete.impossible'));
        }

        $id = $user->id; // get the User id to confirm delete
        $user->forceDelete(); // delete

        // Confirm Deletion
        $user = $this->user->find($id);

        if ( empty($user) ) {

            // MAC: workaround: leaving modal up with back button (otherwise loads list into modal)
            // $data['message'] = Lang::get('admin/users/messages.delete.success');
            // $data['title']   = 'Success!';
            // return View::make('admin/message_modal', $data);

            // Reload list & close Colorbox
            echo "<script>parent.location.reload(true); parent.jQuery.colorbox.close();</script>";

            return Redirect::to('admin/users')->with('success', Lang::get('admin/users/messages.delete.success'));
        }
            // There was a problem deleting the user
            return Redirect::to('admin/users')->with('error', Lang::get('admin/users/messages.delete.error'));
    }

    /**
     * View a User
     * not in use
     *
     * @param $id
     * @return Response
     */
    public function getShow( $user )
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

        $count = Functions::bulkProcess($this->user, $ids, $action);
       
        if ($count > 0) {

             $message = $count . ($count == 1 ? ' record was ' : ' records were ') . $action . 'd.';

            // Redirect to List
            return Redirect::to('admin/users/')->with('success', $message);

        }
        
        return Redirect::to('admin/users/')->with('error', 'No records were ' . $action . 'd.');
    }
}
