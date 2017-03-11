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
                    <th><label for="start"><?php _e('Show when', 'kiku'); ?></label></th>
                    <td>
                        <select name="start" id="start">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <?php
                            echo '<option value="' . $i . '"';
                            if ($i == $this->options['start']) {
                                echo ' selected="selected"';
                            }
                            echo '>' . $i . '</option>' . PHP_EOL;
                        ?>
                        <?php endfor; ?>
                        </select>
                        <?php _e('or more headings are present', 'kiku'); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php _e('Auto insert for the following content types', 'kiku'); ?></th>
                    <td>
                    <?php foreach (get_post_types() as $post_type): ?>
                    <?php
                        if (!in_array($post_type, $this->exclude_post_types)) {
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
                <tr>
                    <th><label for="show_heirarchy"><?php _e('Show hierarchy', 'kiku'); ?></label></th>
                    <td><input type="checkbox" value="1" id="show_heirarchy" name="show_heirarchy"<?php if ($this->options['show_heirarchy']) echo ' checked="checked"'; ?> /></td>
                </tr>
                <tr>
                    <th><label for="ordered_list"><?php _e('Show List Number', 'kiku'); ?></label></th>
                    <td><input type="checkbox" value="1" id="ordered_list" name="ordered_list"<?php if ($this->options['ordered_list']) echo ' checked="checked"'; ?> /></td>
                </tr>
                <tr>
                    <th><?php _e('Heading levels', 'kiku'); ?></th>
                    <td>
                        <p><?php _e('Include the following heading levels. Deselecting a heading will exclude it.', 'kiku'); ?></p>
                        <ul>
                        <?php for ($i = 1; $i <= 6; $i++): ?>
                        <?php
                            echo "<ul>";
                            echo '<input type="checkbox" value="' . $i . '" id="heading_levels' . $i . '" name="heading_levels[]"';
                            if (in_array($i, $this->options['heading_levels'])) {
                                echo ' checked="checked"';
                            }
                            echo ' /><label for="heading_levels' . $i . '"> ' . __('heading ') . $i . ' - &lt;h' . $i . '&gt;</label>';
                            echo "</ul>";
                        ?>
                        <?php endfor; ?>
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th><label for="exclude"><?php _e('Exclude headings', 'kiku'); ?></label></th>
                    <td>
                        <input type="text" class="regular-text" value="<?= esc_html($this->options['exclude'], ENT_COMPAT, 'UTF-8'); ?>" id="exclude" name="exclude" style="width: 100%;" /><br>
                        <label for="exclude">
                            <ul>
                                <li><?php _e('<code>Fruit*</code> ignore headings starting with "Fruit"', 'kiku'); ?></li>
                                <li><?php _e('<code>*Fruit Diet*</code> ignore headings with "Fruit Diet" somewhere in the heading', 'kiku'); ?></li>
                                <li><?php _e('<code>Apple Tree|Oranges|Yellow Bananas</code> ignore headings that are exactly "Apple Tree", "Oranges" or "Yellow Bananas"', 'kiku'); ?></li>
                            </ul>
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="submit">
            <input type="submit" name="submit" class="button-primary" value="<?php _e('Update Options', 'kiku'); ?>" />
        </div>
    </form>
</div>
