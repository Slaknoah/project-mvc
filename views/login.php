<?php
/** @var  $model User */
/** @var View $this  */

use app\core\View;
use app\models\User;
use app\core\form\Form;

$this->title = 'Login';
?>
<div class="row">
    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 mx-auto form p-4">
        <h1 class="display-4 py-2">Login</h1>
        <?php  $form = Form::begin('', 'post'); ?>
            <?php echo $form->field($model, 'email'); ?>
            <?php echo $form->field($model, 'password')->passwordField(); ?>
            <button type="submit" class="btn btn-primary float-end">Login</button>
        <?php Form::end() ?>
    </div>
</div>
