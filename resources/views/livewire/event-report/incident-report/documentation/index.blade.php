<div>

    <div class="overflow-x-auto">
        <table class="table table-xs">
            <!-- head -->
            <thead>
                <tr>

                    <th>{{ __('Document/Image') }}</th>
                    <th>{{ __('Description') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($IncidentDocumentation as $no =>$item)
                    <tr>

                        <td>
                            <div class="flex items-center gap-3">
                                <div wire:click="download('{{ $item->id }}')" class="cursor-pointer avatar">
                                    {{-- <div class="w-12 h-12 mask mask-squircle"> --}}
                                    @if (pathinfo(public_path($item->name_doc))['extension'] === 'docx')
                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                        <svg class="size-8" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                            <title>file_type_word</title>
                                            <path
                                                d="M18.536,2.323V4.868c3.4.019,7.12-.035,10.521.019a.783.783,0,0,1,.912.861c.054,6.266-.013,12.89.032,19.157-.02.4.009,1.118-.053,1.517-.079.509-.306.607-.817.676-.286.039-.764.034-1.045.047-2.792-.014-5.582-.011-8.374-.01l-1.175,0v2.547L2,27.133Q2,16,2,4.873L18.536,2.322"
                                                style="fill:#283c82" />
                                            <path
                                                d="M18.536,5.822h10.5V26.18h-10.5V23.635h8.27V22.363h-8.27v-1.59h8.27V19.5h-8.27v-1.59h8.27V16.637h-8.27v-1.59h8.27V13.774h-8.27v-1.59h8.27V10.911h-8.27V9.321h8.27V8.048h-8.27V5.822"
                                                style="fill:#fff" />
                                            <path
                                                d="M8.573,11.443c.6-.035,1.209-.06,1.813-.092.423,2.147.856,4.291,1.314,6.429.359-2.208.757-4.409,1.142-6.613.636-.022,1.272-.057,1.905-.1-.719,3.082-1.349,6.19-2.134,9.254-.531.277-1.326-.013-1.956.032-.423-2.106-.916-4.2-1.295-6.314C8.99,16.1,8.506,18.133,8.08,20.175q-.916-.048-1.839-.111c-.528-2.8-1.148-5.579-1.641-8.385.544-.025,1.091-.048,1.635-.067.328,2.026.7,4.043.986,6.072.448-2.08.907-4.161,1.352-6.241"
                                                style="fill:#fff" />
                                        </svg>
                                    @elseif(pathinfo(public_path($item->name_doc))['extension'] === 'xlsx' ||
                                            pathinfo(public_path($item->name_doc))['extension'] === 'csv')
                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                        <svg class="size-8" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                            <title>file_type_excel</title>
                                            <path
                                                d="M28.781,4.405H18.651V2.018L2,4.588V27.115l16.651,2.868V26.445H28.781A1.162,1.162,0,0,0,30,25.349V5.5A1.162,1.162,0,0,0,28.781,4.405Zm.16,21.126H18.617L18.6,23.642h2.487v-2.2H18.581l-.012-1.3h2.518v-2.2H18.55l-.012-1.3h2.549v-2.2H18.53v-1.3h2.557v-2.2H18.53v-1.3h2.557v-2.2H18.53v-2H28.941Z"
                                                style="fill:#20744a;fill-rule:evenodd" />
                                            <rect x="22.487" y="7.439" width="4.323" height="2.2"
                                                style="fill:#20744a" />
                                            <rect x="22.487" y="10.94" width="4.323" height="2.2"
                                                style="fill:#20744a" />
                                            <rect x="22.487" y="14.441" width="4.323" height="2.2"
                                                style="fill:#20744a" />
                                            <rect x="22.487" y="17.942" width="4.323" height="2.2"
                                                style="fill:#20744a" />
                                            <rect x="22.487" y="21.443" width="4.323" height="2.2"
                                                style="fill:#20744a" />
                                            <polygon
                                                points="6.347 10.673 8.493 10.55 9.842 14.259 11.436 10.397 13.582 10.274 10.976 15.54 13.582 20.819 11.313 20.666 9.781 16.642 8.248 20.513 6.163 20.329 8.585 15.666 6.347 10.673"
                                                style="fill:#ffffff;fill-rule:evenodd" />
                                        </svg>
                                    @elseif(pathinfo(public_path($item->name_doc))['extension'] === 'pdf' ||
                                            pathinfo(public_path($item->name_doc))['extension'] === 'PDF')
                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                        <svg class="size-8" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
                                            <title>file_type_pdf</title>
                                            <path d="M24.1,2.072h0l5.564,5.8V29.928H8.879V30H29.735V7.945L24.1,2.072"
                                                style="fill:#909090" />
                                            <path d="M24.031,2H8.808V29.928H29.664V7.873L24.03,2"
                                                style="fill:#f4f4f4" />
                                            <path d="M8.655,3.5H2.265v6.827h20.1V3.5H8.655" style="fill:#7a7b7c" />
                                            <path d="M22.472,10.211H2.395V3.379H22.472v6.832" style="fill:#dd2025" />
                                            <path
                                                d="M9.052,4.534h-.03l-.207,0H7.745v4.8H8.773V7.715L9,7.728a2.042,2.042,0,0,0,.647-.117,1.427,1.427,0,0,0,.493-.291,1.224,1.224,0,0,0,.335-.454,2.13,2.13,0,0,0,.105-.908,2.237,2.237,0,0,0-.114-.644,1.173,1.173,0,0,0-.687-.65A2.149,2.149,0,0,0,9.37,4.56a2.232,2.232,0,0,0-.319-.026M8.862,6.828l-.089,0V5.348h.193a.57.57,0,0,1,.459.181.92.92,0,0,1,.183.558c0,.246,0,.469-.222.626a.942.942,0,0,1-.524.114"
                                                style="fill:#464648" />
                                            <path
                                                d="M12.533,4.521c-.111,0-.219.008-.295.011L12,4.538h-.78v4.8h.918a2.677,2.677,0,0,0,1.028-.175,1.71,1.71,0,0,0,.68-.491,1.939,1.939,0,0,0,.373-.749,3.728,3.728,0,0,0,.114-.949,4.416,4.416,0,0,0-.087-1.127,1.777,1.777,0,0,0-.4-.733,1.63,1.63,0,0,0-.535-.4,2.413,2.413,0,0,0-.549-.178,1.282,1.282,0,0,0-.228-.017m-.182,3.937-.1,0V5.392h.013a1.062,1.062,0,0,1,.6.107,1.2,1.2,0,0,1,.324.4,1.3,1.3,0,0,1,.142.526c.009.22,0,.4,0,.549a2.926,2.926,0,0,1-.033.513,1.756,1.756,0,0,1-.169.5,1.13,1.13,0,0,1-.363.36.673.673,0,0,1-.416.106"
                                                style="fill:#464648" />
                                            <path d="M17.43,4.538H15v4.8h1.028V7.434h1.3V6.542h-1.3V5.43h1.4V4.538"
                                                style="fill:#464648" />
                                            <path
                                                d="M21.781,20.255s3.188-.578,3.188.511S22.994,21.412,21.781,20.255Zm-2.357.083a7.543,7.543,0,0,0-1.473.489l.4-.9c.4-.9.815-2.127.815-2.127a14.216,14.216,0,0,0,1.658,2.252,13.033,13.033,0,0,0-1.4.288Zm-1.262-6.5c0-.949.307-1.208.546-1.208s.508.115.517.939a10.787,10.787,0,0,1-.517,2.434A4.426,4.426,0,0,1,18.161,13.841ZM13.513,24.354c-.978-.585,2.051-2.386,2.6-2.444C16.11,21.911,14.537,24.966,13.513,24.354ZM25.9,20.895c-.01-.1-.1-1.207-2.07-1.16a14.228,14.228,0,0,0-2.453.173,12.542,12.542,0,0,1-2.012-2.655,11.76,11.76,0,0,0,.623-3.1c-.029-1.2-.316-1.888-1.236-1.878s-1.054.815-.933,2.013a9.309,9.309,0,0,0,.665,2.338s-.425,1.323-.987,2.639-.946,2.006-.946,2.006a9.622,9.622,0,0,0-2.725,1.4c-.824.767-1.159,1.356-.725,1.945.374.508,1.683.623,2.853-.91a22.549,22.549,0,0,0,1.7-2.492s1.784-.489,2.339-.623,1.226-.24,1.226-.24,1.629,1.639,3.2,1.581,1.495-.939,1.485-1.035"
                                                style="fill:#dd2025" />
                                            <path d="M23.954,2.077V7.95h5.633L23.954,2.077Z" style="fill:#909090" />
                                            <path d="M24.031,2V7.873h5.633L24.031,2Z" style="fill:#f4f4f4" />
                                            <path
                                                d="M8.975,4.457h-.03l-.207,0H7.668v4.8H8.7V7.639l.228.013a2.042,2.042,0,0,0,.647-.117,1.428,1.428,0,0,0,.493-.291A1.224,1.224,0,0,0,10.4,6.79a2.13,2.13,0,0,0,.105-.908,2.237,2.237,0,0,0-.114-.644,1.173,1.173,0,0,0-.687-.65,2.149,2.149,0,0,0-.411-.105,2.232,2.232,0,0,0-.319-.026M8.785,6.751l-.089,0V5.271H8.89a.57.57,0,0,1,.459.181.92.92,0,0,1,.183.558c0,.246,0,.469-.222.626a.942.942,0,0,1-.524.114"
                                                style="fill:#fff" />
                                            <path
                                                d="M12.456,4.444c-.111,0-.219.008-.295.011l-.235.006h-.78v4.8h.918a2.677,2.677,0,0,0,1.028-.175,1.71,1.71,0,0,0,.68-.491,1.939,1.939,0,0,0,.373-.749,3.728,3.728,0,0,0,.114-.949,4.416,4.416,0,0,0-.087-1.127,1.777,1.777,0,0,0-.4-.733,1.63,1.63,0,0,0-.535-.4,2.413,2.413,0,0,0-.549-.178,1.282,1.282,0,0,0-.228-.017m-.182,3.937-.1,0V5.315h.013a1.062,1.062,0,0,1,.6.107,1.2,1.2,0,0,1,.324.4,1.3,1.3,0,0,1,.142.526c.009.22,0,.4,0,.549a2.926,2.926,0,0,1-.033.513,1.756,1.756,0,0,1-.169.5,1.13,1.13,0,0,1-.363.36.673.673,0,0,1-.416.106"
                                                style="fill:#fff" />
                                            <path d="M17.353,4.461h-2.43v4.8h1.028V7.357h1.3V6.465h-1.3V5.353h1.4V4.461"
                                                style="fill:#fff" />
                                        </svg>
                                    @elseif(pathinfo(public_path($item->name_doc))['extension'] === 'png' ||
                                            pathinfo(public_path($item->name_doc))['extension'] === 'jpeg' ||
                                            pathinfo(public_path($item->name_doc))['extension'] === 'JPG' ||
                                            pathinfo(public_path($item->name_doc))['extension'] === 'PNG' ||
                                            pathinfo(public_path($item->name_doc))['extension'] === 'jpg')
                                        <!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->
                                        <svg class="size-8" viewBox="0 0 14 14" role="img" focusable="false"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                                            <title>file_type_image</title>
                                            <g transform="translate(.14285704 .14285704) scale(.28571)">

                                                <path fill="#90caf9" d="M40 13v32H8V3h22z" />

                                                <path fill="#e1f5fe" d="M38.5 14H29V4.5z" />

                                                <path fill="#1565c0" d="M21 23l-7 10h14z" />

                                                <path fill="#1976d2" d="M28 26.4L23 33h10z" />

                                                <circle cx="31.5" cy="24.5" r="1.5" fill="#1976d2" />

                                            </g>

                                        </svg>
                                    @endif
                                    {{-- </div> --}}
                                </div>
                                <div>
                                    <div class="font-bold">{{ $item->name_doc }}</div>
                                    <div class="text-sm opacity-50">
                                        {{ pathinfo(public_path($item->name_doc))['extension'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $item->description }}
                        </td>
                        <th>
                            <x-icon-btn-delete
                                class="{{ $current_step === 'Closed' || $current_step === 'Cancelled' ? 'btn-disabled' : '' }}"
                                data-tip="delete" wire:click='destroy({{ $item->id }})'
                                wire:confirm.prompt="Are you sure delete {{ $item->name_doc }}?\n\nType DELETE to confirm|DELETE" />
                        </th>
                    </tr>
                @empty
                    <tr class="font-semibold text-center text-rose-500">
                        <td colspan="4">there is no documentation </td>
                    </tr>
                @endforelse


            </tbody>
            <!-- foot -->

        </table>
    </div>
</div>
