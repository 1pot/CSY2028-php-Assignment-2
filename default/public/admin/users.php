<?php include 'connect.php';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && (isset($_SESSION['user_type_id']) && $_SESSION['user_type_id'] == 1)) { ?>
	<h2>Users</h2>
	<a class="new pull-rght" href="user_add.php">Add new User</a>
    <?php echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th style="width: 5%">Username</th>';
    echo '<th style="width: 15%">User Type</th>';
    echo '<th>First Name</th>';
    echo '<th>Last Name</th>';
    echo '<th style="width: 15%">Contact</th>';
    echo '<th style="width: 12%">Email</th>';
    echo '<th style="width: 0%">Created On</th>';
    echo '</tr>';

    $users_list = $pdo->query('SELECT usr.user_id, usr.first_name, usr.last_name,
        usr.contact_number as contact, usr.email_address as email, usr.created_date_time, usr.username,
        utp.title as  user_type
        FROM users usr, user_types utp WHERE usr.user_type_id = utp.user_type_id AND usr.record_status = 1 AND utp.user_type_id != 1');
    foreach ($users_list as $user) {
        echo '<tr>';
        echo '<td>' . $user['username'] . '</td>';
        echo '<td>' . $user['user_type'] . '</td>';
        echo '<td>' . $user['first_name'] . '</td>';
        echo '<td>' . $user['last_name'] . '</td>';
        echo '<td>' . $user['contact'] . '</td>';
        echo '<td>' . $user['email'] . '</td>';
        echo '<td>' . $user['created_date_time'] . '</td>';
        echo '<td>
                <a style="float: right" href="user_edit.php?id=' . $user['user_id'] . '">Edit
                </a>
            </td>';
        echo '<td>
                <form method="post" action="user_delete.php">
                    <input type="hidden" name="id" value="'.$user['user_id'].'" />
                    <input type="submit" name="submit" value="Delete" />
                </form>
            </td>';
        echo '</tr>';
    }
    echo '</thead>';
    echo '</table>';
} else { ?>
    <h2>Log in</h2>
    <?php include '../admin/login.php'; ?>
<?php } ?>
</main>