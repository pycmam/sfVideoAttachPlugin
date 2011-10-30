<?php

/**
 * PluginVideo
 */
abstract class PluginVideo extends BaseVideo
{
  /**
   * @return string
   */
  public function getPreviewImageUrl($name = 'default')
  {
    if ($key = $this->getVideoKey()) {
      return sprintf('http://img.youtube.com/vi/%s/%s.jpg', $key, $name);
    }
  }

  /**
   * @return string
   */
  public function getVideoKey()
  {
    if (preg_match('%youtube.com/.*v=([a-z0-9_]+)%i', $this->getUrl(), $match)) {
      return $match[1];
    }
  }
}