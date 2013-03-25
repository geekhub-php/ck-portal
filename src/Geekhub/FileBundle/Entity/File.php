<?php

namespace Geekhub\FileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;

/** @ORM\MappedSuperclass
 *  @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
abstract class File
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /** @ORM\Column(name="original_name", type="decimal") */
    protected $originalName;

    /**
     * @ORM\Column(name="mime_type", type="string")
     */
    protected $mimeType;

    /**
     * @ORM\Column(name="size", type="decimal")
     */
    protected $size;

    /**
     * @ORM\Column(name="path", type="string")
     */
    protected $path;

    /**
     * @var file for move file
     * @Exclude
     */
    protected $uploadDir;

    /** @var boolean fix for fine uploader - it require this parameter for ajax */
    protected $success = true;

    /** @var string for fine uploader */
    protected $error;

    /**
     * @var array configurable value
     * @Exclude
     */
    protected $allowedExtensions;

    /**
     * @var string configurable value
     * @Exclude
     */
    protected $sizeLimit;

    /**
     * @var datetime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;

    /** @ORM\Column(name="deletedAt", type="datetime", nullable=true) */
    protected $deletedAt;

    public function getId()
    {
        return $this->id;
    }

    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
    }

    public function getOriginalName()
    {
        return $this->originalName;
    }

    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setPath($path)
    {
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setUploadDir($uploadDir) {
        $this->uploadDir = $uploadDir;
    }

    public function getUploadDir() {
        return rtrim($this->uploadDir, '/').'/';
    }

    /**
     * @param boolean $success
     */
    public function setSuccess($success)
    {
        $this->success = $success;
    }

    /**
     * @return boolean
     */
    public function getSuccess()
    {
        return $this->success;
    }

    public function setError($error)
    {
        $this->error = $error;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setAllowedExtensions($allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;
    }

    public function getAllowedExtensions()
    {
        return $this->allowedExtensions;
    }

    public function setSizeLimit($sizeLimit)
    {
        $this->sizeLimit = $sizeLimit;
    }

    public function getSizeLimit()
    {
        return $this->sizeLimit;
    }

    /**
     * @param datetime $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return datetime
     */
    public function getCreated()
    {
        return $this->created;
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    public function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }


}