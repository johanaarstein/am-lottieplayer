import type { Dispatch, SetStateAction } from 'react';
import type { EditorTemplateLock } from '@wordpress/block-editor';
import type { DotLottiePlayer } from '@johanaarstein/dotlottie-player';

export interface PlayerComponentProps extends Partial< DotLottiePlayer > {
	align?: string;
	allowedBlocks?: string[];
	alt?: string;
	clickEvent?: boolean;
	contentPosition?: string;
	dimRatio?: number;
	focalPoint?: {
		x?: number;
		y?: number;
	};
	hasParallax?: boolean;
	height?: number;
	heightUnit?: 'px' | '%';
	isDark?: boolean;
	mouseout?: string;
	objectFit?: DotLottiePlayer[ 'objectfit' ];
	templateLock?: EditorTemplateLock;
	width?: number;
}

export type EditProps = {
	attributes: object;
	clientId?: string;
	isSelected?: boolean;
	overlayColor?: {
		color: string;
	};
	setAttributes: Dispatch< SetStateAction< object > >;
	setOverlayColor?: Dispatch< SetStateAction< string > >;
	toggleSelection?: ( x: boolean ) => void;
	context?: {
		postId: string;
		postType: string;
	};
};
