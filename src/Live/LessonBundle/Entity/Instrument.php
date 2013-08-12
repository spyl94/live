<?php

namespace Live\LessonBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="instrument")
 * @ORM\Entity(repositoryClass="Live\LessonBundle\Entity\InstrumentRepository")
 */
class Instrument
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $level;

    /**
     * @ORM\ManyToMany(targetEntity="Live\UserBundle\Entity\User", inversedBy="instruments")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    private $players;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->player = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Constructor
     */
    public function __toString()
    {
        switch ($this->level) {
            case 0:
                return $this->name . ' débutant';
                break;
            case 1:
                return $this->name . ' intermédiaire';
                break;
            case 2:
                return $this->name . ' confirmé';
                break;
            case 3:
                return $this->name . ' expert';
                break;
            default:
                return $this->name;
                break;
        }
        return "NULL";
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
     * Set name
     *
     * @param string $name
     * @return Instrument
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set level
     *
     * @param integer $level
     * @return Instrument
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Add player
     *
     * @param \Live\UserBundle\Entity\User $player
     * @return Instrument
     */
    public function addPlayer(\Live\UserBundle\Entity\User $player)
    {
        $this->player[] = $player;

        return $this;
    }

    /**
     * Remove player
     *
     * @param \Live\UserBundle\Entity\User $player
     */
    public function removePlayer(\Live\UserBundle\Entity\User $player)
    {
        $this->player->removeElement($player);
    }

    /**
     * Get players
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlayers()
    {
        return $this->players;
    }
}
