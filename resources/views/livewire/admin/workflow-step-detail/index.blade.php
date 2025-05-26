<div>
   
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div><x-btn-add data-tip="Add" wire:click="$dispatch('openModal', { component: 'admin.workflow-step-detail.create-and-update', arguments: { template: {{ $template }} }})" /></div>
        <div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-xs table-zebra">
            <thead>
                <th>Step Properties</th>
                <th>Step Transitions</th>
                <th>Action</th>
            </thead>
            <tbody>
                <form wire:submit.prevent='store'>

                    @forelse ($Workflowdetails as $index => $step)
                        <tr class="">
                            <td>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('ID Number')" />
                                        <h2 class="font-semibold text-sm font-serif">: {{ $step->id }}</h2>
                                    </div>
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('name')" />
                                        <h2 class="font-semibold text-sm font-serif">: {{ $step->name }}</h2>
                                    </div>
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('description_wf')" />
                                        <h2 class="font-semibold text-sm font-serif">: {{ $step->description }}</h2>
                                    </div>
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('status_code')" />
                                        <h2 class="font-semibold text-sm font-serif">: {{ $step->Status->status_name }}</h2>
                                    </div>
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('responsible_role')" />
                                        <h2 class="font-semibold text-sm font-serif">: {{ $step->ResponsibleRole->responsible_role_name }}
                                        </h2>

                                    </div>
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('is_cancel_step')" />
                                        <h2 class="font-semibold text-sm font-serif">: {{ $step->is_cancel_step }}</h2>
                                    </div>
                                </div>
                            </td>
                            <td class="">
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('Destination_1')" />
                                        <h2 class="font-semibold text-sm font-serif">: {{ $step->destination_1}}</h2>
                                    </div>
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('destination_1_label')" />
                                        <h2 class="font-semibold text-sm font-serif">: {{ $step->destination_1_label }}
                                        </h2>
                                    </div>
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('Destination_2')" />
                                        <h2 class="font-semibold text-sm font-serif">: {{ $step->destination_2 }}
                                    </div>
                                </div>
                                <div class="w-full max-w-md xl:max-w-xl form-control m-1">
                                    <div class=" sm:flex items-center">
                                        <x-label-no-req class=" w-32" :value="__('destination_2_label')" />
                                        <h2 class="font-semibold text-sm font-serif">: {{ $step->destination_2_label }}
                                    </div>
                                </div>
                            </td>
                            <td class="flex flex-row gap-1 justify-center">
                                <x-icon-btn-edit data-tip="Edit"
                                    wire:click="$dispatch('openModal', { component: 'admin.workflow-step-detail.create-and-update', arguments: {template: {{ $template }} , wd: {{ $step->id }} }})" />
                                <x-icon-btn-delete wire:click="delete({{ $step->id }})"
                                    wire:confirm.prompt="Are you sure delete  {{$step->name}} ?\n\nType DELETE to confirm|DELETE"
                                    data-tip="Delete" />
                            </td>
                        </tr>
                        @empty
                        <tr class="text-center">
                            <td colspan="3" class="text-rose-500 font-bold">data not found!!!</td>
                        </tr>
                    @endforelse
            </tbody>
        </table>
    </div>
</div>
