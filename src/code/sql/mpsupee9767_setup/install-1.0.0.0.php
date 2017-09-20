<?php

$installer = $this;

$installer->startSetup();

// enable Symlinks
$installer->setConfigData('dev/template/allow_symlink', 1);
// Disable, to prevent issues on checkout! with the default patch :)
$installer->setConfigData('admin/security/validate_formkey_checkout', 0);

$installer->endSetup();
