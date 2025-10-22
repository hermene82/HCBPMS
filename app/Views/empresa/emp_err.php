<?php if (isset($validation) && $validation->getErrors()): ?>
    <div class="alert alert-danger">
        <?php foreach ($validation->getErrors() as $error): ?>
            <p><?= $error ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>