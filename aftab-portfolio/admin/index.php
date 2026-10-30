<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
require_admin();
$adminPageTitle = 'Dashboard';
try {
    $counts = ['total' => 0, 'new' => 0, 'read' => 0, 'archived' => 0];
    foreach (database()->query('SELECT status, COUNT(*) AS total FROM contact_messages GROUP BY status') as $row) { $counts[$row['status']] = (int) $row['total']; $counts['total'] += (int) $row['total']; }
    $recent = database()->query('SELECT id, name, email, subject, status, created_at FROM contact_messages ORDER BY created_at DESC LIMIT 6')->fetchAll();
} catch (PDOException $exception) { error_log('Admin dashboard error: ' . $exception->getMessage()); $recent = []; $databaseError = true; }
require __DIR__ . '/includes/header.php';
?>
<p class="admin-kicker">Private dashboard</p><div class="d-flex justify-content-between align-items-end gap-3 mb-4"><div><h1 class="admin-title mb-1">Contact messages</h1><p class="text-secondary mb-0">Review and organize enquiries without removing customer data.</p></div><a class="btn btn-primary" href="<?= e(admin_url('messages.php')) ?>">View all messages</a></div>
<?php if (!empty($databaseError)): ?><div class="alert alert-danger">Messages are temporarily unavailable. Please check the database connection.</div><?php endif; ?>
<div class="row g-3 mb-5"><?php foreach (['total' => 'Total', 'new' => 'New', 'read' => 'Read', 'archived' => 'Archived'] as $key => $label): ?><div class="col-6 col-lg-3"><div class="admin-card stat-card"><p><?= e($label) ?></p><strong><?= $counts[$key] ?? 0 ?></strong></div></div><?php endforeach; ?></div>
<div class="d-flex justify-content-between align-items-center mb-3"><h2 class="h4 mb-0">Recent messages</h2><a class="admin-link" href="<?= e(admin_url('messages.php')) ?>">All messages</a></div><div class="table-wrap table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Sender</th><th>Subject</th><th>Status</th><th>Date</th><th></th></tr></thead><tbody><?php foreach ($recent as $message): ?><tr><td><strong><?= e($message['name']) ?></strong><br><small><?= e($message['email']) ?></small></td><td><?= e($message['subject']) ?></td><td><span class="status status-<?= e($message['status']) ?>"><?= e(ucfirst($message['status'])) ?></span></td><td><?= e(date('M j, Y', strtotime($message['created_at']))) ?></td><td><a class="admin-link" href="<?= e(admin_url('message-view.php?id=' . $message['id'])) ?>">Open</a></td></tr><?php endforeach; ?><?php if (!$recent): ?><tr><td colspan="5" class="text-center text-secondary py-4">No messages yet.</td></tr><?php endif; ?></tbody></table></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
