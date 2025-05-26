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

                    @foreach ($ObserverAction as $index => $item)
                        <tr class="text-center">
                            <th>{{ $ObserverAction->firstItem() + $index }}</th>
                            <td>{{ $item->action }}</td>
                            <td>{{ $item->users->lookup_name }}</td>
                            <td>{{ ($item->due_date==null)?'-':date('d-m-Y', strtotime($item->due_date)) }}</td>
                            <td>{{ ($item->completion_date==null)?'-':date('d-m-Y', strtotime($item->completion_date)) }}</td>
                            <td class="flex flex-row gap-1 justify-center">
                                <x-icon-btn-edit class="{{ $disable_btn }}" wire:click="$dispatch('openModalActionPTO',{ observer: {{ $item->id }} })"
                                    data-tip="Update"></x-icon-btn-edit>
                                <x-icon-btn-delete class="{{ $disable_btn }}" wire:click="delete({{ $item->id }})"
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
