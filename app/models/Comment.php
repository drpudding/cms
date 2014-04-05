<?php

use Robbo\Presenter\PresentableInterface;
use LaravelBook\Ardent\Ardent;

class Comment extends Ardent implements PresentableInterface{

    /**
     * Database table used by the model.
     * 
     * @var string
     */
    protected $table = 'comments';

    /**
     * Soft delete
     * 
     * @var string
     */
    protected $softDelete = true;

    /**
     * Presenter
     * 
     * @return Robbo\Presenter\Presenter|UserPresenter
     */
    public function getPresenter()
    {
        return new PostPresenter($this);
    }

    /**
     * Relationships (using Ardent syntax)
     * 
     * @var array
     */
    public static $relationsData = array(
        'author' => array(self::BELONGS_TO, 'User', 'foreignKey' => 'user_id'), // Get the comment's author
        'post' => array(self::BELONGS_TO, 'Post')                               // Get the comment's post
    );

    /**
     * Validation
     * see lang/en/validation.php for language
     * 
     * @var array
     */
    public static $rules = array(
        'content' => 'required|min:5'
    );

}
