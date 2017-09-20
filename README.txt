Fixed issues with skin based email css file


Sample Event:

<mpsupee10266_validate_css>
    <observers>
        <custom>
            <class>custom/observer</class>
            <method>fixEmailTemplateCssIssues</method>
        </custom>
    </observers>
</mpsupee10266_validate_css>

public function fixEmailTemplateCssIssues($event)
{
    $dir = Mage::getBaseDir().DS.'.modman/Customer/frontend/skin/customer/css';
    $positionSkinDirectory = strpos($event->getObject()->getFilePath(), $dir);
    $event->getObject()->setPositionSkinDirectory($positionSkinDirectory);
}
