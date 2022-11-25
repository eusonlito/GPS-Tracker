<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Http\JsonResponse;
use App\Domains\Alarm\Model\Alarm as Model;

class UpdateBoolean extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(int $id): JsonResponse
    {
        $this->row($id);

        return $this->json($this->fractal($this->actionCall('execute')));
    }

    /**
     * @return \App\Domains\Alarm\Model\Alarm
     */
    protected function execute(): Model
    {
        return $this->action()->updateBoolean();
    }

    /**
     * @param \App\Domains\Alarm\Model\Alarm $alarm
     *
     * @return array
     */
    protected function fractal(Model $alarm): array
    {
        return $this->factory()->fractal('simple', $alarm);
    }
}
