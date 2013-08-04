<?php
namespace Live\UserBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class Comment
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
     * @ORM\Column(type="string", length=255, nullable=true, name="url")
     */
    private $url;

    /** 
     * @ORM\Column(type="string", length=255, nullable=true, name="email")
     */
    private $email;

    /** 
     * @ORM\Column(type="text", nullable=true, name="content")
     */
    private $content;

    /** 
     * @ORM\Column(type="datetime", nullable=true, name="createdAt")
     */
    private $createdAt;

    /** 
     * @ORM\Column(type="datetime", nullable=true, name="updatedAt")
     */
    private $updatedAt;

    /** 
     * @ORM\Column(type="integer", nullable=true, name="status")
     */
    private $status;

    /** 
     * @ORM\ManyToOne(targetEntity="Live\UserBundle\Entity\Post", inversedBy="comments")
     * @ORM\JoinColumn(name="post_id", referencedColumnName="id", nullable=false)
     */
    private $post;
}