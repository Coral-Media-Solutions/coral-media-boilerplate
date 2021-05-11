<?php


namespace CoralMedia\Component\Printing\Api;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use CoralMedia\Bundle\PrintingBundle\Entity\PrintingBatch;
use CoralMedia\Bundle\PrintingBundle\Entity\PrintingBatchFile;
use CoralMedia\Component\Printing\Helper\PdfBatchFileHelper;
use CoralMedia\Component\Printing\Model\PrintingBatchInterface;
use Exception;
use Mpdf\MpdfException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class PrintingBatchDataPersister implements DataPersisterInterface
{

    protected $decoratedDataPersister;
    protected $pdfBatchFileHelper;
    protected $containerParameters;

    /**
     * @param DataPersisterInterface $decoratedDataPersister
     * @param ParameterBagInterface $containerParameters
     * @param PdfBatchFileHelper $pdfBatchFileHelper
     */
    public function __construct(DataPersisterInterface $decoratedDataPersister,
                                ParameterBagInterface $containerParameters,
                                PdfBatchFileHelper $pdfBatchFileHelper)
    {
        $this->decoratedDataPersister = $decoratedDataPersister;
        $this->containerParameters = $containerParameters;
        $this->pdfBatchFileHelper = $pdfBatchFileHelper;
    }

    public function supports($data): bool
    {
        return ($data instanceof PrintingBatchInterface);
    }

    /**
     * @param  $data
     * @return object
     * @throws MpdfException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function persist($data): object
    {
        /**
         * @var $data PrintingBatch
         */
        $jsonData = $data->getJsonData();

        $batchedOrders = $this->pdfBatchFileHelper->batchOrders(
            $jsonData['batchInfo'], $jsonData['orders'],
            $jsonData['pdfParams']['doubleSided'], $jsonData['pdfParams']['columnLayout']
        );

        $vichParameters = $this->containerParameters->get('vich_uploader.mappings')['media_object'];
        $nameAlgorithm = $vichParameters['namer']['options']['algorithm'];
        $nameLength = $vichParameters['namer']['options']['length'];

        $jsonData['pdfParams']['filePath'] = $vichParameters['upload_destination'];
        $jsonData['pdfParams']['fileName'] = $this->pdfBatchFileHelper->getFileName($nameAlgorithm, $nameLength);

        $pdfFilePath = $this->pdfBatchFileHelper->generatePdf($batchedOrders, $jsonData['pdfParams']);

        $pdfFileObject = new PrintingBatchFile();
        $pdfFileObject->setFile(new File($pdfFilePath));
        $pdfFileObject->setFilePath($jsonData['pdfParams']['fileName']);

        /**
         * @var $object        PrintingBatch
         * @var $pdfFileObject PrintingBatchFile
         */
        $data->setPdfFile($pdfFileObject);
        $object = $this->decoratedDataPersister->persist($data);
        return $object;
    }

    public function remove($data)
    {
        return $this->decoratedDataPersister->remove($data);
    }
}