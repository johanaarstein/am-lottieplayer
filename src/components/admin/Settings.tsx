import { useEffect, useState } from '@wordpress/element';
import { __, sprintf } from '@wordpress/i18n';

import BoomerangLottie from '@components/BoomerangLottie';
import Upload from './Upload';

import type { NoticeProps } from '@types';

export default function Settings() {
	const [ activeTab, setActiveTab ] = useState( 1 ),
		[ notice, setNotice ] = useState< NoticeProps >( {
			show: false,
			status: 'success',
			message: __( 'AM LottiePlayer', 'am-lottieplayer' ),
		} ),
		{ pluginUrl } = amPhpVars;

	useEffect( () => {
		if ( notice.show ) {
			setTimeout( () => {
				document
					.querySelector( '.am-main-notice-element' )
					?.scrollIntoView( {
						behavior: 'smooth',
						block: 'center',
					} );
			}, 100 );
			if ( notice.status === 'success' ) {
				setTimeout( () => {
					setNotice( ( prev ) => ( {
						...prev,
						show: false,
					} ) );
				}, 6000 );
			}
		}
	}, [ notice.show, notice.status ] );

	return (
		<section className="am-settings">
			<header className="am-header">
				<BoomerangLottie
					autoplay
					src={ `${ pluginUrl }assets/banner_top.lottie` }
				/>
			</header>
			<main>
				<div className="content">
					<p>
						{ __(
							"We love cool looking, fast loading web sites, and we're glad you do to.",
							'am-lottieplayer'
						) }
					</p>
					<p
						dangerouslySetInnerHTML={ {
							__html: sprintf(
								// translators: %s: href
								__(
									'For documentation and inspiration, visit <a href="%s" target="_blank" rel="noreferrer">this plugins\'s homepage</a>. Feel free to <a href="mailto:johan@aarstein.media" target="_blank" rel="noreferrer">contact us</a> if you have any feature requests or other feedback. Have fun designing!',
									'am-lottieplayer'
								),
								'https://www.aarstein.media/en/am-lottieplayer'
							),
						} }
					/>
				</div>
				<div className="block-tabs">
					<button
						onClick={ () => setActiveTab( 1 ) }
						data-active={ activeTab === 1 }
						className="block-tab"
					>
						<span className="dashicons dashicons-admin-generic" />{ ' ' }
						{ __( 'Combine Animations', 'am-lottieplayer' ) }
					</button>
					<button
						onClick={ () => setActiveTab( 2 ) }
						data-active={ activeTab === 2 }
						className="block-tab"
					>
						<span className="dashicons dashicons-update" />{ ' ' }
						{ __(
							'Convert to JSON to dotLottie',
							'am-lottieplayer'
						) }
					</button>
					<button
						onClick={ () => setActiveTab( 3 ) }
						data-active={ activeTab === 3 }
						className="block-tab"
					>
						<span className="dashicons dashicons-admin-settings" />{ ' ' }
						{ __( 'Settings', 'am-lottieplayer' ) }
					</button>
				</div>
				<div className="content-tabs">
					<div
						className="content-tab"
						data-active={ activeTab === 1 }
					>
						<div className="content">
							<p>
								{ __(
									'Combine two or more Lottie animations in a single dotLottie file. This is useful if you want to differentiate animations on descrete user interactions, or if you want the end user to be able to easily toggle between animations.',
									'am-lottieplayer'
								) }
							</p>
						</div>
						<Upload
							instructions={ __(
								'Choose animations to combine',
								'am-lottieplayer'
							) }
							multiple
							type={ [ 'application/zip', 'application/json' ] }
							context="combine"
							setNotice={ setNotice }
						/>
					</div>
					<div
						className="content-tab"
						data-active={ activeTab === 2 }
					>
						<div className="content">
							<p>
								{ __(
									"If you have a JSON Lottie animation, there are advantages to converting it into a dotLottie. First there's the compression, making the animation lighter and faster to load. Then there's the practicallity of having a descrete file extension. Last there's the possibility to combine several Lottie animations in a single file.",
									'am-lottieplayer'
								) }
							</p>
						</div>

						<Upload
							instructions={ __(
								'Choose JSON Lotties to convert to dotLottie',
								'am-lottieplayer'
							) }
							type={ [ 'application/json' ] }
							context="convert"
							multiple
							setNotice={ setNotice }
						/>
					</div>
					<div
						className="content-tab"
						data-active={ activeTab === 3 }
					>
						<div className="content">
							<h2>
								<span className="dashicons dashicons-admin-network" />{ ' ' }
								{ __( 'License', 'am-lottieplayer' ) }
							</h2>
							<p
								dangerouslySetInnerHTML={ {
									__html: sprintf(
										// translators: %s: href
										__(
											'To unlock updates, please enter your license key below. If you don\'t have a licence key, please see <a href="%s" target="_blank" rel="noreferrer">details & pricing</a>.',
											'am-lottieplayer'
										),
										'https://www.aarstein.media/en/am-lottieplayer/pro'
									),
								} }
							/>
						</div>
						{ /* <License setNotice={ setNotice } /> */ }
						<hr
							style={ {
								margin: '1.3em 0',
								width: '100%',
								border: '0',
								display: 'block',
							} }
						/>
						<h2>
							<span className="dashicons dashicons-admin-generic" />{ ' ' }
							{ __(
								'Auto-optimize script on front-end',
								'am-lottieplayer'
							) }
						</h2>
						<p>
							{ __(
								'When enabled AM LottiePlayer Pro will automatically decide whether to load light or full version of front-end script, based on your animation settings. If you disable this, the full version will always be loaded. If you experience any problems with the animation on the front-end, it might help to disable this setting.',
								'am-lottieplayer'
							) }
						</p>
						{ /* <AutoOptimize /> */ }
					</div>
				</div>
			</main>
		</section>
	);
}
