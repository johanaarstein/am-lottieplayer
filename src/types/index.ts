import type { DotLottiePlayer } from '@johanaarstein/dotlottie-player';

export interface PlayerComponentProps extends DotLottiePlayer {
	align?: string;
	alt?: string;
	clickEvent?: boolean;
	height?: number;
	heightUnit?: 'px' | '%';
	mouseout?: string;
	objectFit?: 'none' | 'contain' | 'cover' | 'fill' | 'scale-down';
	width?: number;
}
