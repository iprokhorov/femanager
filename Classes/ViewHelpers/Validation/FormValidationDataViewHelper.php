<?php
declare(strict_types=1);
namespace In2code\Femanager\ViewHelpers\Validation;

/**
 * Class FormValidationDataViewHelper
 */
class FormValidationDataViewHelper extends AbstractValidationViewHelper
{

    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('settings', 'array', 'TypoScript');
        $this->registerArgument('fieldName', 'string', 'Fieldname');
        $this->registerArgument('additionalAttributes', 'array', 'AdditionalAttributes');
    }

    /**
     * Validation names with simple configuration
     *
     * @var array
     */
    protected $simpleValidations = [
		'date',
		'email',
		'intOnly',
		'lettersOnly',
		'required',
		'uniqueInDb',
		'uniqueInPage'
    ];

    /**
     * Set javascript validation data for input fields
     *
     * @param array $settings TypoScript
     * @param string $fieldName Fieldname
     * @param array $additionalAttributes AdditionalAttributes
     * @return array
     */
    public function render()
    {

        $settings = $this->arguments['settings'];
        $fieldName = $this->arguments['fieldName'];
        $additionalAttributes = $this->arguments['additionalAttributes'];

        if ($settings[$this->getControllerName()]['validation']['_enable']['client'] === '1') {
            $validationString = $this->getValidationString($settings, $fieldName);
            if (!empty($validationString)) {
                if (!empty($additionalAttributes['data-validation'])) {
                    $additionalAttributes['data-validation'] .= ',' . $validationString;
                } else {
                    $additionalAttributes['data-validation'] = $validationString;
                }
            }
        }
        return $additionalAttributes;
    }

    /**
     * Get validation string like
     *        required, email, min(10), max(10), intOnly,
     *        lettersOnly, uniqueInPage, uniqueInDb, date,
     *        mustInclude(number|letter|special), inList(1|2|3)
     *
     * @param array $settings Validation TypoScript
     * @param string $fieldName Fieldname
     * @return string
     */
    protected function getValidationString($settings, $fieldName)
    {
        $string = '';
        $validationSettings = (array)$settings[$this->getControllerName()][$this->getValidationName()][$fieldName];
        foreach ($validationSettings as $validation => $configuration) {
            if (!empty($string)) {
                $string .= ',';
            }
            $string .= $this->getSingleValidationString($validation, $configuration);
        }
        return $string;
    }

    /**
     * @param string $validation
     * @param string $configuration
     * @return string
     */
    protected function getSingleValidationString($validation, $configuration)
    {
        $string = '';
        if ($this->isSimpleValidation($validation) && $configuration === '1') {
            $string = $validation;
        }
        if (!$this->isSimpleValidation($validation)) {
            $string = $validation;
            $string .= '(' . str_replace(',', '|', $configuration) . ')';
        }
        return $string;
    }

    /**
     * Check if validation is simple or extended
     *
     * @param string $validation
     * @return bool
     */
    protected function isSimpleValidation($validation)
    {
        if (in_array($validation, $this->simpleValidations)) {
            return true;
        }
        return false;
    }
}
