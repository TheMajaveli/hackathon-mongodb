<?php
$postId = $data['id'] ?? '';
$post = ViewHelper::apiRequest('/posts/' . $postId);
$comments = ViewHelper::apiRequest('/posts/' . $postId . '/comments');
?>

<div class="info">
    <?php if (!empty($post)): ?>
        <h2>Post Details</h2>
        <p><strong>ID:</strong> <?php echo ViewHelper::formatId($post['_id'] ?? ''); ?></p>
        <p><strong>Content:</strong> <?php echo htmlspecialchars($post['content'] ?? ''); ?></p>
        <p><strong>Category ID:</strong> <?php echo $post['category_id'] ?? '-'; ?></p>
        <p><strong>User ID:</strong> <?php echo $post['user_id'] ?? '-'; ?></p>
        <p><strong>Date:</strong> <?php echo $post['date'] ?? '-'; ?></p>
        
        <?php if (!empty($comments) && isset($comments['comments'])): ?>
            <h3>Comments (<?php echo count($comments['comments']); ?>)</h3>
            <table>
                <tr>
                    <th>Content</th>
                    <th>User ID</th>
                    <th>Date</th>
                </tr>
                <?php foreach ($comments['comments'] as $comment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($comment['content'] ?? ''); ?></td>
                        <td><?php echo $comment['user_id'] ?? '-'; ?></td>
                        <td><?php echo $comment['date'] ?? '-'; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php endif; ?>
        
        <p><a href="/view/posts">Back to Posts</a></p>
    <?php else: ?>
        <p>Post not found</p>
        <p><a href="/view/posts">Back to Posts</a></p>
    <?php endif; ?>
</div>
