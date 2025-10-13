<?php include 'header.php' ?>


<head>
    <title>Event History</title>
 <link rel="stylesheet" href="../css/style.css"> <!-- Your custom CSS -->

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

    <style>
        body {

            background: #0d0d2d;
            /* Dark like hero */
            ;
            /* tu apne theme ka dark dega */
            color: #222;
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
        }

        a,
        a:hover {
            text-decoration: none;
        }

        .event-card {
            border-radius: 16px;
            overflow: hidden;
            background: white;
            /* White card background */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .event-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.3);
        }

        /* Image + Overlay */
        .event-img-wrapper {
            position: relative;
            height: 100%;
        }

        .event-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(70%);
        }

        .badge-category {
            display: inline-block;
            background: #007bff;
            /* Blue */
            color: #fff;
            padding: 4px 12px;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 5px;
            text-transform: capitalize;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
        }

        .event-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 1.2rem;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0));
        }

        .event-date-box {
            background: linear-gradient(90deg, #a855f7, #ec4899);
            /* Purple → Pink neon */
            color: #fff;
            font-weight: 600;
            font-size: 0.95rem;
            padding: 4px 12px;
            border-radius: 6px;
            display: inline-block;
        }

        /* Event Title Highlighted */
        .event-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 800;
            background: linear-gradient(90deg, #a855f7, #ec4899, #a855f7);
            /* Purple-Pink gradient */
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 12px rgba(168, 85, 247, 0.7),
                0 0 20px rgba(236, 72, 153, 0.6);
            letter-spacing: 1px;
        }

        /* Details */
        .event-details {
            padding: 2rem;
            color: #333;
        }

        .event-details h4 {
            font-family: 'Playfair Display', serif;
            background: linear-gradient(90deg, #a855f7, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }

        /* Info Boxes */
        .info-box {
            background: #f9f9f9;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .info-box h5 {
            background: linear-gradient(90deg, #a855f7, #ec4899);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .info-box ul {
            padding-left: 1.2rem;
        }

        /* Buttons */
        .btn-golden {
            background: linear-gradient(90deg, #a855f7, #ec4899);
            color: #fff;
            border: none;
            font-weight: 600;
            border-radius: 30px;
            padding: 0.5rem 1.4rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-golden:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(236, 72, 153, 0.5);
        }

        .btn-outline-light {
            border: 2px solid #a855f7;
            color: #a855f7;
            border-radius: 30px;
            padding: 0.5rem 1.4rem;
            transition: all 0.2s ease;
        }

        .btn-outline-light:hover {
            background: #a855f7;
            color: #fff;
        }

        /* Fade-in animation */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .event-card-section h5 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
    background: linear-gradient(90deg, #a855f7, #ec4899);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 0.8rem;
}

.event-card-section img,
.event-card-section video {
    border-radius: 12px;
    object-fit: cover;
    box-shadow: 0 6px 15px rgba(0,0,0,0.15);
}

.event-card-section video {
    height: 150px;
}

    </style>
</head>

<body>
    <div class="container my-4">
        <a href="../index.php" class="btn btn-outline-light mb-4"><i class="bi bi-arrow-left"></i></a>
        <div id="history-container">
            <!-- JS will inject single event card here -->
        </div>
    </div>

    <script src="../js/historyview.js"></script>
    <script>
        // Fade-in on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        });
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
        });
    </script>
</body>

</html>
<?php include 'footer.php' ?>