<?php
/**
 * Превьюшка ролика
 *
 * @param Video $video
 * @param string $type
 */
use_helper('jQuery');

$display = isset($display) ? (string) $display : 'block';
?>

<li id="attached_video_<?php echo $video->getId(); ?>" style="display: <?php echo $display; ?>">
  <div class="uploaded_preview">
    <?php echo image_tag($video->getPreviewImageUrl(), array('title' => $video->getTitle())); ?>
  </div>

  <?php echo jq_link_to_remote('Удалить', array(
    'url'       => url_for($type . '_video_delete', $video),
    'csrf'      => 1,
    'sf_method' => 'delete',
    'success'   => jq_visual_effect('fadeOut', '#attached_video_'.$video->getId(), array('speed' => 'slow')),
  ), array('class' => 'delete')); ?>
</li>