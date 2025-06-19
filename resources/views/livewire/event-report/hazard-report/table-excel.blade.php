<div>
    <table class="table table-zebra table-xs">
        <!-- head -->
        <thead>
            <tr class="text-center">
                <th>Date</th>
                <th>Month</th>
                <th>Year</th>
                <th>Company Category</th>
                <th>Company</th>
                <th>Department</th>
                <th>Dept Group</th>
                <th>Job Class</th>
                <th>Manhours</th>
                <th>Manpower</th>
            </tr>
        </thead>
        <tbody>
            <!-- row 1 -->
            @foreach ($HazardReport as $no => $hr)
            <tr class="text-center">

                <td>{{ date('d-m-Y', strtotime($hr->date)) }}</td>
                <td>{{ $hr->reference }}</td>
                <td>{{$hr->subEventType->event_sub_type_name}}</td>
                <td>{{ $hr->subEventType->event_sub_type_name }}</td>
                <td>{{ $ActionHazard->where('hazard_id', $hr->id)->count('due_date') }}/{{ $ActionHazard->where('hazard_id', $hr->id)->WhereNull('completion_date')->count('completion_date') }}</td>
                <td>
                    {{ $hr->WorkflowDetails->Status->status_name }}</td>
                <td>{{ $hr->manhours }}</td>
                <td>{{ $hr->manpower }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
