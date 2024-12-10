<?php

namespace Icinga\Module\Sortmodifier\ProvidedHook\Director;

use Icinga\Module\Director\Hook\PropertyModifierHook;
use Icinga\Module\Director\Web\Form\QuickForm;
use stdClass;

class PropertyModifierSort extends PropertyModifierHook
{
    const DEFAULT_ORDER = 'asc';

    public function getName()
    {
        return mt('sorting','Sort items of an array');
    }

    /**
     * Add modifier related fields to the form
     *
     * @param QuickForm $form
     *
     * @return QuickForm|void
     * @throws \Zend_Form_Exception
     */
    public static function addSettingsFormFields(QuickForm $form)
    {
        $form->addElement('select', 'order', array(
            'label'       => 'Order',
            'description' => $form->translate(
                'Give which order the array should be sorted.'
            ),
	    'multiOptions' => [
                'asc' =>  $form->translate('ascending'),
                'desc'  => $form->translate('descending'),
            ],
            'required'    => true,
            'value'       => self::DEFAULT_ORDER,
        ));

    }

    /**
     * Method to transform the given value
     *
     * @return mixed $value
     */
    public function transform($value)
    {
        $order = $this->getSetting('order', self::DEFAULT_ORDER);

        if ($value === null) {
            return null;
        }

        if ($order === "desc") {
            natcasesort($value);
	    $value = array_reverse($value);
	}

        return $value;
    }

    public function hasArraySupport()
    {
        return true;
    }
}
