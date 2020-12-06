<div class="hero-slider">
	<div data-glide-el="track" class="glide__track">
		<div class="glide__slides">
			<?php foreach ( $args as $slide ) : ?>
				<div class="hero-slider__slide" style="background-image: url(<?php echo esc_url_raw( $slide['image'], null ); ?>);">
					<div class="hero-slider__interior container">
						<div class="hero-slider__overlay">
							<h2 class="headline headline--medium t-center"><?php echo esc_html( $slide['title'] ); ?></h2>
							<p class="t-center"><?php echo esc_html( $slide['description'] ); ?></p>
							<p class="t-center no-margin"><a href="<?php echo esc_url_raw( $args['link'], null ); ?>" class="btn btn--blue">Learn more</a></p>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<div class="slider__bullets glide__bullets" data-glide-el="controls[nav]"></div>
	</div>
</div>
