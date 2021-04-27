<?php
/** @var $model Contact */
/** @var View $this  */

use app\core\form\Form;
use app\core\form\TextareaField;
use app\core\View;
use app\models\Contact;


$this->title = 'Add Task';
?>

<h1>Add Task</h1>

<?php  $form = Form::begin('', 'post'); ?>
<?php echo $form->field($model, 'name'); ?>
<?php echo $form->field($model, 'email'); ?>
<?php echo $form->field($model, 'title'); ?>
<?php echo new TextareaField($model, 'description'); ?>
    <button type="submit" class="btn btn-primary">Submit</button>
<?php Form::end() ?>