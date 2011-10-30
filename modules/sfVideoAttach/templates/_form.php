<?php
/**
 * Форма добавления ролика
 *
 * @param VideoForm $form
 * @param Doctrine_Record $object
 */
?>

<?php echo $form->renderHiddenFields(); ?>
<?php echo $form->renderGlobalErrors(); ?>

<ul class="form">
  <li class="form-row">
    <?php echo $form['url']->renderLabel(); ?>
    <?php echo $form['url']->renderError(); ?>
    <?php echo $form['url']; ?>
  </li>
  <li class="form-row">
    <?php echo $form['title']->renderLabel(); ?>
    <?php echo $form['title']->renderError(); ?>
    <?php echo $form['title']; ?>
  </li>
  <li class="form-row">
    <input type="submit" value="Добавить" />
  </li>
</ul>