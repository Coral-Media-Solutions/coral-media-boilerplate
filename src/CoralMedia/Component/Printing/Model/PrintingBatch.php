<?php


namespace CoralMedia\Component\Printing\Model;


use CoralMedia\Bundle\PrintingBundle\Entity\PrintingBatchFile;
use CoralMedia\Component\Resource\Model\TimeStampableTrait;

abstract class PrintingBatch implements PrintingBatchInterface
{
    use TimeStampableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var array
     */
    protected $jsonData = [];

    /**
     * @var string
     */
    protected $reference;

    /**
     * @var PrintingBatchFile
     */
    protected $pdfFile;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return array|null
     */
    public function getJsonData(): ?array
    {
        return $this->jsonData;
    }

    /**
     * @param array $jsonData
     * @return $this
     */
    public function setJsonData(array $jsonData): self
    {
        $this->jsonData = $jsonData;

        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return $this
     */
    public function setReference(string $reference): self
    {
        $this->reference = $reference;
        return $this;
    }

    /**
     * @return PrintingBatchFile|null
     */
    public function getPdfFile(): ?PrintingBatchFile
    {
        return $this->pdfFile;
    }

    /**
     * @param PrintingBatchFile|null $pdfFile
     * @return $this
     */
    public function setPdfFile(?PrintingBatchFile $pdfFile): self
    {
        $this->pdfFile = $pdfFile;

        return $this;
    }
}