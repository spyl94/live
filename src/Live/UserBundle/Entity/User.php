<?php

namespace Live\UserBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
//use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
**/
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank(message="Entrez votre prénom.", groups={"Profile"})
     * @Assert\Length(min=2, max=255, minMessage="Le prénom est trop court.", maxMessage="Le prénom est trop long.", groups={"Profile"})
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank(message="Entrez votre nom.", groups={"Profile"})
     * @Assert\Length(min=2, max=255, minMessage="Le nom est trop court.", maxMessage="Le nom est trop long.", groups={"Profile"})
     */
    protected $realname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank(message="Entrez votre promo.", groups={"Profile"})
     */
    private $promo;

    /**
     *
     * @ORM\OneToMany(targetEntity="Live\CalendarBundle\Entity\Event", mappedBy="creator")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="Live\UserBundle\Entity\Instrument", mappedBy="player")
     */
    private $instruments;


    public function __construct()
    {
        parent::__construct();
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
     * Add events
     *
     * @param \Live\CalendarBundle\Entity\Event $events
     * @return User
     */
    public function addEvent(\Live\CalendarBundle\Entity\Event $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \Live\CalendarBundle\Entity\Event $events
     */
    public function removeEvent(\Live\CalendarBundle\Entity\Event $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Add instruments
     *
     * @param \Live\UserBundle\Entity\Instrument $instruments
     * @return User
     */
    public function addInstrument(\Live\UserBundle\Entity\Instrument $instruments)
    {
        $this->instruments[] = $instruments;

        return $this;
    }

    /**
     * Remove instruments
     *
     * @param \Live\UserBundle\Entity\Instrument $instruments
     */
    public function removeInstrument(\Live\UserBundle\Entity\Instrument $instruments)
    {
        $this->instruments->removeElement($instruments);
    }

    /**
     * Get instruments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInstruments()
    {
        return $this->instruments;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set realname
     *
     * @param string $realname
     * @return User
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;

        return $this;
    }

    /**
     * Get realname
     *
     * @return string
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * Set promo
     *
     * @param string $promo
     * @return User
     */
    public function setPromo($promo)
    {
        $this->promo = $promo;

        return $this;
    }

    /**
     * Get promo
     *
     * @return string
     */
    public function getPromo()
    {
        return $this->promo;
    }
}
