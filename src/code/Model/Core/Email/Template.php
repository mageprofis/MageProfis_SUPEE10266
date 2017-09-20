<?php

class MageProfis_SUPEE10266_Model_Core_Email_Template
extends Mage_Core_Model_Email_Template
{
    /**
     * Load CSS content from filesystem
     *
     * @param string $filename
     * @return string
     */
    protected function _getCssFileContent($filename)
    {
        $parent = parent::_getCssFileContent($filename);
        if (!empty($parent))
        {
            return $parent;
        }
        Mage::log('Can not Load origin: '.$filename, null, 'email_template.log');
        
        // just an secure workaround
        $storeId = $this->getDesignConfig()->getStore();
        $area = $this->getDesignConfig()->getArea();
        // This method should always be called within the context of the email's store, so these values will be correct
        $package = Mage::getDesign()->getPackageName();
        $theme = Mage::getDesign()->getTheme('skin');

        $origfilePath = $filePath;
        $filePath = realpath($filePath);
        $positionSkinDirectory = strpos($filePath, Mage::getBaseDir('skin'));
        $validator = new Zend_Validate_File_Extension('css');

        $filePath = Mage::getDesign()->getFilename(
            'css' . DS . $filename,
            array(
                '_type' => 'skin',
                '_default' => false,
                '_store' => $storeId,
                '_area' => $area,
                '_package' => $package,
                '_theme' => $theme,
            )
        );
        
        $obj = new Varien_Object();
        $obj->setOriginFilePath($origfilePath);
        $obj->setFilePath($filePath);
        $obj->setPositionSkinDirectory($positionSkinDirectory);
        $obj->setValidator($validator);
        $obj->setStoreId($storeId);

        Mage::dispatchEvent('mpsupee10266_validate_css', array(
            'object' => $obj,
            'model'  => $this
        ));

        if ($validator->isValid($obj->getFilePath()) && $obj->getPositionSkinDirectory() !== false && is_readable($filePath)) {
            return (string) file_get_contents($filePath);
        }
        // If file can't be found, return empty string
        return '';
    }
        
}
