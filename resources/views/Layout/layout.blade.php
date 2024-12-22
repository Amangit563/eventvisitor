<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Panel')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('public/css/layout.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        /* Sidebar styles */
        .sidebar {
            position: fixed;
            top: 60px; /* Adjusted for the header height */
            left: 0;
            width: 250px;
            height: calc(100% - 60px); /* Adjusted for the header height */
            background-color: #343a40;
            transition: transform 0.3s ease-in-out;
            transform: translateX(-100%);
        }

        .sidebar.show-sidebar {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease-in-out;
        }

        .main-content.collapsed-main-content {
            margin-left: 250px;
        }

        /* Responsive design */
        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 250px;
            }
        }

        .sidebar-link {
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            display: block;
        }

        .sidebar-link:hover {
            background-color: #495057;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<?php
    $role = $userData['role'];
?>
<!-- Header -->
<header class="header bg-dark text-light py-2 border-bottom fixed-top">
    <div class="container-fluid">
        <div class="row align-items-center">
            <!-- Sidebar Toggle Button -->
            <div class="col-auto">
                <button class="btn btn-light" id="toggleSidebar" style="font-size: 18px;">☰</button>
            </div>

            <!-- Admin Dashboard Title -->
            <div class="col text-center">
                <h3 class="m-0">Event Visitors Management</h3>
            </div>

            <!-- Profile Button -->
            <div class="col-auto text-end">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle" type="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false" title="Profile">
                        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile" width="30" class="rounded-circle">
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
                        <li><a class="dropdown-item" href="#">View Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Sidebar -->
<nav class="sidebar bg-dark text-white" id="sidebar">
    <a href="#" class="navbar-brand text-center text-white my-4">Event visitors</a>
    <div class="text-center mt-3">
        <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Profile" width="80" class="rounded-circle mb-2">
        <h5>Welcome Back, <b>{{ $role }}</b></h5>
    </div>
    <div class="nav flex-column px-3 mt-4">
        @if($role == "admin")
            <a href="{{ url('/usercreatepage') }}" class="sidebar-link">User Create</a>
            <a href="{{ url('/manageUser') }}" class="sidebar-link">Manage User</a>
            <a href="#settings" class="sidebar-link">Settings</a>
            <a href="{{ url('/gettickets') }}" class="sidebar-link">Reports</a>
            <a href="#logout" class="sidebar-link text-danger">Logout</a>
        @else
            <a href="{{ url('/gettickets') }}" class="sidebar-link">Reports</a>
            <a href="#logout" class="sidebar-link text-danger">Logout</a>
        @endif
    </div>
</nav>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <div class="container-fluid mt-5 pt-4">
        @yield('content')
    </div>
    @include('Footer/footer')
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<!-- Custom JS -->
<script>
    const toggleSidebarButton = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    // Toggle Sidebar on button click
    toggleSidebarButton.addEventListener('click', () => {
        sidebar.classList.toggle('show-sidebar');
        mainContent.classList.toggle('collapsed-main-content');
    });
    
        // Initialize DataTable
    $(document).ready(function() {
        $('#exampleTable').DataTable();
    });
</script>
</body>
</html>
