<?php

namespace CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commercant
 */
class Commercant
{
    public $file;

    protected function getUploadDir()
    {
        return 'uploads/imgcms';
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    public function getWebPath()
    {
        return null === $this->image ? null : $this->getUploadDir() . '/' . $this->image;
    }

    public function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir() . '/' . $this->image;
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

    public function __toString()
    {
        // TODO: Implement __toString() method.
        return $this->nom;
    }


    /*generate*/

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $adresse;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var integer
     */
    private $code;

    /**
     * @var string
     */
    private $ville;

    /**
     * @var string
     */
    private $lat;

    /**
     * @var string
     */
    private $lng;

    /**
     * @var string
     */
    private $lien;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $artiste;


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
     * @return Commercant
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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Commercant
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
     * Set nom
     *
     * @param string $nom
     *
     * @return Commercant
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
     * Set code
     *
     * @param integer $code
     *
     * @return Commercant
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return integer
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Commercant
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set lat
     *
     * @param string $lat
     *
     * @return Commercant
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set lng
     *
     * @param string $lng
     *
     * @return Commercant
     */
    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    /**
     * Get lng
     *
     * @return string
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * Set lien
     *
     * @param string $lien
     *
     * @return Commercant
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
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        // Add your code here
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->artiste = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add artiste
     *
     * @param \CmsBundle\Entity\Artiste $artiste
     *
     * @return Commercant
     */
    public function addArtiste(\CmsBundle\Entity\Artiste $artiste)
    {
        $this->artiste[] = $artiste;

        return $this;
    }

    /**
     * Remove artiste
     *
     * @param \CmsBundle\Entity\Artiste $artiste
     */
    public function removeArtiste(\CmsBundle\Entity\Artiste $artiste)
    {
        $this->artiste->removeElement($artiste);
    }

    /**
     * Get artiste
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArtiste()
    {
        return $this->artiste;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $commercant1;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $commercant2;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $commercant3;


    /**
     * Add commercant1
     *
     * @param \CmsBundle\Entity\Artiste $commercant1
     *
     * @return Commercant
     */
    public function addCommercant1(\CmsBundle\Entity\Artiste $commercant1)
    {
        $this->commercant1[] = $commercant1;

        return $this;
    }

    /**
     * Remove commercant1
     *
     * @param \CmsBundle\Entity\Artiste $commercant1
     */
    public function removeCommercant1(\CmsBundle\Entity\Artiste $commercant1)
    {
        $this->commercant1->removeElement($commercant1);
    }

    /**
     * Get commercant1
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommercant1()
    {
        return $this->commercant1;
    }

    /**
     * Add commercant2
     *
     * @param \CmsBundle\Entity\Artiste $commercant2
     *
     * @return Commercant
     */
    public function addCommercant2(\CmsBundle\Entity\Artiste $commercant2)
    {
        $this->commercant2[] = $commercant2;

        return $this;
    }

    /**
     * Remove commercant2
     *
     * @param \CmsBundle\Entity\Artiste $commercant2
     */
    public function removeCommercant2(\CmsBundle\Entity\Artiste $commercant2)
    {
        $this->commercant2->removeElement($commercant2);
    }

    /**
     * Get commercant2
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommercant2()
    {
        return $this->commercant2;
    }

    /**
     * Add commercant3
     *
     * @param \CmsBundle\Entity\Artiste $commercant3
     *
     * @return Commercant
     */
    public function addCommercant3(\CmsBundle\Entity\Artiste $commercant3)
    {
        $this->commercant3[] = $commercant3;

        return $this;
    }

    /**
     * Remove commercant3
     *
     * @param \CmsBundle\Entity\Artiste $commercant3
     */
    public function removeCommercant3(\CmsBundle\Entity\Artiste $commercant3)
    {
        $this->commercant3->removeElement($commercant3);
    }

    /**
     * Get commercant3
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommercant3()
    {
        return $this->commercant3;
    }
}
