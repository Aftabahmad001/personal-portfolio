<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
require_admin();
$adminPageTitle = 'Messages';
$allowedStatuses = ['new', 'read', 'archived'];
$status = (string) ($_GET['status'] ?? '');
if (!in_array($status, $allowedStatuses, true)) { $status = ''; }
$page = max(1, (int) ($_GET['page'] ?? 1)); $perPage = 15;
try {
    $where = $status ? ' WHERE status = :status' : '';
    $count = database()->prepare('SELECT COUNT(*) FROM contact_messages' . $where); $count->execute($status ? ['status' => $status] : []); $total = (int) $count->fetchColumn();
    $pages = max(1, (int) ceil($total / $perPage)); $page = min($page, $pages); $offset = ($page - 1) * $perPage;
    $query = 'SELECT id, name, email, subject, status, created_at FROM contact_messages' . $where . ' ORDER BY created_at DESC LIMIT :limit OFFSET :offset';
    $statement = database()->prepare($query); if ($status) { $statement->bindValue(':status', $status); } $statement->bindValue(':limit', $perPage, PDO::PARAM_INT); $statement->bindValue(':offset', $offset, PDO::PARAM_INT); $statement->execute(); $messages = $statement->fetchAll();
} catch (PDOException $exception) { error_log('Admin list error: ' . $exception->getMessage()); $messages = []; $total = 0; $pages = 1; $databaseError = true; }
require __DIR__ . '/includes/header.php';
?>
<p class="admin-kicker">Message inbox</p><div class="d-flex justify-content-between align-items-end gap-3 mb-4"><div><h1 class="admin-title mb-1">All messages</h1><p class="text-secondary mb-0"><?= $total ?> message<?= $total === 1 ? '' : 's' ?> found.</p></div><a class="btn btn-outline-light" href="<?= e(admin_url('index.php')) ?>">Dashboard</a></div>
<div class="d-flex flex-wrap gap-2 mb-4"><?php foreach (['' => 'All', 'new' => 'New', 'read' => 'Read', 'archived' => 'Archived'] as $value => $label): ?><a class="btn btn-sm <?= $status === $value ? 'btn-primary' : 'btn-outline-secondary' ?>" href="<?= e(admin_url('messages.php' . ($value ? '?status=' . $value : ''))) ?>"><?= e($label) ?></a><?php endforeach; ?></div>
<?php if (!empty($databaseError)): ?><div class="alert alert-danger">Messages are temporarily unavailable. Please check the database connection.</div><?php endif; ?>
<div class="table-wrap table-responsive"><table class="table table-hover align-middle"><thead><tr><th>Sender</th><th>Subject</th><th>Status</th><th>Received</th><th></th></tr></thead><tbody><?php foreach ($messages as $message): ?><tr><td><strong><?= e($message['name']) ?></strong><br><a class="admin-link" href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a></td><td><?= e($message['subject']) ?></td><td><span class="status status-<?= e($message['status']) ?>"><?= e(ucfirst($message['status'])) ?></span></td><td><?= e(date('M j, Y g:i a', strtotime($message['created_at']))) ?></td><td><a class="admin-link" href="<?= e(admin_url('message-view.php?id=' . $message['id'])) ?>">View</a></td></tr><?php endforeach; ?><?php if (!$messages): ?><tr><td colspan="5" class="text-center text-secondary py-4">No messages match this filter.</td></tr><?php endif; ?></tbody></table></div>
<?php if ($pages > 1): ?><nav class="mt-4" aria-label="Message pages"><ul class="pagination pagination-sm"><?php for ($number = 1; $number <= $pages; $number++): ?><li class="page-item <?= $number === $page ? 'active' : '' ?>"><a class="page-link" href="<?= e(admin_url('messages.php?page=' . $number . ($status ? '&status=' . $status : ''))) ?>"><?= $number ?></a></li><?php endfor; ?></ul></nav><?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
