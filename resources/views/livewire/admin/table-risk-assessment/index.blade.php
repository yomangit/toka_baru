<div>
    <x-notification />
    <div class="flex flex-col sm:flex-row sm:justify-between ">
        <div> @livewire('admin.table-risk-assessment.create-and-update') </div>
        <div>
            <x-inputsearch name='search' wire:model.live='search' placeholder="search likelihood..." />
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="table  table-xs">
            <!-- head -->
            <thead>
                <tr class="">
                    <th class="border-2 border-black text-center">Likelihood</th>
                    @foreach ($RiskConsequence as $risk_consequence)
                        <th class="rotate_text text-start border-2 border-black">
                            {{ $risk_consequence->risk_consequence_name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($RiskLikelihood as $risk_likelihood)
                    <tr>
                        <th class="text-left p-0 text-xs font-semibold border-2 border-black">
                            {{ $risk_likelihood->risk_likelihoods_name }}
                        </th>
                        @foreach ($risk_likelihood->RiskAssessment()->get() as $risk_assessment)
                            <th
                                class=" p-0 text-xs font-semibold text-center border-2 border-black {{ $risk_assessment->colour }}">
                                {{ $risk_assessment->risk_assessments_name }}
                            </th>
                        @endforeach
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
