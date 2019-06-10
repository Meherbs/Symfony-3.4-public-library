<?php


namespace FilmBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert ;


/**
 * Film
 *
 * @ORM\Table(name="film", indexes={@ORM\Index(name="FK_FILM_APP1_CATEGORI", columns={"categorie_id"})})
 * @ORM\Entity
 */
class Film
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_film", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idFilm;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=20, nullable=false)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_sortie", type="date", nullable=true)
     */
    private $dateSortie;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=2048, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="couverture", type="string", length=255, nullable=true)
     */
    private $couverture;

    /**
     * @var boolean
     *
     * @ORM\Column(name="disponible", type="boolean", nullable=false)
     */
    private $disponible = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    /**
     * @var \Categorie
     *
     * @ORM\ManyToOne(targetEntity="Categorie")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="categorie_id", referencedColumnName="id_categorie")
     * })
     */
    private $categorie;
    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Acteur", mappedBy="film")
     */
    public $acteur;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->acteur = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @Assert\File(maxSize="1000k")
     */
    public $file;

    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }
    /**
     * Get idFilm
     *
     * @return integer
     */
    public function getIdFilm()
    {
        return $this->idFilm;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Film
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
     * Set dateSortie
     *
     * @param \DateTime $dateSortie
     *
     * @return Film
     */
    public function setDateSortie($dateSortie)
    {
        $this->dateSortie = $dateSortie;

        return $this;
    }

    /**
     * Get dateSortie
     *
     * @return \DateTime
     */
    public function getDateSortie()
    {
        return $this->dateSortie;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Film
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set couverture
     *
     * @param string $couverture
     *
     * @return Film
     */
    public function setCouverture($couverture)
    {
        $this->couverture = $couverture;

        return $this;
    }

    /**
     * Get couverture
     *
     * @return string
     */
    public function getCouverture()
    {
        return $this->couverture;
    }

    /**
     * Set disponible
     *
     * @param boolean $disponible
     *
     * @return Film
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Get disponible
     *
     * @return boolean
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Film
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Film
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set categorie
     *
     * @param \FilmBundle\Entity\Categorie $categorie
     *
     * @return Film
     */
    public function setCategorie(\FilmBundle\Entity\Categorie $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \FilmBundle\Entity\Categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    public function getWebPath() {
        return null===$this->couverture ? null : $this->getUploadDir().'/'.$this->couverture;
    }

    public function getUploadRootDir(){
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir(){
        return 'images/film';
    }

    public function uploadProfilePicture(){
        $this->file->move($this->getUploadRootDir(),$this->getClientOriginalName());
        $this->couverture= $this->file->getClientOriginalName();
        $this->file = null;
    }
    /**
     * Add acteur
     *
     * @param \FilmBundle\Entity\Acteur $acteur
     *
     * @return Film
     */
    public function addActeur(\FilmBundle\Entity\Acteur $acteur)
    {
        $this->acteur[] = $acteur;

        return $this;
    }

    /**
     * Remove acteur
     *
     * @param \FilmBundle\Entity\Acteur $acteur
     */
    public function removeActeur(\FilmBundle\Entity\Acteur $acteur)
    {
        $this->acteur->removeElement($acteur);
    }

    /**
     * Get acteur
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActeur()
    {
        return $this->acteur;
    }

    public function __toString() {
        return (String)($this->getTitre());
    }
}
