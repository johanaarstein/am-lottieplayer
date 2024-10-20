import type { PlayerComponentProps } from '@/types';
import type { BlockEditProps } from '@wordpress/blocks';

import { ColorPicker, Panel, PanelBody } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const Background = ( {
	attributes,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) => {
	const { background } = attributes;

	return (
		<Panel>
			<PanelBody
				className="am-lottieplayer-settings"
				initialOpen={ true }
				title={ __( 'Background Color', 'am-lottieplayer' ) }
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
