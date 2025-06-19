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
                    <th>{{ __('closed by') }}</th>
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
                <td>  {{ $hr->report_byName }}</td>
                <td>  {{ $hr->workgroup_name }}</td>
                <td>{{ $ActionHazard->where('hazard_id', $hr->id)->count('due_date') }}/{{ $ActionHazard->where('hazard_id', $hr->id)->WhereNull('completion_date')->count('completion_date') }}</td>
                <td>
                    {{ $hr->WorkflowDetails->Status->status_name }}</td>
                <td>{{ $hr->closed_by? "$hr->closed_by":'-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
