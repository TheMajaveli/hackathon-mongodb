<?php
// Tâche Dev 1

$categoryId = $data['id'] ?? '';
$category = ViewHelper::apiRequest('/categories/' . $categoryId);
?>

<div class="info">
    <?php if (!empty($category)): ?>
        <h2>Category Details</h2>
        <p><strong>ID:</strong> <?php echo ViewHelper::formatId($category['_id'] ?? ''); ?></p>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($category['name'] ?? ''); ?></p>
        <p><a href="/view/categories">Back to Categories</a></p>
    <?php else: ?>
        <p>Category not found</p>
        <p><a href="/view/categories">Back to Categories</a></p>
    <?php endif; ?>
</div>
