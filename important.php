<?php
session_start();
$message = "";
require_once "connection.php";

?>
<html>

<head>
    <link rel="stylesheet" href="style.css">
    <style>

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
            <button class="btn secondary" id="backBtn" type="button">Back</button>
            <button class="btn primary" id="agreeBtn" type="button">I Agree & Continue</button>
        </div>
    </main>
    </div>
</body>

</html>