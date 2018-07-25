<?php
declare(strict_types=1);

namespace In2code\Femanager\ViewHelpers\Misc;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * Class JsonEncodeViewHelper
 */
class JsonEncodeViewHelper extends AbstractViewHelper
{

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('array', 'array', 'Array to Encode', true);
    }

    /**
     * @var null
     */
    protected $escapeOutput = false;

    /**
     * @param array $array
     * @return string
     */
    public function render(): string
    {
        $array = $this->arguments['array'];
        return json_encode($array);
    }
}
