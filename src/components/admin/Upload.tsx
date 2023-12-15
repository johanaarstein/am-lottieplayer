import { useId, useRef, useState } from '@wordpress/element';
import { __, _n, sprintf } from '@wordpress/i18n';

import Expandable from './Expandable';
import Combine from './Combine';
import Convert from './Convert';
import DropZone from './DropZone';
import { formatBytes, getExt, getFilename, parseJsonFile } from '@utils';

import type { Dispatch, DragEvent, MouseEvent, SetStateAction } from 'react';
import type { Attachment, LottieJSON, Media, NoticeProps } from '@types';

export default function Upload( {
	id: idFromProps,
	instructions,
	multiple = false,
	context = 'combine',
	type,
	setNotice,
}: {
	id?: string;
	instructions?: string;
	multiple?: boolean;
	context?: 'combine' | 'convert';
	type?: string[];
	setNotice: Dispatch< SetStateAction< NoticeProps > >;
} ) {
	const generatedId = useId(),
		id = idFromProps || generatedId,
		{ endpoint, nonce } = amPhpVars,
		allowedTypes = {
			mime:
				context === 'combine'
					? [ 'application/json', 'application/zip' ]
					: [ 'application/json' ],
			extension:
				context === 'combine' ? [ '.lottie', '.json' ] : [ '.json' ],
		},
		checkType = ( mimeType: string, fileName: string ) => {
			return (
				allowedTypes.mime.includes( mimeType.toLowerCase() ) ||
				allowedTypes.extension.includes(
					`.${ getExt( fileName ) ?? '' }`
				)
			);
		},
		wrongType = () => {
			setNotice( {
				show: true,
				status: 'error',
				message:
					context === 'combine'
						? __(
								'Only JSON and dotLottie files allowed',
								'am-lottieplayer'
						  )
						: __( 'Only JSON files allowed', 'am-lottieplayer' ),
			} );
		},
		[ files, setFiles ] = useState< Attachment[] >( [] ),
		frame = useRef< Media | null >( null ),
		{ pluginUrl } = amPhpVars,
		{ media } = wp,
		openModal = ( e: MouseEvent ) => {
			e.preventDefault();

			// If the media frame already exists, reopen it.
			if ( frame.current ) {
				return frame.current.open();
			}

			// Create a new media frame
			frame.current = media( {
				title:
					instructions ??
					__( 'Select or upload Lottie', 'am-lottieplayer' ),
				button: {
					text: __( 'Use' ),
				},
				multiple,
				library: {
					type,
				},
			} );

			frame.current.on( 'select', () => {
				const attachments = frame.current?.state().get( 'selection' );
				if ( ! attachments ) {
					return;
				}
				for ( const attachment of attachments ) {
					const att = attachment.toJSON();
					if ( ! checkType( att.mime, att.filename ) ) {
						return wrongType();
					}
					att.lottieJSON = [];
					setFiles( ( prev ) => [ ...prev, att ] );
				}
			} );

			return frame.current.open();
		},
		handleFiles = async ( filesToHandle: FileList ) => {
			const filesArr = Array.from( filesToHandle );
			if (
				! filesArr.every( ( { type: mimeType, name } ) =>
					checkType( mimeType, name )
				)
			) {
				return wrongType();
			}
			const lottieJSONArr: LottieJSON[] = [];
			for ( const file of filesArr ) {
				if ( file.type !== 'application/json' ) {
					continue;
				}

				lottieJSONArr.push( await parseJsonFile( file ) );
			}
			setFiles( ( prev ) => [
				...prev,
				...filesArr.map( ( file, i ) => {
					const name = getFilename( file.name ),
						typeArr = file.type.split( '/' );
					return {
						title: name,
						name,
						mime: file.type,
						filename: encodeURIComponent( file.name ).toLowerCase(),
						filesizeInBytes: file.size,
						filesizeHumanReadable: formatBytes( file.size, 0 ),
						icon: pluginUrl + 'assets/lottie-icon.svg',
						id: Math.floor( Math.random() * 10000 + 1 ),
						lottieJSON: [ lottieJSONArr[ i ] ], // <-- TODO: Hacky solution, to keep definitions inside scope.
						url: URL.createObjectURL( file ),
						type: typeArr[ 0 ],
						subtype: typeArr[ 1 ],
					};
				} ),
			] );
		},
		handleDrop = ( {
			dataTransfer: { files: droppedFiles },
		}: DragEvent ) => {
			void handleFiles( droppedFiles );
		},
		uploadLottie = async ( buffer: ArrayBuffer, name: string ) => {
			const formData = new FormData();

			formData.append(
				'file',
				new Blob( [ buffer ], {
					type: 'application/zip',
				} ),
				`${ name }.lottie`
			);
			const sendData = await fetch( endpoint, {
				method: 'POST',
				credentials: 'same-origin',
				body: formData,
				headers: {
					'X-WP-Nonce': nonce,
				},
			} );
			if ( ! sendData.ok ) {
				setNotice( {
					show: true,
					status: 'error',
					message: __(
						'Error while uploading file',
						'am-lottieplayer'
					),
				} );
				return;
			}
			setNotice( {
				show: true,
				status: 'success',
				message: sprintf(
					// eslint-disable-next-line @wordpress/i18n-translator-comments
					_n(
						'%s file uploaded successfully',
						'%s files uploaded successfully',
						context === 'combine' ? 1 : files.length,
						'am-lottieplayer'
					),
					context === 'combine' ? 1 : files.length
				),
			} );
			setTimeout( () => {
				setFiles( [] );
			}, 500 );
		};

	return (
		<>
			<Expandable className="am-selected" trigger={ files }>
				{ !! files?.length &&
					( context === 'combine' ? (
						<Combine
							files={ files }
							setFiles={ setFiles }
							setNotice={ setNotice }
							uploadLottie={ uploadLottie }
						/>
					) : (
						<Convert
							files={ files }
							setFiles={ setFiles }
							setNotice={ setNotice }
							uploadLottie={ uploadLottie }
							wrongType={ wrongType }
						/>
					) ) }
			</Expandable>
			<DropZone className="am-lottieplayer-upload" onDrop={ handleDrop }>
				<div className="inner">
					<h2>{ __( 'Drop files to upload' ) }</h2>
					<p>{ __( 'or' ) }</p>
					<input
						id={ id }
						type="file"
						accept={ allowedTypes.extension.join( ',' ) }
						multiple={ multiple }
						onChange={ ( { target: { files: uploadedFiles } } ) => {
							if ( ! uploadedFiles ) return;
							void handleFiles( uploadedFiles );
						} }
					/>
					<div className="am-button-wrapper">
						<label className="am-btn white" htmlFor={ id }>
							{ __( 'Select Files' ) }
						</label>
						<button onClick={ openModal } className="am-btn blue">
							{ __( 'Media Library' ) }
						</button>
					</div>
				</div>
			</DropZone>
		</>
	);
}
