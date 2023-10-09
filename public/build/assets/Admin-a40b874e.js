import{Q as V,a as Q}from"./QBreadcrumbs-f1fcde01.js";import{Q as q}from"./QSelect-57ce204b.js";import{Q as w}from"./QChip-85d4182d.js";import{r as x,o as n,e as g,a as s,d as l,w as t,p as S,l as C,Q as d,F as B,aw as D,n as N,c as U,s as $,x as u,y as i,k as p,t as r,u as I}from"./app-a7abb58d.js";import{u as L}from"./useUtils-e812dfe8.js";import"./rtl-36dd996b.js";const A={class:"flex justify-between items-center text-color"},E=s("p",{class:"page-header"},"Form-11",-1),M=s("p",{class:"text-caption"},"Form-11 (Monitory Report) Submitted by all departments",-1),P=s("br",null,null,-1),T=s("br",null,null,-1),j={class:"column"},O={class:"text-bold"},R={class:"flex q-gutter-sm"},X={__name:"Admin",props:["list","departments","filter"],setup(c){const f=c,{formatDateTime:y}=L(),m=x({selected:f.filter}),k=a=>{D.get(route("form-eleven.all"),{departments:a.map(o=>o.value)})};return(a,o)=>{var _,b;return n(),g(B,null,[s("div",A,[s("div",null,[E,M,l(V,null,{default:t(()=>[l(Q,{href:a.route("dashboard"),icon:"o_dashboard",label:"Dashboard"},null,8,["href"]),l(Q,{href:a.route("form-upload-eleven.all"),label:"Form 11 - Monitory Format"},null,8,["href"])]),_:1})])]),P,l(q,{modelValue:m.selected,"onUpdate:modelValue":[o[0]||(o[0]=e=>m.selected=e),k],options:c.departments,"use-chips":"",standout:"bg-accent",multiple:"",label:"Filter By Departments"},null,8,["modelValue","options"]),T,s("div",j,[l(S,null,{default:t(()=>[(n(!0),g(B,null,N(f.list.data,(e,F)=>(n(),U($,{class:"q-pl-none q-ml-none"},{default:t(()=>[l(u,{avatar:""},{default:t(()=>[l(w,{square:"",label:F+1},null,8,["label"])]),_:2},1024),l(u,null,{default:t(()=>[l(i,null,{default:t(()=>{var h,v;return[p("Uploaded By "+r((h=e==null?void 0:e.user)==null?void 0:h.name)+" for ",1),s("span",O,r((v=e==null?void 0:e.department)==null?void 0:v.name),1)]}),_:2},1024),l(i,{caption:""},{default:t(()=>[p("Uploaded At "+r(I(y)(e.created_at)),1)]),_:2},1024),l(i,{caption:""},{default:t(()=>[p(r(e==null?void 0:e.remark),1)]),_:2},1024)]),_:2},1024),l(u,{side:""},{default:t(()=>[l(d,{href:e==null?void 0:e.fullPath,target:"_blank",round:"",icon:"cloud_download"},null,8,["href"])]),_:2},1024)]),_:2},1024))),256))]),_:1}),l(C,{class:"q-my-sm"}),s("div",R,[l(d,{color:"accent",disable:!Boolean((_=a.item)==null?void 0:_.prev_page_url),onClick:o[1]||(o[1]=e=>a.$inertia.get(a.item.prev_page_url)),label:"Prev"},null,8,["disable"]),l(d,{color:"accent",disable:!Boolean((b=a.item)==null?void 0:b.next_page_url),onClick:o[2]||(o[2]=e=>a.$inertia.get(a.item.next_page_url)),label:"Next"},null,8,["disable"])])])],64)}}};export{X as default};
