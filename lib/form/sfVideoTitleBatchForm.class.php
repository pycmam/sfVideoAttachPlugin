<?php

/**
 * Форма редактирования заголовков роликов
 */
class sfVideoTitleBatchForm extends sfForm
{
    protected
        $object = null,
        $video = null;

    public function __construct(Doctrine_Record $object, $options = array(), $CSRFSecret = null)
    {
        $this->object = $object;

        $configs = sfConfig::get('app_sf_video_attach_types');

        $videoRelation = isset($configs[$options['conf']]['video_relation'])
          ? $configs[$options['conf']]['video_relation']
          : 'Video';

        $video = $object->{'get'.$videoRelation}();
        $this->video = $this->arrayGroup($video, 'id');
        $defaults = $this->arrayGroup($video, 'id', 'title');

        parent::__construct($defaults, $options, $CSRFSecret);
    }

    public function setup()
    {
        foreach (array_keys($this->video) as $id) {
            $this->widgetSchema[$id] = new sfWidgetFormInput();
            $this->validatorSchema[$id] = new sfValidatorString(array(
                'required' => false,
                'max_length' => 255,
            ));
        }

        $this->validatorSchema->setOption('allow_extra_fields', true);
        $this->widgetSchema->setNameFormat('sf_video_title[%s]');
    }

    public function save()
    {
        foreach ($this->values as $id => $title) {
            if (isset($this->video[$id])) {
                $this->video[$id]->setTitle($title);
                $this->video[$id]->save();
            }
        }
    }

    /**
     * @return Doctrine_Record
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return array
     */
    public function getVideo()
    {
        return $this->video;
    }

    protected function arrayGroup($list, $key, $value = null)
    {
      $result = array();
      foreach ($list as $item) {
        if ($value) {
          $result[$item[$key]] = $item[$value];
        } else {
          $result[$item[$key]] = $item;
        }
      }
      return $result;
    }
}