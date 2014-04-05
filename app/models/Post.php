<?php

use Illuminate\Support\Facades\URL; # not sure why i need this here :c
use Robbo\Presenter\PresentableInterface;
use LaravelBook\Ardent\Ardent;

class Post extends Ardent implements PresentableInterface {

    /**
     * Database table used by the model.
     * 
     * @var string
     */
    protected $table = 'posts';

    /**
     * Soft delete
     * 
     * @var boolean
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
        'author' => array(self::BELONGS_TO, 'User', 'foreignKey' => 'user_id'),     // Get the post's author
        'comments' => array(self::HAS_MANY, 'Comment')                              // Get the post's comments
    );

    /**
     * Validation
     *
     * @var array
     */
    public static $rules = array(
        'title'   => 'required|min:5',
        'content' => 'required|min:5'
    );

    /**
     * NOT REQUIRED WITH DRI
     * Deletes a blog post and all
     * the associated comments.
     *
     * @return bool
     */
    // public function delete()
    // {
    //  // Delete the comments
    //  $this->comments()->delete();

    //  // Delete the blog post
    //  return parent::delete();
    // }
}
