import{Q as k,a as _}from"./QBreadcrumbs-f1fcde01.js";import{o as r,e as i,a as o,d as e,w as l,Q as h,p as g,F as b,n as v,c as w,s as C,x as d,y as u,k as t,t as n,u as y}from"./app-a7abb58d.js";import{Q as F}from"./QChip-85d4182d.js";import{u as I}from"./useUtils-e812dfe8.js";const N={class:"flex justify-between items-center text-color"},U=o("p",{class:"page-header"},"Form 9",-1),q=o("p",{class:"text-caption"},"(Completion Certificate)",-1),D=o("br",null,null,-1),L={class:"column"},V={class:"text-bold"},E={class:"text-bold"},A={__name:"Index",props:["list"],setup(m){const Q=m,{formatDateTime:x}=I();return(s,c)=>(r(),i(b,null,[o("div",N,[o("div",null,[U,q,e(k,null,{default:l(()=>[e(_,{href:s.route("dashboard"),icon:"o_dashboard",label:"Dashboard"},null,8,["href"]),e(_,{href:s.route("form-upload-nine.index"),label:"Form 9"},null,8,["href"])]),_:1})]),e(h,{color:"accent",onClick:c[0]||(c[0]=a=>s.$inertia.get(s.route("form-upload-nine.create"))),label:"Upload New"})]),D,o("div",L,[e(g,null,{default:l(()=>[(r(!0),i(b,null,v(Q.list,(a,B)=>(r(),w(C,{class:"q-pl-none q-ml-none"},{default:l(()=>[e(d,{avatar:""},{default:l(()=>[e(F,{square:"",label:B+1},null,8,["label"])]),_:2},1024),e(d,null,{default:l(()=>[e(u,null,{default:l(()=>{var f,p;return[t("Uploaded By "),o("span",V,n((f=a==null?void 0:a.user)==null?void 0:f.name),1),t(" for "),o("span",E,n((p=a==null?void 0:a.department)==null?void 0:p.name),1)]}),_:2},1024),e(u,{caption:""},{default:l(()=>[t("Uploaded At "+n(y(x)(a.created_at)),1)]),_:2},1024),e(u,{caption:""},{default:l(()=>[t(n(a==null?void 0:a.remark),1)]),_:2},1024)]),_:2},1024),e(d,{side:""},{default:l(()=>[e(h,{href:a==null?void 0:a.fullPath,target:"_blank",round:"",icon:"cloud_download"},null,8,["href"])]),_:2},1024)]),_:2},1024))),256))]),_:1})])],64))}};export{A as default};