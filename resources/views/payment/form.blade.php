<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://www.gstatic.com/firebasejs/9.1.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.1.2/firebase-firestore.js"></script>
    <script src="{{ asset('js/payment.js') }}" defer></script> <!-- Load external JS -->
</head>
<body>
    <div class="container">
        <h1>Payment Form</h1>

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('payment.process') }}" method="POST">
            @csrf
            <div>
                <label for="ca_code">CA Code:</label>
                <input type="text" id="ca_code" name="ca_code" required>
            </div>
            <div>
                <label for="buyeremail">Email:</label>
                <input type="email" id="buyeremail" name="buyeremail" required>
            </div>
            <div>
                <label for="phoneno">Phone Number:</label>
                <input type="tel" id="phoneno" name="phoneno" required>
            </div>
            <div>
                <label for="plan">Select Plan:</label>
                <select id="plan" name="plan" required>
                    <option value="">Choose...</option>
                    <option value="standard">Standard Plan - RM19</option>
                    <option value="plus">Plus Plan - RM38</option>
                </select>
            </div>
            <button type="submit">Pay Now</button>
        </form>
    </div>
</body>
</html>
