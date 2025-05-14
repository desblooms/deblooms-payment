<?php
/**
 * Utility Functions
 * 
 * Core utility functions for the PayTrack application
 * Handles common operations across the application
 */

// Make sure we have a session started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Get base URL path for the application
 * 
 * @return string The base URL path
 */
function getBasePath() {
    $path = dirname($_SERVER['PHP_SELF']);
    
    if (strpos($path, '/admin') !== false) {
        return '..';
    } elseif (strpos($path, '/client') !== false) {
        return '..';
    } else {
        return '.';
    }
}

/**
 * Check if the current page matches the given page name
 * Used for highlighting active navigation items
 * 
 * @param string $pageName The page name to check against
 * @return bool True if current page matches, false otherwise
 */
function isCurrentPage($pageName) {
    return basename($_SERVER['PHP_SELF']) === $pageName;
}

/**
 * Format a date to a readable format
 * 
 * @param string $date The date string to format
 * @param string $format The format to use (default: 'M d, Y')
 * @return string The formatted date
 */
function formatDate($date, $format = 'M d, Y') {
    if (empty($date)) return 'N/A';
    
    $dateObj = new DateTime($date);
    return $dateObj->format($format);
}

/**
 * Format a currency amount
 * 
 * @param float $amount The amount to format
 * @param string $currency The currency symbol (default: '$')
 * @return string The formatted amount
 */
function formatCurrency($amount, $currency = '$') {
    if ($amount === null) return 'N/A';
    
    return $currency . number_format($amount, 2, '.', ',');
}

/**
 * Calculate the percentage of a value against a total
 * 
 * @param float $value The value
 * @param float $total The total
 * @return int The percentage (rounded to nearest integer)
 */
function calculatePercentage($value, $total) {
    if ($total == 0) return 0;
    
    return round(($value / $total) * 100);
}

/**
 * Generate a unique ID for various purposes
 * 
 * @param string $prefix The prefix for the ID (default: '')
 * @return string The generated ID
 */
function generateUniqueId($prefix = '') {
    return uniqid($prefix) . bin2hex(random_bytes(8));
}

/**
 * Get project status as a string and corresponding color class
 * 
 * @param string $status The status code
 * @return array Array containing status text and color class
 */
function getProjectStatus($status) {
    switch ($status) {
        case 'not_started':
            return [
                'text' => 'Not Started',
                'color' => 'text-gray-400',
                'bg' => 'bg-gray-800',
                'badge' => 'border-gray-600'
            ];
        case 'in_progress':
            return [
                'text' => 'In Progress',
                'color' => 'text-blue-400',
                'bg' => 'bg-blue-900/30',
                'badge' => 'border-blue-600'
            ];
        case 'on_hold':
            return [
                'text' => 'On Hold',
                'color' => 'text-yellow-400',
                'bg' => 'bg-yellow-900/30',
                'badge' => 'border-yellow-600'
            ];
        case 'completed':
            return [
                'text' => 'Completed',
                'color' => 'text-green-400',
                'bg' => 'bg-green-900/30',
                'badge' => 'border-green-600'
            ];
        case 'cancelled':
            return [
                'text' => 'Cancelled',
                'color' => 'text-red-400',
                'bg' => 'bg-red-900/30',
                'badge' => 'border-red-600'
            ];
        default:
            return [
                'text' => 'Unknown',
                'color' => 'text-gray-400',
                'bg' => 'bg-gray-800',
                'badge' => 'border-gray-600'
            ];
    }
}

/**
 * Get payment status as a string and corresponding color class
 * 
 * @param string $status The status code
 * @return array Array containing status text and color class
 */
function getPaymentStatus($status) {
    switch ($status) {
        case 'paid':
            return [
                'text' => 'Paid',
                'color' => 'text-green-400',
                'bg' => 'bg-green-900/30',
                'badge' => 'border-green-600'
            ];
        case 'pending':
            return [
                'text' => 'Pending',
                'color' => 'text-yellow-400',
                'bg' => 'bg-yellow-900/30',
                'badge' => 'border-yellow-600'
            ];
        case 'overdue':
            return [
                'text' => 'Overdue',
                'color' => 'text-red-400',
                'bg' => 'bg-red-900/30',
                'badge' => 'border-red-600'
            ];
        case 'cancelled':
            return [
                'text' => 'Cancelled',
                'color' => 'text-gray-400',
                'bg' => 'bg-gray-800',
                'badge' => 'border-gray-600'
            ];
        case 'refunded':
            return [
                'text' => 'Refunded',
                'color' => 'text-purple-400',
                'bg' => 'bg-purple-900/30',
                'badge' => 'border-purple-600'
            ];
        default:
            return [
                'text' => 'Unknown',
                'color' => 'text-gray-400',
                'bg' => 'bg-gray-800',
                'badge' => 'border-gray-600'
            ];
    }
}

/**
 * Create a status badge HTML
 * 
 * @param string $text The status text
 * @param string $colorClass The color class
 * @param string $bgClass The background color class
 * @param string $badgeClass The badge class
 * @return string The HTML for the status badge
 */
function createStatusBadge($text, $colorClass, $bgClass, $badgeClass) {
    return '<span class="px-2 py-1 text-xs rounded-full ' . $bgClass . ' ' . $colorClass . ' border ' . $badgeClass . '">' . $text . '</span>';
}

/**
 * Truncate text to a specific length
 * 
 * @param string $text The text to truncate
 * @param int $length The maximum length
 * @param string $append The string to append if truncated
 * @return string The truncated text
 */
function truncateText($text, $length = 50, $append = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    return substr($text, 0, $length) . $append;
}

/**
 * Get time ago in a human-readable format
 * 
 * @param string $datetime The date/time to format
 * @return string The time ago string
 */
