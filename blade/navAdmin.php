<?php

/**
 * Return active class when current request filename matches given name.
 *
 * @param string $name Filename to compare (e.g. 'admin.php')
 * @return string CSS class when active, otherwise empty string
 */
function _spk_is_active(string $name): string
{
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '';
    $current = basename($path);
    return $current === $name ? 'spk-nav-link-active' : '';
}
?>

<div class="spk-nav-wrapper">
    <div class="row mt-2">
        <div class="col-12">
            <div class="spk-card p-1 shadow-sm">
                <nav class="spk-nav" aria-label="Admin navigation">
                    <a href="../admin/admin.php" class="spk-nav-link <?php echo _spk_is_active('admin.php'); ?>">
                        <?php echo spk_icon('home'); ?>
                        <span>Home</span>
                    </a>
                    <a href="../admin/userView.php" class="spk-nav-link <?php echo _spk_is_active('userView.php'); ?>">
                        <?php echo spk_icon('user'); ?>
                        <span>Pengguna</span>
                    </a>
                    <a href="../login/adminLogout.php" class="spk-nav-link logout">
                        <?php echo spk_icon('logout'); ?>
                        <span>Keluar</span>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</div>