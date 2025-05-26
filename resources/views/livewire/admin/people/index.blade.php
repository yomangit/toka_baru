<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div>
            <x-btn-add data-tip="Add data" wire:click="$dispatch('openModalPeople')" />
            <x-btn-upload data-tip="Upload File" wire:click="$dispatch('openModal', { component: 'admin.people.upload' })" />
        </div>
        <div>
            <div class="flex flex-col sm:flex-row">
                <x-inputsearch name='search' wire:model.live='search' />
                
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table table-zebra table-xs">
            <!-- head -->
            <thead>
                <tr class="text-center capitalize">
                    <th>#</th>
                    <th>Lookup name</th>
                    <th>Employee id</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>employer</th>
                    <th>{{__('date_birth')}}</th>
                    <th>{{__('date_commenced')}}</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($People as $no => $user)
                    <tr class="text-center">
                        <th>{{ $People->firstItem() + $no }}</th>
                        <td>{{ $user->lookup_name }}</td>
                        <td>{{ $user->employee_id }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{$user->company_id?$user->company->CompanyCategory->name_category_company:''}}</td>
                        <td>{{$user->company_id?$user->company->name_company:''}}</td>
                        <td>{{$user->date_birth}}</td>
                        <td>{{$user->date_commenced}}</td>
                        <td class="flex flex-row gap-1 justify-center">
                            <x-btn-show data-tip="Show" href="{{ route('peopleShow', ['id' => $user->id]) }}" />
                            <x-icon-btn-edit data-tip="Edit" wire:click="$dispatch('openModalPeople',{ user: {{ $user->id }} })" />
                            <x-icon-btn-delete wire:click="delete({{ $user->id }})"
                                wire:confirm.prompt="Are you sure delete {{ $user->lookup_name }}?\n\nType DELETE to confirm|DELETE"
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
        <div>{{ $People->links() }}</div>
        @livewire('admin.people.create-and-update')
</div>

