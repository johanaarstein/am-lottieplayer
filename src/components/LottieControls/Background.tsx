import { ColorPicker, Panel, PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

import type { BlockEditProps } from 'wordpress__blocks';
import type { PlayerComponentProps } from '@types';

const Background = ( {
	attributes,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) => {
	const { background } = attributes;

	return (
		<Panel>
			<PanelBody
				title={ __( 'Background Color', 'am-lottieplayer' ) }
				className="am-lottieplayer-settings"
				initialOpen={ false }
			>
				<ColorPicker
					color={ background }
					onChange={ ( color ) =>
						setAttributes( { background: color } )
					}
				/>
			</PanelBody>
		</Panel>
	);
};

export default Background;
