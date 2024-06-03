@props(['mechanics', 'repair', 'target'])

<div id={{ isset($target) ? $target : 'edit-modal' }} tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-2/5 max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Edit Repair
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide={{ isset($target) ? $target : 'edit-modal' }}>
                    <i class="fa-solid fa-x"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form method="POST" action={{ '/repairs' . '/' . $repair->id }}>
                @csrf
                @method('PUT')
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    @if (auth()->user()->role != 'mechanic')
                        <div class="mb-5">
                            <label for="mechanic_id"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Mechanic
                            </label>
                            <select id="mechanic_id" name="mechanic_id"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                @foreach ($mechanics as $mechanic)
                                    <option value="{{ $mechanic->id }}" @selected($mechanic->id == $repair->mechanic_id)>
                                        {{ $mechanic->first_name . ' ' . $mechanic->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mechanic_id')
                                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    @endif
                    <div class="flex gap-5 mb-5">
                        <div class="flex-1">
                            <label for="start_date"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Start Date
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <i class="fa-solid fa-calendar-minus text-gray-500 dark:text-gray-400"></i>
                                </div>
                                <input datepicker type="text" id="start_date" name="start_date"
                                    value="{{ $repair->start_date }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500"
                                    placeholder="Start date">
                            </div>
                            @error('start_date')
                                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="flex-1">
                            <label for="end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                End Date
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                    <i class="fa-solid fa-calendar-minus text-gray-500 dark:text-gray-400"></i>
                                </div>
                                <input datepicker type="text" id="end_date" name="end_date"
                                    value="{{ $repair->end_date }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500"
                                    placeholder="End date">
                            </div>
                            @error('end_date')
                                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Status
                        </label>
                        <select id="status" name="status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                            <option value="Pending" @selected($repair->status == 'Pending')>Pending</option>
                            <option value="In Progress" @selected($repair->status == 'In Progress')>In Progress</option>
                            <option value="Completed" @selected($repair->status == 'Completed')>Completed</option>
                        </select>
                        @error('status')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    @if (auth()->user()->role == 'mechanic')
                        <input class="hidden" type="text" name="mechanic_id" id="mechanic"
                            value={{ auth()->user()->mechanic->id }}>
                    @endif
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide={{ isset($target) ? $target : 'edit-modal' }} type="submit"
                        class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                        Update
                    </button>
                    <button data-modal-hide={{ isset($target) ? $target : 'edit-modal' }} type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
