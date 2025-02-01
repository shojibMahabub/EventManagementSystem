<div class="col-md-3 col-lg-2">
    <button class="btn btn-light d-md-none mb-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#filters-sidebar"
        aria-controls="filters-sidebar">
        <i class="fas fa-filter"></i> Filters
    </button>

    <div class="offcanvas-md offcanvas-start" tabindex="-1" id="filters-sidebar" aria-labelledby="filters-sidebar-label">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="filters-sidebar-label">Filters</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#filters-sidebar"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form method="GET" class="mb-3">
                <div class="mb-3">
                    <label for="search" class="form-label">Search Event</label>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search event"
                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="date-range" class="form-label">Date Range</label>
                    <input type="text" name="date_range" id="date-range" class="form-control"
                        placeholder="Select Date Range" value="<?= htmlspecialchars($_GET['date_range'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="filter[location]" id="location" class="form-control"
                        placeholder="Location" value="<?= htmlspecialchars($_GET['filter']['location'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="number" name="filter[capacity]" id="capacity" class="form-control"
                        placeholder="Capacity" value="<?= htmlspecialchars($_GET['filter']['capacity'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="spot_left" class="form-label">Spot Left</label>
                    <input type="number" name="filter[spot_left]" id="spot_left" class="form-control"
                        placeholder="Spot Left" value="<?= htmlspecialchars($_GET['filter']['spot_left'] ?? '') ?>">
                </div>

                <input type="hidden" name="page" value="1">
                <input type="hidden" name="limit" value="<?= $limit ?>">

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-light">Apply Filters</button>
                    <a href="/events" class="btn btn-outline-secondary">Reset Filters</a>
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']->role !== 'attendee'): ?>
                    <a href="/event/add" class="btn btn-primary mb-3">Add Event</a>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>
