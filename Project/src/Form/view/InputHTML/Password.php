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
    <label for="<?php echo $input->GetName(); ?>"><?php echo $input->GetLabel(); ?></label>
    <input type="password" name="<?php echo $input->GetName(); ?>" id="<?php echo $input->GetName(); ?>"/>
    <?php echo $errormessages; ?>
</div>