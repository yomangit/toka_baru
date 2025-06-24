<div>
    <table class="table table-zebra table-xs">
        <!-- head -->
        <thead>
            <tr class="text-center">
                <th>Date</th>
                <th>Reference</th>
                <th>Event Type</th>
                <th>Event Sub Type</th>
                <th>{{ __('report_by') }}</th>
                <th>{{ __('Perusahaan terkait') }}</th>
                <th class="flex-col">
                    <p>Action</p>
                    <p>Total/Open</p>
                </th>
                <th>Status</th>
                <th>{{ __('kondisi tidak aman')  }}</th>
                <th>{{ __('closed by') }}</th>
                <th>{{ __('Hazard Details') }}</th>
                <th>{{ __('immediate corrective action') }}</th>
            </tr>
        </thead>
        <tbody>
            <!-- row 1 -->
            @foreach ($HazardReport as $no => $hr)
            <tr class="text-center">

                <td>{{ DateTime::createFromFormat('Y-m-d : H:i', $hr->date)->format('d-m-Y') }}</td>
                <td>{{ $hr->reference }}</td>
                <td>{{$hr->eventType->type_eventreport_name}}</td>
                <td>{{ $hr->subEventType->event_sub_type_name }}</td>
                <td> {{ $hr->report_byName }}</td>
                <td> {{ $hr->workgroup_name }}</td>
                <td>{{ $ActionHazard->where('hazard_id', $hr->id)->count('due_date') }}/{{ $ActionHazard->where('hazard_id', $hr->id)->WhereNull('completion_date')->count('completion_date') }}</td>
                <td>
                    @if ($hr->WorkflowDetails->Status->status_name ==='Closed')
                    Closed
                    @elseif($hr->WorkflowDetails->Status->status_name ==='Cancelled')
                    Cancelled
                    @else
                    Open
                    @endif
                </td>
                <td>{{ ($hr->kondisi_tidak_aman==1)? "ya":'tidak' }}</td>
                <td>{{ $hr->closed_by? "$hr->closed_by":'-' }}</td>
                <td>{!! $hr->description? "$hr->description":'-' !!}</td>
                <td>{!! $hr->immediate_corrective_action? "$hr->immediate_corrective_action":'-' !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
