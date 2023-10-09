import{Q as k,a as p}from"./QBreadcrumbs-f1fcde01.js";import{a1 as C,h as r,o as v,e as Q,a as o,d as n,w as d,Q as c,F as B,aw as g,t as D}from"./app-a7abb58d.js";import{Q as N}from"./QTable-33cc80a5.js";import"./QSelect-57ce204b.js";import"./QChip-85d4182d.js";import"./rtl-36dd996b.js";import"./use-fullscreen-7c8ce305.js";const S={class:"flex justify-between items-center"},$=o("p",{class:"page-header"},"List of Constituency",-1),q=o("br",null,null,-1),F={align:"right"},P={class:"flex q-gutter-sm justify-end"},A={__name:"Index",props:["list"],setup(f){const s=f,b=[{name:"sn",align:"left",label:"SN",field:"id"},{name:"name",align:"left",label:"Name",field:"name"},{name:"district",align:"center",label:"District",field:"district",format:e=>(e==null?void 0:e.name)||""},{name:"action",label:"Action",field:"id"}],i=C(),h=r(s.list.data||[]),l=r(!1),u=r({page:s.list.current_page,rowsPerPage:s.list.per_page,rowsNumber:s.list.total}),w=e=>{i.dialog({title:"Confirm Delete",message:"Do you want to delete",ok:"Yes",cancel:"No"}).onOk(()=>{g.delete(route("constituency.destroy",e.id),{onStart:a=>i.loading.show({message:"Deleting..."}),onFinish:a=>i.loading.hide(),preserveState:!1})})};function y(e){const{page:a,rowsPerPage:t,sortBy:m,descending:x}=e.pagination;g.get(route("constituency.index"),{per_page:t,page:a},{onStart:_=>l.value=!0,onFinish:_=>l.value=!1})}return(e,a)=>(v(),Q(B,null,[o("div",S,[o("div",null,[$,n(k,null,{default:d(()=>[n(p,{href:e.route("dashboard"),icon:"o_dashboard",label:"Dashboard"},null,8,["href"]),n(p,{label:"Constituencies"})]),_:1})]),n(c,{color:"accent",label:"New Constituency",onClick:a[0]||(a[0]=t=>e.$inertia.get(e.route("constituency.create")))})]),q,n(N,{pagination:u.value,"onUpdate:pagination":a[1]||(a[1]=t=>u.value=t),columns:b,filter:e.filter,loading:l.value,rows:h.value,"rows-per-page-options":[2,5,7,15,30,50],"binary-state-sort":"",flat:"","row-key":"id","table-class":"text-color","table-header-class":"table-header",onRequest:y},{"body-cell-sn":d(t=>[o("td",null,D(t.rowIndex+1),1)]),"body-cell-action":d(t=>[o("td",F,[o("div",P,[n(c,{icon:"edit",outline:"",size:"sm",onClick:m=>e.$inertia.get(e.route("constituency.edit",t.row.id))},null,8,["onClick"]),n(c,{icon:"delete",outline:"",size:"sm",onClick:m=>w(t.row)},null,8,["onClick"])])])]),_:1},8,["pagination","filter","loading","rows"])],64))}};export{A as default};