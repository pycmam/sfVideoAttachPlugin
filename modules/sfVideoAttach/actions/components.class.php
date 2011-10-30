<?php
/**
 * sfVideoAttach
 */

class sfVideoAttachComponents extends sfComponents
{
  public function executeAttached()
  {
    $configs = sfConfig::get('app_sf_video_attach_types');
    if (! isset($configs[$this->type])) {
      throw new InvalidArgumentException(__METHOD__.sprintf(': config `%s` does not exist', $this->type));
    }

    $config = $configs[$this->type];
    $formClass = $config['video_model'].'Form';
    $this->form = new $formClass;

    $videoRelationName = $videoRelationName = isset($config['video_relation'])
      ? $config['video_relation']
      : 'Video';

    $this->videos = $this->object->get($videoRelationName);
  }
}