<?php namespace TypiCMS\LaravelTranslatableBootForms\Form;

use Galahad\Forms\FormBuilder as _FormBuilder;

class FormBuilder extends _FormBuilder
{

    /**
     * Array of locale keys.
     *
     * @var array
     */
    protected $locales;

    /**
     * Sets the available locales for translatable fields.
     *
     * @param array $locales
     */
    public function setLocales(array $locales)
    {
        $this->locales = $locales;
    }

    /**
     * Getting value from Model or ModelTranslation to populate form.
     * Courtesy of TypiCMS/TranslatableBootForms (https://github.com/TypiCMS/TranslatableBootForms/blob/master/src/TranslatableFormBuilder.php)
     *
     * @param string $name key
     * @return string value
     */
    protected function getBoundValue($name, $default)
    {
        $inputName = preg_split('/[\[\]]+/', $name, - 1, PREG_SPLIT_NO_EMPTY);
        if (count($inputName) == 2 && in_array($inputName[0], $this->locales)) {
            list($lang, $name) = $inputName;
            $value = isset($this->boundData->data()->translate($lang)->{$name})
                ? $this->boundData->data()->translate($lang)->{$name}
                : '';

            return $value;
        }

        return $this->boundData->get($name, $default);
    }
}