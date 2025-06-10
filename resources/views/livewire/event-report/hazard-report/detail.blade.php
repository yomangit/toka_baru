<div>
    <x-notification />
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <style>
        .ck-editor__editable[role="textbox"] {
            /* Editing area */
            /* min-height: 200px; */
            padding-left: 40px;
        }
    </style>
    @section('bradcrumbs')
        {{ Breadcrumbs::render('hazardReportDetail', $data_id) }}
    @endsection
    <div
        class="font-mono text-sm font-semibold text-transparent divider divider-info bg-clip-text bg-gradient-to-r from-pink-500 to-violet-500">
        {{ $divider }}</div>
    <livewire:event-report.hazard-report.panal.index :id="$data_id">

        <form wire:submit.prevent='store'>
            @csrf
            @method('PATCH')
            <div wire:target="store" wire:loading.class="skeleton" class="left-0 p-2 border rounded-sm border-slate-300">

                <x-btn-save wire:target="store" wire:loading.class="btn-disabled"
                    class="{{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'btn-disabled' : '' }}">
                    {{ __('Save') }}</x-btn-save>
                <x-btn-delete wire:target="store" wire:loading.class="btn-disabled"
                    class="{{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'btn-disabled' : '' }}"
                    wire:click='destroy'
                    wire:confirm.prompt=" Are you sure delete {{ $reference }}?\n\nType DELETE to confirm|DELETE">{{ __('Delete') }}</x-btn-delete>
            </div>
            <div wire:target="store" wire:loading.class="skeleton" class="p-2 my-1 border rounded-sm border-slate-300">
                <div class="grid gap-1 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="w-full max-w-md xl:max-w-xl form-control">
                        <x-label-req :value="__('event_type')" />
                        <x-select wire:model.live='event_type_id'
                            class="{{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'btn-disabled bg-gray-300' : '' }}"
                            :error="$errors->get('event_type_id')">
                            <option value="" selected>Select an option</option>
                            @foreach ($EventType as $event_type)
                                <option value="{{ $event_type->id }}" selected>
                                    {{ $event_type->EventCategory->event_category_name }} -
                                    {{ $event_type->type_eventreport_name }}</option>
                            @endforeach
                        </x-select>
                        <x-label-error :messages="$errors->get('event_type_id')" />
                    </div>
                    <div class="w-full max-w-md xl:max-w-xl form-control">
                        <x-label-req :value="__('sub_event_type')" />
                        <x-select wire:model.live='sub_event_type_id'
                            class="{{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'btn-disabled bg-gray-300' : '' }}"
                            :error="$errors->get('sub_event_type_id')">
                            <option value="" selected>Select an option</option>
                            @foreach ($EventSubType as $item)
                                <option value="{{ $item->id }}">{{ $item->event_sub_type_name }}</option>
                            @endforeach
                        </x-select>
                        <x-label-error :messages="$errors->get('sub_event_type_id')" />
                    </div>
                    <div class="w-full max-w-md xl:max-w-xl form-control">
                        <x-label-req :value="__('Perusahaan terkait')" />
                        <div class="dropdown dropdown-end">
                            <x-input wire:click='clickWorkgroup' wire:model.live='workgroup_name'
                                wire:keydown.self="changeConditionDivision" :error="$errors->get('workgroup_name')" class="cursor-pointer"
                                tabindex="0" role="button" />
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
                        <x-label-req :value="__('report_by')" />
                        <div class="dropdown dropdown-end">
                            <x-input wire:click='clickReportBy' wire:model.live='report_byName' :error="$errors->get('report_byName')"
                                class="cursor-pointer" tabindex="0" role="button" />
                            <div tabindex="0"
                                class="dropdown-content card card-compact  bg-base-300 text-primary-content z-[1] w-full  p-2 shadow {{ $hiddenReportBy }}">
                                <div class="relative">
                                    <div class="h-full mb-2 overflow-auto max-h-40 scroll-smooth focus:scroll-auto"
                                        wire:target='report_byName' wire:loading.class='hidden'>
                                        @forelse ($Report_By as $report_by)
                                            <div wire:click="reportedBy({{ $report_by->id }})"
                                                class="flex flex-col border-b cursor-pointer border-base-200 ">
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
                        <x-label-req :value="__('report_to')" />
                        <div class="dropdown dropdown-end">
                            <x-input wire:model.live='report_toName' :error="$errors->get('report_toName')" class="cursor-pointer"
                                tabindex="0" role="button" />
                            <div tabindex="0"
                                class="dropdown-content card card-compact  bg-base-300 text-primary-content z-[1] w-full  p-2 shadow">
                                <div class="relative">

                                    <div class="h-40 mb-2 overflow-auto scroll-smooth focus:scroll-auto"
                                        wire:target='report_toName' wire:loading.class='hidden'>
                                        @forelse ($Report_To as $report_to)
                                            <div wire:click="reportedTo({{ $report_to->id }})"
                                                class="flex flex-col border-b cursor-pointer border-base-200 ">
                                                <strong
                                                    class="text-[10px] text-slate-800">{{ $report_to->lookup_name }}</strong>
                                            </div>
                                        @empty
                                            <strong
                                                class="text-xs text-transparent bg-clip-text bg-gradient-to-r from-rose-400 to-rose-800">Name
                                                Not Found!!!</strong>
                                        @endforelse
                                    </div>
                                    <div class="hidden pt-5 text-center" wire:target='report_toName'
                                        wire:loading.class.remove='hidden'> <x-loading-spinner /></div>
                                    <div class="pb-6">{{ $Report_To->links('pagination.minipaginate') }}</div>
                                    <div class="fixed bottom-0 left-0 right-0 px-2 mb-1 bg-base-300 opacity-95 ">
                                        <x-input-no-req wire:model.live='report_to_nolist'
                                            placeholder="{{ __('name_notList') }}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <x-label-error :messages="$errors->get('report_toName')" />
                    </div>
                    <div class="w-full max-w-md xl:max-w-xl form-control">
                        <x-label-req :value="__('date of event')" />
                        <x-input-date id="tanggal" wire:model.live='date'
                            class="{{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'btn-disabled bg-gray-300' : '' }}"
                            readonly :error="$errors->get('date')" />
                        <x-label-error :messages="$errors->get('date')" />
                    </div>
                    <div class="w-full max-w-xs sm:max-w-sm xl:max-w-xl form-control">
                        <x-label-req :value="__('Lokasi')" />
                        <x-input wire:model.blur='location_name' :error="$errors->get('location_name')" />
                        <x-label-error :messages="$errors->get('location_name')" />
                    </div>
                    {{-- <div class="w-full max-w-md xl:max-w-xl form-control">
                        <x-label-req :value="__('sitename')" />
                        <x-select wire:model.live='site_id'
                            class="{{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'btn-disabled bg-gray-300' : '' }}"
                            :error="$errors->get('site_id')">
                            <option value="" selected>Select an option</option>
                            @foreach ($Site as $sites)
                                <option value="{{ $sites->id }}" selected>{{ $sites->site_name }}</option>
                            @endforeach
                        </x-select>
                        <x-label-error :messages="$errors->get('site_id')" />
                    </div> --}}


                    <div class="w-full max-w-md xl:max-w-xl form-control">
                        <x-label-no-req :value="__('documentation')" />
                        <div class="relative">
                            <x-input-file wire:model='file_doc'
                                class="{{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'btn-disabled bg-gray-300' : '' }}"
                                :error="$errors->get('file_doc')" />
                            <div class="absolute inset-y-0 right-0 avatar" wire:target="file_doc"
                                wire:loading.class="hidden">
                                <div class="w-6 rounded  @if ($nameFileDb == $documentation) cursor-pointer @endif "
                                    @if ($nameFileDb == $documentation) wire:click="download" @endif>
                                    @include('livewire.event-report.svg-file')
                                </div>
                            </div>
                            <span wire:target="file_doc"
                                wire:loading.class="absolute inset-y-0 right-0 loading loading-spinner text-warning"></span>
                        </div>
                        <x-label-error :messages="$errors->get('documentation')" />
                    </div>
                </div>
                <div>
                    <div wire:ignore class="w-full form-control">
                        <x-label-req :value="__('Hazard Details')" />
                        <textarea id="description">{{ $description_temp }}</textarea>
                    </div>
                    <x-label-error :messages="$errors->get('description')" />
                </div>

                <div>
                    <div wire:ignore class="w-full form-control">
                        <x-label-req :value="__('immediate corrective action')" />
                        <textarea id="immediate_corrective_action">{{ $immediate_corrective_action_temp }}</textarea>
                    </div>
                    <x-label-error :messages="$errors->get('immediate_corrective_action')" />
                </div>


                <div
                    class="flex flex-col-reverse items-center mt-2 border-2 rounded-sm md:flex-row md:divide-x-2 divide-late-400/25 border-slate-400/25">
                    <div class="flex-auto p-2 divide-y-2 divide-slate-400/25">
                        <div class="flex flex-col sm:items-center sm:flex-row">

                            <div class="w-full px-2">
                                <p class="font-mono text-sm font-semibold text-justify">
                                    {{ $risk_probability_doc }}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:items-center sm:flex-row">
                            <div class="flex-none px-2 w-52">
                                <div class="w-full max-w-md xl:max-w-xl form-control">
                                    <x-label-req :value="__('potential consequence')" />
                                    <x-select wire:model.live='risk_consequence_id'
                                        class="{{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'btn-disabled bg-gray-300' : '' }}"
                                        :error="$errors->get('risk_consequence_id')">
                                        <option value="">Select an option</option>
                                        @foreach ($RiskConsequence as $consequence)
                                            <option value="{{ $consequence->id }}">
                                                {{ $consequence->risk_consequence_name }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                    <x-label-error :messages="$errors->get('risk_consequence_id')" />
                                </div>
                            </div>
                            <div class="w-full px-2">
                                <p class="font-mono text-sm font-semibold text-justify">
                                    {{ $risk_consequence_doc }}
                                </p>
                            </div>
                        </div>
                        <div class="flex flex-col sm:items-center sm:flex-row">
                            <div class="flex-none px-2 w-52">
                                <div class="w-full max-w-md xl:max-w-xl form-control">
                                    <x-label-req :value="__('Potential Likelihood')" />
                                    <x-select wire:model.live='risk_likelihood_id'
                                        class="{{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'btn-disabled bg-gray-300' : '' }}"
                                        :error="$errors->get('risk_likelihood_id')">
                                        <option value="">Select an option</option>
                                        @foreach ($RiskLikelihood as $likelihood)
                                            <option value="{{ $likelihood->id }}">
                                                {{ $likelihood->risk_likelihoods_name }}
                                            </option>
                                        @endforeach
                                    </x-select>
                                    <x-label-error :messages="$errors->get('risk_likelihood_id')" />
                                </div>
                            </div>
                            <div class="px-2 ">
                                <p class="font-mono text-sm font-semibold text-justify">{{ $risk_likelihood_notes }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="flex-none md:w-72 ">
                        <div class="m-1 overflow-x-auto ">
                            <table class="table bg-base-300 table-xs">
                                <caption class="caption-top">
                                    Table Initial Risk Assessment
                                </caption>
                                <thead>
                                    <tr class="">
                                        <th colspan="2" class="p-0 text-center border-2 border-black">Legand</th>
                                        @foreach ($RiskAssessments as $risk_assessment)
                                            <td
                                                class="rotate_text text-start text-xs border-2 border-black   {{ $risk_assessment->colour }}">
                                                {{ $risk_assessment->risk_assessments_name }}

                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr class="">
                                        <th class="text-center border-2 border-black">Likelihood</th>
                                        @foreach ($RiskConsequence as $risk_consequence)
                                            <th class="border-2 border-black rotate_text text-start">
                                                {{ $risk_consequence->risk_consequence_name }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($RiskLikelihood as $risk_likelihood)
                                        <tr>
                                            <th class=" p-0 text-[10px] font-semibold border-2 border-black">
                                                {{ $risk_likelihood->risk_likelihoods_name }}
                                            </th>
                                            @foreach ($risk_likelihood->RiskConsequence()->get() as $risk_consequence)
                                                <th
                                                    class="p-0 text-xs font-semibold text-center border-2 border-black {{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? ' opacity-35 bg-gray-500' : '' }}">
                                                    <label
                                                        @if ($currentStep === 'Closed' || $currentStep === 'Cancelled') @else
                                                wire:click="riskId({{ $risk_likelihood->id }}, {{ $risk_consequence->id }},{{ $TableRisk->where('risk_likelihood_id', $risk_likelihood->id)->where('risk_consequence_id', $risk_consequence->id)->first()->risk_assessment_id }})" @endif
                                                        class="btn p-0 mt-1 btn-block btn-xs {{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'cursor-not-allowed' : '' }}  @if (
                                                            $tablerisk_id ==
                                                                $TableRisk->where('risk_likelihood_id', $risk_likelihood->id)->where('risk_consequence_id', $risk_consequence->id)->first()->id) border-4 border-neutral @endif {{ $TableRisk->where('risk_likelihood_id', $risk_likelihood->id)->where('risk_consequence_id', $risk_consequence->id)->first()->RiskAssessment->colour }}">
                                                    </label>
                                                </th>
                                            @endforeach
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <table class="table table-xs">
                    @foreach ($RiskAssessment as $item)
                        <tr>
                            <th class="w-40 text-xs border-2 border-slate-400">Potential Risk Rating</th>
                            <td class="pl-2 text-xs border-2 border-slate-400">
                                {{ $item->RiskAssessment->risk_assessments_name }}</td>
                        </tr>
                        <tr>
                            <th class="w-40 text-xs border-2 border-slate-400">Notify</th>
                            <td class="pl-2 text-xs border-2 border-slate-400">
                                {{ $item->RiskAssessment->reporting_obligation }}</td>
                        </tr>
                        <tr>
                            <th class="w-40 text-xs border-2 border-slate-400">Deadline</th>
                            <td class="pl-2 text-xs border-2 border-slate-400">{{ $item->RiskAssessment->notes }}</td>
                        </tr>
                        <tr>
                            <th class="w-40 text-xs border-2 border-slate-400">Coordinator</th>
                            <td class="pl-2 text-xs border-2 border-slate-400">
                                {{ $item->RiskAssessment->coordinator }}
                            </td>
                        </tr>
                    @endforeach

                </table>

                <div class="grid grid-cols-2 gap-2 mt-2 px-2 border w-[25rem] border-base-200 rounded-box">
                    <fieldset class="w-40 fieldset rounded-box ">
                        <label class="relative px-0 text-xs font-semibold capitalize label label-text-alt ">
                            {{ __('kondisi tidak aman') }}
                            <input type="checkbox" wire:model.live="kondisi_tidak_aman"
                                {{ $kondisi_tidak_aman = 1 ? 'checked="checked"' : '' }}
                                {{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'disabled ' : '' }}
                                class="checkbox border-rose-600 bg-base-300 checked:border-emerald-500 checked:bg-emerald-400 checked:text-emerald-800 checkbox-sm" />
                        </label>
                    </fieldset>
                    <fieldset class="w-48 fieldset rounded-box ">
                        <label class="relative px-0 text-xs font-semibold capitalize label label-text-alt ">
                            {{ __('perbaikan tingkat lanjut') }}
                            <input type="checkbox" wire:model.live="tindakkan_selanjutnya"
                                {{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'disabled ' : '' }}
                                class="checkbox border-rose-600 bg-base-300 checked:border-emerald-500 checked:bg-emerald-400 checked:text-emerald-800 checkbox-sm" />
                        </label>
                    </fieldset>
                </div>
                <div class="flex flex-col w-full border-opacity-50">
                    <div class="divider divider-accent">Final Documentation</div>
                    <div class="grid card bg-base-300 rounded-box ">

                        <div class="mx-4 my-2">
                            <x-btn-add data-tip="Add"
                                class="{{ $currentStep === 'Closed' || $currentStep === 'Cancelled' ? 'btn-disabled ' : '' }}"
                                wire:click="$dispatch('openModal', { component: 'event-report.hazard-report.documentation.create', arguments: { doc: {{ $data_id }} }})" />
                            <livewire:event-report.hazard-report.documentation.index :id="$data_id">
                        </div>


                    </div>
                    <div class="divider divider-accent">Additional Action</div>
                    <div class="grid card bg-base-300 rounded-box ">
                        <div class="mx-4 my-2">
                            <livewire:event-report.hazard-report.action.index :id="$data_id">
                        </div>
                    </div>
                    <div class="divider divider-accent">Event Keyword</div>
                    <div class="grid card bg-base-300 rounded-box ">
                        <div class="mx-4 my-2">
                            <livewire:event-report.event-keyword.index :data_id="$data_id">
                        </div>
                    </div>
                    <div>
                        <div wire:ignore class="w-full form-control">
                            <x-label-no-req :value="__('moderator comment')" />
                            <textarea id="comment">{{ $comment_temp }}</textarea>

                        </div>
                        <x-label-error :messages="$errors->get('comment')" />
                    </div>
                </div>
            </div>
        </form>
        <livewire:event-report.hazard-report.action.create>
            <script nonce="{{ csp_nonce() }}" type="module">
                ClassicEditor
                    .create(document.querySelector('#immediate_corrective_action'), {
                        toolbar: ['undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList', 'link'],
                        placeholder: 'Type the content here!'
                    })
                    .then(newEditor1 => {
                        newEditor1.editing.view.change((writer) => {
                            writer.setStyle(
                                "height",
                                "155px",
                                newEditor1.editing.view.document.getRoot()
                            );
                        });
                        setInterval(() => Livewire.dispatch('ubahData'), 1000);
                        document.addEventListener('livewire:init', () => {
                            Livewire.on('berhasilUpdate', (event) => {
                                const a = event[0];
                                if (a === "Closed" || a === "Cancelled") {
                                    newEditor1.enableReadOnlyMode('immediate_corrective_action');
                                } else {
                                    newEditor1.disableReadOnlyMode('immediate_corrective_action');
                                }
                            });
                        });
                        newEditor1.model.document.on('change:data', () => {
                            @this.set('immediate_corrective_action', newEditor1.getData())
                        });

                    })
                    .catch(error => {
                        console.error(error);
                    });
                ClassicEditor
                    .create(document.querySelector('#description'), {
                        toolbar: ['undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList', 'link'],
                        placeholder: 'Type the content here!'
                    })

                    .then(newEditor2 => {
                        newEditor2.editing.view.change((writer) => {
                            writer.setStyle(
                                "height",
                                "155px",

                                newEditor2.editing.view.document.getRoot()
                            );
                        });
                        document.addEventListener('livewire:init', () => {
                            Livewire.on('berhasilUpdate', (event) => {
                                const a = event[0];
                                if (a === "Closed" || a === "Cancelled") {
                                    newEditor2.enableReadOnlyMode('description');
                                } else {
                                    newEditor2.disableReadOnlyMode('description');
                                }

                            });
                        });
                        newEditor2.model.document.on('change:data', () => {
                            @this.set('description', newEditor2.getData())
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
                ClassicEditor
                    .create(document.querySelector('#suggested_corrective_action'), {
                        toolbar: ['undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList', 'link'],
                        placeholder: 'Type the content here!'
                    })
                    .then(newEditor3 => {
                        newEditor3.editing.view.change((writer) => {
                            writer.setStyle(
                                "height",
                                "155px",
                                newEditor3.editing.view.document.getRoot()
                            );
                        });
                        document.addEventListener('livewire:init', () => {
                            Livewire.on('berhasilUpdate', (event) => {
                                const a = event[0];
                                if (a === "Closed" || a === "Cancelled") {
                                    newEditor3.enableReadOnlyMode('suggested_corrective_action');
                                } else {
                                    newEditor3.disableReadOnlyMode('suggested_corrective_action');
                                }

                            });
                        });
                        newEditor3.model.document.on('change:data', () => {
                            @this.set('suggested_corrective_action', newEditor3.getData())
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
                ClassicEditor
                    .create(document.querySelector('#corrective_action_suggested'), {
                        toolbar: ['undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList', 'link'],
                        placeholder: 'Type the content here!'

                    })
                    .then(newEditor4 => {
                        newEditor4.editing.view.change((writer) => {
                            writer.setStyle(
                                "height",
                                "155px",
                                newEditor4.editing.view.document.getRoot()
                            );
                        });
                        document.addEventListener('livewire:init', () => {
                            Livewire.on('berhasilUpdate', (event) => {
                                const a = event[0];
                                if (a === "Closed" || a === "Cancelled") {
                                    newEditor4.enableReadOnlyMode('corrective_action_suggested');
                                } else {
                                    newEditor4.disableReadOnlyMode('corrective_action_suggested');
                                }

                            });
                        });
                        newEditor4.model.document.on('change:data', () => {
                            @this.set('corrective_action_suggested', newEditor4.getData())
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
                ClassicEditor
                    .create(document.querySelector('#comment'), {
                        toolbar: ['undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList', 'link'],
                        placeholder: 'Type the content here!'

                    })
                    .then(newEditor5 => {
                        newEditor5.editing.view.change((writer) => {
                            writer.setStyle(
                                "height",
                                "155px",
                                newEditor5.editing.view.document.getRoot()
                            );
                        });
                        document.addEventListener('livewire:init', () => {
                            Livewire.on('berhasilUpdate', (event) => {
                                const a = event[0];
                                if (a === "Closed" || a === "Cancelled") {
                                    newEditor5.enableReadOnlyMode('comment');
                                } else {
                                    newEditor5.disableReadOnlyMode('comment');
                                }

                            });
                        });
                        newEditor5.model.document.on('change:data', () => {
                            @this.set('comment', newEditor5.getData())
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            </script>

</div>
