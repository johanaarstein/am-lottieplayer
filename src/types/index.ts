import type { EditorTemplateLock } from '@wordpress/block-editor';
import { RefObject } from 'react';

declare enum PlayerState {
	Completed = 'completed',
	Destroyed = 'destroyed',
	Error = 'error',
	Frozen = 'frozen',
	Loading = 'loading',
	Paused = 'paused',
	Playing = 'playing',
	Stopped = 'stopped',
}
declare enum PlayMode {
	Bounce = 'bounce',
	Normal = 'normal',
}

type AnimationDirection = 1 | -1;
type RendererType = 'svg' | 'canvas' | 'html';

type Autoplay = boolean | '' | 'autoplay' | null;
type Controls = boolean | '' | 'controls' | null;
type Loop = boolean | '' | 'loop' | null;
type ObjectFit = 'contain' | 'cover' | 'fill' | 'scale-down' | 'none';
type PreserveAspectRatio =
	| 'xMidYMid meet'
	| 'xMidYMid slice'
	| 'xMinYMin slice'
	| 'none';

export type DotLottiePlayer = {
	autoplay?: Autoplay;
	background?: string;
	class?: string;
	controls?: Controls;
	count?: number;
	currentState?: PlayerState;
	description?: string;
	direction?: AnimationDirection;
	hover?: boolean;
	loop?: Loop;
	mode?: PlayMode;
	objectfit?: ObjectFit;
	preserveAspectRatio?: PreserveAspectRatio;
	ref?: RefObject< unknown >;
	renderer?: RendererType;
	seeker?: number;
	shadowRoot?: ShadowRoot;
	speed?: number;
	src: string;
	style?: Record< string, string | unknown >;
	load?: ( src: string | Record< string, unknown > ) => Promise< void >;
	play?: () => void;
	pause?: () => void;
	stop?: () => void;
	destroy?: () => void;
	seek?: ( value: number | string ) => void;
	snapshot?: ( download?: boolean ) => string | void;
	reload?: () => Promise< void >;
	setSpeed?: ( value?: number ) => void;
	setDirection?: ( value: number ) => void;
	setLooping?: ( value: boolean ) => void;
	togglePlay?: () => void;
	toggleLooping?: () => void;
};

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

declare global {
	namespace JSX {
		interface IntrinsicElements {
			'dotlottie-player': DotLottiePlayer;
		}
	}
}

// export type EditProps = {
// 	attributes: object;
// 	clientId?: string;
// 	isSelected?: boolean;
// 	overlayColor?: {
// 		color: string;
// 	};
// 	setAttributes: Dispatch< SetStateAction< object > >;
// 	setOverlayColor?: Dispatch< SetStateAction< string > >;
// 	toggleSelection?: ( x: boolean ) => void;
// 	context?: {
// 		postId: string;
// 		postType: string;
// 	};
// };
