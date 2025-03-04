<?php
// This is the main enquiryMessages.php file
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enquiry Messages - Merit Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- No need to include sidebar CSS as it will be part of the included file -->
  <link rel="stylesheet" href="./page.css">
</head>
<body>



    <div class="wrapper">
        <!-- Include the sidebar -->
        <?php include '../sidenavbar/sidenavbar.php'; ?>

        <!-- Content Area -->
        <div class="content">
            <h2 class="text-center mb-4">Enquiry Messages</h2>
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Standard</th>
                            <th>School/College</th>
                            <th>Board</th>
                            <th>Subject</th>
                            <th>Contact No.</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include 'enquiryGET.php'; // Include data fetch logic
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['id']; ?></td>
                                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><?php echo htmlspecialchars($row['standard']); ?></td>
                                    <td><?php echo htmlspecialchars($row['school_college']); ?></td>
                                    <td><?php echo htmlspecialchars($row['board']); ?></td>
                                    <td><?php echo htmlspecialchars($row['subject']); ?></td>
                                    <td><?php echo htmlspecialchars($row['contact_no']); ?></td>
                                    <td>
                                        <a href="enquiryGET.php?delete=<?php echo $row['id']; ?>"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Are you sure you want to delete this enquiry?');">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php }
                        } else { ?>
                            <tr>
                                <td colspan="8" class="text-center">No Enquiries Found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- No need to include sidebar JS as it will be part of the included file -->
</body>
</html>