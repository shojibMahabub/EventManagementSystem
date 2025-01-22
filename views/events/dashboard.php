<?php include __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Event Dashboard</h2>
    <a href="/events/add" class="btn btn-success mb-3">Add Event</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= $event->id; ?></td>
                    <td><?= htmlspecialchars($event->name); ?></td>
                    <td><?= htmlspecialchars($event->description); ?></td>
                    <td><?= $event->capacity; ?></td>
                    <td>
                        <a href="/events/details?id=<?= $event->id; ?>" class="btn btn-primary btn-sm">View</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
