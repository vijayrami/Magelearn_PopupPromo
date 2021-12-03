<?php

namespace Magelearn\PopupPromo\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Page implements OptionSourceInterface
{
	/**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    protected $pageRepository;
    /**
    * @var \Magento\Framework\Api\SearchCriteriaBuilder
    */
    protected $searchCriteriaBuilder;
	
	public function __construct(
    	\Magento\Cms\Api\PageRepositoryInterface $pageRepository,
    	\Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder
	) {
	    $this->_cmsPage = $pageRepository;
	    $this->_search = $searchCriteriaBuilder;
	}

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray() {
	    $pages = [];
	    foreach($this->_cmsPage->getList($this->_getSearchCriteria())->getItems() as $page) {
	        $pages[] = [
	            'value' => $page->getIdentifier(),
	            'label' => $page->getTitle()
	        ];
	    }
		array_push($pages, [
            'label' => __('Category Page'),
            'value' => 1
        ]);
	    return $pages;
	}

	protected function _getSearchCriteria() {
	    return $this->_search->addFilter('is_active', '1')->create();
	}
}