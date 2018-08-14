<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     attributes={"access_control"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"},
 *     collectionOperations={"get","post"},
 *     itemOperations={"get"},
 *     normalizationContext={"groups"={"visible"}},
 *     denormalizationContext={"groups"={"visible"}}
 * )
 * @ApiFilter(SearchFilter::class, properties={"id": null, "zip": "word_start", "name": "word_start"})
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @UniqueEntity(fields = {"zip"})
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"visible"})
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=255)
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="string",
     *             "example"="Berlin"
     *         }
     *     }
     * )
     * @Groups({"visible"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\JobRequest", mappedBy="zip", orphanRemoval=true)
     */
    private $jobRequests;

    public function __construct()
    {
        $this->jobRequests = new ArrayCollection();
    }

    public function getId()
    : ?int
    {
        return $this->id;
    }

    public function getZip()
    : ?int
    {
        return $this->zip;
    }

    public function setZip(int $zip)
    : self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getName()
    : ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|JobRequest[]
     */
    public function getJobRequests()
    : Collection
    {
        return $this->jobRequests;
    }

    public function addJobRequest(JobRequest $jobRequest)
    : self
    {
        if (!$this->jobRequests->contains($jobRequest)) {
            $this->jobRequests[] = $jobRequest;
            $jobRequest->setZip($this);
        }

        return $this;
    }

    public function removeJobRequest(JobRequest $jobRequest)
    : self
    {
        if ($this->jobRequests->contains($jobRequest)) {
            $this->jobRequests->removeElement($jobRequest);
            // set the owning side to null (unless already changed)
            if ($jobRequest->getZip() === $this) {
                $jobRequest->setZip(null);
            }
        }

        return $this;
    }
}
