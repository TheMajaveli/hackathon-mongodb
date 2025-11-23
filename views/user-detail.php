<?php
// Tâche Dev 1

$userId = $data['id'] ?? '';
$user = ViewHelper::apiRequest('/users/' . $userId);
?>

<div class="info">
    <?php if (!empty($user)): ?>
        <h2>User Details</h2>
        <p><strong>ID:</strong> <?php echo ViewHelper::formatId($user['_id'] ?? ''); ?></p>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username'] ?? ''); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email'] ?? ''); ?></p>
        <p><strong>Active:</strong> <?php echo ($user['is_active'] ?? false) ? 'Yes' : 'No'; ?></p>
        <p><a href="/view/users">Back to Users</a></p>
    <?php else: ?>
        <p>User not found</p>
        <p><a href="/view/users">Back to Users</a></p>
    <?php endif; ?>
</div>