function timeAgo($datetime) {
    $time = strtotime($datetime);
    $now = time();
    $diff = $now - $time;
    
    if ($diff < 60) {
        return $diff . ' seconds ago';
    } elseif ($diff < 3600) {
        return floor($diff / 60) . ' minutes ago';
    } elseif ($diff < 86400) {
        return floor($diff / 3600) . ' hours ago';
    } elseif ($diff < 604800) {
        return floor($diff / 86400) . ' days ago';
    } elseif ($diff < 2592000) {
        return floor($diff / 604800) . ' weeks ago';
    } elseif ($diff < 31536000) {
        return floor($diff / 2592000) . ' months ago';
    } else {
        return floor($diff / 31536000) . ' years ago';
    }
}

/**
 * Check if a date is in the past
 * 
 * @param string $date The date to check
 * @return bool True if date is in the past, false otherwise
 */
function isDatePast($date) {
    $date = new DateTime($date);
    $now = new DateTime();
    
    return $date < $now;
}

/**
 * Check if a date is within a certain number of days
 * 
 * @param string $date The date to check
 * @param int $days The number of days
 * @return bool True if date is within the days, false otherwise
 */
function isDateWithinDays($date, $days) {
    $date = new DateTime($date);
    $now = new DateTime();
    $interval = $now->diff($date);
    
    return $interval->days <= $days && $date >= $now;
}

/**
 * Display a flash message
 * 
 * @param string $type The type of message (success, error, warning, info)
 * @param string $message The message text
 * @return string The HTML for the flash message
 */
function displayFlashMessage($type, $message) {
    $icon = '';
    $colorClass = '';
    $bgClass = '';
    
    switch ($type) {
        case 'success':
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>';
            $colorClass = 'text-green-400';
            $bgClass = 'bg-green-900/30 border-green-600';
            break;
        case 'error':
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>';
            $colorClass = 'text-red-400';
            $bgClass = 'bg-red-900/30 border-red-600';
            break;
        case 'warning':
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>';
            $colorClass = 'text-yellow-400';
            $bgClass = 'bg-yellow-900/30 border-yellow-600';
            break;
        case 'info':
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
            $colorClass = 'text-blue-400';
            $bgClass = 'bg-blue-900/30 border-blue-600';
            break;
        default:
            $icon = '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
            $colorClass = 'text-gray-400';
            $bgClass = 'bg-gray-800 border-gray-600';
    }
    
    return '
    <div class="flex items-center p-4 mb-6 rounded-lg border ' . $bgClass . ' ' . $colorClass . ' backdrop-blur-sm">
        <div class="flex-shrink-0 mr-3">
            ' . $icon . '
        </div>
        <div class="flex-1">
            <p class="font-medium">' . $message . '</p>
        </div>
        <button type="button" class="ml-auto focus:outline-none" onclick="this.parentElement.remove();">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>';
}

/**
 * Get a list of payment methods
 * 
 * @return array Array of payment methods
 */
function getPaymentMethods() {
    return [
        'credit_card' => 'Credit Card',
        'bank_transfer' => 'Bank Transfer',
        'paypal' => 'PayPal',
        'cash' => 'Cash',
        'check' => 'Check',
        'stripe' => 'Stripe',
        'other' => 'Other'
    ];
}

/**
 * Create a glassmorphism card
 * 
 * @param string $title The card title
 * @param string $content The card content
 * @param string $additionalClass Additional CSS classes
 * @return string The HTML for the glassmorphism card
 */
function createGlassCard($title, $content, $additionalClass = '') {
    return '
    <div class="bg-[#26002b]/50 backdrop-blur-sm rounded-xl p-6 shadow-lg border border-[#810041]/20 mb-6 ' . $additionalClass . '">
        ' . ($title ? '<h3 class="text-xl font-semibold mb-4 text-white">' . $title . '</h3>' : '') . '
        <div>
            ' . $content . '
        </div>
    </div>';
}

/**
 * Generate pagination HTML
 * 
 * @param int $currentPage The current page number
 * @param int $totalPages The total number of pages
 * @param string $baseUrl The base URL for pagination links
 * @return string The HTML for pagination
 */
function generatePagination($currentPage, $totalPages, $baseUrl) {
    if ($totalPages <= 1) {
        return '';
    }
    
    $html = '<div class="flex justify-center mt-6 gap-1">';
    
    // Previous page link
    if ($currentPage > 1) {
        $html .= '<a href="' . $baseUrl . '?page=' . ($currentPage - 1) . '" class="px-3 py-2 rounded-md text-gray-400 hover:text-[#f2ab8b] hover:bg-[#810041]/20">';
        $html .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">';
        $html .= '<path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />';
        $html .= '</svg>';
        $html .= '</a>';
    } else {
        $html .= '<span class="px-3 py-2 rounded-md text-gray-600">';
        $html .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">';
        $html .= '<path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />';
        $html .= '</svg>';
        $html .= '</span>';
    }
    
    // Page number links
    $startPage = max(1, $currentPage - 2);
    $endPage = min($totalPages, $currentPage + 2);
    
    if ($startPage > 1) {
        $html .= '<a href="' . $baseUrl . '?page=1" class="px-3 py-2 rounded-md text-gray-400 hover:text-[#f2ab8b] hover:bg-[#810041]/20">1</a>';
        if ($startPage > 2) {
            $html .= '<span class="px-3 py-2 text-gray-400">...</span>';
        }
    }
    
    for ($i = $startPage; $i <= $endPage; $i++) {
        if ($i == $currentPage) {
            $html .= '<span class="px-3 py-2 rounded-md bg-[#810041] text-white">' . $i . '</span>';
        } else {
            $html .= '<a href="' . $baseUrl . '?page=' . $i . '" class="px-3 py-2 rounded-md text-gray-400 hover:text-[#f2ab8b] hover:bg-[#810041]/20">' . $i . '</a>';
        }
    }
    
    if ($endPage < $totalPages) {
        if ($endPage < $totalPages - 1) {
            $html .= '<span class="px-3 py-2 text-gray-400">...</span>';
        }
        $html .= '<a href="' . $baseUrl . '?page=' . $totalPages . '" class="px-3 py-2 rounded-md text-gray-400 hover:text-[#f2ab8b] hover:bg-[#810041]/20">' . $totalPages . '</a>';
    }
    
    // Next page link
    if ($currentPage < $totalPages) {
        $html .= '<a href="' . $baseUrl . '?page=' . ($currentPage + 1) . '" class="px-3 py-2 rounded-md text-gray-400 hover:text-[#f2ab8b] hover:bg-[#810041]/20">';
        $html .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">';
        $html .= '<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />';
        $html .= '</svg>';
        $html .= '</a>';
    } else {
        $html .= '<span class="px-3 py-2 rounded-md text-gray-600">';
        $html .= '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">';
        $html .= '<path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />';
        $html .= '</svg>';
        $html .= '</span>';
    }
    
    $html .= '</div>';
    
    return $html;
}

