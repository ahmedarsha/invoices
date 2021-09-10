<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class invoiceCreated extends Notification
{
    use Queueable;
    private $invoice_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     $url = url('/invoiceDetails/'.$this->invoice_id);

    //     return (new MailMessage)
    //             ->greeting('مرحبا!')
    //             ->subject(' اضافه فاتوره جديده!')
    //             ->line('تم اضافه فاتوره جديده  !')
    //             ->action('عرض الفاتوره', $url)
    //             ->line('شكرا لاستخدامك موقعنا  !');

    // }

    public function toDatabase($notifiable)
    {
        return [
           'id' => $this->invoice_id,
           'title' => 'تم اضافه فاتوره جديده بواسطه : ',
           'user' => Auth::user()->name
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array 
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
