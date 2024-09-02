import { __ } from '@wordpress/i18n';

import BoomerangLottie from '@components/BoomerangLottie';

export default function Widget() {
	const { pluginUrl } = amPhpVars;
	return (
		<div
			style={ {
				backgroundColor: '#22374a',
				color: '#FFF',
				overflow: 'hidden',
				padding: '1em 0',
			} }
		>
			<BoomerangLottie
				autoplay
				src={ `${ pluginUrl }assets/banner_top.lottie` }
			/>
			<div style={ { margin: '1em' } }>
				<p>
					<strong>
						{ __(
							'Thank you for using AM LottiePlayer!',
							'am-lottieplayer'
						) }
					</strong>
				</p>
				<p>
					{ __(
						"We're proud to announce that we've launched a premium version of this plugin with even more features – like combining & controlling animations in a single file, converting JSON to dotLottie and more.",
						'am-lottieplayer'
					) }
				</p>
				<a
					style={ {
						color: '#d98f56',
					} }
					href={ __(
						'https://www.aarstein.media/en/am-lottieplayer/pro',
						'am-lottieplayer'
					) }
					target="_blank"
					rel="noreferrer"
				>
					{ __(
						'Read more about AM LottiePlayer PRO here!',
						'am-lottieplayer'
					) }
				</a>
			</div>
		</div>
	);
}