/**
 * Create a project progress bar
 * 
 * @param int $percent The percentage of progress
 * @param string $size The size (sm, md, lg)
 * @return string The HTML for the progress bar
 */
function createProgressBar($percent, $size = 'md') {
    $height = 'h-2';
    if ($size === 'sm') {
        $height = 'h-1.5';
    } elseif ($size === 'lg') {
        $height = 'h-3';
    }
    
    return '
    <div class="w-full bg-gray-700 rounded-full ' . $height . '">
        <div class="' . $height . ' rounded-full bg-gradient-to-r from-[#810041] to-[#f2ab8b]" style="width: ' . $percent . '%"></div>
    </div>';
}

/**
 * Generate a form input field
 * 
 * @param string $type The input type
 * @param string $name The input name
 * @param string $label The input label
 * @param string $value The input value
 * @param string $placeholder The input placeholder
 * @param bool $required Whether the input is required
 * @param string $additionalAttributes Additional HTML attributes
 * @return string The HTML for the form input
 */
function generateFormInput($type, $name, $label, $value = '', $placeholder = '', $required = false, $additionalAttributes = '') {
    $requiredAttr = $required ? 'required' : '';
    $requiredStar = $required ? '<span class="text-[#f2ab8b]">*</span>' : '';
    
    $html = '
    <div class="mb-4">
        <label for="' . $name . '" class="block text-sm font-medium text-gray-300 mb-1">' . $label . ' ' . $requiredStar . '</label>';
    
    if ($type === 'textarea') {
        $html .= '
        <textarea id="' . $name . '" name="' . $name . '" class="w-full px-4 py-2 bg-[#3a0042]/50 border border-[#810041]/30 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#f2ab8b]/50" placeholder="' . $placeholder . '" ' . $requiredAttr . ' ' . $additionalAttributes . '>' . $value . '</textarea>';
    } else {
        $html .= '
        <input type="' . $type . '" id="' . $name . '" name="' . $name . '" value="' . $value . '" class="w-full px-4 py-2 bg-[#3a0042]/50 border border-[#810041]/30 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#f2ab8b]/50" placeholder="' . $placeholder . '" ' . $requiredAttr . ' ' . $additionalAttributes . '>';
    }
    
    $html .= '
    </div>';
    
    return $html;
}

/**
 * Generate a form select field
 * 
 * @param string $name The select name
 * @param string $label The select label
 * @param array $options The select options
 * @param string $selected The selected option
 * @param bool $required Whether the select is required
 * @param string $additionalAttributes Additional HTML attributes
 * @return string The HTML for the form select
 */
function generateFormSelect($name, $label, $options, $selected = '', $required = false, $additionalAttributes = '') {
    $requiredAttr = $required ? 'required' : '';
    $requiredStar = $required ? '<span class="text-[#f2ab8b]">*</span>' : '';
    
    $html = '
    <div class="mb-4">
        <label for="' . $name . '" class="block text-sm font-medium text-gray-300 mb-1">' . $label . ' ' . $requiredStar . '</label>
        <select id="' . $name . '" name="' . $name . '" class="w-full px-4 py-2 bg-[#3a0042]/50 border border-[#810041]/30 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#f2ab8b]/50" ' . $requiredAttr . ' ' . $additionalAttributes . '>';
    
    foreach ($options as $value => $text) {
        $selectedAttr = ($value == $selected) ? 'selected' : '';
        $html .= '<option value="' . $value . '" ' . $selectedAttr . '>' . $text . '</option>';
    }
    
    $html .= '
        </select>
    </div>';
    
    return $html;
}

/**
 * Generate a form button
 * 
 * @param string $text The button text
 * @param string $type The button type
 * @param string $additionalClasses Additional CSS classes
 * @return string The HTML for the form button
 */
function generateFormButton($text, $type = 'submit', $additionalClasses = '') {
    return '
    <button type="' . $type . '" class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-white font-medium py-2 px-4 rounded-lg hover:opacity-90 transition duration-300 ' . $additionalClasses . '">
        ' . $text . '
    </button>';
}

/**
 * Check if a user has permission to access a resource
 * 
 * @param string $resource The resource to check
 * @param string $action The action to check
 * @return bool True if user has permission, false otherwise
 */
function hasPermission($resource, $action) {
    // Make sure user is logged in
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role'])) {
        return false;
    }
    
    $role = $_SESSION['user_role'];
    
    // Admin has all permissions
    if ($role === 'admin') {
        return true;
    }
    
    // Define client permissions
    if ($role === 'client') {
        $clientPermissions = [
            'project' => ['view'],
            'invoice' => ['view'],
            'payment' => ['view'],
            'profile' => ['view', 'edit']
        ];
        
        if (isset($clientPermissions[$resource]) && in_array($action, $clientPermissions[$resource])) {
            return true;
        }
    }
    
    return false;
}

