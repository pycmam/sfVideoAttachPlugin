<?php

class sfVideoAttachPluginConfiguration extends sfPluginConfiguration
{
  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    $enabledModules = sfConfig::get('sf_enabled_modules', array());
    if (sfConfig::get('app_sf_video_attach_routes_register', true) && in_array('sfVideoAttach', $enabledModules)) {
      $this->dispatcher->connect('routing.load_configuration', array('sfVideoAttachRouting', 'listenToRoutingLoadConfigurationEvent'));
    }
  }
}