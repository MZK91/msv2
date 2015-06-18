<?php

namespace MuzikSpirit\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(
 *      name="article",
 *      indexes={
 *          @ORM\Index(name="type_article_id", columns={"type_article_id"}),
 *          @ORM\Index(name="article_id", columns={"article_id"}),
 *          @ORM\Index(name="date", columns={"date"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="MuzikSpirit\BackBundle\Repository\ArticleRepository")
 */
class Article
{

    /**
     * @var \ArticleId
     * @ORM\Column(name="article_id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $articleId;

    /**
     * @var \TypeArticle
     * @ORM\Id
     *
     * @ORM\ManyToOne(targetEntity="TypeArticle")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_article_id", referencedColumnName="id")
     * })
     */
    private $typeArticle;

    /**
     * @var \Section
     *
     * @ORM\ManyToOne(targetEntity="Section")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="section_id", referencedColumnName="id")
     * })
     */
    private $section;

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
     * @var string
     * @ORM\Column(name="vues", type="integer", nullable=false)
     */
    private $vues = '0';

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
    public function setTypeArticle(\MuzikSpirit\BackBundle\Entity\TypeArticle $typeArticle)
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
     * @return \Section
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param \Section $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return string
     */
    public function getVues()
    {
        return $this->vues;
    }

    /**
     * @param string $vues
     */
    public function setVues($vues)
    {
        $this->vues = $vues;
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
