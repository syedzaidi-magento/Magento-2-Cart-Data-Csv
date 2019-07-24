<?php
/**
 * Created by PhpStorm.
 * User: syedzaidi
 * Date: 7/23/19
 * Time: 12:35 PM
 */

namespace Syedzaidi\CartProductCsv\Block;


use Magento\Framework\View\Element\Template;
use Syedzaidi\CartProductCsv\Helper\Data as helperdata;

class CartProducts extends Template
{
    /**
     * @var helperdata
     */
    private $helperdata;

    /**
     * CartProducts constructor.
     * @param Template\Context $context
     * @param helperdata $helperdata
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        helperdata $helperdata,
        array $data = []
    ){
        parent::__construct($context, $data);
        $this->helperdata = $helperdata;
    }

    public function createCsv()
    {
        $config = $this->helperdata->getConfig('sales/cartproductcsv/allowcsv');

        if ($config) {
            echo '<a href="/export/index"><button class="action primary checkout">Download List Of Products</button></a>';

        } else {
            return false;
        }

    }
}