<?php
require_once("../db/db_connect.php");

$record_id = intval($_POST['record_id']);

$sql = "SELECT
            uh.*,
            u.name
        FROM property_history uh
        LEFT JOIN user u
            ON uh.user_id = u.user_id
        WHERE uh.record_id = ?
        AND uh.target_table = 'property_info'
        ORDER BY uh.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $record_id);
$stmt->execute();

$result = $stmt->get_result();
?>

<table class="table table-bordered table-hover table-sm">

    <thead class="table-success">
        <tr>
            <th width="8%">ID</th>
            <th width="12%">Date</th>
            <th width="12%">User</th>
            <th width="10%">Action</th>
            <th>Notes</th>
            <th width="15%">Description</th>
        </tr>
    </thead>

    <tbody>

        <?php if ($result->num_rows > 0): ?>

            <?php while ($row = $result->fetch_assoc()): ?>

                <tr>

                    <td><?= $row['id']; ?></td>

                    <td>
                        <?= date("M d, Y h:i A", strtotime($row['created_at'])); ?>
                    </td>

                    <td><?= htmlspecialchars($row['name']); ?></td>

                    <td>
                        <?php
                        switch (strtolower($row['action'])) {

                            case 'insert':
                            case 'add':
                                echo '<span class="badge bg-success">' . $row['action'] . '</span>';
                                break;

                            case 'update':
                                echo '<span class="badge bg-warning text-dark">' . $row['action'] . '</span>';
                                break;

                            case 'delete':
                                echo '<span class="badge bg-danger">' . $row['action'] . '</span>';
                                break;

                            default:
                                echo '<span class="badge bg-secondary">' . $row['action'] . '</span>';
                        }
                        ?>
                    </td>

                    <td>

                        <?php

                        $changes = json_decode($row['db_update'], true);

                        if (json_last_error() === JSON_ERROR_NONE && is_array($changes)) {

                            foreach ($changes as $field => $value) {

                                // Make field names readable
                                $label = ucwords(str_replace('_', ' ', $field));

                                $old = trim((string)($value['old'] ?? ''));
                                $new = trim((string)($value['new'] ?? ''));

                                echo '<div class="mb-2">';
                                echo '<strong class="text-success">' . $label . '</strong><br>';

                                echo '<span class="text-danger">Old:</span> ';
                                echo ($old === '') ? '<em>(empty)</em>' : '<strong>' . htmlspecialchars($old) . '</strong>';

                                echo '<br>';

                                echo '<span class="text-primary">New:</span> ';
                                echo ($new === '') ? '<em>(empty)</em>' : '<strong>' . htmlspecialchars($new) . '</strong>';

                                echo '</div>';
                            }
                        } else {

                            echo nl2br(htmlspecialchars($row['description']));
                        }

                        ?>

                    </td>

                    <td><?= htmlspecialchars($row['description']); ?></td>

                </tr>

            <?php endwhile; ?>

        <?php else: ?>

            <tr>
                <td colspan="6" class="text-center text-muted">
                    No history found.
                </td>
            </tr>

        <?php endif; ?>

    </tbody>

</table>