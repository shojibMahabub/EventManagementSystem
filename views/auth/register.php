<?php include __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Register</h2>
    <form method="POST" action="/register" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="role" id="attendee_role" value="attendee" checked>
            <label class="form-check-label" for="attendee_role">Attendee</label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="role" id="admin_role" value="admin" disabled>
            <label class="form-check-label" for="admin_role">Admin</label>
            </div>
            <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="role" id="superadmin_role" value="superadmin" disabled>
            <label class="form-check-label" for="superadmin_role">Super Admin</label>
        </div>
        <button type="submit" class="btn btn-light w-100">Register</button>
    </form>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
