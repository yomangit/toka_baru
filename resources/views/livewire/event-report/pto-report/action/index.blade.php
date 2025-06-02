<div>
    <div class="overflow-x-auto">
        <table class="table table-xs">
            <thead>
                <tr class="text-center">
                    <th></th>
                    <th>Actions</th>
                    <th>By Who</th>
                    <th>Due Date</th>
                    <th>Completion Date</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @if ($show)

                    @foreach ($Action_PTO as $index => $item)
                        <tr class="text-center">
                            <th>{{ $Action_PTO->firstItem() + $index }}</th>
                            <td>{{ $item->new_data['action'] }}</td>
                            <td>{{ App\Models\User::where('id', $item->new_data['by_who'])->first()->lookup_name }}</td>
                            <td>{{ $item->new_data['due_date'] ? date('d-m-Y', strtotime($item->new_data['due_date'])) : '-' }}
                            </td>
                            <td>{{ $item->new_data['completion_date'] ? date('d-m-Y', strtotime($item->new_data['completion_date'])) : '-' }}
                            </td>
                            <td class="flex flex-row justify-center gap-1">
                                <x-icon-btn-delete wire:click="delete({{ $item->id }})"
                                    wire:confirm.prompt="Are you sure delete ?\n\nType DELETE to confirm|DELETE"
                                    data-tip="Delete" />
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr class="text-center text-rose-500">
                        <th colspan="7">data Not Exist</th>
                    </tr>
                @endif
        </table>
    </div>
</div>
