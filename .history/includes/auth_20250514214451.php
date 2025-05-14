<?php
/**
 * Authentication Functions for Payment Status Platform
 */

/**
 * Register a new user
 * 
 * @param string $username Username
 * @param string $password Raw password
 * @param string $email Email address
 * @param string $user_type User type (admin or client)
 * @param PDO $conn Database connection
 * @return array Result with status and message
 */
function registerUser($username, $password, $email, $user_type, $conn) {
    try {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        
        if ($stmt->rowCount() > 0) {
            return ['status' => false, 'message' => 'Username or email already exists'];
        }
        
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert the new user
        $stmt = $conn->prepare("INSERT INTO users (username, password, email, user_type) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$username, $hashed_password, $email, $user_type]);
        
        if ($result) {
            return ['status' => true, 'message' => 'User registered successfully', 'user_id' => $conn->lastInsertId()];
        } else {
            return ['status' => false, 'message' => 'Registration failed'];
        }
    } catch (PDOException $e) {
        return ['status' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

/**
 * Login a user
 * 
 * @param string $username Username
 * @param string $password Raw password
 * @param PDO $conn Database connection
 * @return array Result with status and message
 */
function loginUser($username, $password, $conn) {
    try {
        // Get user by username
        $stmt = $conn->prepare("SELECT id, username, password, email, user_type FROM users WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->rowCount() === 0) {
            return ['status' => false, 'message' => 'Invalid username or password'];
        }
        
        $user = $stmt->fetch();
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['user_type'] = $user['user_type'];
            
            // If user is a client, get client ID
            if ($user['user_type'] === 'client') {
                $stmt = $conn->prepare("SELECT id FROM clients WHERE user_id = ?");
                $stmt->execute([$user['id']]);
                
                if ($stmt->rowCount() > 0) {
                    $client = $stmt->fetch();
                    $_SESSION['client_id'] = $client['id'];
                }
            }
            
            return ['status' => true, 'message' => 'Login successful'];
        } else {
            return ['status' => false, 'message' => 'Invalid username or password'];
        }
    } catch (PDOException $e) {
        return ['status' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

/**
 * Register a new client
 * 
 * @param string $username Username
 * @param string $password Raw password
 * @param string $email Email address
 * @param string $company_name Company name
 * @param string $contact_person Contact person name
 * @param string $phone Phone number
 * @param string $address Address
 * @param PDO $conn Database connection
 * @return array Result with status and message
 */
function registerClient($username, $password, $email, $company_name, $contact_person, $phone, $address, $conn) {
    // Start transaction
    $conn->beginTransaction();
    
    try {
        // Register user first
        $user_result = registerUser($username, $password, $email, 'client', $conn);
        
        if (!$user_result['status']) {
            $conn->rollBack();
            return $user_result;
        }
        
        $user_id = $user_result['user_id'];
        
        // Insert client details
        $stmt = $conn->prepare("INSERT INTO clients (user_id, company_name, contact_person, phone, address) VALUES (?, ?, ?, ?, ?)");
        $result = $stmt->execute([$user_id, $company_name, $contact_person, $phone, $address]);
        
        if ($result) {
            $conn->commit();
            return ['status' => true, 'message' => 'Client registered successfully'];
        } else {
            $conn->rollBack();
            return ['status' => false, 'message' => 'Client registration failed'];
        }
    } catch (PDOException $e) {
        $conn->rollBack();
        return ['status' => false, 'message' => 'Database error: ' . $e->getMessage()];
    }
}

/**
 * Check if the user has admin privileges
 * If not, redirect to unauthorized page
 */
function requireAdmin() {
    if (!isLoggedIn() || !isAdmin()) {
        setFlashMessage('Unauthorized access', 'danger');
        redirect('index.php');
    }
}

/**
 * Check if the user is logged in
 * If not, redirect to login page
 */
function requireLogin() {
    if (!isLoggedIn()) {
        setFlashMessage('Please login to access this page', 'warning');
        redirect('login.php');
    }
}

/**
 * Logout the current user
 */
function logoutUser() {
    // Unset all session variables
    $_SESSION = [];
    
    // Destroy the session
    session_destroy();
    
    // Redirect to login page
    redirect('index.php');
}