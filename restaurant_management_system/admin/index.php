<?php
include "../config.php";
session_start();
if (!$_SESSION['admin_id']) {
	header('Location: ../login');
	exit();
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Dashboard</title>
	<link rel="stylesheet" href="index.css">
</head>

<body>
	<div class="root">
		<div class="">
			<h2>Reservations</h2>
		</div>
		<div class="">
			<table cellspacing="0">
				<thead>
					<tr>
						<th>Customer</th>
						<th>Phone</th>
						<th>No. of Guests</th>
						<th>Time</th>
						<th>Date</th>
						<th>Message</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// Importing database connection string from config.php
					$sql = "SELECT * FROM booking";
					$query = mysqli_query($connection, $sql);
					if (mysqli_num_rows($query) <= 0) {
						echo "
                        <tr class='data'>
                            <td colspan='7'>No data found</td>
                        </tr>
                        ";
					} else {
						while ($row = mysqli_fetch_assoc($query)) {
							?>
							<tr class="data">
								<td><?php echo htmlspecialchars($row['name']); ?></td>
								<td><a
										href="tel:<?php echo htmlspecialchars($row['phone']); ?>"><?php echo htmlspecialchars($row['phone']); ?></a>
								</td>
								<td><?php echo htmlspecialchars($row['guest']); ?></td>
								<td><?php echo htmlspecialchars($row['time']); ?></td>
								<td><?php echo htmlspecialchars($row['date']); ?></td>
								<td><?php echo !empty($row['special']) ? htmlspecialchars($row['special']) : "No message"; ?>
								</td>
								<td style="">
									<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"
										style="display:flex;flex-direction:column;gap:5px;margin:auto;">
										<select name="status" class="status-select" style="font-size: 1.3rem">
											<option value="processing" <?php echo $row['status'] === 'processing' ? 'selected' : ''; ?>>Processing</option>
											<option value="rejected" <?php echo $row['status'] === 'rejected' ? 'selected' : ''; ?>>Rejected</option>
											<option value="completed" <?php echo $row['status'] === 'completed' ? 'selected' : ''; ?>>Completed</option>
										</select>
										<input type="hidden" name="id" value="<?php echo $row['id'] ?>" id="">
										<input type="submit" name="status_change" id="">
									</form>
								</td>
							</tr>
							<?php
						}
					}
					?>
				</tbody>
			</table>

			<?php
			if (isset($_POST['status_change'])) {
				$id = $_POST['id'];
				$status = $_POST['status'];
				$sql = "UPDATE booking SET status = '$status' WHERE id = '$id' ";
				$save = mysqli_query($connection, $sql);

				if ($save) {
					echo "
					<script>
					alert('saved');
					window.location.href = '';
					</script>
					";
				}
			}
			?>
		</div>
	</div>

	<script>
		function updateAllSelectBackgrounds() {
			const selects = document.querySelectorAll('.status-select');
			selects.forEach(select => {
				updateSelectBackground(select);
				select.addEventListener('change', () => updateSelectBackground(select));
			});
		}

		function updateSelectBackground(selectElement) {
			const selectedValue = selectElement.value;

			if (selectedValue === 'processing') {
				selectElement.style.backgroundColor = 'blue';
			} else if (selectedValue === 'rejected') {
				selectElement.style.backgroundColor = 'red';
			} else if (selectedValue === 'completed') {
				selectElement.style.backgroundColor = 'green';
			} else {
				selectElement.style.backgroundColor = ''; // Reset to default
			}
		}

		// Initialize the background color for all select elements when the page loads
		updateAllSelectBackgrounds();
	</script>
</body>

</html>