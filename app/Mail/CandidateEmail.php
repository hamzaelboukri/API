<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CandidateEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $candidate;
    public $message;

    public function __construct($candidate, $message)
    {
        $this->candidate = $candidate;
        $this->message = $message;
    }

    public function build()
    {
        return $this->subject('Candidate Email')
                    ->view('emails.candidate_email')
                    ->with([
                        'candidate' => $this->candidate,
                        'message' => $this->message,
                    ]);
    }
}