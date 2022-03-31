<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class EmailVerificationHelper
{
    public static function sendEmail($user)
    {
        try {
            $details = [
                'title' => 'YachtFindr - Verify your account',
                'panel' => 'Welcome to Yacht Findr. Thank you for your registration, please verify your account.',
                'body' => '',
                'link' => url('/email-verification/'.$user->uuid),
                'link_title' => 'Verify email'
            ];
           Mail::to($user->email)->send(new SendMail($details));
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
