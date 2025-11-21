<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public User $seller;

    public function __construct(User $seller)
    {
        $this->seller = $seller;
    }

    public function build()
    {
        return $this->subject('Pendaftaran Penjual EasyMart Diterima')
                    ->view('emails.sellers.approved');
    }
}
