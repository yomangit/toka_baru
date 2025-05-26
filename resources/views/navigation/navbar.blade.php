<div class="sticky top-0 left-0 z-50 flex items-center px-2 shadow-md bg-base-300 shadow-black/5">
    <button type="button" class="py-3 text-lg text-gray-600 sidebar-toggle">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
            <path fill-rule="evenodd"
                d="M2 3.75A.75.75 0 0 1 2.75 3h10.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 3.75ZM2 8a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H2.75A.75.75 0 0 1 2 8Zm0 4.25a.75.75 0 0 1 .75-.75h4.5a.75.75 0 0 1 0 1.5h-4.5a.75.75 0 0 1-.75-.75Z"
                clip-rule="evenodd" />
        </svg>

    </button>
   <div class="hidden ml-4 sm:block"> @yield('bradcrumbs')</div>

    <div class="flex items-center gap-1 ml-auto">
        @auth

        <livewire:notification.index>
            <div class="dropdown dropdown-bottom dropdown-end">
                <div tabindex="0" role="button" class="">
                    <p
                        class="capitalize text-xs font-semibold bg-clip-text text-transparent bg-gradient-to-r from-[#03346E] to-[#021526]">
                        {{ isset(auth()->user()->lookup_name) ? auth()->user()->lookup_name : 'guest' }}</p>
                </div>
                <ul tabindex="0" class="dropdown-content menu-xs menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                    <li>
                        @auth
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        @endauth
                    </li>
                </ul>
            </div>
        @else
            <a class="btn btn-link btn-xs" href="{{ route('login') }}">Log in</a>
            @if (Route::has('register'))
                <a class="btn btn-link btn-xs" href="{{ route('register') }}">Register</a>
            @endif
        @endauth
        <div class="dropdown dropdown-end avatar">
            <label class="rounded btn btn-ghost btn-xs btn-square" tabindex="0" role="button">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd" d="M11 5a.75.75 0 0 1 .688.452l3.25 7.5a.75.75 0 1 1-1.376.596L12.89 12H9.109l-.67 1.548a.75.75 0 1 1-1.377-.596l3.25-7.5A.75.75 0 0 1 11 5Zm-1.24 5.5h2.48L11 7.636 9.76 10.5ZM5 1a.75.75 0 0 1 .75.75v1.261a25.27 25.27 0 0 1 2.598.211.75.75 0 1 1-.2 1.487c-.22-.03-.44-.056-.662-.08A12.939 12.939 0 0 1 5.92 8.058c.237.304.488.595.752.873a.75.75 0 0 1-1.086 1.035A13.075 13.075 0 0 1 5 9.307a13.068 13.068 0 0 1-2.841 2.546.75.75 0 0 1-.827-1.252A11.566 11.566 0 0 0 4.08 8.057a12.991 12.991 0 0 1-.554-.938.75.75 0 1 1 1.323-.707c.049.09.099.181.15.271.388-.68.708-1.405.952-2.164a23.941 23.941 0 0 0-4.1.19.75.75 0 0 1-.2-1.487c.853-.114 1.72-.185 2.598-.211V1.75A.75.75 0 0 1 5 1Z" clip-rule="evenodd" />
                  </svg>
              </label>

            <ul tabindex="0" class="dropdown-content menu menu-xs bg-base-300  rounded-box z-[1] w-52 shadow">

              <li><a href="{{route('locale','en')}}" ><x-flag-language-en class="w-4 h-4"/>English</a></li>
              <li><a href="{{route('locale','id')}}"><x-flag-language-id class="w-4 h-4"/>Indonesia</a></li>
            </ul>
          </div>
    </div>
</div>
