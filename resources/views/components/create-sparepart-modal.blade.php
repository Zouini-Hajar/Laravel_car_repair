@props(['suppliers'])

<div id="create-modal" tabindex="-1" aria-hidden="true" data-modal-backdrop="static"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-2/5 max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Create New Spare Part
                </h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                    data-modal-hide="create-modal">
                    <i class="fa-solid fa-x"></i>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form method="POST" action="/spareparts" enctype="multipart/form-data">
                @csrf
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <div class="mb-5">
                        <label for="sparepart_picture"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Picture
                        </label>
                        <input type="file" id="sparepart_picture" name="picture"
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            aria-describedby="user_avatar_help">
                        @error('picture')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div class="flex gap-5">
                        <div class="mb-5 flex-1">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Name
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                            @error('name')
                                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="mb-5 flex-1">
                            <label for="reference" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Reference
                            </label>
                            <input type="text" id="reference" name="reference" value="{{ old('reference') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                            @error('reference')
                                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="flex gap-5">
                        <div class="mb-5 flex-1">
                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Price
                            </label>
                            <input type="number" id="price" name="price" value="{{ old('price') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                            @error('price')
                                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="mb-5 flex-1">
                            <label for="stock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Stock
                            </label>
                            <input type="number" id="stock" name="stock" value="{{ old('stock') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500" />
                            @error('stock')
                                <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-5">
                        <label for="supplier_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Supplier
                        </label>
                        <select id="supplier_id" name="supplier_id"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-purple-500 focus:border-purple-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-purple-500 dark:focus:border-purple-500">
                            <option value=""></option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @selected($supplier->id == old('supplier_id'))>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <p id="filled_error_help" class="mt-2 text-xs text-red-600 dark:text-red-400">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="create-modal" type="submit"
                        class="text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                        Save
                    </button>
                    <button data-modal-hide="create-modal" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-purple-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
