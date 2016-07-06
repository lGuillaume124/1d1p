<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <?php if (!empty($params)) {
        echo h($message) . h($params[0]);
    } else {
        echo h($message);
    } ?>
</div>