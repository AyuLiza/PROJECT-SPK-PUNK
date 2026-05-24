<?php
if (!function_exists('_spk_is_active')) {
    /**
     * Return active class when current request filename matches given name.
     * @param string $name
     * @return string
     */
    function _spk_is_active(string $name): string
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '';
        $current = basename($path);
        return $current === $name ? 'spk-nav-link-active' : '';
    }
}
?>
<?php include __DIR__ . '/icon.php'; ?>

<div class="spk-nav-wrapper">
    <div class="spk-card p-1 shadow-sm">
        <nav class="spk-nav" aria-label="Main navigation">
            <a href="../home/home.php" class="spk-nav-link <?php echo _spk_is_active('home.php'); ?>">
                <?php echo spk_icon('home'); ?>
                <span>Home</span>
            </a>
            <a href="../alternatif/alternatifView.php" class="spk-nav-link <?php echo _spk_is_active('alternatifView.php'); ?>">
                <?php echo spk_icon('box'); ?>
                <span>Alternatif</span>
            </a>
            <a href="../kriteria/kriteriaView.php" class="spk-nav-link <?php echo _spk_is_active('kriteriaView.php'); ?>">
                <?php echo spk_icon('chart'); ?>
                <span>Kriteria</span>
            </a>
            <a href="../subKriteria/subKriteriaView.php" class="spk-nav-link <?php echo _spk_is_active('subKriteriaView.php'); ?>">
                <?php echo spk_icon('bookmark'); ?>
                <span>Sub Kriteria</span>
            </a>
            <a href="../faktor/faktorView.php" class="spk-nav-link <?php echo _spk_is_active('faktorView.php'); ?>">
                <?php echo spk_icon('gear'); ?>
                <span>Faktor</span>
            </a>
            <a href="../ranking/ranking.php" class="spk-nav-link <?php echo _spk_is_active('ranking.php'); ?>">
                <?php echo spk_icon('trophy'); ?>
                <span>Ranking</span>
            </a>
            <a href="../login/userLogout.php" class="spk-nav-link logout">
                <?php echo spk_icon('logout'); ?>
                <span>Keluar</span>
            </a>
        </nav>
    </div>
</div>