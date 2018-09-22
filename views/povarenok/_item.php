<?php if (!empty($dishes)): ?>
    <?php foreach ($dishes as $item): ?>
        <h3>Блюдо: <?= $item['name'] ?></h3>
        <p>Кол-во совпадающих ингредиентов: <?= $item['count'] ?></p>
    <?php endforeach; ?>
<?php endif; ?>