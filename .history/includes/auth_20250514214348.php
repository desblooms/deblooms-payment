 
<?php
/**
 * Utility Functions for Payment Status Platform
 */

/**
 * Sanitize input data to prevent XSS attacks
 * 
 * @param string $data The input to be sanitized
 * @return string Sanitized data
 */
function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * Validate email address format
 * 
 * @param string $email The email to validate
 * @return bool True if valid, false otherwise
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Flash message functionality
 * 
 * @param string $message The message to display
 * @param string $type The type of message (success, danger, warning, info)
 */
function setFlashMessage($message, $type = 'info') {
    $_SESSION['flash_message'] = $message;
    $_SESSION['flash_type'] = $type;
}

/**
 * Display flash message if available and then clear it
 */
function displayFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        $type = isset($_SESSION['flash_type']) ? $_SESSION['flash_type'] : 'info';
        $colorClass = 'bg-blue-100 text-blue-700'; // Default info style
        
        switch ($type) {
            case 'success':
                $colorClass = 'bg-green-100 text-green-700';
                break;
            case 'danger':
                $colorClass = 'bg-red-100 text-red-700';
                break;
            case 'warning':
                $colorClass = 'bg-yellow-100 text-yellow-700';
                break;
        }
        
        echo '<div class="' . $colorClass . ' px-4 py-3 rounded relative mb-4" role="alert">';
        echo '<span class="block sm:inline">' . $_SESSION['flash_message'] . '</span>';
        echo '</div>';
        
        // Clear the flash message
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_type']);
    }
}

/**
 * Check if user is logged in
 * 
 * @return bool True if logged in, false otherwise
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is an admin
 * 
 * @return bool True if admin, false otherwise
 */
function isAdmin() {
    return isLoggedIn() && $_SESSION['user_type'] === 'admin';
}

/**
 * Redirect to a specific page
 * 
 * @param string $location The location to redirect to
 */
function redirect($location) {
    header("Location: $location");
    exit;
}

/**
 * Get project status class for Tailwind CSS
 * 
 * @param string $status The project status
 * @return string CSS class
 */
function getStatusClass($status) {
    switch($status) {
        case 'paid':
            return 'bg-green-100 text-green-800';
        case 'pending':
            return 'bg-yellow-100 text-yellow-800';
        case 'overdue':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
}

/**
 * Format currency
 * 
 * @param float $amount The amount to format
 * @return string Formatted amount
 */
function formatCurrency($amount) {
    return '$' . number_format($amount, 2);
}

/**
 * Calculate remaining balance for a project
 * 
 * @param float $total_amount The total project amount
 * @param float $paid_amount The amount already paid
 * @return float Remaining balance
 */
function calculateRemainingBalance($total_amount, $paid_amount) {
    return max(0, $total_amount - $paid_amount);
}

/**
 * Check if a project is overdue
 * 
 * @param string $due_date The due date
 * @return bool True if overdue, false otherwise
 */
function isOverdue($due_date) {
    $today = new DateTime();
    $due = new DateTime($due_date);
    return $today > $due;
}

/**
 * Update project status based on payment and due date
 * 
 * @param int $project_id The project ID
 * @param PDO $conn Database connection
 */
function updateProjectStatus($project_id, $conn) {
    // Get project info
    $stmt = $conn->prepare("SELECT p.total_amount, p.end_date, 
                          COALESCE(SUM(pm.amount), 0) as paid_amount 
                          FROM projects p 
                          LEFT JOIN payments pm ON p.id = pm.project_id 
                          WHERE p.id = ?
                          GROUP BY p.id");
    $stmt->execute([$project_id]);
    $project = $stmt->fetch();
    
    if ($project) {
        $status = 'pending';
        
        // If fully paid, mark as paid
        if ($project['paid_amount'] >= $project['total_amount']) {
            $status = 'paid';
        } 
        // If past due date and not fully paid, mark as overdue
        else if (isOverdue($project['end_date'])) {
            $status = 'overdue';
        }
        
        // Update status in database
        $updateStmt = $conn->prepare("UPDATE projects SET payment_status = ? WHERE id = ?");
        $updateStmt->execute([$status, $project_id]);
    }
}