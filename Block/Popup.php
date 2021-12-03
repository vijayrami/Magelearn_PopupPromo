<?php

namespace Magelearn\PopupPromo\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Template;
use Magento\Framework\UrlInterface;
use Magelearn\PopupPromo\Helper\Data as DataHelper;

class Popup extends Template
{
    protected $dataHelper;
	protected $_storeManager;
    protected $categoryRepository;
	
    public function __construct(
        DataHelper $dataHelper,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\CategoryRepository $categoryRepository,
        Template\Context $context,
        array $data = []
    ) {
        $this->dataHelper = $dataHelper;
		$this->_storeManager = $storeManager;
		$this->categoryRepository = $categoryRepository;
        parent::__construct($context, $data);
    }

    /**
     * Is module enabled/disabled
     *
     * @return bool
     */
    public function isModuleEnabled()
    {
        return (boolean) $this->dataHelper->getConfig('magelearn_popuppromo/functional/enable');
    }

    /**
     * Get display settings
     *
     * @return string
     */
    public function getDisplaySettings()
    {
        return $this->dataHelper->getConfig('magelearn_popuppromo/functional/display_settings');
    }

    /**
     * Get display settings
     *
     * @return integer
     */
    public function getDisplayDelay()
    {
        return (int)$this->dataHelper->getConfig('magelearn_popuppromo/functional/display_delay');
    }

    /**
     * Get block ID
     *
     * @return string|null
     */
    public function getBlockId()
    {
        return $this->dataHelper->getConfig('magelearn_popuppromo/content/block_id');
    }

    /**
     * Get coupon code
     *
     * @return string|null
     */
    public function getCouponCode()
    {
        return $this->dataHelper->getConfig('magelearn_popuppromo/content/coupon_code');
    }

    /**
     * Get regulations text
     *
     * @return string|null
     */
    public function getRequlationsText()
    {
        return $this->dataHelper->getConfig('magelearn_popuppromo/regulations/text');
    }

    /**
     * Get page URL
     *
     * @return string|null
     * @throws NoSuchEntityException
     */
    public function getPageUrl()
    {
    	if($this->dataHelper->getConfig('magelearn_popuppromo/regulations/page') == 1) {
    		$categoryId = $this->dataHelper->getConfig('magelearn_popuppromo/regulations/category_page');
			$category = $this->categoryRepository->get($categoryId, $this->_storeManager->getStore()->getId());
        	return $category->getUrl();
    	}
        return $this->_storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_WEB) . $this->dataHelper->getConfig('magelearn_popuppromo/regulations/page');
    }

    /**
     * Get custom CSS
     *
     * @return string|null
     */
    public function getCustomCss()
    {
        return $this->dataHelper->getConfig('magelearn_popuppromo/design/custom_css');
    }
}
