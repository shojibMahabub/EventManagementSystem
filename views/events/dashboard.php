<?php include __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Event Dashboard</h2>
    <a href="/events/add" class="btn btn-success mb-3">Add Event</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($events as $event): ?>
                <tr>
                    <td><?= htmlspecialchars($event->name); ?></td>
                    <td><?= htmlspecialchars($event->description); ?></td>
                    <td><?= $event->capacity; ?></td>
                    <td>
                        <a href="/events/details?uuid=<?= $event->uuid; ?>" class="btn btn-primary btn-sm">View</a>
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="/events/details?uuid=<?= $event->uuid; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="/events/details?uuid=<?= $event->uuid; ?>" class="btn btn-danger btn-sm">Delete</a>                        
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
