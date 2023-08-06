<?php


namespace App\Contracts;


interface NotificationContract extends Base\CrudContract
{
    public function sendAdminNotification($id);
}
