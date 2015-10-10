<?php
if(!isset($input)){
    throw new ElementMissingException();
}

/*
 * Use variable $input to access methods
 *
 * @var $input \Form\model\Element
 * @var $errormessage HTMLstring
 */
?>
<div class="form-group">
    <button type="submit" name="<?php echo $input->GetName(); ?>" id="<?php echo $input->GetName(); ?>" value="<?php echo $input->GetValue(); ?>"><?php echo $input->GetValue(); ?></button>
</div>