<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericMailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The Data to be passed to View.
     *
     * @var  Array
     */
    public $data;

    /**
     * The blade file name with path.
     *
     * @var  string
     */
    public $view;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$viewName)
    {
        $this->data = $data;
        $this->view = $viewName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->view)->with($this->data)->subject('Account Update');
    }
}
