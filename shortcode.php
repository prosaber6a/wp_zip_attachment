<?php
require_once plugin_dir_path(__FILE__) . '/class/HZip.php';


function prozip_product_meta()
{
    $product_id = intval($_POST['product_id']);

    $data = get_field('tech_spaces', $product_id);
    wp_send_json_success($data, 200);
    // echo $product_id;
    wp_die();
}

add_action('wp_ajax_nopriv_prozip_get_product_meta', 'prozip_product_meta');
add_action('wp_ajax_prozip_get_product_meta', 'prozip_product_meta');


function prozip_product_zip()
{
    $fileIds = $_POST['fileIds'];
    $files = [];
    for ($i = 0; $i < count($fileIds); $i++) {
        $files[] = get_attached_file(intval($fileIds[$i]));
    }

    $pro_file_name = 'file' . time();
    $pro_folder_path = plugin_dir_path(__FILE__) . '/zip/' . $pro_file_name;
    if (mkdir($pro_folder_path)) {
        for ($i = 0; $i < count($files); $i++) {
            $srcPathInfo = pathinfo($files[$i]);
            copy($files[$i], $pro_folder_path.'/'.$srcPathInfo['basename']);
        }
    }

    $pro_zip_path = plugin_dir_path(__FILE__) . '/zip/' . $pro_file_name . '.zip';
    HZip::zipDir($pro_folder_path, $pro_zip_path);
    if (is_dir($pro_folder_path)) {
        rmdir($pro_folder_path);
    }
    wp_send_json_success(plugin_dir_url(__FILE__) . '/zip/' . $pro_file_name . '.zip', 200);
    exit();
}

add_action('wp_ajax_nopriv_prozip_pdf_zip', 'prozip_product_zip');
add_action('wp_ajax_prozip_pdf_zip', 'prozip_product_zip');


add_shortcode('zip_product', 'prdzip_product_show');
function prdzip_product_show($atts)
{

    $products = get_posts([
        'post_type'        => 'pro_zip_product',
        'posts_per_page' => -1
    ]);
  
    $select_options = "";
    foreach ($products as $product) {
        $select_options .= "<option value=\"$product->ID\">" . $product->post_title . "</option>";
    }
    

    $html = <<<EOD
    <div class="pro_zip_container">
        <div>
            <h2>Select Your Product</h2>
            <select id="prozip_product_select" class="pro_zip_select_box">
                <option value=""></option>
                $select_options
            </select>
        </div>
        <h3 class="" id="prozip_product_name"></h3>
        <div class="" id="prozip_ajax_response">
            <div class="">

            </div>
        </div>
        <div class="">
            <button class="btn pro_zip_btn" id="prozip_generate_pdf">Generate PDF</button>
        </div>
    </div>
EOD;

    
    return $html;
}
