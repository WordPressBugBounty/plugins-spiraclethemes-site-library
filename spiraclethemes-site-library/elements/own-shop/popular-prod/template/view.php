<?php
// phpcs:disable WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
if ( ! defined( 'ABSPATH' ) ) exit;

$settings = $this->get_settings();
$id = $this->get_id();

$prod_count = absint($settings['prod_count'] ?? 8);
$prod_columns_count = absint($settings['prod_columns_count'] ?? 4);

$out = '[popularprod'
    . ' prod_columns_count="' . $prod_columns_count . '"'
    . ' prod_count="' . $prod_count . '"]';

echo wp_kses_post( shortcode_unautop( do_shortcode( $out ) ) );

?>
