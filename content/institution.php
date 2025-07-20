<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container1 {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px; /* Adds spacing between cards */
            padding: 50px 20px; /* Adds padding to the container */
            flex-wrap: wrap; /* Allows wrapping on smaller screens */
        }

        .card {
            height: 12rem;
            width: 25rem;
            border-radius: 1.5rem;
            background-color: #ffffff;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Adds shadow to cards */
            transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transition for hover effect */
            padding: 20px;
            cursor: pointer;
        }
        a {
            text-decoration: none; /* Removes underline from the <a> tag */
        }

        .card img {
            margin-bottom: 10px; /* Adds space between the image and text */
        }

        .card p {
            font-size: 1.2rem;
            font-weight: bold;
            color: #333;
        }

        .card:hover {
            transform: translateY(-5px); /* Lift effect on hover */
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* More prominent shadow on hover */
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column; /* Stacks cards vertically on smaller screens */
                gap: 10px;
            }

            .card {
                width: 80%; /* Makes the cards take up more width on small screens */
            }
        }
    </style>

    <div class="container">
    <!-- Breadcrumbs Section -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" id="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="breadcrumb-link" data-page="in.php">Institution </a></li>
        </ol>
    </nav>

    <h2>Institution Section</h2>
    <p>Manage institution details, departments, and policies.</p>

    <div class="container1">
        <!-- Affiliation & Approval Box -->
        <a href="#" >
            <div class="card option-box1" data-page="./institution-details.php">
                <img src="./content/inst.png" alt="approval icon" height="75px">
                <p>Room Allocation</p>
            </div>
        </a>

        <!-- Examination Box -->
        <a href="#" >
            <div class="card option-box1" data-page="./departments.php">
                <img src="./content/dept.png" alt="exam icon" height="75px">
                <p>Departments</p>
            </div>
        </a>
    <!-- Content Section -->
    <div id="academic-content" class="mt-4"></div>
</div>

<script src="./script/option-box.js"></script>
