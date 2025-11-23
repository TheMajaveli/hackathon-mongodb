<?php
// Tâche Dev 1

$usersCount = ViewHelper::apiRequest('/users/count');
$postsCount = ViewHelper::apiRequest('/posts/count');
$categories = ViewHelper::apiRequest('/categories');
$lastPosts = ViewHelper::apiRequest('/posts/last-five');
?>

<div class="info">
    <h2>Statistics</h2>
    <p><strong>Users:</strong> <?php echo $usersCount['count'] ?? 0; ?></p>
    <p><strong>Posts:</strong> <?php echo $postsCount['count'] ?? 0; ?></p>
    <p><strong>Categories:</strong> <?php echo count($categories); ?></p>
</div>

<div class="info">
    <h2>Last 5 Posts</h2>
    <?php if (!empty($lastPosts)): ?>
        <table>
            <tr>
                <th>Content</th>
                <th>Category ID</th>
                <th>User ID</th>
                <th>Date</th>
            </tr>
            <?php foreach ($lastPosts as $post): ?>
                <tr>
                    <td><?php echo htmlspecialchars(substr($post['content'] ?? '', 0, 50)); ?></td>
                    <td><?php echo $post['category_id'] ?? '-'; ?></td>
                    <td><?php echo $post['user_id'] ?? '-'; ?></td>
                    <td><?php echo $post['date'] ?? '-'; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No posts available</p>
    <?php endif; ?>
</div>

