<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PictureRepository::class)
 * @ApiResource(
 *     attributes={"pagination_items_per_page"=12},
 *     collectionOperations={
 *     "get",
 *     "post_upload" = {
 *         "route_name"="upload_picture",
 *         "method"="POST",
 *     }
 * },
 *     itemOperations={
 *     "get_view"={
 *         "route_name"="view_picture",
 *     },
 * }
 *     )
 * @ApiFilter(OrderFilter::class, properties={"views"="DESC"})
 */
class Picture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @ApiFilter(SearchFilter::class)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @ApiFilter(SearchFilter::class)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=8)
     * @ApiFilter(SearchFilter::class)
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity=File::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="picture")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $views;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        if (!in_array($category, ['new', 'popular']))
        {
            throw new \InvalidArgumentException("Category must be only \"new\" or \"popular\"");
        }

        $this->category = $category;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(File $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getViews(): ?int
    {
        return $this->views;
    }

    public function setViews(int $views): self
    {
        $this->views = $views;

        return $this;
    }
}
