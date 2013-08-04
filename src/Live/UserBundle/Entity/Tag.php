<?php
namespace Live\UserBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class Tag
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=255, nullable=true, name="name")
     */
    private $name;

    /** 
     * @ORM\Column(type="boolean", nullable=true, name="enabled")
     */
    private $enabled;

    /** 
     * @ORM\Column(type="string", length=255, nullable=true, name="slug")
     */
    private $slug;

    /** 
     * @ORM\Column(type="datetime", nullable=true, name="createdAt")
     */
    private $createdAt;

    /** 
     * @ORM\Column(type="datetime", nullable=true, name="updatedAt")
     */
    private $updatedAt;
}