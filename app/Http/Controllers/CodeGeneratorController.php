<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CodeGeneratorController extends Controller
{
    public function generateCode(Request $request)
    {
        $userId = $request->input('userId');
        $generatedCode = $this->csr($userId, $this->getTarikhShortYearSum());

        // Save generated code to your database or Firestore if needed

        return response()->json(['code' => $generatedCode]);
    }

    private function csr($msg, $key)
    {
        $c = [];
        $msg = strtoupper($msg);
        $key = (int)$key;

        for ($i = 0; $i < strlen($msg); $i++) {
            $x = ((ord($msg[$i]) - 65) + $key++) % 26;
            $c[] = chr($x + 65);
        }

        return implode('', $c);
    }

    private function getTarikhShortYearSum()
    {
        $shortYear = date('y');
        return array_sum(str_split($shortYear));
    }
}
