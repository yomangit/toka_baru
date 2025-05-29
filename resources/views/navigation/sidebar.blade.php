<!-- start: Sidebar -->
<div
    class="fixed top-0 left-0 z-50 w-64 h-full overflow-y-auto transition-transform bg-base-400 text-neutral-content sidebar-menu">
    <a href="#"
        class="fixed top-0 z-50 flex items-center w-64 p-1 border-b shadow-md shadow-indigo-500/50 bg-base-400 border-b-gray-800">
        <div class="avatar ">
            <div class="w-8 rounded">
                <img src="{{ asset('icons.png') }}" alt="Tailwind-CSS-Avatar-component" />
            </div>
        </div>
        <span
            class="ml-3 text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-500 to-yellow-500">TOSAR</span>
    </a>

    <ul class="mt-12 menu menu-xs">
        <li>


            <a href="{{ route('dashboard') }}"class="{{ Request::is('/') ? 'text-primary-muted font-semibold' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                    <path
                        d="M8.543 2.232a.75.75 0 0 0-1.085 0l-5.25 5.5A.75.75 0 0 0 2.75 9H4v4a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1v-1a1 1 0 1 1 2 0v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V9h1.25a.75.75 0 0 0 .543-1.268l-5.25-5.5Z" />
                </svg>
                Dashboard</a>
        </li>
        @auth
            <li>
                <details {{ Request::is('eventReport/*') ? ' open' : '' }}>
                    <summary class="{{ Request::is('eventReport*') ? ' text-primary-muted font-semibold' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd"
                                d="M11.986 3H12a2 2 0 0 1 2 2v6a2 2 0 0 1-1.5 1.937V7A2.5 2.5 0 0 0 10 4.5H4.063A2 2 0 0 1 6 3h.014A2.25 2.25 0 0 1 8.25 1h1.5a2.25 2.25 0 0 1 2.236 2ZM10.5 4v-.75a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75V4h3Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M3 6a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H3Zm1.75 2.5a.75.75 0 0 0 0 1.5h3.5a.75.75 0 0 0 0-1.5h-3.5ZM4 11.75a.75.75 0 0 1 .75-.75h3.5a.75.75 0 0 1 0 1.5h-3.5a.75.75 0 0 1-.75-.75Z"
                                clip-rule="evenodd" />
                        </svg>

                        Event Report
                    </summary>
                    <ul class="p-1 w-52 bg-base-400 menu menu-xs">
                        <li><a
                                href="{{ route('incidentReport') }}"class="{{ Request::is('eventReport/incidentReport*') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Incident Report') }}</a>
                        </li>
                        <li><a
                                href="{{ route('hazardReport') }}"class="{{ Request::is('eventReport/hazardReport*') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Hazard Report') }}</a>
                        </li>
                        <li><a
                                href="{{ route('ptoReport') }}"class="{{ Request::is('eventReport/PTOReport*') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('PTO Report') }}</a>
                        </li>

                    </ul>
                </details>
            </li>
            <li>
                <details {{ Request::is('manhours*') ? ' open' : '' }}>
                    <summary class="{{ Request::is('manhours*') ? ' text-primary-muted font-semibold' : '' }}">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                            <path fill-rule="evenodd"
                                d="M11.986 3H12a2 2 0 0 1 2 2v6a2 2 0 0 1-1.5 1.937V7A2.5 2.5 0 0 0 10 4.5H4.063A2 2 0 0 1 6 3h.014A2.25 2.25 0 0 1 8.25 1h1.5a2.25 2.25 0 0 1 2.236 2ZM10.5 4v-.75a.75.75 0 0 0-.75-.75h-1.5a.75.75 0 0 0-.75.75V4h3Z"
                                clip-rule="evenodd" />
                            <path fill-rule="evenodd"
                                d="M3 6a1 1 0 0 0-1 1v7a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H3Zm1.75 2.5a.75.75 0 0 0 0 1.5h3.5a.75.75 0 0 0 0-1.5h-3.5ZM4 11.75a.75.75 0 0 1 .75-.75h3.5a.75.75 0 0 1 0 1.5h-3.5a.75.75 0 0 1-.75-.75Z"
                                clip-rule="evenodd" />
                        </svg>

                        Manhours
                    </summary>
                    <ul class="p-1 w-52 bg-base-400 menu menu-xs">
                        <li><a
                                href="{{ route('manhoursRegister') }}"class="{{ Request::is('manhours/manhoursRegister*') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Manhours Register') }}</a>
                        </li>
                        @if (auth()->user()->role_user_permit_id == 1)
                            <li><a
                                    href="{{ route('manhoursSite') }}"class="{{ Request::is('manhours/manhoursSite*') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Manhours Site') }}</a>
                            </li>
                        @endif

                    </ul>
                </details>
            </li>
            @if (auth()->user()->role_user_permit_id == 1)
                <li>
                    <details {{ Request::is('admin*') ? ' open' : '' }}>
                        <summary class="{{ Request::is('admin*') ? ' text-primary-muted font-semibold' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                                <path fill-rule="evenodd"
                                    d="M6.955 1.45A.5.5 0 0 1 7.452 1h1.096a.5.5 0 0 1 .497.45l.17 1.699c.484.12.94.312 1.356.562l1.321-1.081a.5.5 0 0 1 .67.033l.774.775a.5.5 0 0 1 .034.67l-1.08 1.32c.25.417.44.873.561 1.357l1.699.17a.5.5 0 0 1 .45.497v1.096a.5.5 0 0 1-.45.497l-1.699.17c-.12.484-.312.94-.562 1.356l1.082 1.322a.5.5 0 0 1-.034.67l-.774.774a.5.5 0 0 1-.67.033l-1.322-1.08c-.416.25-.872.44-1.356.561l-.17 1.699a.5.5 0 0 1-.497.45H7.452a.5.5 0 0 1-.497-.45l-.17-1.699a4.973 4.973 0 0 1-1.356-.562L4.108 13.37a.5.5 0 0 1-.67-.033l-.774-.775a.5.5 0 0 1-.034-.67l1.08-1.32a4.971 4.971 0 0 1-.561-1.357l-1.699-.17A.5.5 0 0 1 1 8.548V7.452a.5.5 0 0 1 .45-.497l1.699-.17c.12-.484.312-.94.562-1.356L2.629 4.107a.5.5 0 0 1 .034-.67l.774-.774a.5.5 0 0 1 .67-.033L5.43 3.71a4.97 4.97 0 0 1 1.356-.561l.17-1.699ZM6 8c0 .538.212 1.026.558 1.385l.057.057a2 2 0 0 0 2.828-2.828l-.058-.056A2 2 0 0 0 6 8Z"
                                    clip-rule="evenodd" />
                            </svg>

                            Administrator
                        </summary>
                        <ul class="p-1 w-52 bg-base-400 menu menu-xs">
                            <li>
                                <details {{ Request::is('admin/parent*') ? ' open' : '' }}>
                                    <summary
                                        class="{{ Request::is('admin/parent/*') ? ' text-primary-muted font-semibold' : '' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                            class="size-4">
                                            <path fill-rule="evenodd"
                                                d="M3.757 4.5c.18.217.376.42.586.608.153-.61.354-1.175.596-1.678A5.53 5.53 0 0 0 3.757 4.5ZM8 1a6.994 6.994 0 0 0-7 7 7 7 0 1 0 7-7Zm0 1.5c-.476 0-1.091.386-1.633 1.427-.293.564-.531 1.267-.683 2.063A5.48 5.48 0 0 0 8 6.5a5.48 5.48 0 0 0 2.316-.51c-.152-.796-.39-1.499-.683-2.063C9.09 2.886 8.476 2.5 8 2.5Zm3.657 2.608a8.823 8.823 0 0 0-.596-1.678c.444.298.842.659 1.182 1.07-.18.217-.376.42-.586.608Zm-1.166 2.436A6.983 6.983 0 0 1 8 8a6.983 6.983 0 0 1-2.49-.456 10.703 10.703 0 0 0 .202 2.6c.72.231 1.49.356 2.288.356.798 0 1.568-.125 2.29-.356a10.705 10.705 0 0 0 .2-2.6Zm1.433 1.85a12.652 12.652 0 0 0 .018-2.609c.405-.276.78-.594 1.117-.947a5.48 5.48 0 0 1 .44 2.262 7.536 7.536 0 0 1-1.575 1.293Zm-2.172 2.435a9.046 9.046 0 0 1-3.504 0c.039.084.078.166.12.244C6.907 13.114 7.523 13.5 8 13.5s1.091-.386 1.633-1.427c.04-.078.08-.16.12-.244Zm1.31.74a8.5 8.5 0 0 0 .492-1.298c.457-.197.893-.43 1.307-.696a5.526 5.526 0 0 1-1.8 1.995Zm-6.123 0a8.507 8.507 0 0 1-.493-1.298 8.985 8.985 0 0 1-1.307-.696 5.526 5.526 0 0 0 1.8 1.995ZM2.5 8.1c.463.5.993.935 1.575 1.293a12.652 12.652 0 0 1-.018-2.608 7.037 7.037 0 0 1-1.117-.947 5.48 5.48 0 0 0-.44 2.262Z"
                                                clip-rule="evenodd" />
                                        </svg>

                                        Global
                                    </summary>
                                    <ul>
                                        <li><a
                                                href="{{ route('categoryCompany') }}"class="{{ Request::is('admin/parent/companyCategory*') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Company Category') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('company') }}"class="{{ Request::is('admin/parent/company') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Company ') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('businnesUnit') }}"class="{{ Request::is('admin/parent/businnesUnit*') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Business Unit ') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('department') }}"class="{{ Request::is('admin/parent/department') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Department ') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('deptGroup') }}"class="{{ Request::is('admin/parent/deptGroup') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Dept Group ') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('subContDept') }}"class="{{ Request::is('admin/parent/subContDept') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Custodion Department') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('DeptByBU') }}"class="{{ Request::is('admin/parent/DeptByBU') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Dept Under Business Unit') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('section') }}"class="{{ Request::is('admin/parent/section') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Section') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('division') }}"class="{{ Request::is('admin/parent/division') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Division') }}</a>
                                        </li>

                                        <li>
                                            <a
                                                href="{{ route('JobClass') }}"class="{{ Request::is('admin/parent/JobClass') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Job Class') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('keyWord') }}"class="{{ Request::is('admin/parent/keyWord') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Keyword Maintenance') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('userInputManhours') }}"class="{{ Request::is('admin/parent/userInputManhours') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('User Input Manhours') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('typeInvolvement') }}"class="{{ Request::is('admin/parent/typeInvolvement') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Type Involvement') }}</a>
                                        </li>


                                        <li><a
                                                href="{{ route('routeRequestEvent') }}"class="{{ Request::is('admin/parent/routeRequestEvent') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Route Request Event') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('choseEventType') }}"class="{{ Request::is('admin/parent/choseEventType') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Route Event Type') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('statusEvent') }}"class="{{ Request::is('admin/parent/statusEvent') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Status Event') }}</a>
                                        </li>
                                        <li>
                                            <details {{ Request::is('admin/parent/event/*') ? ' open' : '' }}>
                                                <summary
                                                    class=" {{ Request::is('admin/parent/event*') ? ' text-primary-muted font-semibold' : '' }}">
                                                    Event-General</summary>
                                                <ul>
                                                    <li>
                                                        <a
                                                            href="{{ route('eventUserSecurity') }}"class="{{ Request::is('admin/parent/event/eventUserSecurity') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Event User Security') }}</a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="{{ route('eventCategory') }}"class="{{ Request::is('admin/parent/event/eventCategory') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Event Category') }}</a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="{{ route('typeEventReport') }}"class="{{ Request::is('admin/parent/event/typeEventReport') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Event Type') }}</a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="{{ route('eventSubType') }}"class="{{ Request::is('admin/parent/event/eventSubType') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Event Subtype') }}</a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            href="{{ route('responsibleRole') }}"class="{{ Request::is('admin/parent/event/responsibleRole') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Responsible Role') }}</a>
                                                    </li>

                                                </ul>
                                            </details>
                                        </li>
                                        <li><a
                                                href="{{ route('riskConsequence') }}"class="{{ Request::is('admin/parent/riskConsequence') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Risk Consequence') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('riskAssessment') }}"class="{{ Request::is('admin/parent/riskAssessment') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Risk Assessment') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('riskLikelihood') }}"class="{{ Request::is('admin/parent/riskLikelihood') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Risk Likelihood') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('tableRiskAssessment') }}"class="{{ Request::is('admin/parent/tableRiskAssessment') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Table Risk') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('workflowAdministration') }}"class="{{ Request::is('admin/parent/workflowAdministration') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Workflow Administration') }}</a>
                                        </li>

                                        <li><a
                                                href="{{ route('location') }}"class="{{ Request::is('admin/parent/location') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Location Event') }}</a>
                                        </li>
                                        <li><a
                                                href="{{ route('site') }}"class="{{ Request::is('admin/parent/site') ? 'active text-emerald-500 font-semibold' : '' }}">{{ __('Site') }}</a>
                                        </li>
                                    </ul>
                                </details>
                            </li>
                            <li><a
                                    href="{{ route('people') }}"class="{{ Request::is('admin/people*') ? 'active text-emerald-500 font-semibold' : '' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor"
                                        class="size-4">
                                        <path
                                            d="M8 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM3.156 11.763c.16-.629.44-1.21.813-1.72a2.5 2.5 0 0 0-2.725 1.377c-.136.287.102.58.418.58h1.449c.01-.077.025-.156.045-.237ZM12.847 11.763c.02.08.036.16.046.237h1.446c.316 0 .554-.293.417-.579a2.5 2.5 0 0 0-2.722-1.378c.374.51.653 1.09.813 1.72ZM14 7.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0ZM3.5 9a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3ZM5 13c-.552 0-1.013-.455-.876-.99a4.002 4.002 0 0 1 7.753 0c.136.535-.324.99-.877.99H5Z" />
                                    </svg>

                                    {{ __('People') }}</a>
                            </li>
                        </ul>
                    </details>
                </li>
            @endif
        @endauth

    </ul>

</div>
<div class="fixed top-0 left-0 z-40 w-full h-full bg-black/50 md:hidden sidebar-overlay"></div>
<!-- end: Sidebar -->
