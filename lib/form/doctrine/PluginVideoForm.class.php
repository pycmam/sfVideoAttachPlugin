<?php

/**
 * PluginVideo form.
 */
abstract class PluginVideoForm extends BaseVideoForm
{
  public function setup()
  {
    $this->setWidgets(array(
      'url'   => new sfWidgetFormInput(),
      'title' => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'url' => new sfValidatorRegex(array('pattern' => '/youtube.com\/.*v=[a-z0-9_]+/i')),
      'title' => new sfValidatorString(array('required' => false, 'max_length' => 255)),
    ));

    $this->widgetSchema->setNameFormat('video[%s]');
    $this->disableLocalCSRFProtection();
  }
}
