<?php

class AdminController extends BaseController {

    /**
     * Initializer.
     *
     * @return \AdminController
     */
    public function __construct()
    {
        parent::__construct();

        // Apply the admin auth filter
        // MAC: not in use; 'auth' applied as filter
        //$this->beforeFilter('admin-auth');
    }

}