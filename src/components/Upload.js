import { MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';

export default function Upload( {
	gallery = false,
	onSelect = () => {},
	render = {},
} = {} ) {
	const allowed = [ 'application/json', 'application/zip', 'text/plain' ];

	return (
		<MediaUploadCheck>
			<MediaUpload
				gallery={ gallery }
				onSelect={ ( { mime, url } ) => {
					if ( url && allowed.includes( mime ) ) {
						onSelect( url );
					}
				} }
				allowedTypes={ allowed }
				render={ render }
			/>
		</MediaUploadCheck>
	);
}
