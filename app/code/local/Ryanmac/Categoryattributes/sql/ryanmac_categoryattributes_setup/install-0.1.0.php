<?php
/**
 * Created by PhpStorm.
 * User: racmurray
 * Date: 7/22/14
 * Time: 10:26 AM
 */
/* @var $installer Mage_Core_Model_Resource_Setup */
/**
 *  You will need to change the following
 *
 *  CUSTOM_ATTRIBUTE_IDENTIFIER     The unique identifier for your attribute
 *  CUSTOM_ATTRIBUTE_LABEL          The admin label for your attribute
 *  CUSTOM_ATTRIBUTE_TYPE           The input type (varchar, int, text, etc)
 *
 *  Remember that you will need to update the database table on line 46 to use the correct corresponding
 *  database table depending on the input type that you use.
 *
 */


$installer = $this;
$installer->startSetup();
$entityTypeId     = $installer->getEntityTypeId('catalog_category');
$attributeSetId   = $installer->getDefaultAttributeSetId($entityTypeId);
$attributeGroupId = $installer->getDefaultAttributeGroupId($entityTypeId, $attributeSetId);
$installer->addAttribute('catalog_category', 'category_h1',  array(
    'type'     => 'text',
    'label'    => 'Category H1',
    'input'    => 'text',
    'global'   => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
    'visible'           => true,
    'required'          => false,
    'user_defined'      => false,
    'default'           => NULL,
    'visible_on_front'  => true
));
$installer->addAttributeToGroup(
    $entityTypeId,
    $attributeSetId,
    $attributeGroupId,
    'CUSTOM_ATTRIBUTE_IDENTIFIER',
    '11'                    //last Magento's attribute position in General tab is 10
);
$attributeId = $installer->getAttributeId($entityTypeId, 'category_h1');
$installer->run("
INSERT INTO `{$installer->getTable('catalog_category_entity_text')}`
(`entity_type_id`, `attribute_id`, `entity_id`, `value`)
    SELECT '{$entityTypeId}', '{$attributeId}', `entity_id`, NULL
        FROM `{$installer->getTable('catalog_category_entity')}`;
");
//this will set data of your custom attribute for root category
Mage::getModel('catalog/category')
    ->load(1)
    ->setImportedCatId(0)
    ->setInitialSetupFlag(true)
    ->save();
//this will set data of your custom attribute for default category
Mage::getModel('catalog/category')
    ->load(2)
    ->setImportedCatId(0)
    ->setInitialSetupFlag(true)
    ->save();
$installer->endSetup();