import{Q as y,a as g}from"./QBreadcrumbs-f1fcde01.js";import{Q as S}from"./QSelect-57ce204b.js";import{Q as V}from"./QChip-85d4182d.js";import{r as q,o as n,e as v,a as s,d as l,w as t,p as x,l as D,Q as d,F as B,aw as C,n as N,c as U,s as $,x as u,y as i,k as c,t as r,u as E}from"./app-a7abb58d.js";import{u as I}from"./useUtils-e812dfe8.js";import"./rtl-36dd996b.js";const L={class:"flex justify-between items-center text-color"},P=s("p",{class:"page-header"},"Form-10",-1),A=s("p",{class:"text-caption"},"Form-10 (FOSEDP kalpui tha, chawimawi tlak recommend form) Submitted by all departments",-1),O=s("br",null,null,-1),T=s("br",null,null,-1),j={class:"column"},z={class:"text-bold"},G={class:"flex q-gutter-sm"},X={__name:"Admin",props:["list","departments","filter"],setup(p){const m=p,{formatDateTime:k}=I(),f=q({selected:m.filter}),F=a=>{C.get(route("form-ten.all"),{departments:a.map(o=>o.value)})};return(a,o)=>{var _,b;return n(),v(B,null,[s("div",L,[s("div",null,[P,A,l(y,null,{default:t(()=>[l(g,{href:a.route("dashboard"),icon:"o_dashboard",label:"Dashboard"},null,8,["href"]),l(g,{href:a.route("form-upload-ten.all"),label:"Form 10 "},null,8,["href"])]),_:1})])]),O,l(S,{modelValue:f.selected,"onUpdate:modelValue":[o[0]||(o[0]=e=>f.selected=e),F],options:p.departments,"use-chips":"",standout:"bg-accent",multiple:"",label:"Filter By Departments"},null,8,["modelValue","options"]),T,s("div",j,[l(x,null,{default:t(()=>[(n(!0),v(B,null,N(m.list.data,(e,w)=>(n(),U($,{class:"q-pl-none q-ml-none"},{default:t(()=>[l(u,{avatar:""},{default:t(()=>[l(V,{square:"",label:w+1},null,8,["label"])]),_:2},1024),l(u,null,{default:t(()=>[l(i,null,{default:t(()=>{var h,Q;return[c("Uploaded By "+r((h=e==null?void 0:e.user)==null?void 0:h.name)+" for ",1),s("span",z,r((Q=e==null?void 0:e.department)==null?void 0:Q.name),1)]}),_:2},1024),l(i,{caption:""},{default:t(()=>[c("Uploaded At "+r(E(k)(e.created_at)),1)]),_:2},1024),l(i,{caption:""},{default:t(()=>[c(r(e==null?void 0:e.remark),1)]),_:2},1024)]),_:2},1024),l(u,{side:""},{default:t(()=>[l(d,{href:e==null?void 0:e.fullPath,target:"_blank",round:"",icon:"cloud_download"},null,8,["href"])]),_:2},1024)]),_:2},1024))),256))]),_:1}),l(D,{class:"q-my-sm"}),s("div",G,[l(d,{color:"accent",disable:!Boolean((_=a.item)==null?void 0:_.prev_page_url),onClick:o[1]||(o[1]=e=>a.$inertia.get(a.item.prev_page_url)),label:"Prev"},null,8,["disable"]),l(d,{color:"accent",disable:!Boolean((b=a.item)==null?void 0:b.next_page_url),onClick:o[2]||(o[2]=e=>a.$inertia.get(a.item.next_page_url)),label:"Next"},null,8,["disable"])])])],64)}}};export{X as default};