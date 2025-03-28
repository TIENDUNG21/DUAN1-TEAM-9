<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="/public/css/profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>
<body>
    <?php include __DIR__ . '/../share/header.php'; ?>
    <?php include __DIR__ . '/../share/nav.php'; ?>
    <main>
        <div class="profile-container">
            <h2>Hồ Sơ Của Tôi</h2>
            <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
            <?php if (isset($error)): ?>
                <p class="error-message"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <form action="/index.php?action=profile" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username">Tên đăng nhập</label>
                    <input type="text" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
                    <small>Tên Đăng nhập chỉ có thể thay đổi một lần.</small>
                </div>

                <div class="form-group">
                    <label for="full_name">Tên</label>
                    <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($user['full_name'] ?? ''); ?>" placeholder="Nhập tên của bạn">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
                    <a href="#">Thay Đổi</a>
                </div>

                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" placeholder="Nhập số điện thoại">
                    <?php if (empty($user['phone'])): ?>
                        <a href="#">Thêm</a>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <textarea id="address" name="address" placeholder="Nhập địa chỉ của bạn"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Giới tính</label>
                    <label><input type="radio" name="gender" value="male" <?php echo ($user['gender'] ?? '') === 'male' ? 'checked' : ''; ?>> Nam</label>
                    <label><input type="radio" name="gender" value="female" <?php echo ($user['gender'] ?? '') === 'female' ? 'checked' : ''; ?>> Nữ</label>
                    <label><input type="radio" name="gender" value="other" <?php echo ($user['gender'] ?? '') === 'other' ? 'checked' : ''; ?>> Khác</label>
                </div>

                <div class="form-group">
                    <label>Ngày sinh</label>
                    <div class="birthday-select">
                        <select name="day">
                            <option value="">Ngày</option>
                            <?php for ($i = 1; $i <= 31; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo (isset($user['birth_date']) && date('d', strtotime($user['birth_date'])) == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                        <select name="month">
                            <option value="">Tháng</option>
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php echo (isset($user['birth_date']) && date('m', strtotime($user['birth_date'])) == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                        <select name="year">
                            <option value="">Năm</option>
                            <?php for ($i = date('Y'); $i >= 1900; $i--): ?>
                                <option value="<?php echo $i; ?>" <?php echo (isset($user['birth_date']) && date('Y', strtotime($user['birth_date'])) == $i) ? 'selected' : ''; ?>>
                                    <?php echo $i; ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label>Ảnh đại diện</label>
                    <?php if (!empty($user['avatar'])): ?>
                        <img src="/public/images/avatars/<?php echo htmlspecialchars($user['avatar']); ?>" alt="Avatar" width="100" class="mb-2">
                    <?php endif; ?>
                    <input type="file" name="avatar" accept=".jpg, .jpeg, .png">
                    <small>Dung lượng file tối đa 1 MB, định dạng: .JPEG, .PNG</small>
                </div>

                <button type="submit">Lưu</button>
            </form>
        </div>
    </main>
    <?php include __DIR__. '/../share/footer.php';?>
</body>
</html>