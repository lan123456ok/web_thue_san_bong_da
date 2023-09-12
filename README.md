# Phân tích trang web thuê sân bóng đá


Trang web sử dụng Framework Laravel.

## Đối tượng sử dụng
- Quản trị viên
- Chủ quản lí sân bóng
- Khách hàng
## Chức năng từng đối tượng
- Quản trị viên:
1. quản lí trang web, thông tin, banner, giới thiệu
2. quản lí hệ thống
3. quản lí sân
4. quản lí tài khoản người dùng
- Chủ quản lí sân:
1. quản lí sân bóng
2. quán lí sân (khung giờ từ 7h sáng đến 10h đêm)
3. quản lí khách hàng, thông tin khách hàng
4. chỉnh sửa thông tin cá nhân
5. quản lí lịch hẹn và hóa đơn sân bóng(tên khách hàng, giờ đặt, khung giờ)
6. thống kê theo ngày, tháng
- Khách hàng:
1. đặt sân, hủy sân
2. báo cáo và đánh giá
3. chỉnh sữa thông tin cá nhân

## Phân tích chức năng 

| Các tác nhân | Chủ sân bóng |
| ------ | ------ |
| Mo tả | Đăng ký số sân chủ quản lí |
| Kích hoạt | Người dùng tạo số sân bóng đang sở hữu |
| Đầu vào | Tên sân <br> Đăng ký số sân, loại sân <br> Giá/giờ |
| Trình tự xử lí | Quản lí sân đăng ký số sân quản lí ở trang menu <br> Điền đầy đủ thông tin sân, số sân, loại sân <br> Tạo sân thành công |
| Lưu ý | Kiểm tra xem đã đăng nhập bằng Javascript |
## Bản quyền
MIT
