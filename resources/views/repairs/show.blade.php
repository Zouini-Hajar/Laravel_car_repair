@extends('layout')

@php
    $headers = ['Name', 'Reference', 'Quantity', 'Price', 'Total'];
    if (!$spareparts->isEmpty()) {
        $columns = array_keys($spareparts->first()->toArray());
    }
    $total = $repair->price;
@endphp

@section('content')
    <div class="flex justify-between items-center my-5">
        <div class="flex items-center gap-4">
            <button type="button" onclick="history.back()"
                class="text-purple-700 hover:bg-gray-200 focus:outline-none font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center">
                <i class="fa-solid fa-arrow-left"></i>
            </button>
            <h3 class="text-3xl font-bold text-gray-900 dark:text-white">
                {{ $repair->description }}
            </h3>
        </div>
        @if (auth()->user()->role != 'client')
            <button type="button" data-modal-target="edit-modal" data-modal-show="edit-modal"
                class="px-6 py-3 focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900">
                <i class="fa-solid fa-pen"></i> Edit
            </button>
        @endif
    </div>
    <div class="grid grid-cols-2 gap-8">
        @if (auth()->user()->role == 'mechanic' && auth()->user()->mechanic->id == $mechanic->id)
            <x-card title="My Notes">
                <form method="POST" action={{ '/repairs' . '/' . $repair->id }}>
                    @csrf
                    @method('PUT')
                    <div class="w-full rounded-lg bg-gray-50">
                        <div class="px-4 py-2 bg-white rounded-t-lg">
                            <label for="notes" class="sr-only">Your Note</label>
                            <textarea id="notes" rows="4" name="mechanic_notes"
                                class="w-full px-0 text-sm text-gray-900 bg-white border-0 focus:ring-0"
                                placeholder="Keep a note..." required>{{ $repair->mechanic_notes ?? 'Keep a note..' }}
                            </textarea>
                        </div>
                        <div class="flex items-center justify-end px-3 py-2 bg-white">
                            <button type="submit"
                                class="inline-flex items-center py-2.5 px-4 text-xs font-medium text-center text-white bg-purple-700 rounded-lg focus:ring-4 focus:ring-purple-200 dark:focus:ring-purple-900 hover:bg-purple-800">
                                Save
                            </button>
                        </div>
                    </div>
                </form>
            </x-card>
        @else
            <x-card title="Mechanic">
                <x-info-card :user="$user" :person="$mechanic" />
                <hr class="mb-4">
                <p class="text-sm">
                    <span class="font-semibold text-sky-500">
                        <i class="fa-solid fa-pencil"></i> Notes :
                    </span>
                    {{ $repair->mechanic_notes }}
                </p>
            </x-card>
        @endif
        <x-card title="Summary" :status="$repair->status">
            <div class="px-4">
                <div class="flex items-baseline justify-between gap-3 mb-2">
                    <div class="text-sm">Repair Price</div>
                    <div class="flex-1 border-b border-gray-400 border-dashed"></div>
                    <div class="font-bold">{{ $repair->price }} DH</div>
                </div>
                @if (!$spareparts->isEmpty())
                    @foreach ($spareparts as $part)
                        @php
                            $total += $part->quantity * $part->price;
                        @endphp
                        <div class="flex items-baseline justify-between gap-3 mb-2">
                            <div class="text-sm">{{ $part->name }}</div>
                            <div class="flex-1 border-b border-gray-400 border-dashed"></div>
                            <div class="font-bold">{{ $part->quantity * $part->price }} DH</div>
                        </div>
                    @endforeach
                @endif
                <div class="flex items-baseline justify-between gap-3 mb-2 text-purple-700">
                    <div class="font-semibold">Total</div>
                    <div class="flex-1 border-b border-purple-700 border-dashed"></div>
                    <div class="font-bold">{{ $total }} DH</div>
                </div>
            </div>
        </x-card>
        <div
            class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 col-span-2">
            <div class="flex justify-between items-center">
                <h3 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Spare Parts
                </h3>
                @if (auth()->user()->role != 'client')
                    <button type="button" data-modal-target="add-sparepart" data-modal-show="add-sparepart"
                        class="w-10 h-10 flex justify-center items-center text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-full text-sm p-2.5 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                @endif
            </div>
            <hr class="my-4">
            <div class="relative overflow-x-auto">
                @if (!$spareparts->isEmpty())
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <tr>
                                <th class="w-24"></th>
                                @foreach ($headers as $header)
                                    <th scope="col" class="px-6 py-3">
                                        {{ $header }}
                                    </th>
                                @endforeach
                                @if (auth()->user()->role != 'client')
                                    <th scope="col" class="px-6 py-3 text-center"></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($spareparts as $item)
                                <tr
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="text-center">
                                        <img class="w-10 h-10 rounded-full object-cover m-auto"
                                            src="{{ asset('storage/' . $item->picture) }}" alt="Sparepart">
                                    </td>
                                    @foreach ($columns as $col)
                                        @if ($col != 'id' && $col != 'picture')
                                            <td class="px-6 py-4">
                                                @if ($col != 'quantity')
                                                    {{ $item[$col] }}
                                                @else
                                                    @if (auth()->user()->role != 'client')
                                                        <form method="POST"
                                                            action={{ '/repair-spareparts' . '/' . $item->id }}>
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="relative flex items-center">
                                                                <button type="submit" id="decrement-button"
                                                                    data-input-counter-decrement="counter-input"
                                                                    class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                                    <i class="fa-solid fa-minus"></i>
                                                                </button>
                                                                <input type="text" id="counter-input" name="quantity"
                                                                    data-input-counter
                                                                    class="flex-shrink-0 text-gray-900 dark:text-white border-0 bg-transparent text-sm font-normal focus:outline-none focus:ring-0 max-w-[2.5rem] text-center"
                                                                    placeholder="" value={{ $item[$col] }} required />
                                                                <button type="submit" id="increment-button"
                                                                    data-input-counter-increment="counter-input"
                                                                    class="flex-shrink-0 bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 inline-flex items-center justify-center border border-gray-300 rounded-md h-5 w-5 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    @else
                                                        {{ $item[$col] }}
                                                    @endif
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                    <td class="font-semibold px-6 py-4">
                                        {{ $item->quantity * $item->price }}
                                    </td>
                                    @if (auth()->user()->role != 'client')
                                        <td class="flex justify-center items-center px-6 py-4">
                                            <button type="button" data-modal-target="delete-modal"
                                                data-modal-show="delete-modal"
                                                class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800 dark:hover:bg-red-500">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </td>
                                    @endif
                                </tr>
                                @if (auth()->user()->role != 'client')
                                    <x-delete-modal :id="$item->id" route="/repair-spareparts" />
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="text-center">No Spare Parts were used</div>
                @endif
            </div>
        </div>
    </div>
    @if (auth()->user()->role != 'client')
        <x-edit-repair-modal :mechanics="$mechanics" :repair="$repair" />

        <!-- Add Spare Part Modal -->
        <div id="add-sparepart" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-2/5 max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Add Spare Part
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="add-sparepart">
                            <i class="fa-solid fa-x"></i>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <form method="POST" action="/repair-spareparts">
                        @csrf
                        <!-- Modal body -->
                        <div class="p-4 md:p-5 space-y-4">
                            <div class="mb-5">
                                <label for="sparepart_id"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Spare Part
                                </label>
                                <select id="sparepart_id" name="sparepart_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                                    <option value="">Select Spare Part</option>
                                    @foreach ($spareparts_list as $part)
                                        <option value="{{ $part->id }}" @selected($part->id == old('sparepart_id'))>
                                            {{ $part->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sparepart_id')
                                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="mb-5">
                                <label for="quantity"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                    Quantity
                                </label>
                                <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}"
                                    placeholder="Quantity"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                                @error('quantity')
                                    <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <input type="hidden" name="repair_id" value="{{ $repair->id }}">
                        </div>
                        <!-- Modal footer -->
                        <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                            <button data-modal-hide="add-sparepart" type="submit"
                                class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                                Add
                            </button>
                            <button data-modal-hide="add-sparepart" type="button"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection
