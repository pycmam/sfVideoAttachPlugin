<?php
/**
 * Интерфейс загрузки и управления загруженными роликами
 *
 * @param Doctrine_Collection of Video $videos
 * @param VideoForm $form
 * @param Doctrine_Record $object
 * @param string $type
 */
use_helper('jQuery');
use_stylesheet('/sfVideoAttachPlugin/css/style.css');
?>

<script type="text/javascript">
$(function(){
  var form = document.getElementById('sf_video_attach_form_<?php echo $type; ?>');
  var list = '#sf_video_attach_list_<?php echo $type; ?>';

  $(form).submit(function(){
    $.ajax({
      type: 'POST',
      url: $(this).attr('action'),
      data: $(this).serialize(),
      dataType: 'html',
      complete: function(xhr, status){
        if (status == 'success') {
          $(list).append(xhr.responseText);
          $('li:last-child', $(list)).fadeIn('slow');
          $('.error_list', $(form)).remove();
          form.reset();
        } else {
          $(form).html(xhr.responseText);
        }
      }
    });
    return false;
  });

  $(list).sortable({
      update: function(e, ui) {
          var serial = $(e.target).sortable('serialize', { key: 'order[]' });
          var options = {
              url: '<?php echo url_for($type.'_video_sort', $object); ?>',
              type: 'POST',
              data: serial
          };
          $.ajax(options);
      }
  });

});
</script>

<div class="sf_video_attach_container">
  <div class="title">Добавление видеоролика</div>

  <form action="<?php echo url_for($type . '_video_add', $object); ?>"
        id="sf_video_attach_form_<?php echo $type; ?>"
        method="post">

    <?php include_partial('sfVideoAttach/form', array('form' => $form)); ?>
  </form>

  <div class="title">Добавленые видеоролики</div>

  <ul id="sf_video_attach_list_<?php echo $type; ?>" class="sf_video_attach_list">
    <?php foreach($videos as $video): ?>
      <?php include_partial('sfVideoAttach/preview', array(
        'video' => $video,
        'type' => $type,
      )); ?>
    <?php endforeach; ?>
  </ul>

  <?php if ($sf_params->get('module') != 'sfVideoTitle' && in_array('sfVideoTitle', sfConfig::get('sf_enabled_modules'))): ?>
    <?php echo link_to('Редактировать названия роликов', $type.'_video_title', $object); ?>
  <?php endif; ?>
</div>