<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TokenGeneratedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function sendNotificationViaApi(Request $request)
{
    // Validate and process the request data as needed

    // Find the user or recipient by their ID or other criteria
   // $user = User::find($request->user_id);

    // if (!$user) {
    //     return response()->json(['error' => 'User not found'], 404);
    // }

    // Create a notification instance
   // $notification = new TokenGeneratedNotification($request->token);

    // Send the notification to the user
   // Notification::send($user, $notification);

    return response()->json(['message' => 'Notification sent successfully']);
}
}
