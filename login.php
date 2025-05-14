 
<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';
require_once 'includes/auth.php';

// Check if already logged in
if (isLoggedIn()) {
    redirect('index.php');
}

$error = '';

// Process login form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitize($_POST['username']);
    $password = $_POST['password']; // Don't sanitize password, will be hashed
    
    if (empty($username) || empty($password)) {
        $error = 'Username and password are required';
    } else {
        $result = loginUser($username, $password, $conn);
        
        if ($result['status']) {
            // Redirect based on user type
            if ($_SESSION['user_type'] === 'admin') {
                redirect('index.php');
            } else {
                redirect('index.php');
            }
        } else {
            $error = $result['message'];
        }
    }
}

// Include header
include 'includes/header.php';
?>

<div class="flex justify-center items-center my-12">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h1 class="text-2xl font-bold mb-6 text-center text-indigo-600">Login to Payment Platform</h1>
        
        <?php if (!empty($error)): ?>
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="mb-4">
                <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    required>
            </div>
            
            <div class="mb-6">
                <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" id="password" name="password" 
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" 
                    required>
            </div>
            
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                    Login
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center text-sm text-gray-500">
            If you don't have an account, please contact the administrator for registration.
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>