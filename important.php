<?php
session_start();
$message = "";
require_once "connection.php";

// Check if user is logged in and OTP verified
if (!isset($_SESSION['student_id']) || !isset($_SESSION['otp_verified'])) {
    header("Location: login.php");
    exit();
}
?>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Override dark background for better readability */
        body {
            background: #ffffff !important;
            color: #333333 !important;
        }

        main.card {
            background: #ffffff !important;
            color: #333333 !important;
            border: 1px solid #e0e0e0 !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1) !important;
        }

        .top h1 {
            color: #2c3e50 !important;
        }

        .lead {
            color: #666666 !important;
        }

        .info-box {
            background: #f8f9fa !important;
            border: 1px solid #e9ecef !important;
            color: #333333 !important;
        }

        .info-box svg {
            color: #007bff !important;
        }

        .info-box h3 {
            color: #2c3e50 !important;
        }

        .info-box p, .info-box li {
            color: #555555 !important;
        }

        .actions {
            background: #ffffff !important;
            border-top: 1px solid #e0e0e0 !important;
        }

        .btn {
            background: #ffffff !important;
            color: #007bff !important;
            border: 2px solid #007bff !important;
        }

        .btn.primary {
            background: #007bff !important;
            color: #ffffff !important;
        }

        .btn:hover {
            opacity: 0.9 !important;
        }

        /* Comprehensive Responsive Design for Important Information Page */

        /* Mobile Styles (320px - 767px) */
        @media (max-width: 767px) {
            body {
                padding: 16px !important;
            }
            main.card {
                padding: 20px !important;
                margin: 0 !important;
                border-radius: 12px !important;
            }
            .top h1 {
                font-size: 24px !important;
                margin-bottom: 8px !important;
            }
            .lead {
                font-size: 16px !important;
                line-height: 1.5 !important;
            }
            .info-list {
                gap: 16px !important;
            }
            .info-box {
                padding: 16px !important;
                border-radius: 8px !important;
            }
            .info-box svg {
                width: 20px !important;
                height: 20px !important;
                margin-bottom: 12px !important;
            }
            .info-box h3 {
                font-size: 18px !important;
                margin-bottom: 8px !important;
            }
            .info-box ul {
                padding-left: 20px !important;
            }
            .info-box li {
                font-size: 14px !important;
                line-height: 1.5 !important;
                margin-bottom: 6px !important;
            }
            .actions {
                flex-direction: column !important;
                gap: 12px !important;
                padding: 20px !important;
            }
            .btn {
                padding: 12px 16px !important;
                font-size: 16px !important;
                min-height: 48px !important; /* Touch target size */
                border-radius: 8px !important;
                width: 100% !important;
            }
            .btn.secondary {
                order: 2 !important; /* Back button comes after primary */
            }
        }

        /* Tablet Styles (768px - 1023px) */
        @media (min-width: 768px) and (max-width: 1023px) {
            body {
                padding: 24px !important;
            }
            main.card {
                max-width: 700px !important;
                margin: 0 auto !important;
                padding: 24px !important;
            }
            .top h1 {
                font-size: 28px !important;
            }
            .info-box {
                padding: 20px !important;
            }
            .info-box h3 {
                font-size: 20px !important;
            }
            .actions {
                gap: 16px !important;
                padding: 24px !important;
            }
            .btn {
                padding: 12px 20px !important;
                font-size: 16px !important;
                min-height: 44px !important;
            }
        }

        /* Desktop Styles (1024px+) */
        @media (min-width: 1024px) {
            main.card {
                max-width: 800px !important;
            }
            .info-list {
                display: grid !important;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)) !important;
                gap: 24px !important;
            }
            .actions {
                justify-content: flex-end !important;
                gap: 16px !important;
            }
            .btn.secondary {
                order: -1 !important; /* Back button comes first on desktop */
            }
        }

        /* Large Desktop Styles (1200px+) */
        @media (min-width: 1200px) {
            main.card {
                max-width: 900px !important;
            }
            .top h1 {
                font-size: 32px !important;
            }
            .info-box {
                padding: 24px !important;
            }
            .info-box h3 {
                font-size: 22px !important;
            }
        }

        /* Extra Large Desktop Styles (1600px+) */
        @media (min-width: 1600px) {
            main.card {
                max-width: 1000px !important;
            }
            .top h1 {
                font-size: 36px !important;
            }
            .lead {
                font-size: 20px !important;
            }
            .info-box {
                padding: 28px !important;
            }
            .info-box h3 {
                font-size: 24px !important;
            }
            .info-box p, .info-box li {
                font-size: 16px !important;
            }
        }

        /* Ultra Wide Desktop Styles (2000px+) */
        @media (min-width: 2000px) {
            main.card {
                max-width: 1200px !important;
            }
            .top h1 {
                font-size: 40px !important;
            }
            .lead {
                font-size: 22px !important;
            }
            .info-list {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 32px !important;
            }
            .info-box {
                padding: 32px !important;
            }
            .info-box h3 {
                font-size: 26px !important;
            }
            .info-box p, .info-box li {
                font-size: 18px !important;
            }
            .actions {
                padding: 32px !important;
            }
            .btn {
                padding: 16px 24px !important;
                font-size: 18px !important;
                min-height: 52px !important;
            }
        }

        /* Touch-friendly interactions */
        .btn {
            -webkit-tap-highlight-color: transparent;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .btn:active {
            transform: scale(0.98);
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            main.card {
                border: 2px solid #000 !important;
            }
            .info-box {
                border: 2px solid #000 !important;
            }
            .btn {
                border: 2px solid #000 !important;
            }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            .btn {
                transition: none !important;
            }
            .btn:active {
                transform: none !important;
            }
        }

        /* Print styles */
        @media print {
            body {
                background: white !important;
            }
            .actions {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <main class="card" role="main">
        <div class="top">

            <h1><b>Important Information</b></h1>
            <p class="lead">Please read the following carefully before proceeding to vote</p>
        </div>

        <section class="info-list" aria-labelledby="guidelines">
            <div class="info-box" id="notice">

                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v3a3 3 0 0 1-3 3H6a3 3 0 0 1-3-3V7z" stroke="#111"
                        stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div>
                <p><strong>Your vote is anonymous and will be recorded securely.</strong> Once submitted, it cannot be
                    changed.</p>
            </div>
            </div>

            <div class="info-box" id="guidelines" role="region" aria-labelledby="guidelines-heading">

                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9 12l2 2 4-5" stroke="#111" stroke-width="1.2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </div>
            <div>
                <h3 id="guidelines-heading">Voting Guidelines</h3>
                <ul>
                    <li>You can only vote once in this election.</li>
                    <li>Your vote is final and cannot be changed after submission.</li>
                    <li>Ensure you review all candidates before making your selection.</li>
                    <li>Do not share your login credentials with anyone.</li>
                </ul>
            </div>
            </div>

            <div class="info-box" id="responsibilities" role="region" aria-labelledby="resp-heading">

                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8z" stroke="#111" stroke-width="1.2"
                        stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M3 21v-1a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v1" stroke="#111" stroke-width="1.2"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
            <div>
                <h3 id="resp-heading">Voter Responsibilities</h3>
                <ul>
                    <li>You confirm that you are eligible to vote in this election.</li>
                    <li>You understand that fraudulent voting is a serious offense.</li>
                    <li>Follow instructions given by election officials if applicable.</li>
                </ul>
            </div>
            </div>

            <div class="info-box" id="privacy" role="region" aria-labelledby="privacy-heading">
                <div class="icon" aria-hidden="true">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 3c-3 0-6 1.5-6 6v3c0 4.5 3 7 6 8 3-1 6-3.5 6-8V9c0-4.5-3-6-6-6z" stroke="#111"
                            stroke-width="1.1" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div>
                    <h3 id="privacy-heading">Security & Privacy</h3>
                    <ul>
                        <li>We use encryption and secure storage to protect voting data.</li>
                        <li>Personal identifying information is used only for authentication and auditing.</li>
                        <li>For questions about privacy, contact the election administrators.</li>
                    </ul>
                </div>
            </div>

        </section>

        <div class="actions" role="group" aria-label="Proceed actions">
            <button class="btn secondary" id="backBtn" type="button" onclick="window.location='login.php'">Back</button>
            <button class="btn primary" id="agreeBtn" type="button" onclick="window.location='president.php'">I Agree & Continue</button>
        </div>
    </main>

<script>
(function () {
    const card = document.querySelector('main.card');
    if (!card) return;

    function updateScale() {
        const w = window.innerWidth;
        let scale = 1;

        if (w >= 1600) {
            scale = Math.min(1, 1400 / w + 0.1);
            if (scale < 0.8) scale = 0.8;
        }

        card.style.transform = `scale(${scale})`;
        card.style.transformOrigin = 'top center';
        card.style.transition = 'transform 0.2s ease';
    }

    window.addEventListener('resize', updateScale);
    updateScale();
})();
</script>

</body>

</html>