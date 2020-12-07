<?php
if ( ! isset( $args['title'] ) ) {
	$args['title'] = is_archive() ? get_the_archive_title() : get_the_title();
}
if ( ! isset( $args['subtitle'] ) ) {
	$args['subtitle'] = is_archive() ? get_the_archive_description() : get_field( 'page_banner_subtitle' );
}
if ( ! isset( $args['image_url'] ) ) {
	if ( get_field( 'page_banner_background_image' )['sizes']['pageBanner'] ?? false ) {
		$args['image_url'] = get_field( 'page_banner_background_image' )['sizes']['pageBanner'];
	} else {
		$args['image_url'] = get_theme_file_uri( '/images/ocean.jpg' );
	}
}
?>

<div class="page-banner">
	<div class="page-banner__bg-image" style="background-image: url(<?php echo esc_url_raw( $args['image_url'] ); ?>);"></div>
	<div class="page-banner__content container container--narrow">
		<h1 class="page-banner__title"><?php echo esc_html( $args['title'] ); ?></h1>
		<div class="page-banner__intro">
			<p><?php echo esc_html( $args['subtitle'] ); ?></p>
		</div>
	</div>
</div>
