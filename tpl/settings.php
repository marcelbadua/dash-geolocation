<div class="wrap">
    <h2>Dash Gelocation</h2>
    <form method="post" action="options.php">
        <?php @settings_fields('dash_geolocation_settings-group'); ?>
        <?php @do_settings_fields('dash_geolocation_settings-group'); ?>
        <?php do_settings_sections('dash_geolocation_settings'); ?>
        <?php @submit_button(); ?>
    </form>
</div>
