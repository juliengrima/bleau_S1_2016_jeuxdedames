<?php

namespace CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Partenaire
 */
class Partenaire
{
    public $file;

    protected function getUploadDir()
    {
        return 'uploads/imgcms';
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getWebPath()
    {
        return null === $this->image ? null : $this->getUploadDir().'/'.$this->image;
    }

    public function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir().'/'.$this->image;
    }

    /**
     * @ORM\PrePersist
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->image = uniqid() . '.' . $this->file->guessExtension();
        }
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        // Add your code here
    }

    /**
     * @ORM\PrePersist
     */
    public function setExpiresAtValue()
    {
        // Add your code here
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        // Add your code here
    }

    /**
     * @ORM\PostPersist
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }
        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->image);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }
    
    
    
//Generate


    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $image;

    /**
     * @var integer
     */
    private $donation;

    /**
     * @var string
     */
    private $adresse;

    /**
     * @var string
     */
    private $lien;

    /**
     * @var string
     */
    private $langue;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $partenaire;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->partenaire = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set image
     *
     * @param string $image
     *
     * @return Partenaire
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set donation
     *
     * @param integer $donation
     *
     * @return Partenaire
     */
    public function setDonation($donation)
    {
        $this->donation = $donation;

        return $this;
    }

    /**
     * Get donation
     *
     * @return integer
     */
    public function getDonation()
    {
        return $this->donation;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Partenaire
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set lien
     *
     * @param string $lien
     *
     * @return Partenaire
     */
    public function setLien($lien)
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * Get lien
     *
     * @return string
     */
    public function getLien()
    {
        return $this->lien;
    }

    /**
     * Set langue
     *
     * @param string $langue
     *
     * @return Partenaire
     */
    public function setLangue($langue)
    {
        $this->langue = $langue;

        return $this;
    }

    /**
     * Get langue
     *
     * @return string
     */
    public function getLangue()
    {
        return $this->langue;
    }

    /**
     * Add partenaire
     *
     * @param \CmsBundle\Entity\Partenaire $partenaire
     *
     * @return Partenaire
     */
    public function addPartenaire(\CmsBundle\Entity\Partenaire $partenaire)
    {
        $this->partenaire[] = $partenaire;

        return $this;
    }

    /**
     * Remove partenaire
     *
     * @param \CmsBundle\Entity\Partenaire $partenaire
     */
    public function removePartenaire(\CmsBundle\Entity\Partenaire $partenaire)
    {
        $this->partenaire->removeElement($partenaire);
    }

    /**
     * Get partenaire
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPartenaire()
    {
        return $this->partenaire;
    }
}
