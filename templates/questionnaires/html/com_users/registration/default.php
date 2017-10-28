<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');
jimport('joomla.form.form');

jimport('joomla.application.component.model');

JModelLegacy::addIncludePath(JPATH_SITE . '/components/com_ete/models');
$eteBackendModel = JModelLegacy::getInstance('Backend', 'EteModel');
?>
<div class="registration<?php echo $this->pageclass_sfx ?>">
    <?php if ($this->params->get('show_page_heading')) : ?>
        <div class="page-header">
            <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
        </div>
    <?php endif; ?>

    <form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">

        <?php
        $ip = JFactory::getApplication()->input->server->get('REMOTE_ADDR', '');
        $this->form->setValue('ipAddress', null, $ip);

        $details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
        ?>

        <?php // Iterate through the form fieldsets and display each one.  ?>
        <fieldset>
            <legend>User Registration</legend>
            <?php foreach ($this->form->getFieldsets() as $key => $fieldset): ?>
                <?php $fields = $this->form->getFieldset($fieldset->name); ?>
                <?php if (count($fields)): ?>
                    <?php // If the fieldset has a label set, display it as the legend. ?>
                    <?php if (isset($fieldset->label)): ?>
                    <?php endif; ?>
                    <?php // Iterate through the fields in the set and display them. ?>
                    <?php foreach ($fields as $field) : ?>
                        <?php // If the field is hidden, just display the input. ?>     

                        <?php if ($field->hidden): ?>
                            <?php echo $field->input; ?>
                        <?php else: ?>
                            <div class="control-group">
                                <div class="control-label">
                                    <?php $field->required = 1; ?>
                                    <?php echo $field->label; ?>
                                    <?php if (!$field->required && $field->type != 'Spacer') : ?>
                                        <span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL'); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="controls">                                    
                                    <?php if (strpos(strtolower($field->label), 'country') !== FALSE): ?>
                                        <select name="jform[profile][country]" class="required registration-country-select" required="required">                                            
                                            <?php foreach ($eteBackendModel->getCountries() as $index => $country): ?>
                                                <option value="<?php echo $index; ?>" <?php if ($details->country == $index): ?>selected="selected"<?php endif; ?>><?php echo $country; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php else: ?>
                                        <?php echo $field->input; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </fieldset>
        <div class="control-group">
            <div class="controls">
                <button type="submit" class="btn btn-primary validate"><?php echo JText::_('JREGISTER'); ?></button>
                <a class="btn" href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>"><?php echo JText::_('JCANCEL'); ?></a>
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="registration.register" />
            </div>
        </div>
        <?php echo JHtml::_('form.token'); ?>
    </form>
</div>

<script type="text/javascript">
jQuery(document).ready(function(){    
    jQuery("#jform_profile_country-lbl").parents(".control-group").after(jQuery("#jform_captcha-lbl").parents(".control-group"));
});
</script>