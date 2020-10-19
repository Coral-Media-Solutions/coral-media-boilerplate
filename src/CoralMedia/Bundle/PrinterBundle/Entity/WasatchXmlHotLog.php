<?php


namespace CoralMedia\Bundle\PrinterBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class WasatchXmlHotLog
 * @package CoralMedia\Bundle\PrinterBundle\Entity
 *
 * @ORM\Entity()
 * @ApiResource()
 */
class WasatchXmlHotLog extends \CoralMedia\Component\Printer\Wasatch\Model\WasatchXmlHotLog
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected int $id;

    /**
     * @ORM\Column(type="text")
     */
    protected string $rawLog;

    /**
     * @ORM\Column(type="datetimetz")
     */
    protected \DateTime $logDateTime;

    /**
     * @ORM\Column(type="string", length=256, unique=true)
     */
    protected string $filePath;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    protected string $fileName;

    /**
     * @ORM\Column(type="smallint")
     */
    protected int $status;
}