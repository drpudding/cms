<?php

use Zizaco\Entrust\EntrustRole;
use Robbo\Presenter\PresentableInterface;

class Role extends EntrustRole implements PresentableInterface
{

    /**
     * Database table used by the model.
     * 
     * @var string
     */
    protected $table = 'roles';

    /**
     * Same presenter as the User model.
     * 
     * @return Robbo\Presenter\Presenter|UserPresenter
     */
    public function getPresenter()
    {
        return new UserPresenter($this);
    }

    // RELATIONSHIPS (see EntrustRole)

    /**
     * Validation
     * 
     * @var array
     */
    public static $rules = array(
        'name'  => 'required|unique:roles|between:4,16'
    );

    /**
     * Save Role permissions - input from multiselect
     * If none are selected, delete 'em all
     * 
     * @param $inputPermissions
     */
    public function savePermissions($inputPermissions)
    {
        if (!empty($inputPermissions)) {

            $this->perms()->sync($inputPermissions);

        } else {

            $this->perms()->detach();
        }
    }

    /**
     * Returns Role's current permissions: as array($permissionID=>$permissionName)
     * 
     * @return array|bool
     */
    public function currentPermissionIds()
    {
        $permissions = $this->perms; // get the Roles's Permission object
        $permissionIds = false;
        if( !empty( $permissions ) ) { // returns true even if no roles

            $permissionIds = array();
            foreach( $permissions as &$permission )
            {
                $permissionIds[$permission->id] = $permission->name;
            }
            
        }
        return $permissionIds;
    }
    
    /**
     * NOT IN USE
     * 
     * Provide an array of strings that map to valid roles.
     *
     * MAC: get the current authenticated user, via Confide.
     * Create a $roleValidation class, where each role is
     * a property and is set to true/false based on if current
     * user has the role.
     * 
     * @param array $roles
     * @return stdClass
     */
    public function validateRoles( array $roles )
    {
        $user = Confide::user();
        $roleValidation = new stdClass();
        foreach( $roles as $role )
        {
            // Make sure we have a valid user, then check if user has role.
            $roleValidation->$role = ( empty($user) ? false : $user->hasRole($role) );
        }
        return $roleValidation;
    }
}