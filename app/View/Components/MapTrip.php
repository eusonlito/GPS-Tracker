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
        readonly public bool $sidebarHidden = false,
        readonly public bool $userShow = false,
        readonly public bool $vehicleShow = false,
        readonly public bool $deviceShow = false,
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
