<?php
include __DIR__ . '/db_connect.php';

$farmData = [
    'Farm_ID' => '',
    'Name' => '',
    'Street' => '',
    'City' => '',
    'State' => '',
    'Certification' => '',
    'ContactNumber' => '',
    'Email' => ''
];

$editMode = false;

if (isset($_GET['edit'])) {
    $editMode = true;
    $farmId = $_GET['edit'];
    $stmt = $conn->prepare("SELECT * FROM Farm_T WHERE Farm_ID = ?");
    $stmt->bind_param("s", $farmId);
    $stmt->execute();
    $result = $stmt->get_result();
    $farmData = $result->fetch_assoc();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $editMode ? 'Edit Farm' : 'Add New Farm'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-footer {
            display: flex;
            justify-content: start;
            gap: 15px;
            margin-top: 30px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <h2 class="text-center mb-4"><?php echo $editMode ? 'Edit Farm Information' : 'Add New Farm'; ?></h2>

        <!-- Change the form action to farm_create.php -->
        <form action="farm_create.php" method="POST" class="card p-4 shadow-sm">
            <input type="hidden" name="editMode" value="<?php echo $editMode ? '1' : '0'; ?>">

            <div class="mb-3">
                <label for="Farm_ID" class="form-label">Farm ID</label>
                <input type="text" class="form-control" id="Farm_ID" name="Farm_ID" value="<?php echo $farmData['Farm_ID']; ?>" <?php echo $editMode ? 'readonly' : 'required'; ?>>
            </div>

            <div class="mb-3">
                <label for="Name" class="form-label">Farm Name</label>
                <input type="text" class="form-control" id="Name" name="Name" value="<?php echo $farmData['Name']; ?>" required>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="Street" class="form-label">Street</label>
                    <input type="text" class="form-control" id="Street" name="Street" value="<?php echo $farmData['Street']; ?>" required>
                </div>
                <div class="col">
                    <label for="City" class="form-label">City</label>
                    <input type="text" class="form-control" id="City" name="City" value="<?php echo $farmData['City']; ?>" required>
                </div>
                <div class="col">
                    <label for="State" class="form-label">State</label>
                    <input type="text" class="form-control" id="State" name="State" value="<?php echo $farmData['State']; ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="Certification" class="form-label">Certification</label>
                <input type="text" class="form-control" id="Certification" name="Certification" value="<?php echo $farmData['Certification']; ?>">
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="ContactNumber" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="ContactNumber" name="ContactNumber" value="<?php echo $farmData['ContactNumber']; ?>" required>
                </div>
                <div class="col">
                    <label for="Email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="Email" name="Email" value="<?php echo $farmData['Email']; ?>" required>
                </div>
            </div>

            <div class="form-footer">
                <button type="submit" class="btn btn-primary">
                    <?php echo $editMode ? 'Update Farm' : 'Add Farm'; ?>
                </button>
                <a href="f8.php#farms" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
