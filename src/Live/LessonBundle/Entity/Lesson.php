<?php

namespace Live\LessonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Lesson
 *
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(columns={"instrument_id", "creator_id"})})
 * @ORM\Entity(repositoryClass="Live\LessonBundle\Entity\LessonRepository")
 */
class Lesson
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
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Instrument", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $instrument;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Live\UserBundle\Entity\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Set creator
     *
     * @param \Live\UserBundle\Entity\User $creator
     * @return Event
     */
    public function setCreator(\Live\UserBundle\Entity\User $creator)
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Lesson
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
     * Set instrument
     *
     * @param \Live\LessonBundle\Entity\Instrument $instrument
     * @return Lesson
     */
    public function setInstrument(\Live\LessonBundle\Entity\Instrument $instrument = null)
    {
        $this->instrument = $instrument;

        return $this;
    }

    /**
     * Get instrument
     *
     * @return \Live\LessonBundle\Entity\Instrument
     */
    public function getInstrument()
    {
        return $this->instrument;
    }
}
