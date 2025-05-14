 
<?php
<?php
session_start();
require_once '../config.php';
require_once '../includes/functions.php'; // Change this line from '../functions.php'

// Rest of your code...

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

$errors = [];
$success = false;

// Get all clients for the dropdown
$stmt = $conn->prepare("SELECT c.id, c.name as client_name FROM clients c ORDER BY c.name");
$stmt->execute();
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $client_id = $_POST['client_id'] ?? '';
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $amount = $_POST['amount'] ?? '';
    $due_date = $_POST['due_date'] ?? '';
    $payment_status = $_POST['payment_status'] ?? 'pending';
    
    // Basic validation
    if (empty($client_id)) {
        $errors[] = "Client is required";
    }
    
    if (empty($name)) {
        $errors[] = "Project name is required";
    }
    
    if (empty($amount) || !is_numeric($amount) || $amount <= 0) {
        $errors[] = "Valid amount is required";
    }
    
    if (empty($due_date)) {
        $errors[] = "Due date is required";
    } elseif (strtotime($due_date) === false) {
        $errors[] = "Invalid due date format";
    }
    
    // If no errors, insert the new project
    if (empty($errors)) {
        try {
            $stmt = $conn->prepare("INSERT INTO projects (client_id, name, description, amount, due_date, payment_status, created_at) 
                                    VALUES (?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$client_id, $name, $description, $amount, $due_date, $payment_status]);
            
            $success = true;
            
            // Clear the form after successful submission
            $client_id = $name = $description = $amount = $due_date = '';
            $payment_status = 'pending';
            
        } catch (PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Project - Payment Status Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-indigo-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="../index.php" class="text-xl font-bold">Payment Platform</a>
            <div>
                <span class="mr-4">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 
                    (Admin)
                </span>
                <a href="../index.php?logout=1" class="bg-indigo-700 hover:bg-indigo-800 px-4 py-2 rounded">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Add New Project</h1>
            <a href="../index.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
        
        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline"> Project has been added successfully.</span>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong class="font-bold">Error!</strong>
                <ul class="list-disc list-inside">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if (empty($clients)): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-4">
                <strong class="font-bold">Warning!</strong>
                <span class="block sm:inline"> No clients found. Please <a href="add_client.php" class="underline">add a client</a> first.</span>
            </div>
        <?php endif; ?>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="client_id" class="block text-gray-700 font-medium mb-2">Client</label>
                    <select id="client_id" name="client_id" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                        required <?php echo empty($clients) ? 'disabled' : ''; ?>>
                        <option value="">Select Client</option>
                        <?php foreach ($clients as $client): ?>
                            <option value="<?php echo $client['id']; ?>" <?php echo (isset($client_id) && $client_id == $client['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($client['client_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-medium mb-2">Project Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" 
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"><?php echo htmlspecialchars($description ?? ''); ?></textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="mb-4">
                        <label for="amount" class="block text-gray-700 font-medium mb-2">Amount ($)</label>
                        <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($amount ?? ''); ?>" 
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" 
                            min="0" step="0.01" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="due_date" class="block text-gray-700 font-medium mb-2">Due Date</label>
                        <input type="date" id="due_date" name="due_date" value="<?php echo htmlspecialchars($due_date ?? ''); ?>" 
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="payment_status" class="block text-gray-700 font-medium mb-2">Payment Status</label>
                        <select id="payment_status" name="payment_status" 
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            <option value="pending" <?php echo (isset($payment_status) && $payment_status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                            <option value="paid" <?php echo (isset($payment_status) && $payment_status == 'paid') ? 'selected' : ''; ?>>Paid</option>
                            <option value="overdue" <?php echo (isset($payment_status) && $payment_status == 'overdue') ? 'selected' : ''; ?>>Overdue</option>
                        </select>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg" <?php echo empty($clients) ? 'disabled' : ''; ?>>
                        <i class="fas fa-plus mr-2"></i> Add Project
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="bg-white py-4 shadow-inner mt-8">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; <?php echo date('Y'); ?> Desblooms. All rights reserved.
        </div>
    </footer>
</body>
</html>