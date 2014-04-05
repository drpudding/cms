<?php

return array(

	'already_exists'    => 'The user already exists.',
	'does_not_exist'    => 'The user does not exist.',
	'login_required'    => 'The login field is required',
	'password_required' => 'The password is required.',
	'password_does_not_match' => 'The passwords provided do not match.',

	'create' => array(
		'error'   => 'There user was not added. Please try again.',
		'success' => 'The user was added.',
        'role_required' => 'A role is required.',
	),

    'update' => array(
        'impossible' => 'You cannot edit yourself.',
        'error'      => 'The user was not updated. Please try again.',
        'success'    => 'The user was edited.',
        'role_required' => 'A role is required.',
    ),

    'delete' => array(
        'impossible' => 'You cannot delete yourself.',
        'error'      => 'The user was not deleted. Please try again.',
        'success'    => 'The user was deleted.'
    )

);
