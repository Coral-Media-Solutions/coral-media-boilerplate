<?php

namespace CoralMedia\Bundle\PrintingBundle\Entity;

use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;
use CoralMedia\Bundle\PrintingBundle\Repository\PrintingBatchFileRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use CoralMedia\Bundle\PrintingBundle\Controller\Action\PrintingBatchFileAction;

/**
 * @ORM\Entity(repositoryClass=PrintingBatchFileRepository::class)
 *
 * @ApiResource(
 *     iri="http://schema.org/MediaObject",
 *     normalizationContext={
 *         "groups"={"media_object_read"}
 *     },
 *     collectionOperations={
 *         "post"={
 *             "controller"=PrintingBatchFileAction::class,
 *             "deserialize"=false,
 *             "security"="is_granted('ROLE_USER')",
 *             "validation_groups"={"Default", "media_object_create"},
 *             "openapi_context"={
 *                 "requestBody"={
 *                     "content"={
 *                         "multipart/form-data"={
 *                             "schema"={
 *                                 "type"="object",
 *                                 "properties"={
 *                                     "file"={
 *                                         "type"="string",
 *                                         "format"="binary"
 *                                     }
 *                                 }
 *                             }
 *                         }
 *                     }
 *                 }
 *             }
 *         },
 *         "get"
 *     },
 *     itemOperations={
 *         "get"
 *     }
 * )
 * @Vich\Uploadable
 */
class PrintingBatchFile extends \CoralMedia\Component\Printing\Model\PrintingBatchFile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string|null
     *
     * @ApiProperty(iri="http://schema.org/contentUrl")
     * @Groups({"media_object_read"})
     */
    protected $contentUrl;

    /**
     * @Assert\NotNull(groups={"media_object_create"})
     * @Vich\UploadableField(mapping="media_object", fileNameProperty="filePath")
     */
    protected $file;

    /**
     * @ORM\Column(nullable=true)
     */
    protected $filePath;

    /**
     * @Groups({"media_object_read"})
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @Groups({"media_object_read"})
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

}
