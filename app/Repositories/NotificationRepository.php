<?php


namespace App\Repositories;

use App\Models\AdminNotification;
use App\Models\User;
use App\Services\FirebaseFCM;
use App\Traits\UploadAble;
use Kreait\Firebase\Messaging\CloudMessage;

class NotificationRepository extends BaseRepositories implements \App\Contracts\NotificationContract
{
    use UploadAble;

    /**
     * @param AdminNotification $model
     * @param array $filters
     */
    public function __construct(AdminNotification $model, array $filters = [
        \App\QueryFilter\Search::class,
    ])
    {
        parent::__construct($model, $filters);
    }

    /**
     * @inheritDoc
     */
    public function new(array $data)
    {
        if (array_key_exists('image',$data))
        {
            $data['image'] = $this->uploadOne($data['image'],'notifications/image');
        }
        return AdminNotification::create($data);
    }

    /**
     * @inheritDoc
     */
    public function update($id, array $data)
    {
        $notification = $this->findOneById($id);
        if (array_key_exists('image',$data))
        {
            if ($notification->image)
            {
                $this->deleteOne($notification->image);
            }
            $data['image'] = $this->uploadOne($data['image'],'notifications/image');
        }
        $notification->update($data);
        return $notification;
    }

    /**
     * @inheritDoc
     */
    public function destroy($id)
    {
        return AdminNotification::destroy($id);
    }

    public function sendAdminNotification($id)
    {
        $notification = $this->findOneById($id);

        $tokens = User::whereNotNull('fcm_token')->groupBy('fcm_token')->pluck('fcm_token')->toArray();

        if (count($tokens) > 0)
        {
            (new FirebaseFCM($notification->title,$notification->message))->sendMulticastDeviceNotification($tokens);
        }
    }
}
