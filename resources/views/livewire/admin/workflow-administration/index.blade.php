<div>
    <x-notification />

    <div class="">
        <div class="divider divider-neutral">
            <span
                class="font-mono text-sm font-semibold bg-clip-text text-transparent bg-gradient-to-r from-emerald-500 to-orange-500">
                {{ __('Workflow Template') }}
            </span>

        </div>
        <div> <x-btn-add data-tip="Add data"
                wire:click="$dispatch('openModal', { component: 'admin.workflow-administration.create-and-update' })" />
        </div>
        <div class="w-full max-w-xs xl:max-w-xs form-control">
            <x-label-no-req :value="__('Workflow Template Name')" />
            <div class="dropdown ">
                <x-inputsearch wire:model.live='template_name' class="cursor-pointer" readonly tabindex="0"
                    role="button" />
                <ul tabindex="0"
                    class="dropdown-content menu menu-xs bg-base-300  rounded-box z-[1] mt-0.5 w-auto p-2 shadow">
                    <li class="menu-title">
                        <div class="mb-2"><x-inputsearch name='search' wire:model.live='search_report_by'
                                placeholder="{{ __('search_people') }}" /></div>
                    </li>
                    <li class="menu-item">
                        <ul class="list-inside h-auto overflow-x-auto">
                            @forelse ($WorkflowAdministration as $item)
                                <li
                                    class="hover:bg-slate-200 cursor-pointer text-xs" >
                                    <div class="grid grid-cols-2 gap-4">
                                        <div wire:click="send_templates({{ $item->id }},'{{ $item->workflow_template_name }}')"> {{ $item->workflow_template_name }}</div>
                                        <div>
                                            <x-icon-btn-edit data-tip="Edit"
                                                wire:click="$dispatch('openModal', { component: 'admin.workflow-administration.create-and-update', arguments: { wk: {{ $item->id }} }})" />
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li class="bg-clip-text text-transparent bg-gradient-to-r from-rose-400 to-rose-800">
                                    {{ __('dataNotFound') }}</li>
                            @endforelse
                        </ul>
                    </li>

                </ul>
            </div>
            <x-label-error :messages="$errors->get('report_byName')" />
        </div>
        @if ($hidden)
            <div class="">
                <div class="divider divider-accent">
                    <span
                        class="font-mono text-sm font-semibold bg-clip-text text-transparent bg-gradient-to-r from-emerald-500 to-orange-500">
                        {{ __('Workflow Applicable To') }}
                    </span>
                </div>
                <div class="m-2"> @livewire('admin.workflow-applicable.index', ['template_id' => $template_id])</div>
                <div class="divider divider-secondary">
                    <span
                        class="font-mono text-sm font-semibold bg-clip-text text-transparent bg-gradient-to-r from-emerald-500 to-orange-500">
                        {{ __('Workflow Step Details') }}
                    </span>
                </div>
                <div class="m-2"> @livewire('admin.workflow-step-detail.index', ['template_id' => $template_id])</div>

            </div>
        @endif


    </div>
