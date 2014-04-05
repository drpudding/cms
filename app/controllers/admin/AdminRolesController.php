<?php

class AdminRolesController extends AdminController {

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
     * Permission Model
     * @var Permission
     */
    protected $permission;

    /**
     * Inject the models.
     * @param User $user
     * @param Role $role
     * @param Permission $permission
     */
    public function __construct(User $user, Role $role, Permission $permission)
    {
        parent::__construct();
        $this->user       = $user;
        $this->role       = $role;
        $this->permission = $permission;
    }
    
    /**
     * Display Role List
     *
     * @return Response
     */
    public function getIndex()
    {
        $section = 'role'; // singular of URL: admin/[section]
        $title   = Lang::get('admin/roles/title.role_management');
        $columns = array('ID', 'Name', 'Permissions', 'Users', 'Actions');

        $filters = array(

                array(
                    'fieldName'=>'role',
                    'optionNameFld'=>'name',
                    'optionValueFld'=>'id',
                    'data'=>DB::table('roles')->get()
                ),
                array(
                    'fieldName'=>'permission',
                    'optionNameFld'=>'display_name',
                    'optionValueFld'=>'id',
                    'data'=>DB::table('permissions')->get()
                )
            );

        // echo '<pre>';
        // print_r($filters);
        // echo '</pre>';
        // exit;
    
        return View::make('admin/list', compact('section', 'title', 'columns', 'filters'));
    }

    /**
     * Return Roles List data, formatted for Datatable
     * 
     * @return Datatables JSON
     */
    public function getData()
    {
        $query = $this->role->with('perms', 'users') // eager loading
                ->orderBy('name', 'desc')
                ->get();

        $table = Datatable::collection($query);

         return $table
            //->addColumn('checkbox', function($model) { return '<input type="checkbox" name="ids[]" value="' . $model->id . '">'; })
            ->showColumns('id', 'name') // add these columns
            //->addColumn('permissions', function($model) { return implode($model->currentPermissionIds(), '<br>'); })
            ->addColumn('permissions', function($model) {  // get data via realtionship

                $permissions = '';

                $model->perms->each(function($permission) use (&$permissions)
                    {
                        $permissions .= $permission->name . '<br>';
                    });

                return $permissions;
            })

            ->addColumn('users', function($model) { return $model->users->count(); }) // count on related model
            ->addColumn('dropdown', function($model) 
            { 
                return '<div class="btn-group tr-action">
                            <a class="btn-default btn btn-xs iframe" href="' . URL::to('admin/roles/' . $model->id . '/edit' ) . '" class="iframe">' . Lang::get('button.edit') . '</a>
                            <button class="btn-default btn btn-xs dropdown-toggle" type="button" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="' . URL::to('admin/roles/' . $model->id . '/edit' ) . '" class="iframe">' . Lang::get('button.edit') . '</a></li>
                                <li><a href="' . URL::to('admin/roles/' . $model->id . '/delete' ) . '" class="iframe">' . Lang::get('button.delete') . '</a></li>
                            </ul>
                        </div>';
            })
            ->searchColumns('id', 'name')
            //->orderColumns('id', 'name')
            ->make();
    }

    /**
     * Display Create New Role form
     *
     * @return Response
     */
    public function getCreate()
    {
        // Title
        $title = Lang::get('admin/roles/title.create_a_new_role');

        // Get all
        $permissions = $this->permission->orderBy('display_name', 'ASC')->get();

        // Get selected (if validation fails)
        $selectedPermissions = Input::old('permissions', array());

        // Mode
        $mode = 'create';

        // Show the form
        return View::make('admin/roles/edit', compact('title', 'permissions', 'selectedPermissions', 'mode'));
    }

