<?php


namespace CoralMedia\Component\Printing\Model;


use CoralMedia\Component\Resource\Model\TimeStampableTrait;
use Symfony\Component\HttpFoundation\File\File;

abstract class PrintingBatchFile implements PrintingBatchFileInterface
{
    use TimeStampableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $contentUrl;

    /**
     * @var File
     */
    protected $file;

    /**
     * @var string
     */
    protected $filePath;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContentUrl(): string
    {
        return $this->contentUrl;
    }

    /**
     * @param string $contentUrl
     * @return PrintingBatchFile
     */
    public function setContentUrl(string $contentUrl): PrintingBatchFile
    {
        $this->contentUrl = $contentUrl;
        return $this;
    }

    /**
     * @return File
     */
    public function getFile(): File
    {
        return $this->file;
    }

    /**
     * @param File $file
     * @return PrintingBatchFile
     */
    public function setFile(File $file): PrintingBatchFile
    {
        $this->file = $file;
        return $this;
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }

    /**
     * @param string $filePath
     * @return PrintingBatchFile
     */
    public function setFilePath(string $filePath): PrintingBatchFile
    {
        $this->filePath = $filePath;
        return $this;
    }


}