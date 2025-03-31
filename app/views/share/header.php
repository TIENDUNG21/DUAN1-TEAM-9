<header>
        <!-- Đây là header gồm: sdt hỗ trợ, logo, tìm kiếm, yêu thích -->
        <div class="box">
            <div class="help"><a href="#">Hỗ trợ: 0123456789</a></div>
            <div class="logo">
                <a href="/"><img src="/public/images/logoTUBOY.jpg" alt="TuBoy Logo"></a>
            </div>
            <div class="extention">
            <div class="search">
                <form action="/index.php" method="GET">
                    <input type="hidden" name="action" value="search">
                    <input type="text" name="search" id="searching" placeholder="Tìm kiếm" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                    <button type="submit" class="btn">
                        <span class="material-symbols-outlined">Search</span>
                    </button>
                </form>
            </div>
                <a href="/"><span class="material-symbols-outlined">Home</span></a>
                <?php 
                   if (!isset($_SESSION['username'])): ?>
                    <a href="/?action=login"><span class="material-symbols-outlined">Account_circle</span></a>
                <?php else: ?>
                    <a href="/?action=profile"><span class="material-symbols-outlined">Account_circle</span></a>
                <?php endif; ?>

                <a href="?action=cart"><span class="material-symbols-outlined">shopping_cart</span></a>

                <?php 
                   if (isset($_SESSION['username'])): ?>
                    <a href="/?action=logout"><span class="material-symbols-outlined">logout</span></a>
                <?php endif; ?>
            </div>
        </div>
    </header>