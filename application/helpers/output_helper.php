<?php
class OutputHelper{
  
  public static function commonProductMenu($type = 1){
    $ci = &get_instance();
    $ci->load->model('product');
    $conditionArray = array(
        'categoryId' => $type,
        'parentId'   => 0
    );
    $products = ProductItem::factory()->getMultipleByMultipleFields($conditionArray);
    foreach ($products as $product){
      echo('<li><a href="'.base_url().'products/' . $product->alias . '">' . $product->name . '</a></li>');
    }
  }
  
}
?>