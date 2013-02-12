<?php

namespace Geekhub\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity()
 * @ORM\Table(name="dream_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\Column(name="name", type="string", length=255, nullable=true) */
    private $name;

    /** @ORM\Column(name="gender", type="string", length=255, nullable=true) */
    private  $gender;

    /** @ORM\Column(name="avatar", type="string", length=255, nullable=true) */
    private  $profilePicture;

    /** @ORM\Column(name="website", type="string", length=255, nullable=true) */
    private  $website;

    /** @ORM\Column(name="facebook_id", type="string", length=255, nullable=true) */
    private $facebookId;

    /** @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true) */
    private  $facebookAccessToken;

    /** @ORM\Column(name="facebook_profile", type="string", length=255, nullable=true) */
    private $facebookProfile;

    /** @ORM\Column(name="google_id", type="string", length=255, nullable=true) */
    private  $googleId;

    /** @ORM\Column(name="google_access_token", type="string", length=255, nullable=true) */
    private  $googleAccessToken;



    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set gender
     *
     * @param string $gender
     * @return User
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    
        return $this;
    }

    /**
     * Get gender
     *
     * @return string 
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set profilePicture
     *
     * @param string $profilePicture
     * @return User
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profilePicture = $profilePicture;
    
        return $this;
    }

    /**
     * Get profilePicture
     *
     * @return string 
     */
    public function getProfilePicture()
    {
        return $this->profilePicture;
    }

    /**
     * Set website
     *
     * @param string $website
     * @return User
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    
        return $this;
    }

    /**
     * Get website
     *
     * @return string 
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set facebookId
     *
     * @param string $facebookId
     * @return User
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    
        return $this;
    }

    /**
     * Get facebookId
     *
     * @return string 
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * Set facebookAccessToken
     *
     * @param string $facebookAccessToken
     * @return User
     */
    public function setFacebookAccessToken($facebookAccessToken)
    {
        $this->facebookAccessToken = $facebookAccessToken;
    
        return $this;
    }

    /**
     * Get facebookAccessToken
     *
     * @return string 
     */
    public function getFacebookAccessToken()
    {
        return $this->facebookAccessToken;
    }

    /**
     * Set googleId
     *
     * @param string $googleId
     * @return User
     */
    public function setGoogleId($googleId)
    {
        $this->googleId = $googleId;
    
        return $this;
    }

    /**
     * Get googleId
     *
     * @return string 
     */
    public function getGoogleId()
    {
        return $this->googleId;
    }

    /**
     * Set googleAccessToken
     *
     * @param string $googleAccessToken
     * @return User
     */
    public function setGoogleAccessToken($googleAccessToken)
    {
        $this->googleAccessToken = $googleAccessToken;
    
        return $this;
    }

    /**
     * Get googleAccessToken
     *
     * @return string 
     */
    public function getGoogleAccessToken()
    {
        return $this->googleAccessToken;
    }

    /**
     * Set facebookProfile
     *
     * @param string $facebookProfile
     * @return User
     */
    public function setFacebookProfile($facebookProfile)
    {
        $this->facebookProfile = $facebookProfile;
    
        return $this;
    }

    /**
     * Get facebookProfile
     *
     * @return string 
     */
    public function getFacebookProfile()
    {
        return $this->facebookProfile;
    }
}