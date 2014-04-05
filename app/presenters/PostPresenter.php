<?php

use Robbo\Presenter\Presenter;

class PostPresenter extends Presenter
{

	/**
	 * Returns a formatted post content entry,
	 * that ensures that line breaks are returned.
	 * But posts will save <br> for breaks, so this
	 * is only in cases where a DB line break happens
	 *
	 * @return string
	 */
	public function presentContent()
	{
		return nl2br($this->object->content);
	}

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

    /**
     * Get a formatted date the post was created.
     *
     * @param \Carbon|null $date
     * @return string
     */
    public function date($date=null)
    { 
        if(is_null($date)) {
            $date = $this->object->created_at;
        }

        return String::date($date);
    }

	/**
	 * Get the URL to the post.
	 *
	 * @return string
	 */
	// public function url($type = '')
	// {
	// 	switch ($type)
	// 	{
	// 		case 'view':
	// 			return $this->slug;
	// 		break;
	// 		default:
	// 			return null;
	// 	}

	// 	return $this->slug;
	// }

	public function presentViewUrl()
	{
		return $this->slug;
	}

}