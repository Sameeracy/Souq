<x-app-layout>
    <x-slot name="title">Admin Edit Product: {{ $product->title }}</x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition">Admin Dashboard</a>
            <svg class="w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-slate-800 font-semibold truncate">Edit {{ $product->title }}</span>
        </nav>

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm p-6 sm:p-10">
            <div class="border-b border-slate-100 pb-6 mb-8 flex items-center justify-between">
                <div>
                    <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 text-xs font-bold uppercase tracking-wider mb-2">
                        <span>Admin Product Override</span>
                    </div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">Edit Marketplace Product</h1>
                    <p class="text-sm text-slate-500 mt-1">Listed by seller: <strong class="text-slate-800">{{ $product->seller->name ?? 'Unknown' }}</strong> ({{ $product->seller->email ?? 'N/A' }})</p>
                </div>
                <a href="{{ route('product.show', $product) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 underline">
                    View Live &rarr;
                </a>
            </div>

            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" 
                  x-data="{ 
                      options: {{ Js::from($product->options->map(fn($o) => ['name' => $o->name, 'value' => $o->value, 'price' => $o->price])) }},
                      addOption() {
                          this.options.push({ name: '', value: '', price: '' });
                      },
                      removeOption(index) {
                          this.options.splice(index, 1);
                      }
                  }" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Product Title -->
                <div>
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Product Title <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" required value="{{ old('title', $product->title) }}"
                           class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3.5">
                </div>

                <!-- Price & Image Row -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="price" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Base Price (PKR / Rs.) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400 font-bold text-xs">Rs.</div>
                            <input type="number" step="1" min="1" name="price" id="price" required value="{{ old('price', $product->price) }}"
                                   class="w-full pl-10 bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3.5 font-semibold">
                        </div>
                    </div>

                    <div>
                        <label for="image" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                            Replace Image (Optional)
                        </label>
                        <div class="flex items-center space-x-3">
                            @if($product->image_path)
                                <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200">
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="Current Image" class="w-full h-full object-cover">
                                </div>
                            @endif
                            <input type="file" name="image" id="image" accept="image/*"
                                   class="flex-1 bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-2 file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700">
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                        Product Description <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="4" required
                              class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3.5">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Dynamic Variants / Options Section -->
                <div class="bg-slate-50 rounded-2xl p-5 sm:p-6 border border-slate-200/80">
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900">Customizable Variants & Custom Pricing</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Admin can modify options and variant-specific pricing (Rs.)</p>
                        </div>
                        <button type="button" @click="addOption()" 
                                class="inline-flex items-center px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-bold text-xs rounded-xl border border-indigo-200 transition">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            + Add Option
                        </button>
                    </div>

                    <div class="space-y-3 mt-4">
                        <template x-for="(option, index) in options" :key="index">
                            <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 bg-white p-3.5 rounded-xl border border-slate-200 shadow-sm items-end">
                                <div class="sm:col-span-4">
                                    <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Option Name</label>
                                    <input type="text" :name="'options[' + index + '][name]'" x-model="option.name" placeholder="e.g. Size or Color"
                                           class="w-full bg-slate-50 border border-slate-300 text-xs rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div class="sm:col-span-4">
                                    <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Option Value</label>
                                    <input type="text" :name="'options[' + index + '][value]'" x-model="option.value" placeholder="e.g. XL or Navy Blue"
                                           class="w-full bg-slate-50 border border-slate-300 text-xs rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500">
                                </div>
                                <div class="sm:col-span-3">
                                    <label class="block text-[10px] font-bold uppercase text-slate-400 mb-1">Variant Price (Rs.)</label>
                                    <input type="number" step="1" min="1" :name="'options[' + index + '][price]'" x-model="option.price" placeholder="Base price"
                                           class="w-full bg-slate-50 border border-slate-300 text-xs rounded-lg p-2.5 focus:ring-indigo-500 focus:border-indigo-500 font-semibold">
                                </div>
                                <div class="sm:col-span-1 flex justify-end">
                                    <button type="button" @click="removeOption(index)" class="p-2.5 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition" title="Remove option">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </div>
                        </template>

                        <div x-show="options.length === 0" class="text-xs text-slate-400 italic text-center py-2">
                            No variants configured for this product.
                        </div>
                    </div>
                </div>

                <!-- Submit Form -->
                <div class="pt-4 flex items-center justify-end space-x-3">
                    <a href="{{ route('admin.dashboard') }}" class="px-5 py-3 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-purple-600/30 transition">
                        Save Changes as Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
