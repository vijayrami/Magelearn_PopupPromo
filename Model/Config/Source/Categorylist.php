<?php
namespace Magelearn\PopupPromo\Model\Config\Source;
 
use Magento\Framework\Option\ArrayInterface;
 
class Categorylist implements ArrayInterface
{
    protected $_categoryHelper;
 
    public function __construct(\Magento\Catalog\Helper\Category $catalogCategory)
    {
        $this->_categoryHelper = $catalogCategory;
    }
 	
	/**
     * Retrieve current store level 2 category
     *
     * @param bool|string $sorted (if true display collection sorted as name otherwise sorted as based on id asc)
     * @param bool $asCollection (if true display all category otherwise display second level category menu visible category for current store)
     * @param bool $toLoad
     */
    public function getStoreCategories($sorted = false, $asCollection = false, $toLoad = true)
    {
        return $this->_categoryHelper->getStoreCategories($sorted , $asCollection, $toLoad);
    }
 
    public function toOptionArray()
    {
 
        $arr = $this->toArray();
        $ret = [];
 
        foreach ($arr as $key => $value)
        {
 
            $ret[] = [
                'value' => $key,
                'label' => $value
            ];
        }
 
        return $ret;
    }
 
    public function toArray()
    {
 
        $categories = $this->getStoreCategories(true,true,true);
 
        $catagoryList = array();
        foreach ($categories as $category){
            $catagoryList[$category->getEntityId()] = __($category->getName());
        }
 
        return $catagoryList;
    }
 
}