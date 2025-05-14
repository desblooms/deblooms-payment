 
<?php
session_start();
require_once '../config.php';
require_once '../includes/functions.php'; // Change this line from '../functions.php'



// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Get stats for admin dashboard
$stats = [];

// Total projects
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM projects");
$stmt->execute();
$stats['total_projects'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Paid projects
$stmt = $conn->prepare("SELECT COUNT(*) as paid FROM projects WHERE payment_status = 'paid'");
$stmt->execute();
$stats['paid_projects'] = $stmt->fetch(PDO::FETCH_ASSOC)['paid'];

// Pending projects
$stmt = $conn->prepare("SELECT COUNT(*) as pending FROM projects WHERE payment_status = 'pending'");
$stmt->execute();
$stats['pending_projects'] = $stmt->fetch(PDO::FETCH_ASSOC)['pending'];

// Overdue projects
$stmt = $conn->prepare("SELECT COUNT(*) as overdue FROM projects WHERE payment_status = 'overdue'");
$stmt->execute();
$stats['overdue_projects'] = $stmt->fetch(PDO::FETCH_ASSOC)['overdue'];

// Total clients
$stmt = $conn->prepare("SELECT COUNT(*) as total FROM clients");
$stmt->execute();
$stats['total_clients'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

// Get all projects with client info
$stmt = $conn->prepare("SELECT p.*, c.name as client_name FROM projects p 
                        LEFT JOIN clients c ON p.client_id = c.id
                        ORDER BY p.created_at DESC");
$stmt->execute();
$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get revenue stats
$stmt = $conn->prepare("SELECT SUM(total_amount) as total_revenue FROM projects");
$stmt->execute();
$totalRevenue = $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'] ?? 0;

$stmt = $conn->prepare("SELECT SUM(total_amount) as paid_revenue FROM projects WHERE payment_status = 'paid'");
$stmt->execute();
$paidRevenue = $stmt->fetch(PDO::FETCH_ASSOC)['paid_revenue'] ?? 0;

$stmt = $conn->prepare("SELECT SUM(total_amount) as pending_revenue FROM projects WHERE payment_status = 'pending'");
$stmt->execute();
$pendingRevenue = $stmt->fetch(PDO::FETCH_ASSOC)['pending_revenue'] ?? 0;

// Include header
include_once '../includes/header.php';
?>

<!-- Main Content -->
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Admin Dashboard</h1>
            <div>
                <a href="add_client.php" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded inline-flex items-center mr-2">
                    <i class="fas fa-user-plus mr-2"></i> Add Client
                </a>
                <a href="add_project.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded inline-flex items-center">
                    <i class="fas fa-plus mr-2"></i> Add Project
                </a>
            </div>
        </div>
        
        <!-- Dashboard Cards -->
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
        
        <!-- Revenue Stats -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Revenue Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <p class="text-gray-500">Total Revenue</p>
                    <p class="text-2xl font-semibold text-indigo-600">$<?php echo number_format($totalRevenue, 2); ?></p>
                </div>
                <div>
                    <p class="text-gray-500">Collected Revenue</p>
                    <p class="text-2xl font-semibold text-green-600">$<?php echo number_format($paidRevenue, 2); ?></p>
                </div>
                <div>
                    <p class="text-gray-500">Pending Revenue</p>
                    <p class="text-2xl font-semibold text-yellow-600">$<?php echo number_format($pendingRevenue, 2); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Project Status Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500">Paid</p>
                        <p class="text-2xl font-semibold"><?php echo $stats['paid_projects']; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <i class="fas fa-clock text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500">Pending</p>
                        <p class="text-2xl font-semibold"><?php echo $stats['pending_projects']; ?></p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-red-100 text-red-600">
                        <i class="fas fa-exclamation-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500">Overdue</p>
                        <p class="text-2xl font-semibold"><?php echo $stats['overdue_projects']; ?></p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Recent Projects -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">All Projects</h2>
                <a href="all_projects.php" class="text-indigo-600 hover:text-indigo-800">View All</a>
            </div>
            
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
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($project['project_name']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars(substr($project['description'], 0, 50)) . (strlen($project['description']) > 50 ? '...' : ''); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo htmlspecialchars($project['client_name']); ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        $<?php echo number_format($project['total_amount'], 2); ?>
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
                                        <?php echo date('M d, Y', strtotime($project['end_date'])); ?>
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
        </div>
        
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Recent Clients -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Recent Clients</h2>
                    <a href="all_clients.php" class="text-indigo-600 hover:text-indigo-800 text-sm">View All</a>
                </div>
                
                <?php
                // Get recent clients
                $stmt = $conn->prepare("SELECT * FROM clients ORDER BY created_at DESC LIMIT 5");
                $stmt->execute();
                $recentClients = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                
                <?php if (empty($recentClients)): ?>
                    <p class="text-gray-500 text-center py-4">No clients found</p>
                <?php else: ?>
                    <ul class="divide-y divide-gray-200">
                        <?php foreach ($recentClients as $client): ?>
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($client['company_name']); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($client['contact_person']); ?></p>
                                </div>
                                <a href="client_details.php?id=<?php echo $client['id']; ?>" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            
            <!-- Recent Payments -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Recent Payments</h2>
                    <a href="all_payments.php" class="text-indigo-600 hover:text-indigo-800 text-sm">View All</a>
                </div>
                
                <?php
                // Get recent payments
                $stmt = $conn->prepare("SELECT pa.*, pr.project_name 
                                        FROM payments pa
                                        JOIN projects pr ON pa.project_id = pr.id
                                        ORDER BY pa.payment_date DESC LIMIT 5");
                $stmt->execute();
                $recentPayments = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                
                <?php if (empty($recentPayments)): ?>
                    <p class="text-gray-500 text-center py-4">No payments found</p>
                <?php else: ?>
                    <ul class="divide-y divide-gray-200">
                        <?php foreach ($recentPayments as $payment): ?>
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <p class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($payment['project_name']); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo date('M d, Y', strtotime($payment['payment_date'])); ?></p>
                                </div>
                                <div class="text-sm font-medium text-green-600">
                                    $<?php echo number_format($payment['amount'], 2); ?>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
include_once '../includes/footer.php';
?>