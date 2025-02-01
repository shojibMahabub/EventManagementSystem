<?php

include __DIR__ . '/../templates/header.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$sort = $_GET['sort'] ?? 'date';
$order = $_GET['order'] ?? 'asc';

usort($events, function ($a, $b) use ($sort, $order) {
    if ($sort === 'name') {
        return $order === 'asc' ? strcmp($a->name, $b->name) : strcmp($b->name, $a->name);
    } elseif ($sort === 'date') {
        return $order === 'asc' ? strtotime($a->event_date_time) - strtotime($b->event_date_time) : strtotime($b->event_date_time) - strtotime($a->event_date_time);
    } elseif ($sort === 'time') {
        return $order === 'asc' ? strtotime($a->event_date_time) - strtotime($b->event_date_time) : strtotime($b->event_date_time) - strtotime($a->event_date_time);
    } elseif ($sort === 'capacity') {
        return $order === 'asc' ? $a->capacity - $b->capacity : $b->capacity - $a->capacity;
    } elseif ($sort === 'spot_left') {
        return $order === 'asc' ? $a->spot_left - $b->spot_left : $b->spot_left - $a->spot_left;
    } elseif ($sort === 'location') {
        return $order === 'asc' ? strcmp($a->location, $b->location) : strcmp($b->location, $a->location);
    }
    return 0;
});
?>

<div class="container mt-5">
    <div><h2>Events</h2></div>
    <div class="row">

        <?php include __DIR__ . '/event_filter.php'; ?>

        <div class="col-md-9 col-lg-10">
            <?php include __DIR__ . '/event_data.php'; ?>
            <?php include __DIR__ . '/../templates/footer.php'; ?>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('.dropdown-item').on('click', function() {
                        const status = $(this).data('status');
                        const eventUuid = $(this).attr('data-eventuuid');
                        const userUuid = $(this).attr('data-useruuid');
                        const button = $(this).closest('.btn-group').find('button');

                        if (!eventUuid || !userUuid) {
                            console.error('Missing event or user UUID');
                            return;
                        }

                        console.log('Event UUID:', eventUuid, 'User UUID:', userUuid, 'Status:', status);

                        $.ajax({
                            url: '/update_attendee_event',
                            type: 'POST',
                            data: {
                                event_uuid: eventUuid,
                                user_uuid: userUuid,
                                status: status
                            },
                            success: function(response) {
                                button.text(ucfirst(status.toLowerCase()));
                            },
                            error: function(xhr) {
                                alert('Error updating status. Please try again.');
                            }
                        });
                    });

                    function ucfirst(string) {
                        return string.charAt(0).toUpperCase() + string.slice(1);
                    }
                });
            </script>
        </div>
    </div>
</div>
