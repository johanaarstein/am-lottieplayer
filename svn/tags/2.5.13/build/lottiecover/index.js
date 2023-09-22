!function(){var e,t={960:function(e,t,l){"use strict";var a=window.wp.blocks,n=window.wp.element,r=l(184),o=l.n(r),i=window.wp.blockEditor,s=window.wp.components,c=window.wp.i18n,u=window.wp.data,d=({attributes:e,setAttributes:t})=>{const{alt:l,renderer:a="svg"}=e;return(0,n.createElement)(i.InspectorAdvancedControls,null,(0,n.createElement)(s.SelectControl,{label:(0,c.__)("Renderer"),value:a,onChange:e=>t({renderer:e}),options:[{value:"svg",label:"SVG"},{value:"canvas",label:"Canvas"}]}),(0,n.createElement)(s.TextareaControl,{label:(0,c.__)("Description","am-lottieplayer"),help:(0,c.__)("Describe the animation. This is helpful for screen readers and search engines.","am-lottieplayer"),value:l,onChange:e=>t({alt:e})}))};let m=function(e){return e.Bounce="bounce",e.Normal="normal",e}({}),p=function(e){return e.Void="void",e.Stop="stop",e.Pause="pause",e.Reverse="reverse",e}({});var g=window.wp.blob;const y=({id:e="",onChange:t,subTitle:l,title:a,value:r})=>(0,n.createElement)(s.BaseControl,{id:e,help:l,className:"lottie-switch-label"},(0,n.createElement)(s.BaseControl.VisualLabel,null,a),(0,n.createElement)(s.FormToggle,{checked:r,onChange:()=>t(!r)})),f=({id:e="",onChange:t,title:l,value:a="",disabled:r,placeholder:o=""})=>(0,n.createElement)(s.BaseControl,{id:e,help:l,className:"lottie-number-wrapper"},(0,n.createElement)(s.TextControl,{value:a,onChange:e=>{t(void 0===e||""===e?void 0:Number(e))},onKeyDown:e=>{(({ctrlKey:e,key:t,metaKey:l,shiftKey:a})=>!(!a&&"End"!==t&&"Home"!==t&&"Backspace"!==t&&"Tab"!==t&&"Enter"!==t&&"Delete"!==t&&(!e&&!l||"a"!==t&&"c"!==t&&"v"!==t&&"x"!==t&&"z"!==t&&"t"!==t&&"r"!==t)))(e)||!(({key:e})=>Number(e)>=0&&Number(e)<=9)(e)&&e.preventDefault()},disabled:r,placeholder:o})),h=({id:e="",onChange:t,title:l,help:a,value:r="",placeholder:o=""})=>(0,n.createElement)(s.BaseControl,{id:e,help:a,className:"lottie-number-wrapper"},(0,n.createElement)(s.BaseControl.VisualLabel,null,l),(0,n.createElement)(s.TextControl,{value:r,onChange:e=>t(e),placeholder:o}));var b=({attributes:e,clientId:t,setAttributes:l})=>{const{autoplay:a,controls:r,direction:o,loop:i,mode:u=m.Normal,segment:d,speed:p=1,subframe:g}=e,h=(0,n.useRef)(),b=(0,n.useCallback)((e=>{"number"==typeof e&&(h.current=e)}),[]);return(0,n.useEffect)((()=>{const e=document.getElementById(t);e&&(b(e?.getLottie()?.totalFrames),e.addEventListener("ready",(()=>{b(e?.getLottie()?.totalFrames)})))}),[t,b]),(0,n.createElement)(s.Panel,null,(0,n.createElement)(s.PanelBody,{title:(0,c.__)("Animation Settings","am-lottieplayer"),initialOpen:!0},(0,n.createElement)(y,{id:"am-lottieplayer-controls-settings",title:(0,c.__)("Show controls","am-lottieplayer"),value:!!r,onChange:e=>l({controls:e})}),(0,n.createElement)(y,{id:"am-lottieplayer-autoplay-settings",title:(0,c.__)("Autoplay","am-lottieplayer"),value:!!a,onChange:e=>{l({autoplay:e})}}),(0,n.createElement)(y,{id:"am-lottieplayer-loop-settings",title:(0,c.__)("Loop","am-lottieplayer"),value:!!i,onChange:e=>{l({loop:e})}}),(0,n.createElement)(y,{id:"am-lottieplayer-playmode-settings",title:(0,c.__)("Boomerang","am-lottieplayer"),value:u===m.Bounce,onChange:e=>{l({mode:e?m.Bounce:m.Normal})}}),(0,n.createElement)(y,{id:"am-lottieplayer-reverse-settings",title:(0,c.__)("Reverse","am-lottieplayer"),value:-1===o,onChange:e=>l({direction:e?-1:1})}),(0,n.createElement)(y,{id:"am-lottieplayer-subframe-settings",title:(0,c.__)("Subframe","am-lottieplayer"),subTitle:(0,c.__)("Enabling this can sometimes reduce flicker","am-lottieplayer"),value:!!g,onChange:e=>l({subframe:e})}),(0,n.createElement)(s.RangeControl,{label:(0,c.__)("Speed","am-lottieplayer"),min:.5,max:5,step:.5,value:p,onChange:e=>l({speed:e})}),(0,n.createElement)(s.BaseControl.VisualLabel,null,(0,c.__)("Play only part of the animation","am-lottieplayer")),(0,n.createElement)(s.PanelRow,{className:"lottie-segment"},(0,n.createElement)(f,{id:"am-lottieplayer-segment-in",title:(0,c.__)("First frame","am-lottieplayer"),value:d?.[0],onChange:e=>{var t;return l({segment:void 0!==e?[e,null!==(t=d?.[1])&&void 0!==t?t:1]:void 0})},placeholder:"1"}),(0,n.createElement)(f,{id:"am-lottieplayer-segment-out",title:(0,c.__)("Last frame","am-lottieplayer"),value:d?.[1],onChange:e=>{var t;return l({segment:e?[null!==(t=d?.[0])&&void 0!==t?t:1,e]:void 0})},placeholder:h.current?.toString()}))))},v=({attributes:e,setAttributes:t})=>{const{background:l}=e;return(0,n.createElement)(s.Panel,null,(0,n.createElement)(s.PanelBody,{title:(0,c.__)("Background Color","am-lottieplayer"),initialOpen:!1},(0,n.createElement)(s.ColorPicker,{color:l,onChangeComplete:e=>t({background:e.hex})})))},_=({attributes:e,setAttributes:t})=>{const{clickEvent:l,hover:a,mouseout:r,once:o,scrollEvent:i,scrollDelay:u,selector:d}=e;return(0,n.createElement)(s.Panel,null,(0,n.createElement)(s.PanelBody,{title:(0,c.__)("Interactions","am-lottieplayer"),initialOpen:!0},(0,n.createElement)(y,{id:"am-lottieplayer-click-settings",title:(0,c.__)("Play on click","am-lottieplayer"),value:l,onChange:e=>t({clickEvent:e})}),(0,n.createElement)(y,{id:"am-lottieplayer-hover-settings",title:(0,c.__)("Play on mouseover","am-lottieplayer"),value:a,onChange:e=>t({hover:e})}),a&&(0,n.createElement)(s.SelectControl,{label:(0,c.__)("On mouseout","am-lottieplayer"),value:r,onChange:e=>t({mouseout:e}),options:[{value:p.Void,label:(0,c.__)("No event","am-lottieplayer")},{value:p.Stop,label:(0,c.__)("Stop","am-lottieplayer")},{value:p.Pause,label:(0,c.__)("Pause","am-lottieplayer")},{value:p.Reverse,label:(0,c.__)("Reverse","am-lottieplayer")}]}),(a||l)&&(0,n.createElement)(n.Fragment,null,(0,n.createElement)(h,{id:"am-lottieplayer-settings",title:(0,c.__)("Trigger element","am-lottieplayer"),help:(0,c.__)("Anchor tag (id) for an element you want to trigger the animation, either by hover or click.","am-lottieplayer"),placeholder:"#",value:d?.id,onChange:e=>t({selector:{...d,id:e}})}),(0,n.createElement)(y,{id:"am-lottieplayer-selector-settings",title:(0,c.__)("Apply interaction only to trigger element","am-lottieplayer"),value:d?.exclude,onChange:e=>t({selector:{...d,exclude:e}})})),(0,n.createElement)(y,{id:"am-lottieplayer-scroll-settings",title:(0,c.__)("Play on scroll, when visible in viewport","am-lottieplayer"),value:i,onChange:e=>t({scrollEvent:e})}),i&&(0,n.createElement)(n.Fragment,null,(0,n.createElement)(y,{id:"am-lottieplayer-once-settings",title:(0,c.__)("Play only once","am-lottieplayer"),value:o,onChange:e=>t({once:e})}),(0,n.createElement)(s.RangeControl,{label:(0,c.__)("Delay, in 10th of a second","am-lottieplayer"),min:0,max:50,step:1,value:null!=u?u:1,onChange:e=>t({scrollDelay:e})}))))},E=({attributes:e,setAttributes:t})=>{const{align:l,fullscreen:a,height:r,objectFit:o="contain",width:i}=e,u=(0,n.useCallback)((e=>"full"===l||"wide"===l?"100%":e&&"0"!==e?e:void 0),[l]);return(0,n.createElement)(s.Panel,null,(0,n.createElement)(s.PanelBody,{title:(0,c.__)("Dimensions","am-lottieplayer"),initialOpen:!0},(!a||"full"!==l)&&(0,n.createElement)(s.PanelRow,{className:"lottie-dimensions"},(0,n.createElement)(f,{id:"am-lottieplayer-width-settings",title:(0,c.__)("Width","am-lottieplayer"),value:u(i),onChange:e=>t({width:null!=e?e:null}),disabled:"full"===l||"wide"===l,placeholder:"full"===l||"wide"===l?"100%":"auto"}),(0,n.createElement)(f,{id:"am-lottieplayer-height-settings",title:(0,c.__)("Height","am-lottieplayer"),value:r&&"0"!==r.toString()?r:void 0,disabled:a,onChange:e=>t({height:e}),placeholder:"auto"})),("full"===l||"wide"===l)&&(0,n.createElement)(y,{id:"am-lottieplayer-fullscreen-settings",title:(0,c.__)("Fill screen","am-lottieplayer"),value:a,onChange:e=>t({fullscreen:e})}),(0,n.createElement)(s.SelectControl,{label:(0,c.__)("Object fit"),value:o,onChange:e=>{t({objectFit:e})},options:[{value:"contain",label:(0,c.__)("Contain","am-lottieplayer")},{value:"cover",label:(0,c.__)("Cover","am-lottieplayer")},{value:"fill",label:(0,c.__)("Fill","am-lottieplayer")},{value:"none",label:(0,c.__)("None","am-lottieplayer")}]})))};function w({attributes:e,className:t,clientId:l,context:a,isSelected:r,setAttributes:o}){return(0,n.createElement)(i.InspectorControls,null,(0,n.createElement)(b,{attributes:e,setAttributes:o,clientId:l,isSelected:r,context:a,className:t}),(0,n.createElement)(_,{attributes:e,setAttributes:o,clientId:l,isSelected:r,context:a,className:t}),(0,n.createElement)(E,{attributes:e,setAttributes:o,clientId:l,isSelected:r,context:a,className:t}),(0,n.createElement)(v,{attributes:e,setAttributes:o,clientId:l,isSelected:r,context:a,className:t}),(0,n.createElement)(d,{attributes:e,setAttributes:o,clientId:l,isSelected:r,context:a,className:t}))}function C(){return(0,n.createElement)(s.SVG,{role:"img",xmlns:"http://www.w3.org/2000/svg",xmlSpace:"preserve",viewBox:"0 0 80 80"},(0,n.createElement)("style",null,"\n\t\t\t\t.am-lottieplayer-path {\n\t\t\t\t\tfill: url(#a)\n\t\t\t\t}\n\t\t\t\t.block-editor-block-toolbar .am-lottieplayer-path,\n\t\t\t\t.components-panel .am-lottieplayer-path {\n\t\t\t\t\tfill: var(--wp-admin-theme-color-darker-10)\n\t\t\t\t}"),(0,n.createElement)("defs",null,(0,n.createElement)("radialGradient",{id:"a",cx:".2",cy:"1.07",r:"1.2"},(0,n.createElement)("stop",{offset:"10%"},(0,n.createElement)("animate",{attributeName:"stop-color",values:"#24708f;#e18d4c;#1f374c;#85c6e0;#24708f;",dur:"12s",repeatCount:"indefinite"})),(0,n.createElement)("stop",{offset:"90%"},(0,n.createElement)("animate",{attributeName:"stop-color",values:"#85c6e0;#24708f;#e18d4c;#1f374c;#85c6e0;",dur:"24s",repeatCount:"indefinite"})))),(0,n.createElement)(s.Path,{className:"am-lottieplayer-path",d:"M60 0H20C9 0 0 9 0 20v39.5C0 71 9 80 20 80h39.5c11 0 20.5-9 20.5-20V20C80 9 71 0 60 0zm4.9 59.7h-7.4V37.1c0-3.2.3-8.2.3-8.2h-.1s-.9 4.7-1.7 7.5l-6.8 23.3h-4l-11-30.2c-.8-2.2-2-5.8-2-5.8h-.1s-1.1 3.4-1.9 5.8L18.7 59.7H15l15-39.4h4.2l11.4 30c.3-1.4 1.2-6.1 2.4-10.2l5.6-19.8H65v39.4z"}))}function k({children:e,onSelectMedia:t,onError:l}){return(0,n.createElement)(i.MediaPlaceholder,{icon:(0,n.createElement)(i.BlockIcon,{icon:C}),labels:{title:(0,c.__)("AM Lottie Animation","am-lottieplayer"),instructions:(0,c.__)("Upload Lottie animations to WordPress and add them in Gutenberg.","am-lottieplayer")},onHTMLDrop:t,onSelect:t,accept:".lottie, .json",allowedTypes:["application/json","application/zip"],onError:l},e)}function S({attributes:e,clientId:t}){const{align:l,alt:a,autoplay:r,background:o,controls:i,direction:s,height:c,loop:d,mode:m,objectFit:p,renderer:g,segment:y,speed:f,src:h,subframe:b,width:v}=e,{getBlockIndex:_}=(0,u.useSelect)((e=>e("core/block-editor")),[]),E=_(t),w=(0,n.useRef)(null),C=(0,n.useRef)(!0),k=y&&y?.[1]?JSON.stringify([y[0],y[1]]):void 0,S=(0,n.useCallback)((()=>{w.current&&(w.current.reload&&w.current.reload(),setTimeout((()=>{const e=w.current?.shadowRoot?.querySelector("canvas");"svg"===g&&e?.remove()}),100))}),[g]),x=e=>e&&"number"==typeof e?`${e}px`:null;return(0,n.useEffect)((()=>{C.current||S(),C.current=!1}),[r,E,s,d,m,p,S,g,y,f,b]),(0,n.createElement)("dotlottie-player",{id:t,class:"lottie-element",autoplay:r?"":null,controls:i?"":null,description:a,direction:s,loop:d?"":null,mode:m,objectfit:p,ref:w,renderer:g,segment:k,speed:f,subframe:b?"":null,src:h,style:{width:(N=v,"wide"===l||"full"===l?"100%":x(N)),height:x(c),backgroundColor:o,margin:"0 auto"}});var N}function x({attributes:e,clientId:t,isPlaceholder:l,setAttributes:a}){return(0,n.createElement)(n.Fragment,null,l?(0,n.createElement)(k,{onSelectMedia:({id:e,url:t,alt:l})=>{if(!t)return a({src:void 0,id:void 0});a({src:t,id:e?.toString(),alt:l})},onError:e=>{(e=>{(0,n.createElement)(s.Notice,{status:"error"},e)})(e)},children:void 0}):(0,n.createElement)(S,{attributes:e,clientId:t}))}function N({children:e,className:t,fullscreen:l,onResizeStart:a,onResize:r,onResizeStop:i,showHandle:c,...u}){const[d,m]=(0,n.useState)(!1);return(0,n.createElement)(s.ResizableBox,{className:o()(t,{"is-resizing":d}),enable:{bottom:!l},minHeight:10,onResizeStart:a,onResize:(e,t,l)=>{r(l.clientHeight),d||m(!0)},onResizeStop:(e,t,l)=>{i(l.clientHeight),m(!1)},showHandle:c,...u},e)}var P=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"gb/lottiecover","title":"AM LottieCover","category":"media","description":"Add a Lottie animation with a text overlay — great for headers.","keywords":["animation","gif","motion","vector","SVG","Lottie","dotLottie"],"textdomain":"am-lottieplayer","attributes":{"align":{"type":"string","default":"full"},"allowedBlocks":{"type":"array","default":["core/paragraph","core/heading","core/buttons"]},"alt":{"type":"string","source":"attribute","selector":"dotlottie-player","attribute":"description","default":"","__experimentalRole":"content"},"autoplay":{"type":"boolean","source":"attribute","selector":"dotlottie-player","attribute":"autoplay","default":true},"controls":{"type":"boolean","source":"attribute","selector":"dotlottie-player","attribute":"controls"},"content":{"type":"string","default":""},"contentPosition":{"type":"string","default":""},"clickEvent":{"type":"boolean","default":false},"dimRatio":{"type":"number","default":50},"direction":{"type":"number","default":1},"focalPoint":{"type":"object","default":{}},"fullscreen":{"type":"boolean","default":false},"hasParallax":{"type":"boolean","default":false},"height":{"type":"number","default":null},"heightUnit":{"type":"string","default":"px"},"hover":{"type":"boolean","default":false},"id":{"type":"string","default":null},"isDark":{"type":"boolean","default":true},"loop":{"type":"boolean","source":"attribute","selector":"dotlottie-player","attribute":"loop","default":true},"mode":{"type":"string","default":"normal"},"objectFit":{"type":"string","default":"cover"},"once":{"type":"boolean","default":false},"overlayColor":{"type":"string","default":"transparent"},"mouseOut":{"type":"string","default":"stop"},"renderer":{"type":"string","default":"svg"},"scrollEvent":{"type":"boolean","default":false},"scrollDelay":{"type":"number","default":null},"segment":{"type":"array","default":null},"selector":{"type":"object","default":{"id":null,"exclude":false}},"speed":{"type":"number","default":1},"src":{"type":"string","default":""},"subframe":{"type":"boolean","default":true},"templateLock":{"type":["string","boolean"],"enum":["all","insert","contentOnly",false]},"width":{"type":"number","default":null}},"supports":{"anchor":true,"align":true,"html":false,"spacing":{"padding":true,"margin":["top","bottom"],"__experimentalDefaultControls":{"padding":true,"margin":true}},"color":{"text":false,"background":false},"typography":{"fontSize":true,"lineHeight":true,"__experimentalFontFamily":true,"__experimentalFontWeight":true,"__experimentalFontStyle":true,"__experimentalTextTransform":true,"__experimentalTextDecoration":true,"__experimentalLetterSpacing":true,"__experimentalDefaultControls":{"fontSize":true}}},"editorScript":"file:./index.js","editorStyle":"file:./index.css","style":"file:./style-index.css"}');(0,a.registerBlockType)(P,{icon:C,edit:function({attributes:e,className:t,clientId:l,context:a,isSelected:r,setAttributes:d,toggleSelection:m}){const{allowedBlocks:p=["core/paragraph","core/heading","core/buttons"],background:y,fullscreen:f,height:h,heightUnit:b="px",id:v,src:_,templateLock:E}=e,C=((e,t)=>!e&&(0,g.isBlobURL)(t))(v,_),k=(0,n.useRef)(),[S,P]=(0,n.useState)(!0),B=(0,i.useBlockProps)({ref:k}),R={minHeight:f?"100vh":(h&&b?`${h}${b}`:h)||void 0},A=(0,u.useSelect)((e=>!!e(i.store)?.getBlock(l)?.innerBlocks?.length),[l]),O=(e=>[["core/paragraph",{align:"center",placeholder:(0,c.__)("Write title…","am-lottieplayer"),...e}]])({fontSize:(0,i.useSetting)("typography.fontSizes")?.length?"large":void 0}),I=(0,i.useInnerBlocksProps)({className:"wp-block-gb-lottiecover__inner-container"},{template:A?void 0:O,templateInsertUpdatesSelection:!0,allowedBlocks:p,templateLock:E});return(0,n.useEffect)((()=>{P(!_||""===_)}),[_]),(0,n.createElement)(n.Fragment,null,(0,n.createElement)(w,{attributes:e,setAttributes:d,clientId:l,isSelected:!1,context:a,className:t}),(0,n.createElement)("div",{...B,className:o()({"is-placeholder":S},B.className),style:{...R,...B.style}},(0,n.createElement)(N,{className:"block-library-lottiecover__resize-container",fullscreen:f,onResizeStart:()=>{d({heightUnit:"px"}),m&&m(!1)},onResize:e=>{d({height:e})},onResizeStop:e=>{d({height:e}),m&&m(!0)},showHandle:r}),(0,n.createElement)("span",{"aria-hidden":"true",className:"wp-block-gb-lottiecover__background",style:{backgroundColor:y},hidden:S}),C&&(0,n.createElement)(s.Spinner,null),(0,n.createElement)(x,{attributes:e,setAttributes:d,isPlaceholder:S,clientId:l,isSelected:!1,context:a,className:t}),!S&&(0,n.createElement)("div",{...I})))},save:function({attributes:e}){const{align:t,alt:l,autoplay:a,background:r,controls:o,clickEvent:s,direction:c,fullscreen:u,height:d,heightUnit:m,hover:p,loop:g,mode:y,mouseout:f,objectFit:h,once:b,renderer:v,scrollEvent:_,scrollDelay:E,segment:w,selector:C,speed:k,src:S,subframe:x,width:N}=e,P={minHeight:u?"100vh":(d&&m?`${d}${m}`:d)||void 0},B=JSON.stringify(C),R=w&&w?.[1]?JSON.stringify([w[0],w[1]]):void 0;return(0,n.createElement)("div",{...i.useBlockProps.save({style:P})},(0,n.createElement)("span",{"aria-hidden":"true",className:"wp-block-gb-lottiecover__background",style:{backgroundColor:r}}),(0,n.createElement)("dotlottie-player",{class:"lottie-element"+(C?.id?" has-selector":""),autoplay:a?"":null,controls:o?"":null,description:l,direction:c,"data-direction":c,"data-mouseover":p,"data-mouseout":f,"data-click":s,"data-delay":E,"data-scroll":_,"data-selector":B,"data-once":b,loop:g?"":null,mode:y,objectfit:h,renderer:v,segment:R,speed:k,src:S,style:{width:(A=N,"wide"===t||"full"===t?"100%":A&&"number"==typeof A?`${A}px`:null),height:d&&"number"==typeof d?`${d}px`:null,backgroundColor:r},subframe:x?"":null}),(0,n.createElement)("div",{...i.useInnerBlocksProps.save({className:"wp-block-gb-lottiecover__inner-container"})}));var A}})},184:function(e,t){var l;!function(){"use strict";var a={}.hasOwnProperty;function n(){for(var e=[],t=0;t<arguments.length;t++){var l=arguments[t];if(l){var r=typeof l;if("string"===r||"number"===r)e.push(l);else if(Array.isArray(l)){if(l.length){var o=n.apply(null,l);o&&e.push(o)}}else if("object"===r){if(l.toString!==Object.prototype.toString&&!l.toString.toString().includes("[native code]")){e.push(l.toString());continue}for(var i in l)a.call(l,i)&&l[i]&&e.push(i)}}}return e.join(" ")}e.exports?(n.default=n,e.exports=n):void 0===(l=function(){return n}.apply(t,[]))||(e.exports=l)}()}},l={};function a(e){var n=l[e];if(void 0!==n)return n.exports;var r=l[e]={exports:{}};return t[e](r,r.exports,a),r.exports}a.m=t,e=[],a.O=function(t,l,n,r){if(!l){var o=1/0;for(u=0;u<e.length;u++){l=e[u][0],n=e[u][1],r=e[u][2];for(var i=!0,s=0;s<l.length;s++)(!1&r||o>=r)&&Object.keys(a.O).every((function(e){return a.O[e](l[s])}))?l.splice(s--,1):(i=!1,r<o&&(o=r));if(i){e.splice(u--,1);var c=n();void 0!==c&&(t=c)}}return t}r=r||0;for(var u=e.length;u>0&&e[u-1][2]>r;u--)e[u]=e[u-1];e[u]=[l,n,r]},a.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return a.d(t,{a:t}),t},a.d=function(e,t){for(var l in t)a.o(t,l)&&!a.o(e,l)&&Object.defineProperty(e,l,{enumerable:!0,get:t[l]})},a.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},function(){var e={841:0,560:0};a.O.j=function(t){return 0===e[t]};var t=function(t,l){var n,r,o=l[0],i=l[1],s=l[2],c=0;if(o.some((function(t){return 0!==e[t]}))){for(n in i)a.o(i,n)&&(a.m[n]=i[n]);if(s)var u=s(a)}for(t&&t(l);c<o.length;c++)r=o[c],a.o(e,r)&&e[r]&&e[r][0](),e[r]=0;return a.O(u)},l=self.webpackChunkam_lottieplayer=self.webpackChunkam_lottieplayer||[];l.forEach(t.bind(null,0)),l.push=t.bind(null,l.push.bind(l))}();var n=a.O(void 0,[560],(function(){return a(960)}));n=a.O(n)}();