<?php
namespace Live\UserBundle\Entity;
use Doctrine\ORM\Mapping AS ORM;

/** 
 * @ORM\Entity
 */
class Event
{
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer", name="id")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=255, nullable=true, name="start")
     */
    private $start;

    /** 
     * @ORM\Column(type="string", length=255, nullable=true, name="end")
     */
    private $end;

    /** 
     * @ORM\Column(type="string", length=255, nullable=true, name="title")
     */
    private $title;

    /** 
     * @ORM\Column(type="boolean", nullable=true, name="validate")
     */
    private $validate;

    /** 
     * @ORM\Column(type="boolean", nullable=true, name="refused")
     */
    private $refused;

    /** 
     * @ORM\ManyToOne(targetEntity="Live\UserBundle\Entity\User", inversedBy="events")
     * @ORM\JoinColumn(name="creator_id", referencedColumnName="id")
     */
    private $creator;
}