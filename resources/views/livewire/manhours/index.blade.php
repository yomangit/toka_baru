<div>
    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @endpush
    <x-notification />
    <div class="flex flex-col justify-items-stretch sm:flex-row sm:justify-between mb-2">
        <div class=" justify-self-start">
             <div class= "flex gap-1">
                <x-btn-add data-tip="Add data" wire:click="$dispatch('openModalManhours')" />
                 @if (auth()->user()->role_user_permit_id == 1)
                <x-btn-upload data-tip="Upload File" wire:click="$dispatch('openModal', { component: 'manhours.upload' })" />
                <div class="@if ($bulkDisable) hidden  @endif ">
                    <x-btn-download  data-tip="Download File" wire:click="export" />
                    <x-icon-btn-delete class="tooltip-right" data-tip="Delete Selected"
                        wire:confirm.prompt="Are you sure you want to delete selected data ?\n\nType DELETE to confirm|DELETE"
                        wire:click="deleteAll"></x-icon-btn-delete>
                </div>
                @endif
             </div>
            
        </div>
        <div class="flex flex-col sm:flex-wrap sm:w-full sm:max-w-2xl gap-y-1 sm:pl-4 gap-x-2 sm:flex-row ">
            <x-select-search wire:model.live='search_companyCategory'>
                <option class="opacity-40  " value="" selected>Select All Company Category</option>
                @foreach ($CompanyCategory as $item)
                    <option class="opacity-40  " value="{{ $item->name_category_company }}">
                        {{ $item->name_category_company }}</option>
                @endforeach
            </x-select-search>
            <x-select-search wire:model.live='search_name_company'>
                <option class="opacity-40  " value="" selected>Select All Company </option>
                @foreach ($Company as $item)
                    <option class="opacity-40  " value="{{ $item->name_company }}">{{ $item->name_company }}</option>
                @endforeach
            </x-select-search>
            <x-select-search wire:model.live='search_department'>
                <option class="opacity-40  " value="" selected>Select All Department </option>
                @foreach ($Department as $item)
                    <option class="opacity-40  " value="{{ $item->department_name }}">{{ $item->department_name }}
                    </option>
                @endforeach
            </x-select-search>
            <x-input-daterange id="date_range" wire:model.live='rangeDate' placeholder='date-range' />
            {{-- <x-inputsearch wire:model.live='search' /> --}}
        </div>
    </div>
    <div class="overflow-x-auto md:h-[28rem] 2xl:h-[45rem]  shadow-md">
      <table class="table table-xs table-pin-cols table-pin-rows ">
            <!-- head -->
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    @if ($show)
                        <th>
                            <input type="checkbox" wire:model.live="selectAll"
                                class="checkbox checkbox-xs [--chkbg:oklch(var(--a))] [--chkfg:oklch(var(--p))]" />
                        </th>
                    @endif
                    <th>Date</th>
                    <th>Company Category</th>
                    <th>Company</th>
                    <th>Department</th>
                    <th>Dept Group</th>
                    <th>Job Class</th>
                    <th>Manhours</th>
                    <th>Manpower</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- row 1 -->
                @forelse ($Manhours as $no => $cc)
                    <tr class="text-center">
                        <th>{{ $Manhours->firstItem() + $no }}</th>
                        @if ($show)
                        <th>
                            <input value="{{ $cc->id }}" type="checkbox" wire:model.live="seleted_manhours"
                                class="checkbox checkbox-xs [--chkbg:oklch(var(--in))] [--chkfg:oklch(var(--a))]" />
                        </th>
                        @endif
                        <td>{{ date('M-Y', strtotime($cc->date)) }}</td>
                        <td>{{ $cc->company_category }}</td>
                        <td>{{ $cc->company }}</td>
                        <td>{{ $cc->department }}</td>
                        <td>{{ $cc->dept_group }}</td>
                        <td>{{ $cc->job_class }}</td>
                        <td>{{ $cc->manhours }}</td>
                        <td>{{ $cc->manpower }}</td>
                        <td>
                            <div class="">
                                <x-icon-btn-edit wire:click="$dispatch('openModalManhours',{ id: {{ $cc->id }} })"
                                    data-tip="Update"></x-icon-btn-edit>
                                <x-icon-btn-delete wire:click="delete({{ $cc->id }})"
                                    wire:confirm.prompt="Are you sure you want to delete this data ?\n\nType DELETE to confirm|DELETE"
                                    data-tip="Delete"></x-icon-btn-delete>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr class="text-center">
                        <th colspan="10" class="text-error">data not found!!! </th>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div>{{ $Manhours->links() }}</div>
  
     @livewire('manhours.create-and-update')
     <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
     <script>
        flatpickr("#date_range", {
            mode: 'range',
            dateFormat: "d-m-Y", //defaults to "F Y"
            onChange: function(dates) {
                if (dates.length === 2) {

                    var start = new Date(dates[0]);
                    var end = new Date(dates[1]);

                    var year = start.getFullYear();
                    var month = start.getMonth() + 1;
                    var dt = start.getDate();

                    if (dt < 10) {
                        dt = '0' + dt;
                    }
                    if (month < 10) {
                        month = '0' + month;
                    }
                    var year2 = end.getFullYear();
                    var month2 = end.getMonth() + 1;
                    var dt2 = end.getDate();

                    if (dt2 < 10) {
                        dt2 = '0' + dt2;
                    }
                    if (month2 < 10) {
                        month2 = '0' + month2;
                    }

                    // var tglMulai = year + '-' + month + '-' + dt;
                    // var tglAkhir = year2 + '-' + month2 + '-' + dt2;

                    var tglMulai = year + '/' + month + '/' + dt;
                    var tglAkhir = year2 + '/' + month2 + '/' + dt2;
                    @this.set('tglMulai', tglMulai)
                    @this.set('tglAkhir', tglAkhir)
                }
            }
        });
    </script>
</div>
