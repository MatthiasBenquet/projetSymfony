<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EntrepriseRepository::class)
 */
class Entreprise
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\Length(
     *      min = 4,
     *      max = 60,
     *      minMessage = "Le nom de l'entreprise doit faire au moins {{ limit }} caractères.",
     *      maxMessage = "Le nom de l'entreprise doit faire au plus {{ limit }} caractères."
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank(
     *      message = "Cette valeur ne doit pas être vide."
     *)
     */
    private $domaine;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\Regex(pattern="#^[1-9]#", message="Le numéro de rue semble incorrect.")
     * @Assert\Regex(pattern="#rue|avenue|boulevard|impasse|allée|place|route|voie#i", message="Le type de route/voie semble incorrect.")
     * @Assert\Regex(pattern="# [0-9]{5} #", message="Il semble y avoir un problème avec le code postal.")
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Regex(pattern="#[0-9]{10}#", message="Le numéro de téléphone doit contenir 10 chiffres uniquement.")
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Le numéro de téléphone doit contenir 10 chiffres uniquement."
     * )
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=120, nullable=true)
     * @Assert\Url(
     *      message = "Cette valeur n'est pas une URL valide."
     *)
     */
    private $urlSiteWeb;

    /**
     * @ORM\OneToMany(targetEntity=Stage::class, mappedBy="entreprise")
     */
    private $stages;

    public function __construct()
    {
        $this->stages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getUrlSiteWeb(): ?string
    {
        return $this->urlSiteWeb;
    }

    public function setUrlSiteWeb(?string $urlSiteWeb): self
    {
        $this->urlSiteWeb = $urlSiteWeb;

        return $this;
    }

    /**
     * @return Collection|Stage[]
     */
    public function getStages(): Collection
    {
        return $this->stages;
    }

    public function addStage(Stage $stage): self
    {
        if (!$this->stages->contains($stage)) {
            $this->stages[] = $stage;
            $stage->setEntreprise($this);
        }

        return $this;
    }

    public function removeStage(Stage $stage): self
    {
        if ($this->stages->removeElement($stage)) {
            // set the owning side to null (unless already changed)
            if ($stage->getEntreprise() === $this) {
                $stage->setEntreprise(null);
            }
        }

        return $this;
    }
}
