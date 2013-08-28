<?php

namespace Live\UserBundle\Entity;

//use FOS\UserBundle\Entity\User as BaseUser;
use FOS\UserBundle\Model\User as BaseUser;
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
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank(message="Entrez votre nom.", groups={"Profile"})
     * @Assert\Length(min=2, max=255, minMessage="Le nom est trop court.", maxMessage="Le nom est trop long.", groups={"Profile"})
     */
    protected $lastname;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true, name="facebookId")
     *
     */
    protected $facebookId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="cotisant", type="boolean", nullable=true)
     */
    private $cotisant;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Assert\NotBlank(message="Entrez votre promo.", groups={"Profile"})
     */
    private $promo;

    /**
     * @ORM\OneToMany(targetEntity="Live\CalendarBundle\Entity\Event", mappedBy="creator")
     */
    private $events;

    /**
     * @ORM\OneToMany(targetEntity="Live\NotificationBundle\Entity\Notification", mappedBy="receiver")
     */
    private $notifications;

    /**
     * @ORM\ManyToMany(targetEntity="Live\LessonBundle\Entity\Instrument")
     */
    private $instruments;


    public function __construct()
    {
        parent::__construct();
        $this->events = new \Doctrine\Common\Collections\ArrayCollection();
        $this->notifications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->instruments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function isGranted($role)
    {
        return in_array($role, $this->getRoles());
    }

    public function serialize()
    {
        return serialize(array($this->facebookId, parent::serialize()));
    }

    public function unserialize($data)
    {
        list($this->facebookId, $parentData) = unserialize($data);
        parent::unserialize($parentData);
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the full name of the user (first + last name)
     * @return string
     */
    public function getFullName()
    {
        return $this->getFirstname() . ' ' . $this->getLastname();
    }

     /**
     * @param string $facebookId
     * @return void
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
        $this->setUsername($facebookId);
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param Array
     */
    public function setFBData($fbdata)
    {
        if (isset($fbdata['id'])) {
            $this->setFacebookId($fbdata['id']);
            $this->addRole('ROLE_FACEBOOK');
        }
        if (isset($fbdata['first_name'])) {
            $this->setFirstname($fbdata['first_name']);
            $this->setUsername($fbdata['first_name']);
        }
        if (isset($fbdata['last_name'])) {
            $this->setLastname($fbdata['last_name']);
        }
        if (isset($fbdata['email'])) {
            $this->setEmail($fbdata['email']);
        }
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
     * Set cotisant
     *
     * @param boolean $enabled
     * @return Post
     */
    public function setCotisant($cotisant)
    {
        $this->cotisant = $cotisant;

        return $this;
    }

    /**
     * Get cotisant
     *
     * @return boolean
     */
    public function getCotisant()
    {
        return $this->cotisant;
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
     * Add notifications
     *
     * @param \Live\NotificationBundle\Entity\Notification $notifications
     * @return User
     */
    public function addNotification(\Live\NotificationBundle\Entity\Notification $notifications)
    {
        $this->notifications[] = $notifications;

        return $this;
    }

    /**
     * Remove notifications
     *
     * @param \Live\NotificationBundle\Entity\Notification $notifications
     */
    public function removeNotification(\Live\NotificationBundle\Entity\Notification $notifications)
    {
        $this->notifications->removeElement($notifications);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNotifications()
    {
        return $this->notifications;
    }

    /**
     * Set instruments
     *
     * @param array
     * @return User
     */
    public function setInstruments($instruments)
    {
        foreach ($instruments as $instrument) {
            $this->addInstrument($instrument);
        }

        return $this;
    }

    /**
     * Add instruments
     *
     * @param \Live\LessonBundle\Entity\Instrument $instruments
     * @return User
     */
    public function addInstrument(\Live\LessonBundle\Entity\Instrument $instruments)
    {
        $this->instruments[] = $instruments;

        return $this;
    }

    /**
     * Remove instruments
     *
     * @param \Live\LessonBundle\Entity\Instrument $instruments
     */
    public function removeInstrument(\Live\LessonBundle\Entity\Instrument $instruments)
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
