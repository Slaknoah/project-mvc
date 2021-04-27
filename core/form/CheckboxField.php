<?php


namespace app\core\form;


class CheckboxField extends BaseField
{

    public function renderInput(): string
    {
        return sprintf('<input class="form-check-input" type="checkbox" value="1" name="%s" %s>',
            $this->attribute,
            $this->model->{$this->attribute} ? 'checked' : ''
        );
    }
}