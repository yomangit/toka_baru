<div>

    <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost btn-sm btn-circle">
            <div class="indicator">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                <span
                    class="text-[9px] text-white badge badge-xs bg-rose-500 indicator-item">{{ auth()->user()->unreadNotifications->count() <= 99 ? auth()->user()->unreadNotifications->count() : '99+' }}</span>
            </div>
        </label>
        <div tabindex="0"
            class=" z-20 card card-compact dropdown-content w-56  lg:w-[28rem] lg:h-[34rem] xl:h-[48rem] bg-base-100 shadow">
            <div class=" card-body">
                <label wire:click='deleteCheked' class=" text-rose-500 btn-link btn-xs {{ $hidden ? 'hidden' : '' }}"
                    checked="checked">Delete
                    Checked</label>
                <div wire:poll role="tablist" class="tabs tabs-bordered ">
                    <input type="radio" name="my_tabs_1" role="tab" class="tab " aria-label="All"
                        checked="checked" />
                    <div role="tabpanel"
                        class="lg:h-[28rem] xl:h-[42rem] max-h-full h-80 overflow-y-auto md:max-h-screen tab-content">
                        <table class="table table-zebra table-xs">
                            <tbody>
                                @forelse  ($AllNotification as $notification)
                                    <tr>
                                        <td><x-input-checkbox value="{{ $notification->id }}"
                                                wire:model.live="seleted_notif" />
                                        </td>
                                        <td>
                                            <label
                                                wire:click="goTo('{{ $notification->id }}','{{ $notification->data['url'] }}')"
                                                class="text-xs cursor-pointer font-signika {{ $notification->read_at == null ? 'text-sky-500' : '' }} ">
                                                {{ $notification->data['line'] }}</label>
                                        </td>
                                        <td>
                                            <x-icon-btn-delete wire:click="delete('{{ $notification->id }}')"
                                                wire:confirm.prompt="Are you sure you want to delete this notification ?\n\nType DELETE to confirm|DELETE"
                                                data-tip="Delete"></x-icon-btn-delete>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>all notifications are read</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <input type="radio" name="my_tabs_1" role="tab" class="tab text-sky-500"
                        aria-label="Unread" />
                    <div role="tabpanel"
                        class="lg:h-[28rem] xl:h-[42rem] max-h-full h-80 overflow-y-auto md:max-h-screen tab-content">
                        <table class="table table-zebra table-xs">
                            <tbody>
                                @forelse ($Unread as $notification)
                                    <tr>
                                        <td><x-input-checkbox value="{{ $notification->id }}"
                                                wire:model.live="seleted_notif" />
                                        </td>
                                        <td>
                                            <label
                                                wire:click="readNotification('{{ $notification->id }}','{{ $notification->data['url'] }}')"
                                                class="text-xs cursor-pointer font-signika text-sky-500">
                                                {{ $notification->data['line'] }}</label>
                                        </td>
                                        <td>
                                            <x-icon-btn-delete wire:click="delete('{{ $notification->id }}')"
                                                wire:confirm.prompt="Are you sure you want to delete this notification ?\n\nType DELETE to confirm|DELETE"
                                                data-tip="Delete"></x-icon-btn-delete>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>all notifications are read</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
