<?php

namespace Geekhub\DreamBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineExtensions\Taggable\Taggable;
use Doctrine\ORM\Mapping as ORM;

/**
 * Dream
 *
 * @ORM\Table(name="dream")
 * @ORM\Entity(repositoryClass="Geekhub\DreamBundle\Entity\DreamRepository")
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
    protected $id;

    /**
     * @var string
     *
     * * @Assert\Length(
     *      min = "8",
     *      max = "70"
     * )
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /** @ORM\ManyToOne(targetEntity="Geekhub\UserBundle\Entity\User", inversedBy="userDreams") */
    protected $owner;

    /** @ORM\OneToMany(targetEntity="Financial", mappedBy="dream", cascade={"persist", "remove"}) */
    protected $financial;

    /** @ORM\OneToMany(targetEntity="Equipment", mappedBy="dream", cascade={"persist", "remove"}) */
    protected $equipment;

    /** @ORM\OneToMany(targetEntity="Work", mappedBy="dream", cascade={"persist", "remove"}) */
    protected $work;

    /** @ORM\OneToMany(targetEntity="OtherDonate", mappedBy="dream", cascade={"persist", "remove"}) */
    protected $otherDonate;

    /**
     * @ORM\OneToOne(targetEntity="ProgressBar")
     * @ORM\JoinColumn(name="progress_bar_id", referencedColumnName="id")
     */
    protected $progressBar;

    /** @ORM\OneToMany(targetEntity="Geekhub\FileBundle\Entity\Document", mappedBy="dream", cascade={"persist", "remove"}) */
    protected $document;

    /** @ORM\OneToMany(targetEntity="Geekhub\FileBundle\Entity\Image", mappedBy="dream", cascade={"persist", "remove"}) */
    protected $images;

    /** @ORM\Column(name="main_image", type="string", length=255, nullable=true) */
    protected $mainImage;

    /** @ORM\OneToMany(targetEntity="Geekhub\FileBundle\Entity\Video", mappedBy="dream", cascade={"persist", "remove"}) */
    protected $video;

    /** @ORM\Column(name="dream_like", type="integer", nullable=true) */
    protected $like;

    /**
     * @ORM\ManyToMany(targetEntity="Geekhub\UserBundle\Entity\User", inversedBy="favoriteDreams")
     * @ORM\JoinTable(name="favorite")
     */
    protected $usersWhoFavorites;

    /** @ORM\OneToMany(targetEntity="Geekhub\UserBundle\Entity\Notify", mappedBy="dream") */
    protected $notices;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=255, unique=true)
     */
    protected $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    protected $tags;

    protected $tagArray = array();

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    protected $phone;

    /**
     * @var boolean
     *
     * @ORM\Column(name="phone_available", type="boolean")
     */
    protected $phoneAvailable;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", columnDefinition="ENUM('open', 'close', 'complete', 'success')", nullable=false)
     */
    protected $state;

    /**
     * @var boolean
     *
     * @ORM\Column(name="on_front", type="boolean", nullable=true)
     */
    protected $onFront;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    protected $deletedAt;

    /**
     * @var datetime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;

    /**
     * @var datetime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updated", type="datetime")
     */
    protected $updated;

    /** @ORM\Column(name="locked", type="boolean", nullable=true) */
    protected $locked;

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
     * Constructor
     */
    public function __construct()
    {
        $this->financial = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->work = new \Doctrine\Common\Collections\ArrayCollection();
        $this->document = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
        $this->video = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contribution = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usersWhoFavorites = new \Doctrine\Common\Collections\ArrayCollection();
        $this->notices = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    public function setTagArray($tagArray)
    {
        $array = explode(',', $tagArray);
        foreach ($array as $tag) {
            $this->tagArray[] = trim($tag);
        }
    }

    public function getTagArray()
    {
        return $this->tagArray;
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
     * Set like
     *
     * @param integer $like
     * @return Dream
     */
    public function setLike($like)
    {
        $this->like = $like;
    
        return $this;
    }

    /**
     * Get like
     *
     * @return integer 
     */
    public function getLike()
    {
        return $this->like;
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
     * Add financial
     *
     * @param \Geekhub\DreamBundle\Entity\Financial $financial
     * @return Dream
     */
    public function addFinancial(\Geekhub\DreamBundle\Entity\Financial $financial)
    {
        $this->financial->add($financial);
        $financial->setDream($this);
    
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
        $this->equipment->add($equipment);
        $equipment->setDream($this);
    
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
        $this->work->add($work);
        $work->setDream($this);
    
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
     * Add otherDonate
     *
     * @param \Geekhub\DreamBundle\Entity\OtherDonate $work
     * @return Dream
     */
    public function addOtherDonate(\Geekhub\DreamBundle\Entity\OtherDonate $otherDonate)
    {
        $this->otherDonate->add($otherDonate);
        $otherDonate->setDream($this);

        return $this;
    }

    /**
     * Remove otherDonate
     *
     * @param \Geekhub\DreamBundle\Entity\OtherDonate $otherDonate
     */
    public function removeOtherDonate(\Geekhub\DreamBundle\Entity\OtherDonate $otherDonate)
    {
        $this->work->removeElement($otherDonate);
    }

    /**
     * Get otherDonate
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOtherDonate()
    {
        return $this->otherDonate;
    }

    public function setProgressBar(\Geekhub\DreamBundle\Entity\ProgressBar $progressBar)
    {
        $this->progressBar = $progressBar;
    }

    public function getProgressBar()
    {
        return $this->progressBar;
    }

    /**
     * Add file
     *
     * @param \Geekhub\FileBundle\Entity\File $file
     * @return Dream
     */
    public function addDocument(\Geekhub\FileBundle\Entity\Document $document)
    {
        $this->document->add($document);
        $document->setDream($this);
    
        return $this;
    }

    /**
     * Remove file
     *
     * @param \Geekhub\FileBundle\Entity\File $file
     */
    public function removeDocument(\Geekhub\FileBundle\Entity\Document $document)
    {
        $this->document->removeElement($document);
    }

    /**
     * Get file
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Add image
     *
     * @param \Geekhub\FileBundle\Entity\Image $image
     * @return Dream
     */
    public function addImage(\Geekhub\FileBundle\Entity\Image $image)
    {
        $this->images->add($image);
        $image->setDream($this);
    
        return $this;
    }

    /**
     * Remove image
     *
     * @param \Geekhub\FileBundle\Entity\Image $image
     */
    public function removeImage(\Geekhub\FileBundle\Entity\Image $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get image
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    public function setMainImage($mainImage)
    {
        $this->mainImage = $mainImage;
    }

    public function getMainImage()
    {
        return $this->mainImage;
    }

    /**
     * Add video
     *
     * @param \Geekhub\FileBundle\Entity\Video $video
     * @return Dream
     */
    public function addVideo(\Geekhub\FileBundle\Entity\Video $video)
    {
        $this->video->add($video);
        $video->setDream($this);
    
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

    public function getLocked()
    {
        return $this->locked;
    }

    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    public function __toString()
    {
        return $this->title;
    }
}