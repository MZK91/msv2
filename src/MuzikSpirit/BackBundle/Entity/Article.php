<?php

namespace MuzikSpirit\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="type_article_id", columns={"type_article_id"})})
 * @ORM\Entity(repositoryClass="MuzikSpirit\BackBundle\Repository\ArticleRepository")
 */
class Article
{

    /**
     * @ORM\Id
     * @ORM\Column(name="article_id", type="integer", nullable=false)
     */
    private $articleId;

    /**
     * @var \TypeArticle
     * @ORM\Id
     * @ORM\Column(name="type_article_id", type="integer", nullable=false)
     */
    private $typeArticle;

    /**
     * @var string
     * @ORM\Column(name="titre", type="string", nullable=false)
     */
    private $titre;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", nullable=false)
     */
    private $slug;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", nullable=false)
     */
    private $image;

    /**
     * @var \DateTime
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * Set articleId
     *
     * @param integer $articleId
     * @return Article
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
     * Set typeArticle
     *
     * @param \MuzikSpirit\BackBundle\Entity\TypeArticle $typeArticle
     * @return Article
     */
    public function setTypeArticle($typeArticle)
    {
        $this->typeArticle = $typeArticle;

        return $this;
    }

    /**
     * Get typeArticle
     *
     * @return \MuzikSpirit\BackBundle\Entity\TypeArticle 
     */
    public function getTypeArticle()
    {
        return $this->typeArticle;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return Article
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
     * Set slug
     *
     * @param string $slug
     * @return Article
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
     * Set image
     *
     * @param string $image
     * @return Article
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
     * @return Article
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

}
