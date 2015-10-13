<?php
if(!isset($input)){
    throw new \Form\view\ElementMissingException();
}

/*
 * Use variable $input to access methods
 *
 * @var $input \Form\model\Element
 * @var $errormessage HTMLstring
 */
?>
<div class="form-group">
    <input type="checkbox" name="<?php echo $input->GetName(); ?>" id="<?php echo $input->GetName(); ?>" <?php echo $input->GetValue() ? 'checked="checked"' : ''; ?>/>
    <label for="<?php echo $input->GetName(); ?>"><?php echo $input->GetLabel(); ?></label>
    <?php echo $errormessages; ?>
</div>