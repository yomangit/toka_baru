<div>
    <x-notification />
    @if (session()->has('message'))
    @endif
    @section('bradcrumbs')
        {{ Breadcrumbs::render('hazardReportform') }}
    @endsection
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable[role="textbox"] {
            /* Editing area */
            /* min-height: 200px; */
            padding-left: 40px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    @if ($show)
        <x-btn-admin-template wire:click="$dispatch('openModal', { component: 'admin.chose-event-type.create'})">Chose
            Event Category</x-btn-admin-template>
    @endif
    <div
        class="py-1 text-sm font-extrabold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
        {{ $divider }}</div>
    <form wire:target="store" wire:loading.class="skeleton" wire:submit.prevent='store' enctype="multipart/form-data">
        @csrf
        <div class="grid gap-1 sm:grid-cols-2 lg:grid-cols-3">
            <div class="w-full max-w-md xl:max-w-xl form-control">
                <x-label-req :value="__('event_type')" />
                <x-select wire:model.live='event_type_id' :error="$errors->get('event_type_id')">
                    <option value="">Select an option</option>
                    @foreach ($EventType as $event_type)
                        <option value="{{ $event_type->id }}">
                            {{ $event_type->EventCategory->event_category_name }} -
                            {{ $event_type->type_eventreport_name }}</option>
                    @endforeach
                </x-select>
                <x-label-error :messages="$errors->get('event_type_id')" />
            </div>
            <div class="w-full max-w-md xl:max-w-xl form-control">
                <x-label-req :value="__('sub_event_type')" />
                <x-select wire:model.live='sub_event_type_id' :error="$errors->get('sub_event_type_id')">
                    <option value="" selected>Select an option</option>
                    @foreach ($EventSubType as $item)
                        <option value="{{ $item->id }}">{{ $item->event_sub_type_name }}</option>
                    @endforeach
                </x-select>
                <x-label-error :messages="$errors->get('sub_event_type_id')" />
            </div>
            <div class="w-full max-w-md xl:max-w-xl form-control">
                <x-label-req :value="__('report_by')" />
                <div class="dropdown dropdown-end">
                    <x-input wire:click='clickReportBy' wire:model.live='report_byName'
                        placeholder='cari nama pelapor...' :error="$errors->get('report_byName')" class="cursor-pointer" tabindex="0"
                        role="button" />
                    <div tabindex="0"
                        class="dropdown-content card card-compact  bg-base-300 text-primary-content z-[1] w-full  p-2 shadow {{ $hiddenReportBy }}">
                        <div class="relative">
                            <div class="h-full mb-2 overflow-auto max-h-40 scroll-smooth focus:scroll-auto"
                                wire:target='report_byName' wire:loading.class='hidden'>
                                @forelse ($Report_By as $report_by)
                                    <div wire:click="reportedBy({{ $report_by->id }})"
                                        class="flex flex-col border-b cursor-pointer hover:bg-primary border-base-200 ">
                                        <strong
                                            class="text-[10px] text-slate-800">{{ $report_by->lookup_name }}</strong>
                                    </div>
                                @empty
                                    <strong
                                        class="text-xs text-transparent bg-clip-text bg-gradient-to-r from-rose-400 to-rose-800">Name
                                        Not Found!!!</strong>
                                @endforelse
                            </div>
                            <div class="hidden pt-5 text-center" wire:target='report_byName'
                                wire:loading.class.remove='hidden'> <x-loading-spinner /></div>
                            <div class="pb-6">{{ $Report_By->links('pagination.minipaginate') }}</div>
                            <div class="fixed bottom-0 left-0 right-0 px-2 mb-1 bg-base-300 opacity-95 ">
                                <x-input-no-req wire:model.live='report_by_nolist'
                                    placeholder="{{ __('name_notList') }}" />
                            </div>
                        </div>
                    </div>
                </div>
                <x-label-error :messages="$errors->get('report_byName')" />
            </div>
            <div class="w-full max-w-md xl:max-w-xl form-control">
                <x-label-req :value="__('Perusahaan terkait')" />
                <div class="dropdown dropdown-end">
                    <x-input wire:click='clickWorkgroup' wire:model.live='workgroup_name'
                        wire:keydown.self="changeConditionDivision" placeholder='cari divisi...' :error="$errors->get('workgroup_name')"
                        class="cursor-pointer" tabindex="0" role="button" />
                    <div tabindex="0"
                        class="z-10 w-full   overflow-y-auto shadow dropdown-content card card-compact bg-base-200 text-primary-content {{ $hiddenWorkgroup }}">
                        <ul class="h-full px-4 py-4 list-disc list-inside max-h-40 bg-base-200 rounded-box">
                            @forelse ($Division as $item)
                                <li wire:click="select_division({{ $item->id }})"
                                    class = "text-[9px] text-wrap hover:bg-primary subpixel-antialiased text-left cursor-pointer">
                                    {{ $item->DeptByBU->Department->department_name }}
                                    @if (!empty($item->company_id))
                                        -{{ $item->Company->name_company }}
                                    @endif
                                    @if (!empty($item->section_id))
                                        -{{ $item->Section->name }}
                                    @endif
                                </li>
                            @empty
                                <li class='font-semibold text-center text-rose-500'>Division not found!! </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <x-label-error :messages="$errors->get('workgroup_name')" />
            </div>

            <div class="w-full max-w-md xl:max-w-xl form-control">
                <x-label-req :value="__('date of event')" />
                <x-input-date id="tanggal" wire:model.live='date' readonly :error="$errors->get('date')" />
                <x-label-error :messages="$errors->get('date')" />
            </div>
            <div class="w-full max-w-md xl:max-w-xl form-control">
                <x-label-req :value="__('Lokasi')" />
                <x-input wire:model.blur='location_name' :error="$errors->get('location_name')" />
                <x-label-error :messages="$errors->get('location_name')" />
            </div>
        </div>

        <div>
            <div wire:ignore class="w-full form-control">
                <x-label-req :value="__('Hazard Details')" />
                <!--<x-text-area id="description" :error="$errors->get('description')" />-->
                <textarea id="description">{{ $description }}</textarea>
            </div>
            <x-label-error :messages="$errors->get('description')" />
        </div>

        <fieldset>
            @if ($show_immidiate === 'yes')
                <x-label-req :value="__('immediate corrective action')" />
            @else
                <x-label-no-req :value="__('immediate corrective action')" />
            @endif
            <input wire:model.live="show_immidiate" value='yes' name="status" id="draft"
                class="radio-xs peer/draft checked:bg-indigo-500 radio" type="radio" name="13" />
            <label for="draft"
                class="text-xs font-semibold peer-checked/draft:text-indigo-500">{{ __('Yes') }}</label>
            <input wire:model.live="show_immidiate" value="no" id="published"
                class="peer/published checked:bg-sky-500 radio-xs radio" type="radio" name="status" />
            <label for="published"
                class="text-xs font-semibold peer-checked/published:text-sky-500">{{ __('No') }}</label>
            <div wire:ignore class="hidden w-full peer-checked/draft:block form-control">
                <x-text-area id="immediate_corrective_action" :error="$errors->get('immediate_corrective_action')" />
            </div>
            <x-label-error :messages="$errors->get('immediate_corrective_action')" />
        </fieldset>
        <fieldset class="fieldset   rounded-box w-32  ">
            {{-- <x-label-req :value="__('kondisi tidak aman')" /> --}}
            {{-- <input wire:model.live="kondisi_tidak_aman" value='aman' name="kondisi" id="aman"
                class="radio-xs peer/aman checked:bg-emerald-500 radio" type="radio" name="13" />
            <label for="aman"
                class="text-xs font-semibold peer-checked/aman:text-emerald-500">{{ __('Aman') }}</label>
            <input wire:model.live="kondisi_tidak_aman" value="no" id="tidak_aman"
                class="peer/tidak_aman checked:bg-rose-500 radio-xs radio" type="radio" name="kondisi" />
            <label for="tidak_aman"
                class="text-xs font-semibold peer-checked/tidak_aman:text-rose-500">{{ __('No') }}</label> --}}
            <label class="label text-xs px-0 capitalize relative font-semibold label-text-alt gap-2">
                {{ __('kondisi tidak aman') }}
                <input type="checkbox" checked="checked" class="checkbox checkbox-accent checkbox-sm" />
            </label>
        </fieldset>

        <div class="w-full max-w-md xl:max-w-xl form-control">
            <x-label-req :value="__('documentation')" />
            <div class="relative">
                <x-input-file wire:model.live='documentation' :error="$errors->get('documentation')" />
                <div class="absolute inset-y-0 right-0 avatar" wire:target="documentation" wire:loading.class="hidden">
                    <div class="w-6 rounded">
                        @include('livewire.event-report.svg-file')
                        {{ $documentation }}
                    </div>
                </div>
                <span wire:target="documentation"
                    wire:loading.class="absolute inset-y-0 right-0 loading loading-spinner text-warning"></span>
            </div>
            <x-label-error :messages="$errors->get('documentation')" />
        </div>

        <div class="modal-action ">
            <x-btn-save-active wire:target="documentation" wire:loading.class="btn-disabled">{{ __('Submit') }}
            </x-btn-save-active>
        </div>
    </form>
    <!--<button wire:click="setData">Set Data</button>-->
    <script nonce="{{ csp_nonce() }}">
        var count = 10;
        var redirect = "https://tokasafe.archimining.com/eventReport/hazardReportGuest/3";
        document.addEventListener('livewire:init', () => {
            Livewire.on('buttonClicked', (event) => {
                const data = event
                var ss = data[0]['duration'];
                (function() {
                    setTimeout(
                        function() {
                            window.location.href = redirect;
                        }, ss);
                })();
            });
        });
    </script>
    <script nonce="{{ csp_nonce() }}">
        ClassicEditor
            .create(document.querySelector('#immediate_corrective_action'), {
                toolbar: ['undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList', 'link']
            })
            .then(newEditor => {
                newEditor.editing.view.change((writer) => {
                    writer.setStyle(
                        "height",
                        "155px",
                        newEditor.editing.view.document.getRoot()
                    );
                });
                newEditor.model.document.on('change:data', () => {
                    @this.set('immediate_corrective_action', newEditor.getData())
                });
                window.addEventListener('articleStore', event => {
                    newEditor.setData('');
                })
            });
        // involved person
        ClassicEditor
            .create(document.querySelector('#description'), {
                toolbar: ['undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList', 'link']

            })
            .then(newEditor => {
                newEditor.editing.view.change((writer) => {
                    writer.setStyle(
                        "height",
                        "155px",
                        newEditor.editing.view.document.getRoot()
                    );
                });
                newEditor.model.document.on('change:data', () => {
                    @this.set('description', newEditor.getData())
                });
                window.addEventListener('articleStore', event => {
                    newEditor.setData('');
                })
            });
    </script>


</div>
