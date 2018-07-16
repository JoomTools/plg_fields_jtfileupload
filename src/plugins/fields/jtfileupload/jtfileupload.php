<?php
/**
 * @package      Joomla.Plugin
 * @subpackage   Fields.JtFileUpload
 *
 * @author       Sven Schultschik
 * @copyright    (c) 2018 JoomTools.de - All rights reserved
 * @license      GNU General Public License version 3 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Application\CMSApplication;

JLoader::import('components.com_fields.libraries.fieldsplugin', JPATH_ADMINISTRATOR);
JFormHelper::addRulePath(JPATH_PLUGINS . '/fields/foo/rules');
//JForm::getInstance()->validate($submitedValues);

/**
 * JtFileUpload plugin.
 *
 * @package      Joomla.Plugin
 * @subpackage   Fields.Jtfieldupload
 *
 * @since        __DEPLOY_VERSION__
 */
class plgFieldsJtfileupload extends FieldsPlugin
{
	/**
	 * Fieldname
	 *
	 * @var     Array
	 * @since   __DEPLOY_VERSION__
	 */
	protected $fieldname = [];

	/**
	 * Application object
	 *
	 * @var     CMSApplication
	 * @since   __DEPLOY_VERSION__
	 */
	protected $app;

	/**
	 * Database object
	 *
	 * @var     JDatabaseDriver
	 * @since   __DEPLOY_VERSION__
	 */
	protected $db;

	/**
	 * Affects constructor behavior. If true, language files will be loaded automatically.
	 *
	 * @var     boolean
	 * @since   __DEPLOY_VERSION__
	 */
	protected $autoloadLanguage = true;

	/**
	 * Transforms the field into a DOM XML element and appends it as a child on the given parent.
	 *
	 * @param   stdClass    $field   The field.
	 * @param   DOMElement  $parent  The field node parent.
	 * @param   JForm       $form    The form.
	 *
	 * @return   DOMElement
	 *
	 * @since   __DEPLOY_VERSION__
	 */
	public function onCustomFieldsPrepareDom($field, DOMElement $parent, JForm $form)
	{
		// Execute only if we had a jtfileupload
		if ($field->type == 'jtfileupload')
		{
			return parent::onCustomFieldsPrepareDom($field, $parent, $form);
		}

		// Set Fieldname
		if ($field->type == 'jtfileupload')
		{
			$this->fieldname[] = $field->name;
		}

		// Add enctype to formtag
		$script = "jQuery(document).ready(function($){ 
	                    $('form#adminForm').attr('enctype','multipart/form-data');
	               });";

		JFactory::getDocument()->addScriptDeclaration($script);

		$fieldNode = parent::onCustomFieldsPrepareDom($field, $parent, $form);

		if (!$fieldNode)
		{
			return $fieldNode;
		}

		$fieldNode->setAttribute('accept', '.pdf,.PDF');

		return $fieldNode;
	}

	/**
	 * The save event.
	 *
	 * @param   string   $context  The context
	 * @param   JTable   $item     The table
	 * @param   boolean  $isNew    Is new item
	 * @param   array    $data     The validated data
	 *
	 * @return   boolean
	 *
	 * @since   3.7.0
	 */
	public function onContentBeforeSave($context, $item, $isNew, $data = array())
	{
		// Array with fieldnames uses jtfileupload
		$fieldname = $this->fieldname;

		if (empty($fieldname))
		{
			return true;
		}

		foreach ($fieldname as $name)
		{
			echo '<p>';
			echo $item['com_fields'][$name];
			echo '</p>';
		}
		
		$input     = $this->app->input;
		$files     = $input->files;

		print_r($this->params->get('type'));
		echo '<p>name</p>';
		//$files->get
		if (!empty($_FILES))
		{
			//print_r($_FILES);


			echo '<p>';
			//    $jinput          = new \Jtf\Input\Files;
			//    $submitedFiles     = $jinput->get($formTheme);
			//   $submitedValues = array_merge_recursive($submitedValues, $submitedFiles);
		}
		else
		{
			echo '<p>empty</p>';
		};
		// $this->getForm()->bind($submitedValues);
		//$this->setFieldValidates();
		//$valid = $this->getForm()->validate($submitedValues);


		print_r($context);

		echo "<p>";

		print_r($item);
		echo "<p>";

		print_r($isNew);
		echo "<p>";
		print_r($data);
//die();
	}
}