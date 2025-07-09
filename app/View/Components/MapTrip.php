<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class MapTrip extends Component
{
    /**
     * @param bool $sidebarHidden = false
     * @param bool $userShow = false
     * @param bool $vehicleShow = false
     * @param bool $deviceShow = false
     *
     * @return self
     */
    public function __construct(
        public readonly bool $sidebarHidden = false,
        public readonly bool $userShow = false,
        public readonly bool $vehicleShow = false,
        public readonly bool $deviceShow = false,
    ) {
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('components.map-trip', [
            'id' => uniqid(),
        ]);
    }
}
