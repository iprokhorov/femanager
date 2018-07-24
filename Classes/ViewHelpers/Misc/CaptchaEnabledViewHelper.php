<?php
declare(strict_types=1);
namespace In2code\Femanager\ViewHelpers\Misc;

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Look if captcha is enabled
 */
class CaptchaEnabledViewHelper extends AbstractViewHelper
{

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('settings', 'array', 'TypoScript');
    }
    /**
     * Check if captcha is enabled
     *
     * @return bool
     */
    public function render(): bool
    {
        $settings = $this->arguments['settings'];
        $controllerName = strtolower($this->renderingContext->getControllerContext()->getRequest()->getControllerName());
        return ExtensionManagementUtility::isLoaded('sr_freecap')
            && !empty($settings[$controllerName]['validation']['captcha']['captcha']);
    }
}
