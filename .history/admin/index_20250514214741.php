 
<?php
session_start();
require_once '../config.php';
require_once '../functions.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ../index.php');
    exit;
}

// Get all projects for admin dashboard
$stmt = $conn->prepare("SELECT p.*, c.name as client_name FROM projects p 
                        LEFT JOIN clients c ON p.client_id = c.id
                        ORDER BY p.created_at DESC");
$stmt->execute();
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get stats for admin dashboard
// Total projects
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM projects");
$stmt->execute();
$total_projects = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Paid projects
$stmt = $conn->prepare("SELECT COUNT(*) as paid FROM projects WHERE payment_status = 'paid'");
$stmt->execute();
$paid_projects = $stmt->fetch(PDO::FETCH_ASSOC)['paid'];

// Pending projects
$stmt = $conn->prepare("SELECT COUNT(*) as pending FROM projects WHERE payment_status = 'pending'");
$stmt->execute();
$pending_projects = $stmt->fetch(PDO::FETCH_ASSOC)['pending'];

// Overdue projects
$stmt = $conn->prepare("SELECT COUNT(*) as overdue FROM projects WHERE payment_status = 'overdue'");
$stmt->execute();
$overdue_projects = $stmt->fetch(PDO::FETCH_ASSOC)['overdue'];

// Total clients
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM clients");
$stmt->execute();
$total_clients = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Total revenue
$stmt = $conn->prepare("SELECT SUM(amount) as total FROM projects WHERE payment_status = 'paid'");
$stmt->execute();
$total_revenue = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?: 0;

// Pending revenue
$stmt = $conn->prepare("SELECT SUM(amount) as total FROM projects WHERE payment_status IN ('pending', 'overdue')");
$stmt->execute();
$pending_revenue = $stmt->fetch(PDO::FETCH_ASSOC)['total'] ?: 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Payment Status Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-indigo-700 text-white shadow-lg">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="../index.php" class="text-xl font-bold">Payment Platform</a>
            <div class="flex items-center">
                <a href="add_client.php" class="bg-indigo-600 hover:bg-indigo-800 px-3 py-2 rounded mr-2">
                    <i class="fas fa-user-plus mr-1"></i> Add Client
                </a>
                <a href="add_project.php" class="bg-indigo-600 hover:bg-indigo-800 px-3 py-2 rounded mr-4">
                    <i class="fas fa-plus mr-1"></i> Add Project
                </a>
                <span class="mr-4">
                    Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> (Admin)
                </span>
                <a href="../index.php?logout=1" class="bg-indigo-800 hover:bg-indigo-900 px-4 py-2 rounded">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar and Main Content -->
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-indigo-800 text-white min-h-screen px-4 py-6">
            <div class="mb-8">
                <h2 class="text-lg font-semibold mb-4">Admin Menu</h2>
                <ul>
                    <li class="mb-2">
                        <a href="index.php" class="flex items-center py-2 px-4 bg-indigo-900 rounded">
                            <i class="fas fa-tachometer-alt mr-3"></i> Dashboard
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="projects.php" class="flex items-center py-2 px-4 hover:bg-indigo-700 rounded">
                            <i class="fas fa-project-diagram mr-3"></i> Projects
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="clients.php" class="flex items-center py-2 px-4 hover:bg-indigo-700 rounded">
                            <i class="fas fa-users mr-3"></i> Clients
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="payments.php" class="flex items-center py-2 px-4 hover:bg-indigo-700 rounded">
                            <i class="fas fa-money-bill-wave mr-3"></i> Payments
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="reports.php" class="flex items-center py-2 px-4 hover:bg-indigo-700 rounded">
                            <i class="fas fa-chart-bar mr-3"></i> Reports
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="settings.php" class="flex items-center py-2 px-4 hover:bg-indigo-700 rounded">
                            <i class="fas fa-cog mr-3"></i> Settings
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600">
                            <i class="fas fa-clipboard-list text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500">Total Projects</p>
                            <p class="text-2xl font-semibold"><?php echo $total_projects; ?></p>
                        </div>
                    </div>
                    <div class="mt-4 flex justify-between text-sm">
                        <div>
                            <span class="text-green-500 font-semibold"><?php echo $paid_projects; ?></span> Paid
                        </div>
                        <div>
                            <span class="text-yellow-500 font-semibold"><?php echo $pending_projects; ?></span> Pending
                        </div>
                        <div>
                            <span class="text-red-500 font-semibold"><?php echo $overdue_projects; ?></span> Overdue
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <i class="fas fa-dollar-sign text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500">Total Revenue</p>
                            <p class="text-2xl font-semibold">$<?php echo number_format($total_revenue, 2); ?></p>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <div class="text-gray-500">
                            Pending: <span class="text-yellow-500 font-semibold">$<?php echo number_format($pending_revenue, 2); ?></span>
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
                            <p class="text-2xl font-semibold"><?php echo $total_clients; ?></p>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <a href="clients.php" class="text-blue-500 hover:text-blue-700">View all clients <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <i class="fas fa-exclamation-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500">Overdue Payments</p>
                            <p class="text-2xl font-semibold"><?php echo $overdue_projects; ?></p>
                        </div>
                    </div>
                    <div class="mt-4 text-sm">
                        <a href="overdue.php" class="text-red-500 hover:text-red-700">View overdue projects <i class="fas fa-arrow-right ml-1"></i></a>
                    </div>
                </div>
            </div>

            <!-- Recent Projects -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="flex justify-between items-center p-4 border-b">
                    <h2 class="text-lg font-semibold">Recent Projects</h2>
                    <a href="projects.php" class="text-blue-600 hover:text-blue-800 text-sm">View All <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
                
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
                            <?php 
                            // Display only the 5 most recent projects
                            $recent_projects = array_slice($projects, 0, 5);
                            foreach ($recent_projects as $project): 
                            ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($project['name']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars(substr($project['description'], 0, 30)); ?><?php echo (strlen($project['description']) > 30) ? '...' : ''; ?></div>
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
                                        <a href="../project_details.php?id=<?php echo $project['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-3">
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

            <!-- Quick Actions & Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Quick Actions</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <a href="add_project.php" class="flex items-center p-4 bg-indigo-50 rounded-lg hover:bg-indigo-100">
                            <div class="rounded-full p-2 bg-indigo-200 mr-3">
                                <i class="fas fa-plus text-indigo-600"></i>
                            </div>
                            <span>New Project</span>
                        </a>
                        <a href="add_client.php" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100">
                            <div class="rounded-full p-2 bg-blue-200 mr-3">
                                <i class="fas fa-user-plus text-blue-600"></i>
                            </div>
                            <span>New Client</span>
                        </a>
                        <a href="record_payment.php" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100">
                            <div class="rounded-full p-2 bg-green-200 mr-3">
                                <i class="fas fa-money-bill-wave text-green-600"></i>
                            </div>
                            <span>Record Payment</span>
                        </a>
                        <a href="generate_invoice.php" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100">
                            <div class="rounded-full p-2 bg-yellow-200 mr-3">
                                <i class="fas fa-file-invoice text-yellow-600"></i>
                            </div>
                            <span>New Invoice</span>
                        </a>
                    </div>
                </div>
                
                <!-- Recent Activity (Placeholder) -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Recent Activity</h2>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 rounded-full p-2 bg-green-100 mr-3">
                                <i class="fas fa-check text-green-600"></i>
                            </div>
                            <div>
                                <p class="text-sm">Payment recorded for <span class="font-medium">Website Redesign</span></p>
                                <p class="text-xs text-gray-500">Today, 10:30 AM</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 rounded-full p-2 bg-blue-100 mr-3">
                                <i class="fas fa-user text-blue-600"></i>
                            </div>
                            <div>
                                <p class="text-sm">New client <span class="font-medium">Acme Corp</span> added</p>
                                <p class="text-xs text-gray-500">Yesterday, 3:45 PM</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 rounded-full p-2 bg-yellow-100 mr-3">
                                <i class="fas fa-exclamation text-yellow-600"></i>
                            </div>
                            <div>
                                <p class="text-sm">Project <span class="font-medium">Mobile App Development</span> is due soon</p>
                                <p class="text-xs text-gray-500">Yesterday, 1:15 PM</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 rounded-full p-2 bg-red-100 mr-3">
                                <i class="fas fa-exclamation-triangle text-red-600"></i>
                            </div>
                            <div>
                                <p class="text-sm">Payment for <span class="font-medium">E-commerce Integration</span> is overdue</p>
                                <p class="text-xs text-gray-500">May 12, 2025</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <a href="activity.php" class="text-indigo-600 hover:text-indigo-800 text-sm">View all activity</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white py-4 shadow-inner mt-8 text-center text-gray-500 text-sm">
        &copy; <?php echo date('Y'); ?> Desblooms. All rights reserved.
    </footer>

    <!-- Scripts -->
    <script src="../assets/js/app.js"></script>
</body>
</html>