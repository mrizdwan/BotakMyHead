<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Payment Successful!</h1>
        <p>Your payment has been processed successfully. Please wait while we verify your information.</p>
        <p>Your CA Code: <strong>{{ request('ca_code') }}</strong></p>
        <div id="statusMessage"></div>
        <div id="res"></div> <!-- Add this line to create the 'res' div -->
    </div>
    <script type="module">
     
        import { handleFormSubmit } from '/js/payment.js'; // Update with the correct path

        // Handle form submission
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            const caCode = urlParams.get('ca_code');
            const currentPlan = urlParams.get('plan');

            if (!caCode || !currentPlan) {
                document.getElementById('statusMessage').innerText = 'Error: Missing information.';
                throw new Error("Missing parameters: ca_code or plan.");
            }

            // Ensure handleFormSubmit is defined before calling it
            if (typeof handleFormSubmit === 'function') {
                handleFormSubmit(caCode, currentPlan);
            } else {
                console.error("handleFormSubmit is not defined.");
            }
        });
    </script>

<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-firestore.js"></script>
    <script type="module" src="{{ asset('js/payment.js') }}"></script>
</body>
</html>
