<?php
// Usage: [qs-featured-products-block]
function get_qs_fp_block()
{
    $slide_no = 0;
    $o = '
        <div id="fp_slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
    ';

    foreach (get_qs_fp_products() as $product) {
        $is_active = ($slide_no === 0) ?  "active" : "";
        $o .= '<div class="carousel-item '.$is_active.'">';
        $o .= '     <div class="fp_left">';
        $o .= '         <a href="'.$product->get_permalink().'" class="fp_link">';
        $o .=  '            <img class="d-block w-100" src="'.wp_get_attachment_image_url($product->get_image_id(), 'full').'" alt="First slide">';
        $o .= '         </a>';
        $o .= '     </div>';
        $o .= '     <div class="fp_right color'.rand(1, 3).'">';
        $o .=  '        <h2>'.$product->get_title().'</h2>';
        $o .=  '        <p>'.$product->get_short_description().'</p>';
        $o .= '     </div>';
        $o .= '</div>';
        $slide_no++;
    }

    $o .= ' 
            </div>
            <!-- controls -->
            <a class="carousel-control-prev" href="#fp_slider" role="button" data-slide="prev">
                <span class="et-pb-icon">&#x23;</span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#fp_slider" role="button" data-slide="next">
                <span class="et-pb-icon">&#x24;</span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    ';


    return $o;
}
add_shortcode('qs-featured-products-block', 'get_qs_fp_block');
