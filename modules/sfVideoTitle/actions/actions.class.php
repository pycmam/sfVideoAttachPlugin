<?php

/**
 * Редактирование заголовков ведеороликов
 */
class sfVideoTitleActions extends sfActions
{
    /**
     * Форма
     */
    public function executeIndex(sfWebRequest $request)
    {
        $object = $this->getRoute()->getObject();
        $options = $this->getRoute()->getOptions();
        $this->conf = $options['config'];
        $this->form = new sfVideoTitleBatchForm($object, array('conf' => $this->conf));
    }

    /**
     * Сохранение
     */
    public function executeSave(sfWebRequest $request)
    {
        $this->executeIndex($request);

        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid()) {
            $this->form->save();

            $this->getUser()->setFlash('notice', 'Заголовки видеороликов успешно сохранены.');
            return $this->redirect($this->conf.'_video_title', $this->form->getObject());
        }

        $this->getUser()->getFlash('error', 'Заголовки видеороликов не сохранены из-за ошибок.');
        $this->setTemplate('index');
    }
}