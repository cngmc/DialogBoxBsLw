<?php

namespace Cngmc\DialogBoxBsLw\Tests\Feature;

use Orchestra\Testbench\TestCase;

class DialogBoxTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->registerTestRoutes();
        $this->app['config']->set('app.key', 'base64:VeY/lVfIDF+b0W/fJtMSfuK6EcZQbFwj7evQ7kVZ0I0=');
        $this->app->register(\Livewire\LivewireServiceProvider::class);
    }

    protected function getPackageProviders($app): array
    {
        return [
            \Cngmc\DialogBoxBsLw\DialogBoxBsLwServiceProvider::class,
        ];
    }
    protected function registerTestRoutes(): void
    {
        \Illuminate\Support\Facades\Route::get('/tek', function () {
            return 'tek';
        })->name('tek');
    }

    public function test_the_application_returns_a_successful_response(): void
    {
        // \Livewire\Livewire::component('dynamic-component', SampleLivewireComponent::class);

        $result = \Livewire\Livewire::test(SampleLivewireComponent::class)
            ->assertSet('dialogBoxes', '')
            ->call('dialogBox', 'sample', 'openFn', 1)
            ->assertDispatched('dialogBoxEventListener')
            ->call('dialogBox','sample', 'acceptFn', 1)
            ->assertReturned([
                'function' => 'acceptFn',
                'params' => [1]
            ]);

        $result = \Livewire\Livewire::test(SampleLivewireComponent::class)
            ->call('dialogBox', 'sample', 'openFn', 2)
            ->assertDispatched('dialogBoxEventListener')
            ->call('dialogBox','sample', 'cancelFn', 2)
            ->assertReturned([
                'function' => 'cancelFn',
                'params' => [2]
            ]);
    }
}

class SampleLivewireComponent extends \Livewire\Component
{
    use \Cngmc\DialogBoxBsLw\Traits\DialogBox;
    public function boot(): void
    {
        $dialogBox = [
            "box" => [
                'name' => 'sample',
                'id' => 'dialogbox-sample', // Bootstrap modal ID
                "contents" => [
                    'title' => 'Sample Title',
                    'body' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.",
                    'cancelButtonText' => "Cancel",
                    'actionButtonText' => "Accept"
                ],
            ],
            'acceptFn' => function () {
                return $this->accept($this->dialogBoxes['sample']['box']['params'][0]);
            },
            'cancelFn' => function () {
                return $this->cancel($this->dialogBoxes['sample']['box']['params'][0]);
            }
        ];

        $this->setDialogBox('sample', $dialogBox);
    }

    private function accept(...$params): array
    {
        return ['function' => 'acceptFn', 'params' => $params];
    }

    private function cancel(...$params): array
    {
        return ['function' => 'cancelFn', 'params' => $params];
    }

    public function render(): String
    {
        return <<<'HTML'
            <div>
                <x-dialogboxbslw::dialog modal="dialogbox-sample"/>
            </div>
        HTML;
    }
}
