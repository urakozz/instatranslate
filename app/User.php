<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User implements AuthenticatableContract, CanResetPasswordContract 
{

	protected $token;
	protected $username;
	protected $bio;
	protected $website;
	protected $profilePicture;
	protected $fullName;
	protected $id;

	/**
	 * @return mixed
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @param mixed $token
	 */
	public function setToken($token)
	{
		$this->token = $token;
	}

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * @return mixed
	 */
	public function getBio()
	{
		return $this->bio;
	}

	/**
	 * @param mixed $bio
	 */
	public function setBio($bio)
	{
		$this->bio = $bio;
	}

	/**
	 * @return mixed
	 */
	public function getWebsite()
	{
		return $this->website;
	}

	/**
	 * @param mixed $website
	 */
	public function setWebsite($website)
	{
		$this->website = $website;
	}

	/**
	 * @return mixed
	 */
	public function getProfilePicture()
	{
		return $this->profilePicture;
	}

	/**
	 * @param mixed $profilePicture
	 */
	public function setProfilePicture($profilePicture)
	{
		$this->profilePicture = $profilePicture;
	}

	/**
	 * @return mixed
	 */
	public function getFullName()
	{
		return $this->fullName;
	}

	/**
	 * @param mixed $fullName
	 */
	public function setFullName($fullName)
	{
		$this->fullName = $fullName;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param mixed $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}




	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getToken();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		// TODO: Implement getAuthPassword() method.
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		// TODO: Implement getRememberToken() method.
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		// TODO: Implement setRememberToken() method.
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		// TODO: Implement getRememberTokenName() method.
	}

	/**
	 * Get the e-mail address where password reset links are sent.
	 *
	 * @return string
	 */
	public function getEmailForPasswordReset()
	{
		// TODO: Implement getEmailForPasswordReset() method.
	}

	public function save(){
		
	}
}
