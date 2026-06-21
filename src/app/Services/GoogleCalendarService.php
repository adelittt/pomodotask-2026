<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GoogleCalendarService
{
    protected string $baseUrl = 'https://www.googleapis.com/calendar/v3';

    public function __construct(protected User $user)
    {
    }

    /**
     * Get a valid access token. Refresh it if necessary.
     */
    protected function getAccessToken(): ?string
    {
        if (!$this->user->google_calendar_token) {
            return null;
        }

        // We assume token might be expired and just use it, 
        // ideally we would check expiry and use refresh token if needed.
        // For simplicity, we just use the refresh token to get a new access token if it fails,
        // or we can preemptively refresh if we store the expires_in.
        
        // Here is a basic implementation of token refresh
        return $this->user->google_calendar_token;
    }

    protected function refreshToken()
    {
        if (!$this->user->google_calendar_refresh_token) {
            return false;
        }

        $response = Http::post('https://oauth2.googleapis.com/token', [
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'refresh_token' => $this->user->google_calendar_refresh_token,
            'grant_type' => 'refresh_token',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $this->user->update([
                'google_calendar_token' => $data['access_token'],
            ]);
            return $data['access_token'];
        }

        return false;
    }

    /**
     * Call Google Calendar API
     */
    protected function request(string $method, string $endpoint, array $data = [])
    {
        $token = $this->getAccessToken();
        
        if (!$token) {
            return null;
        }

        $response = Http::withToken($token)
            ->$method($this->baseUrl . $endpoint, $data);

        if ($response->status() === 401) {
            // Token expired, refresh and retry
            $newToken = $this->refreshToken();
            if ($newToken) {
                return Http::withToken($newToken)
                    ->$method($this->baseUrl . $endpoint, $data)->json();
            }
            return null;
        }

        return $response->json();
    }

    public function createEvent(string $title, string $startDateTime, string $endDateTime, string $description = '')
    {
        return $this->request('post', '/calendars/primary/events', [
            'summary' => $title,
            'description' => $description,
            'start' => [
                'dateTime' => $startDateTime,
                'timeZone' => config('app.timezone'),
            ],
            'end' => [
                'dateTime' => $endDateTime,
                'timeZone' => config('app.timezone'),
            ],
        ]);
    }

    public function updateEvent(string $eventId, string $title, string $startDateTime, string $endDateTime, string $description = '')
    {
        return $this->request('put', '/calendars/primary/events/' . $eventId, [
            'summary' => $title,
            'description' => $description,
            'start' => [
                'dateTime' => $startDateTime,
                'timeZone' => config('app.timezone'),
            ],
            'end' => [
                'dateTime' => $endDateTime,
                'timeZone' => config('app.timezone'),
            ],
        ]);
    }

    public function deleteEvent(string $eventId)
    {
        return $this->request('delete', '/calendars/primary/events/' . $eventId);
    }
}
