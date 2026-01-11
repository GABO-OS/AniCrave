<?php
session_start();
include('connect.php');

// Handle Role Updates
$message = '';
$msg_type = '';

if (isset($_POST['user_id']) && isset($_POST['action'])) {
    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
    $action = $_POST['action'];

    $target_role = ($action === 'demote') ? 'user' : 'admin';
    $action_verb = ($action === 'demote') ? 'Demoted' : 'Promoted';

    $sql = "UPDATE users SET role = '$target_role' WHERE id = '$user_id'";
    if (mysqli_query($con, $sql)) {
        $message = "User ID: $user_id has been successfully $action_verb.";
        $msg_type = 'success';
    } else {
        $message = "Database error: " . mysqli_error($con);
        $msg_type = 'error';
    }
}

// Fetch Users with optional Search
$search = isset($_GET['search']) ? mysqli_real_escape_string($con, $_GET['search']) : '';
$where_clause = "WHERE 1=1";
if ($search) {
    $where_clause .= " AND (username LIKE '%$search%' OR email LIKE '%$search%')";
}

$users_sql = "SELECT * FROM users $where_clause ORDER BY role ASC, username ASC";
$users_res = mysqli_query($con, $users_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Role Manager - AniCrave</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Overpass:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .role-manager-container {
            padding: 40px 20px;
            max-width: 1000px;
            margin: 0 auto;
            min-height: 80vh;
        }

        .manager-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .search-box form {
            display: flex;
            gap: 10px;
        }

        .search-box input {
            padding: 10px 15px;
            background: var(--bg-secondary);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 4px;
            width: 250px;
        }

        .search-box button {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 0 20px;
            border-radius: 4px;
            cursor: pointer;
        }

        .users-table {
            width: 100%;
            border-collapse: collapse;
            background: var(--bg-secondary);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .users-table th,
        .users-table td {
            text-align: left;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .users-table th {
            background: rgba(0, 0, 0, 0.2);
            color: var(--text-nav);
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .users-table tr:hover {
            background: rgba(255, 255, 255, 0.02);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-circle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #2B2D42;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 12px;
            overflow: hidden;
        }

        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-details h4 {
            font-size: 14px;
            color: var(--text-main);
            margin-bottom: 2px;
        }

        .user-details span {
            font-size: 12px;
            color: var(--text-muted);
        }

        .btn-action {
            padding: 6px 12px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: 700;
            transition: 0.2s;
        }

        .btn-promote {
            background: rgba(61, 180, 242, 0.15);
            color: var(--primary-blue);
            border: 1px solid rgba(61, 180, 242, 0.3);
        }

        .btn-promote:hover {
            background: var(--primary-blue);
            color: white;
        }

        .btn-demote {
            background: rgba(255, 107, 107, 0.15);
            color: #ff6b6b;
            border: 1px solid rgba(255, 107, 107, 0.3);
        }

        .btn-demote:hover {
            background: #ff6b6b;
            color: white;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 6px;
        }

        .alert-success {
            background: rgba(76, 209, 55, 0.1);
            color: #4cd137;
            border: 1px solid rgba(76, 209, 55, 0.2);
        }

        .alert-error {
            background: rgba(232, 65, 24, 0.1);
            color: #e84118;
            border: 1px solid rgba(232, 65, 24, 0.2);
        }
    </style>
</head>

<body>

    <?php include 'includes/header.php'; ?>

    <div class="role-manager-container">
        <div class="manager-header">
            <div>
                <h1 style="font-size: 24px; margin-bottom: 5px;">User Management</h1>
                <p style="color: var(--text-muted); font-size: 14px;">Manage user roles and permissions</p>
            </div>

            <div class="search-box">
                <form method="GET">
                    <input type="text" name="search" placeholder="Search by username or email..."
                        value="<?php echo htmlspecialchars($search); ?>">
                    <button type="submit"><i class="fa-solid fa-search"></i></button>
                </form>
            </div>
        </div>

        <?php if ($message): ?>
            <div class="alert <?php echo ($msg_type == 'success') ? 'alert-success' : 'alert-error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <table class="users-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($users_res)): ?>
                    <tr>
                        <td>
                            <div class="user-info">
                                <div class="avatar-circle">
                                    <?php if (!empty($row['profile_picture'])): ?>
                                        <img src="<?php echo htmlspecialchars($row['profile_picture']); ?>" alt="Profile">
                                    <?php else: ?>
                                        <i class="fa-solid fa-user"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="user-details">
                                    <h4><?php echo htmlspecialchars($row['username']); ?></h4>
                                    <span><?php echo htmlspecialchars($row['email']); ?></span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <?php if ($row['role'] === 'admin'): ?>
                                <span class="role-badge role-admin" style="margin:0;">Admin</span>
                            <?php else: ?>
                                <span class="role-badge role-user" style="margin:0;">User</span>
                            <?php endif; ?>
                        </td>
                        <td style="color: var(--text-muted); font-size: 13px;">
                            <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                        </td>
                        <td style="text-align: right;">
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                <?php if ($row['role'] === 'admin'): ?>
                                    <button type="submit" name="action" value="demote" class="btn-action btn-demote">
                                        <i class="fa-solid fa-arrow-down"></i> Demote
                                    </button>
                                <?php else: ?>
                                    <button type="submit" name="action" value="promote" class="btn-action btn-promote">
                                        <i class="fa-solid fa-crown"></i> Promote
                                    </button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>

                <?php if (mysqli_num_rows($users_res) == 0): ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            No users found matching your search.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div style="margin-top: 30px;">
            <a href="admin_dashboard.php"
                style="color: var(--text-nav); font-size: 14px; display: flex; align-items: center; gap: 8px;">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>

</html>