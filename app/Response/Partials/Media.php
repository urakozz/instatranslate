<?php
/**
 * PHP Version 5
 *
 * @category  H24
 * @package
 * @author    "Yury Kozyrev" <yury.kozyrev@home24.de>
 * @copyright 2015 Home24 GmbH
 * @license   Proprietary license.
 * @link      http://www.home24.de
 */

namespace App\Response\Partials;


use App\Response\Partials\Image\Images;
use App\Response\Partials\Sequence\Comments;
use App\Response\Partials\Sequence\Likes;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class Media
{

    /**
     * @var string
     * @Type("string")
     */
    protected $attribution;

    /**
     * @var array
     * @Type("array<string>")
     */
    protected $tags = [];

    /**
     * @var array
     * @Type("array<string>")
     */
    protected $location = [];

    /**
     * @var Comments
     * @Type("App\Response\Partials\Sequence\Comments")
     */
    protected $comments = [];

    /**
     * @var Likes
     * @Type("App\Response\Partials\Sequence\Likes")
     */
    protected $likes = [];

    /**
     * @var string
     * @Type("string")
     */
    protected $filter;

    /**
     * @var string
     * @Type("string")
     */
    protected $createdTime;

    /**
     * @var string
     * @Type("string")
     */
    protected $link;

    /**
     * @var Images
     * @Type("App\Response\Partials\Image\Images")
     */
    protected $images;

    /**
     * @var ArrayCollection | UserInfo[]
     * @Type("App\Response\Partials\UserInfo")
     */
    protected $userInPhoto;

    /**
     * @var Caption
     * @Type("App\Response\Partials\Caption")
     */
    protected $caption;

    /**
     * @var boolean
     * @Type("boolean")
     */
    protected $userHasLiked;

    /**
     * @var UserInfo
     * @Type("App\Response\Partials\UserInfo")
     */
    protected $user;

    /**
     * @return string
     */
    public function getAttribution()
    {
        return $this->attribution;
    }

    /**
     * @param string $attribution
     */
    public function setAttribution($attribution)
    {
        $this->attribution = $attribution;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }

    /**
     * @return array
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param array $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return Comments
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comments $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return Likes
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param Likes $likes
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    /**
     * @return string
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param string $filter
     */
    public function setFilter($filter)
    {
        $this->filter = $filter;
    }

    /**
     * @return string
     */
    public function getCreatedTime()
    {
        return $this->createdTime;
    }

    /**
     * @param string $createdTime
     */
    public function setCreatedTime($createdTime)
    {
        $this->createdTime = $createdTime;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return Images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param Images $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }

    /**
     * @return UserInfo[]|ArrayCollection
     */
    public function getUserInPhoto()
    {
        return $this->userInPhoto;
    }

    /**
     * @param UserInfo[]|ArrayCollection $userInPhoto
     */
    public function setUserInPhoto($userInPhoto)
    {
        $this->userInPhoto = $userInPhoto;
    }

    /**
     * @return Caption
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @param Caption $caption
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;
    }

    /**
     * @return boolean
     */
    public function isUserHasLiked()
    {
        return $this->userHasLiked;
    }

    /**
     * @param boolean $userHasLiked
     */
    public function setUserHasLiked($userHasLiked)
    {
        $this->userHasLiked = $userHasLiked;
    }

    /**
     * @return UserInfo
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param UserInfo $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }


}