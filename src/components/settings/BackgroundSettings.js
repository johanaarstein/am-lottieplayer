import { ColorPalette, Panel, PanelBody } from '@wordpress/components';

import { debounce } from '../../functions';

const theme = [
	{ name: '#000000', color: '#000000' },
	{ name: '#FFFFFF', color: '#FFFFFF' },
	{ name: '#274447', color: '#274447' },
	{ name: '#F9E3CA', color: '#F9E3CA' },
	{ name: '#F6F6F6', color: '#F6F6F6' },
	{ name: 'Transparent', color: 'transparent' },
];

const defaultColors = [
	{ name: '#000000', color: '#000000' },
	{ name: '#ADB8C2', color: '#ADB8C2' },
	{ name: '#FFFFFF', color: '#FFFFFF' },
	{ name: '#E792A7', color: '#E792A7' },
	{ name: '#BD3D36', color: '#BD3D36' },
	{ name: '#EB712E', color: '#EB712E' },
	{ name: '#F1BB40', color: '#F1BB40' },
	{ name: '#95DAB7', color: '#95DAB7' },
	{ name: '#63CC8A', color: '#63CC8A' },
	{ name: '#9FD0F8', color: '#9FD0F8' },
	{ name: '#4492DD', color: '#4492DD' },
	{ name: '#9058D8', color: '#9058D8' },
];

const BackgroundSettings = ( { attributes, setAttributes } ) => {
	const debouncedChange = debounce( ( val ) => setAttributes( val ), 500 );

	return (
		<Panel>
			<PanelBody title="Background" initialOpen={ true }>
				<div>
					<h3>Background Color</h3>
					<ColorPalette
						clearable={ false }
						colors={ [] }
						className="lf-pr-2"
						value={ attributes.background }
						onChange={ ( color ) =>
							debouncedChange( { background: color } )
						}
					/>
				</div>
				<div className="lf-mb-4">
					<h3>Theme</h3>
					<ColorPalette
						disableCustomColors
						colors={ theme }
						clearable={ false }
						value={ attributes.background }
						onChange={ ( color ) =>
							setAttributes( { background: color } )
						}
					/>
				</div>
				<div className="lf-mb-4">
					<h3>Default</h3>
					<ColorPalette
						disableCustomColors
						colors={ defaultColors }
						clearable={ false }
						value={ attributes.background }
						onChange={ ( color ) =>
							setAttributes( { background: color } )
						}
					/>
				</div>
			</PanelBody>
		</Panel>
	);
};

export default BackgroundSettings;
