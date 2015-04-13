<?php

namespace MuzikSpirit\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Carousel
 *
 * @ORM\Table(name="carousel")
 * @ORM\Entity
 */
class Carousel
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
     * @var integer
     *
     * @ORM\Column(name="section_id", type="integer", nullable=false)
     */
    private $sectionId;

    /**
     * @var integer
     *
     * @ORM\Column(name="type_article_id", type="integer", nullable=false)
     */
    private $typeArticleId;

    /**
     * @var integer
     *
     * @ORM\Column(name="article_id", type="integer", nullable=false)
     */
    private $articleId;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="lien", type="string", length=255, nullable=false)
     */
    private $lien;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;



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
     * Set sectionId
     *
     * @param integer $sectionId
     * @return Carousel
     */
    public function setSectionId($sectionId)
    {
        $this->sectionId = $sectionId;

        return $this;
    }

    /**
     * Get sectionId
     *
     * @return integer 
     */
    public function getSectionId()
    {
        return $this->sectionId;
    }

    /**
     * Set typeArticleId
     *
     * @param integer $typeArticleId
     * @return Carousel
     */
    public function setTypeArticleId($typeArticleId)
    {
        $this->typeArticleId = $typeArticleId;

        return $this;
    }

    /**
     * Get typeArticleId
     *
     * @return integer 
     */
    public function getTypeArticleId()
    {
        return $this->typeArticleId;
    }

    /**
     * Set articleId
     *
     * @param integer $articleId
     * @return Carousel
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;

        return $this;
    }

    /**
     * Get articleId
     *
     * @return integer 
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Carousel
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
     * @return Carousel
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
     * Set lien
     *
     * @param string $lien
     * @return Carousel
     */
    public function setLien($lien)
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * Get lien
     *
     * @return string 
     */
    public function getLien()
    {
        return $this->lien;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Carousel
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
}
