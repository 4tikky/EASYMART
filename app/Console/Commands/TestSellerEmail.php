<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\Seller;
use App\Mail\SellerRegisteredMail;

class TestSellerEmail extends Command
{
    protected $signature = 'test:seller-email {seller_id}';
    protected $description = 'Test sending seller registration email';

    public function handle()
    {
        $sellerId = $this->argument('seller_id');
        $seller = Seller::find($sellerId);

        if (!$seller) {
            $this->error('Seller not found!');
            return 1;
        }

        $this->info('Sending email to: ' . $seller->picEmail);
        
        Mail::to($seller->picEmail)->send(new SellerRegisteredMail($seller));
        
        $this->info('Email sent successfully!');
        $this->info('Check your log file at: storage/logs/laravel.log');
        
        return 0;
    }
}
