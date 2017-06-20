<?php class Ryanmac_Catalog_Block_Product_Featured extends Mage_Catalog_Block_Product_Abstract
{
	public function getFeaturedProducts() {
		$resource = Mage::getSingleton('core/resource');
		$read = $resource->getConnection('catalog_read');
		$productEntityIntTable = (string)Mage::getConfig()->getTablePrefix() . 'catalog_product_entity_int';
		$eavAttributeTable = $resource->getTableName('eav/attribute');
		$categoryProductTable = $resource->getTableName('catalog/category_product');
		$select = $read->select()
			->distinct(true)
			->from(array('cp'=>$categoryProductTable), 'product_id')
			->join(array('pei'=>$productEntityIntTable), 'pei.entity_id=cp.product_id', array())
			->joinNatural(array('ea'=>$eavAttributeTable))
			->where('pei.value=1')
			->where('ea.attribute_code="popular"');
		$res = $read->fetchAll($select);
		return $res;
	}
	
	public function getLacrosseProducts() {
		$resource = Mage::getSingleton('core/resource');
		$read = $resource->getConnection('catalog_read');
		$productEntityIntTable = (string)Mage::getConfig()->getTablePrefix() . 'catalog_product_entity_int';
		$eavAttributeTable = $resource->getTableName('eav/attribute');
		$categoryProductTable = $resource->getTableName('catalog/category_product');
		$select = $read->select()
			->distinct(true)
			->from(array('cp'=>$categoryProductTable), 'product_id')
			->join(array('pei'=>$productEntityIntTable), 'pei.entity_id=cp.product_id', array())
			->joinNatural(array('ea'=>$eavAttributeTable))
			->where('pei.value=1')
			->where('ea.attribute_code="is_lacrosse"');
		$res = $read->fetchAll($select);
		return $res;
	}
}
?>