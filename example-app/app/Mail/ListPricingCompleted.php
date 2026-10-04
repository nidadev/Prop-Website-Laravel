<?php
namespace App\Mail;
use Illuminate\Mail\Mailable;
class ListPricingCompleted extends Mailable {
    public function __construct(public int $uploadId, public bool $needsReview) {}
    public function build() {
        return $this->subject('Your Propelyze list pricing is ready')->view('emails.list-pricing-completed');
    }
}