/**
 * Log an action for audit purposes
 * 
 * @param string $action The action performed
 * @param string $description The description of the action
 * @param int $userId The user ID who performed the action
 * @return bool True if logged successfully, false otherwise
 */
function logAction($action, $description, $userId = null) {
    // If no user ID provided, try to get from session
    if ($userId === null && isset($_SESSION['user_id'])) {
        $userId = $_SESSION['user_id'];
    }
    
    // If still no user ID, set as system
    if ($userId === null) {
        $userId = 0; // System user
    }
    
    // In a real implementation, this would be saved to database
    // For now, we'll just return true
    return true;
}

/**
 * Get total payments for a project
 * 
 * @param int $projectId The project ID
 * @return float The total payments
 */
function getProjectTotalPayments($projectId) {
    // In a real implementation, this would query the database
    // For now, we'll return a dummy value
    return 0;
}

/**
 * Get project completion percentage
 * 
 * @param int $projectId The project ID
 * @return int The completion percentage
 */
function getProjectCompletionPercentage($projectId) {
    // In a real implementation, this would query the database
    // For now, we'll return a dummy value
    return 0;
}

/**
 * Get remaining balance for a project
 * 
 * @param float $totalAmount The total project amount
 * @param float $paidAmount The amount already paid
 * @return float The remaining balance
 */
function getRemainingBalance($totalAmount, $paidAmount) {
    return max(0, $totalAmount - $paidAmount);
}

/**
 * Calculate days until deadline
 * 
 * @param string $deadline The deadline date
 * @return int|string Number of days or "Overdue" if past
 */
function daysUntilDeadline($deadline) {
    if (empty($deadline)) {
        return 'N/A';
    }
    
    $deadlineDate = new DateTime($deadline);
    $today = new DateTime();
    
    // If deadline is in the past
    if ($deadlineDate < $today) {
        $interval = $today->diff($deadlineDate);
        return 'Overdue by ' . $interval->days . ' days';
    }
    
    // If deadline is in the future
    $interval = $today->diff($deadlineDate);
    return $interval->days;
}
/**
 * Format a phone number
 * 
 * @param string $phone The phone number to format
 * @return string The formatted phone number
 */
function formatPhoneNumber($phone) {
    // Strip all non-numeric characters
    $phone = preg_replace('/[^0-9]/', '', $phone);
    
    if (strlen($phone) === 10) {
        // Format as (XXX) XXX-XXXX
        return '(' . substr($phone, 0, 3) . ') ' . substr($phone, 3, 3) . '-' . substr($phone, 6);
    }
    
    // Return as is if not 10 digits
    return $phone;
}

/**
 * Sanitize user input
 * 
 * @param string $input The input to sanitize
 * @return string The sanitized input
 */
function sanitizeInput($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Generate a random password
 * 
 * @param int $length The password length
 * @return string The generated password
 */
function generateRandomPassword($length = 12) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
    $password = '';
    
    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    return $password;
}

/**
 * Create a dashboard summary card
 * 
 * @param string $title The card title
 * @param string $value The main value to display
 * @param string $icon The icon HTML
 * @param string $description Additional description text
 * @param string $trend Trend indicator (up, down, or null)
 * @param string $trendValue The trend value
 * @return string The HTML for the dashboard summary card
 */
function createDashboardCard($title, $value, $icon, $description = '', $trend = null, $trendValue = '') {
    $trendHTML = '';
    
    if ($trend === 'up') {
        $trendHTML = '<span class="flex items-center text-green-400 text-sm ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
            ' . $trendValue . '
        </span>';
    } elseif ($trend === 'down') {
        $trendHTML = '<span class="flex items-center text-red-400 text-sm ml-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            ' . $trendValue . '
        </span>';
    }
    
    return '
    <div class="bg-[#26002b]/50 backdrop-blur-sm rounded-xl p-4 border border-[#810041]/20 shadow-lg">
        <div class="flex items-center">
            <div class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] p-3 rounded-lg">
                ' . $icon . '
            </div>
            <div class="ml-4">
                <p class="text-gray-400 text-sm">' . $title . '</p>
                <div class="flex items-center">
                    <h3 class="text-xl font-bold text-white">' . $value . '</h3>
                    ' . $trendHTML . '
                </div>
                ' . ($description ? '<p class="text-gray-400 text-xs mt-1">' . $description . '</p>' : '') . '
            </div>
        </div>
    </div>';
}

/**
 * Create a navigation breadcrumb
 * 
 * @param array $items The breadcrumb items (name => url)
 * @return string The HTML for the breadcrumb
 */
