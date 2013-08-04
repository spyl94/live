<?php
namespace Live\UserBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity(repositoryClass="Live\BlogBundle\Entity\PostRepository")
 */
class Post
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=255, nullable=true, name="title")
     */
    private $title;

    /** 
     * @ORM\Column(type="string", length=255, nullable=true, name="slug")
     */
    private $slug;

    /** 
     * @ORM\Column(type="text", nullable=true, name="content")
     */
    private $content;

    /** 
     * @ORM\Column(type="string", length=255, nullable=true, name="contentFormatter")
     */
    private $contentFormatter;

    /** 
     * @ORM\Column(type="boolean", nullable=true, name="enabled")
     */
    private $enabled;

    /** 
     * @ORM\Column(type="datetime", nullable=true, name="publicationDateStart")
     */
    private $publicationDateStart;

    /** 
     * @ORM\Column(type="datetime", nullable=true, name="createdAt")
     */
    private $createdAt;

    /** 
     * @ORM\Column(type="datetime", nullable=true, name="updatedAt")
     */
    private $updatedAt;

    /** 
     * @ORM\Column(type="boolean", nullable=true, name="commentsEnabled")
     */
    private $commentsEnabled;

    /** 
     * @ORM\Column(type="integer", nullable=true, name="commentsCount")
     */
    private $commentsCount;

    /** 
     * @ORM\OneToOne(targetEntity="Live\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", unique=true)
     */
    private $author;

    /** 
     * @ORM\OneToMany(targetEntity="Live\UserBundle\Entity\Comment", mappedBy="post")
     */
    private $comments;

    /** 
     * @ORM\ManyToMany(targetEntity="Live\UserBundle\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(
     *     name=, 
     *     joinColumns={@ORM\JoinColumn(name="Post_id", referencedColumnName="id")}, 
     *     inverseJoinColumns={@ORM\JoinColumn(name="Category_id", referencedColumnName="id")}
     * )
     */
    private $categories;
}