<div>
 
    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Date</th>
                    <th>Reference </th>
                    <th>Event Type</th>
                    <th>Event Sub Type</th>
                    <th class="flex-col">
                        <p>Action</p>
                        <p>Total/Open</p>
                    </th>
                    <th>Potential LTI</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody >

                @foreach ($IncidentReport as $index => $item)
                   <tr class="text-center">
                        <th>{{ $IncidentReport->firstItem() + $index }}</th>
                        <td>{{ DateTime::createFromFormat('Y-m-d : H:i', $item->date)->format('d-m-Y') }}</td>
                        <td>{{ $item->reference }}</td>
                        <td>
                            {{ $item->eventType->type_eventreport_name }}
                        </td>
                        <td>
                            {{ $item->subEventType->event_sub_type_name }}
                        </td>
                        
                        <td>
                            {{ $IncidentAction->where('incident_id', $item->id)->count('due_date') }}/{{ $IncidentAction->where('incident_id', $item->id)->WhereNull('completion_date')->count('completion_date') }}
                        </td>
                        <td>{{ $item->potential_lti }}</td>
                        <td>
                            <p
                                class="bg-clip-text text-transparent font-bold font-mono {{ $item->WorkflowDetails->Status->bg_status }}">
                                {{ $item->WorkflowDetails->Status->status_name }}</p>
                        </td>
                        <td>
                            <div class="">
                                 
                                <x-icon-btn-detail href="{{ route('incidentReportDetail', ['id' => $item->id]) }}"
                                    data-tip="Details" />
                                <x-icon-btn-delete data-tip="delete" wire:click='delete({{ $item->id }})'
                                    wire:confirm.prompt="Are you sure delete {{ $item->reference }}?\n\nType DELETE to confirm|DELETE" />
                                    
                            </div>
                        </td>
                    </tr>
                   
                @endforeach
               
            </tbody>
        </table>
    </div>
</div>
