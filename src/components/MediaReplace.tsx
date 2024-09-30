import { useSelect } from '@wordpress/data';
import { useEffect, useRef, useState } from '@wordpress/element';
// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
import { __unstableStripHTML as stripHTML } from '@wordpress/dom';
import { speak } from '@wordpress/a11y';
import { __ } from '@wordpress/i18n';
import { upload } from '@wordpress/icons';
import {
	Dropdown,
	FormFileUpload,
	MenuItem,
	NavigableMenu,
	Notice,
	ToolbarButton,
} from '@wordpress/components';
import {
	// eslint-disable-next-line @typescript-eslint/ban-ts-comment
	// @ts-expect-error
	// eslint-disable-next-line @wordpress/no-unsafe-wp-apis
	__experimentalLinkControl as LinkControl,
	BlockIcon,
	MediaUpload as MediaUploadComponent,
	MediaUploadCheck,
} from '@wordpress/block-editor';
import classNames from 'classnames';

import { isValidUrl } from '@utils';
import Lottie from '@assets/Lottie';

import type { PlayerComponentProps } from '@types';

type MediaUpload = ( options: {
	allowedTypes: string[];
	filesList: FileList | null;
	onFileChange: ( media: Media[] ) => void;
	onError: ( message: string ) => void;
} ) => void;

export type Media = {
	id: number;
	url?: string;
	alt?: string;
};

export default function MediaReplace( {
	attributes,
	setAttributes,
}: {
	readonly attributes: PlayerComponentProps;
	readonly setAttributes: ( attrs: Partial< PlayerComponentProps > ) => void;
} ) {
	const [ state, setState ] = useState( {
			externalURL: attributes.src || '',
			mediaId: Number( attributes.id ),
		} ),
		editMediaButtonRef = useRef< HTMLButtonElement >( null ),
		mediaUpload: MediaUpload | undefined = useSelect( ( select ) => {
			try {
				const {
					getSettings,
				}: { getSettings: () => { mediaUpload: MediaUpload } } =
					select( 'core/block-editor' );
				return getSettings().mediaUpload;
			} catch ( err ) {
				console.error( err );
			}
		}, [] ),
		allowedTypes = [ 'application/json', 'application/zip' ],
		accept = '.lottie,.json',
		ErrorNotice = ( message: string ) => (
			<Notice className="am-lottieplayer-notice" status="error">
				{ message }
			</Notice>
		),
		onUploadError = ( message: string ) => {
			const safeMessage: string = stripHTML( message );
			// We need to set a timeout for showing the notice
			// so that VoiceOver and possibly other screen readers
			// can announce the error afer the toolbar button
			// regains focus once the upload dialog closes.
			// Otherwise VO simply skips over the notice and announces
			// the focused element and the open menu.
			setTimeout( () => {
				ErrorNotice( safeMessage );
			}, 1000 );
		},
		onSelectMedia = ( { alt, id, url }: Media ) => {
			if ( ! url ) {
				setAttributes( { id: undefined, src: undefined } );
				return;
			}
			setState( ( prev ) => ( { ...prev, mediaId: id } ) );
			setAttributes( {
				alt,
				id: id?.toString(),
				src: url,
			} );
		},
		selectMedia = ( media: Media, closeMenu: () => void ) => {
			closeMenu();
			// Calling `onSelect` after the state update since it might unmount the component.
			onSelectMedia( media );
			speak( __( 'The media file has been replaced' ) );
		},
		uploadFiles = (
			{ target }: React.ChangeEvent< HTMLInputElement >,
			closeMenu: () => void
		) => {
			try {
				if ( ! mediaUpload ) {
					throw new Error( 'Media Upload function is not set' );
				}
				const files = target.files;
				mediaUpload( {
					allowedTypes,
					filesList: files,
					onError: onUploadError,
					onFileChange: ( [ media ] ) => {
						selectMedia( media, closeMenu );
					},
				} );
			} catch ( err ) {
				console.error( err );
			}
		},
		openOnArrowDown = (
			event:
				| React.KeyboardEvent< HTMLAnchorElement >
				| React.KeyboardEvent< HTMLButtonElement >
		) => {
			if ( event.key === 'ArrowDown' ) {
				event.preventDefault();
				if (
					event.target instanceof HTMLAnchorElement ||
					event.target instanceof HTMLButtonElement
				) {
					event.target.click();
				}
			}
		};

	useEffect( () => {
		if (
			isValidUrl( state.externalURL ) &&
			( state.externalURL.endsWith( '.lottie' ) ||
				state.externalURL.endsWith( '.json' ) )
		) {
			setAttributes( {
				src: state.externalURL,
			} );
		}
	}, [ state.externalURL, setAttributes ] );

	return (
		<Dropdown
			contentClassName="block-editor-media-replace-flow__options"
			renderContent={ ( { onClose } ) => (
				<>
					<NavigableMenu className="block-editor-media-replace-flow__media-upload-menu">
						<MediaUploadCheck>
							<MediaUploadComponent
								allowedTypes={ allowedTypes }
								multiple={ false }
								onSelect={ ( media ) =>
									selectMedia( media, onClose )
								}
								// eslint-disable-next-line @typescript-eslint/unbound-method
								render={ ( { open } ) => (
									<MenuItem
										icon={ <BlockIcon icon={ Lottie } /> }
										onClick={ open }
									>
										{ __( 'Open Media Library' ) }
									</MenuItem>
								) }
								value={ state.mediaId }
							/>
							<FormFileUpload
								accept={ accept }
								onChange={ ( event ) => {
									uploadFiles( event, onClose );
								} }
								render={ ( { openFileDialog } ) => {
									return (
										<MenuItem
											icon={ upload }
											onClick={ () => {
												openFileDialog();
											} }
										>
											{ __( 'Upload' ) }
										</MenuItem>
									);
								} }
							/>
						</MediaUploadCheck>
					</NavigableMenu>
					<form
						className={ classNames(
							'block-editor-media-flow__url-input',
							{
								'has-siblings': !! mediaUpload,
							}
						) }
					>
						<span className="block-editor-media-replace-flow__image-url-label">
							{ __( 'Current media URL:' ) }
						</span>

						<LinkControl
							onChange={ ( externalURL: string ) => {
								setState( ( prev ) => ( {
									...prev,
									externalURL,
								} ) );
								editMediaButtonRef.current?.focus();
							} }
							settings={ [] }
							showSuggestions={ false }
							value={ { url: attributes.src } }
						/>
					</form>
				</>
			) }
			renderToggle={ ( { isOpen, onToggle } ) => (
				<ToolbarButton
					aria-expanded={ isOpen }
					aria-haspopup="true"
					onClick={ onToggle }
					onKeyDown={ openOnArrowDown }
					ref={ editMediaButtonRef }
				>
					{ __( 'Replace' ) }
				</ToolbarButton>
			) }
		/>
	);
}
