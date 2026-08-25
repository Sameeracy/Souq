<x-app-layout>
    <x-slot name="title">Add New Product</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('seller.dashboard') }}" class="hover:text-brand-500 transition">Seller Dashboard</a>
            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-gray-800 dark:text-white font-medium">Add New Product</span>
        </nav>

        <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 dark:border-gray-800 dark:bg-gray-dark shadow-theme-xs">
            <div class="border-b border-gray-100 dark:border-gray-800 pb-5 mb-6">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">List a New Product</h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Provide product details, price, images, and customizable variants with individual pricing</p>
            </div>

            <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" 
                  x-data="{ 
                      options: [
                          { name: 'Size', value: 'Standard', price: '' }
                      ],
                      addOption() {
                          this.options.push({ name: '', value: '', price: '' });
                      },
                      removeOption(index) {
                          this.options.splice(index, 1);
                      }
                  }" class="space-y-6">
                @csrf

                <!-- Product Title -->
                <div>
                    <label for="title" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Product Title <span class="text-error-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required value="{{ old('title') }}"
                           placeholder="e.g. Handcrafted Leather Duffle Bag"
                           class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                </div>

                <!-- Price & Image Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Base Price (PKR / Rs.) <span class="text-error-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400 font-bold text-xs">Rs.</div>
                            <input type="number" step="1" min="1" name="price" id="price" required value="{{ old('price') }}"
                                   placeholder="2500"
                                   class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full pl-11 pr-4 py-2.5 rounded-lg border border-gray-300 bg-transparent text-sm text-gray-800 font-semibold focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        </div>
                    </div>

                    <div>
                        <label for="image" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                            Product Image (Optional)
                        </label>
                        <input type="file" name="image" id="image" accept="image/*"
                               class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent p-2 text-xs text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-brand-50 file:text-brand-600 dark:file:bg-brand-500/10 dark:file:text-brand-400 hover:file:bg-brand-100">
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Product Description <span class="text-error-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="4" required
                              placeholder="Describe materials, dimensions, craftsmanship, usage, and any other relevant details..."
                              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">{{ old('description') }}</textarea>
                </div>

                <!-- Dynamic Variants / Options Section -->
                <div class="rounded-xl bg-gray-50 dark:bg-white/[0.02] p-5 border border-gray-200 dark:border-gray-800">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white">Customizable Variants & Custom Pricing (Optional)</h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Specify option names, values, and an optional variant-specific price (Rs.)</p>
                        </div>
                        <button type="button" @click="addOption()" 
                                class="inline-flex items-center px-3 py-1.5 bg-brand-50 hover:bg-brand-100 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 font-semibold text-xs rounded-lg border border-brand-200 dark:border-brand-800 transition cursor-pointer">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            + Add Option
                        </button>
                    </div>

                    <div class="space-y-3 mt-4">
                        <template x-for="(option, index) in options" :key="index">
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 bg-white dark:bg-gray-dark p-3.5 rounded-xl border border-gray-200 dark:border-gray-700 shadow-theme-xs items-end">
                                <div class="sm:col-span-4">
                                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Option Name</label>
                                    <input type="text" :name="'options[' + index + '][name]'" x-model="option.name" placeholder="e.g. Size or Color"
                                           class="dark:bg-dark-900 shadow-theme-xs h-9 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-3 text-xs text-gray-800 dark:text-white">
                                </div>
                                <div class="sm:col-span-4">
                                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Option Value</label>
                                    <input type="text" :name="'options[' + index + '][value]'" x-model="option.value" placeholder="e.g. XL or Navy Blue"
                                           class="dark:bg-dark-900 shadow-theme-xs h-9 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-3 text-xs text-gray-800 dark:text-white">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-[10px] font-bold uppercase text-gray-400 mb-1">Variant Price (Rs.)</label>
                                    <input type="number" step="1" :name="'options[' + index + '][price]'" x-model="option.price" placeholder="Leave empty for base"
                                           class="dark:bg-dark-900 shadow-theme-xs h-9 w-full rounded-lg border border-gray-300 dark:border-gray-700 bg-transparent px-3 text-xs text-gray-800 dark:text-white">
                                </div>
                                <div class="sm:col-span-1 flex justify-end">
                                    <button type="button" @click="removeOption(index)" 
                                            class="p-2 text-gray-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-lg transition" title="Remove option">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Submit & Cancel Actions -->
                <div class="flex items-center justify-end space-x-3 pt-4 border-t border-gray-100 dark:border-gray-800">
                    <a href="{{ route('seller.dashboard') }}" class="px-5 py-2.5 border border-gray-300 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 font-medium text-sm rounded-lg transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-medium text-sm rounded-lg shadow-theme-xs transition cursor-pointer">
                        Publish Product
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>