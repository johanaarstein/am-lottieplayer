import { InspectorAdvancedControls } from '@wordpress/block-editor';
import { SelectControl, TextareaControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import type { BlockEditProps } from 'wordpress__blocks';
import type { PlayerComponentProps } from '@types';
import type { RendererType } from 'lottie-web';

const Advanced = ( {
	attributes,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) => {
	const { alt, renderer = 'svg' } = attributes;

	return (
		<InspectorAdvancedControls>
			<SelectControl
				label={
					<>
						{ __( 'Renderer' ) }{ ' ' }
						<span
							style={ {
								fontWeight: 'bold',
								color: 'white',
								backgroundColor: 'var(--wp-admin-theme-color)',
								display: 'inline-block',
								padding: '.5em 1em',
								borderRadius: '1.5em',
							} }
						>
							{ __( 'PRO feature', 'am-lottieplayer' ) }
						</span>
					</>
				}
				help={
					<a
						href="https://www.aarstein.media/en/am-lottieplayer/pro"
						target="_blank"
						rel="noreferrer"
					>
						{ __(
							'Read more about additional features in AM LottiePlayer PRO',
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
				}
				disabled
				value={ renderer }
				onChange={ ( val ) =>
					setAttributes( { renderer: val as RendererType } )
				}
				options={ [
					{ value: 'svg', label: 'SVG' },
					{ value: 'canvas', label: 'Canvas' },
				] }
			/>
			<TextareaControl
				label={ __( 'Description', 'am-lottieplayer' ) }
				help={ __(
					'Describe the animation. This is helpful for screen readers and search engines.',
					'am-lottieplayer'
				) }
				value={ alt as string }
				onChange={ ( value ) => setAttributes( { alt: value } ) }
			/>
		</InspectorAdvancedControls>
	);
};

export default Advanced;