function createBreadcrumb($items) {
    $html = '<nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">';
    
    $i = 0;
    $count = count($items);
    
    foreach ($items as $name => $url) {
        $i++;
        
        if ($i === 1) {
            // First item
            $html .= '<li class="inline-flex items-center">
                <a href="' . $url . '" class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-[#f2ab8b]">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    ' . $name . '
                </a>
            </li>';
        } elseif ($i === $count) {
            // Last item (current page)
            $html .= '<li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-[#f2ab8b]">' . $name . '</span>
                </div>
            </li>';
        } else {
            // Middle items
            $html .= '<li>
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <a href="' . $url . '" class="ml-1 text-sm font-medium text-gray-400 hover:text-[#f2ab8b]">' . $name . '</a>
                </div>
            </li>';
        }
    }
    
    $html .= '</ol></nav>';
    
    return $html;
}

/**
 * Create a responsive data table
 * 
 * @param array $headers The table headers
 * @param array $data The table data
 * @param string $emptyMessage Message to display when data is empty
 * @return string The HTML for the data table
 */
function createDataTable($headers, $data, $emptyMessage = 'No data available') {
    if (empty($data)) {
        return '<div class="text-center py-8 text-gray-400">' . $emptyMessage . '</div>';
    }
    
    $html = '
    <div class="overflow-x-auto rounded-lg border border-[#810041]/20">
        <table class="min-w-full divide-y divide-[#810041]/20">
            <thead class="bg-[#3a0042]/50">
                <tr>';
    
    foreach ($headers as $header) {
        $html .= '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">' . $header . '</th>';
    }
    
    $html .= '</tr>
            </thead>
            <tbody class="bg-[#2a0032]/50 divide-y divide-[#810041]/20">';
    
    foreach ($data as $row) {
        $html .= '<tr class="hover:bg-[#3a0042]/30">';
        
        foreach ($row as $cell) {
            $html .= '<td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">' . $cell . '</td>';
        }
        
        $html .= '</tr>';
    }
    
    $html .= '</tbody>
        </table>
    </div>';
    
    return $html;
}

/**
 * Create a confirmation modal
 * 
 * @param string $id The modal ID
 * @param string $title The modal title
 * @param string $message The modal message
 * @param string $confirmButtonText The confirm button text
 * @param string $confirmButtonAction The confirm button action (JavaScript)
 * @return string The HTML for the confirmation modal
 */
function createConfirmationModal($id, $title, $message, $confirmButtonText, $confirmButtonAction) {
    return '
    <div id="' . $id . '" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-black opacity-75 transition-opacity" aria-hidden="true"></div>
            
            <div class="relative bg-[#26002b] rounded-lg max-w-md w-full mx-auto shadow-xl z-10">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-white mb-4">' . $title . '</h3>
                    <p class="text-gray-300 mb-6">' . $message . '</p>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="document.getElementById(\'' . $id . '\').classList.add(\'hidden\')" class="px-4 py-2 bg-gray-800 text-gray-300 rounded-lg hover:bg-gray-700 transition">
                            Cancel
                        </button>
                        <button type="button" onclick="' . $confirmButtonAction . '" class="px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-red-800 transition">
                            ' . $confirmButtonText . '
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>';
}

/**
 * Create a notification badge
 * 
 * @param int $count The count to display
 * @return string The HTML for the notification badge
 */
function createNotificationBadge($count) {
    if ($count <= 0) {
        return '';
    }
    
    return '<span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">' . $count . '</span>';
}

/**
 * Format file size in human-readable format
 * 
 * @param int $bytes The size in bytes
 * @return string The formatted size
 */
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' bytes';
    } elseif ($bytes == 1) {
        return $bytes . ' byte';
    } else {
        return '0 bytes';
    }
}

/**
 * Check if user is logged in, if not redirect to login page
 * 
 * @param string $redirectUrl The URL to redirect to if not logged in
 * @return void
 */
function requireLogin($redirectUrl = '/login.php') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . $redirectUrl);
        exit;
    }
}

/**
 * Check if user is admin, if not redirect to access denied page
 * 
 * @param string $redirectUrl The URL to redirect to if not admin
 * @return void
 */
function requireAdmin($redirectUrl = '/access-denied.php') {
    requireLogin();
    
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
        header('Location: ' . $redirectUrl);
        exit;
    }
}

/**
 * Check if user is client, if not redirect to access denied page
 * 
 * @param string $redirectUrl The URL to redirect to if not client
 * @return void
 */
function requireClient($redirectUrl = '/access-denied.php') {
    requireLogin();
    
    if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'client') {
        header('Location: ' . $redirectUrl);
        exit;
    }
}

/**
 * Create a SVG icon
 * 
 * @param string $name The icon name
 * @param string $classes Additional CSS classes
 * @return string The SVG icon HTML
 */
function createIcon($name, $classes = 'h-5 w-5') {
    $icons = [
        'dashboard' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>',
        'clients' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>',
        'projects' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" /></svg>',
        'payments' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>',
        'invoices' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>',
        'settings' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>',
        'reports' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>',
        'add' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>',
        'edit' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>',
        'delete' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>',
        'view' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>',
        'download' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>',
        'logout' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>',
        'search' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>',
        'filter' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>',
        'calendar' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>',
        'notification' => '<svg xmlns="http://www.w3.org/2000/svg" class="' . $classes . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>'
    ];
    
    return $icons[$name] ?? '';
}

/**
 * Create an action button for tables
 * 
 * @param string $text The button text
 * @param string $url The button URL
 * @param string $icon The icon name
 * @param string $type The button type (primary, secondary, danger, etc.)
 * @return string The HTML for the action button
 */
function createActionButton($text, $url, $icon, $type = 'primary') {
    $classes = '';
    
    switch ($type) {
        case 'primary':
            $classes = 'text-blue-400 hover:text-blue-500';
            break;
        case 'secondary':
            $classes = 'text-gray-400 hover:text-gray-300';
            break;
        case 'danger':
            $classes = 'text-red-400 hover:text-red-500';
            break;
        case 'success':
            $classes = 'text-green-400 hover:text-green-500';
            break;
        case 'warning':
            $classes = 'text-yellow-400 hover:text-yellow-500';
            break;
        default:
            $classes = 'text-[#f2ab8b] hover:text-white';
    }
    
    return '
    <a href="' . $url . '" class="' . $classes . ' transition-colors" title="' . $text . '">
        ' . createIcon($icon) . '
    </a>';
}

/**
 * Get month names
 * 
 * @param bool $abbreviated Whether to return abbreviated names
 * @return array Array of month names
 */
function getMonthNames($abbreviated = false) {
    return $abbreviated 
        ? ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        : ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
}

/**
 * Get current month data for dashboard
 * 
 * @param string $type The data type (projects, clients, payments, invoices)
 * @return array Array of month data
 */
