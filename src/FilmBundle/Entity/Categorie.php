<?php

namespace FilmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_categorie", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCategorie;

    /**
     * @var string
     *
     * @ORM\Column(name="design_categorie", type="string", length=30, nullable=false)
     */
    private $designCategorie;



    /**
     * Get idCategorie
     *
     * @return integer
     */
    public function getIdCategorie()
    {
        return $this->idCategorie;
    }

    /**
     * Set designCategorie
     *
     * @param string $designCategorie
     *
     * @return Categorie
     */
    public function setDesignCategorie($designCategorie)
    {
        $this->designCategorie = $designCategorie;

        return $this;
    }

    /**
     * Get designCategorie
     *
     * @return string
     */
    public function getDesignCategorie()
    {
        return $this->designCategorie;
    }

    public function __toString() {
        return (String)($this->getDesignCategorie());
    }
}
