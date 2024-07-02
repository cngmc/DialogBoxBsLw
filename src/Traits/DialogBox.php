<?php
namespace Cngmc\DialogBoxBsLw\Traits;

trait DialogBox {
    /**
     * This trait is using livewire feature.
     */
    protected array $dialogBoxes = [];

    public final function setDialogBox(string $name, array $dialogBox): void
    {
        $dialogBox['box']['display'] = $this->dialogBoxe['box']['display'] ?? 'show';
        $this->dialogBoxes[$name] = $dialogBox;
    }

    public final function dialogBox(string $name, string $mode, ...$params): mixed
    {
        if (!isset($this->dialogBoxes[$name])) {
            throw new \Exception("Dialog box '{$name}' not found.");
        }

        $this->dialogBoxes[$name]['box']['params'] = $params;
        $this->dialogBoxes[$name]['box']['name'] = $name;

        return match($mode) {
            'openFn' => $this->dialogBoxOpenFn($name, $this->dialogBoxes[$name]['box']['params']),
            'acceptFn' =>  $this->dialogBoxes[$name]['acceptFn'](),
            'cancelFn' => $this->dialogBoxes[$name]['cancelFn'](),
            default => throw new \Exception('Unsupported'),
        };
    }

    private function dialogBoxOpenFn(string $name, ...$params): bool
    {
        $this->dispatch('dialogBoxEventListener', $this->dialogBoxes[$name]['box']);

        return true;
    }
}
