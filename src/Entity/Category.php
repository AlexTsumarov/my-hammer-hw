<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     attributes={"access_control"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"},
 *     collectionOperations={"get","post"},
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"visible"}},
 *     denormalizationContext={"groups"={"visible"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @UniqueEntity("name")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Groups({"visible"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\JobRequest", mappedBy="category", orphanRemoval=true)
     */
    private $jobRequests;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"visible"})
     */
    private $catId;

    public function __construct()
    {
        $this->jobRequests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|JobRequest[]
     */
    public function getJobRequests(): Collection
    {
        return $this->jobRequests;
    }

    public function addJobRequest(JobRequest $jobRequest): self
    {
        if (!$this->jobRequests->contains($jobRequest)) {
            $this->jobRequests[] = $jobRequest;
            $jobRequest->setCategory($this);
        }

        return $this;
    }

    public function removeJobRequest(JobRequest $jobRequest): self
    {
        if ($this->jobRequests->contains($jobRequest)) {
            $this->jobRequests->removeElement($jobRequest);
            // set the owning side to null (unless already changed)
            if ($jobRequest->getCategory() === $this) {
                $jobRequest->setCategory(null);
            }
        }

        return $this;
    }

    public function getCatId(): ?int
    {
        return $this->catId;
    }

    public function setCatId(int $catId): self
    {
        $this->catId = $catId;

        return $this;
    }
}
