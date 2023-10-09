import{Q,a as f}from"./QBreadcrumbs-f1fcde01.js";import{a1 as N,h as i,o as B,e as C,a as n,d as o,w as d,Q as u,m as D,F as S,aw as c,t as x}from"./app-a7abb58d.js";import{Q as F}from"./QTable-33cc80a5.js";import"./QSelect-57ce204b.js";import"./QChip-85d4182d.js";import"./rtl-36dd996b.js";import"./use-fullscreen-7c8ce305.js";const T={class:"flex justify-between items-center"},V=n("p",{class:"page-header"},"List of Trades",-1),$=n("br",null,null,-1),q={class:"flex justify-between items-center"},P={align:"right"},j={class:"flex q-gutter-sm justify-end"},Y={__name:"Index",props:["list","search"],setup(h){const l=h,b=[{name:"sn",align:"left",label:"SN",field:"id"},{name:"name",align:"left",label:"Name",field:"name"},{name:"department",align:"left",label:"Department",field:"department",format:e=>(e==null?void 0:e.name)||"NA"},{name:"action",label:"Action",field:"id"}],s=N(),m=i(l.search),w=i(l.list.data||[]),r=i(!1),p=i({page:l.list.current_page,rowsPerPage:l.list.per_page,rowsNumber:l.list.total}),v=e=>{c.get(route("trade.index"),{search:e},{onStart:a=>s.loading.show(),onFinish:a=>s.loading.hide()})},y=e=>{s.dialog({title:"Confirm Delete",message:"Do you want to delete",ok:"Yes",cancel:"No"}).onOk(()=>{c.delete(route("trade.destroy",e.id),{onStart:a=>s.loading.show({message:"Deleting..."}),onFinish:a=>s.loading.hide(),preserveState:!1})})};function _(e){const{page:a,rowsPerPage:t,sortBy:g,descending:I}=e.pagination;console.log(e.pagination),c.get(route("trade.index"),{per_page:t,page:a},{onStart:k=>r.value=!0,onFinish:k=>r.value=!1})}return(e,a)=>(B(),C(S,null,[n("div",T,[n("div",null,[V,o(Q,null,{default:d(()=>[o(f,{href:e.route("dashboard"),icon:"o_dashboard",label:"Dashboard"},null,8,["href"]),o(f,{label:"Trades"})]),_:1})]),o(u,{color:"accent",label:"New Trade",onClick:a[0]||(a[0]=t=>e.$inertia.get(e.route("trade.create")))})]),$,n("div",q,[o(D,{modelValue:m.value,"onUpdate:modelValue":[a[1]||(a[1]=t=>m.value=t),v],debounce:800,dense:"",outlined:"",placeholder:"Type here"},null,8,["modelValue"])]),o(F,{pagination:p.value,"onUpdate:pagination":a[2]||(a[2]=t=>p.value=t),columns:b,filter:e.filter,loading:r.value,rows:w.value,"rows-per-page-options":[2,5,7,15,30,50],"binary-state-sort":"",flat:"","row-key":"id","table-class":"text-color","table-header-class":"table-header",onRequest:_},{"body-cell-sn":d(t=>[n("td",null,x(t.rowIndex+1),1)]),"body-cell-action":d(t=>[n("td",P,[n("div",j,[o(u,{icon:"edit",outline:"",size:"sm",onClick:g=>e.$inertia.get(e.route("trade.edit",t.row.id))},null,8,["onClick"]),o(u,{icon:"delete",outline:"",size:"sm",onClick:g=>y(t.row)},null,8,["onClick"])])])]),_:1},8,["pagination","filter","loading","rows"])],64))}};export{Y as default};