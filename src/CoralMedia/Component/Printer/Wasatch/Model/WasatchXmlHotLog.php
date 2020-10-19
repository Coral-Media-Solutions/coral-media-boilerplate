<?php


namespace CoralMedia\Component\Printer\Wasatch\Model;


use DateTime;

class WasatchXmlHotLog implements WasatchXmlHotLogInterface
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var DateTime
     */
    protected DateTime $logDateTime;

    /**
     * @var string
     */
    protected string $rawLog;

    /**
     * @var string
     */
    protected string $filePath;

    /**
     * @var string
     */
    protected string $fileName;

    /**
     * @var int
     */
    protected int $status;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getLogDateTime(): DateTime
    {
        return $this->logDateTime;
    }

    /**
     * @param DateTime $logDateTime
     * @return WasatchXmlHotLogInterface
     */
    public function setLogDateTime(DateTime $logDateTime): WasatchXmlHotLogInterface
    {
        $this->logDateTime = $logDateTime;
        return $this;
    }

    /**
     * @return string
     */
    public function getRawLog(): string
    {
        return $this->rawLog;
    }

    /**
     * @param string $rawLog
     * @return WasatchXmlHotLogInterface
     */
    public function setRawLog(string $rawLog): WasatchXmlHotLogInterface
    {
        $this->rawLog = $rawLog;
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
     * @return WasatchXmlHotLogInterface
     */
    public function setFilePath(string $filePath): WasatchXmlHotLogInterface
    {
        $this->filePath = $filePath;
        return $this;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @param string $fileName
     * @return WasatchXmlHotLogInterface
     */
    public function setFileName(string $fileName): WasatchXmlHotLogInterface
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return WasatchXmlHotLogInterface
     */
    public function setStatus(int $status): WasatchXmlHotLogInterface
    {
        $this->status = $status;
        return $this;
    }
}