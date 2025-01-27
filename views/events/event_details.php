<?php include __DIR__ . '/../templates/header.php'; ?>

<div class="card text-center">
  <div class="card-header">
    Event Details
  </div>
  <?php if ($event): ?>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($event->name); ?></h5>
                <p><strong>Capacity:</strong> <?= $event->capacity; ?> | <strong>Spot Left:</strong> <?= $event->spot_left; ?></p>
                <p class="card-text"><?= htmlspecialchars($event->description); ?></p>
            </div>
            
        </div>
        <div class="card-footer text-body-secondary">

            <?php if (!isset($_SESSION['user'])): ?>
                <a href="/register" class="btn btn-primary">Join the event</a>
            <?php elseif (isset($_SESSION['user']) && $_SESSION['user']->role == 'attendee'): ?>
                <button type="button" class="btn btn-primary status-btn" data-status="going">Going</button>
                <button type="button" class="btn btn-danger status-btn" data-status="not_going">Not Going</button>
                <button type="button" class="btn btn-warning status-btn" data-status="interested">Interested</button>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <p class="text-center text-danger">Event not found!</p>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../templates/footer.php'; ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.status-btn').on('click', function() {
            const status = $(this).data('status');
            const eventUuid = "<?= $event->uuid; ?>";

            $.ajax({
                url: '/update_attendee_event',
                type: 'POST',
                data: {
                    event_uuid: eventUuid,
                    status: status
                },
                success: function(response) {
                    const buttons = $('.status-btn');
                    buttons.removeClass('btn-primary btn-danger btn-warning');
                    buttons.addClass('btn-secondary');
                    
                    if (status === 'going') {
                        buttons.filter('[data-status="going"]').removeClass('btn-secondary').addClass('btn-primary');
                    } else if (status === 'not_going') {
                        buttons.filter('[data-status="not_going"]').removeClass('btn-secondary').addClass('btn-danger');
                    } else if (status === 'interested') {
                        buttons.filter('[data-status="interested"]').removeClass('btn-secondary').addClass('btn-warning');
                    }
                },
                error: function(xhr) {
                    alert('Error updating status. Please try again.');
                }
            });
        });
    });
</script>