function getCurrentMonthData($type) {
    // In a real implementation, this would query the database
    // For now, we'll return dummy data
    
    switch ($type) {
        case 'projects':
            return [
                'total' => 8,
                'completed' => 3,
                'in_progress' => 4,
                'on_hold' => 1,
                'trend' => 'up',
                'trend_value' => '25%'
            ];
        case 'clients':
            return [
                'total' => 12,
                'new' => 2,
                'active' => 9,
                'inactive' => 1,
                'trend' => 'up',
                'trend_value' => '10%'
            ];
        case 'payments':
            return [
                'total' => 15000,
                'received' => 10000,
                'pending' => 3000,
                'overdue' => 2000,
                'trend' => 'up',
                'trend_value' => '15%'
            ];
        case 'invoices':
            return [
                'total' => 15,
                'paid' => 10,
                'pending' => 3,
                'overdue' => 2,
                'trend' => 'up',
                'trend_value' => '20%'
            ];
        default:
            return [];
    }
}

/**
 * Get payment methods icon
 * 
 * @param string $method The payment method
 * @return string The HTML for the payment method icon
 */
function getPaymentMethodIcon($method) {
    switch ($method) {
        case 'credit_card':
            return '<i class="fas fa-credit-card text-blue-400"></i>';
        case 'bank_transfer':
            return '<i class="fas fa-university text-green-400"></i>';
        case 'paypal':
            return '<i class="fab fa-paypal text-blue-600"></i>';
        case 'cash':
            return '<i class="fas fa-money-bill-wave text-green-500"></i>';
        case 'check':
            return '<i class="fas fa-money-check text-gray-400"></i>';
        case 'stripe':
            return '<i class="fab fa-stripe-s text-purple-500"></i>';
        default:
            return '<i class="fas fa-dollar-sign text-gray-400"></i>';
    }
}

/**
 * Generate chart data
 * 
 * @param string $type The chart type
 * @param int $months Number of months to include
 * @return array The chart data
 */
function generateChartData($type, $months = 6) {
    $data = [];
    $labels = [];
    
    // Get month names
    $monthNames = getMonthNames(true);
    
    // Get current month
    $currentMonth = (int)date('n') - 1; // 0-indexed
    
    // Generate month labels
    for ($i = $months - 1; $i >= 0; $i--) {
        $monthIndex = ($currentMonth - $i) % 12;
        if ($monthIndex < 0) {
            $monthIndex += 12;
        }
        $labels[] = $monthNames[$monthIndex];
    }
    
    // Generate random data based on type
    switch ($type) {
        case 'revenue':
            $baseValue = 10000;
            $multiplier = 2000;
            for ($i = 0; $i < $months; $i++) {
                $data[] = $baseValue + mt_rand(0, $multiplier);
            }
            break;
        case 'projects':
            $baseValue = 5;
            $multiplier = 3;
            for ($i = 0; $i < $months; $i++) {
                $data[] = $baseValue + mt_rand(0, $multiplier);
            }
            break;
        case 'clients':
            $baseValue = 3;
            $multiplier = 2;
            for ($i = 0; $i < $months; $i++) {
                $data[] = $baseValue + mt_rand(0, $multiplier);
            }
            break;
        default:
            for ($i = 0; $i < $months; $i++) {
                $data[] = mt_rand(1, 10);
            }
    }
    
    return [
        'labels' => $labels,
        'data' => $data
    ];
}

/**
 * Generate an activity log entry
 * 
 * @param string $action The action performed
 * @param string $target The target of the action
 * @param string $time The time of the action
 * @param string $user The user who performed the action
 * @return string The HTML for the activity log entry
 */
function generateActivityLogEntry($action, $target, $time, $user) {
    $actionIcon = '';
    $actionClass = '';
    
    switch ($action) {
        case 'created':
            $actionIcon = '<i class="fas fa-plus"></i>';
            $actionClass = 'bg-green-900/30 text-green-400';
            break;
        case 'updated':
            $actionIcon = '<i class="fas fa-edit"></i>';
            $actionClass = 'bg-blue-900/30 text-blue-400';
            break;
        case 'deleted':
            $actionIcon = '<i class="fas fa-trash"></i>';
            $actionClass = 'bg-red-900/30 text-red-400';
            break;
        case 'viewed':
            $actionIcon = '<i class="fas fa-eye"></i>';
            $actionClass = 'bg-purple-900/30 text-purple-400';
            break;
        case 'completed':
            $actionIcon = '<i class="fas fa-check"></i>';
            $actionClass = 'bg-green-900/30 text-green-400';
            break;
        default:
            $actionIcon = '<i class="fas fa-dot-circle"></i>';
            $actionClass = 'bg-gray-900/30 text-gray-400';
    }
    
    return '
    <div class="flex items-start mb-4">
        <div class="flex-shrink-0 w-8 h-8 rounded-full ' . $actionClass . ' flex items-center justify-center">
            ' . $actionIcon . '
        </div>
        <div class="ml-3">
            <p class="text-gray-300">
                <span class="font-medium text-white">' . $user . '</span> 
                ' . $action . ' 
                <span class="font-medium text-[#f2ab8b]">' . $target . '</span>
            </p>
            <p class="text-xs text-gray-500 mt-1">' . $time . '</p>
        </div>
    </div>';
}

/**
 * Get recent activities
 * 
 * @param int $limit Number of activities to return
 * @return array Array of recent activities
 */
