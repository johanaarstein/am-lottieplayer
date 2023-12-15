import { __, _n, sprintf } from '@wordpress/i18n';

import { getExt, truncate } from '@utils';

import type { Dispatch, SetStateAction } from 'react';
import type { Attachment, LottieJSON, NoticeProps } from '@types';

export default function Convert( {
	files,
	setFiles,
	setNotice,
	uploadLottie,
	wrongType,
}: {
	files: Attachment[];
	setFiles: Dispatch< SetStateAction< Attachment[] > >;
	setNotice: Dispatch< SetStateAction< NoticeProps > >;
	uploadLottie: ( buffer: ArrayBuffer, name: string ) => Promise< void >;
	wrongType(): void;
} ) {
	const isDotLottie = ( { mime }: Attachment ) => {
			return mime.toLowerCase() !== 'application/json';
		},
		convertLottie = async ( download?: boolean ) => {
			const toResolve: Promise< void >[] = [];
			try {
				for ( const file of files ) {
					if ( isDotLottie( file ) ) {
						wrongType();
						continue;
					}
					if ( ! file.lottieJSON.length ) {
						const res = await fetch( file.url );
						if ( res.ok ) {
							const lottieJSON: unknown = await res.json();
							if (
								lottieJSON &&
								typeof lottieJSON === 'object'
							) {
								file.lottieJSON.push(
									lottieJSON as LottieJSON
								);
							}
						}
					}
					toResolve.push(
						new Promise< void >( ( resolve ) => {
							const convert = dotLottiePlayer().convert(
								false, // We've already checked that the file is not a dotLottie
								{
									animations: [
										{
											id: file.id.toString(),
										},
									],
								},
								file.lottieJSON,
								file.name,
								download
							);

							void convert?.then( ( buffer ) => {
								if ( buffer ) {
									void uploadLottie( buffer, file.name ).then(
										() => resolve()
									);
								}
							} );
							resolve();
						} )
					);
				}

				await Promise.all( toResolve );

				setNotice( {
					show: true,
					status: 'success',
					message: download
						? sprintf(
								// eslint-disable-next-line @wordpress/i18n-translator-comments
								_n(
									'%s file was successfully converted and downloaded',
									'%s files was uccessfully converted and downloaded',
									files.length,
									'am-lottieplayer'
								),
								files.length
						  )
						: sprintf(
								// eslint-disable-next-line @wordpress/i18n-translator-comments
								_n(
									'%s file was successfully converted',
									'%s files was uccessfully converted',
									files.length,
									'am-lottieplayer'
								),
								files.length
						  ),
				} );

				return setFiles( [] );
			} catch ( err ) {
				return setNotice( {
					show: true,
					status: 'error',
					message: __( 'Failed to convert file', 'am-lottieplayer' ),
				} );
			}
		};
	return (
		<>
			<h3>{ __( 'Animations to convert', 'am-lottieplayer' ) }</h3>
			<div className="am-files">
				{ files.map(
					( {
						alt,
						icon,
						id: fileId,
						filename,
						filesizeHumanReadable,
						name,
					} ) => (
						<div key={ fileId } className="am-file">
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
							<p>
								{ truncate( name, 8 ) }
								{ getExt( filename )
									? `.${ getExt( filename ) as string } `
									: ' ' }
								<span className="am-size">
									{ filesizeHumanReadable }
								</span>
							</p>
						</div>
					)
				) }
			</div>
			{ !! files.length && (
				<div className="am-button-wrapper convert-files">
					<button
						onClick={ () => void convertLottie( true ) }
						className="am-btn small white"
					>
						<span className="dashicons dashicons-download" />{ ' ' }
						{ __( 'Convert and download' ) }
					</button>
					<button
						onClick={ () => void convertLottie( false ) }
						className="am-btn small blue"
					>
						<span className="dashicons dashicons-cloud-saved" />{ ' ' }
						{ __(
							'Convert and save to Media Library',
							'am-lottieplayer'
						) }
					</button>
				</div>
			) }
		</>
	);
}
