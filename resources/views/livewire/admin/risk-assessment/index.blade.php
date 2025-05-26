<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div><x-btn-add data-tip="Add data"
                wire:click="$dispatch('openModal', { component: 'admin.risk-assessment.create-and-update' })" /></div>
        <div>
            <x-inputsearch name='search' wire:model.live='search' />
        </div>
    </div>

    <div class="overflow-x-auto ">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Name</th>
                    <th>Notes</th>
                    <th>Action Days</th>
                    <th>Coordinator</th>
                    <th>Reporting Obligation</th>
                    <th>Colour</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($Risk_ass as $no => $risk)
                    <tr>
                        <th>{{ $Risk_ass->firstItem() + $no }}</th>
                        <td class="text-center p-0 text-xs font-semibold">{{ $risk->risk_assessments_name }}</td>
                        <td class="text-justify   px-4">{{ $risk->notes }}</td>
                        <td class="text-center  px-4">{{ $risk->action_days }}</td>
                        <td class="text-center  px-4">{{ $risk->coordinator }}</td>
                        <td class="text-center  px-4">{{ $risk->reporting_obligation }}</td>
                        <td class="text-center  px-4 {{ $risk->colour }}">{{ $risk->colour }}</td>
                        <td class="flex flex-row gap-1 justify-center items-center ">
                            <x-icon-btn-edit data-tip="Edit"
                                wire:click="$dispatch('openModal', { component: 'admin.risk-assessment.create-and-update', arguments: { risk: {{ $risk->id }} }})" />
                            <x-icon-btn-delete wire:click="delete({{ $risk->id }})"
                                wire:confirm.prompt="Are you sure delete {{ $risk->risk_assessments_name }} ?\n\nType DELETE to confirm|DELETE"
                                data-tip="Delete" />
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <th colspan="8" class="text-error">data not found!!! </th>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div>{{ $Risk_ass->links() }}</div>
    </div>
</div>
