<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AircraftModelRepository;
use App\Services\GetAirportsDataService;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AircraftModelRepository::class)]
#[\ApiPlatform\Core\Annotation\ApiResource(
    collectionOperations: [
        "get"  => [
            "method"                => "GET",
            "normalization_context" => ["groups" => ["get:collection:model"]]
        ],
        "post" => [
            "method"                  => "POST",
            "security"                => "is_granted('" . User::ROLE_ADMIN . "')",
            "denormalization_context" => ["groups" => ["post:collection:model"]],
            "normalization_context"   => ["groups" => ["get:item:model"]]
        ]
    ],
    itemOperations:[
        "get"  => [
            "method"                => "GET",
            "normalization_context" => ["groups" => ["get:item:model"]]
        ],
        "put"=>[
            "method"                  => "PUT",
            "security"                => "is_granted('" . User::ROLE_ADMIN . "')",
            "denormalization_context" => ["groups" => ["post:item:model"]],
            "normalization_context"   => ["groups" => ["get:item:model"]]
        ]
    ],
//    attributes: [
//        "security" => "is_granted('" . User::ROLE_ADMIN . "') or is_granted('" . User::ROLE_USER . "') or is_granted('" . User::ROLE_MANAGER . "') or is_granted('" . User::ROLE_OWNER . "')"
//    ]
)]
class AircraftModel
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:item:model",
        "get:collection:model",
        "post:item:model"
    ])]
    private ?string $plane = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:item:model",
        "get:collection:model",
        "post:item:model"
    ])]
    private ?string $brand = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    #[Groups([
        "get:item:model",
        "get:collection:model",
        "post:item:model"
    ])]
    private ?int $passenger_capacity = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    #[Groups([
        "get:item:model",
        "get:collection:model",
        "post:item:model"
    ])]
    private ?int $cruise_speed_kmph = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:item:model",
        "get:collection:model",
        "post:item:model"
    ])]
    private ?string $engine = null;

    /**
     * @var string|null
     */
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:item:model",
        "get:collection:model",
        "post:item:model"
    ])]
    private ?string $imgThumb = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getPlane(): ?string
    {
        return $this->plane;
    }

    /**
     * @param string $plane
     * @return $this
     */
    public function setPlane(string $plane): self
    {
        $this->plane = $plane;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     * @return $this
     */
    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEngine(): ?string
    {
        return $this->engine;
    }

    /**
     * @param string $engine
     * @return $this
     */
    public function setEngine(string $engine): self
    {
        $this->engine = $engine;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImgThumb(): ?string
    {
        return $this->imgThumb;
    }

    /**
     * @param string $imgThumb
     * @return $this
     */
    public function setImgThumb(string $imgThumb): self
    {
        $this->imgThumb = $imgThumb;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getPassengerCapacity(): ?int
    {
        return $this->passenger_capacity;
    }

    /**
     * @param int $passenger_capacity
     * @return $this
     */
    public function setPassengerCapacity(int $passenger_capacity): self
    {
        $this->passenger_capacity = $passenger_capacity;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getCruiseSpeedKmph(): ?int
    {
        return $this->cruise_speed_kmph;
    }

    /**
     * @param int $cruise_speed_kmph
     * @return $this
     */
    public function setCruiseSpeedKmph(int $cruise_speed_kmph): self
    {
        $this->cruise_speed_kmph = $cruise_speed_kmph;

        return $this;
    }

}
