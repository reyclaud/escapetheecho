<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_ete
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

/**
 * ETE Form Field class for the ETE component
 *
 * @since  0.0.1
 */
class JFormFieldETE extends JFormFieldList {

    /**
     * The field type.
     *
     * @var         string
     */
    protected $type = 'ete';

    /**
     * Method to get a list of options for a list input.
     *
     * @return  array  An array of JHtml options.
     */
    protected function getOptions() {        
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);
        $query->select('FormId,FormTitle');
        $query->from('#__rsform_forms');
        $query->where($db->quoteName('CSSId') . ' LIKE '. $db->quote('ete-questionnaires'));
        $db->setQuery((string) $query);
        
        $forms = $db->loadObjectList();
        $options = array();
        
        if ($forms) {
            foreach ($forms as $form) {
                $options[] = JHtml::_('select.option', $form->FormId, $form->FormTitle);
            }
        }

        $options = array_merge(parent::getOptions(), $options);

        return $options;
    }

}
