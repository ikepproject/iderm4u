<?php $pager->setSurroundCount(4) ?>

<ul class="pagination pagination-rounded justify-content-center mt-3 mb-4 pb-1">
    <?php if ($pager->hasPrevious()) : ?>
        <li class="page-item">
            <a href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>" class="page-link">
                <i class="mdi mdi-chevron-left"></i>
            </a>
        </li>
    <?php endif ?>

    <?php foreach ($pager->links() as $link): ?>
        <li <?= $link['active'] ? 'class="page-item active"' : '' ?> >
            <a href="<?= $link['uri'] ?>" class="page-link"><?= $link['title'] ?></a>
        </li>
    <?php endforeach ?>

    <?php if ($pager->hasNext()) : ?>
        <li class="page-item">
            <a href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
        </li>
    <?php endif ?>
    
</ul>