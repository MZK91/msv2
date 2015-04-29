<?php

namespace MuzikSpirit\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * TypeImage
 *
 * @ORM\Table(name="type_image")
 * @ORM\Entity
 */
class TypeImage
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255, nullable=false)
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="crop", type="boolean", nullable=false)
     */
    private $crop;

    /**
     * @var boolean
     *
     * @ORM\Column(name="resize", type="boolean", nullable=false)
     */
    private $resize;

    /**
     * @var boolean
     *
     * @ORM\Column(name="thumb", type="boolean", nullable=false)
     */
    private $thumb;

    /**
     * @var integer
     *
     * @ORM\Column(name="width", type="integer", nullable=false)
     */
    private $width;

    /**
     * @var integer
     *
     * @ORM\Column(name="height", type="integer", nullable=false)
     */
    private $height;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=false)
     */
    private $path;

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
     * Set type
     *
     * @param string $type
     * @return TypeImage
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
     * Set crop
     *
     * @param boolean $crop
     * @return TypeImage
     */
    public function setCrop($crop)
    {
        $this->crop = $crop;

        return $this;
    }

    /**
     * Get crop
     *
     * @return boolean 
     */
    public function getCrop()
    {
        return $this->crop;
    }

    /**
     * Set resize
     *
     * @param boolean $resize
     * @return TypeImage
     */
    public function setResize($resize)
    {
        $this->resize = $resize;

        return $this;
    }

    /**
     * Get resize
     *
     * @return boolean
     */
    public function getResize()
    {
        return $this->resize;
    }

    /**
     * @return boolean
     */
    public function getThumb()
    {
        return $this->thumb;
    }

    /**
     * @param boolean $thumb
     */
    public function setThumb($thumb)
    {
        $this->thumb = $thumb;
    }

    /**
     * Set width
     *
     * @param integer $width
     * @return TypeImage
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer 
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     * @return TypeImage
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer 
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return TypeImage
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
     * Retourne le type
     * @return string
     */

    public function __toString(){
        return $this->type;
    }
}
