import{Q as k,a as p}from"./QBreadcrumbs-f1fcde01.js";import{a1 as y,h as r,o as D,e as C,a as s,d as o,w as d,Q as c,F as Q,aw as g,t as B}from"./app-a7abb58d.js";import{Q as N}from"./QTable-33cc80a5.js";import"./QSelect-57ce204b.js";import"./QChip-85d4182d.js";import"./rtl-36dd996b.js";import"./use-fullscreen-7c8ce305.js";const S={class:"flex justify-between items-center"},$=s("p",{class:"page-header"},"List of District",-1),q=s("br",null,null,-1),F={align:"right"},P={class:"flex q-gutter-sm justify-end"},A={__name:"Index",props:["list"],setup(f){const l=f,b=[{name:"sn",align:"left",label:"SN",field:"id"},{name:"code",align:"left",label:"Code",field:"code"},{name:"name",align:"left",label:"Name",field:"name"},{name:"action",label:"Action",field:"id"}],i=y(),h=r(l.list.data||[]),n=r(!1),u=r({page:l.list.current_page,rowsPerPage:l.list.per_page,rowsNumber:l.list.total}),w=e=>{i.dialog({title:"Confirm Delete",message:"Do you want to delete",ok:"Yes",cancel:"No"}).onOk(()=>{g.delete(route("district.destroy",e.id),{onStart:a=>i.loading.show({message:"Deleting..."}),onFinish:a=>i.loading.hide(),preserveState:!1})})};function v(e){const{page:a,rowsPerPage:t,sortBy:m,descending:x}=e.pagination;g.get(route("district.index"),{per_page:t,page:a},{onStart:_=>n.value=!0,onFinish:_=>n.value=!1})}return(e,a)=>(D(),C(Q,null,[s("div",S,[s("div",null,[$,o(k,null,{default:d(()=>[o(p,{href:e.route("dashboard"),label:"Dashboard",icon:"o_dashboard"},null,8,["href"]),o(p,{label:"District"})]),_:1})]),o(c,{color:"accent",label:"New District",onClick:a[0]||(a[0]=t=>e.$inertia.get(e.route("district.create")))})]),q,o(N,{"table-class":"text-color",flat:"","table-header-class":"table-header",pagination:u.value,"onUpdate:pagination":a[1]||(a[1]=t=>u.value=t),columns:b,filter:e.filter,loading:n.value,rows:h.value,"binary-state-sort":"","row-key":"id",onRequest:v,"rows-per-page-options":[2,5,7,15,30,50]},{"body-cell-sn":d(t=>[s("td",null,B(t.rowIndex+1),1)]),"body-cell-action":d(t=>[s("td",F,[s("div",P,[o(c,{onClick:m=>e.$inertia.get(e.route("district.edit",t.row.id)),size:"sm",icon:"edit",outline:""},null,8,["onClick"]),o(c,{onClick:m=>w(t.row),size:"sm",icon:"delete",outline:""},null,8,["onClick"])])])]),_:1},8,["pagination","filter","loading","rows"])],64))}};export{A as default};