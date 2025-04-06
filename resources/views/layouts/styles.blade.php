<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/footer.css') }}">
@stack('styles')

<style>
:root {
    --primary-color: #e31235;
    --secondary-color: #0056b3;
    --text-color: #333;
    --light-gray: #f8f9fa;
    --border-color: #dee2e6;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
    --info-color: #17a2b8;
}

body {
    font-family: 'Jost', sans-serif;
    color: var(--text-color);
    background-color: var(--light-gray);
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    background: white;
    margin-bottom: 20px;
}

.card-header {
    background-color: white;
    border-bottom: 1px solid var(--border-color);
    padding: 15px 20px;
}

.card-body {
    padding: 20px;
}

.btn {
    border-radius: 5px;
    padding: 8px 16px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.btn-primary:hover {
    background-color: #c0102d;
    border-color: #c0102d;
}

.btn-secondary {
    background-color: var(--secondary-color);
    border-color: var(--secondary-color);
}

.btn-secondary:hover {
    background-color: #004494;
    border-color: #004494;
}

.form-control {
    border-radius: 5px;
    border: 1px solid var(--border-color);
    padding: 8px 12px;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(227, 18, 53, 0.25);
}

.table {
    width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}

.table th {
    background-color: var(--light-gray);
    font-weight: 600;
}

.modal-content {
    border-radius: 10px;
    border: none;
}

.modal-header {
    border-bottom: 1px solid var(--border-color);
    padding: 15px 20px;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    border-top: 1px solid var(--border-color);
    padding: 15px 20px;
}

.pagination {
    margin-top: 20px;
}

.pagination .page-link {
    color: var(--primary-color);
    border: 1px solid var(--border-color);
}

.pagination .page-item.active .page-link {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
}

.alert {
    border-radius: 5px;
    padding: 15px 20px;
    margin-bottom: 20px;
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

.list-group-item {
    border: 1px solid var(--border-color);
    padding: 12px 20px;
}

.list-group-item:first-child {
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}

.list-group-item:last-child {
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
}

.nav-tabs {
    border-bottom: 1px solid var(--border-color);
}

.nav-tabs .nav-link {
    color: var(--text-color);
    border: none;
    padding: 10px 20px;
}

.nav-tabs .nav-link.active {
    color: var(--primary-color);
    border-bottom: 2px solid var(--primary-color);
}

.text-primary {
    color: var(--primary-color) !important;
}

.text-secondary {
    color: var(--secondary-color) !important;
}

.bg-primary {
    background-color: var(--primary-color) !important;
}

.bg-secondary {
    background-color: var(--secondary-color) !important;
}

@media (max-width: 768px) {
    .container {
        padding: 10px;
    }

    .card {
        margin-bottom: 15px;
    }

    .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.fade-in {
    animation: fadeIn 0.3s ease-in;
}

.profile-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.profile-header {
    text-align: center;
    margin-bottom: 30px;
}

.profile-avatar {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
    border: 3px solid var(--primary-color);
}

.profile-info {
    background: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.profile-field {
    margin-bottom: 15px;
}

.profile-label {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 5px;
}

.profile-value {
    color: var(--text-color);
}

@media (max-width: 576px) {
    .profile-container {
        padding: 10px;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
    }
}


</style>
