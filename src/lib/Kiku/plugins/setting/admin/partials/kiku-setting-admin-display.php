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
                <tr>
                    <th><?php _e('Share Button', 'kiku'); ?></th>
                    <td>
                        <label for="kiku_share_btn_twitter">
                            <input name="kiku_share_btn_twitter" id="kiku_share_btn_twitter" value="1" <?= ( get_option('kiku_share_btn_twitter') ) ? 'checked="checked"' : ''; ?> type="checkbox">
                            <?php _e('Twitter', 'kiku'); ?><br>
                        </label>
                        <label for="kiku_share_btn_facebook">
                            <input name="kiku_share_btn_facebook" id="kiku_share_btn_facebook" value="1" <?= ( get_option('kiku_share_btn_facebook') ) ? 'checked="checked"' : ''; ?> type="checkbox">
                            <?php _e('Facebook', 'kiku'); ?><br>
                        </label>
                        <label for="kiku_share_btn_hatena">
                            <input name="kiku_share_btn_hatena" id="kiku_share_btn_hatena" value="1" <?= ( get_option('kiku_share_btn_hatena') ) ? 'checked="checked"' : ''; ?> type="checkbox">
                            <?php _e('hatena', 'kiku'); ?><br>
                        </label>
                        <label for="kiku_share_btn_line">
                            <input name="kiku_share_btn_line" id="kiku_share_btn_line" value="1" <?= ( get_option('kiku_share_btn_line') ) ? 'checked="checked"' : ''; ?> type="checkbox">
                            <?php _e('Line', 'kiku'); ?><br>
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
