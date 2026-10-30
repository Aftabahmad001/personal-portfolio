<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/bootstrap.php';
require_admin();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
if (!$id) { header('Location: ' . admin_url('messages.php'), true, 303); exit; }
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf(); $newStatus = (string) ($_POST['status'] ?? '');
    if (in_array($newStatus, ['new', 'read', 'archived'], true)) { try { database()->prepare('UPDATE contact_messages SET status = :status WHERE id = :id')->execute(['status' => $newStatus, 'id' => $id]); admin_flash('success', 'Message status updated.'); } catch (PDOException $exception) { error_log('Admin status error: ' . $exception->getMessage()); admin_flash('error', 'The status could not be updated.'); } }
    header('Location: ' . admin_url('message-view.php?id=' . $id), true, 303); exit;
}
try { $statement = database()->prepare('SELECT id, name, email, subject, budget, message, status, created_at FROM contact_messages WHERE id = :id LIMIT 1'); $statement->execute(['id' => $id]); $message = $statement->fetch(); } catch (PDOException $exception) { error_log('Admin view error: ' . $exception->getMessage()); $message = false; }
if (!$message) { http_response_code(404); $adminPageTitle = 'Message not found'; require __DIR__ . '/includes/header.php'; echo '<div class="alert alert-warning">This message was not found.</div>'; require __DIR__ . '/includes/footer.php'; exit; }
$adminPageTitle = 'Message from ' . $message['name']; require __DIR__ . '/includes/header.php';
?>
<a class="admin-link d-inline-block mb-3" href="<?= e(admin_url('messages.php')) ?>"><i class="fa-solid fa-arrow-left"></i> Back to messages</a><div class="d-flex justify-content-between align-items-start gap-3 mb-4"><div><p class="admin-kicker">Message details</p><h1 class="admin-title mb-1"><?= e($message['subject']) ?></h1><p class="text-secondary mb-0">Received <?= e(date('F j, Y g:i a', strtotime($message['created_at']))) ?></p></div><span class="status status-<?= e($message['status']) ?>"><?= e(ucfirst($message['status'])) ?></span></div>
<?php if ($flash = admin_flash('success')): ?><div class="alert alert-success"><?= e($flash) ?></div><?php endif; ?><?php if ($flash = admin_flash('error')): ?><div class="alert alert-danger"><?= e($flash) ?></div><?php endif; ?>
<div class="row g-4"><div class="col-lg-8"><article class="admin-card p-4"><h2 class="h5">Message</h2><p class="admin-message mb-0"><?= e($message['message']) ?></p></article></div><aside class="col-lg-4"><div class="admin-card p-4"><h2 class="h5">Sender</h2><p class="mb-1"><strong><?= e($message['name']) ?></strong></p><p><a class="admin-link" href="mailto:<?= e($message['email']) ?>"><?= e($message['email']) ?></a></p><p class="text-secondary small mb-4">Budget: <?= e($message['budget'] ?: 'Not provided') ?></p><form method="post"><input type="hidden" name="csrf_token" value="<?= e(admin_csrf_token()) ?>"><label class="form-label" for="status">Message status</label><select class="form-select mb-3" id="status" name="status"><?php foreach (['new','read','archived'] as $status): ?><option value="<?= e($status) ?>" <?= $message['status'] === $status ? 'selected' : '' ?>><?= e(ucfirst($status)) ?></option><?php endforeach; ?></select><button class="btn btn-primary w-100" type="submit">Update status</button></form></div></aside></div>
<?php require __DIR__ . '/includes/footer.php'; ?>
