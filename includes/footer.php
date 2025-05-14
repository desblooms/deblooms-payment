<?php
// Make sure we have a session started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
</main>

<!-- Spacing for mobile nav -->
<div class="pb-20"></div>

<!-- Mobile Bottom Navigation -->
<?php if(isset($_SESSION['user_id'])): ?>
    <nav class="fixed bottom-0 left-0 right-0 bg-darkbg border-t border-gray-800 z-50">
        <?php if($_SESSION['user_role'] === 'client'): ?>
            <!-- Client Bottom Navigation -->
            <div class="grid grid-cols-4 h-16">
                <a href="<?php echo getBasePath(); ?>/client/dashboard.php" class="flex flex-col items-center justify-center <?php echo isCurrentPage('dashboard.php') ? 'text-primary' : 'text-gray-400'; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-xs mt-1">Home</span>
                </a>
                <a href="<?php echo getBasePath(); ?>/client/invoices.php" class="flex flex-col items-center justify-center <?php echo isCurrentPage('invoices.php') ? 'text-primary' : 'text-gray-400'; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <span class="text-xs mt-1">Invoices</span>
                </a>
                <a href="<?php echo getBasePath(); ?>/client/payment-history.php" class="flex flex-col items-center justify-center <?php echo isCurrentPage('payment-history.php') ? 'text-primary' : 'text-gray-400'; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-xs mt-1">Payments</span>
                </a>
                <a href="<?php echo getBasePath(); ?>/client/profile.php" class="flex flex-col items-center justify-center <?php echo isCurrentPage('profile.php') ? 'text-primary' : 'text-gray-400'; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <span class="text-xs mt-1">Profile</span>
                </a>
            </div>
        <?php else: ?>
            <!-- Admin Bottom Navigation -->
            <div class="grid grid-cols-5 h-16">
                <a href="<?php echo getBasePath(); ?>/admin/dashboard.php" class="flex flex-col items-center justify-center <?php echo isCurrentPage('dashboard.php') ? 'text-primary' : 'text-gray-400'; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="text-xs mt-1">Home</span>
                </a>
                <a href="<?php echo getBasePath(); ?>/admin/clients.php" class="flex flex-col items-center justify-center <?php echo isCurrentPage('clients.php') ? 'text-primary' : 'text-gray-400'; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="text-xs mt-1">Clients</span>
                </a>
                <a href="<?php echo getBasePath(); ?>/admin/projects.php" class="flex flex-col items-center justify-center <?php echo isCurrentPage('projects.php') ? 'text-primary' : 'text-gray-400'; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                    <span class="text-xs mt-1">Projects</span>
                </a>
                <a href="<?php echo getBasePath(); ?>/admin/payments.php" class="flex flex-col items-center justify-center <?php echo isCurrentPage('payments.php') ? 'text-primary' : 'text-gray-400'; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-xs mt-1">Payments</span>
                </a>
                <a href="<?php echo getBasePath(); ?>/admin/settings.php" class="flex flex-col items-center justify-center <?php echo isCurrentPage('settings.php') ? 'text-primary' : 'text-gray-400'; ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-xs mt-1">Settings</span>
                </a>
            </div>
        <?php endif; ?>
    </nav>
<?php endif; ?>

<!-- Add New Button for Admin -->
<?php if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'admin'): ?>
    <?php
    $currentPage = basename($_SERVER['PHP_SELF']);
    $addButtonUrl = '';
    $showAddButton = false;
    
    switch($currentPage) {
        case 'clients.php':
            $addButtonUrl = getBasePath() . '/admin/add-client.php';
            $showAddButton = true;
            break;
        case 'projects.php':
            $addButtonUrl = getBasePath() . '/admin/add-project.php';
            $showAddButton = true;
            break;
        case 'payments.php':
            $addButtonUrl = getBasePath() . '/admin/add-payment.php';
            $showAddButton = true;
            break;
    }
    
    if($showAddButton):
    ?>
    <a href="<?php echo $addButtonUrl; ?>" class="fixed right-6 bottom-24 rounded-full bg-secondary w-14 h-14 flex items-center justify-center shadow-lg z-40">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
    </a>
    <?php endif; ?>
<?php endif; ?>

<script>
    // Helper function to toggle dropdown
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
        } else {
            dropdown.classList.add('hidden');
        }
    }
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        const dropdowns = document.querySelectorAll('.dropdown-content');
        dropdowns.forEach(function(dropdown) {
            if (!dropdown.previousElementSibling.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>
</body>
</html>