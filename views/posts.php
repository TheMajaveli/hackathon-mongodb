<?php
$posts = ViewHelper::apiRequest('/posts');
?>

<div class="info">
    <p><strong>Total Posts:</strong> <?php echo count($posts); ?></p>
</div>

<?php if (!empty($posts)): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Content</th>
            <th>Category ID</th>
            <th>User ID</th>
            <th>Date</th>
        </tr>
        <?php foreach ($posts as $post): ?>
            <tr>
                <td><?php echo ViewHelper::formatId($post['_id'] ?? ''); ?></td>
                <td><?php echo htmlspecialchars(substr($post['content'] ?? '', 0, 50)); ?>...</td>
                <td><?php echo $post['category_id'] ?? '-'; ?></td>
                <td><?php echo $post['user_id'] ?? '-'; ?></td>
                <td><?php echo $post['date'] ?? '-'; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No posts found</p>
<?php endif; ?>
