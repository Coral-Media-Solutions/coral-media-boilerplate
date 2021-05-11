<?php

namespace CoralMedia\Bundle\PrintingBundle\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use CoralMedia\Bundle\PrintingBundle\Repository\PrintingBatchRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"printing_batch:read"}},
 *     denormalizationContext={"groups"={"printing_batch:write"}},
 * )
 * @ORM\Entity(repositoryClass=PrintingBatchRepository::class)
 */
class PrintingBatch extends \CoralMedia\Component\Printing\Model\PrintingBatch
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"printing_batch:read", "printing_batch:write"})
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Groups({"printing_batch:read", "printing_batch:write"})
     */
    protected $reference;

    /**
     * @ORM\Column(type="json")
     * @Groups({"printing_batch:read", "printing_batch:write"})
     */
    protected $jsonData = [];

    /**
     * @Groups({"printing_batch:read"})
     * @ORM\OneToOne(targetEntity=PrintingBatchFile::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     * @ApiProperty(iri="https://schema.org/DigitalDocument")
     */
    protected $pdfFile;

    /**
     * @Groups({"printing_batch:read"})
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @Groups({"printing_batch:read"})
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;
}
