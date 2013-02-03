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


    private $deleted;

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
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return datetime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}
