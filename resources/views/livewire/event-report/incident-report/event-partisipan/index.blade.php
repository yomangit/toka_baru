<div>
    <div class="overflow-x-auto sm:w-full w-80 h-36">
        <table class="table table-xs ">
            <!-- head -->
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('Type of Involvement') }}</th>
                    <th>{{ __('Employee Name') }}</th>
                    <th>{{ __('Company') }}</th>
                    <th>{{ __('Action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($EventParticipants as $key => $value)
                    <tr>
                        <th>{{ $key + 1 }}</th>
                        <td>{{ $value->TypeInvolvement->name }}</td>
                        <td>{{ $value->User->lookup_name }}</td>
                        <td>{{ $value->User->company_id ? $value->User->company->name_company : '' }}</td>
                        <td>
                            <div class="flex gap-1">

                                <x-icon-btn-edit data-tip="Edit"
                                    class="{{ $current_step === 'Closed' || $current_step === 'Cancelled' ? 'btn-disabled' : '' }}"
                                    wire:click="$dispatch('openModal', { component: 'event-report.incident-report.event-partisipan.create-and-update', arguments: { incident: {{ $data_id }},participan:{{ $value->id }}  }})" />
                                <x-icon-btn-delete wire:click="delete({{ $value->id }})"
                                    wire:confirm.prompt="Are you sure delete {{ $value->User->lookup_name }}?\n\nType DELETE to confirm|DELETE"
                                    data-tip="Delete"
                                    class="{{ $current_step === 'Closed' || $current_step === 'Cancelled' ? 'btn-disabled' : '' }}" />

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <th colspan="5"><span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-orange-500">
                                No Involved Employees
                            </span></th>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>
