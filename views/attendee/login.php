<?php include __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Login</h2>
    <form method="POST" action="/login" class="mt-4">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-light w-100">Login</button>
    </form>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>
