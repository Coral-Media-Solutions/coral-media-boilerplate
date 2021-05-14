<?php


namespace CoralMedia\Component\Printing\Helper;

use Exception;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Mpdf\Output\Destination;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class PdfBatchFileHelper
 * @package CoralMedia\Component\Printing\Helper
 */
class PdfBatchFileHelper
{

    protected $twigEnvironment;

    public function __construct(Environment $twigEnvironment)
    {
        $this->twigEnvironment = $twigEnvironment;
    }

    /**
     * @param array $batchedOrders
     * @param array $pdfParams
     * @return string
     * @throws MpdfException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function generatePdf(array $batchedOrders, array $pdfParams): string
    {
        if(!isset($pdfParams['fileName']) || !$pdfParams['fileName']) {
            $pdfParams['fileName'] = $this->getFileName();
        }

        if (!isset($pdfParams['filePath'])) {
            throw new MpdfException(
                'You must use a valid filepath for output', Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        switch($pdfParams['columnLayout']) {
            case 1:
                $template = '@CoralMediaPrinting/pdf/single_column.html.twig';
                break;
            case 2:
                $template = '@CoralMediaPrinting/pdf/double_column.html.twig';
                break;
            default:
                throw new \InvalidArgumentException(
                    sprintf("Unsupported column layout value '%d'", $pdfParams['columnLayout'])
                );
        }

        $html =  $this->twigEnvironment->render($template, [
            'batchHeader' => $batchedOrders['batchHeader'],
            'batchNumber' => $batchedOrders['batchNumber'],
            'productSKU' => $batchedOrders ['productSKU'],
            'creationDate' => $batchedOrders['creationDate'],
            'items' => $batchedOrders['items'],
        ]);

        try {
            $pdfObject = new Mpdf(
                ['mode' => 'utf-8', 'format' => [$pdfParams['pageWidth'],
                    ($pdfParams['pageHeight'] * count($batchedOrders['items']))],
                    'margin-top' => $pdfParams['marginTop'],
                ]
            );
        } catch (MpdfException $e) {
            throw new MpdfException($e->getMessage(), $e->getCode());
        }
        $pdfObject->img_dpi = $pdfParams['imgDpi'];
        $pdfObject->setTitle('Batch #: ' . $batchedOrders['batchNumber']);
        $pdfObject->setSubject('ProductSKU: ' . $batchedOrders ['productSKU']);
        $pdfObject->setAuthor('System');
        $pdfObject->WriteHTML($html);

        $pdfObject->Output(
            $pdfParams['filePath'] . DIRECTORY_SEPARATOR . $pdfParams['fileName'], Destination::FILE
        );

        return $pdfParams['filePath'] . DIRECTORY_SEPARATOR . $pdfParams['fileName'];
    }

    /**
     * @param array $batchInfo
     * @param array $batchOrders
     * @param bool $doubleSided
     * @param int $columnLayout
     * @return array
     */
    public function batchOrders(array $batchInfo, array $batchOrders, $doubleSided = false, $columnLayout = 1): array
    {
        $batchedOrders = [];
        $batchNumber = $batchInfo['batchNumber'];

        $batchedOrders ['batchNumber'] = $batchNumber;
        $batchedOrders ['batchHeader'] = $batchInfo['batchHeader'];
        $batchedOrders ['productSKU'] = $batchInfo['productSKU'];

        $items = [];
        $i = 0;
        foreach ($batchOrders as $order) {
            foreach ($order['items'] as $item) {
                if($item['sku'] === $batchedOrders ['productSKU']) {
                    for ($j=0; $j < (int) $item['quantity']; $j++) {
                        foreach ($item['metadata']['image'] as $imageUrl) {
                            $items[$i] = [
                                'itemId' => $item['id'],
                                'itemSerial' => $item['id'] . '-' . ($j + 1),
                                'orderId' => $order['id'],
                                'orderPo' => $order['po'],
                                'batchNumber' => $batchNumber,
                                'imageUrl' => $imageUrl
                            ];
                            $i++;
                        }
                    }
                }
            }
        }

        $batchedOrders['creationDate'] = new \DateTime();
        $batchedOrders['totalItems'] = count($items);

        if($doubleSided === false){
            $this->batchSingleSidedOrders($batchedOrders, $items, $columnLayout);
        } else {
            $this->batchDoubleSidedOrders($batchedOrders, $items, $columnLayout);
        }

        return $batchedOrders;
    }

    /**
     * @param string $algorithm
     * @param int $length
     * @return string
     * @throws Exception
     */
    public function getFileName($algorithm = 'sha256', $length = 40): string
    {
        return \substr(
                \hash(
                    $algorithm,\microtime(true).\random_int(0, 9999999)
                ),
                0, $length)
            . '.pdf';
    }

    /**
     * @param array $batchedOrders
     * @param array $items
     * @param int $columnLayout
     */
    protected function batchSingleSidedOrders(array &$batchedOrders, array $items, $columnLayout = 1): void
    {
        if ($columnLayout === 1) {
            for ($i = 0; $i < count($items); $i++) {
                $batchedOrders['items'][$i] = $items[$i];
            }
        } elseif ($columnLayout === 2) {
            $k = 0;
            for ($i = 0; $i < count($items); $i+=$columnLayout) {
                $j=0;
                $batchedOrders['items'][$k][$j] = $items[$i];
                if(isset($items[$i+1])) {
                    $j++;
                    $batchedOrders['items'][$k][$j] = $items[$i + 1];
                }
                $k++;
            }
        } else {
            throw new \InvalidArgumentException(
                sprintf("Unsupported column layout value '%d'", $columnLayout)
            );
        }
    }

    /**
     * @param array $batchedOrders
     * @param array $items
     * @param int $columnLayout
     */
    protected function batchDoubleSidedOrders(array &$batchedOrders, array $items, $columnLayout = 1): void
    {
        $numberLabels = range(1, count($items)/2);


        for ($i=0; $i<count($items); $i+=2) {
            $numberLabel = array_shift($numberLabels);
            $batchedOrders['items']['A' . $numberLabel] = $items[$i];
            $batchedOrders['items']['B' . $numberLabel] = $items[$i+1];
        }
        krsort($batchedOrders['items']);

        if ($columnLayout === 2) {
            $items = $batchedOrders['items'];
            $batchedOrders['items'] = [];
            $itemKeys = array_keys($items);
            $itemData = array_values($items);
            $k = 0;
            for ($i = 0; $i < count($items); $i+=$columnLayout) {
                $batchedOrders['items'][$k][$itemKeys[$i]] = $itemData[$i];
                if(isset($itemKeys[$i+1])) {
                    $batchedOrders['items'][$k][$itemKeys[$i+1]] = $itemData[$i+1];
                }
                $k++;
            }
        } elseif ($columnLayout !== 1 || $columnLayout > 2) {
            throw new \InvalidArgumentException(
                sprintf("Unsupported column layout value '%d'", $columnLayout)
            );
        }
    }
}