<?php include __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Attendee Registeration Form</h2>
    <form method="POST" action="/attendee/register" class="mt-4">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <p>Alredy have an account ? <a href="#">Login</a></p>

        <button type="submit" class="btn btn-light w-100">Register</button>
    </form>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
