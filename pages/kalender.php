<?php
// Get month and year from URL
$cal_month = isset($_GET['month']) ? (int) $_GET['month'] : date('n');
$cal_year = isset($_GET['year']) ? (int) $_GET['year'] : date('Y');

// Calculate prev and next month
$prev_month = $cal_month - 1;
$prev_year = $cal_year;
if ($prev_month < 1) {
    $prev_month = 12;
    $prev_year--;
}

$next_month = $cal_month + 1;
$next_year = $cal_year;
if ($next_month > 12) {
    $next_month = 1;
    $next_year++;
}

$months = [
    '',
    'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
];

$first_day = date('w', mktime(0, 0, 0, $cal_month, 1, $cal_year));
$days_in_month = date('t', mktime(0, 0, 0, $cal_month, 1, $cal_year));
?>

<div id="kalenderPage" class="page-section <?php echo ($active_page == 'kalender') ? 'active' : ''; ?>">
    <div class="card shadow-lg">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="dashboard.php?page=kalender&month=<?php echo $prev_month; ?>&year=<?php echo $prev_year; ?>"
                    class="btn btn-outline-secondary">
                    <i class="bi bi-chevron-left"></i>
                </a>
                <h2 class="mb-0"><?php echo $months[$cal_month] . ' ' . $cal_year; ?></h2>
                <a href="dashboard.php?page=kalender&month=<?php echo $next_month; ?>&year=<?php echo $next_year; ?>"
                    class="btn btn-outline-secondary">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>

            <div class="calendar-grid mb-3">
                <div class="text-center fw-bold py-2">Min</div>
                <div class="text-center fw-bold py-2">Sen</div>
                <div class="text-center fw-bold py-2">Sel</div>
                <div class="text-center fw-bold py-2">Rab</div>
                <div class="text-center fw-bold py-2">Kam</div>
                <div class="text-center fw-bold py-2">Jum</div>
                <div class="text-center fw-bold py-2">Sab</div>
            </div>

            <div class="calendar-grid">
                <?php
                // Empty cells
                for ($i = 0; $i < $first_day; $i++) {
                    echo '<div class="calendar-day"></div>';
                }

                // Days
                for ($day = 1; $day <= $days_in_month; $day++) {
                    $date = sprintf('%04d-%02d-%02d', $cal_year, $cal_month, $day);

                    // Get schedules for this day
                    $day_jadwal = [];
                    foreach ($jadwal_list as $jadwal) {
                        if ($jadwal['tanggal'] == $date) {
                            $day_jadwal[] = $jadwal;
                        }
                    }

                    $count = count($day_jadwal);
                    $has_schedule = $count > 0 ? 'has-schedule' : '';

                    echo '<div class="calendar-day ' . $has_schedule . '" 
                               data-date="' . $date . '"
                               ondrop="handleDrop(event)" 
                               ondragover="allowDrop(event)"
                               onclick="openAddJadwalWithDate(\'' . $date . '\')">';
                    echo '<div class="day-number">' . $day . '</div>';

                    // Show first schedule
                    if ($count > 0) {
                        $jadwal = $day_jadwal[0];
                        echo '<div class="calendar-event" 
                                   draggable="true" 
                                   ondragstart="handleDragStart(event, ' . $jadwal['id'] . ', \'' . $date . '\')"
                                   onclick="event.stopPropagation();">
                                   <a href="dashboard.php?page=kalender&edit=' . $jadwal['id'] . '" style="color: white; text-decoration: none;">
                                       ' . htmlspecialchars(substr($jadwal['mata_kuliah'], 0, 15)) . '
                                   </a>
                              </div>';

                        // Show "+N more" if multiple schedules
                        if ($count > 1) {
                            $jadwal_json = htmlspecialchars(json_encode($day_jadwal));
                            echo '<div class="more-events" onclick="event.stopPropagation(); showAllJadwalPopup(' . $jadwal_json . ')">
                                    +' . ($count - 1) . ' lainnya
                                  </div>';
                        }
                    }

                    echo '</div>';
                }
                ?>
            </div>

            <div class="alert alert-info mt-4">
                <strong>💡 Tip:</strong> Drag jadwal ke tanggal lain untuk memindahkan. Klik tanggal kosong untuk tambah
                jadwal.
            </div>
        </div>
    </div>
</div>

<!-- Hidden Form untuk Drag & Drop -->
<form id="dragDropForm" method="POST" action="process/move_jadwal.php" style="display: none;">
    <input type="hidden" name="jadwal_id" id="dragJadwalId">
    <input type="hidden" name="new_date" id="dragNewDate">
    <input type="hidden" name="old_date" id="dragOldDate">
</form>

<!-- Modal Popup untuk Multiple Schedules -->
<div class="modal fade" id="multipleScheduleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info text-cream">
                <h5 class="modal-title">
                    <i class="bi bi-calendar-event"></i> Jadwal Hari Ini
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="multipleScheduleBody"></div>
        </div>
    </div>
</div>

<style>
    .calendar-day.drag-over {
        background: #d4edda !important;
        border: 2px dashed #e4ab32ff !important;
    }

    .calendar-event {
        cursor: move;
    }

    .calendar-event:active {
        opacity: 0.5;
    }

    .modal-header-cream {
        background-color: #f5efe6;
        /* cream */
        color: #4a3f2a;
        border-bottom: 1px solid #e0d6c6;
    }

    .modal-header-cream .modal-title i {
        color: #9c6a1f;
        /* gold icon */
    }

    .modal-header-cream .btn-close {
        filter: invert(0.4);
    }
</style>