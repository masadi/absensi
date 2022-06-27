<div>
    <div wire:ignore.self>
        <x-jet-form-section submit="store">
            <x-slot name="title">
            {{ __('Akun Sosial Media') }}
            </x-slot>
        
            <x-slot name="description">
            {{ __('Silahkan tambahkan akun sosial media dibawah ini bagi yang memiliki.') }}
            </x-slot>
            <x-jet-action-message on="tersimpan">
                {{ __('Tersimpan.') }}
            </x-jet-action-message>
            <x-slot name="form">
                <div class="mb-1">
                    <input type="hidden" wire:model.defer="user_id">
                    <x-jet-label class="form-label" for="whatsapp" value="{{ __('Nomor Whatsapp') }}" />
                    <x-jet-input id="whatsapp" type="text" class="{{ $errors->has('whatsapp') ? 'is-invalid' : '' }}"
                    wire:model.defer="whatsapp" autocomplete="whatsapp" />
                    <x-jet-input-error for="whatsapp" />
                </div>
                <div class="mb-1">
                    <x-jet-label class="form-label" for="facebook" value="{{ __('Akun Facebook') }}" />
                    <x-jet-input id="facebook" type="text"
                    class="{{ $errors->has('facebook') ? 'is-invalid' : '' }}" wire:model.defer="facebook"
                    autocomplete="facebook" />
                    <x-jet-input-error for="facebook" />
                </div>
                <div class="mb-1">
                    <x-jet-label class="form-label" for="instagram" value="{{ __('Akun Instagram') }}" />
                    <x-jet-input id="instagram" type="text"
                    class="{{ $errors->has('instagram') ? 'is-invalid' : '' }}" wire:model.defer="instagram"
                    autocomplete="instagram" />
                    <x-jet-input-error for="instagram" />
                </div>
                <div class="mb-1">
                    <x-jet-label class="form-label" for="youtube" value="{{ __('Akun YouTube') }}" />
                    <x-jet-input id="youtube" type="text"
                    class="{{ $errors->has('youtube') ? 'is-invalid' : '' }}" wire:model.defer="youtube"
                    autocomplete="youtube" />
                    <x-jet-input-error for="youtube" />
                </div>
                <div class="mb-1">
                    <x-jet-label class="form-label" for="tiktok" value="{{ __('Akun TikTok') }}" />
                    <x-jet-input id="tiktok" type="text"
                    class="{{ $errors->has('tiktok') ? 'is-invalid' : '' }}" wire:model.defer="tiktok"
                    autocomplete="tiktok" />
                    <x-jet-input-error for="tiktok" />
                </div>
                <div class="mb-1">
                    <x-jet-label class="form-label" for="twitter" value="{{ __('Akun Twitter') }}" />
                    <x-jet-input id="twitter" type="text"
                    class="{{ $errors->has('twitter') ? 'is-invalid' : '' }}" wire:model.defer="twitter"
                    autocomplete="twitter" />
                    <x-jet-input-error for="twitter" />
                </div>
            </x-slot>
        
        
            <x-slot name="actions">
            <x-jet-button>
                {{ __('Simpan') }}
            </x-jet-button>
            </x-slot>
        </x-jet-form-section>      
    </div>
</div>
