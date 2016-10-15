<?php

namespace CmsBundle\Entity;

/**
 * Equipe
 */
class Equipe
{

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $prenom;

    /**
     * @var string
     */
    private $role;

    /**
     * @var integer
     */
    private $telephone;

    /**
     * @var boolean
     */
    private $show_tel;

    /**
     * @var \CmsBundle\Entity\Images
     */
    private $images;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Equipe
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Equipe
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Equipe
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set telephone
     *
     * @param integer $telephone
     *
     * @return Equipe
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return integer
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set showTel
     *
     * @param boolean $showTel
     *
     * @return Equipe
     */
    public function setShowTel($showTel)
    {
        $this->show_tel = $showTel;

        return $this;
    }

    /**
     * Get showTel
     *
     * @return boolean
     */
    public function getShowTel()
    {
        return $this->show_tel;
    }

    /**
     * Set images
     *
     * @param \CmsBundle\Entity\Images $images
     *
     * @return Equipe
     */
    public function setImages(\CmsBundle\Entity\Images $images = null)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return \CmsBundle\Entity\Images
     */
    public function getImages()
    {
        return $this->images;
    }
}
