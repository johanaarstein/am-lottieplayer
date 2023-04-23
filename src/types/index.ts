import type { EditorTemplateLock } from '@wordpress/block-editor';
import type { BlockEditProps } from 'wordpress__blocks';
import type { ResizeStartCallback } from 're-resizable';
import type { DotLottiePlayer } from '@johanaarstein/dotlottie-player';
import type { AnimationSegment } from 'lottie-web';

export enum PlayMode {
	Bounce = 'bounce',
	Normal = 'normal',
}

export enum OnMouseOut {
	Void = 'void',
	Stop = 'stop',
	Pause = 'pause',
	Reverse = 'reverse',
}

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
	fullscreen?: boolean;
	hasParallax?: boolean;
	height?: number;
	heightUnit?: 'px' | '%';
	id?: string;
	isDark?: boolean;
	mouseout?: OnMouseOut;
	objectFit?: DotLottiePlayer[ 'objectfit' ];
	scrollEvent?: boolean;
	segment?: AnimationSegment;
	selector?: {
		id?: string;
		exclude?: boolean;
	};
	templateLock?: EditorTemplateLock;
	width?: number;
}

export interface BlockCoverEditProps
	extends BlockEditProps< PlayerComponentProps > {
	toggleSelection?: ( x: boolean ) => void;
}

export interface PlaceholderProps
	extends BlockEditProps< PlayerComponentProps > {
	isPlaceholder?: boolean;
}

export interface UploadProps {
	children?: never;
	onSelectMedia: ( value: { id: number; url: string; alt: string } ) => void;
	onError: ( message: string ) => void;
}

export interface ResizableCoverProps {
	className?: string;
	fullscreen?: boolean;
	onResizeStart: ResizeStartCallback;
	onResize: ( n: number ) => void;
	onResizeStop: ( n: number ) => void;
	showHandle?: boolean;
	[ x: string ]: unknown;
}
