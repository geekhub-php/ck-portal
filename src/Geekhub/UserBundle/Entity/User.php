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

    /** @ORM\Column(name="first_name", type="string", length=255, nullable=true) */
    private $firstName;

    /** @ORM\Column(name="last_name", type="string", length=255, nullable=true) */
    private $lastName;

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

    /** @ORM\Column(name="vkontakte_id", type="string", length=255, nullable=true) */
    private $vkontakteId;

    /** @ORM\Column(name="vkontakte_access_token", type="string", length=255, nullable=true) */
    private $vkontakteAccessToken;

    /** @ORM\Column(name="vkontakte_profile", type="string", length=255, nullable=true) */
    private $vkontakteProfile;

    /** @ORM\Column(name="odnoklassniki_id", type="string", length=255, nullable=true) */
    private  $odnoklassnikiId;

    /** @ORM\Column(name="odnoklassniki_access_token", type="string", length=255, nullable=true) */
    private  $odnoklassnikiAccessToken;

    /** @ORM\Column(name="odnoklassniki_profile", type="string", length=255, nullable=true) */
    private $odnoklassnikiProfile;

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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    
        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    
        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
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

    /**
     * Set vkontakteId
     *
     * @param string $vkontakteId
     * @return User
     */
    public function setVkontakteId($vkontakteId)
    {
        $this->vkontakteId = $vkontakteId;
    
        return $this;
    }

    /**
     * Get vkontakteId
     *
     * @return string 
     */
    public function getVkontakteId()
    {
        return $this->vkontakteId;
    }

    /**
     * Set vkontakteAccessToken
     *
     * @param string $vkontakteAccessToken
     * @return User
     */
    public function setVkontakteAccessToken($vkontakteAccessToken)
    {
        $this->vkontakteAccessToken = $vkontakteAccessToken;
    
        return $this;
    }

    /**
     * Get vkontakteAccessToken
     *
     * @return string 
     */
    public function getVkontakteAccessToken()
    {
        return $this->vkontakteAccessToken;
    }

    /**
     * Set vkontakteProfile
     *
     * @param string $vkontakteProfile
     * @return User
     */
    public function setVkontakteProfile($vkontakteProfile)
    {
        $this->vkontakteProfile = $vkontakteProfile;
    
        return $this;
    }

    /**
     * Get vkontakteProfile
     *
     * @return string 
     */
    public function getVkontakteProfile()
    {
        return $this->vkontakteProfile;
    }

    /**
     * Set odnoklassnikiId
     *
     * @param string $odnoklassnikiId
     * @return User
     */
    public function setOdnoklassnikiId($odnoklassnikiId)
    {
        $this->odnoklassnikiId = $odnoklassnikiId;
    
        return $this;
    }

    /**
     * Get odnoklassnikiId
     *
     * @return string 
     */
    public function getOdnoklassnikiId()
    {
        return $this->odnoklassnikiId;
    }

    /**
     * Set odnoklassnikiAccessToken
     *
     * @param string $odnoklassnikiAccessToken
     * @return User
     */
    public function setOdnoklassnikiAccessToken($odnoklassnikiAccessToken)
    {
        $this->odnoklassnikiAccessToken = $odnoklassnikiAccessToken;
    
        return $this;
    }

    /**
     * Get odnoklassnikiAccessToken
     *
     * @return string 
     */
    public function getOdnoklassnikiAccessToken()
    {
        return $this->odnoklassnikiAccessToken;
    }

    /**
     * Set odnoklassnikiProfile
     *
     * @param string $odnoklassnikiProfile
     * @return User
     */
    public function setOdnoklassnikiProfile($odnoklassnikiProfile)
    {
        $this->odnoklassnikiProfile = $odnoklassnikiProfile;
    
        return $this;
    }

    /**
     * Get odnoklassnikiProfile
     *
     * @return string 
     */
    public function getOdnoklassnikiProfile()
    {
        return $this->odnoklassnikiProfile;
    }
}