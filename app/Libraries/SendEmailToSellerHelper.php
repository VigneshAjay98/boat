<?php

namespace App\Libraries;

use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class SendEmailToSellerHelper
{
    public static function sendEmail($email, $message)
    {
        try {
            $details = [
                'title' => 'YachtFindr - Message',
                'panel' => '',
                'body' => $message,
                'link' => '',
                'link_title' =>''
            ];
           Mail::to($email)->send(new SendMail($details));
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
