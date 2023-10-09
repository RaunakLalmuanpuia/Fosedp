import{Q as Y,a as h}from"./QBreadcrumbs-f1fcde01.js";import{a1 as A,h as G,v as B,o as g,e as F,a as o,d as e,w as s,q as H,F as U,m as v,u as r,Q as m,s as z,x as p,y as E,k as I,c as T,n as J,p as K,f as M,g as X,b as $,W as Z,t as ee,C as L,aw as ae}from"./app-a7abb58d.js";import{Q as te}from"./QSelect-57ce204b.js";import{Q as se}from"./QChip-85d4182d.js";import{Q as j}from"./QForm-ea84dcf4.js";import"./rtl-36dd996b.js";const le={class:"flex justify-between items-center text-color"},re=o("p",{class:"page-header"},"Edit Trade",-1),oe=o("br",null,null,-1),ne=o("br",null,null,-1),de={class:"flex q-gutter-sm"},ue=o("br",null,null,-1),ie={class:"flex q-gutter-sm"},me={class:"flex justify-between items-center"},pe=o("p",{class:"q-ma-none text-md text-weight-medium text-color"},"New Subtrade",-1),ce={class:"flex q-gutter-sm"},Qe={__name:"Edit",props:["data","departments"],setup(c){const u=c,i=A(),b=G(!1),l=B({name:u.data.name,department:u.data.department?{value:u.data.department.id,label:u.data.department.name}:null,description:u.data.description}),f=B({name:""}),O=n=>{f.submit("post",route("trade.subtrade.store",u.data.id),{onStart:a=>i.loading.show({message:"Saving..."}),onSuccess:a=>{f.name="",b.value=!1},onFinish:a=>i.loading.hide()})},P=n=>{i.dialog({title:"Confirm Detach",message:"Do you want to Detach Subtrade",ok:"Yes",cancel:"No"}).onOk(()=>{ae.delete(route("trade.subtrade.detach",n.id),{onStart:a=>i.loading.show({message:"Removing..."}),onFinish:a=>i.loading.hide(),preserveState:!1})})},R=n=>{console.log(l.data()),l.transform(a=>({department_id:a.department.value,...a})).submit("put",route("trade.update",u.data.id),{onStart:a=>i.loading.show({message:"Updating..."}),onFinish:a=>i.loading.hide()})};return(n,a)=>(g(),F(U,null,[o("div",le,[o("div",null,[re,e(Y,null,{default:s(()=>[e(h,{href:n.route("dashboard"),label:"Dashboard",icon:"o_dashboard"},null,8,["href"]),e(h,{href:n.route("trade.index"),label:"Trade"},null,8,["href"]),e(h,{label:"Edit Trade"})]),_:1})])]),oe,ne,e(j,{onSubmit:R},{default:s(()=>{var d,_,Q,V,S,C,k,w,x,q,D,N;return[e(v,{modelValue:r(l).name,"onUpdate:modelValue":a[0]||(a[0]=t=>r(l).name=t),label:"Name *",error:!!((_=(d=r(l))==null?void 0:d.errors)!=null&&_.name),"error-message":!!((V=(Q=r(l))==null?void 0:Q.errors)!=null&&V.name),rules:[t=>!!t||"Name is required"]},null,8,["modelValue","error","error-message","rules"]),e(te,{modelValue:r(l).department,"onUpdate:modelValue":a[1]||(a[1]=t=>r(l).department=t),label:"Department *",options:c.departments,error:!!((C=(S=r(l))==null?void 0:S.errors)!=null&&C.department_id),"error-message":!!((w=(k=r(l))==null?void 0:k.errors)!=null&&w.department_id),rules:[t=>!!t||"Department is required"]},null,8,["modelValue","options","error","error-message","rules"]),e(v,{modelValue:r(l).description,"onUpdate:modelValue":a[2]||(a[2]=t=>r(l).description=t),label:"Description",error:!!((q=(x=r(l))==null?void 0:x.errors)!=null&&q.description),"error-message":!!((N=(D=r(l))==null?void 0:D.errors)!=null&&N.description)},null,8,["modelValue","error","error-message"]),o("div",de,[e(m,{class:"sized-btn",type:"submit",label:"Update",color:"accent"}),e(m,{class:"sized-btn",onClick:a[3]||(a[3]=t=>n.$inertia.replace(n.route("trade.index"))),label:"Cancel",color:"negative"})]),ue,e(z,null,{default:s(()=>[e(p,null,{default:s(()=>[e(E,{class:"text-md text-color"},{default:s(()=>[I("SubTrades")]),_:1})]),_:1}),e(p,{side:""},{default:s(()=>[e(m,{size:"md",outline:"","no-caps":"",onClick:a[4]||(a[4]=t=>b.value=!0),label:"New Subtrade"})]),_:1})]),_:1}),c.data.sub_trades.length>0?(g(),T(K,{key:0,separator:""},{default:s(()=>[(g(!0),F(U,null,J(c.data.sub_trades,(t,y)=>(g(),T(z,{key:y},{default:s(()=>[e(p,{avatar:""},{default:s(()=>[e(se,{square:"",label:y+1},null,8,["label"])]),_:2},1024),e(p,null,{default:s(()=>[e(E,null,{default:s(()=>[I(ee(t==null?void 0:t.name),1)]),_:2},1024)]),_:2},1024),e(p,{side:""},{default:s(()=>[o("div",ie,[e(m,{size:"sm",outline:"",onClick:W=>n.edit(t),icon:"edit"},null,8,["onClick"]),e(m,{size:"sm",outline:"",onClick:W=>P(t),icon:"delete"},null,8,["onClick"])])]),_:2},1024)]),_:2},1024))),128))]),_:1})):M("",!0)]}),_:1}),e(H,{modelValue:b.value,"onUpdate:modelValue":a[6]||(a[6]=d=>b.value=d)},{default:s(()=>[e(X,{style:{width:"480px"},class:"q-pa-md"},{default:s(()=>[o("div",me,[pe,$(e(Z,{size:"18px",class:"cursor-pointer",name:"close"},null,512),[[L]])]),e(j,{class:"column q-gutter-sm",onSubmit:O},{default:s(()=>[e(v,{modelValue:r(f).name,"onUpdate:modelValue":a[5]||(a[5]=d=>r(f).name=d),autofocus:"",label:"Name *",rules:[d=>!!d||"Name is required"]},null,8,["modelValue","rules"]),o("div",ce,[e(m,{type:"submit",color:"accent",label:"Save"}),$(e(m,{color:"negative",label:"Cancel"},null,512),[[L]])])]),_:1})]),_:1})]),_:1},8,["modelValue"])],64))}};export{Qe as default};
