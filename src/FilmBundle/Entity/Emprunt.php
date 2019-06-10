<?php

namespace FilmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emprunt
 *
 * @ORM\Table(name="emprunt", indexes={@ORM\Index(name="FK_EMPRUNT_APP2_FILM", columns={"film_id"}), @ORM\Index(name="FK_EMPRUNT_APP3_ADHERENT", columns={"adherent_id"})})
 * @ORM\Entity
 */
class Emprunt
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_emprunt", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEmprunt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dh_emprunt", type="datetime", nullable=false)
     */
    private $dhEmprunt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dh_retour", type="datetime", nullable=true)
     */
    private $dhRetour;

    /**
     * @var \Film
     *
     * @ORM\ManyToOne(targetEntity="Film")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="film_id", referencedColumnName="id_film")
     * })
     */
    private $film;

    /**
     * @var \Adherent
     *
     * @ORM\ManyToOne(targetEntity="Adherent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="adherent_id", referencedColumnName="id_adherent")
     * })
     */
    private $adherent;



    /**
     * Get idEmprunt
     *
     * @return integer
     */
    public function getIdEmprunt()
    {
        return $this->idEmprunt;
    }

    /**
     * Set dhEmprunt
     *
     * @param \DateTime $dhEmprunt
     *
     * @return Emprunt
     */
    public function setDhEmprunt($dhEmprunt)
    {
        $this->dhEmprunt = $dhEmprunt;

        return $this;
    }

    /**
     * Get dhEmprunt
     *
     * @return \DateTime
     */
    public function getDhEmprunt()
    {
        return $this->dhEmprunt;
    }

    /**
     * Set dhRetour
     *
     * @param \DateTime $dhRetour
     *
     * @return Emprunt
     */
    public function setDhRetour($dhRetour)
    {
        $this->dhRetour = $dhRetour;

        return $this;
    }

    /**
     * Get dhRetour
     *
     * @return \DateTime
     */
    public function getDhRetour()
    {
        return $this->dhRetour;
    }

    /**
     * Set film
     *
     * @param \FilmBundle\Entity\Film $film
     *
     * @return Emprunt
     */
    public function setFilm(\FilmBundle\Entity\Film $film = null)
    {
        $this->film = $film;

        return $this;
    }

    /**
     * Get film
     *
     * @return \FilmBundle\Entity\Film
     */
    public function getFilm()
    {
        return $this->film;
    }

    /**
     * Set adherent
     *
     * @param \FilmBundle\Entity\Adherent $adherent
     *
     * @return Emprunt
     */
    public function setAdherent(\FilmBundle\Entity\Adherent $adherent = null)
    {
        $this->adherent = $adherent;

        return $this;
    }

    /**
     * Get adherent
     *
     * @return \FilmBundle\Entity\Adherent
     */
    public function getAdherent()
    {
        return $this->adherent;
    }
}
