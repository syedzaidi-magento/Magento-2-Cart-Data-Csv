<?php
/**
 * Created by PhpStorm.
 * User: syedzaidi
 * Date: 7/9/19
 * Time: 1:31 AM
 */

namespace Syedzaidi\CartProductCsv\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Checkout\Model\Session as checkoutSession;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\File\Csv;

class Index extends Action
{

    /**
     * @var Session
     */
    private $session;
    /**
     * @var checkoutSession
     */
    private $checkoutSession;
    /**
     * @var Csv
     */
    private $csvProcessor;
    /**
     * @var DirectoryList
     */
    private $directoryList;
    /**
     * @var FileFactory
     */
    private $fileFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param Session $session
     * @param Csv $csvProcessor
     * @param DirectoryList $directoryList
     * @param FileFactory $fileFactory
     * @param checkoutSession $checkoutSession
     * @param array $data
     */
    public function __construct(
        Context $context,
        Session $session,
        Csv $csvProcessor,
        DirectoryList $directoryList,
        FileFactory $fileFactory,
        checkoutSession $checkoutSession,
        array $data = []
    ){
        parent::__construct($context);
        $this->session = $session;
        $this->checkoutSession = $checkoutSession;
        $this->csvProcessor = $csvProcessor;
        $this->directoryList = $directoryList;
        $this->fileFactory = $fileFactory;
    }

    public function execute()
    {
        if (!$this->session->isLoggedIn()) {
            $this->session->authenticate();
        } else {

            try {
                $fileName = 'cart_product.csv';
                $filePath = $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR)
                    . "/" . $fileName;
            } catch (FileSystemException $e) {
            }

            $cartlist = $this->checkoutSession->getQuote()->getAllVisibleItems();
            foreach ($cartlist as $item) {
                $data[] = [
                    $item->getName(), $item->getPrice()
                    ];
            }

            $this->csvProcessor
                ->setDelimiter(';')
                ->setEnclosure('"')
                ->saveData(
                    $filePath,
                    $data
                );
            return $this->fileFactory->create(
                $fileName,
                [
                    'type' => 'filename',
                    'value' => $fileName,
                    'rm' => true
                ],
                \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR,
                'application/octet-stream'

            );

        }
    }

}