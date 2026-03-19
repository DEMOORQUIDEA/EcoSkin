<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    
    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(\Illuminate\Http\Request $request)
    {
        \Illuminate\Support\Facades\Log::info('Password reset request received for email: ' . $request->email);
        
        try {
            $response = $this->traitSendResetLinkEmail($request);
            \Illuminate\Support\Facades\Log::info('Password reset link processed. Response status: ' . session('status'));
            return $response;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error sending password reset email: ' . $e->getMessage());
            \Illuminate\Support\Facades\Log::error($e->getTraceAsString());
            throw $e;
        }
    }

    // Rename the trait method to avoid collision
    use SendsPasswordResetEmails {
        sendResetLinkEmail as traitSendResetLinkEmail;
    }
}
