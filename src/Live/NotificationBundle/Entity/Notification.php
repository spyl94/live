<?php

namespace Live\NotificationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Notification
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Live\NotificationBundle\Entity\NotificationRepository")
 */
class Notification
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
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_read", type="boolean")
     */
    private $isRead;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Live\UserBundle\Entity\User", inversedBy="notifications")
     */
    private $receiver;


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
     * Set content
     *
     * @param string $content
     * @return Notification
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Notification
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
     * Set isRead
     *
     * @param boolean $isRead
     * @return Notification
     */
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }

    /**
     * Get isRead
     *
     * @return boolean
     */
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * Set receiver
     *
     * @param \Live\UserBundle\Entity\User $receiver
     * @return Event
     */
    public function setReceiver(\Live\UserBundle\Entity\User $receiver)
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     * Get receiver
     *
     * @return \Live\UserBundle\Entity\User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }
}
