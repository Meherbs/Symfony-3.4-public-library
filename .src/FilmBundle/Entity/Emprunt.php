<?php



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


}

