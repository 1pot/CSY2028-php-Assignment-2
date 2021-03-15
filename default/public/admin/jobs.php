<?php session_start();
include 'connect.php';
$pageTittle = "Jo's Jobs - Job";
include 'inc/admin_header.php' ?>
    <section class="left">
        <?php include '../admin/inc/left_bar.php'; ?>
    </section>
	<section class="right">
		<!-- Permission base check to view jobs page for staff panel or admin panel -->
		<?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true ) { ?>
			<h2>Jobs</h2>
			<!-- Permission check for add all users can add job -->
			<?php echo ( ((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) &&
			( isset($_SESSION['user_type_id']) && ($_SESSION['user_type_id'] == 1  || $_SESSION['user_type_id'] == 2 || $_SESSION['user_type_id'] == 3)) ?
				'<a class="new pull-rght" href="addjob.php">Add new job</a>': ''
			)?>
			<!-- Jobs filter form -->
            <form action="jobs.php" method="post">
                <label class="lblCat">Category</label>
                <select name="category_id">
                    <option>Please select category</option>
                <?php try {
                    $stmt = $pdo->prepare('SELECT * FROM category');
                    $stmt->execute();
                    foreach ($stmt as $row) {
                        //posted value of filter form to show jobs by category
                        if ($_POST['category_id'] == $row['id']) {
                            echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        } else {
                            echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                        }
                    }
                } catch(PDOException $e) {
                    echo  $e->getMessage();
                }
                catch(Error $e) {
                    echo  $e->getMessage();
                }?>
                </select>
                <input type="submit" name="submit" value="FILTER" />
                <br>
            </form>
            <?php echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Title</th>';
            echo '<th>Category</th>';
            echo '<th style="width: 15%">Salary</th>';
            echo '<th>Closing Date</th>';
            echo '<th style="width: 12%">&nbsp;</th>';
            echo '<th style="width: 15%">&nbsp;</th>';
            echo '<th style="width: 0%">&nbsp;</th>';
            echo '<th style="width: 5%">&nbsp;</th>';
            echo '</tr>';
            try {
                // inline if condition to concat category id in query string
                $quer_concat_string = (isset($_POST['category_id']) ? " AND jb.categoryId = '" . $_POST['category_id'] . "'" : '');
                // check for user type it it's not admin & staff then only show jobs by created_by means user can only see jobs he/she posted.
                if ((isset($_SESSION['user_type_id']) && ($_SESSION['user_type_id'] == 3) && isset($_SESSION['user_id']))) {
                    $quer_concat_string .= "AND ( jb.created_by = '" . $_SESSION['user_id'] . "' OR jb.updated_by = '" . $_SESSION['user_id'] . "' )";
                }
                $stmt = $pdo->query('SELECT jb.id, jb.title, jb.salary, jb.closingDate, jb.categoryId, jb.record_status, jb.description, cat.name as category_title FROM job jb, category cat WHERE jb.categoryId = cat.Id AND jb.record_status = 1 '
                    . $quer_concat_string . ' ORDER BY jb.closingDate DESC LIMIT 10 ');
            } catch(PDOException $e) {
                echo  $e->getMessage(); 
            } catch(Error $e) {
                echo  $e->getMessage(); 
            }
            foreach ($stmt as $job) {
                $applicants = $pdo->prepare('SELECT count(*) as count FROM applicants WHERE jobId = :jobId');
                $applicants->execute(['jobId' => $job['id']]);
                $applicantCount = $applicants->fetch();
                echo '<tr>';
                echo '<td>' . $job['title'] . '</td>';
                echo '<td>' . $job['category_title'] . '</td>';
                echo '<td>' . $job['salary'] . '</td>';
                echo '<td>' . $job['closingDate'] . '</td>';
                echo (
                    ((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) &&
                    (isset($_SESSION['user_type_id']) && ($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2)) ?
                    '<td><a style="float: right" href="editjob.php?id=' . $job['id'] . '">Edit</a></td>': ''
                );
                echo (
                    ((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) &&
                    (isset($_SESSION['user_type_id']) && ($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 3)) ?
                    '<td><a style="float: right" href="applicants.php?id=' . $job['id'] . '">View applicants (' . $applicantCount['count'] . ')</a></td>': ''
                );

                echo '<td>
                    <form method="post" action="deletejob.php">';
                        // Inline if for permission base access
                        echo (
                            ((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) &&
                            (isset($_SESSION['user_type_id']) && ($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2)) ?
                            '<input type="hidden" name="id" value="' . $job['id'] . '" />': ''
                        );
                        echo (
                            ((isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)) &&
                            (isset($_SESSION['user_type_id']) && ($_SESSION['user_type_id'] == 1 || $_SESSION['user_type_id'] == 2)) ?
                            '<input type="submit" name="submit" value="Delete" />': ''
                        );
                    echo '</form>
                </td>';
                echo '</tr>';

            }
            echo '</thead>';
            echo '</table>';
        }else { ?>
            <h2>Log in</h2>
            <?php include 'login.php'; ?>
        <?php
        }
		?>
	</section>
</main>

<?php include 'inc/admin_footer.php' ?>
