// Import necessary modules
const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');

const app = express();
const PORT = process.env.PORT || 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json()); // Parse JSON bodies

// Sample endpoint to handle payment processing
app.post('/process-payment', (req, res) => {
    const { amount, paymentMethod } = req.body;

    // Simulate payment processing logic
    if (amount && paymentMethod) {
        // Here you would integrate with a payment gateway (e.g., Stripe, PayPal)
        console.log(`Processing payment of ${amount} using ${paymentMethod}`);
        
        // Send a success response
        res.status(200).json({ message: 'Payment processed successfully!' });
    } else {
        // Send an error response
        res.status(400).json({ error: 'Amount and payment method are required.' });
    }
});

// Start the server
app.listen(PORT, () => {
    console.log(`Server is running on http://localhost:${PORT}`);
});
