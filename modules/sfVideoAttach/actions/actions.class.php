<?php
/**
 * sfVideoAttach
 */

class sfVideoAttachActions extends sfActions
{
  /**
   * PreExecute
   */
  public function preExecute()
  {
      sfConfig::set('sf_web_debug', false);
  }

  /**
   * Добавить ролик
   */
  public function executeCreate(sfWebRequest $request)
  {
    $object = $this->getRoute()->getObject();
    $options = $this->getRoute()->getOptions();

    $configs = sfConfig::get('app_sf_video_attach_types');
    $config = $configs[$options['config']];

    $videoRelationName = isset($config['video_relation'])
      ? $config['video_relation']
      : 'Video';


    $relation = $object->getTable()->getRelation($videoRelationName);
    $objectSetter = 'set' . get_class($object);

    $videoClass = $relation->getClass();
    $video = new $videoClass;
    $video->$objectSetter($object);

    $videoFormClass = $relation->getClass() . 'Form';
    $form = new $videoFormClass($video);

    $this->setVar('form', $form); // тестам
    $form->bind($request->getParameter($form->getName()));

    if ($form->isValid()) {
        $video = $form->save();

        return $this->renderPartial('preview', array(
            'video'   => $video,
            'type'    => $options['config'],
            'display' => 'none', // CSS, чтобы JS плавно показал
        ));
    } else {
      $this->getResponse()->setStatusCode(400);
    }

    return $this->renderPartial('form', array('form' => $form));
  }

  /**
   * Сортировка
   */
  public function executeSort(sfWebRequest $request)
  {
    $object = $this->getRoute()->getObject();
    $options = $this->getRoute()->getOptions();

    Doctrine::getTable($options['video_model'])
      ->setSortOrder($request->getParameter('order'), array(
        'object_id' => $object->getId(),
      ));

    return sfView::NONE;
  }

  /**
   * Удаление
   */
  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();
    $this->forward404Unless($request->isXmlHttpRequest());
    $this->getRoute()->getObject()->delete();

    return sfView::HEADER_ONLY;
  }
}