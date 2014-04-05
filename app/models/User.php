<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\Confide;
use Zizaco\Confide\ConfideEloquentRepository;
use Zizaco\Entrust\HasRole;
use Robbo\Presenter\PresentableInterface;

class User extends ConfideUser implements PresentableInterface {
    use HasRole;

	/**
	 * Database table used by the model.
     * 
	 * @var string
	 */
	protected $table = 'users';

    /**
     * Soft delete
     * 
     * @var string
     */
    protected $softDelete = true;
    
    /**
     * Presenter
     * 
     * @return Presenter object
     */
    public function getPresenter()
    {
        return new UserPresenter($this);
    }

     /**
     * Relationships (using Ardent syntax)
     * 
     * @var array
     */
    public static $relationsData = array(
        'comments' => array(self::HAS_MANY, 'Comment')  // Get the user's comments
    );

    /**
     * Validation
     * see lang/en/validation.php for language
     *
     * @var array
     */
    public static $rules = array(
        'username'              => 'required|between:4,12|alpha_dash|unique:users',
        'email'                 => 'required|email|unique:users',
        'password'              => 'required|between:4,12|confirmed',
        'password_confirmation' => 'between:4,12'
    );

    // sample event on "creating" a record
    // public static function boot()
    // {
    //     parent::boot();

    //     User::creating(function($user)
    //     {
    //         if ( $user->username != 'fooby') return false;
    //     });
    // }


    // SCOPES

    /**
     * Get user by username (for public profile)
     * 
     * @param string $username
     * @return mixed
     */
    public function getUserByUsername( $username)
    {
        return $this->where('username', '=', $username)->first();
    }
   
    // public function scopeByUsername( $query, $username)
    // {
    //     return $query->whereUsername($username)->first();
    // }

    // METHODS

    /**
     * Get the currently authenticated user or null
     * 
     * @return Zizaco\Confide\ConfideUser|null
     */
    public function currentUser()
    {
        return (new Confide(new ConfideEloquentRepository()))->user();
    }

    /**
     * NOT IN USE (moved to controller)
     * Save User Roles - input from multiselect
     * If none are selected, delete 'em all
     * @param $inputRoles
     */
    public function saveRoles($inputRoles)
    {
        if (!empty($inputRoles)) {

            $this->roles()->sync($inputRoles);

        } else {

            $this->roles()->detach();
            
        }
    }

    /**
     * Returns User's current roles: as array($roleID=>$roleName)
     * 
     * @return array|bool
     */
    public function currentRoleIds()
    {
        $roles = $this->roles; // get the user's Role object
        $roleIds = false;

        if ( !empty( $roles ) ) { // returns true even if no roles

            $roleIds = array();
            foreach( $roles as &$role )
            {
                $roleIds[$role->id] = $role->name;
            }
        }

        return $roleIds;
    }

    /**
     * Handles two types of redirection after User authentication
     * 
     * 1. if ifValid = false
     *     - a guest is $redirectTo log in then on to their $destination (stored in SESSION)
     *       once they return as a user, they simply pass thru to View::make() in action
     *       
     * 2. if ifValid = true
     *     - a guest will ERROR, since it goes to View::make('user') with no user object
     *     - a user will ERROR unless the destination is not the same action that invoked the check
     *
     * 
     * @param $redirect
     * @param bool $ifValid
     * @return mixed
     */
    public static function checkAuthAndRedirect($destination, $ifValid = false)
    {

        $user = Auth::user();
        $redirectTo = false;

        // Guest & ifValid = false
        // force log in via $redirectTo & store $destination in SESSION
        if (empty($user->id) && ! $ifValid) {

            Session::put('loginRedirect', $destination);
            $redirectTo = Redirect::to('user/login')
                ->with( 'notice', Lang::get('user/user.login_first') );

        // User and inValid = true
        // redirect the user to the destination $redirect page
        } elseif (!empty($user->id) && $ifValid) {

            $redirectTo = Redirect::to($destination);
        }

        return array($user, $redirectTo);
    }
}