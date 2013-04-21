<?php

namespace Geekhub\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 * @ORM\Table(name="dream_user")
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
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

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /** @ORM\Column(name="about_me", type="text", nullable=true) */
    private $aboutMe;

    /** @ORM\OneToMany(targetEntity="Geekhub\DreamBundle\Entity\Financial", mappedBy="user", cascade={"persist", "remove"}) */
    private $financialDonates;

    /** @ORM\OneToMany(targetEntity="Geekhub\DreamBundle\Entity\Equipment", mappedBy="user", cascade={"persist", "remove"}) */
    private $equipmentDonates;

    /** @ORM\OneToMany(targetEntity="Geekhub\DreamBundle\Entity\Work", mappedBy="user", cascade={"persist", "remove"}) */
    private $workDonates;

    /** @ORM\OneToMany(targetEntity="Geekhub\DreamBundle\Entity\OtherDonate", mappedBy="user", cascade={"persist", "remove"}) */
    private $otherDonates;

    /**
     * @ORM\ManyToMany(targetEntity="Geekhub\DreamBundle\Entity\Dream", mappedBy="usersWhoFavorites")
     */
    private $favoriteDreams;

    /** @ORM\OneToMany(targetEntity="Notify", mappedBy="user") */
    private $notices;

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

    /** @ORM\Column(name="date", nullable=true) */
    private $birthday;

    /** @ORM\Column(name="skype", type="string", length=255, nullable=true) */
    private $skype;

    /** @ORM\Column(name="phone", type="string", length=255, nullable=true) */
    private $phone;

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

    /** @ORM\Column(name="deletedAt", type="datetime", nullable=true) */
    private $deletedAt;

    /** @ORM\Column(name="ban_reason", type="text", length=255, nullable=true) */
    private $banReason;

    /**
     * @var datetime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @var datetime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime")
     */
    private $updated;

    /**
     * @ORM\OneToMany(targetEntity="Geekhub\DreamBundle\Entity\Dream", mappedBy="owner")
     */
    private $userDreams;

    public function __construct()
    {
        $this->userDreams = new ArrayCollection();
        $this->financialDonates = new ArrayCollection();
        $this->equipmentDonates = new ArrayCollection();
        $this->workDonates = new ArrayCollection();
        $this->otherDonates = new ArrayCollection();
        $this->favoriteDreams = new ArrayCollection();
        $this->notices = new ArrayCollection();

        parent::__construct();
    }


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
     * Set slug
     *
     * @param string $slug
     * @return User
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set aboutMe
     *
     * @param string $aboutMe
     * @return User
     */
    public function setAboutMe($aboutMe)
    {
        $this->aboutMe = $aboutMe;
    
        return $this;
    }

    /**
     * Get aboutMe
     *
     * @return string 
     */
    public function getAboutMe()
    {
        return $this->aboutMe;
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
     * Set birthday
     *
     * @param string $birthday
     * @return User
     */
    public function setBirthday($birthday)
    {
        $this->birthday = $birthday;
    
        return $this;
    }

    /**
     * Get birthday
     *
     * @return string 
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set skype
     *
     * @param string $skype
     * @return User
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;
    
        return $this;
    }

    /**
     * Get skype
     *
     * @return string 
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    
        return $this;
    }

    /**
     * Get phone
     *
     * @return string 
     */
    public function getPhone()
    {
        return $this->phone;
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

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return User
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    
        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime 
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;
    
        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime 
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Add financialDonate
     *
     * @param \Geekhub\DreamBundle\Entity\Financial $financial
     * @return User
     */
    public function addFinancialDonate(\Geekhub\DreamBundle\Entity\Financial $financial)
    {
        $this->financialDonates[] = $financial;

        return $this;
    }

    /**
     * Remove financialDonate
     *
     * @param \Geekhub\DreamBundle\Entity\Financial $financial
     */
    public function removeFinancialDonate(\Geekhub\DreamBundle\Entity\Financial $financial)
    {
        $this->financialDonates->removeElement($financial);
    }

    /**
     * Get financialDonate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFinancialDonates()
    {
        return $this->financialDonates;
    }

    /**
     * Add equipmentDonate
     *
     * @param \Geekhub\DreamBundle\Entity\Equipment $equipment
     * @return User
     */
    public function addEquipmentDonate(\Geekhub\DreamBundle\Entity\Equipment $equipment)
    {
        $this->equipmentDonates[] = $equipment;
    
        return $this;
    }

    /**
     * Remove equipmentDonate
     *
     * @param \Geekhub\DreamBundle\Entity\Equipment $equipment
     */
    public function removeEquipmentDonate(\Geekhub\DreamBundle\Entity\Equipment $equipment)
    {
        $this->equipmentDonates->removeElement($equipment);
    }

    /**
     * Get equipmentDonates
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEquipmentDonates()
    {
        return $this->equipmentDonates;
    }

    /**
     * Add workDonate
     *
     * @param \Geekhub\DreamBundle\Entity\Work $work
     * @return User
     */
    public function addWorkDonate(\Geekhub\DreamBundle\Entity\Work $work)
    {
        $this->workDonates[] = $work;

        return $this;
    }

    /**
     * Remove workDonate
     *
     * @param \Geekhub\DreamBundle\Entity\Work $work
     */
    public function removeWorkDonate(\Geekhub\DreamBundle\Entity\Work $work)
    {
        $this->workDonates->removeElement($work);
    }

    /**
     * Get workDonate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getWorkDonates()
    {
        return $this->workDonates;
    }

    /**
     * Add otherDonate
     *
     * @param \Geekhub\DreamBundle\Entity\OtherDonate $otherDonate
     * @return User
     */
    public function addOtherDonate(\Geekhub\DreamBundle\Entity\OtherDonate $otherDonate)
    {
        $this->otherDonates[] = $otherDonate;

        return $this;
    }

    /**
     * Remove otherDonate
     *
     * @param \Geekhub\DreamBundle\Entity\otherDonate $otherDonate
     */
    public function removeOtherDonate(\Geekhub\DreamBundle\Entity\otherDonate $otherDonate)
    {
        $this->otherDonates->removeElement($otherDonate);
    }

    /**
     * Get otherDonate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOtherDonates()
    {
        return $this->otherDonates;
    }

    /**
     * Add favoriteDreams
     *
     * @param \Geekhub\DreamBundle\Entity\Dream $favoriteDreams
     * @return User
     */
    public function addFavoriteDream(\Geekhub\DreamBundle\Entity\Dream $favoriteDreams)
    {
        $this->favoriteDreams[] = $favoriteDreams;
    
        return $this;
    }

    /**
     * Remove favoriteDreams
     *
     * @param \Geekhub\DreamBundle\Entity\Dream $favoriteDreams
     */
    public function removeFavoriteDream(\Geekhub\DreamBundle\Entity\Dream $favoriteDreams)
    {
        $this->favoriteDreams->removeElement($favoriteDreams);
    }

    /**
     * Get favoriteDreams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFavoriteDreams()
    {
        return $this->favoriteDreams;
    }

    /**
     * Add notices
     *
     * @param \Geekhub\UserBundle\Entity\Notify $notices
     * @return User
     */
    public function addNotice(\Geekhub\UserBundle\Entity\Notify $notices)
    {
        $this->notices[] = $notices;
    
        return $this;
    }

    /**
     * Remove notices
     *
     * @param \Geekhub\UserBundle\Entity\Notify $notices
     */
    public function removeNotice(\Geekhub\UserBundle\Entity\Notify $notices)
    {
        $this->notices->removeElement($notices);
    }

    /**
     * Get notices
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotices()
    {
        return $this->notices;
    }

    /**
     * Add userDreams
     *
     * @param \Geekhub\DreamBundle\Entity\Dream $userDreams
     * @return User
     */
    public function addUserDream(\Geekhub\DreamBundle\Entity\Dream $userDreams)
    {
        $this->userDreams[] = $userDreams;
    
        return $this;
    }

    /**
     * Remove userDreams
     *
     * @param \Geekhub\DreamBundle\Entity\Dream $userDreams
     */
    public function removeUserDream(\Geekhub\DreamBundle\Entity\Dream $userDreams)
    {
        $this->userDreams->removeElement($userDreams);
    }

    /**
     * Get userDreams
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUserDreams()
    {
        return $this->userDreams;
    }

    public function getBanReason()
    {
        return $this->banReason;
    }

    public function setBanReason($banReason)
    {
        $this->banReason = $banReason;

        return $this;
    }
}