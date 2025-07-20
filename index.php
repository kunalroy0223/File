<?php
    include "./backend/session_verification.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"> 
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3 text-white" style="background-color: #2E368F; width: 250px; min-height: 100vh;">
            <h3><a href="index.php" class="text-center text-white text-decoration-none">Dashboard</a></h3>
            <ul class="nav flex-column">
                 <li class="nav-item">
                    <a href="#" class="nav-link text-white menu-item" data-page="students">
                        <i class="fas fa-user-graduate"></i> Students
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white menu-item" data-page="academics">
                        <i class="fas fa-book-open"></i> Academics
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white menu-item" data-page="institution">
                        <i class="fas fa-university"></i> Records
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./backend/logout.php" class="nav-link text-white">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="content flex-grow-1 p-4">
            <div class="container" id="main-content">
                <!-- Top Navigation Bar -->
                <div class="top-nav p-3 mb-3 text-center text-black" style="background-color: #FDD306; font-weight: bold; border-radius: 8px;">
                    <h4 class="mb-3">Document Management System</h4>
                    
                </div>
                
                <!-- Dashboard Content -->
                <div class="row">
                    <!-- Quick Stats -->
                    <div class="col-md-3">
                        <div class="card text-center p-3" style="background-color: white;">
                            <i class="fas fa-users fa-2x mb-2"></i>
                            <h5>Total Students</h5>
                            <h3 id="total-students">1,245</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center p-3" style="background-color: white;">
                            <i class="fas fa-file-alt fa-2x mb-2"></i>
                            <h5>Documents</h5>
                            <h3 id="total-documents">856</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center p-3" style="background-color: white">
                            <i class="fas fa-graduation-cap fa-2x mb-2"></i>
                            <h5>Examinations</h5>
                            <h3 id="total-exams">23</h3>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center p-3" style="background-color: white">
                            <i class="fas fa-certificate fa-2x mb-2"></i>
                            <h5>Affiliations</h5>
                            <h3 id="total-affiliations">4</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function refreshRecentFiles() {
            // Add AJAX call to refresh recent files
            console.log("Refreshing recent files...");
            // You can implement this to fetch real data from backend
        }

        // Load dashboard statistics (you can implement this with AJAX)
        $(document).ready(function() {
            // Load real statistics from database
            // loadDashboardStats();
        });

        function loadDashboardStats() {
            // AJAX calls to get real statistics
            $.ajax({
                url: './backend/get_dashboard_stats.php',
                type: 'GET',
                success: function(response) {
                    var stats = JSON.parse(response);
                    $('#total-students').text(stats.students);
                    $('#total-documents').text(stats.documents);
                    $('#total-exams').text(stats.examinations);
                    $('#total-affiliations').text(stats.affiliations);
                }
            });
        }
    </script>

    <script src="./script/main.js"></script>
</body>
</html>