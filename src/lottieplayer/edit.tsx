import { useBlockProps } from '@wordpress/block-editor';
import { Spinner } from '@wordpress/components';

import PlayerWrapper from '@context/PlayerWrapper';
import LottieControls from '@components/LottieControls';
import Placeholder from '@components/Placeholder';

import { isTemporaryMedia } from '@utils';

import type { BlockEditProps } from 'wordpress__blocks';
import type { PlayerComponentProps } from '@types';

import './editor.scss';

export default function Edit( {
	attributes,
	className,
	clientId,
	context,
	isSelected,
	setAttributes,
}: BlockEditProps< PlayerComponentProps > ) {
	const isUploadingMedia = isTemporaryMedia( attributes.id, attributes.src );

	return (
		<PlayerWrapper>
			<LottieControls
				attributes={ attributes }
				setAttributes={ setAttributes }
				clientId={ clientId }
				isSelected={ isSelected }
				context={ context }
				className={ className }
			/>
			{ isUploadingMedia && <Spinner /> }
			<div { ...useBlockProps() }>
				<Placeholder
					attributes={ attributes }
					setAttributes={ setAttributes }
					clientId={ clientId }
					isSelected={ isSelected }
					context={ context }
					className={ className }
				/>
			</div>
		</PlayerWrapper>
	);
}
