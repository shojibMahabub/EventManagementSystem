<?php
include __DIR__ . '/../templates/header.php';
if ( array_key_exists('PATH_INFO', $_SERVER) && $_SERVER['PATH_INFO'] === '/event/edit' || array_key_exists('REDIRECT_URL', $_SERVER) && $_SERVER['REDIRECT_URL'] === '/event/edit') {
    $pageTitle = 'Edit Event';
    $action = '/event/update';
    $button = 'Edit Event';
} else {
    $pageTitle = 'Add New Event';
    $action = '/event/add';
    $button = 'Add Event';
}
?>

<div class="container mt-5">
    <h2 class="text-center"><?php echo $pageTitle ?></h2>
    <form method="POST" action=<?php echo $action ?> class="mt-4">


        <?php if (isset($event->uuid)) : ?>
            <input type="hidden" name="uuid" value="<?php echo htmlspecialchars($event->uuid); ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label for="name" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="name" name="name" required
                   value="<?php echo isset($event->name) ? $event->name : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"
                      required><?php echo isset($event->description) ? $event->description : ''; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity" required
                   value="<?php echo isset($event->capacity) ? $event->capacity : ''; ?>">
        </div>

        <div class="mb-3">
            <label for="datetime" class="form-label">Date and Time</label>
            <input
                    type="date"
                    class="form-control"
                    id="datetime"
                    name="datetime"
                    required
                    value="<?php echo isset($event->event_date_time) ? date('Y-m-d', strtotime($event->event_date_time)) : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" required
                   value="<?php echo isset($event->location) ? $event->location : ''; ?>">
        </div>
        <button type="submit" class="btn btn-light w-100"><?php echo $button ?></button>
    </form>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
