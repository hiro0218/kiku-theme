<div class='wrap'>
    <h2><?php _e('Mokuji', 'kiku'); ?></h2>
    <?php
        $message = '';
        if (isset($_GET['update'])) {
            $result = $this->save_admin_options();
            if ($result === true) {
                $message = '<div id="message" class="updated fade"><p>' . __('Options saved.', 'kiku') . '</p></div>';
            } else if ($result === false) {
                $message = '<div id="message" class="error fade"><p>' . __('Save failed.', 'kiku') . '</p></div>';
            }
        }
        echo $message;
    ?>
    <form method="post" action="<?= esc_html('?page=' . $_GET['page'] . '&update'); ?>">
        <?php wp_nonce_field(plugin_basename(__FILE__), 'mokuji-admin-options'); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label for="position"><?php _e('Position', 'kiku'); ?></label></th>
                    <td>
                        <select name="position" id="position">
                            <option value="<?= MKJ_POSITION_BEFORE_FIRST_HEADING; ?>"<?php if (MKJ_POSITION_BEFORE_FIRST_HEADING == $this->options['position']) echo ' selected="selected"'; ?>><?php _e('Before first heading (default)', 'kiku'); ?></option>
                            <option value="<?= MKJ_POSITION_AFTER_FIRST_HEADING; ?>"<?php if (MKJ_POSITION_AFTER_FIRST_HEADING == $this->options['position']) echo ' selected="selected"'; ?>><?php _e('After first heading', 'kiku'); ?></option>
                            <option value="<?= MKJ_POSITION_CONTENTS_TOP; ?>"<?php if (MKJ_POSITION_CONTENTS_TOP == $this->options['position']) echo ' selected="selected"'; ?>><?php _e('Top', 'kiku'); ?></option>
                            <option value="<?= MKJ_POSITION_CONTENTS_BOTTOM; ?>"<?php if (MKJ_POSITION_CONTENTS_BOTTOM == $this->options['position']) echo ' selected="selected"'; ?>><?php _e('Bottom', 'kiku'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Auto insert for the following content types', 'kiku'); ?></th>
                    <td>
                    <?php foreach (get_post_types() as $post_type): ?>
                    <?php
                        if (in_array($post_type, ['post', 'page'])) {
                            echo '<input type="checkbox" value="' . $post_type . '" id="auto_insert_post_types_' . $post_type . '" name="auto_insert_post_types[]"';
                            if (in_array($post_type, $this->options['auto_insert_post_types'])) {
                                echo ' checked="checked"';
                            }
                            echo ' /><label for="auto_insert_post_types_' . $post_type . '"> ' . $post_type . '</label><br>';
                        }
                    ?>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <th><label for="show_heading_text"><?php _e('Heading text', 'kiku'); ?></label></th>
                    <td>
                        <div class="more_mokuji_options<?php if (!$this->options['show_heading_text']) echo ' disabled'; ?>">
                            <input type="text" class="regular-text" value="<?= esc_html($this->options['heading_text'], ENT_COMPAT, 'UTF-8'); ?>" id="show_heading_text" name="heading_text" />
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="submit">
            <input type="submit" name="submit" class="button-primary" value="<?php _e('Update Options', 'kiku'); ?>" />
        </div>
    </form>
</div>
