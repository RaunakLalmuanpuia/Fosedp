import{Q as Y,a as S}from"./QBreadcrumbs-f1fcde01.js";import{a1 as z,h as d,r as N,T as A,o as b,e as F,a as o,d as l,w as i,Q as U,av as D,m as $,u as G,F as q,aw as u,p as J,s as O,x as R,k as K,n as W,aH as X,c as Z,ax as ee}from"./app-a7abb58d.js";import{Q as te}from"./QTable-33cc80a5.js";import"./QSelect-57ce204b.js";import"./QChip-85d4182d.js";import"./rtl-36dd996b.js";import"./use-fullscreen-7c8ce305.js";const ae={class:"flex justify-between items-center"},le=o("p",{class:"page-header"},"Outbox",-1),ne=o("br",null,null,-1),oe={class:"flex justify-between items-center"},se=o("br",null,null,-1),ie={align:"right"},re={class:"flex q-gutter-sm justify-end"},_e={__name:"Index",props:["search","list","departments","districts","filter"],setup(_){var w,y,k,x;const s=_,T=[{name:"sn",align:"left",label:"SN",field:"id"},{name:"head_of_family",align:"left",label:"Head of Family",field:"head_of_family"},{name:"mobile",align:"left",label:"Mobile",field:"mobile"},{name:"epic_no",align:"left",label:"Epic no",field:"epic_no"},{name:"district",align:"left",label:"District",field:"district",format:e=>e==null?void 0:e.name},{name:"constituency",align:"left",label:"Constituency",field:"constituency",format:e=>e==null?void 0:e.name},{name:"department",align:"left",label:"Department",field:"department",format:e=>e==null?void 0:e.name},{name:"trade",align:"left",label:"Trade",field:"trade",format:e=>e==null?void 0:e.name},{name:"action",label:"Action",field:"id"}],r=z(),I=d(s.list.data||[]),m=d(!1),p=d({page:s.list.current_page,rowsPerPage:s.list.per_page,rowsNumber:s.list.total}),c=d([]),f=d(s.search),h=d([{name:"head_of_family",selected:!0},{name:"mobile",selected:!0},{name:"district",selected:!0},{name:"constituency",selected:!0},{name:"department",selected:!0},{name:"trade",selected:!0},{name:"action",selected:!0}]);N({trades:[],constituencies:[]});const n=N({district:((w=s.filter)==null?void 0:w.district)||null,constituency:((y=s.filter)==null?void 0:y.constituency)||null,department:((k=s.filter)==null?void 0:k.department)||null,trade:((x=s.filter)==null?void 0:x.trade)||null}),P=A(e=>h.value.filter(t=>t.selected).map(t=>t.name)),j=e=>{v({pagination:p})},E=e=>{r.dialog({title:"Confirmation",message:"Do you want to undo",ok:"Yes",cancel:"No"}).onOk(()=>{u.delete(route("application.revert",e.id),{onStart:t=>r.loading.show({message:"Deleting..."}),onFinish:t=>r.loading.hide(),preserveState:!1})})},H=e=>{r.dialog({title:"Confirmation",message:"Do you want to revert",ok:"Yes",cancel:"No"}).onOk(()=>{u.put(route("application.bulk-revert"),{ids:c.value.map(t=>t.id)},{onStart:t=>r.loading.show({message:"Deleting..."}),onFinish:t=>r.loading.hide(),preserveState:!1})})},L=(e,t,a)=>u.get(route("application.show",t.id));function v(e){var Q,C,V,B;const{page:t,rowsPerPage:a,sortBy:g,descending:de}=e.pagination;u.get(route("application.outgoing"),{per_page:a,page:t,filter_district_id:(Q=n==null?void 0:n.district)==null?void 0:Q.value,filter_constituency_id:(C=n==null?void 0:n.constituency)==null?void 0:C.value,filter_trade_id:(V=n==null?void 0:n.trade)==null?void 0:V.value,filter_department_id:(B=n==null?void 0:n.department)==null?void 0:B.value,search:f.value},{preserveState:!1,onStart:M=>m.value=!0,onFinish:M=>m.value=!1})}return(e,t)=>(b(),F(q,null,[o("div",ae,[o("div",null,[le,l(Y,null,{default:i(()=>[l(S,{href:e.route("dashboard"),icon:"o_dashboard",label:"Dashboard"},null,8,["href"]),l(S,{class:"text-color",label:"Outbox"})]),_:1})]),o("div",null,[l(U,{onClick:H,disable:c.value.length<=0,color:"accent",label:"Revert","no-caps":""},null,8,["disable"]),l(D,{class:"q-pa-xs","dropdown-icon":"more_vert",flat:""},{default:i(()=>[l(J,null,{default:i(()=>[l(O,null,{default:i(()=>[l(R,null,{default:i(()=>[K("Visible Column")]),_:1})]),_:1}),l(O,null,{default:i(()=>[l(R,null,{default:i(()=>[(b(!0),F(q,null,W(h.value,a=>(b(),Z(ee,{modelValue:a.selected,"onUpdate:modelValue":g=>a.selected=g,label:a.name,val:""},null,8,["modelValue","onUpdate:modelValue","label"]))),256))]),_:1})]),_:1})]),_:1})]),_:1})])]),ne,o("div",oe,[o("div",null,[l($,{modelValue:f.value,"onUpdate:modelValue":[t[0]||(t[0]=a=>f.value=a),j],autofocus:"",debounce:800,dense:"",outlined:"",placeholder:"Type here..."},null,8,["modelValue"])])]),se,l(te,{pagination:p.value,"onUpdate:pagination":t[1]||(t[1]=a=>p.value=a),selected:c.value,"onUpdate:selected":t[2]||(t[2]=a=>c.value=a),columns:T,filter:_.filter,loading:m.value,rows:I.value,"rows-per-page-options":[7,15,30,50,100,200],"visible-columns":G(P),"binary-state-sort":"",flat:"","row-key":"id",selection:"multiple","table-class":"text-color","table-header-class":"table-header",onRequest:v,onRowClick:L},{"body-cell-action":i(a=>[o("td",ie,[o("div",re,[l(U,{icon:"undo",outline:"",size:"sm",onClick:X(g=>E(a.row),["stop"])},null,8,["onClick"])])])]),_:1},8,["pagination","selected","filter","loading","rows","visible-columns"])],64))}};export{_e as default};