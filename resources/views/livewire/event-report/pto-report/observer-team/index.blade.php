<div>
    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Name</th>
                    <th>ID Number</th>
                    <th>Job Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                
                @if ($show)
                    @forelse ($Approval as $index => $app)
                        <tr class="text-center">
                            <th>{{ $Approval->firstItem() + $index }}</th>
                            <td>{{ $app->new_data['name'] }}</td>
                            <td>{{ $app->new_data['id_card'] }}</td>
                            <td>{{ $app->new_data['job_title'] }}</td>
                            <td class="flex flex-row gap-1 justify-center">
                               
                                <x-icon-btn-delete wire:click="delete({{ $app->id }})"
                                    wire:confirm.prompt="Are you sure delete ?\n\nType DELETE to confirm|DELETE"
                                    data-tip="Delete" />
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <th colspan="5" class="text-error">data not found!!! </th>
                        </tr>
                    @endforelse
                @else
                <tr class="text-center text-rose-500">
                        <th colspan="5">data Not Exist</th>
                    </tr>
                @endif

            </tbody>
        </table>
    </div>

</div>
