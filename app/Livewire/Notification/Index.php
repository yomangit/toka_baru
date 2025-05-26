<?php

namespace App\Livewire\Notification;

use Livewire\Component;

class Index extends Component
{
    public $searching = "", $hidden = false, $seleted_notif = [];
    public function render()
    {
        $this->hidden = count($this->seleted_notif) <= 1;
        $allNotification  = auth()->user()->notifications;
        $unRead = auth()->user()->unreadNotifications;
        return view('livewire.notification.index', [
            'AllNotification' => $allNotification,
            'Unread' =>  $unRead
        ]);
    }
    public function readNotification($id, $url)
    {
        if ($url) {
            $notificationId = $id;
            $userUnreadNotification = auth()->user()->unreadNotifications->where('id', 'like', $notificationId)->first();
            if ($userUnreadNotification) {
                $userUnreadNotification->markAsRead();
                return redirect($url);
            }
        }
    }
    public function goTo($id, $url)
    {
        if ($url) {
            $userUnreadNotification = auth()->user()->notifications->where('id', 'like', $id)->whereNull('read_at')->first();
            if ($userUnreadNotification) {
                $userUnreadNotification->markAsRead();
                return redirect($url);
            }
            return redirect($url);
        }
    }
    public function delete($id)
    {
        $userDeleteNotification = auth()->user()->notifications->where('id', 'like', $id)->first();
        if ($userDeleteNotification) {
            $userDeleteNotification->delete();
        }
    }
    public function deleteCheked()
    {

        $main =  auth()->user()->notifications->whereIn('id', $this->seleted_notif)->pluck('id');

        foreach ($main as $key => $value) {
            $userDeleteNotification = auth()->user()->notifications->where('id', 'like', $value)->first();
            if ($userDeleteNotification) {
                $userDeleteNotification->delete();
                $this->seleted_notif = [];
            }
        }
        $this->dispatch(
            'alert',
            [
                'text' => "data successfully deleted!!",
                'duration' => 3000,
                'destination' => '/contact',
                'newWindow' => true,
                'close' => true,
                'backgroundColor' => "linear-gradient(to right, #ff3333, #ff6666)",
            ]
        );
    }
}
