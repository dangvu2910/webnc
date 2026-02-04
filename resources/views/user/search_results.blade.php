@extends('layouts.user')

@section('title', 'Kết quả tìm kiếm')

@section('content')
@include('partials.header')

<div class="container-lg py-5">
  <div class="mb-4">
    <h1 class="mb-2">Kết quả tìm kiếm</h1>
    <p class="text-muted">Từ khóa: <strong>{{ e($q) }}</strong>
      @if($selectedCategory)
        | Danh mục: <strong>{{ $categories->find($selectedCategory)?->name }}</strong>
      @endif
    </p>
  </div>

  <!-- Filter Section -->
  <div class="card mb-4">
    <div class="card-body">
      <form action="{{ url('/search') }}" method="get" class="row g-3 align-items-end">
        <div class="col-md-6">
          <label for="searchKeyword" class="form-label">Từ khóa</label>
          <input type="text" class="form-control" id="searchKeyword" name="q" value="{{ e($q) }}" placeholder="Tìm kiếm...">
        </div>
        <div class="col-md-4">
          <label for="categorySelect" class="form-label">Danh mục</label>
          <select class="form-select" id="categorySelect" name="category_id">
            <option value="">-- Tất cả danh mục --</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ $selectedCategory == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
        </div>
        <div class="col-md-2">
          <button type="submit" class="btn btn-primary w-100">Lọc</button>
        </div>
      </form>
    </div>
  </div>

  @if(empty($q))
    <div class="alert alert-info" role="alert">
      Vui lòng nhập từ khóa tìm kiếm.
    </div>
  @else
    @if($results->isEmpty())
      <div class="alert alert-warning" role="alert">
        Không tìm thấy sản phẩm nào cho <strong>{{ e($q) }}</strong>
        @if($selectedCategory)
          trong danh mục <strong>{{ $categories->find($selectedCategory)?->name }}</strong>
        @endif
        . Vui lòng thử tìm kiếm với từ khóa khác.
      </div>
    @else
      <p class="text-muted mb-4">Tìm thấy <strong>{{ $results->total() }}</strong> sản phẩm</p>

      <!-- Products Grid -->
      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
        @forelse($results as $product)
          <div class="col">
            <div class="product-item position-relative">
              <div class="card rounded-0 shadow-sm border-0 overflow-hidden h-100">
                <!-- Product Image -->
                <div class="card-image position-relative overflow-hidden">
                  <a href="{{ route('product.show', $product->sku ?? $product->id) }}">
                    @php
                      // Always use demo images based on product ID or SKU
                      $imageIndex = 1;
                      if ($product->sku && preg_match('/^(men|women)-(\d+)$/', $product->sku, $m)) {
                        $num = (int)$m[2];
                        $imageIndex = ($num % 10) + 1;
                      } else {
                        $imageIndex = (($product->id % 10) + 1);
                      }
                      $imageUrl = asset("user/images/card-item{$imageIndex}.jpg");
                    @endphp
                    <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="img-fluid" style="height: 250px; object-fit: cover;">
                  </a>
                  
                  <!-- Sale Badge -->
                  @if($product->sale_price && $product->sale_price < $product->price)
                    <div class="position-absolute top-0 start-0 m-3">
                      <span class="badge bg-danger">Giảm giá</span>
                    </div>
                  @endif

                  <!-- Featured Badge -->
                  @if($product->is_featured)
                    <div class="position-absolute top-0 end-0 m-3">
                      <span class="badge bg-info">Nổi bật</span>
                    </div>
                  @endif
                </div>

                <!-- Product Info -->
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title">
                    <a href="{{ route('product.show', $product->sku ?? $product->id) }}" class="text-dark text-decoration-none">{{ $product->name }}</a>
                  </h5>

                  <!-- Brand & Material -->
                  @if($product->brand || $product->material)
                    <div class="small text-muted mb-2">
                      @if($product->brand)
                        <span class="badge bg-light text-dark">{{ $product->brand }}</span>
                      @endif
                      @if($product->material)
                        <span class="badge bg-light text-dark">{{ $product->material }}</span>
                      @endif
                    </div>
                  @endif
                  
                  <p class="card-text text-muted small">
                    {{ \Illuminate\Support\Str::limit($product->description, 50) }}
                  </p>

                  <!-- Rating & Reviews -->
                  @if($product->rating > 0)
                    <div class="mb-2">
                      <div class="d-flex align-items-center gap-2">
                        <div>
                          @for($i = 1; $i <= 5; $i++)
                            <span class="text-warning small">
                              @if($i <= floor($product->rating))
                                ★
                              @elseif($i - 0.5 <= $product->rating)
                                ★
                              @else
                                ☆
                              @endif
                            </span>
                          @endfor
                        </div>
                        <span class="text-muted small">({{ $product->reviews_count }})</span>
                      </div>
                    </div>
                  @endif

                  <!-- Stock Status -->
                  <div class="mb-2">
                    @if($product->stock > 0)
                      <small class="text-success">✓ Còn hàng ({{ $product->stock }})</small>
                    @else
                      <small class="text-danger">✗ Hết hàng</small>
                    @endif
                  </div>

                  <!-- Price -->
                  <div class="mb-3 mt-auto">
                    @if($product->sale_price && $product->sale_price < $product->price)
                      <span class="h6 text-danger">
                        {{ number_format($product->sale_price, 0, ',', '.') }} ₫
                      </span>
                      <span class="text-muted text-decoration-line-through small ms-2">
                        {{ number_format($product->price, 0, ',', '.') }} ₫
                      </span>
                    @else
                      <span class="h6">
                        {{ number_format($product->price, 0, ',', '.') }} ₫
                      </span>
                    @endif
                  </div>

                  <!-- Action Buttons -->
                  <div class="d-grid gap-2">
                    <a href="{{ route('product.show', $product->sku ?? $product->id) }}" class="btn btn-outline-dark btn-sm">
                      Xem chi tiết
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12">
            <p class="text-center text-muted">Không có sản phẩm</p>
          </div>
        @endforelse
      </div>

      <!-- Pagination -->
      @if($results->hasPages())
        <div class="d-flex justify-content-center mt-5">
          {{ $results->appends(request()->query())->links('pagination::bootstrap-4') }}
        </div>
      @endif
    @endif
  @endif
</div>

@endsection
