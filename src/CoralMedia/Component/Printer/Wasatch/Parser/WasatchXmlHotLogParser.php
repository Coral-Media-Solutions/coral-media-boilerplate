<?php


namespace CoralMedia\Component\Printer\Wasatch\Parser;

/**
 * Class WasatchXmlHotLogParser
 * @package CoralMedia\Component\Printer\Wasatch\Parser
 *
 * Log File sample:
 *   Fri, 16 Oct 2020 17:58:19 -0400 : Print Unit 2, Processing: Z:\PRINTER-10\124511.xml
 *   Fri, 16 Oct 2020 17:58:19 -0400 : Finished Processing: Z:\PRINTER-10\124511.xml
 *   Fri, 16 Oct 2020 18:22:36 -0400 : Print Unit 2, Processing: Z:\PRINTER-10\124512.xml
 *   Fri, 16 Oct 2020 18:22:36 -0400 : Finished Processing: Z:\PRINTER-10\124512.xml
 *   Fri, 16 Oct 2020 18:22:36 -0400 : Print Unit 2, Processing: Z:\PRINTER-10\124513.xml
 *   Fri, 16 Oct 2020 18:22:36 -0400 : Finished Processing: Z:\PRINTER-10\124513.xml
 *   Fri, 16 Oct 2020 18:22:36 -0400 : Print Unit 2, Processing: Z:\PRINTER-10\124514.xml
 */
class WasatchXmlHotLogParser
{
    const DATE_TIME_EXP =
        "/([aA-zZ]{3})\,\s([0-9]{2})\s([aA-zZ]{3})\s([0-9]{4})\s([0-9]{2}\:[0-9]{2}\:[0-9]{2}\s\-?[0-9]{4})/ui";

    const DATE_FORMAT = 'D, d M Y H:i:s T';

    const STATUS_PROCESSING = 0;
    const STATUS_PROCESSED = 1;
    const STATUS_PROCESSING_KEYWORDS = 'Processing';
    const STATUS_PROCESSED_KEYWORDS = 'Finished Processing';

    const FILE_EXT = 'xml';
    const FILENAME_EXP = '/([\\|\/])([aA0-zZ9]+\./ui)';


    public function getLogDateTime($textToProcess = ''): \DateTime
    {
        preg_match(self::DATE_TIME_EXP, $textToProcess, $expMatches);
        return \DateTime::createFromFormat(self::DATE_FORMAT, $expMatches[0]);
    }

}