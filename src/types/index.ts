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
	id?: string;
	isDark?: boolean;
	mouseout?: string;
	objectFit?: DotLottiePlayer[ 'objectfit' ];
	templateLock?: EditorTemplateLock;
	width?: number;
}
