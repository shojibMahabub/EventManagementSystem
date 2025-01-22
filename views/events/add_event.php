<?php include __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Add New Event</h2>
    <form method="POST" action="/events/add" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
        </div>
        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Add Event</button>
    </form>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
