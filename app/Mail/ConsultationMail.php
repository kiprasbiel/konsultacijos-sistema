<?php

namespace App\Mail;

use App\Exports\ConsultationExport;
//use http\Env\Request;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ConsultationMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $updated_data)
    {
        $this->data = $data;
        $this->updated_data = $updated_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (empty($this->updated_data)){
            $view = 'emails.consultations.email';
        }
        else {
            $view = 'emails.consultations.email-change';
        }
        return $this->markdown($view)
            ->attach(Excel::download(new ConsultationExport($this->data, $this->updated_data),'konsultacijos.xlsx')
                ->getFile(), ['as' => 'konsultacijos.xlsx'])
            ->subject('Naujos konsultacijos');
    }
}
