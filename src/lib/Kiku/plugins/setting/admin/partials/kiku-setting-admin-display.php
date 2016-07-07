<div class='wrap'>
    <h2><?php _e('Setting', 'kiku'); ?></h2>
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php
            settings_fields( 'kiku-settings-group' );
            do_settings_sections( 'kiku-settings-group' );
        ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="kiku_twitter"><?php _e('Twitter ID', 'kiku'); ?></label></th>
                    <td>
                        <input type="text" name="kiku_twitter" class="regular-text" value="<?= get_option('kiku_twitter'); ?>" id="kiku_twitter" />
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
