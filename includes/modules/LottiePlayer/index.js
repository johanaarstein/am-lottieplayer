const ETBuilderModuleLottiePlayer = ( {
	alt = '',
	autoplay = true,
	controls = true,
	// direction = 1,
	// height = null,
	loop = true,
	// mode = 'normal',
	// objectFit = 'cover',
	// renderer = 'svg',
	// speed = 1,
	src = '',
	// width = null,
} = {} ) => {
	return (
		<dotlottie-player
			alt={ alt }
			autoplay={ autoplay }
			controls={ controls }
			loop={ loop }
			src={ src }
		/>
	);
};

ETBuilderModuleLottiePlayer.slug = 'et_pb_lottieplayer';

export default ETBuilderModuleLottiePlayer;
