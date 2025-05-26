<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div>
            <x-btn-add data-tip="Add data" wire:click="$dispatch('openModal', { component: 'admin.company.create-and-update' })" />
            <x-btn-upload data-tip="Upload File" wire:click="$dispatch('openModal', { component: 'admin.company.upload' })" />
        </div>
        <div>
            <div class="flex flex-col sm:flex-row gap-1">
                <x-inputsearch name='search' wire:model.live='search' />
                <x-select-search wire:model.live='search_companty_category'>
                    <option class="opacity-40" value="" selected>Select All</option>
                    @foreach ($CompanyCategory as $company_category)
                        <option value="{{ $company_category->name_category_company }}">
                            {{ $company_category->name_category_company }}
                        </option>
                    @endforeach
                </x-select-search>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>Company Category</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($Company as $no => $cc)
                    <tr class="text-center">
                        <th>{{ $Company->firstItem() + $no }}</th>
                        <td>{{ $cc->CompanyCategory->name_category_company }}</td>
                        <td>{{ $cc->name_company }}</td>
                        <td class="flex flex-row gap-1 justify-center">
                            <x-icon-btn-edit data-tip="Edit"
                                wire:click="$dispatch('openModal', { component: 'admin.company.create-and-update', arguments: { company: {{ $cc->id }} }})" />
                            <x-icon-btn-delete wire:click="delete({{ $cc->id }})"
                                wire:confirm.prompt="Are you sure delete {{ $cc->name_company }}?\n\nType DELETE to confirm|DELETE"
                                data-tip="Delete" />
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <th colspan="4" class="text-error">data not found!!! </th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div>{{ $Company->links() }}</div>
</div>
