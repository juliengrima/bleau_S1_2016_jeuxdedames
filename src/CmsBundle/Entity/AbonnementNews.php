<?php

namespace CmsBundle\Entity;

/**
 * AbonnementNews
 */
class AbonnementNews
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $email;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return AbonnementNews
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @var boolean
     */
    private $etat;


    /**
     * Set etat
     *
     * @param boolean $etat
     *
     * @return AbonnementNews
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return boolean
     */
    public function getEtat()
    {
        return $this->etat;
    }
    /**
     * @var \DateTime
     */
    private $date_inscription;


    /**
     * Set dateInscription
     *
     * @param \DateTime $dateInscription
     *
     * @return AbonnementNews
     */
    public function setDateInscription($dateInscription)
    {
        $this->date_inscription = $dateInscription;

        return $this;
    }

    /**
     * Get dateInscription
     *
     * @return \DateTime
     */
    public function getDateInscription()
    {
        return $this->date_inscription;
    }
}
