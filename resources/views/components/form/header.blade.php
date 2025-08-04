@php
    // Tự động lấy route để xác định đang ở trang thêm hay sửa
    $isCreate = Str::contains(request()->url(), '/create');
    $modelLabel = 'Khách hàng'; // Có thể hardcode hoặc lấy động nếu bạn muốn

    $title = $isCreate ? 'Thêm mới ' . $modelLabel : 'Cập nhật ' . $modelLabel;
@endphp

<div class="text-xl font-bold text-gray-800 mb-6">
    Thêm mới khách hàng
</div>