    /**
     * Store the New Role
     *
     * @return Response
     */
    public function postCreate()
    {

        // Get form data and set to a role object
        $this->role->name = Input::get( 'name' );
        $permissions      = Input::get( 'permissions');

        if(empty($permissions))
        {
            return Redirect::to('admin/roles/create')
                ->withInput()
                ->with('error', Lang::get('admin/roles/messages.create.permission_required'));
        }

        // Save
        $this->role->save();

        // Success
        if ($this->role->id) {

            // Reload list & close Colorbox
            echo "<script>parent.location.reload(true); parent.jQuery.colorbox.close();</script>";

            // Save selected role permissions
            //$this->role->savePermissions($permissions);
            $this->role->perms()->sync($permissions);

            // Redirect to List
            return Redirect::to('admin/roles')->with('success', Lang::get('admin/roles/messages.create.success'));
        }

        // Fail: get validation errors
        $error = $this->role->errors()->all(); // as array, not MessageBag

        // Return to Create, with errors
        return Redirect::to('admin/roles/create')->with( 'error', $error );
    }

    /**
     * Display the Edit Role form
     *
     * @param $role
     * @return Response
     */
    public function getEdit( $role )
    {
        // Title
        $title = Lang::get('admin/roles/title.role_update');

        if(!empty($role))
        {

            // Get all
            $permissions = $this->permission->orderBy('display_name', 'ASC')->get();

            // Get this role's permissions, as an array
            $currentPermissionIds = $role->currentPermissionIds();

            // Get selected
            $selectedPermissions = Input::old('permissions', array());

            // Mode
            $mode = 'edit';

            // Show the page
            return View::make('admin/roles/edit', compact('role', 'title', 'permissions', 'currentPermissionIds', 'selectedPermissions', 'mode'));
        }

            return Redirect::to('admin/roles')->with('error', Lang::get('admin/roles/messages.does_not_exist'));
    }

    /**
     * Process the Edit Role form.
     *
     * @param $role
     * @return Response
     */
    public function postEdit( $role )
    {

        // Get form data
        $role->name        = Input::get('name');
        $permissions = Input::get( 'permissions' );
        
        if(empty($permissions))
        {
            return Redirect::to('admin/roles/' . $role->id . '/edit')
                ->withInput()
                ->with('error', Lang::get('admin/roles/messages.update.permission_required'));
        }

        // Save (using Ardent method)
        $role->save();

        // Get validation errors
        $error = $role->errors()->all(); // as array, not MessageBag

        if(empty($error)) {

            // Reload list & close Colorbox
             echo "<script>parent.location.reload(true); parent.jQuery.colorbox.close();</script>";

            // Save the selected role permissions
            // $role->savePermissions(Input::get( 'permissions' ));
            $role->perms()->sync($permissions);

            // Redirect to List
            return Redirect::to('admin/roles')->with('success', Lang::get('admin/roles/messages.update.success'));
        }

            // Return to Edit form, with errors
            return Redirect::to('admin/roles/' . $role->id . '/edit')->with('error', $error);
    }

    /**
     * Display Delete Role form
     *
     * @param $role
     * @return Response
     */
    public function getDelete( $role )
    {
        // Title
        $title   = Lang::get('admin/roles/title.role_delete');
        $section = 'role';
        
        // Show the page
        return View::make('admin/delete', compact('role', 'title', 'section'));
    }

    /**
     * Process Delete Role form.
     *
     * @param $role
     * @internal param $id
     * @return Response
     */
    public function postDelete( $role )
    {
        $id = $role->id; // get the role id to confirm delete
        $role->delete(); // delete

        // Confirm Deletion
        $role = $this->role->find($id);

        if (empty($role)) {

            echo "<script>parent.location.reload(true); parent.jQuery.colorbox.close();</script>";
            
            return Redirect::to('admin/roles')->with('success', Lang::get('admin/roles/messages.delete.success'));
        }

            // There was a problem deleting the user
            return Redirect::to('admin/roles')->with('error', Lang::get('admin/roles/messages.delete.error'));
    }

    /**
     * View a role
     * Not in use
     *
     * @param $role
     * @return Response
     */
    public function getShow( $role )
    {
        // redirect to the frontend
    }

}