<?php

use Robbo\Presenter\Presenter;

class UserPresenter extends Presenter
{

    /**
     * Returns the date of the user creation,
     * on a good and more readable format :)
     *
     * @return string
     */
    public function presentCreatedAt()
    {

        return String::date($this->object->created_at);
    }

    /**
     * Returns the date of the user last update,
     * on a good and more readable format :)
     *
     * @return string
     */
    public function presentUpdatedAt()
    {
        return String::date($this->object->updated_at);
    }

    /* NOT IN USE

    public function presentIsActivated()
    { 
        if( $this->confirmed )
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    public function currentUser()
    {
        if( Auth::check() )
        {
            return Auth::user()->email;
        }
        else
        {
            return null;
        }
    }

    public function displayDate()
    {
        return date('m-d-y', strtotime($this->created_at));
    }
    */
}