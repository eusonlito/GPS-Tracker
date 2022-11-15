<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class NotificationUpdateClosedAt extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'device_alarm_notification_id' => ['bail', 'required', 'integer'],
        ];
    }
}
