<?php

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{

    /**
     * Database table used by the model.
     * 
     * @var string
     */
    protected $table = 'permissions';

    /**
     * Soft delete
     * 
     * @var string
     */
    protected $softDelete = true;

    // RELATIONSHIPS (see EntrustPermission)

    /**
     * Validation
     * 
     * @var array
     */
    public static $rules = array(
      'name' => 'required|between:4,32',
      'display_name' => 'required|between:4,32'
    );

    /**
     * NOT IN USE
     * 
     * [preparePermissionsForDisplay description]
     * @param  $permissions
     * @return array
     */
    public function preparePermissionsForDisplay($permissions)
    {
        // Get all the available permissions
        $availablePermissions = $this->orderBy('display_name', 'ASC')->get()->toArray();

        // MAC: walk thru ALL permissions and check those assigned to the role
        // then return the permissions array
        foreach($permissions as &$permission) {
            array_walk($availablePermissions, function(&$value) use(&$permission){
                if ($permission->name == $value['name']) {
                    $value['checked'] = true;
                }
            });
        }
        return $availablePermissions;
    }

    /**
     * NOT IN USE
     * 
     * Convert Permissions form input array (checkboxes) to savable array.
     * @param $permissions
     * @return array
     */
    public function preparePermissionsForSave( $permissions )
    {
        $availablePermissions = $this->get()->toArray();
        $preparedPermissions = array();

        // MAC: walk thru the saved permissions and check it exists
        // then return the permissions array
        foreach( $permissions as $permission => $value )
        {
            // If checkbox is selected
            if ( $value == '1' ) {
                
                // If permission exists
                array_walk($availablePermissions, function(&$value) use($permission, &$preparedPermissions){
                    if ($permission == (int)$value['id']) {
                        $preparedPermissions[] = $permission;
                    }
                });
            }
        }
        return $preparedPermissions;
    }
}