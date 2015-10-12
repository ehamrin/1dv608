<?php
if(!isset($input)){
    throw new \Form\view\ElementMissingException();
}

/*
 * Use variable $input to access methods
 *
 * @var $input \Form\model\input\dev\Select
 * @var $errormessage HTMLstring
 */
?>
<div class="form-group">
    <label for="<?php echo $input->GetName(); ?>"><?php echo $input->GetLabel(); ?></label>
    <select name="<?php echo $input->GetName(); ?>" id="<?php echo $input->GetName(); ?>">
<?php foreach($input->GetOptions() as $option): ?>
        <option value="<?php echo $option->value; ?>" <?php echo $option->name == $input->GetValue() ? 'selected' : ''; ?>><?php echo $option->name; ?></option>
<?php endforeach; ?>
    </select>
    <?php echo $errormessages; ?>
</div>