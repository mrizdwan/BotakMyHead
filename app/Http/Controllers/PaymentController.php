<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Show the payment form
    public function showPaymentForm()
    {
        return view('payment.form'); // Ensure this view exists
    }

    // Process the payment
    public function processPayment(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'ca_code' => 'required|string',
            'buyeremail' => 'required|email',
            'phoneno' => 'required|string',
            'plan' => 'required|in:standard,plus',
        ]);

        // Capture form data
        $ca_code = $request->input('ca_code');
        $email = $request->input('buyeremail');
        $telefon = $request->input('phoneno');
        $plan = $request->input('plan');

        session(['ca_code' => $ca_code, 'plan' => $plan]);

        // Determine price based on selected plan
        $harga = $plan === 'standard' ? 19 : 38; // RM19 for standard, RM38 for plus
        $rmx100 = $harga * 100; // Convert to cents

        // Prepare data for ToyyibPay
        $some_data = [
            'userSecretKey' => env('TOYYIBPAY_SECRET_KEY'),
            'categoryCode' => env('TOYYIBPAY_CATEGORY_CODE'),
            'billName' => 'Payment for ' . ucfirst($plan) . ' Plan',
            'billDescription' => 'Payment for ' . ucfirst($plan) . ' Plan - RM' . $harga,
            'billPriceSetting' => 1,
            'billPayorInfo' => 1,
            'billAmount' => $rmx100,
            'billReturnUrl' => route('payment.success', ['ca_code' => $ca_code, 'plan' => $plan]),// Ensure it points to the success page
            'billCallbackUrl' => route('payment.callback'),
            'billExternalReferenceNo' => uniqid(),
            'billTo' => $ca_code,
            'billEmail' => $email,
            'billPhone' => $telefon,
            'billSplitPayment' => 0,
            'billSplitPaymentArgs' => '',
            'billPaymentChannel' => 0,
        ];

        // Initialize cURL
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/createBill');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);

        // Execute cURL and get response
        $result = curl_exec($curl);
        curl_close($curl);

        // Decode JSON response
        $obj = json_decode($result, true);

        // Check for errors
        if (isset($obj[0]['BillCode'])) {
            $billcode = $obj[0]['BillCode'];

            // Redirect to payment gateway
            return redirect()->away("https://dev.toyyibpay.com/{$billcode}");
        }

        // Handle failure
        return redirect()->back()->with('error', 'Failed to create payment. Please try again.');
    }

    public function handlePaymentCallback(Request $request)
    {
        // Retrieve payment data from the request
        $billCode = $request->input('billCode');
        $status = $request->input('billpaymentStatus');
    
        // Check the payment status
        if ($status == '1') {
            // Payment was successful
            // You may want to store or process additional info here
            
            // You can pass these values to the success route
            return redirect()->route('payment.success', [
                'ca_code' => $request->input('ca_code'), // Ensure this is sent in the callback
                'plan' => $request->input('plan') // Ensure this is sent in the callback
            ]);
        }
    
        return redirect()->back()->with('error', 'Payment failed');
    }
    

}
