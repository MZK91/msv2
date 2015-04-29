<?php

namespace MuzikSpirit\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article", indexes={@ORM\Index(name="type_article_id", columns={"type_article_id"})})
 * @ORM\Entity
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
}
