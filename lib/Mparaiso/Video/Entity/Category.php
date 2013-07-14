<?php
namespace Mparaiso\Video\Entity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 */
class Category
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     * @var integer
     */
    protected $id;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $title;

    /**
     * @OneToMany(targetEntity="Mparaiso\Video\Entity\Article",mappedBy="category",cascade={"persist"})
     * @var ArrayCollection;
     */
    protected $articles;

    function __construct()
    {
        $this->articles = new ArrayCollection;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $articles
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

    function addArticle(Article $article)
    {
        $article->setCategory($this);
        $this->articles[] = $article;


    }

    function removeArticle(Article $article)
    {
        $article->setCategory(null);
        $this->articles->removeElement($article);
    }

    function __toString(){
        return $this->title;
    }
}
