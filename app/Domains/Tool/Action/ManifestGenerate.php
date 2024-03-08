<?php declare(strict_types=1);

namespace App\Domains\Tool\Action;

class ManifestGenerate extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->save();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        file_put_contents(public_path('manifest.json'), helper()->jsonEncode($this->contents()));
    }

    /**
     * @return array
     */
    protected function contents(): array
    {
        return [
            'name' => config('app.name'),
            'short_name' => config('app.name'),
            'start_url' => config('app.url'),
            'scope' => config('app.url'),
            'theme_color' => 'white',
            'background_color' => 'white',
            'display' => 'standalone',
            'orientation' => 'any',
            'icons' => [
                [
                    'src' => asset('/build/images/webapp/logo.png'),
                    'type' => 'image/png',
                ],
            ],
            'splash_screens' => [
                [
                    'src' => asset('/build/images/webapp/startup.png'),
                    'type' => 'image/png',
                ],
            ],
        ];
    }
}
