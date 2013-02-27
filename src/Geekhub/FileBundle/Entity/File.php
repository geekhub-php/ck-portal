<?php
namespace Geekhub\FileBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Uploadable\MimeType\MimeTypeGuesserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="file")
 * @Gedmo\Uploadable(filenameGenerator="ALPHANUMERIC", appendNumber=true, maxSize=52428800)
 */
class File implements MimeTypeGuesserInterface
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @ORM\Column(name="path", type="string")
     * @Gedmo\UploadableFilePath
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="mime_type", type="string", columnDefinition="ENUM('doc', 'xls', 'xlsx', 'pdf')", nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(name="size", type="decimal")
     * @Gedmo\UploadableFileSize
     */
    private $size;

    /** @ORM\ManyToOne(targetEntity="Geekhub\DreamBundle\Entity\Dream", inversedBy="file") */
    private $dream;

    public function guess($filePath)
    {
        // TODO: Implement guess() method.
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
     * @return File
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return File
     */
    public function setPath($path)
    {
        $this->path = $path;
    
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return File
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set size
     *
     * @param float $size
     * @return File
     */
    public function setSize($size)
    {
        $this->size = $size;
    
        return $this;
    }

    /**
     * Get size
     *
     * @return float 
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set dream
     *
     * @param \Geekhub\DreamBundle\Entity\Dream $dream
     * @return File
     */
    public function setDream(\Geekhub\DreamBundle\Entity\Dream $dream = null)
    {
        $this->dream = $dream;
    
        return $this;
    }

    /**
     * Get dream
     *
     * @return \Geekhub\DreamBundle\Entity\Dream 
     */
    public function getDream()
    {
        return $this->dream;
    }
}