function getRecentActivities($limit = 5) {
    // In a real implementation, this would query the database
    // For now, we'll return dummy data
    
    $activities = [
        [
            'action' => 'created',
            'target' => 'Website Redesign Project',
            'time' => '2 hours ago',
            'user' => 'Admin'
        ],
        [
            'action' => 'updated',
            'target' => 'E-commerce Platform',
            'time' => '3 hours ago',
            'user' => 'Admin'
        ],
        [
            'action' => 'completed',
            'target' => 'Logo Design Project',
            'time' => '1 day ago',
            'user' => 'Admin'
        ],
        [
            'action' => 'viewed',
            'target' => 'Invoice #INV-2023-05',
            'time' => '1 day ago',
            'user' => 'Client Name'
        ],
        [
            'action' => 'created',
            'target' => 'New Client Account',
            'time' => '2 days ago',
            'user' => 'Admin'
        ],
        [
            'action' => 'updated',
            'target' => 'Payment for Invoice #INV-2023-04',
            'time' => '3 days ago',
            'user' => 'Admin'
        ],
        [
            'action' => 'deleted',
            'target' => 'Old Project Files',
            'time' => '5 days ago',
            'user' => 'Admin'
        ]
    ];
    
    // Return only the requested number of activities
    return array_slice($activities, 0, $limit);
}

/**
 * Get upcoming deadlines
 * 
 * @param int $limit Number of deadlines to return
 * @return array Array of upcoming deadlines
 */
function getUpcomingDeadlines($limit = 5) {
    // In a real implementation, this would query the database
    // For now, we'll return dummy data
    
    $deadlines = [
        [
            'project' => 'Website Redesign',
            'deadline' => '2025-05-25',
            'progress' => 70,
            'client' => 'ABC Company'
        ],
        [
            'project' => 'Mobile App Development',
            'deadline' => '2025-06-10',
            'progress' => 45,
            'client' => 'XYZ Corp'
        ],
        [
            'project' => 'SEO Optimization',
            'deadline' => '2025-05-18',
            'progress' => 90,
            'client' => '123 Industries'
        ],
        [
            'project' => 'Content Marketing Strategy',
            'deadline' => '2025-06-30',
            'progress' => 20,
            'client' => 'Global Solutions'
        ],
        [
            'project' => 'Brand Identity Refresh',
            'deadline' => '2025-07-15',
            'progress' => 10,
            'client' => 'Innovative Tech'
        ],
        [
            'project' => 'Social Media Campaign',
            'deadline' => '2025-05-31',
            'progress' => 60,
            'client' => 'Local Business'
        ]
    ];
    
    // Return only the requested number of deadlines
    return array_slice($deadlines, 0, $limit);
}

/**
 * Get upcoming payments
 * 
 * @param int $limit Number of payments to return
 * @return array Array of upcoming payments
 */
function getUpcomingPayments($limit = 5) {
    // In a real implementation, this would query the database
    // For now, we'll return dummy data
    
    $payments = [
        [
            'invoice' => 'INV-2023-06',
            'amount' => 2500,
            'due_date' => '2025-05-20',
            'client' => 'ABC Company',
            'status' => 'pending'
        ],
        [
            'invoice' => 'INV-2023-07',
            'amount' => 1800,
            'due_date' => '2025-05-25',
            'client' => 'XYZ Corp',
            'status' => 'pending'
        ],
        [
            'invoice' => 'INV-2023-08',
            'amount' => 3200,
            'due_date' => '2025-06-01',
            'client' => '123 Industries',
            'status' => 'pending'
        ],
        [
            'invoice' => 'INV-2023-09',
            'amount' => 1500,
            'due_date' => '2025-06-05',
            'client' => 'Global Solutions',
            'status' => 'pending'
        ],
        [
            'invoice' => 'INV-2023-10',
            'amount' => 4000,
            'due_date' => '2025-06-10',
            'client' => 'Innovative Tech',
            'status' => 'pending'
        ],
        [
            'invoice' => 'INV-2023-11',
            'amount' => 900,
            'due_date' => '2025-06-15',
            'client' => 'Local Business',
            'status' => 'pending'
        ]
    ];
    
    // Return only the requested number of payments
    return array_slice($payments, 0, $limit);
}

/**
 * Check if a project belongs to a client
 * 
 * @param int $projectId The project ID
 * @param int $clientId The client ID
 * @return bool True if project belongs to client, false otherwise
 */
function isProjectBelongsToClient($projectId, $clientId) {
    // In a real implementation, this would query the database
    // For now, we'll return true
    return true;
}

/**
 * Check if a invoice belongs to a client
 * 
 * @param int $invoiceId The invoice ID
 * @param int $clientId The client ID
 * @return bool True if invoice belongs to client, false otherwise
 */
function isInvoiceBelongsToClient($invoiceId, $clientId) {
    // In a real implementation, this would query the database
    // For now, we'll return true
    return true;
}

/**
 * Check if a payment belongs to a client
 * 
 * @param int $paymentId The payment ID
 * @param int $clientId The client ID
 * @return bool True if payment belongs to client, false otherwise
 */
function isPaymentBelongsToClient($paymentId, $clientId) {
    // In a real implementation, this would query the database
    // For now, we'll return true
    return true;
}

/**
 * Generate a search form
 * 
 * @param string $placeholder The search placeholder
 * @param string $action The form action URL
 * @return string The HTML for the search form
 */
function generateSearchForm($placeholder = 'Search', $action = '') {
    return '
    <form action="' . $action . '" method="GET" class="w-full">
        <div class="relative">
            <input type="text" name="search" placeholder="' . $placeholder . '" class="w-full px-4 py-2 pl-10 bg-[#3a0042]/50 border border-[#810041]/30 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#f2ab8b]/50">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3">
                <span class="text-sm text-[#f2ab8b]">Search</span>
            </button>
        </div>
    </form>';
}

/**
 * Generate a filter form
 * 
 * @param array $filters Array of filters (name => options)
 * @param array $selected Array of selected filter values
 * @param string $action The form action URL
 * @return string The HTML for the filter form
 */
