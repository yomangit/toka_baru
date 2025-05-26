<div>
    <div class="p-2" wire:target='store' wire:loading.class="skeleton">
        <div
            class="font-semibold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
              {{$divider}}
        </div>
            <form wire:submit.prevent='store'>
                @csrf
                @method('PATCH')
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('Department')" />
                    <x-select wire:model='department_id' :error="$errors->get('department_id')">
                        <option value="" selected>Select an option</option>
                        @foreach ($Department as $dept)
                            <option value="{{ $dept->id }}">
                                {{ $dept->department_name }}</option>
                        @endforeach
                    </x-select>
                    <x-label-error :messages="$errors->get('department_id')" />
                </div>
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('Company')" />
                    <x-select wire:model='company_id' :error="$errors->get('company_id')">
                        <option value="" selected>Select an option</option>
                        @foreach ($Company as $company)
                            <option value="{{ $company->id }}">
                                {{ $company->name_company }}</option>
                        @endforeach
                    </x-select>
                    <x-label-error :messages="$errors->get('company_id')" class="mt-0" />
                </div>
                <div>

                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-xs btn-success btn-outline">Save</button>
                    <label wire:click='closeModal' class="btn btn-xs btn-error btn-outline">Close</label>
                </div>
            </form>
        </div>
</div>
