<?php

namespace Live\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Live\UserBundle\Entity\User as User;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Post
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Live\BlogBundle\Entity\PostRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Post
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
     * @Assert\Length(min=2, minMessage="Le titre doit faire au moins {{ limit }} caractères")
     */
    private $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="contentFormatter", type="string", length=255)
     */
    private $contentFormatter;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publicationDateStart", type="datetime")
     */
    private $publicationDateStart;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     */
    private $updatedAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="commentsEnabled", type="boolean")
     */
    private $commentsEnabled;

    /**
     * @var integer
     *
     * @ORM\Column(name="commentsCount", type="integer")
     */
    private $commentsCount;

    /**
     * @ORM\ManyToOne(targetEntity="Live\UserBundle\Entity\User", cascade={"persist"})
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity="Category", cascade={"persist"})
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity="Tag", cascade={"persist"})
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="post")
     */
    private $comments;

    /* Used for Post create form only */
    // TODO : implements better way (eg: using AJAX)

    private $categoriesAdded;

    public function setCategoriesAdded($categories)
    {
        foreach($categories as $cat) {

            $this->categoriesAdded[] = $cat;
            $this->categories[] = $cat;
        }

        return $this;
    }

    public function getCategoriesAdded()
    {
        return $this->categoriesAdded;
    }

    /* End */


    public function __construct()
    {
       $this->categories   = new \Doctrine\Common\Collections\ArrayCollection();
       $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
       $this->tags = new \Doctrine\Common\Collections\ArrayCollection();

       // Defaults
       $this->setContentFormatter("tinymce");
       $this->setEnabled(true);
       $this->setCommentsEnabled(true);
       $this->setPublicationDateStart(new \DateTime);
       $this->setCommentsCount(0);
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist()
    {
        if (!$this->getPublicationDateStart()) {
            $this->setPublicationDateStart(new \DateTime);
        }

        $this->setCreatedAt(new \DateTime);
        $this->setUpdatedAt(new \DateTime);
    }

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate()
    {
        $this->setUpdatedAt(new \DateTime);
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
     * Set title
     *
     * @param string $title
     * @return Post
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
     * Set slug
     *
     * @param string $slug
     * @return Post
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
     * Set content
     *
     * @param string $content
     * @return Post
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set contentFormatter
     *
     * @param string $contentFormatter
     * @return Post
     */
    public function setContentFormatter($contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;

        return $this;
    }

    /**
     * Get contentFormatter
     *
     * @return string
     */
    public function getContentFormatter()
    {
        return $this->contentFormatter;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Post
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set publicationDateStart
     *
     * @param \DateTime $publicationDateStart
     * @return Post
     */
    public function setPublicationDateStart($publicationDateStart)
    {
        $this->publicationDateStart = $publicationDateStart;

        return $this;
    }

    /**
     * Get publicationDateStart
     *
     * @return \DateTime
     */
    public function getPublicationDateStart()
    {
        return $this->publicationDateStart;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Post
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Post
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set commentsEnabled
     *
     * @param boolean $commentsEnabled
     * @return Post
     */
    public function setCommentsEnabled($commentsEnabled)
    {
        $this->commentsEnabled = $commentsEnabled;

        return $this;
    }

    /**
     * Get commentsEnabled
     *
     * @return boolean
     */
    public function getCommentsEnabled()
    {
        return $this->commentsEnabled;
    }

    /**
     * Set commentsCount
     *
     * @param integer $commentsCount
     * @return Post
     */
    public function setCommentsCount($commentsCount)
    {
        $this->commentsCount = $commentsCount;

        return $this;
    }

    /**
     * Get commentsCount
     *
     * @return integer
     */
    public function getCommentsCount()
    {
        return $this->commentsCount;
    }

    /**
     * Set author
     *
     * @param \Live\UserBundle\Entity\User $author
     * @return Post
     */
    public function setAuthor(\Live\UserBundle\Entity\User $author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \Live\UserBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set categories
     *
     * @param \Doctrine\Common\Collections\ArrayCollection $categories
     * @return Post
     */
    public function setCategories(\Doctrine\Common\Collections\ArrayCollection $categories)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Add categories
     *
     * @param \Live\BlogBundle\Entity\Category $categories
     * @return Post
     */
    public function addCategorie(\Live\BlogBundle\Entity\Category $categories)
    {
        $this->categories[] = $categories;

        return $this;
    }

    /**
     * Remove categories
     *
     * @param \Live\BlogBundle\Entity\Category $categories
     */
    public function removeCategorie(\Live\BlogBundle\Entity\Category $categories)
    {
        $this->categories->removeElement($categories);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set tags
     *
     * @param  \Live\BlogBundle\Entity\Tag $tags
     * @return Post
     */
    public function setTags(\Live\BlogBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Add tags
     *
     * @param \Live\BlogBundle\Entity\Tag $tags
     * @return Post
     */
    public function addTag(\Live\BlogBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \Live\BlogBundle\Entity\Tag $tags
     */
    public function removeTag(\Live\BlogBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add comments
     *
     * @param \Live\BlogBundle\Entity\Comment $comments
     * @return Post
     */
    public function addComment(\Live\BlogBundle\Entity\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Live\BlogBundle\Entity\Comment $comments
     */
    public function removeComment(\Live\BlogBundle\Entity\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }
}
