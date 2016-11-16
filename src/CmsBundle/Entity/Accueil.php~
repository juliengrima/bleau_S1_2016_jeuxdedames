<?php

namespace CmsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Accueil
 */
class Accueil
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

    /*generate*/


    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var string
     */
    private $premiertitre;

    /**
     * @var string
     */
    private $premiercontenu;

    /**
     * @var string
     */
    private $deuxiemetitre;

    /**
     * @var string
     */
    private $deuxiemecontenu;

    /**
     * @var string
     */
    private $troisiemetitre;

    /**
     * @var string
     */
    private $troisiemecontenu;

    /**
     * @var string
     */
    private $image;

    /**
     * @var string
     */
    private $contenu;

    /**
     * @var \CmsBundle\Entity\Images
     */
    private $image_2;


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
     * Set titre
     *
     * @param string $titre
     *
     * @return Accueil
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set premiertitre
     *
     * @param string $premiertitre
     *
     * @return Accueil
     */
    public function setPremiertitre($premiertitre)
    {
        $this->premiertitre = $premiertitre;

        return $this;
    }

    /**
     * Get premiertitre
     *
     * @return string
     */
    public function getPremiertitre()
    {
        return $this->premiertitre;
    }

    /**
     * Set premiercontenu
     *
     * @param string $premiercontenu
     *
     * @return Accueil
     */
    public function setPremiercontenu($premiercontenu)
    {
        $this->premiercontenu = $premiercontenu;

        return $this;
    }

    /**
     * Get premiercontenu
     *
     * @return string
     */
    public function getPremiercontenu()
    {
        return $this->premiercontenu;
    }

    /**
     * Set deuxiemetitre
     *
     * @param string $deuxiemetitre
     *
     * @return Accueil
     */
    public function setDeuxiemetitre($deuxiemetitre)
    {
        $this->deuxiemetitre = $deuxiemetitre;

        return $this;
    }

    /**
     * Get deuxiemetitre
     *
     * @return string
     */
    public function getDeuxiemetitre()
    {
        return $this->deuxiemetitre;
    }

    /**
     * Set deuxiemecontenu
     *
     * @param string $deuxiemecontenu
     *
     * @return Accueil
     */
    public function setDeuxiemecontenu($deuxiemecontenu)
    {
        $this->deuxiemecontenu = $deuxiemecontenu;

        return $this;
    }

    /**
     * Get deuxiemecontenu
     *
     * @return string
     */
    public function getDeuxiemecontenu()
    {
        return $this->deuxiemecontenu;
    }

    /**
     * Set troisiemetitre
     *
     * @param string $troisiemetitre
     *
     * @return Accueil
     */
    public function setTroisiemetitre($troisiemetitre)
    {
        $this->troisiemetitre = $troisiemetitre;

        return $this;
    }

    /**
     * Get troisiemetitre
     *
     * @return string
     */
    public function getTroisiemetitre()
    {
        return $this->troisiemetitre;
    }

    /**
     * Set troisiemecontenu
     *
     * @param string $troisiemecontenu
     *
     * @return Accueil
     */
    public function setTroisiemecontenu($troisiemecontenu)
    {
        $this->troisiemecontenu = $troisiemecontenu;

        return $this;
    }

    /**
     * Get troisiemecontenu
     *
     * @return string
     */
    public function getTroisiemecontenu()
    {
        return $this->troisiemecontenu;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Accueil
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
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Accueil
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * Set image2
     *
     * @param \CmsBundle\Entity\Images $image2
     *
     * @return Accueil
     */
    public function setImage2(\CmsBundle\Entity\Images $image2 = null)
    {
        $this->image_2 = $image2;

        return $this;
    }

    /**
     * Get image2
     *
     * @return \CmsBundle\Entity\Images
     */
    public function getImage2()
    {
        return $this->image_2;
    }
}
