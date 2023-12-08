import { __ } from '@wordpress/i18n';
// import { injectStyle } from '@utils';

export default function ProFeature() {
	// const keyframesStyle = `
	//     @keyframes amPulse {
	//       0%{background-position:0% 50%}
	//       50%{background-position:100% 50%}
	//       100%{background-position:0% 50%}
	//     }
	//   `;

	// injectStyle( keyframesStyle );
	return (
		<>
			<a
				href={ __(
					'https://www.aarstein.media/en/am-lottieplayer/pro',
					'am-lottieplayer'
				) }
				target="_blank"
				rel="noreferrer"
				style={ {
					color: 'white',
					fontSize: '.75rem',
					// backgroundImage:
					// 	'linear-gradient(300deg, #24708f, #e18d4c, #85c6e0)',
					// backgroundSize: '300% 300%',
					// animation: 'amPulse 30s linear infinite',
					textDecoration: 'none',
					textTransform: 'none',
					backgroundColor: 'var(--wp-admin-theme-color)',
					display: 'inline-block',
					padding: '.5em 1em',
					borderRadius: '1.5em',
				} }
			>
				<strong>PRO</strong> { __( 'feature', 'am-lottieplayer' ) }
			</a>
		</>
	);
}
