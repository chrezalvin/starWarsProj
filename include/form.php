<!-- TODO -->
<?php require_once('../Model/FormInput.php') ?>
<form action="<?= $action_url ?>" method="post">
    <div class="modal-body">

    <?php foreach($formArray as $val): ?>
        <?php if($val instanceof FormInput): ?>
            <div class="form-group">
                <label for="<?= $val->getLabel() ?>"><?= $val->getName() ?></label>
                <input 
                    type="text" 
                    name="<?= $val->getLabel() ?>" 
                    id="<?= $val->getLabel() ?>" 
                    class="form-control" 
                    value="<?= $val->getValue() ?>" 
                    <?= $val->getIsrequired() ? 'required' : '' ?>
                    <?= $val->getIsDisabled() ? 'disabled' : '' ?>
                />
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</form>