<?php
session_start();
require_once '../config.php';
require_once '../functions.php';

// Check if user is logged in and is a client
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'client') {
    header('Location: ../login.php');
    exit;
}

// Get client projects
$stmt = $conn->prepare("SELECT * FROM projects WHERE client_id = ? ORDER BY created_at DESC");
$stmt->bindParam(1, $_SESSION['user_id']);
$stmt->execute();
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get client stats
$totalProjects = count($projects);
$paidProjects = count(array_filter($projects, function($p) { return $p['payment_status'] === 'paid'; }));
$pendingProjects = count(array_filter($projects, function($p) { return $p['payment_status'] === 'pending'; }));
$overdueProjects = count(array_filter($projects, function($p) { return $p['payment_status'] === 'overdue'; }));

// Total amount due
$totalDue = 0;
$totalPaid = 0;
foreach ($projects as $project) {
    if ($project['payment_status'] === 'pending' || $project['payment_status'] === 'overdue') {
        $totalDue += $project['amount'];
    } else if ($project['payment_status'] === 'paid') {
        $totalPaid += $project['amount'];
    }
}

// Get client details
$stmt = $conn->prepare("SELECT * FROM clients WHERE user_id = ?");
$stmt->bindParam(1, $_SESSION['user_id']);
$stmt->execute();
$client = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Dashboard - Payment Status Platform</title>
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
                    (Client)
                </span>
                <a href="../index.php?logout=1" class="bg-indigo-700 hover:bg-indigo-800 px-4 py-2 rounded">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-6">
        <!-- Client Dashboard -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold mb-6">Client Dashboard</h1>
            
            <!-- Client Info Card -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Account Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Company:</p>
                        <p class="font-medium"><?php echo htmlspecialchars($client['company_name'] ?? 'N/A'); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Contact Person:</p>
                        <p class="font-medium"><?php echo htmlspecialchars($client['contact_person'] ?? 'N/A'); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Email:</p>
                        <p class="font-medium"><?php echo htmlspecialchars($_SESSION['email'] ?? 'N/A'); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Phone:</p>
                        <p class="font-medium"><?php echo htmlspecialchars($client['phone'] ?? 'N/A'); ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
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
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <i class="fas fa-exclamation-circle text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500">Overdue Payments</p>
                            <p class="text-2xl font-semibold"><?php echo $overdueProjects; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Financial Summary -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h2 class="text-xl font-semibold mb-4">Financial Summary</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-500 mb-1">Total Amount Paid</p>
                        <p class="text-2xl font-bold text-green-600">$<?php echo number_format($totalPaid, 2); ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-500 mb-1">Total Amount Due</p>
                        <p class="text-2xl font-bold text-red-600">$<?php echo number_format($totalDue, 2); ?></p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-500 mb-1">Total Project Value</p>
                        <p class="text-2xl font-bold text-indigo-600">$<?php echo number_format($totalPaid + $totalDue, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Project List -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Your Projects</h2>
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
                                        <a href="../project_details.php?id=<?php echo $project['id']; ?>" class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i> View Details
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment History -->
        <div class="mb-6">
            <h2 class="text-xl font-semibold mb-4">Recent Payments</h2>
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <?php
                // Get recent payments
                $stmt = $conn->prepare("
                    SELECT p.*, pr.name as project_name 
                    FROM payments p 
                    JOIN projects pr ON p.project_id = pr.id 
                    WHERE pr.client_id = ? 
                    ORDER BY p.payment_date DESC 
                    LIMIT 5
                ");
                $stmt->bindParam(1, $_SESSION['user_id']);
                $stmt->execute();
                $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>

                <?php if (empty($payments)): ?>
                    <div class="px-6 py-4 text-center text-gray-500">No payment records found</div>
                <?php else: ?>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($payments as $payment): ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo htmlspecialchars($payment['project_name']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium text-green-600">
                                        $<?php echo number_format($payment['amount'], 2); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo date('M d, Y', strtotime($payment['payment_date'])); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo htmlspecialchars($payment['payment_method']); ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        <?php echo htmlspecialchars($payment['notes'] ?? 'N/A'); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
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