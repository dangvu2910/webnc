@include('partials.header')

<div class="container-lg py-5">
  <h1>Kết quả tìm kiếm</h1>
  <p>Từ khóa: <strong>{{ e($q) }}</strong></p>

  @if(empty($q))
    <p>Vui lòng nhập từ khóa tìm kiếm.</p>
  @else
    @if(count($results) === 0)
      <p>Không tìm thấy kết quả nào cho <strong>{{ e($q) }}</strong>.</p>
    @else
      <ul class="list-unstyled">
        @foreach($results as $r)
          <li class="py-2 border-bottom">
            <a href="{{ $r['url'] }}">{{ $r['title'] }}</a>
          </li>
        @endforeach
      </ul>
    @endif
  @endif
</div>

@include('partials.footer')
