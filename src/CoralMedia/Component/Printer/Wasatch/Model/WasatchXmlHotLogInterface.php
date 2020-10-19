<?php


namespace CoralMedia\Component\Printer\Wasatch\Model;


use DateTime;

interface WasatchXmlHotLogInterface
{

    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return DateTime
     */
    public function getLogDateTime(): DateTime;

    /**
     * @param DateTime $logDateTime
     * @return WasatchXmlHotLogInterface
     */
    public function setLogDateTime(DateTime $logDateTime): WasatchXmlHotLogInterface;

    /**
     * @return string
     */
    public function getRawLog(): string;

    /**
     * @param string $rawLog
     * @return WasatchXmlHotLogInterface
     */
    public function setRawLog(string $rawLog): WasatchXmlHotLogInterface;

    /**
     * @return string
     */
    public function getFilePath(): string;

    /**
     * @param string $filePath
     * @return WasatchXmlHotLogInterface
     */
    public function setFilePath(string $filePath): WasatchXmlHotLogInterface;

    /**
     * @return string
     */
    public function getFileName(): string;

    /**
     * @param string $fileName
     * @return WasatchXmlHotLogInterface
     */
    public function setFileName(string $fileName): WasatchXmlHotLogInterface;

    /**
     * @return int
     */
    public function getStatus(): int;

    /**
     * @param int $status
     * @return WasatchXmlHotLogInterface
     */
    public function setStatus(int $status): WasatchXmlHotLogInterface;
}