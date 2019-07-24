<?php
/**
 * Created by PhpStorm.
 * User: syedzaidi
 * Date: 7/23/19
 * Time: 6:42 PM
 */

namespace Syedzaidi\CartProductCsv\Helper;


use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function getConfig($config_path)
    {
        return $this->scopeConfig->getValue(
            $config_path,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
}