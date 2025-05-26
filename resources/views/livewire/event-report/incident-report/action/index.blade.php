<div>
    

    @forelse ($ActionIncident as $no => $index)
        <div class="flex flex-col sm:flex-row items-center justify-between border mb-2 border-gray-500 p-2">
            <div class=" w-full basis-1/5">
                <div class="text-gray-500 space-x-4">
                    <span class="font-mono text-[10px] font-semibold">Action No.</span>
                    <span class="text-[10px] font-semibold">{{ $ActionIncident->firstItem() + $no }} </span>
                    <div class="flex gap-2">
                        <x-icon-btn-detail wire:click="$dispatch('modalActionIncident',{ dataIncident: {{ $incident_id }}, action:{{$index->id}} })" data-tip="Edit" class="{{($current_step ==='Closed' || $current_step ==='Cancelled') ? 'btn-disabled' :'' }}"/>
                            <x-icon-btn-delete class="{{($current_step ==='Closed' || $current_step ==='Cancelled') ? 'btn-disabled' :'' }}" data-tip="delete" wire:click='delete({{$index->id}})'
                                wire:confirm.prompt="Are you sure delete action {{ $task_being_done }}?\n\nType DELETE to confirm|DELETE" />
                    </div>
                </div>
            </div>
            <div class=" w-full basis-3/4 p-4">
                <div class="flex flex-col items-stretch divide-y divide-gray-400 ">

                    <div class="flex-row text-gray-500 grid grid-cols-4 gap-1">
                        <span class="font-mono text-[10px] font-semibold ">Incident</span>
                        <span
                            class="font-mono text-[10px] text-justify font-semibold col-span-3">{{ $task_being_done }}</span>
                    </div>
                    <div class="flex-row text-gray-500 grid grid-cols-4 gap-1 ">
                        <span class="font-mono text-[10px] font-semibold ">Followup Action</span>
                        <span
                            class="font-mono text-[10px] text-justify font-semibold col-span-3">{{ $index->followup_action }}</span>
                    </div>
                    <div class="flex-row text-gray-500 grid grid-cols-4 gap-1 ">
                        <span class="font-mono text-[10px] font-semibold ">Actionee Comments</span>
                        <span class="font-mono text-[10px] text-justify font-semibold col-span-3">
                            {{ $index->actionee_comment }}</span>
                    </div>
                    <div class="flex-row text-gray-500 grid grid-cols-4 gap-1 ">
                        <span class="font-mono text-[10px] font-semibold ">Action Conditions</span>
                        <span class="font-mono text-[10px] font-semibold col-span-3">
                            {{ $index->action_condition }}</span>
                    </div>
                </div>
            </div>
            <div class=" w-full basis-2/3 ">
                <div class="flex flex-col items-stretch divide-y divide-gray-400 ">
                    <div class="flex-row">
                        <div class="text-gray-500 grid grid-cols-3">
                            <span class="font-mono text-[10px] font-semibold ">{{ __('Orginal Due Date') }}</span>
                            <span class="font-mono text-[10px] font-semibold "> {{ $orginal_due_date }}</span>
                        </div>
                    </div>
                    <div class="flex-row">
                        <div class="text-gray-500 grid grid-cols-3">
                            <span class="font-mono text-[10px] font-semibold ">{{ __('Responsibility') }}</span>
                            <span class="font-mono text-[10px] col-span-2 font-semibold ">
                                {{ $index->users->lookup_name }}</span>
                        </div>
                    </div>
                    <div class="flex-row">
                        <div class="text-gray-500 grid grid-cols-3">
                            <span class="font-mono text-[10px] font-semibold ">{{ __('Due Date') }}</span>
                            <span class="font-mono text-[10px] col-span-2 font-semibold ">
                                {{ $index->due_date }}</span>
                        </div>
                    </div>
                    <div class="flex-row">
                        <div class="text-gray-500 grid grid-cols-3">
                            <span class="font-mono text-[10px] font-semibold ">{{ __('Completion Date') }}</span>
                            <span class="font-mono text-[10px] col-span-2 font-semibold ">
                                {{ $index->completion_date }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
    <div class='text-center font-semibold bg-clip-text text-transparent bg-gradient-to-r from-rose-500 to-orange-500'>No Addictional Action</div>
    @endforelse
 
</div>
