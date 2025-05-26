<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between mb-2 p-1 shadow-md">
        <div class="flex gap-1">
            <!-- Open the modal using ID.showModal() method -->
            <x-btn-add wire:click="modalMS" data-tip="Add Data"></x-btn-add>
            <x-btn-icon-upload for="my_modal_7" data-tip="Upload Data" />
        </div>
        <div>
            <div class="flex flex-col sm:flex-row">
                <x-inputsearch wire:model.live='search' />
            </div>
        </div>
    </div>
    <div class="overflow-x-auto md:h-[28rem] 2xl:h-[45rem]  shadow-md">
        <table class="table table-xs table-pin-cols table-pin-rows "id="dataGrid">
            <!-- head -->
            <thead>
                <tr class="text-center text-[11px]">
                    <th >Date</th>
                    <td>Company Employee</td>
                    <td>Company Workhours</td>
                    <td>Company Cummulatives</td>
                    <td>Contractor Employee</td>
                    <td>Contractor Workhours</td>
                    <td>Contractor Cummulatives</td>
                    <td>Total Employee</td>
                    <td>Total Workhours</td>
                    <td>Total Cummulatives</td>
                    <td>Cummulatives Manhours By LTI</td>
                    <td>Manhours Lost</td>
                    <td>LTI</td>
                    <td>LTI Date</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

    {{-- Modal --}}
    
    <div  class="modal {{ $modal }}">
        <div class="modal-box">
            <form wire:submit.prevent='store'>
                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('Date')" />
                    <x-input id="month" wire:model.live='date' readonly :error="$errors->get('date')" />
                    <x-label-error :messages="$errors->get('date')" />
                </div>
                <div class="modal-action">
                    <x-btn-save  wire:target="store" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                    <x-btn-close wire:target="store" wire:loading.class="btn-disabled" wire:click="closeModal" >{{ __('Close') }}</x-btn-close>
                </div>
            </form>
        </div>
    </div>

    <input type="checkbox" id="my_modal_7" class="modal-toggle" />
    <div class="modal" role="dialog">

        <div wire:target="uploadManhours" wire:loading.class="skeleton" class="modal-box">
            <div
                class="pb-2 font-extrabold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
                Upload Manhours</div>
            <form wire:submit.prevent='uploadManhours'>
                @csrf

                <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                    <x-label-req :value="__('File')" />
                    <div class="relative ">
                        <x-input-file wire:model.blur='files' :error="$errors->get('files')" />
                        <span wire:target="files"
                            wire:loading.class="loading-md loading loading-spinner text-accent absolute inset-y-0 right-0"></span>
                    </div>
                    <x-label-error :messages="$errors->get('files')" />
                </div>
                <div class="modal-action">
                    <x-btn-save wire:target="uploadManhours,files" wire:loading.class="btn-disabled">{{ __('Save') }}</x-btn-save>
                    <x-btn-close wire:target="uploadManhours,files" wire:loading.class="btn-disabled" >{{ __('Close') }}</x-btn-close>
                </div>
            </form>
        </div>

        <label class="modal-backdrop">Close</label>
    </div>

</div>
<script>
    var data_table = JSON.parse('<?php echo $Loop; ?>');
    const tableBody = document.querySelector("#dataGrid tbody");



    for (var i = 0; i < data_table.bulanBerjalan.length; i++) {

        const row = `
            <tr class='text-center ' >

            <td>${data_table.bulanBerjalan[i]}</td>
            <td>${data_table.company_employee[i]}</td>
            <td>${data_table.company_manhours[i]}</td>
            <td>${data_table.Company_Cummulatives[i]}</td>
           


            </tr>
            `;
        tableBody.innerHTML += row;
    }
</script>
