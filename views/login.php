<?php
    use app\models\User;
    use app\core\form\Form;
    /** @var  $model User */
?>
    <h1>Login</h1>
<?php  $form = Form::begin('', 'post'); ?>
    <?php echo $form->field($model, 'email'); ?>
    <?php echo $form->field($model, 'password')->passwordField(); ?>
    <button type="submit" class="btn btn-primary">Login</button>
<?php Form::end() ?>