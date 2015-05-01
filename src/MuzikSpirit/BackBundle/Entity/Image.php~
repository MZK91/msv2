<?php

namespace MuzikSpirit\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Image
 *
 * @ORM\Table(name="image", indexes={@ORM\Index(name="type_image_id", columns={"type_image_id"})})
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Image
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
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var \TypeImage
     *
     * @ORM\ManyToOne(targetEntity="TypeImage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_image_id", referencedColumnName="id")
     * })
     */
    private $typeImage;

    /**
     * @Assert\File(
     *     maxSizeMessage = "L'image ne doit pas dépasser 5Mb.",
     *     maxSize = "5000k",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/gif", "image/png"},
     *     mimeTypesMessage = "Les images doivent être au format JPG, GIF ou PNG."
     * )
     */
    public $file;

    private $fileName;

    private $fileExtension;

    private $fileSlug;

    // propriété utilisé temporairement pour la suppression
    private $filenameForRemove;

    public function __construct(){
        $this->date = new \DateTime();
    }

    public function getRootDir(){
        return __DIR__.'/../../../../web/';
    }

    public function getAbsolutePath()
    {
        return null === $this->image ? null : __DIR__.'/../../../../web/'.$this->image;
    }

    public function getWebPath()
    {
        return null === $this->image ? null : $this->getUploadDir().'/'.$this->image;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire où les documents uploadés doivent être sauvegardés
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'images/tmp';
    }

    /**
     * @ORM\PostPersist()
     */
    public function upload()
    {
        if(isset($this->file)){
            if (null === $this->file) {
                return;
            }
            $this->fileName = $this->fileSlug.'-'.$this->id.'.'.$this->file->guessExtension();
            $this->file->move($this->getUploadRootDir(), $this->fileSlug.'-'.$this->id.'.'.$this->file->guessExtension());

        }
    }

    /**
     * @ORM\PreRemove()
     */
    public function storeFilenameForRemove()
    {
        $this->filenameForRemove = $this->getAbsolutePath();
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {

        if ($this->filenameForRemove && file_exists ($this->filenameForRemove) ) {
            unlink($this->filenameForRemove);
        }
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
     * Set titre
     *
     * @param string $titre
     * @return Image
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Image
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Image
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set typeImage
     *
     * @param \MuzikSpirit\BackBundle\Entity\TypeImage $typeImage
     * @return Image
     */
    public function setTypeImage(\MuzikSpirit\BackBundle\Entity\TypeImage $typeImage = null)
    {
        $this->typeImage = $typeImage;

        return $this;
    }

    /**
     * Get typeImage
     *
     * @return \MuzikSpirit\BackBundle\Entity\TypeImage
     */
    public function getTypeImage()
    {
        return $this->typeImage;
    }

    /**
     * @return mixed
     */
    public function getFileSlug()
    {
        return $this->fileSlug;
    }

    /**
     * @param mixed $fileSlug
     */
    public function setFileSlug($fileSlug)
    {
        $this->fileSlug = $fileSlug;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @return mixed
     */
    public function getFileExtension()
    {
        return $this->fileExtension;
    }

    /**
     * @param mixed $fileExtension
     */
    public function setFileExtension($fileExtension)
    {
        $this->fileExtension = $fileExtension;
    }



    /**
     * @return mixed
     */
    public function getFilenameForRemove()
    {
        return $this->filenameForRemove;
    }

    /**
     * @param mixed $filenameForRemove
     */
    public function setFilenameForRemove($filenameForRemove)
    {
        $this->filenameForRemove = $filenameForRemove;
    }

}
