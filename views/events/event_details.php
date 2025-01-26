<?php include __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Event Details</h2>
    <?php if ($event): ?>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Name : <?= htmlspecialchars($event->name); ?></h5>
                <p class="card-text">Description : <?= htmlspecialchars($event->description); ?></p>
                <p><strong>Capacity:</strong> <?= $event->capacity; ?></p>
            </div>
        </div>
    <?php else: ?>
        <p class="text-center text-danger">Event not found!</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
