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
                        <input type="text" name="kiku_twitter" class="regular-text" value="<?php echo get_option('kiku_twitter'); ?>" id="kiku_twitter" />
                    </td>
                </tr>
                <tr>
                    <th><label for="kiku_appid"><?php _e('app_id', 'kiku'); ?></label></th>
                    <td>
                        <input type="text" name="kiku_appid" class="regular-text" value="<?php echo get_option('kiku_appid'); ?>" id="kiku_appid" />
                    </td>
                </tr>
                <tr>
                    <th><label><?php _e('Amazon Product Advertising API', 'kiku'); ?></label></th>
                    <td>
                        <label><input type="text" name="kiku_amazon_api_key" class="regular-text" value="<?php echo get_option('kiku_amazon_api_key'); ?>" placeholder="access key id" /></label>
                        <label><input type="text" name="kiku_amazon_secret_key" class="regular-text" value="<?php echo get_option('kiku_amazon_secret_key'); ?>" placeholder="secret access key" /></label>
                        <label><input type="text" name="kiku_amazon_associate_tag" class="regular-text" value="<?php echo get_option('kiku_amazon_associate_tag'); ?>" placeholder="associate tag" /></label>
                    </td>
                </tr>
                <tr>
                    <th><label for="kiku_author_page"><?php _e('author page', 'kiku'); ?></label></th>
                    <td>
                        <select id="kiku_appid" name="kiku_author_page">
                        <?php
                            $pages = get_pages();
                            $kiku_page = get_option('kiku_author_page');
                        foreach ($pages as $page) {
                            $link = get_page_link($page->ID);
                            $selected = ($kiku_page == $link) ? 'selected' : '';
                            $option = '<option value="'. $link .'" '. $selected .'>';
                            $option .= $page->post_title;
                            $option .= '</option>';
                            echo $option;
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Share Button', 'kiku'); ?></th>
                    <td>
                        <label for="kiku_share_btn_twitter">
                            <input name="kiku_share_btn_twitter" id="kiku_share_btn_twitter" value="1" <?php echo ( get_option('kiku_share_btn_twitter') ) ? 'checked="checked"' : ''; ?> type="checkbox">
                            <?php _e('Twitter', 'kiku'); ?><br>
                        </label>
                        <label for="kiku_share_btn_facebook">
                            <input name="kiku_share_btn_facebook" id="kiku_share_btn_facebook" value="1" <?php echo ( get_option('kiku_share_btn_facebook') ) ? 'checked="checked"' : ''; ?> type="checkbox">
                            <?php _e('Facebook', 'kiku'); ?><br>
                        </label>
                        <label for="kiku_share_btn_hatena">
                            <input name="kiku_share_btn_hatena" id="kiku_share_btn_hatena" value="1" <?php echo ( get_option('kiku_share_btn_hatena') ) ? 'checked="checked"' : ''; ?> type="checkbox">
                            <?php _e('Hatena', 'kiku'); ?><br>
                        </label>
                        <label for="kiku_share_btn_line">
                            <input name="kiku_share_btn_line" id="kiku_share_btn_line" value="1" <?php echo ( get_option('kiku_share_btn_line') ) ? 'checked="checked"' : ''; ?> type="checkbox">
                            <?php _e('LINE', 'kiku'); ?><br>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th rowspan="4"><?php _e('Insert data', 'kiku'); ?></th>
                    <td>
                        <label>
                            <p><?php _e('Insert to <code>&lt;head&gt;</code> tag', 'kiku'); ?></p>
                            <textarea name="kiku_insert_data_head" rows="4" wrap="off" class="large-text"><?php echo get_option('kiku_insert_data_head'); ?></textarea>
                        </label>
                    </td>
                <tr>
                    <td>
                        <?php foreach (get_post_types() as $post_type) : ?>
                        <?php
                        if (in_array($post_type, ['post', 'page'])) {
                            echo '<label for="kiku_insert_data_bottom_of_more_tag_post_types_' . $post_type . '"> ';
                            echo '<input type="checkbox" value="' . $post_type . '" id="kiku_insert_data_bottom_of_more_tag_post_types_' . $post_type . '" name="kiku_insert_data_bottom_of_more_tag_post_types[]"';
                            if ( !empty(get_option('kiku_insert_data_bottom_of_more_tag_post_types')) ) {
                                if ( in_array($post_type, get_option('kiku_insert_data_bottom_of_more_tag_post_types')) ) {
                                    echo ' checked="checked"';
                                }
                            }
                            echo ' />' . $post_type . '</label>';
                        }
                        ?>
                        <?php endforeach; ?>
                        <label>
                            <p>
                                <?php _e('Insert to the bottom of <code>&lt;!--more--&gt;</code>', 'kiku'); ?><br>
                                <code><?php _e('Element code', 'kiku'); ?></code>
                            </p>
                            <textarea name="kiku_insert_data_bottom_of_more_tag" rows="4" wrap="off" class="large-text"><?php echo get_option('kiku_insert_data_bottom_of_more_tag'); ?></textarea>
                            <label>
                                <input name="kiku_insert_data_bottom_of_more_tag_option" value="1" <?php echo ( get_option('kiku_insert_data_bottom_of_more_tag_option') ) ? 'checked="checked"' : ''; ?> type="checkbox">
                                <?php _e('If the <code>&lt;!--more--&gt;</code> does not exist, to insert the data at the top of the post/page.', 'kiku'); ?><br>
                            </label>
                        </label>
                    </td>
                </tr>
                </tr>
                <tr>
                    <td>
                        <?php foreach (get_post_types() as $post_type) : ?>
                        <?php
                        if (in_array($post_type, ['post', 'page'])) {
                            echo '<label for="kiku_insert_data_bottom_of_content_post_types_' . $post_type . '"> ';
                            echo '<input type="checkbox" value="' . $post_type . '" id="kiku_insert_data_bottom_of_content_post_types_' . $post_type . '" name="kiku_insert_data_bottom_of_content_post_types[]"';
                            if ( !empty(get_option('kiku_insert_data_bottom_of_content_post_types')) ) {
                                if ( in_array($post_type, get_option('kiku_insert_data_bottom_of_content_post_types')) ) {
                                    echo ' checked="checked"';
                                }
                            }
                            echo ' />' . $post_type . '</label>';
                        }
                        ?>
                        <?php endforeach; ?>
                        <label>
                            <p>
                                <?php _e('Insert to the bottom of content', 'kiku'); ?><br>
                                <code><?php _e('Element code', 'kiku'); ?></code>
                            </p>
                            <textarea name="kiku_insert_data_bottom_of_content" rows="4" wrap="off" class="large-text"><?php echo get_option('kiku_insert_data_bottom_of_content'); ?></textarea>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>
                            <p>
                                <?php _e('Insert to the top of pagination (home)', 'kiku'); ?><br>
                                <code><?php _e('Element code', 'kiku'); ?></code>
                            </p>
                            <textarea name="kiku_insert_data_home" rows="4" wrap="off" class="large-text"><?php echo get_option('kiku_insert_data_home'); ?></textarea>
                        </label>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Filter in Front Page', 'kiku'); ?></th>
                    <td>
                        <label>
                            <p><?php _e('Comma-separated list of category IDs', 'kiku'); ?></p>
                            <input type="text" name="kiku_exclude_category_frontpage" class="regular-text" value="<?php echo get_option('kiku_exclude_category_frontpage'); ?>" id="kiku_exclude_category_frontpage" />
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
