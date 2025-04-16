<?php
if (!defined('WPINC')) {
    die;
}

// Handle form submissions
if (isset($_POST['codewpx_ail_add_keyword'])) {
    // Nonce verification
    check_admin_referer('codewpx_ail_add_keyword_action', 'codewpx_ail_add_keyword_nonce');

    $keyword = sanitize_text_field($_POST['codewpx_ail_keyword']);
    $url = esc_url_raw($_POST['codewpx_ail_url']);

    if (!empty($keyword) && !empty($url)) {
        $keywords = get_option('codewpx_ail_keywords', array());
        $keywords[$keyword] = $url;
        update_option('codewpx_ail_keywords', $keywords);
        echo '<div class="notice notice-success"><p>Keyword added successfully!</p></div>';
    }
}

if (isset($_POST['codewpx_ail_delete_keyword'])) {
    check_admin_referer('codewpx_ail_delete_keyword_action', 'codewpx_ail_delete_keyword_nonce');

    $keyword_to_delete = sanitize_text_field($_POST['codewpx_ail_keyword_to_delete']);

    if (!empty($keyword_to_delete)) {
        $keywords = get_option('codewpx_ail_keywords', array());
        if (isset($keywords[$keyword_to_delete])) {
            unset($keywords[$keyword_to_delete]);
            update_option('codewpx_ail_keywords', $keywords);
            echo '<div class="notice notice-success"><p>Keyword deleted successfully!</p></div>';
        }
    }
}

if (isset($_POST['codewpx_ail_edit_keyword'])) {
    check_admin_referer('codewpx_ail_edit_keyword_action', 'codewpx_ail_edit_keyword_nonce');

    $old_keyword = sanitize_text_field($_POST['codewpx_ail_old_keyword']);
    $new_keyword = sanitize_text_field($_POST['codewpx_ail_new_keyword']);
    $new_url = esc_url_raw($_POST['codewpx_ail_new_url']);

    if (!empty($old_keyword) && !empty($new_keyword) && !empty($new_url)) {
        $keywords = get_option('codewpx_ail_keywords', array());
        if (isset($keywords[$old_keyword])) {
            unset($keywords[$old_keyword]);
            $keywords[$new_keyword] = $new_url;
            update_option('codewpx_ail_keywords', $keywords);
            echo '<div class="notice notice-success"><p>Keyword updated successfully!</p></div>';
        }
    }
}

$keywords = get_option('codewpx_ail_keywords', array());
?>

<div class="wrap codewpx-ail-admin">
    <h1>Auto Internal Linking Settings</h1>

    <!-- Add New Keyword Form -->
    <div class="codewpx-ail-section">
        <h2>Add New Keyword</h2>
        <form method="post">
            <?php wp_nonce_field('codewpx_ail_add_keyword_action', 'codewpx_ail_add_keyword_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="codewpx_ail_keyword">Keyword</label></th>
                    <td>
                        <input type="text" id="codewpx_ail_keyword" name="codewpx_ail_keyword" class="regular-text" required>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="codewpx_ail_url">Target URL</label></th>
                    <td>
                        <input type="url" id="codewpx_ail_url" name="codewpx_ail_url" class="regular-text" required>
                    </td>
                </tr>
            </table>
            <?php submit_button('Add Keyword', 'primary', 'codewpx_ail_add_keyword'); ?>
        </form>
    </div>

    <!-- Edit Keyword Form -->
    <div class="codewpx-ail-section">
        <h2>Edit Keyword</h2>
        <form method="post">
            <?php wp_nonce_field('codewpx_ail_edit_keyword_action', 'codewpx_ail_edit_keyword_nonce'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="codewpx_ail_old_keyword">Select Keyword to Edit</label></th>
                    <td>
                        <select id="codewpx_ail_old_keyword" name="codewpx_ail_old_keyword" class="regular-text" required>
                            <option value="">-- Select Keyword --</option>
                            <?php foreach ($keywords as $keyword => $url): ?>
                                <option value="<?php echo esc_attr($keyword); ?>"><?php echo esc_html($keyword); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="codewpx_ail_new_keyword">New Keyword</label></th>
                    <td>
                        <input type="text" id="codewpx_ail_new_keyword" name="codewpx_ail_new_keyword" class="regular-text" required>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="codewpx_ail_new_url">New Target URL</label></th>
                    <td>
                        <input type="url" id="codewpx_ail_new_url" name="codewpx_ail_new_url" class="regular-text" required>
                    </td>
                </tr>
            </table>
            <?php submit_button('Update Keyword', 'primary', 'codewpx_ail_edit_keyword'); ?>
        </form>
    </div>

    <!-- Keywords List Table -->
    <div class="codewpx-ail-section">
        <h2>Current Keywords</h2>
        <?php if (empty($keywords)): ?>
            <p>No keywords added yet.</p>
        <?php else: ?>
            <div style="text-align: right; margin-bottom: 10px;">
                <input type="text" id="keywordSearchInput" placeholder="Search keywords..." style="padding: 5px; max-width: 400px; width: 100%;">
            </div>

            <table class="wp-list-table widefat striped" id="keywordsTable">
                <thead>
                    <tr>
                        <th>Keyword</th>
                        <th>Target URL</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($keywords as $keyword => $url): ?>
                        <tr>
                            <td><?php echo esc_html($keyword); ?></td>
                            <td><a href="<?php echo esc_url($url); ?>" target="_blank"><?php echo esc_url($url); ?></a></td>
                            <td>
                                <form method="post" style="display:inline;">
                                    <?php wp_nonce_field('codewpx_ail_delete_keyword_action', 'codewpx_ail_delete_keyword_nonce'); ?>
                                    <input type="hidden" name="codewpx_ail_keyword_to_delete" value="<?php echo esc_attr($keyword); ?>">
                                    <?php submit_button('Delete', 'delete', 'codewpx_ail_delete_keyword', false, array(
                                        'onclick' => 'return confirm("Are you sure you want to delete this keyword?");'
                                    )); ?>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <script>
                document.getElementById('keywordSearchInput').addEventListener('keyup', function() {
                    var filter = this.value.toLowerCase();
                    var rows = document.querySelectorAll('#keywordsTable tbody tr');
                    rows.forEach(function(row) {
                        var keyword = row.cells[0].textContent.toLowerCase();
                        if (keyword.indexOf(filter) > -1) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            </script>
        <?php endif; ?>
    </div>
</div>

<style>
    .codewpx-ail-admin .codewpx-ail-section {
        margin-bottom: 30px;
        padding: 20px;
        background: #fff;
        border: 1px solid #ccd0d4;
        box-shadow: 0 1px 1px rgba(0,0,0,0.04);
    }
    .codewpx-ail-admin .form-table th {
        width: 200px;
    }
    #keywordsTable thead th {
        font-weight: bold;
    }
</style>
