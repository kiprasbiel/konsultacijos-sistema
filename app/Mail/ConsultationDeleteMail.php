<?php

namespace App\Mail;

use App\Exports\ConsultationDeleteExport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ConsultationDeleteMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $main_theme)
    {
        $this->data = $data;
        $this->main_theme = $main_theme;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.consultations.email-delete')
            ->attach(Excel::download(new ConsultationDeleteExport($this->data, $this->main_theme),'atsaukta.xlsx')
                ->getFile(), ['as' => 'atsaukta.xlsx'])
            ->subject('Atšauktos konsultacijos');
    }
}
