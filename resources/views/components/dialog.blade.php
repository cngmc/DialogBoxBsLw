@props(['modal'])
<div>
    <div wire:ignore.self wire:key="id" x-data="dialogBox" class="modal" id="{{$modal}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border:none !important;">
                <div class="modal-body" style="padding:1.5rem!important;">

                    <h5 class="modal-title text-black" x-text="title">...</h5>
                    <p class="text-black" x-html="body">...</p>

                    {{$slot}}

                    <button wire:loading.attr="disabled" type="button" class="btn btn-primary float-end me-2"  x-on:click="$wire.dialogBox(name,'acceptFn', ...params)" data-bs-dismiss="modal" style="min-width:125px">
                        <div wire:loading.remove  wire:target="dialogBox"  x-html="actionButtonText">...</div>
                        <div wire:loading wire:target="dialogBox" class="spinner-border spinner-border-sm" role="status"></div>
                    </button>

                    <button x-on:click="$wire.dialogBox(name,'cancelFn', ...params)" data-bs-dismiss="modal" wire:loading.attr="disabled" type="button" class="btn btn-secondary float-end me-2" style="min-width:100px">
                        <div wire:loading.remove  wire:target="dialogBox('cancelFn')"  x-html="cancelButtonText">...</div>
                        <div wire:loading wire:target="dialogBox('cancelFn')" class="spinner-border spinner-border-sm" role="status"></div>
                    </button>

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dialogBox', () => ({
                init() {
                    window.addEventListener('dialogBoxEventListener', this.handleDialogBoxEvent.bind(this));
                },
                handleDialogBoxEvent(event) {
                    const { id, name, contents = {}, params = [], display } = event.detail[0];
                    Object.assign(this, { id, name, ...contents, params });

                    this.displayModal(display);
                },
                displayModal(display) {
                    $(`#${this.id}`).modal(display);
                }
            }));
        });
    </script>
</div>