function generateFilterForm($filters, $selected = [], $action = '') {
    $html = '
    <form action="' . $action . '" method="GET" class="w-full">
        <div class="grid grid-cols-1 md:grid-cols-' . count($filters) . ' gap-4">';
    
    foreach ($filters as $name => $options) {
        $label = ucfirst(str_replace('_', ' ', $name));
        $selectedValue = $selected[$name] ?? '';
        
        $html .= '
        <div>
            <label for="filter_' . $name . '" class="block text-sm font-medium text-gray-300 mb-1">' . $label . '</label>
            <select id="filter_' . $name . '" name="filter_' . $name . '" class="w-full px-4 py-2 bg-[#3a0042]/50 border border-[#810041]/30 rounded-lg text-gray-200 focus:outline-none focus:ring-2 focus:ring-[#f2ab8b]/50">
                <option value="">All</option>';
        
        foreach ($options as $value => $text) {
            $selectedAttr = ($value == $selectedValue) ? 'selected' : '';
            $html .= '<option value="' . $value . '" ' . $selectedAttr . '>' . $text . '</option>';
        }
        
        $html .= '
            </select>
        </div>';
    }
    
    $html .= '
        </div>
        <div class="mt-4 flex justify-end space-x-3">
            <button type="submit" class="bg-gradient-to-r from-[#810041] to-[#f2ab8b] text-white font-medium py-2 px-4 rounded-lg hover:opacity-90 transition duration-300">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </div>
            </button>
            <a href="' . $action . '" class="bg-gray-800 text-gray-300 font-medium py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-300">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Reset
                </div>
            </a>
        </div>
    </form>';
    
    return $html;
}

/**
 * Generate URL with query parameters
 * 
 * @param string $baseUrl The base URL
 * @param array $params The query parameters
 * @return string The generated URL
 */
function generateUrl($baseUrl, $params = []) {
    if (empty($params)) {
        return $baseUrl;
    }
    
    $query = http_build_query($params);
    return $baseUrl . (strpos($baseUrl, '?') !== false ? '&' : '?') . $query;
}

/**
 * Format invoice number
 * 
 * @param int $id The invoice ID
 * @param string $prefix The invoice prefix
 * @return string The formatted invoice number
 */
function formatInvoiceNumber($id, $prefix = 'INV') {
    return $prefix . '-' . date('Y') . '-' . str_pad($id, 3, '0', STR_PAD_LEFT);
}

/**
 * Get status count
 * 
 * @param array $items The items array
 * @param string $statusField The status field name
 * @param string $statusValue The status value to count
 * @return int The count of items with the given status
 */
function getStatusCount($items, $statusField, $statusValue) {
    $count = 0;
    
    foreach ($items as $item) {
        if ($item[$statusField] === $statusValue) {
            $count++;
        }
    }
    
    return $count;
}

/**
 * Calculate total amount
 * 
 * @param array $items The items array
 * @param string $amountField The amount field name
 * @return float The total amount
 */
function calculateTotalAmount($items, $amountField) {
    $total = 0;
    
    foreach ($items as $item) {
        $total += $item[$amountField];
    }
    
    return $total;
}

/**
 * Create a notification
 * 
 * @param string $title The notification title
 * @param string $message The notification message
 * @param string $level The notification level (info, success, warning, error)
 * @return bool True if created successfully, false otherwise
 */
function createNotification($title, $message, $level = 'info') {
    // In a real implementation, this would save to database
    // For now, we'll just return true
    return true;
}

/**
 * Get notifications for a user
 * 
 * @param int $userId The user ID
 * @param int $limit The limit
 * @param bool $unreadOnly Whether to get only unread notifications
 * @return array The notifications
 */
function getNotifications($userId, $limit = 5, $unreadOnly = false) {
    // In a real implementation, this would query the database
    // For now, we'll return dummy data
    
    $notifications = [
        [
            'id' => 1,
            'title' => 'New Project Created',
            'message' => 'A new project has been created: Website Redesign',
            'time' => '2 hours ago',
            'level' => 'info',
            'read' => false
        ],
        [
            'id' => 2,
            'title' => 'Payment Received',
            'message' => 'Payment received for Invoice #INV-2023-05',
            'time' => '1 day ago',
            'level' => 'success',
            'read' => false
        ],
        [
            'id' => 3,
            'title' => 'Upcoming Deadline',
            'message' => 'Project "Mobile App Development" is due in 5 days',
            'time' => '2 days ago',
            'level' => 'warning',
            'read' => true
        ],
        [
            'id' => 4,
            'title' => 'Invoice Overdue',
            'message' => 'Invoice #INV-2023-03 is overdue by 15 days',
            'time' => '3 days ago',
            'level' => 'error',
            'read' => true
        ],
        [
            'id' => 5,
            'title' => 'Client Added',
            'message' => 'New client added: XYZ Corp',
            'time' => '5 days ago',
            'level' => 'info',
            'read' => true
        ]
    ];
    
    // Filter unread if requested
    if ($unreadOnly) {
        $notifications = array_filter($notifications, function($notification) {
            return !$notification['read'];
        });
    }
    
    // Return only the requested number of notifications
    return array_slice($notifications, 0, $limit);
}

/**
 * Mark notification as read
 * 
 * @param int $notificationId The notification ID
 * @return bool True if marked successfully, false otherwise
 */
function markNotificationAsRead($notificationId) {
    // In a real implementation, this would update the database
    // For now, we'll just return true
    return true;
}

/**
 * Get unread notification count
 * 
 * @param int $userId The user ID
 * @return int The unread notification count
 */
function getUnreadNotificationCount($userId) {
    // In a real implementation, this would query the database
    // For now, we'll return a dummy count
    return 2;
}

// Initialize the application if needed
function initApp() {
    // In a real implementation, this would do various initialization tasks
    // For now, it's just a placeholder
}

// Call the initialization function
initApp();