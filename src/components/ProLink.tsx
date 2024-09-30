import { __ } from '@wordpress/i18n';

export default function ProLink() {
	return (
		<a
			href={ __(
				'https://www.aarstein.media/en/am-lottieplayer/pro',
				'am-lottieplayer'
			) }
			rel="noreferrer"
			target="_blank"
		>
			{ __(
				'Read about additional features in AM LottiePlayer PRO',
				'am-lottieplayer'
			) }
			<sup
				style={ {
					verticalAlign: 'super',
				} }
			>
				<span
					className="dashicons dashicons-external"
					style={ {
						fontSize: '1em',
					} }
				/>
			</sup>
		</a>
	);
}
