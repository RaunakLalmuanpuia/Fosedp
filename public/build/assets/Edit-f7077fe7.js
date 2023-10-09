import{Q as be,a as I}from"./QBreadcrumbs-f1fcde01.js";import{z as K,aV as he,aW as A,aX as Z,ac as ge,aY as J,aZ as ye,a_ as B,a$ as L,b0 as ee,K as U,b1 as Pe,b2 as F,h as W,T as k,ad as Ce,L as xe,I as ce,G as V,b3 as _e,a7 as ke,H as X,b4 as Te,O as we,R as Se,U as Ve,a1 as qe,v as De,r as Qe,o as E,e as z,a as w,d as r,w as m,F as M,m as te,u as _,Q as $,l as Ae,p as ae,n as ne,c as se,s as re,x as S,y as O,k as R,t as Y,aw as oe}from"./app-a7abb58d.js";import{u as Ee,a as Ne,b as Be,Q as $e}from"./QTabs-e58d4627.js";import{Q as le}from"./QChip-85d4182d.js";import{Q as Ie}from"./QForm-ea84dcf4.js";import"./rtl-36dd996b.js";const ie=K({name:"QTab",props:Ee,emits:Ne,setup(t,{slots:a,emit:o}){const{renderTab:i}=Be(t,a,o);return()=>i("div")}});function Le(t){const a=[.06,6,50];return typeof t=="string"&&t.length&&t.split(":").forEach((o,i)=>{const u=parseFloat(o);u&&(a[i]=u)}),a}const Ue=he({name:"touch-swipe",beforeMount(t,{value:a,arg:o,modifiers:i}){if(i.mouse!==!0&&A.has.touch!==!0)return;const u=i.mouseCapture===!0?"Capture":"",e={handler:a,sensitivity:Le(o),direction:Z(i),noop:ge,mouseStart(n){J(n,e)&&ye(n)&&(B(e,"temp",[[document,"mousemove","move",`notPassive${u}`],[document,"mouseup","end","notPassiveCapture"]]),e.start(n,!0))},touchStart(n){if(J(n,e)){const v=n.target;B(e,"temp",[[v,"touchmove","move","notPassiveCapture"],[v,"touchcancel","end","notPassiveCapture"],[v,"touchend","end","notPassiveCapture"]]),e.start(n)}},start(n,v){A.is.firefox===!0&&L(t,!0);const b=ee(n);e.event={x:b.left,y:b.top,time:Date.now(),mouse:v===!0,dir:!1}},move(n){if(e.event===void 0)return;if(e.event.dir!==!1){U(n);return}const v=Date.now()-e.event.time;if(v===0)return;const b=ee(n),d=b.left-e.event.x,f=Math.abs(d),y=b.top-e.event.y,p=Math.abs(y);if(e.event.mouse!==!0){if(f<e.sensitivity[1]&&p<e.sensitivity[1]){e.end(n);return}}else if(f<e.sensitivity[2]&&p<e.sensitivity[2])return;const h=f/v,P=p/v;e.direction.vertical===!0&&f<p&&f<100&&P>e.sensitivity[0]&&(e.event.dir=y<0?"up":"down"),e.direction.horizontal===!0&&f>p&&p<100&&h>e.sensitivity[0]&&(e.event.dir=d<0?"left":"right"),e.direction.up===!0&&f<p&&y<0&&f<100&&P>e.sensitivity[0]&&(e.event.dir="up"),e.direction.down===!0&&f<p&&y>0&&f<100&&P>e.sensitivity[0]&&(e.event.dir="down"),e.direction.left===!0&&f>p&&d<0&&p<100&&h>e.sensitivity[0]&&(e.event.dir="left"),e.direction.right===!0&&f>p&&d>0&&p<100&&h>e.sensitivity[0]&&(e.event.dir="right"),e.event.dir!==!1?(U(n),e.event.mouse===!0&&(document.body.classList.add("no-pointer-events--children"),document.body.classList.add("non-selectable"),Pe(),e.styleCleanup=T=>{e.styleCleanup=void 0,document.body.classList.remove("non-selectable");const x=()=>{document.body.classList.remove("no-pointer-events--children")};T===!0?setTimeout(x,50):x()}),e.handler({evt:n,touch:e.event.mouse!==!0,mouse:e.event.mouse,direction:e.event.dir,duration:v,distance:{x:f,y:p}})):e.end(n)},end(n){e.event!==void 0&&(F(e,"temp"),A.is.firefox===!0&&L(t,!1),e.styleCleanup!==void 0&&e.styleCleanup(!0),n!==void 0&&e.event.dir!==!1&&U(n),e.event=void 0)}};if(t.__qtouchswipe=e,i.mouse===!0){const n=i.mouseCapture===!0||i.mousecapture===!0?"Capture":"";B(e,"main",[[t,"mousedown","mouseStart",`passive${n}`]])}A.has.touch===!0&&B(e,"main",[[t,"touchstart","touchStart",`passive${i.capture===!0?"Capture":""}`],[t,"touchmove","noop","notPassiveCapture"]])},updated(t,a){const o=t.__qtouchswipe;o!==void 0&&(a.oldValue!==a.value&&(typeof a.value!="function"&&o.end(),o.handler=a.value),o.direction=Z(a.modifiers))},beforeUnmount(t){const a=t.__qtouchswipe;a!==void 0&&(F(a,"main"),F(a,"temp"),A.is.firefox===!0&&L(t,!1),a.styleCleanup!==void 0&&a.styleCleanup(),delete t.__qtouchswipe)}});function Fe(){const t=new Map;return{getCache:function(a,o){return t[a]===void 0?t[a]=o:t[a]},getCacheWithFn:function(a,o){return t[a]===void 0?t[a]=o():t[a]}}}const ze={name:{required:!0},disable:Boolean},ue={setup(t,{slots:a}){return()=>V("div",{class:"q-panel scroll",role:"tabpanel"},X(a.default))}},Me={modelValue:{required:!0},animated:Boolean,infinite:Boolean,swipeable:Boolean,vertical:Boolean,transitionPrev:String,transitionNext:String,transitionDuration:{type:[String,Number],default:300},keepAlive:Boolean,keepAliveInclude:[String,Array,RegExp],keepAliveExclude:[String,Array,RegExp],keepAliveMax:Number},Oe=["update:modelValue","beforeTransition","transition"];function Re(){const{props:t,emit:a,proxy:o}=ce(),{getCacheWithFn:i}=Fe();let u,e;const n=W(null),v=W(null);function b(s){const c=t.vertical===!0?"up":"left";Q((o.$q.lang.rtl===!0?-1:1)*(s.direction===c?1:-1))}const d=k(()=>[[Ue,b,void 0,{horizontal:t.vertical!==!0,vertical:t.vertical,mouse:!0}]]),f=k(()=>t.transitionPrev||`slide-${t.vertical===!0?"down":"right"}`),y=k(()=>t.transitionNext||`slide-${t.vertical===!0?"up":"left"}`),p=k(()=>`--q-transition-duration: ${t.transitionDuration}ms`),h=k(()=>typeof t.modelValue=="string"||typeof t.modelValue=="number"?t.modelValue:String(t.modelValue)),P=k(()=>({include:t.keepAliveInclude,exclude:t.keepAliveExclude,max:t.keepAliveMax})),T=k(()=>t.keepAliveInclude!==void 0||t.keepAliveExclude!==void 0);Ce(()=>t.modelValue,(s,c)=>{const C=g(s)===!0?D(s):-1;e!==!0&&j(C===-1?0:C<D(c)?-1:1),n.value!==C&&(n.value=C,a("beforeTransition",s,c),xe(()=>{a("transition",s,c)}))});function x(){Q(1)}function q(){Q(-1)}function l(s){a("update:modelValue",s)}function g(s){return s!=null&&s!==""}function D(s){return u.findIndex(c=>c.props.name===s&&c.props.disable!==""&&c.props.disable!==!0)}function pe(){return u.filter(s=>s.props.disable!==""&&s.props.disable!==!0)}function j(s){const c=s!==0&&t.animated===!0&&n.value!==-1?"q-transition--"+(s===-1?f.value:y.value):null;v.value!==c&&(v.value=c)}function Q(s,c=n.value){let C=c+s;for(;C>-1&&C<u.length;){const N=u[C];if(N!==void 0&&N.props.disable!==""&&N.props.disable!==!0){j(s),e=!0,a("update:modelValue",N.props.name),setTimeout(()=>{e=!1});return}C+=s}t.infinite===!0&&u.length>0&&c!==-1&&c!==u.length&&Q(s,s===-1?u.length:-1)}function G(){const s=D(t.modelValue);return n.value!==s&&(n.value=s),!0}function H(){const s=g(t.modelValue)===!0&&G()&&u[n.value];return t.keepAlive===!0?[V(Te,P.value,[V(T.value===!0?i(h.value,()=>({...ue,name:h.value})):ue,{key:h.value,style:p.value},()=>s)])]:[V("div",{class:"q-panel scroll",style:p.value,key:h.value,role:"tabpanel"},[s])]}function me(){if(u.length!==0)return t.animated===!0?[V(_e,{name:v.value},H)]:H()}function ve(s){return u=ke(X(s.default,[])).filter(c=>c.props!==null&&c.props.slot===void 0&&g(c.props.name)===!0),u.length}function fe(){return u}return Object.assign(o,{next:x,previous:q,goTo:l}),{panelIndex:n,panelDirectives:d,updatePanelsList:ve,updatePanelIndex:G,getPanelContent:me,getEnabledPanels:pe,getPanels:fe,isValidPanelName:g,keepAliveProps:P,needsUniqueKeepAliveWrapper:T,goToPanelByOffset:Q,goToPanel:l,nextPanel:x,previousPanel:q}}const de=K({name:"QTabPanel",props:ze,setup(t,{slots:a}){return()=>V("div",{class:"q-tab-panel",role:"tabpanel"},X(a.default))}}),Ye=K({name:"QTabPanels",props:{...Me,...we},emits:Oe,setup(t,{slots:a}){const o=ce(),i=Se(t,o.proxy.$q),{updatePanelsList:u,getPanelContent:e,panelDirectives:n}=Re(),v=k(()=>"q-tab-panels q-panel-parent"+(i.value===!0?" q-tab-panels--dark q-dark":""));return()=>(u(a),Ve("div",{class:v.value},e(),"pan",t.swipeable,()=>n.value))}}),We={class:"flex justify-between items-center text-color"},Ke=w("p",{class:"page-header"},"Edit Department",-1),Xe=w("br",null,null,-1),je=w("br",null,null,-1),Ge={class:"flex q-gutter-sm"},He=w("br",null,null,-1),st={__name:"Edit",props:["data"],setup(t){const a=t,o=qe(),i=De({name:a.data.name,description:a.data.description}),u=Qe({tab:"trade"});W(a.data.trades);const e=b=>{o.dialog({title:"Confirm Remove",message:"Do you want to remove",ok:"Yes",cancel:"No"}).onOk(()=>{oe.delete(route("trade.detach",b.id),{onStart:d=>o.loading.show({message:"Detaching..."}),onFinish:d=>o.loading.hide(),preserveState:!1})})},n=b=>{o.dialog({title:"Confirm Remove",message:"Do you want to remove",ok:"Yes",cancel:"No"}).onOk(()=>{oe.delete(route("assignment.department.detach-user",[a.data.id,b.id]),{onStart:d=>o.loading.show({message:"Detaching..."}),onFinish:d=>o.loading.hide(),preserveState:!1})})},v=b=>{i.submit("put",route("department.update",a.data.id),{onStart:d=>o.loading.show({message:"Updating..."}),onFinish:d=>o.loading.hide()})};return(b,d)=>(E(),z(M,null,[w("div",We,[w("div",null,[Ke,r(be,null,{default:m(()=>[r(I,{href:b.route("dashboard"),label:"Dashboard",icon:"o_dashboard"},null,8,["href"]),r(I,{href:b.route("department.index"),label:"Departments"},null,8,["href"]),r(I,{label:"Edit Department"})]),_:1})])]),Xe,je,r(Ie,{onSubmit:v},{default:m(()=>{var f,y,p,h,P,T,x,q;return[r(te,{modelValue:_(i).name,"onUpdate:modelValue":d[0]||(d[0]=l=>_(i).name=l),label:"Name *",error:!!((y=(f=_(i))==null?void 0:f.errors)!=null&&y.name),"error-message":!!((h=(p=_(i))==null?void 0:p.errors)!=null&&h.name),rules:[l=>!!l||"Name is required"]},null,8,["modelValue","error","error-message","rules"]),r(te,{modelValue:_(i).description,"onUpdate:modelValue":d[1]||(d[1]=l=>_(i).description=l),label:"Description",error:!!((T=(P=_(i))==null?void 0:P.errors)!=null&&T.description),"error-message":!!((q=(x=_(i))==null?void 0:x.errors)!=null&&q.description)},null,8,["modelValue","error","error-message"]),w("div",Ge,[r($,{class:"sized-btn",type:"submit",label:"Update",color:"accent"}),r($,{class:"sized-btn",onClick:d[2]||(d[2]=l=>b.$inertia.replace(b.route("department.index"))),label:"Cancel",color:"negative"})]),He,r(Ae,{class:"q-my-sm full-width"}),r($e,{modelValue:u.tab,"onUpdate:modelValue":d[3]||(d[3]=l=>u.tab=l),class:"bg-secondary text-grey-1"},{default:m(()=>[r(ie,{name:"trade",label:"Trades"}),r(ie,{name:"user",label:"Users"})]),_:1},8,["modelValue"]),r(Ye,{modelValue:u.tab,"onUpdate:modelValue":d[4]||(d[4]=l=>u.tab=l),animated:""},{default:m(()=>[r(de,{name:"trade"},{default:m(()=>[r(ae,{separator:""},{default:m(()=>[(E(!0),z(M,null,ne(t.data.trades,(l,g)=>(E(),se(re,{key:g},{default:m(()=>[r(S,{avatar:""},{default:m(()=>[r(le,{square:"",label:g+1},null,8,["label"])]),_:2},1024),r(S,null,{default:m(()=>[r(O,null,{default:m(()=>[R(Y(l==null?void 0:l.name),1)]),_:2},1024)]),_:2},1024),r(S,{side:""},{default:m(()=>[r($,{size:"sm",onClick:D=>e(l),outline:"",color:"negative",icon:"delete"},null,8,["onClick"])]),_:2},1024)]),_:2},1024))),128))]),_:1})]),_:1}),r(de,{name:"user"},{default:m(()=>[r(ae,{separator:""},{default:m(()=>[(E(!0),z(M,null,ne(t.data.users,(l,g)=>(E(),se(re,{key:g},{default:m(()=>[r(S,{avatar:""},{default:m(()=>[r(le,{square:"",label:g+1},null,8,["label"])]),_:2},1024),r(S,null,{default:m(()=>[r(O,null,{default:m(()=>[R(Y(l==null?void 0:l.name),1)]),_:2},1024),r(O,{caption:""},{default:m(()=>[R(Y(l==null?void 0:l.name),1)]),_:2},1024)]),_:2},1024),r(S,{side:""},{default:m(()=>[r($,{size:"sm",onClick:D=>n(l),outline:"",color:"negative",icon:"o_close"},null,8,["onClick"])]),_:2},1024)]),_:2},1024))),128))]),_:1})]),_:1})]),_:1},8,["modelValue"])]}),_:1})],64))}};export{st as default};