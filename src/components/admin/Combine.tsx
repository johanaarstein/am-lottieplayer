import { useState } from '@wordpress/element';
import { Notice } from '@wordpress/components';
import { __, _n, sprintf } from '@wordpress/i18n';

import { Draggable, DraggableItem } from './Draggable';
import { getExt, truncate } from '@utils';

import type { Dispatch, SetStateAction } from 'react';
import type { Attachment, NoticeProps } from '@types';

export default function Combine( {
	files,
	setFiles,
	setNotice,
	uploadLottie,
}: {
	files: Attachment[];
	setFiles: Dispatch< SetStateAction< Attachment[] > >;
	setNotice: Dispatch< SetStateAction< NoticeProps > >;
	uploadLottie: ( buffer: ArrayBuffer, name: string ) => Promise< void >;
} ) {
	const [ fileName, setFileName ] = useState< string >(),
		fallBackName = files.map( ( { name } ) => name ).join( '_' ),
		combineLottie = async ( download?: boolean ) => {
			const toAdd = files.map( ( { id, url } ) => ( {
				id: id.toString(),
				url,
			} ) );
			try {
				const parsedName =
						( fileName &&
							encodeURIComponent(
								fileName.replace( /\s/g, '-' )
							).toLowerCase() ) ||
						fallBackName,
					buffer = await dotLottiePlayer().addAnimation(
						toAdd,
						parsedName,
						!! download
					);
				if ( buffer ) {
					await uploadLottie( buffer, parsedName );
				} else {
					setNotice( {
						show: true,
						status: 'success',
						message: sprintf(
							// eslint-disable-next-line @wordpress/i18n-translator-comments
							_n(
								'%s file was combined to 1 dotLottie, and downloaded successfully',
								'%s files was combined to 1 dotLottie, and downloaded successfully',
								files.length,
								'am-lottieplayer'
							),
							files.length
						),
					} );
					setTimeout( () => {
						setFiles( [] );
					}, 500 );
				}
			} catch ( err ) {
				setNotice( {
					show: true,
					status: 'error',
					message: __( 'There was an error', 'am-lottieplayer' ),
				} );
			}
		};

	return (
		<>
			<div className="content">
				<h3>{ __( 'Animations to combine', 'am-lottieplayer' ) }</h3>
				<p>
					{ __(
						'Place the animations in the order you want them to appear. Use drag to change the order.',
						'am-lottieplayer'
					) }
				</p>
			</div>

			<Draggable className="am-files">
				{ files.map(
					(
						{
							alt,
							filename,
							icon,
							id: fileId,
							filesizeHumanReadable,
							name,
						},
						i
					) => (
						<DraggableItem
							key={ fileId }
							id={ fileId }
							list={ files }
							setList={ setFiles }
							className="am-file am-combine"
						>
							<button
								className="am-remove media-modal-close"
								onClick={ () => {
									setFiles( ( prev ) =>
										prev.filter( ( a ) => a.id !== fileId )
									);
								} }
							>
								<span className="media-modal-icon" />
							</button>
							<img src={ icon } alt={ alt } />
							<span className="am-order">{ i + 1 }</span>
							<p>
								{ truncate( name, 8 ) }
								{ getExt( filename )
									? `.${ getExt( filename ) as string } `
									: ' ' }
								<span className="am-size">
									{ filesizeHumanReadable }
								</span>
							</p>
						</DraggableItem>
					)
				) }
			</Draggable>
			{ files.length > 1 ? (
				<>
					<div className="am-button-wrapper combine-files">
						<fieldset className="am-fieldset">
							<label
								className="am-label"
								htmlFor="am-lottieplayer-filename"
							>
								{ __( 'File name', 'am-lottieplayer' ) }
							</label>
							<input
								id="am-lottieplayer-filename"
								className="am-input"
								name="fileName"
								value={ fileName }
								onChange={ ( { target } ) =>
									setFileName( target.value )
								}
								type="text"
								placeholder={ `${ fallBackName }.lottie` }
							/>
						</fieldset>
						<button
							onClick={ () => void combineLottie( true ) }
							className="am-btn small white"
						>
							<span className="dashicons dashicons-download" />{ ' ' }
							{ __( 'Combine and download' ) }
						</button>
						<button
							onClick={ () => void combineLottie( false ) }
							className="am-btn small blue"
						>
							<span className="dashicons dashicons-cloud-saved" />{ ' ' }
							{ __(
								'Combine and add to Media Library',
								'am-lottieplayer'
							) }
						</button>
					</div>
				</>
			) : (
				<Notice status="info" isDismissible={ false }>
					{ __(
						'You need to select 2 or more animations',
						'am-lottieplayer'
					) }
				</Notice>
			) }
		</>
	);
}
