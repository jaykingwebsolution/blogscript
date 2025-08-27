<?php

namespace App\Notifications;

use App\Models\DistributionRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Notification;

class ReleaseStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    public DistributionRequest $distributionRequest;
    public string $oldStatus;
    public string $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(DistributionRequest $distributionRequest, string $oldStatus, string $newStatus)
    {
        $this->distributionRequest = $distributionRequest;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = new MailMessage();
        
        switch ($this->newStatus) {
            case 'delivered':
                return $message
                    ->subject('🎉 Your music is now live!')
                    ->greeting('Great news!')
                    ->line("Your release '{$this->distributionRequest->song_title}' by {$this->distributionRequest->artist_name} has been delivered to all digital streaming platforms.")
                    ->line('Your music is now available on Spotify, Apple Music, and other major platforms worldwide.')
                    ->action('View Release', route('distribution.show', $this->distributionRequest))
                    ->line('Thank you for choosing our distribution service!');

            case 'processing':
                return $message
                    ->subject('Your music is being processed')
                    ->line("Your release '{$this->distributionRequest->song_title}' by {$this->distributionRequest->artist_name} is now being processed for distribution.")
                    ->line('We\'ll notify you once it\'s live on all platforms.')
                    ->action('View Status', route('distribution.show', $this->distributionRequest));

            case 'failed':
                return $message
                    ->subject('Distribution Update Required')
                    ->line("There was an issue with your release '{$this->distributionRequest->song_title}' by {$this->distributionRequest->artist_name}.")
                    ->line('Please check your submission and contact support if you need assistance.')
                    ->action('View Details', route('distribution.show', $this->distributionRequest));

            default:
                return $message
                    ->subject('Release Status Updated')
                    ->line("Your release '{$this->distributionRequest->song_title}' status has been updated to {$this->newStatus}.")
                    ->action('View Release', route('distribution.show', $this->distributionRequest));
        }
    }

    /**
     * Get the database representation of the notification.
     */
    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'release_status_updated',
            'title' => $this->getNotificationTitle(),
            'message' => $this->getNotificationMessage(),
            'data' => [
                'distribution_request_id' => $this->distributionRequest->id,
                'song_title' => $this->distributionRequest->song_title,
                'artist_name' => $this->distributionRequest->artist_name,
                'old_status' => $this->oldStatus,
                'new_status' => $this->newStatus,
                'url' => route('distribution.show', $this->distributionRequest)
            ]
        ];
    }

    /**
     * Get notification title based on status
     */
    protected function getNotificationTitle(): string
    {
        switch ($this->newStatus) {
            case 'delivered':
                return '🎉 Your music is now live!';
            case 'processing':
                return '⏳ Music being processed';
            case 'failed':
                return '❌ Distribution issue';
            default:
                return 'Release status updated';
        }
    }

    /**
     * Get notification message
     */
    protected function getNotificationMessage(): string
    {
        switch ($this->newStatus) {
            case 'delivered':
                return "'{$this->distributionRequest->song_title}' is now available on all major streaming platforms.";
            case 'processing':
                return "'{$this->distributionRequest->song_title}' is being processed for distribution.";
            case 'failed':
                return "There was an issue with '{$this->distributionRequest->song_title}'. Please review your submission.";
            default:
                return "'{$this->distributionRequest->song_title}' status updated to {$this->newStatus}.";
        }
    }
}
