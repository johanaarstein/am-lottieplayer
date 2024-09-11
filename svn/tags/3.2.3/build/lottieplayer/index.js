(()=>{"use strict";const e=window.wp.blocks,t=window.wp.blockEditor,l=window.wp.components,a=window.wp.element,i=window.ReactJSXRuntime,n=(0,a.createContext)({setAnimationContext:e=>e,animationContext:{player:null,animations:[]}}),o=()=>(0,a.useContext)(n);function s({children:e}){const[t,l]=(0,a.useState)({player:null,animations:[]});return(0,i.jsx)(n.Provider,{value:{animationContext:t,setAnimationContext:l},children:e})}const r=window.wp.i18n;function c(){return(0,i.jsx)(i.Fragment,{children:(0,i.jsxs)("a",{href:(0,r.__)("https://www.aarstein.media/en/am-lottieplayer/pro","am-lottieplayer"),target:"_blank",rel:"noreferrer",style:{color:"white",fontSize:".75rem",textDecoration:"none",textTransform:"none",backgroundColor:"var(--wp-admin-theme-color)",display:"inline-block",padding:".5em 1em",borderRadius:"1.5em"},children:[(0,i.jsx)("strong",{children:"PRO"})," ",(0,r.__)("feature","am-lottieplayer")]})})}function d(){return(0,i.jsxs)("a",{href:(0,r.__)("https://www.aarstein.media/en/am-lottieplayer/pro","am-lottieplayer"),target:"_blank",rel:"noreferrer",children:[(0,r.__)("Read about additional features in AM LottiePlayer PRO","am-lottieplayer"),(0,i.jsx)("sup",{style:{verticalAlign:"super"},children:(0,i.jsx)("span",{className:"dashicons dashicons-external",style:{fontSize:"1em"}})})]})}const u=({attributes:e,setAttributes:a})=>{const{alt:n}=e;return(0,i.jsxs)(t.InspectorAdvancedControls,{children:[(0,i.jsx)(l.SelectControl,{label:(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)("span",{className:"pro-feature",style:{marginRight:"1em"},children:(0,r.__)("Renderer")}),(0,i.jsx)(c,{})]}),help:(0,i.jsx)(d,{}),disabled:!0,value:"svg",onChange:()=>console.warn("This feature is only available in the premium version"),options:[{value:"svg",label:"SVG"},{value:"canvas",label:"Canvas"}]}),(0,i.jsx)(l.TextareaControl,{label:(0,r.__)("Description","am-lottieplayer"),help:(0,r.__)("Describe the animation. This is helpful for screen readers and search engines.","am-lottieplayer"),value:n,onChange:e=>a({alt:e})})]})},m=window.wp.blob;let p=function(e){return e.Center="center",e.Full="full",e.Left="left",e.None="none",e.Right="right",e.Wide="wide",e}({}),h=function(e){return e.Void="void",e.Stop="stop",e.Pause="pause",e.Reverse="reverse",e}({});const y=({className:e="",id:t="",onChange:a,subTitle:n,title:o,value:s,disabled:r})=>(0,i.jsxs)(l.BaseControl,{id:t,help:n,className:`lottie-switch-label ${e}`,children:[(0,i.jsx)(l.BaseControl.VisualLabel,{children:o}),(0,i.jsx)(l.FormToggle,{checked:s,onChange:()=>a(!s),disabled:r})]}),g=({id:e="",onChange:t,title:a,value:n="",disabled:o,placeholder:s=""})=>(0,i.jsx)(l.BaseControl,{id:e,help:a,className:"lottie-number-wrapper",children:(0,i.jsx)(l.TextControl,{value:n,onChange:e=>{t(void 0===e||""===e?void 0:Number(e))},onKeyDown:e=>{(({ctrlKey:e,key:t,metaKey:l,shiftKey:a})=>!(!a&&"End"!==t&&"Home"!==t&&"Backspace"!==t&&"Tab"!==t&&"Enter"!==t&&"Delete"!==t&&(!e&&!l||"a"!==t&&"c"!==t&&"v"!==t&&"x"!==t&&"z"!==t&&"t"!==t&&"r"!==t)))(e)||(({key:e})=>Number(e)>=0&&Number(e)<=9)(e)||e.preventDefault()},disabled:o,placeholder:s})}),b=({id:e="",onChange:t,title:a,help:n,value:o="",placeholder:s="",disabled:r})=>(0,i.jsxs)(l.BaseControl,{id:e,help:n,className:"lottie-number-wrapper",children:[(0,i.jsx)(l.BaseControl.VisualLabel,{children:a}),(0,i.jsx)(l.TextControl,{value:o,disabled:r,onChange:e=>t(e),placeholder:s})]}),x=({attributes:e,setAttributes:t})=>{const{autoplay:n,controls:s,direction:u,loop:m,segment:p,speed:h=1,subframe:b}=e,{animationContext:{animations:x,player:f}}=o(),[v,j]=(0,a.useState)({totalFrames:0,hasMultipleAnimations:!1});return(0,a.useEffect)((()=>{var e;f&&j({totalFrames:Number(null!==(e=f.getLottie()?.totalFrames)&&void 0!==e?e:0),hasMultipleAnimations:x?.length>1})}),[x?.length,f]),(0,i.jsx)(l.Panel,{children:(0,i.jsxs)(l.PanelBody,{title:(0,r.__)("Animation Settings","am-lottieplayer"),className:"am-lottieplayer-settings",initialOpen:!0,children:[v.hasMultipleAnimations&&(0,i.jsxs)("div",{style:{marginBottom:"1em"},children:[(0,i.jsx)("p",{children:(0,i.jsx)(c,{})}),(0,i.jsx)("p",{children:(0,r.__)("This file contains multiple animations. To control each of them individually you need to upgrade to AM LottiePlayer PRO.","am-lottieplayer")})]}),(0,i.jsx)(y,{id:"am-lottieplayer-controls-settings",title:(0,r.__)("Show controls","am-lottieplayer"),value:!!s,onChange:e=>t({controls:e})}),(0,i.jsx)(y,{id:"am-lottieplayer-autoplay-settings",title:(0,r.__)("Autoplay","am-lottieplayer"),value:!!n,onChange:e=>{t({autoplay:e})}}),(0,i.jsx)(y,{id:"am-lottieplayer-loop-settings",title:(0,r.__)("Loop","am-lottieplayer"),value:!!m,onChange:e=>{t({loop:e})}}),(0,i.jsx)(y,{id:"am-lottieplayer-playmode-settings",title:(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)("span",{className:"pro-feature",style:{marginRight:"1em"},children:(0,r.__)("Boomerang","am-lottieplayer")}),(0,i.jsx)(c,{})]}),value:!1,disabled:!0,onChange:()=>console.warn("This feature is only available in the premium version")}),(0,i.jsx)(y,{id:"am-lottieplayer-reverse-settings",title:(0,r.__)("Reverse","am-lottieplayer"),value:-1===u,onChange:e=>t({direction:e?-1:1})}),(0,i.jsx)(y,{id:"am-lottieplayer-subframe-settings",title:(0,r.__)("Subframe","am-lottieplayer"),subTitle:(0,r.__)("Makes the animation smoother, at the cost of RAM usage","am-lottieplayer"),value:!!b,onChange:e=>t({subframe:e})}),(0,i.jsx)(l.RangeControl,{label:(0,r.__)("Speed","am-lottieplayer"),min:.5,max:5,step:.5,value:h,onChange:e=>t({speed:e})}),(0,i.jsxs)(l.BaseControl.VisualLabel,{children:[(0,i.jsx)("p",{children:(0,i.jsx)(c,{})}),(0,i.jsx)("span",{className:"pro-feature",children:(0,r.__)("Play only part of the animation","am-lottieplayer")})]}),(0,i.jsxs)(l.PanelRow,{className:"lottie-segment",children:[(0,i.jsx)(g,{id:"am-lottieplayer-segment-in",title:(0,r.__)("First frame","am-lottieplayer"),value:p?.[0],disabled:!0,onChange:()=>console.warn("This feature is only available in the premium version"),placeholder:"1"}),(0,i.jsx)(g,{id:"am-lottieplayer-segment-out",title:(0,r.__)("Last frame","am-lottieplayer"),value:p?.[1],disabled:!0,onChange:()=>console.warn("This feature is only available in the premium version"),placeholder:(v.totalFrames+1).toString()})]}),(0,i.jsx)(d,{})]})})},f=({attributes:e,setAttributes:t})=>{const{background:a}=e;return(0,i.jsx)(l.Panel,{children:(0,i.jsx)(l.PanelBody,{title:(0,r.__)("Background Color","am-lottieplayer"),className:"am-lottieplayer-settings",initialOpen:!1,children:(0,i.jsx)(l.ColorPicker,{color:a,onChange:e=>t({background:e})})})})},v=({attributes:e,setAttributes:t})=>{const{clickEvent:a,hover:n,mouseout:o,once:s,scrollEvent:u,scrollDelay:m,selector:p}=e;return(0,i.jsx)(l.Panel,{children:(0,i.jsxs)(l.PanelBody,{className:"am-lottieplayer-settings",title:(0,r.__)("Interactions","am-lottieplayer"),initialOpen:!0,children:[(0,i.jsx)(y,{id:"am-lottieplayer-animateOnScroll-settings",title:(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)("span",{className:"pro-feature",style:{marginRight:"1em"},children:(0,r.__)("Animate on scroll","am-lottieplayer")}),(0,i.jsx)(c,{})]}),value:!1,disabled:!0,onChange:()=>console.warn("This feature is only available in the premium version")}),(0,i.jsx)(y,{id:"am-lottieplayer-click-settings",title:(0,r.__)("Play on click","am-lottieplayer"),value:a,onChange:e=>t({clickEvent:e})}),(0,i.jsx)(y,{id:"am-lottieplayer-hover-settings",title:(0,r.__)("Play on mouseover","am-lottieplayer"),value:n,onChange:e=>t({hover:e})}),n&&(0,i.jsx)(l.SelectControl,{label:(0,r.__)("On mouseout","am-lottieplayer"),value:o,onChange:e=>t({mouseout:e}),options:[{value:h.Void,label:(0,r.__)("No event","am-lottieplayer")},{value:h.Stop,label:(0,r.__)("Stop","am-lottieplayer")},{value:h.Pause,label:(0,r.__)("Pause","am-lottieplayer")},{value:h.Reverse,label:(0,r.__)("Reverse","am-lottieplayer")}]}),(n||a)&&(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)(b,{id:"am-lottieplayer-settings",title:(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)("span",{className:"pro-feature",style:{marginRight:"1em"},children:(0,r.__)("Trigger element","am-lottieplayer")}),(0,i.jsx)(c,{})]}),help:(0,r.__)("Anchor tag (id) for an element you want to trigger the animation, either by hover or click.","am-lottieplayer"),placeholder:"#",value:p?.id,disabled:!0,onChange:e=>t({selector:{...p,id:e}})}),(0,i.jsx)(y,{id:"am-lottieplayer-selector-settings",title:(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)("span",{className:"pro-feature",style:{display:"block",marginBottom:"1em"},children:(0,r.__)("Apply interaction only to trigger element","am-lottieplayer")}),(0,i.jsx)(c,{})]}),value:p?.exclude,disabled:!0,onChange:e=>t({selector:{...p,exclude:e}})})]}),(0,i.jsx)(y,{id:"am-lottieplayer-scroll-settings",title:(0,r.__)("Play on scroll, when visible in viewport","am-lottieplayer"),value:u,onChange:e=>t({scrollEvent:e})}),u&&(0,i.jsxs)(i.Fragment,{children:[(0,i.jsx)(y,{id:"am-lottieplayer-once-settings",title:(0,r.__)("Play only once","am-lottieplayer"),value:s,onChange:e=>t({once:e})}),(0,i.jsx)(l.RangeControl,{label:(0,r.__)("Delay, in 10th of a second","am-lottieplayer"),min:0,max:50,step:1,value:null!=m?m:1,onChange:e=>t({scrollDelay:e})})]}),(0,i.jsx)(d,{})]})})},j=({attributes:e,setAttributes:t})=>{const{align:n,fullscreen:o,height:s,objectFit:c="contain",width:d}=e,u=(0,a.useCallback)((e=>n===p.Full||n===p.Wide?"100%":e&&"0"!==e?e:void 0),[n]);return(0,i.jsx)(l.Panel,{children:(0,i.jsxs)(l.PanelBody,{title:(0,r.__)("Dimensions","am-lottieplayer"),className:"am-lottieplayer-settings",initialOpen:!0,children:[(!o||n!==p.Full)&&(0,i.jsxs)(l.PanelRow,{className:"lottie-dimensions",children:[(0,i.jsx)(g,{id:"am-lottieplayer-width-settings",title:(0,r.__)("Width","am-lottieplayer"),value:u(d),onChange:e=>t({width:null!=e?e:null}),disabled:n===p.Full||n===p.Wide,placeholder:n===p.Full||n===p.Wide?"100%":"auto"}),(0,i.jsx)(g,{id:"am-lottieplayer-height-settings",title:(0,r.__)("Height","am-lottieplayer"),value:s&&"0"!==s.toString()?s:void 0,disabled:o,onChange:e=>t({height:e}),placeholder:"auto"})]}),(n===p.Full||n===p.Wide)&&(0,i.jsx)(y,{id:"am-lottieplayer-fullscreen-settings",title:(0,r.__)("Fill screen","am-lottieplayer"),value:o,onChange:e=>t({fullscreen:e})}),(0,i.jsx)(l.SelectControl,{label:(0,r.__)("Object fit"),value:c,onChange:e=>{t({objectFit:e})},options:[{value:"contain",label:(0,r.__)("Contain","am-lottieplayer")},{value:"cover",label:(0,r.__)("Cover","am-lottieplayer")},{value:"fill",label:(0,r.__)("Fill","am-lottieplayer")},{value:"none",label:(0,r.__)("None","am-lottieplayer")}]})]})})};function _({attributes:e,className:l,clientId:n,context:s,isSelected:r,setAttributes:c}){const d=(0,a.useId)(),{animationContext:{animations:m},setAnimationContext:p}=o();return m.length||p((t=>{var l;return{...t,animations:[{id:null!==(l=e.id)&&void 0!==l?l:d,autoplay:e.autoplay,loop:e.loop,direction:e.direction,mode:e.mode,speed:e.speed}]}})),(0,i.jsxs)(t.InspectorControls,{children:[(0,i.jsx)(x,{attributes:e,setAttributes:c,clientId:n,isSelected:r,context:s,className:l}),(0,i.jsx)(v,{attributes:e,setAttributes:c,clientId:n,isSelected:r,context:s,className:l}),(0,i.jsx)(j,{attributes:e,setAttributes:c,clientId:n,isSelected:r,context:s,className:l}),(0,i.jsx)(f,{attributes:e,setAttributes:c,clientId:n,isSelected:r,context:s,className:l}),(0,i.jsx)(u,{attributes:e,setAttributes:c,clientId:n,isSelected:r,context:s,className:l})]})}function C(){return(0,i.jsxs)(l.SVG,{role:"img",xmlns:"http://www.w3.org/2000/svg",xmlSpace:"preserve",viewBox:"0 0 80 80",children:[(0,i.jsx)("style",{children:"\n\t\t\t\t.am-lottieplayer-path {\n\t\t\t\t\tfill: url(#a)\n\t\t\t\t}\n\t\t\t\t.block-editor-block-toolbar .am-lottieplayer-path,\n\t\t\t\t.components-panel .am-lottieplayer-path {\n\t\t\t\t\tfill: var(--wp-admin-theme-color-darker-10)\n\t\t\t\t}"}),(0,i.jsx)("defs",{children:(0,i.jsxs)("radialGradient",{id:"a",cx:".2",cy:"1.07",r:"1.2",children:[(0,i.jsx)("stop",{offset:"10%",children:(0,i.jsx)("animate",{attributeName:"stop-color",values:"#24708f;#e18d4c;#1f374c;#85c6e0;#24708f;",dur:"12s",repeatCount:"indefinite"})}),(0,i.jsx)("stop",{offset:"90%",children:(0,i.jsx)("animate",{attributeName:"stop-color",values:"#85c6e0;#24708f;#e18d4c;#1f374c;#85c6e0;",dur:"24s",repeatCount:"indefinite"})})]})}),(0,i.jsx)(l.Path,{className:"am-lottieplayer-path",d:"M60 0H20C9 0 0 9 0 20v39.5C0 71 9 80 20 80h39.5c11 0 20.5-9 20.5-20V20C80 9 71 0 60 0zm4.9 59.7h-7.4V37.1c0-3.2.3-8.2.3-8.2h-.1s-.9 4.7-1.7 7.5l-6.8 23.3h-4l-11-30.2c-.8-2.2-2-5.8-2-5.8h-.1s-1.1 3.4-1.9 5.8L18.7 59.7H15l15-39.4h4.2l11.4 30c.3-1.4 1.2-6.1 2.4-10.2l5.6-19.8H65v39.4z"})]})}function w({children:e,onSelectMedia:l,onError:n}){const[o,s]=(0,a.useState)(!1);return(0,i.jsx)(t.MediaPlaceholder,{icon:(0,i.jsx)(t.BlockIcon,{icon:C}),labels:{title:(0,r.__)("AM Lottie Animation","am-lottieplayer"),instructions:o?(0,r.__)("Dropped!","am-lottieplayer"):(0,r.__)("Upload Lottie animations to WordPress and add them in Gutenberg.","am-lottieplayer")},onHTMLDrop:()=>s(!0),onSelect:l,accept:".lottie, .json",allowedTypes:["application/json","application/zip"],onError:n,children:e})}const S=window.wp.data;function k({attributes:e,clientId:t}){var l;const{animationContext:{player:n},setAnimationContext:s}=o(),{segment:r}=e,{getBlockIndex:c}=(0,S.useSelect)((e=>e("core/block-editor")),[]),d=c(t),u=(0,a.useRef)(!0),m=(0,a.useRef)(null),h=r&&r?.[1]?JSON.stringify([r[0],r[1]]):void 0,y=(0,a.useCallback)((()=>{n&&n.reload()}),[n]),g=e=>{if(e&&"number"==typeof e)return`${e}px`};return(0,a.useEffect)((()=>{m.current&&s((e=>({...e,player:m.current})))}),[s]),(0,a.useEffect)((()=>{n&&n.addEventListener("ready",(()=>{s((e=>{var t;return{...e,animations:null!==(t=n.getManifest()?.animations)&&void 0!==t?t:[]}}))}))}),[n,s]),(0,a.useEffect)((()=>{u.current||y(),u.current=!1}),[d,e.objectFit,y,r]),(0,i.jsx)("dotlottie-player",{id:t,class:"lottie-element",autoplay:e.autoplay?"":null,controls:e.controls?"":null,description:e.alt,direction:e.direction,loop:e.loop?"":null,mode:e.mode,objectfit:e.objectFit,ref:m,segment:h,speed:e.speed,subframe:e.subframe?"":null,src:null!==(l=e.src)&&void 0!==l?l:"",style:{width:(b=e.width,e.align===p.Wide||e.align===p.Full?"100%":g(b)),height:g(e.height),backgroundColor:e.background,margin:"0 auto"}});var b}function N({attributes:e,clientId:n,setAttributes:o}){const[s,r]=(0,a.useState)(!0),[c,d]=(0,a.useState)("");return(0,a.useEffect)((()=>{r(!e.src||""===e.src)}),[e.src]),(0,a.useEffect)((()=>{var e;e=c,new RegExp("^(https?:\\/\\/)?((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|((\\d{1,3}\\.){3}\\d{1,3}))(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*(\\?[;&a-z\\d%_.~+=-]*)?(\\#[-a-z\\d_]*)?$","i").test(e)&&(c.endsWith(".lottie")||c.endsWith(".json"))&&o({src:c})}),[c,o]),(0,i.jsx)(i.Fragment,{children:s?(0,i.jsx)(w,{onSelectMedia:({id:e,url:t,alt:l})=>{if(!t)return o({src:void 0,id:void 0});o({src:t,id:e?.toString(),alt:l})},onError:e=>{l.Notice},children:(0,i.jsx)(t.URLInput,{value:c,onChange:e=>d(e)})}):(0,i.jsx)(k,{attributes:e,clientId:n})})}const A=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","apiVersion":2,"name":"gb/lottieplayer","title":"AM LottiePlayer","description":"Play Lottie animations on your WordPress website.","keywords":["animation","gif","motion","vector","SVG","Lottie","dotLottie"],"category":"media","supports":{"align":true,"anchor":true,"html":false},"textdomain":"am-lottieplayer","attributes":{"align":{"enum":["center","full","none","left","right","wide"],"default":"none"},"alt":{"type":"string","default":""},"autoplay":{"type":"boolean"},"background":{"type":"string","default":"transparent"},"controls":{"type":"boolean","default":true},"clickEvent":{"type":"boolean","default":false},"direction":{"type":"number","default":1},"height":{"type":"number","default":null},"hover":{"type":"boolean","default":false},"id":{"type":"string"},"loop":{"type":"boolean"},"mode":{"enum":["bounce","normal"],"default":"normal"},"mouseout":{"type":"string","default":"stop"},"multiAnimationInteractions":{"type":"array"},"multiAnimationSettings":{"type":"array"},"objectFit":{"type":"string","default":"contain"},"once":{"type":"boolean","default":false},"renderer":{"enum":["svg"],"default":"svg"},"scrollEvent":{"type":"boolean","default":false},"scrollDelay":{"type":"number","default":null},"segment":{"type":"array","default":null},"selector":{"type":"object","default":{"id":null,"exclude":false}},"speed":{"type":"number","default":1},"src":{"type":"string","default":""},"subframe":{"type":"boolean","default":true},"width":{"type":"number","default":null}},"editorScript":"file:./index.js","editorStyle":"file:./index.css"}');(0,e.registerBlockType)(A,{icon:C,edit:function({attributes:e,className:a,clientId:n,context:o,isSelected:r,setAttributes:c}){const d=(u=e.id,p=e.src||void 0,!u&&(0,m.isBlobURL)(p));var u,p;return(0,i.jsxs)(s,{children:[(0,i.jsx)(_,{attributes:e,setAttributes:c,clientId:n,isSelected:r,context:o,className:a}),d&&(0,i.jsx)(l.Spinner,{}),(0,i.jsx)("div",{...(0,t.useBlockProps)(),children:(0,i.jsx)(N,{attributes:e,setAttributes:c,clientId:n,isSelected:r,context:o,className:a})})]})},save:function({attributes:e}){var l;const a=JSON.stringify(e.selector),n=e.segment&&e.segment?.[1]?JSON.stringify([e.segment[0],e.segment[1]]):void 0;return(0,i.jsx)("figure",{id:e.id,...t.useBlockProps.save({className:`align${null!==(l=e.align)&&void 0!==l?l:"none"}`}),style:{backgroundColor:e.background,height:e.height&&0!==e.height?e.height:"auto",width:e.width&&0!==e.width?e.width:"auto",margin:"0 auto"},children:(0,i.jsx)("dotlottie-player",{class:"lottie-element"+(e.selector?.id?" has-selector":""),autoplay:e.autoplay&&!e.scrollEvent?"":null,controls:e.controls?"":null,description:e.alt,direction:e.direction,"data-direction":e.direction,"data-mouseover":e.hover,"data-mouseout":e.mouseout,"data-click":e.clickEvent,"data-scroll":e.scrollEvent,"data-delay":e.scrollDelay,"data-selector":a,"data-once":e.once,loop:e.loop?"":null,mode:e.mode,multiAnimationSettings:[],objectfit:e.objectFit,segment:n,src:e.src,speed:e.speed,subframe:e.subframe?"":null})})}})})();