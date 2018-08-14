<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(
 *     attributes={"access_control"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"},
 *     collectionOperations={"get","post"},
 *     itemOperations={"get","put"},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\JobRequestRepository")
 * @UniqueEntity(fields = {"title","zip"})
 */
class JobRequest
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\Length(min = 5,max = 200,
     *    minMessage = "Title should be at least {{ limit }} symbols",
     *    maxMessage = "Title should not more than {{ limit }} symbols"
     * )
     * @Groups({"read", "write"})
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="jobRequests")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"write"})
     * @ApiSubresource(maxDepth=1)
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="IRI",
     *             "example"="/api/locations/1"
     *         }
     *     }
     * )
     */
    private $zip;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="jobRequests")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"write"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *             "type"="IRI",
     *             "example"="/api/categories/1"
     *         }
     *     }
     * )
     */
    private $category;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\Range(
     *      min = "now",
     *      max = "first day of December next year",
     *      minMessage = "End date should not be in the past",
     *      maxMessage = "End date should not be later than 12 month from now"
     * )
     * @Groups({"write"})
     * @ApiProperty(
     *     attributes={
     *         "swagger_context"={
     *     "type"="string",
     *     "format"="date-time",
     *     "example"="2018-10-01"
     * }
     *     }
     * )
     */
    private $endDT;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"write","read"})
     */
    private $description;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getZip(): ?Location
    {
        return $this->zip;
    }

    public function setZip(?Location $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getEndDT(): ?\DateTimeInterface
    {
        return $this->endDT;
    }

    public function setEndDT(\DateTimeInterface $endDT): self
    {
        $this->endDT = $endDT;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
