<div class='wrap'>
    <h2><?php _e('Setting', 'kiku'); ?></h2>
    <?php
        $this->message = '';
        if (isset($_GET['update'])) {
            $result = $this->save_admin_options();
            if ($result === true) {
                $this->message = '<div id="message" class="updated fade"><p>' . __('Options saved.', 'kiku') . '</p></div>';
            } else if ($result === false) {
                $this->message = '<div id="message" class="error fade"><p>' . __('Save failed.', 'kiku') . '</p></div>';
            }
        }
        echo $this->message;
    ?>
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
