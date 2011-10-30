<?php

/**
 * sfVideoAttachRouting
 */
class sfVideoAttachRouting
{
    /**
     * Listens to the routing.load_configuration event.
     *
     * @param sfEvent An sfEvent instance
     * @static
     */
    static public function listenToRoutingLoadConfigurationEvent(sfEvent $event)
    {
        $routing = $event->getSubject();
        $types = sfConfig::get('app_sf_video_attach_types', array());

        foreach ($types as $name => $config) {

            // add
            $routing->prependRoute($name .'_video_add', new sfDoctrineRoute(sprintf('/%s/:id/add', $name),
                array('module' => 'sfVideoAttach', 'action' => 'create'),
                array('id' => '\d+', 'sf_method' => 'post'),
                array('model' => $config['object_model'], 'type' => 'object', 'config' => $name,
                      'video_model' => $config['video_model'])
            ));

            // delete
            $routing->prependRoute($name .'_video_delete', new sfDoctrineRoute(sprintf('/%s/:id/delete', $name),
                array('module' => 'sfVideoAttach', 'action' => 'delete'),
                array('id' => '\d+', 'sf_method' => 'delete'),
                array('model' => $config['video_model'], 'type' => 'object')
            ));

            // sort
            $routing->prependRoute($name .'_video_sort', new sfDoctrineRoute(sprintf('/%s/:id/sort', $name),
                array('module' => 'sfVideoAttach', 'action' => 'sort'),
                array('id' => '\d+', 'sf_method' => 'post'),
                array('model' => $config['object_model'], 'type' => 'object', 'video_model' => $config['video_model'])
            ));
        }
    }
}
