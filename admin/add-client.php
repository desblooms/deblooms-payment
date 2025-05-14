 
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

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $company_name = trim($_POST['company_name'] ?? '');
    $contact_person = trim($_POST['contact_person'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    
    // Basic validation
    if (empty($username)) {
        $errors[] = "Username is required";
    }
    
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    
    if (empty($password)) {
        $errors[] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }
    
    if (empty($company_name)) {
        $errors[] = "Company name is required";
    }
    
    if (empty($contact_person)) {
        $errors[] = "Contact person is required";
    }
    
    // Check if username or email already exists
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->fetchColumn() > 0) {
            $errors[] = "Username or email already exists";
        }
    }
    
    // If no errors, insert the new client
    if (empty($errors)) {
        try {
            $conn->beginTransaction();
            
            // Insert into users table
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, 'client')");
            $stmt->execute([$username, $hashed_password, $email]);
            $user_id = $conn->lastInsertId();
            
            // Insert into clients table
            $stmt = $conn->prepare("INSERT INTO clients (user_id, name, contact_person, phone, address) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$user_id, $company_name, $contact_person, $phone, $address]);
            
            $conn->commit();
            $success = true;
            
            // Clear the form after successful submission
            $username = $email = $company_name = $contact_person = $phone = $address = '';
            
        } catch (PDOException $e) {
            $conn->rollBack();
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
    <title>Add Client - Payment Status Platform</title>
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
            <h1 class="text-2xl font-bold">Add New Client</h1>
            <a href="../index.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>
        
        <?php if ($success): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline"> Client has been added successfully.</span>
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
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <form method="POST" action="">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Account Information -->
                    <div>
                        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Account Information</h2>
                        
                        <div class="mb-4">
                            <label for="username" class="block text-gray-700 font-medium mb-2">Username</label>
                            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" 
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
                            <input type="password" id="password" name="password"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            <p class="text-sm text-gray-500 mt-1">Minimum 6 characters</p>
                        </div>
                    </div>
                    
                    <!-- Client Information -->
                    <div>
                        <h2 class="text-lg font-semibold mb-4 border-b pb-2">Client Information</h2>
                        
                        <div class="mb-4">
                            <label for="company_name" class="block text-gray-700 font-medium mb-2">Company Name</label>
                            <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($company_name ?? ''); ?>"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="contact_person" class="block text-gray-700 font-medium mb-2">Contact Person</label>
                            <input type="text" id="contact_person" name="contact_person" value="<?php echo htmlspecialchars($contact_person ?? ''); ?>"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 font-medium mb-2">Phone</label>
                            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone ?? ''); ?>"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        </div>
                        
                        <div class="mb-4">
                            <label for="address" class="block text-gray-700 font-medium mb-2">Address</label>
                            <textarea id="address" name="address" rows="3"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"><?php echo htmlspecialchars($address ?? ''); ?></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg">
                        <i class="fas fa-user-plus mr-2"></i> Add Client
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