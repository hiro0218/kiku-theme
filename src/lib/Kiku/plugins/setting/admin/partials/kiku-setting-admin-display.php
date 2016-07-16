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
                    <th><label for="kiku_appid"><?php _e('app_id', 'kiku'); ?></label></th>
                    <td>
                        <input type="text" name="kiku_appid" class="regular-text" value="<?= get_option('kiku_appid'); ?>" id="kiku_appid" />
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
                            <?php _e('Hatena', 'kiku'); ?><br>
                        </label>
                        <label for="kiku_share_btn_line">
                            <input name="kiku_share_btn_line" id="kiku_share_btn_line" value="1" <?= ( get_option('kiku_share_btn_line') ) ? 'checked="checked"' : ''; ?> type="checkbox">
                            <?php _e('LINE', 'kiku'); ?><br>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th rowspan="3"><?php _e('Insert data', 'kiku'); ?></th>
                    <td>
                        <label>
                            <p><?php _e('Insert to <code>&lt;head&gt;</code> tag', 'kiku'); ?></p>
                            <textarea name="kiku_insert_data_head" rows="4" wrap="off" class="large-text"><?= get_option('kiku_insert_data_head'); ?></textarea>
                        </label>
                    </td>
                <tr>
                    <td>
                        <label>
                            <p><?php _e('Insert to the bottom of <code>&lt;!--more--&gt;</code> (post/page)', 'kiku'); ?></p>
                            <textarea name="kiku_insert_data_bottom_of_more_tag" rows="4" wrap="off" class="large-text"><?= get_option('kiku_insert_data_bottom_of_more_tag'); ?></textarea>
                            <label>
                                <input name="kiku_insert_data_bottom_of_more_tag_option" value="1" <?= ( get_option('kiku_insert_data_bottom_of_more_tag_option') ) ? 'checked="checked"' : ''; ?> type="checkbox">
                                <?php _e('If the <code>&lt;!--more--&gt;</code> does not exist, to insert the data at the top of the post/page.', 'kiku'); ?><br>
                            </label>
                        </label>
                    </td>
                </tr>
                </tr>
                <tr>
                    <td>
                        <label>
                            <p><?php _e('Insert to the bottom of content (post/page)', 'kiku'); ?></p>
                            <textarea name="kiku_insert_data_bottom_of_content" rows="4" wrap="off" class="large-text"><?= get_option('kiku_insert_data_bottom_of_content'); ?></textarea>
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
