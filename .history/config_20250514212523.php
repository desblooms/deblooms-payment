 
<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

// Check if user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = $isLoggedIn && $_SESSION['user_type'] === 'admin';

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Get projects for display
$projects = [];
if ($isLoggedIn) {
    if ($isAdmin) {
        // Admin sees all projects
        $stmt = $conn->prepare("SELECT p.*, c.name as client_name FROM projects p 
                                LEFT JOIN clients c ON p.client_id = c.id
                                ORDER BY p.created_at DESC");
        $stmt->execute();
    } else {
        // Clients only see their own projects
        $stmt = $conn->prepare("SELECT p.* FROM projects p WHERE p.client_id = ? ORDER BY p.created_at DESC");
        $stmt->bindParam(1, $_SESSION['user_id']);
        $stmt->execute();
    }
    $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get stats for admin dashboard
$stats = [];
if ($isAdmin) {
    // Total projects
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM projects");
    $stmt->execute();
    $stats['total_projects'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Paid projects
    $stmt = $conn->prepare("SELECT COUNT(*) as paid FROM projects WHERE payment_status = 'paid'");
    $stmt->execute();
    $stats['paid_projects'] = $stmt->fetch(PDO::FETCH_ASSOC)['paid'];
    
    // Total clients
    $stmt = $conn->prepare("SELECT COUNT(*) as total FROM clients");
    $stmt->execute();
    $stats['total_clients'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-indigo-600 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="index.php" class="text-xl font-bold">Payment Platform</a>
            <div>
                <?php if ($isLoggedIn): ?>
                    <span class="mr-4">
                        Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 
                        (<?php echo $_SESSION['user_type'] === 'admin' ? 'Admin' : 'Client'; ?>)
                    </span>
                    <a href="index.php?logout=1" class="bg-indigo-700 hover:bg-indigo-800 px-4 py-2 rounded">
                        Logout
                    </a>
                <?php else: ?>
                    <a href="login.php" class="bg-indigo-700 hover:bg-indigo-800 px-4 py-2 rounded">
                        Login
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6">
        <?php if (!$isLoggedIn): ?>
            <!-- Welcome Screen -->
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <h1 class="text-3xl font-bold mb-4">Welcome to Payment Status Platform</h1>
                <p class="text-gray-600 mb-6">Please login to view your projects and payment status</p>
                <a href="login.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded">
                    Login Now
                </a>
            </div>
        <?php elseif ($isAdmin): ?>
            <!-- Admin Dashboard -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                                <i class="fas fa-clipboard-list text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Total Projects</p>
                                <p class="text-2xl font-semibold"><?php echo $stats['total_projects']; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-dollar-sign text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Paid Projects</p>
                                <p class="text-2xl font-semibold"><?php echo $stats['paid_projects']; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Total Clients</p>
                                <p class="text-2xl font-semibold"><?php echo $stats['total_clients']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">All Projects</h2>
                    <div>
                        <a href="add_project.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i> Add Project
                        </a>
                        <a href="add_client.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded inline-flex items-center ml-2">
                            <i class="fas fa-user-plus mr-2"></i> Add Client
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Project List -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($projects)): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No projects found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($projects as $project): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($project['name']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($project['description']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo htmlspecialchars($project['client_name']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        $<?php echo number_format($project['amount'], 2); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php 
                                            switch($project['payment_status']) {
                                                case 'paid':
                                                    echo 'bg-green-100 text-green-800';
                                                    break;
                                                case 'pending':
                                                    echo 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 'overdue':
                                                    echo 'bg-red-100 text-red-800';
                                                    break;
                                                default:
                                                    echo 'bg-gray-100 text-gray-800';
                                            }
                                        ?>">
                                            <?php echo ucfirst(htmlspecialchars($project['payment_status'])); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo date('M d, Y', strtotime($project['due_date'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="project_details.php?id=<?php echo $project['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="delete_project.php?id=<?php echo $project['id']; ?>" class="text-red-600 hover:text-red-900" 
                                           onclick="return confirm('Are you sure you want to delete this project?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <!-- Client Dashboard -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold mb-6">Your Projects</h1>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <?php
                    $totalProjects = count($projects);
                    $paidProjects = count(array_filter($projects, function($p) { return $p['payment_status'] === 'paid'; }));
                    $pendingProjects = count(array_filter($projects, function($p) { return $p['payment_status'] === 'pending'; }));
                    ?>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                                <i class="fas fa-clipboard-list text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Total Projects</p>
                                <p class="text-2xl font-semibold"><?php echo $totalProjects; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Paid Projects</p>
                                <p class="text-2xl font-semibold"><?php echo $paidProjects; ?></p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-gray-500">Pending Payments</p>
                                <p class="text-2xl font-semibold"><?php echo $pendingProjects; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Project List -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if (empty($projects)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No projects found</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($projects as $project): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($project['name']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($project['description']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        $<?php echo number_format($project['amount'], 2); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        <?php 
                                            switch($project['payment_status']) {
                                                case 'paid':
                                                    echo 'bg-green-100 text-green-800';
                                                    break;
                                                case 'pending':
                                                    echo 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 'overdue':
                                                    echo 'bg-red-100 text-red-800';
                                                    break;
                                                default:
                                                    echo 'bg-gray-100 text-gray-800';
                                            }
                                        ?>">
                                            <?php echo ucfirst(htmlspecialchars($project['payment_status'])); ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo date('M d, Y', strtotime($project['due_date'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="project_details.php?id=<?php echo $project['id']; ?>" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-4 shadow-inner mt-8">
        <div class="container mx-auto px-4 text-center text-gray-500 text-sm">
            &copy; <?php echo date('Y'); ?> Payment Status Platform. All rights reserved.
        </div>
    </footer>
</body>
</html>