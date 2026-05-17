// Role Selection Function - Redirects to appropriate login page
function selectRole(role) {
    console.log('Selected role:', role);
    
    // Redirect to Laravel routes based on role
    switch(role) {
        case 'customer':
            window.location.href = '/customer/login';
            break;
        case 'admin':
            window.location.href = '/admin/login';
            break;
        case 'baker':
            window.location.href = '/baker/login';
            break;
        case 'delivery':
            window.location.href = '/delivery/login';
            break;
        default:
            alert('Invalid role selected');
    }
}

// Optional: Add loading effect when clicking
document.addEventListener('DOMContentLoaded', function() {
    const roleCards = document.querySelectorAll('.role-card');
    
    roleCards.forEach(card => {
        card.addEventListener('click', function() {
            // Add visual feedback
            this.style.opacity = '0.7';
            this.style.transform = 'scale(0.98)';
        });
    });
});