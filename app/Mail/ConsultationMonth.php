<?php

namespace App\Mail;

use App\Exports\ConsultationMonthExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ConsultationMonth extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.consultations.email')
            ->attach(Excel::download(new ConsultationMonthExport($this->data),'menesio-ataskaita.xlsx')->getFile(), ['as' => 'menesio-ataskaita.xlsx']);
    }
}
