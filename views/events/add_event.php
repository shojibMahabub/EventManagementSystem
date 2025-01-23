<?php 
    include __DIR__ . '/../templates/header.php';
    if ($_SERVER['PATH_INFO'] === '/events/edit') {
        $pageTitle = 'Edit Event';
        $action = '/events/update';
        $button = 'Edit Event';
    }
    else {
        $pageTitle = 'Add New Event';
        $action = '/events/add';
        $button = 'Add Event';
    }
?>

<div class="container mt-5">
    <h2 class="text-center"><?php echo $pageTitle ?></h2>
    <form method="POST" action=<?php echo $action ?> class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Event Name</label>
            <input type="text" class="form-control" id="name" name="name" required value="<?php echo isset($event->name) ? $event->name : ''; ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo isset($event->description) ? $event->description : ''; ?></textarea>

        </div>
        <div class="mb-3">
            <label for="capacity" class="form-label">Capacity</label>
            <input type="number" class="form-control" id="capacity" name="capacity" required value="<?php echo isset($event->capacity) ? $event->capacity : ''; ?>">
        </div>
        
        <button type="submit" class="btn btn-success w-100"><?php echo $button ?></button>
    </form>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
