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
                @foreach ($Manhours as $no => $cc)
                    <tr class="text-center">
                        <td>{{ date('d-m-Y', strtotime($cc->date)) }}</td>
                        <td>{{ date('m-Y', strtotime($cc->date)) }}</td>
                        <td>{{ date('Y', strtotime($cc->date)) }}</td>
                        <td>{{ $cc->company_category }}</td>
                        <td>{{ $cc->company }}</td>
                        <td>{{ $cc->department }}</td>
                        <td>{{ $cc->dept_group }}</td>
                        <td>{{ $cc->job_class }}</td>
                        <td>{{ $cc->manhours }}</td>
                        <td>{{ $cc->manpower }}</td>
                    </tr>
               
                @endforeach
            </tbody>
        </table>
</div>
