@extends('layouts.admin')

@section('title', 'Chỉnh sửa Sản phẩm')

@section('content')
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            Chỉnh sửa Sản phẩm
        </h2>

        <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Product Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="name">
                        Tên sản phẩm <span class="text-red-600">*</span>
                    </label>
                    <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('name') border-red-600 @enderror" 
                           type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $product->name) }}" 
                           required>
                    @error('name')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="description">
                        Mô tả
                    </label>
                    <textarea class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-textarea @error('description') border-red-600 @enderror" 
                              id="description" 
                              name="description" 
                              rows="3">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Price -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="price">
                            Giá <span class="text-red-600">*</span>
                        </label>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('price') border-red-600 @enderror" 
                               type="number" 
                               id="price" 
                               name="price" 
                               value="{{ old('price', $product->price) }}" 
                               step="0.01" 
                               required>
                        @error('price')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Sale Price -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="sale_price">
                            Giá khuyến mãi
                        </label>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('sale_price') border-red-600 @enderror" 
                               type="number" 
                               id="sale_price" 
                               name="sale_price" 
                               value="{{ old('sale_price', $product->sale_price) }}" 
                               step="0.01">
                        @error('sale_price')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Category -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="category_id">
                            Danh mục <span class="text-red-600">*</span>
                        </label>
                        <select class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-select @error('category_id') border-red-600 @enderror" 
                                id="category_id" 
                                name="category_id" 
                                required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="stock">
                            Tồn kho <span class="text-red-600">*</span>
                        </label>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('stock') border-red-600 @enderror" 
                               type="number" 
                               id="stock" 
                               name="stock" 
                               value="{{ old('stock', $product->stock) }}" 
                               required>
                        @error('stock')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Size -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="size">
                            Size (ví dụ: 38, 39, 40)
                        </label>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('size') border-red-600 @enderror" 
                               type="text" 
                               id="size" 
                               name="size" 
                               value="{{ old('size', $product->size) }}">
                        @error('size')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Color -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="color">
                            Màu sắc
                        </label>
                        <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('color') border-red-600 @enderror" 
                               type="text" 
                               id="color" 
                               name="color" 
                               value="{{ old('color', $product->color) }}">
                        @error('color')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- New Fields Section -->
                <div class="mb-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-400 mb-4">Thông tin bổ sung</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Brand -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="brand">
                                Thương hiệu
                            </label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('brand') border-red-600 @enderror" 
                                   type="text" 
                                   id="brand" 
                                   name="brand" 
                                   value="{{ old('brand', $product->brand) }}"
                                   placeholder="VD: Nike, Adidas">
                            @error('brand')
                                <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Material -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="material">
                                Chất liệu
                            </label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('material') border-red-600 @enderror" 
                                   type="text" 
                                   id="material" 
                                   name="material" 
                                   value="{{ old('material', $product->material) }}"
                                   placeholder="VD: Da thật, Vải canvas">
                            @error('material')
                                <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Specifications -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="specifications">
                            Thông số kỹ thuật
                        </label>
                        <textarea class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-textarea @error('specifications') border-red-600 @enderror" 
                                  id="specifications" 
                                  name="specifications" 
                                  rows="2"
                                  placeholder="VD: Trọng lượng, Kích thước, Công nghệ...">{{ old('specifications', $product->specifications) }}</textarea>
                        @error('specifications')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Rating -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="rating">
                                Đánh giá (0-5 sao)
                            </label>
                            <input class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input @error('rating') border-red-600 @enderror" 
                                   type="number" 
                                   id="rating" 
                                   name="rating" 
                                   value="{{ old('rating', $product->rating ?? 0) }}" 
                                   min="0" 
                                   max="5" 
                                   step="0.1"
                                   placeholder="4.5">
                            @error('rating')
                                <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <!-- Warranty -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="warranty">
                            Bảo hành
                        </label>
                        <textarea class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-textarea @error('warranty') border-red-600 @enderror" 
                                  id="warranty" 
                                  name="warranty" 
                                  rows="2"
                                  placeholder="VD: Bảo hành 1 năm...">{{ old('warranty', $product->warranty) }}</textarea>
                        @error('warranty')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Care Instructions -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="care_instructions">
                            Hướng dẫn bảo quản
                        </label>
                        <textarea class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-textarea @error('care_instructions') border-red-600 @enderror" 
                                  id="care_instructions" 
                                  name="care_instructions" 
                                  rows="2"
                                  placeholder="VD: Vệ sinh sạch sẽ bằng nước ấm...">{{ old('care_instructions', $product->care_instructions) }}</textarea>
                        @error('care_instructions')
                            <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Current Image -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                        Ảnh hiện tại
                    </label>
                    <div class="mt-2">
                        @php
                          // Always use demo images based on product SKU or ID
                          $imageIndex = 1;
                          $id = $product->sku ?? $product->id;
                          if ($id && preg_match('/^(men|women)-(\d+)$/', (string)$id, $m)) {
                            $num = (int)$m[2];
                            $imageIndex = ($num % 10) + 1;
                          } elseif ($product->id) {
                            $imageIndex = (($product->id % 10) + 1);
                          }
                          $imageUrl = asset("user/images/card-item{$imageIndex}.jpg");
                        @endphp
                        <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded-lg">
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-400" for="image">
                        Hình ảnh mới (JPG, PNG, max 2MB)
                    </label>
                    <input class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input @error('image') border-red-600 @enderror" 
                           type="file" 
                           id="image" 
                           name="image" 
                           accept="image/*">
                    @error('image')
                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                    @enderror
                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">Để trống nếu không muốn đổi ảnh</p>
                </div>

                <!-- Checkboxes -->
                <div class="mb-6 space-y-2">
                    <label class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400">
                        <input type="checkbox" 
                               class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" 
                               name="is_featured" 
                               value="1"
                               {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                        <span class="ml-2">Sản phẩm nổi bật</span>
                    </label>
                    <br>
                    <label class="inline-flex items-center text-sm font-medium text-gray-700 dark:text-gray-400">
                        <input type="checkbox" 
                               class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                        <span class="ml-2">Hiển thị sản phẩm</span>
                    </label>
                </div>

                <!-- Buttons -->
                <div class="flex space-x-2">
                    <button type="submit" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        Cập nhật sản phẩm
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 bg-white border border-gray-300 rounded-lg dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600 active:bg-gray-100 hover:bg-gray-100 focus:outline-none focus:shadow-outline-gray">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
