<?php
if(!isset($input)){
    throw new \Form\view\ElementMissingException();
}

/*
 * Use variable $input to access methods
 *
 * @var $input \Form\model\input\dev\Radio
 * @var $errormessage HTMLstring
 */
?>
<div class="form-group">
    <label><?php echo $input->GetLabel(); ?></label>
    <?php foreach($input->GetOptions() as $option): ?>
        <div class="radio-group">
            <input id="<?php echo $input->GetName() . '_' . $option->name; ?>" name="<?php echo $input->GetName(); ?>" type="radio" value="<?php echo $option->value; ?>" <?php echo $option->value == $input->GetValue() ? 'checked="checked"' : ''; ?> />
            <label for="<?php echo $input->GetName() . '_' . $option->name; ?>"><?php echo $option->name; ?></label>
        </div>
    <?php endforeach; ?>
    <?php echo $errormessages; ?>
</div>