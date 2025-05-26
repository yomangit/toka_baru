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
                    @forelse ($ObserverTeam as $index => $app)
                        <tr class="text-center">
                            <th>{{ $ObserverTeam->firstItem() + $index }}</th>
                            <td>{{ $app->name }}</td>
                            <td>{{ $app->id_card }}</td>
                            <td>{{ $app->job_title }}</td>
                            <td class="flex flex-row gap-1 justify-center">
                                <x-icon-btn-edit class="{{ $disable_btn }}" wire:click="$dispatch('openModalPtoTeam',{ ptoTeam: {{ $app->id }} })"
                                    data-tip="Update"></x-icon-btn-edit>
                                <x-icon-btn-delete class="{{ $disable_btn }}" wire:click="delete({{ $app->id }})"
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
