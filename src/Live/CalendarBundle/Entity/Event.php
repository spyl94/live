<?php

namespace Live\CalendarBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Event
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
     * @ORM\Column(name="start", type="string", length=255)
     */
    private $start;

    /**
     * @var string
     *
     * @ORM\Column(name="end", type="string", length=255)
     */
    private $end;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validate", type="boolean")
     */
    private $validate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="refused", type="boolean")
     */
    private $refused;


    /**
     *
     * @ORM\ManyToOne(targetEntity="Live\UserBundle\Entity\User", inversedBy="events")
     */
    private $creator;



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
     * Set start
     *
     * @param string $start
     * @return Event
     */
    public function setStart($start)
    {
        $this->start = $start;
    
        return $this;
    }

    /**
     * Get start
     *
     * @return string 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param string $end
     * @return Event
     */
    public function setEnd($end)
    {
        $this->end = $end;
    
        return $this;
    }

    /**
     * Get end
     *
     * @return string 
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Event
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
     * Set validate
     *
     * @param boolean $validate
     * @return Event
     */
    public function setValidate($validate)
    {
        $this->validate = $validate;
    
        return $this;
    }

    /**
     * Get validate
     *
     * @return boolean 
     */
    public function getValidate()
    {
        return $this->validate;
    }

    /**
     * Set  refused
     *
     * @param boolean $refused
     * @return Event
     */
    public function setRefused($refused)
    {
        $this->refused = $refused;
    
        return $this;
    }

    /**
     * Get refused
     *
     * @return boolean 
     */
    public function getRefused()
    {
        return $this->refused;
    }

    /**
     * Set creator
     *
     * @param \Live\UserBundle\Entity\User $creator
     * @return Event
     */
    public function setCreator(\Live\UserBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;
    
        return $this;
    }

    /**
     * Get creator
     *
     * @return \Live\UserBundle\Entity\User 
     */
    public function getCreator()
    {
        return $this->creator;
    }
}
