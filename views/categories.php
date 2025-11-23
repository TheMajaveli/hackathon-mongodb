<?php
// Tâche Dev 1

$categories = ViewHelper::apiRequest('/categories');
?>

<div class="info">
    <p><strong>Total Categories:</strong> <?php echo count($categories); ?></p>
</div>

<?php if (!empty($categories)): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?php echo ViewHelper::formatId($category['_id'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars($category['name'] ?? ''); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No categories found</p>
<?php endif; ?>
