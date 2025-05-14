<?php
/**
 * Project Details Page for Admin
 * 
 * Shows detailed information about a specific project including:
 * - Project information
 * - Client details
 * - Payment history
 * - Invoice details
 */

session_start();
require_once '../config.php';
require_once '../includes/functions.php';
require_once '../includes/auth.php';

// Check if user is logged in and is admin
if (!isLoggedIn() || !isAdmin()) {
    setFlashMessage('Unauthorized access. Admin privileges required.', 'danger');
    redirect('../login.php');
}

// Check if project ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    setFlashMessage('Invalid project ID', 'danger');
    redirect('dashboard.php');
}

$project_id = (int)$_GET['id'];

// Get project details
$stmt = $conn->prepare("
    SELECT p.*, c.name as client_name, c.email as client_email, c.phone as client_phone, c.address as client_address
    FROM projects p
    JOIN clients c ON p.client_id = c.id
    WHERE p.id = ?
");
$stmt->execute([$project_id]);
$project = $stmt->fetch();

// Check if project exists
if (!$project) {
    setFlashMessage('Project not found', 'danger');
    redirect('dashboard.php');
}

// Get payment history
$stmt = $conn->prepare("
    SELECT * FROM payments 
    WHERE project_id = ? 
    ORDER BY payment_date DESC
");
$stmt->execute([$project_id]);
$payments = $stmt->fetchAll();

// Calculate payment statistics
$total_paid = 0;
foreach ($payments as $payment) {
    $total_paid += $payment['amount'];
}
$remaining_balance = $project['amount'] - $total_paid;
$payment_percentage = ($project['amount'] > 0) ? ($total_paid / $project['amount'] * 100) : 0;

// Get invoice details
$stmt = $conn->prepare("
    SELECT * FROM invoices 
    WHERE project_id = ? 
    ORDER BY issue_date DESC
");
$stmt->execute([$project_id]);
$invoices = $stmt->fetchAll();

// Include header
include_once '../includes/header.php';
?>

<!-- Main Content -->
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Project Details</h1>
        <div>
            <a href="projects.php" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded inline-flex items-center mr-2">
                <i class="fas fa-arrow-left mr-2"></i> Back to Projects
            </a>
            <a href="edit_project.php?id=<?php echo $project['id']; ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded inline-flex items-center">
                <i class="fas fa-edit mr-2"></i> Edit Project
            </a>
        </div>
    </div>
    
    <!-- Project Overview Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-xl font-semibold mb-2"><?php echo htmlspecialchars($project['name']); ?></h2>
                <p class="text-gray-500 mb-4">Project #<?php echo $project['id']; ?></p>
            </div>
            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                <?php echo getStatusClass($project['payment_status']); ?>">
                <?php echo ucfirst(htmlspecialchars($project['payment_status'])); ?>
            </span>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            <!-- Project Information -->
            <div>
                <h3 class="text-lg font-semibold mb-3 border-b pb-2">Project Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600">Start Date:</p>
                        <p class="font-medium"><?php echo $project['start_date'] ? date('M d, Y', strtotime($project['start_date'])) : 'N/A'; ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Due Date:</p>
                        <p class="font-medium"><?php echo date('M d, Y', strtotime($project['due_date'])); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Total Amount:</p>
                        <p class="font-medium"><?php echo formatCurrency($project['amount']); ?></p>
                    </div>
                    <div>
                        <p class="text-gray-600">Created:</p>
                        <p class="font-medium"><?php echo date('M d, Y', strtotime($project['created_at'])); ?></p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <p class="text-gray-600">Description:</p>
                    <p><?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                </div>
            </div>
            
            <!-- Client Information -->
            <div>
                <h3 class="text-lg font-semibold mb-3 border-b pb-2">Client Information</h3>
                <div class="mb-3">
                    <p class="text-gray-600">Client:</p>
                    <p class="font-medium"><?php echo htmlspecialchars($project['client_name']); ?></p>
                </div>
                <div class="mb-3">
                    <p class="text-gray-600">Email:</p>
                    <p class="font-medium"><?php echo htmlspecialchars($project['client_email']); ?></p>
                </div>
                <div class="mb-3">
                    <p class="text-gray-600">Phone:</p>
                    <p class="font-medium"><?php echo htmlspecialchars($project['client_phone'] ?? 'N/A'); ?></p>
                </div>
                <div>
                    <p class="text-gray-600">Address:</p>
                    <p><?php echo nl2br(htmlspecialchars($project['client_address'] ?? 'N/A')); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Payment Progress -->
        <div class="mb-4">
            <h3 class="text-lg font-semibold mb-3 border-b pb-2">Payment Progress</h3>
            <div class="flex justify-between mb-2">
                <span>Payment Status: <?php echo round($payment_percentage, 2); ?>% Complete</span>
                <span>
                    <?php echo formatCurrency($total_paid); ?> of <?php echo formatCurrency($project['amount']); ?>
                </span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-4">
                <div class="bg-indigo-600 h-4 rounded-full" style="width: <?php echo min(100, $payment_percentage); ?>%"></div>
            </div>
            <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-green-50 p-3 rounded-lg">
                    <p class="text-gray-600">Total Paid:</p>
                    <p class="text-xl font-semibold text-green-600"><?php echo formatCurrency($total_paid); ?></p>
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <p class="text-gray-600">Remaining Balance:</p>
                    <p class="text-xl font-semibold text-yellow-600"><?php echo formatCurrency($remaining_balance); ?></p>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <p class="text-gray-600">Total Amount:</p>
                    <p class="text-xl font-semibold text-blue-600"><?php echo formatCurrency($project['amount']); ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Payment History Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Payment History</h3>
            <a href="add_payment.php?project_id=<?php echo $project_id; ?>" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded inline-flex items-center">
                <i class="fas fa-plus mr-2"></i> Add Payment
            </a>
        </div>
        
        <?php if (empty($payments)): ?>
            <div class="text-center py-6 text-gray-500">
                <i class="fas fa-money-bill-wave text-4xl mb-2"></i>
                <p>No payments recorded yet.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Transaction ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($payments as $payment): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo date('M d, Y', strtotime($payment['payment_date'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                    <?php echo formatCurrency($payment['amount']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($payment['payment_method'] ?? 'N/A'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo htmlspecialchars($payment['transaction_id'] ?? 'N/A'); ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php echo htmlspecialchars($payment['notes'] ?? 'N/A'); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="edit_payment.php?id=<?php echo $payment['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete_payment.php?id=<?php echo $payment['id']; ?>&project_id=<?php echo $project_id; ?>" 
                                       class="text-red-600 hover:text-red-900"
                                       onclick="return confirm('Are you sure you want to delete this payment?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Invoices Card -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold">Invoices</h3>
            <a href="create_invoice.php?project_id=<?php echo $project_id; ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded inline-flex items-center">
                <i class="fas fa-file-invoice mr-2"></i> Create Invoice
            </a>
        </div>
        
        <?php if (empty($invoices)): ?>
            <div class="text-center py-6 text-gray-500">
                <i class="fas fa-file-invoice text-4xl mb-2"></i>
                <p>No invoices created yet.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice #</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($invoices as $invoice): ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <?php echo htmlspecialchars($invoice['invoice_number']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo date('M d, Y', strtotime($invoice['issue_date'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo date('M d, Y', strtotime($invoice['due_date'])); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo formatCurrency($invoice['total_amount']); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    <?php echo getStatusClass($invoice['status']); ?>">
                                        <?php echo ucfirst(htmlspecialchars($invoice['status'])); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="view_invoice.php?id=<?php echo $invoice['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-3">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="edit_invoice.php?id=<?php echo $invoice['id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="delete_invoice.php?id=<?php echo $invoice['id']; ?>&project_id=<?php echo $project_id; ?>" 
                                       class="text-red-600 hover:text-red-900"
                                       onclick="return confirm('Are you sure you want to delete this invoice?');">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Action Buttons -->
    <div class="flex justify-end space-x-4">
        <a href="edit_project.php?id=<?php echo $project_id; ?>" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded inline-flex items-center">
            <i class="fas fa-edit mr-2"></i> Edit Project
        </a>
        <a href="delete_project.php?id=<?php echo $project_id; ?>" 
           class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded inline-flex items-center"
           onclick="return confirm('Are you sure you want to delete this project? This will also delete all associated payments and invoices.');">
            <i class="fas fa-trash-alt mr-2"></i> Delete Project
        </a>
    </div>
</div>

<?php
// Include footer
include_once '../includes/footer.php';
?>