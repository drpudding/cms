<?php

class UserController extends BaseController {

    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Inject the models.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Display Manage Account form
     * requires a logged in user
     *
     * @return View
     */
    public function getIndex()
    {
        $title = 'Manage Account';

        list($user,$redirectTo) = $this->user->checkAuthAndRedirect('user');
        if ($redirectTo){ return $redirectTo; }

        // Show the page
        return View::make('site/user/index', compact('user', 'title'));
    }

    /**
     * Display the Sign Up form
     *
     */
    public function getCreate()
    {
        $title = 'Sign up';
        return View::make('site/user/create', compact('title'));
    }

    /**
     * Process the Sign Up form
     *
     */
    public function postCreate()
    {

        $this->user->username     = Input::get('username');
        $this->user->email        = Input::get('email');

        if (Input::get('password')) {

            $this->user->password = Input::get('password');
            $this->user->password_confirmation = Input::get('password_confirmation');
        }

        // Save if valid. Password field will be hashed before save
        $this->user->save();

        if ( $this->user->id ) {

            // assign the default "user" role, if a new sign up
            $roleID = Config::get('site_settings.user_role_id');
            $this->user->attachRole( $roleID );

            // Redirect with success message and request to confirm.
            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('user/user.user_account_created') );

        } else {
            
            // Get validation errors (see Ardent package)
            $error = $this->user->errors()->all();

            return Redirect::to('user/create')
                ->with( 'error', $error );
        }
    }

    /**
     * Process Manage Account form
     * MAC: major update
     */
    public function postEdit( $user )
    {
        $user->username     = Input::get('username');
        $user->email        = Input::get('email');

        if (Input::get('password')) {

            $user->password              = Input::get('password');
            $user->password_confirmation = Input::get('password_confirmation');
        }
        
         // Save if valid. Password field will be hashed before save (see Ardent package)
        $user->updateUniques();

        // Get validation errors (see Ardent package)
        $error = $user->errors()->all();

        if (empty($error)) {

            return Redirect::to('user')
                ->with( 'success', Lang::get('user/user.user_account_updated') );

        } else {

            return Redirect::to('user')
                //->withInput(Input::except('password','password_confirmation'))
                ->with( 'error', $error );
        }
    }
    
    /**
     * Display Login form
     *
     */
    public function getLogin()
    {
        $title = 'Login';

        if ( Auth::check() ) {

            return Redirect::to('/');
        }

        return View::make('site/user/login', compact('title'));
    }

    /**
     * Process Login form
     * Accepts email or username + pw as a valid login
     *
     */
    public function postLogin()
    {
        $input = array(
            'email'    => Input::get( 'email' ), // May be the username too
            'username' => Input::get( 'email' ), // May be the username too
            'password' => Input::get( 'password' ),
            'remember' => Input::get( 'remember' ),
        );

        // Attempt Log in
        if ( Confide::logAttempt( $input, true ) ) { // true = only allow confirmed accounts
        
            $r = Session::get('loginRedirect'); // check for post login redirect
            
            if (!empty($r)) {

                Session::forget('loginRedirect'); // remove the stored redirect, then send there
                return Redirect::to($r);
            }
            return Redirect::to('/');
        
        // Fail
        } else {
        
            // Check if there were too many login attempts
            if ( Confide::isThrottled( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
            // MAC: checkUserExists() & isConfirmed() are deprecated
            } elseif ( $this->user->checkUserExists( $input ) && ! $this->user->isConfirmed( $input ) ) {
                $err_msg = Lang::get('confide::confide.alerts.not_confirmed');
            } else {
                $err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
            }

            return Redirect::to('user/login')
                ->withInput(Input::except('password'))
                ->with( 'error', $err_msg );
        }
    }

    /**
     * Attempt Account Confirmation by code
     *
     * @param  string  $code
     */
    public function getConfirm( $code )
    {
        if ( Confide::confirm( $code ) ) {

            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.confirmation') );

        } else {

            return Redirect::to('user/login')
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_confirmation') );
        }
    }

    /**
     * Display Forgot Password (Password Reset) form
     *
     */
    public function getForgot()
    {
        return View::make('site/user/forgot');
    }

    /**
     * Process Forgot Password (Password Reset) form
     *
     */
    public function postForgot()
    {
        if ( Confide::forgotPassword( Input::get( 'email' ) ) ) {

            return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.password_forgot') );

        } else {

            return Redirect::to('user/forgot')
                ->withInput()
                ->with( 'error', Lang::get('confide::confide.alerts.wrong_password_forgot') );
        }
    }

    /**
     * Display Password Reset form
     * Shows the change password form with the given token
     *
     */
    public function getReset( $token )
    {
        return View::make('site/user/reset')
            ->with('token', $token);
    }

    /**
     * Process Password Reset form
     * Attempt change password of the user
     * MAC: added pw validation pre Confide, since it was absent
     *
     */
    public function postReset()
    {
        $input = array(
            'token'=>Input::get( 'token' ),
            'password'=>Input::get( 'password' ),
            'password_confirmation'=>Input::get( 'password_confirmation' ),
        );

        $rules = array(
            'password'              => 'required|between:4,12|confirmed',
            'password_confirmation' => 'between:4,12'
        );

        $validator = Validator::make($input, $rules);

        // MAC added
        if ( $validator->passes() ) {

            // By passing an array with the token, password and confirmation
            if ( Confide::resetPassword( $input ) ) {

                return Redirect::to('user/login')
                ->with( 'notice', Lang::get('confide::confide.alerts.password_reset') );

            } else {

                return Redirect::to('user/reset/'.$input['token'])
                    ->withInput()
                    ->with( 'error', Lang::get('confide::confide.alerts.wrong_password_reset') );
            }

        } else {

            $error = $validator->errors()->all();

            return Redirect::to('user/reset/'. $input['token'])
                    ->withInput()
                    ->with('error', $error);
        }
    }

    /**
     * Log the user out of the application.
     *
     */
    public function getLogout()
    {
        Confide::logout();

        return Redirect::to('/');
    }

    /**
     * Get any user's public profile based on their username
     * Currently, a blind URL
     * 
     * @param $username
     * @return mixed
     */
    public function getProfile( $username )
    {
        $userModel = new User;
        $user = $userModel->getUserByUsername($username);

        // Check if the user exists
        if (is_null($user)) {

            return View::make('error/404');
        }

        return View::make('site/user/profile', compact('user'));
    }

    /**
     * Get the logged in user's public profile
     * Currently, a blind URL
     * 
     * @param $username
     * @return mixed
     */
    public function getSettings()
    {
        list($user,$redirect) = User::checkAuthAndRedirect('user/settings');
        if ($redirect){return $redirect;}

        return View::make('site/user/profile', compact('user'));
    }

    /**
     * Process a dumb redirect.
     * @param $url1
     * @param $url2
     * @param $url3
     * @return string
     */
    public function processRedirect( $url1, $url2, $url3 )
    {
        $redirect = '';
        if ( ! empty( $url1 ) ) {

            $redirect = $url1;
            $redirect .= (empty($url2)? '' : '/' . $url2);
            $redirect .= (empty($url3)? '' : '/' . $url3);
        }
        return $redirect;
    }
}
