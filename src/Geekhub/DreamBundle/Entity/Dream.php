<?php

namespace Geekhub\DreamBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineExtensions\Taggable\Taggable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Dream
 *
 * @ORM\Table(name="dream")
 * @ORM\Entity
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
class Dream implements Taggable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /** @ORM\ManyToOne(targetEntity="Geekhub\UserBundle\Entity\User", inversedBy="userDreams") */
    private $owner;

    /** @ORM\OneToMany(targetEntity="Financial", mappedBy="dream", cascade={"persist", "remove"}) */
    private $financial;

    /** @ORM\OneToMany(targetEntity="Equipment", mappedBy="dream", cascade={"persist", "remove"}) */
    private $equipment;

    /** @ORM\OneToMany(targetEntity="Work", mappedBy="dream", cascade={"persist", "remove"}) */
    private $work;

    /** @ORM\OneToMany(targetEntity="Geekhub\FileBundle\Entity\File", mappedBy="dream") */
    private $file;

    /** @ORM\OneToMany(targetEntity="Geekhub\FileBundle\Entity\Image", mappedBy="dream") */
    private $image;

    /** @ORM\OneToMany(targetEntity="Geekhub\FileBundle\Entity\Video", mappedBy="dream") */
    private $video;

    /** @ORM\OneToMany(targetEntity="ContributorSupport", mappedBy="dream") */
    private $contributions;

    /** @ORM\Column(name="dream_like", type="integer") */
    private $like;

    /**
     * @ORM\ManyToMany(targetEntity="Geekhub\UserBundle\Entity\User", inversedBy="favoriteDreams")
     * @ORM\JoinTable(name="favorite")
     */
    private $usersWhoFavorites;

    /** @ORM\OneToMany(targetEntity="Geekhub\UserBundle\Entity\Notify", mappedBy="dream") */
    private $notices;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    private $tags;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="phone_available", type="boolean")
     */
    private $phoneAvailable;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", columnDefinition="ENUM('open', 'close', 'complete', 'success')", nullable=false)
     */
    private $state;

    /**
     * @var boolean
     *
     * @ORM\Column(name="on_front", type="boolean")
     */
    private $onFront;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

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

    public function __construct()
    {
        $this->usersWhoFavorites = new ArrayCollection();
        $this->contributions = new ArrayCollection();
        $this->financial = new ArrayCollection();
        $this->equipment = new ArrayCollection();
        $this->work = new ArrayCollection();
    }

    public function getTags()
    {
        $this->tags = $this->tags ?: new ArrayCollection();

        return $this->tags;
    }

    public function getTaggableType()
    {
        return 'dream_tag';
    }

    public function getTaggableId()
    {
        return $this->getId();
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
     * Set title
     *
     * @param string $title
     * @return Dream
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Dream
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
     * Set description
     *
     * @param string $description
     * @return Dream
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set phone
     *
     * @param string $phone
     * @return Dream
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
     * Set phoneAvailable
     *
     * @param boolean $phoneAvailable
     * @return Dream
     */
    public function setPhoneAvailable($phoneAvailable)
    {
        $this->phoneAvailable = $phoneAvailable;
    
        return $this;
    }

    /**
     * Get phoneAvailable
     *
     * @return boolean 
     */
    public function getPhoneAvailable()
    {
        return $this->phoneAvailable;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Dream
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set onFront
     *
     * @param boolean $onFront
     * @return Dream
     */
    public function setOnFront($onFront)
    {
        $this->onFront = $onFront;
    
        return $this;
    }

    /**
     * Get onFront
     *
     * @return boolean 
     */
    public function getOnFront()
    {
        return $this->onFront;
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     * @return Dream
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
     * @return Dream
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
     * @return Dream
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
     * Set owner
     *
     * @param \Geekhub\UserBundle\Entity\User $owner
     * @return Dream
     */
    public function setOwner(\Geekhub\UserBundle\Entity\User $owner = null)
    {
        $this->owner = $owner;
    
        return $this;
    }

    /**
     * Get owner
     *
     * @return \Geekhub\UserBundle\Entity\User 
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Add contributions
     *
     * @param \Geekhub\DreamBundle\Entity\ContributorSupport $contributions
     * @return Dream
     */
    public function addContribution(\Geekhub\DreamBundle\Entity\ContributorSupport $contributions)
    {
        $this->contributions[] = $contributions;
    
        return $this;
    }

    /**
     * Remove contributions
     *
     * @param \Geekhub\DreamBundle\Entity\ContributorSupport $contributions
     */
    public function removeContribution(\Geekhub\DreamBundle\Entity\ContributorSupport $contributions)
    {
        $this->contributions->removeElement($contributions);
    }

    /**
     * Get contributions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getContributions()
    {
        return $this->contributions;
    }

    public function setLike($like)
    {
        $this->like = $like;
    }

    public function getLike()
    {
        return $this->like;
    }

    /**
     * Add usersWhoFavorites
     *
     * @param \Geekhub\UserBundle\Entity\User $usersWhoFavorites
     * @return Dream
     */
    public function addUsersWhoFavorite(\Geekhub\UserBundle\Entity\User $usersWhoFavorites)
    {
        $this->usersWhoFavorites[] = $usersWhoFavorites;
    
        return $this;
    }

    /**
     * Remove usersWhoFavorites
     *
     * @param \Geekhub\UserBundle\Entity\User $usersWhoFavorites
     */
    public function removeUsersWhoFavorite(\Geekhub\UserBundle\Entity\User $usersWhoFavorites)
    {
        $this->usersWhoFavorites->removeElement($usersWhoFavorites);
    }

    /**
     * Get usersWhoFavorites
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsersWhoFavorites()
    {
        return $this->usersWhoFavorites;
    }

    /**
     * Add notices
     *
     * @param \Geekhub\UserBundle\Entity\Notify $notices
     * @return Dream
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
     * Add financial
     *
     * @param \Geekhub\DreamBundle\Entity\Financial $financial
     * @return Dream
     */
    public function addFinancial(\Geekhub\DreamBundle\Entity\Financial $financial)
    {
        $this->financial[] = $financial;
    
        return $this;
    }

    /**
     * Remove financial
     *
     * @param \Geekhub\DreamBundle\Entity\Financial $financial
     */
    public function removeFinancial(\Geekhub\DreamBundle\Entity\Financial $financial)
    {
        $this->financial->removeElement($financial);
    }

    /**
     * Get financial
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFinancial()
    {
        return $this->financial;
    }

    /**
     * Add equipment
     *
     * @param \Geekhub\DreamBundle\Entity\Equipment $equipment
     * @return Dream
     */
    public function addEquipment(\Geekhub\DreamBundle\Entity\Equipment $equipment)
    {
        $this->equipment[] = $equipment;
    
        return $this;
    }

    /**
     * Remove equipment
     *
     * @param \Geekhub\DreamBundle\Entity\Equipment $equipment
     */
    public function removeEquipment(\Geekhub\DreamBundle\Entity\Equipment $equipment)
    {
        $this->equipment->removeElement($equipment);
    }

    /**
     * Get equipment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Add work
     *
     * @param \Geekhub\DreamBundle\Entity\Work $work
     * @return Dream
     */
    public function addWork(\Geekhub\DreamBundle\Entity\Work $work)
    {
        $this->work[] = $work;
    
        return $this;
    }

    /**
     * Remove work
     *
     * @param \Geekhub\DreamBundle\Entity\Work $work
     */
    public function removeWork(\Geekhub\DreamBundle\Entity\Work $work)
    {
        $this->work->removeElement($work);
    }

    /**
     * Get work
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * Add file
     *
     * @param \Geekhub\FileBundle\Entity\File $file
     * @return Dream
     */
    public function addFile(\Geekhub\FileBundle\Entity\File $file)
    {
        $this->file[] = $file;
    
        return $this;
    }

    /**
     * Remove file
     *
     * @param \Geekhub\FileBundle\Entity\File $file
     */
    public function removeFile(\Geekhub\FileBundle\Entity\File $file)
    {
        $this->file->removeElement($file);
    }

    /**
     * Get file
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Add image
     *
     * @param \Geekhub\FileBundle\Entity\Image $image
     * @return Dream
     */
    public function addImage(\Geekhub\FileBundle\Entity\Image $image)
    {
        $this->image[] = $image;
    
        return $this;
    }

    /**
     * Remove image
     *
     * @param \Geekhub\FileBundle\Entity\Image $image
     */
    public function removeImage(\Geekhub\FileBundle\Entity\Image $image)
    {
        $this->image->removeElement($image);
    }

    /**
     * Get image
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add video
     *
     * @param \Geekhub\FileBundle\Entity\Video $video
     * @return Dream
     */
    public function addVideo(\Geekhub\FileBundle\Entity\Video $video)
    {
        $this->video[] = $video;
    
        return $this;
    }

    /**
     * Remove video
     *
     * @param \Geekhub\FileBundle\Entity\Video $video
     */
    public function removeVideo(\Geekhub\FileBundle\Entity\Video $video)
    {
        $this->video->removeElement($video);
    }

    /**
     * Get video
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVideo()
    {
        return $this->video;
    }
}