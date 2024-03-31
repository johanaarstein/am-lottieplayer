import type { ReactNode } from 'react';
import type { EditorTemplateLock } from '@wordpress/block-editor';
import type { BlockEditProps } from 'wordpress__blocks';
import type { ResizeStartCallback } from 're-resizable';
import type { DotLottiePlayer } from '@aarsteinmedia/dotlottie-player-light';
import type { AnimationSegment } from 'lottie-web';
import type { Align, OnMouseOut } from '@utils';

export interface PlayerComponentProps extends Partial< DotLottiePlayer > {
	align?: Align;
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
	once?: boolean;
	scrollEvent?: boolean;
	scrollDelay?: number | null;
	segment?: AnimationSegment;
	selector?: {
		id?: string;
		exclude?: boolean;
	};
	templateLock?: EditorTemplateLock;
	width?: number | null;
}

export interface BlockCoverEditProps
	extends BlockEditProps< PlayerComponentProps > {
	toggleSelection?: ( x: boolean ) => void;
}

export interface UploadProps {
	children?: never;
	onSelectMedia: ( value: { id: number; url: string; alt: string } ) => void;
	onError: ( message: string ) => void;
}

export interface ResizableCoverProps {
	children?: ReactNode;
	className?: string;
	fullscreen?: boolean;
	onResizeStart: ResizeStartCallback;
	onResize: ( n: number ) => void;
	onResizeStop: ( n: number ) => void;
	showHandle?: boolean;
	[ x: string ]: unknown;
}

interface LottieAsset {
	/** Whether the data is encoded or not */
	e: 0 | 1;
	/** Name of asset – e.g. image_0 / audio_0 */
	id: string;
	/** Filename – e.g image_0.png / audio_0.mp3 | DataURL, Base64 encoded */
	p: string;
	u: string;
}

export interface LottieJSON {
	assets?: LottieAsset[];
	ddd: number;
	/** Frames per second, natively */
	fr: number;
	/** Height of animation in pixels */
	h: number;
	ip: number;
	layers: unknown[];
	markers: unknown[];
	meta: {
		a: string;
		d: string;
		/** Generator */
		g: string;
		k: string;
		tc: string;
	};
	/** Name of animation, from rendering */
	nm: string;
	/** Total number of frames */
	op: number;
	/** Version */
	v: string;
	/** Width of animation in pixels */
	w: number;
}

type PHPVars = {
	pluginUrl: string;
	nonce: string;
	endpoint: string;
};

export interface Attachment {
	alt?: string;
	caption?: string;
	description?: string;
	filename: string;
	filesizeHumanReadable: string;
	filesizeInBytes: number;
	icon: string;
	id: number;
	lottieJSON: LottieJSON[];
	mime: string;
	name: string;
	subtype: string;
	title: string;
	type: string;
	url: string;
}

interface AttachmentObj {
	toJSON: () => Attachment;
}

interface MediaState {
	get: ( event: string ) => AttachmentObj[];
}

export interface Media {
	[ x: string ]: unknown;
	on: ( event: string, callback: () => unknown ) => void;
	open: () => void;
	state: () => MediaState;
}

interface MediaOptions {
	title: string;
	button: {
		text: string;
	};
	multiple: boolean;
	library: {
		type?: string[];
	};
}

export interface NoticeProps {
	show: boolean;
	status: 'success' | 'error' | 'info';
	message?: string;
}

declare global {
	const amPhpVars: PHPVars;
	function dotLottiePlayer(): DotLottiePlayer;
	const wp: {
		[ x: string ]: unknown;
		media: ( options: MediaOptions ) => Media;
	};
}
