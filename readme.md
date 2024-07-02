# Dialog Box Bs(Bootstrap) Lw(Livewire)
- version: 1.0 beta


  bla bla..
## Installation, Requirements and Usage Instructions

### Installation
```terminal
composer require cngmc/dialogboxbslw
```

### Requirements

- [Livewire](https://livewire.laravel.com/)
- Bootstrap 5
- jQuery

###  Basic Usage Instructions

Sample Livewire component (livewire/sample.php)
```php
    public function boot(): void
    {
        $dialogBox = [
            "box" => [
                'name' => 'sample',
                'id' => 'dialogbox-sample', // Bootstrap modal ID
                "contents" => [
                    'title' => 'Sample Title',
                    'body' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.",
                    'cancelButtonText' => "Cancel",
                    'actionButtonText' => "Accept"
                ],
            ],
            'acceptFn' => function () {
                return $this->accept($this->dialogBoxes['sample']['box']['params'][0], $this->dialogBoxes['sample']['box']['params'][1]);
            },
            'cancelFn' => function () {
                return $this->cancel($this->dialogBoxes['sample']['box']['params'][0], $this->dialogBoxes['sample']['box']['params'][1]);
            }
        ];

        $this->setDialogBox('sample', $dialogBox);
    }


    private function accept($param1, $param2)
    {
        return 'accepted';
    }

    private function cancel($param1, $param2)
    {
        return 'canceled';
    }


```
Sample Livewire component blade file (livewire/sample.blade.php)
```html
    <button wire:click="dialogBox('sample', 'openFn', '1', 'Test')" class="btn btn-primary">Open Dialog</button>
    <x-dialogboxbslw::dialog modal="dialogbox-sample" />
```
## Advanced Usage

### Customization View

```
php artisan vendor:publish --tag=dialogboxbslw --force
```

You can make the necessary adjustments for customized component design in the
<span style="font-family:monospace;font-size:12px;">resources/views/vendor/dialogboxbslw/components/dialog.blade.php</span> file.


### Using dynamic data in dialog 
Sample Livewire component (sample.php)
```
    use DialogBox {
        DialogBox::dialogBoxOpenFn as private parentDialogBoxOpenFn;
    }

    private function dialogBoxOpenFn($name, $params): bool
    {
        $this->dialogBoxes[$name]['box']['contents']['title'] = 'Custom Title Params 0: ' . $params[0]. ' Params 1: ' . $params[1];        $this->dialogBoxes[$name]['box']['contents']['title'] = 'Custom Title Params 0: ' . $params[0]. ' Params 1: ' . $params[1];
        
        $this->parentDialogBoxOpenFn($name);
    }
```

### Testing

``` bash
vendor/bin/phpunit
```

### License
The DialogBoxBsLw package is open-sourced software licensed under the [MIT license](./license).
