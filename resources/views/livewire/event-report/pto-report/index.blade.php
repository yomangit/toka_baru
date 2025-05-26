<div>
    @section('bradcrumbs')
        {{ Breadcrumbs::render('ptoReport') }}
    @endsection
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush
    <x-notification />
    <div class="flex flex-col items-center sm:flex-row sm:justify-between">
        <div>
            <x-icon-btn-a
                href="{{ route('ptoForm', ['reference' => $reference, 'workflow_template_id' => $workflow_template_id]) }}"
                data-tip="Add Data" />
            @if ($show)
                <x-btn-admin-template
                    wire:click="$dispatch('openModal', { component: 'admin.route-request.create'})">Chose Workflow
                    Template</x-btn-admin-template>
            @endif
        </div>
        <div class="flex flex-col sm:flex-wrap sm:w-full sm:max-w-2xl gap-y-1 sm:pl-4 gap-x-4 sm:flex-row">

            <x-input-daterange id="rangeDate" wire:model.live='rangeDate' placeholder='date-range' />
            <div class="w-full max-w-xs"><x-inputsearch wire:model.live='searching' placeholder='specific search' />
            </div>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Date</th>
                    <th>Reference </th>

                    <th class="flex-col">
                        <p>Action</p>
                        <p>Total/Open</p>
                    </th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>

                @forelse ($PTO_Report as $index => $item)
                    <tr wire:target='rangeDate,search_workgroup,search_eventType,search_eventSubType,search_status,searching'
                        wire:loading.class='hidden' class="text-center">
                        <th>{{ $PTO_Report->firstItem() + $index }}</th>
                        <td>{{ DateTime::createFromFormat('Y-m-d : H:i', $item->date_time)->format('d-F-Y') }} </td>
                        <td>{{ $item->reference }}</td>


                        <td>
                            {{ $PTO_Action->where('reference', $item->reference)->count('due_date') }}/{{ $PTO_Action->where('reference', $item->reference)->WhereNull('completion_date')->count('completion_date') }}
                        </td>
                        <td>
                            <p
                                class="bg-clip-text text-transparent font-bold font-mono {{ $item->WorkflowDetails->Status->bg_status }}">
                                {{ $item->WorkflowDetails->Status->status_name }}</p>
                        </td>
                        <td>
                            @if (auth()->user()->role_user_permit_id == 1 ||
                                    $item->user_id == auth()->user()->id ||
                                    $item->supervisor_area_id == auth()->user()->id ||
                                    $item->assign_to == auth()->user()->id ||
                                    $item->also_assign_to == auth()->user()->id)
                                <div class="">
                                    <x-icon-btn-detail href="{{ route('ptoDetail', ['id' => $item->id]) }}"
                                        data-tip="Details" />

                                    <x-icon-btn-delete data-tip="delete" wire:click='delete({{ $item->id }})'
                                        wire:confirm.prompt="Are you sure delete {{ $item->reference }}?\n\nType DELETE to confirm|DELETE" />
                                </div>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr wire:loading.class='hidden '
                        wire:target='rangeDate,search_workgroup,search_eventType,search_eventSubType,search_status,searching,in_tray'>
                        <th colspan="8" class="text-xl text-center font-signika"> <span
                                class="text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-yellow-500">
                                data not found
                            </span>
                        </th>
                    </tr>
                @endforelse
                <tr class="hidden bg-transparent"
                    wire:target='rangeDate,search_workgroup,search_eventType,search_eventSubType,search_status,searching'
                    wire:loading.class.remove='hidden'>
                    <th colspan="10" class="h-32 text-center">
                        <x-loading-spinner />
                    </th>
                </tr>
            </tbody>
        </table>

    </div>
    <script nonce="{{ csp_nonce() }}" src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script nonce="{{ csp_nonce() }}">
        flatpickr("#rangeDate", {
            mode: 'range',
            dateFormat: "d-m-Y", //defaults to "F Y"
            onChange: function(dates) {
                if (dates.length === 2) {

                    var start = new Date(dates[0]);
                    var end = new Date(dates[1]);

                    var year = start.getFullYear();
                    var month = start.getMonth() + 1;
                    var dt = start.getDate();

                    if (dt < 10) {
                        dt = '0' + dt;
                    }
                    if (month < 10) {
                        month = '0' + month;
                    }
                    var year2 = end.getFullYear();
                    var month2 = end.getMonth() + 1;
                    var dt2 = end.getDate();

                    if (dt2 < 10) {
                        dt2 = '0' + dt2;
                    }
                    if (month2 < 10) {
                        month2 = '0' + month2;
                    }

                    // var tglMulai = year + '-' + month + '-' + dt;
                    // var tglAkhir = year2 + '-' + month2 + '-' + dt2;

                    var tglMulai = year + '-' + month + '-' + dt;
                    var tglAkhir = year2 + '-' + month2 + '-' + dt2;
                    @this.set('tglMulai', tglMulai)
                    @this.set('tglAkhir', tglAkhir)
                }
            }
        });
    </script>
</div>
