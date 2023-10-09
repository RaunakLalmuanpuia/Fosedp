import{Q as M,a as n}from"./QBreadcrumbs-f1fcde01.js";import{a1 as T,v as j,o as A,e as I,a as t,d as l,w as x,F as H,m as i,u as e,Q as z}from"./app-a7abb58d.js";import{Q as J}from"./QSelect-57ce204b.js";import{Q as K}from"./QForm-ea84dcf4.js";import"./QChip-85d4182d.js";import"./rtl-36dd996b.js";const L={class:"flex justify-between items-center text-color"},O=t("p",{class:"page-header"},"Task Group User",-1),R=t("br",null,null,-1),W=t("br",null,null,-1),X={class:"flex q-gutter-sm"},or={__name:"Create",props:["districts"],setup(D){const m=T(),r=j({name:"",mobile:"",email:"",roles:[],district:null,password:"",password_confirmation:""}),G=a=>{r.transform(o=>({district_id:o.district.value,...o})).submit("post",route("task-group-user.store"),{onStart:o=>m.loading.show({message:"Saving..."}),onFinish:o=>m.loading.hide()})};return(a,o)=>(A(),I(H,null,[t("div",L,[t("div",null,[O,l(M,null,{default:x(()=>[l(n,{class:"cursor-pointer",onClick:o[0]||(o[0]=d=>a.$inertia.get(a.route("dashboard"))),label:"Dashboard",icon:"o_dashboard"}),l(n,{class:"cursor-pointer",onClick:o[1]||(o[1]=d=>a.$inertia.get(a.route("task-group-user.index"))),label:"Task Group Users"}),l(n,{label:"New User"})]),_:1})])]),R,W,l(K,{onSubmit:G},{default:x(()=>{var d,u,p,b,g,w,f,V,c,k,v,Q,C,U,q,B,$,N,P,S,y,E,F,_;return[l(i,{modelValue:e(r).name,"onUpdate:modelValue":o[2]||(o[2]=s=>e(r).name=s),label:"Name *",error:!!((u=(d=e(r))==null?void 0:d.errors)!=null&&u.name),"error-message":(b=(p=e(r))==null?void 0:p.errors)==null?void 0:b.name,outlined:"",rules:[s=>!!s||"Name is required"]},null,8,["modelValue","error","error-message","rules"]),l(i,{modelValue:e(r).mobile,"onUpdate:modelValue":o[3]||(o[3]=s=>e(r).mobile=s),label:"Mobile *",error:!!((w=(g=e(r))==null?void 0:g.errors)!=null&&w.mobile),"error-message":(V=(f=e(r))==null?void 0:f.errors)==null?void 0:V.mobile,mask:"##########",outlined:"",rules:[s=>!!s||"Mobile is required"]},null,8,["modelValue","error","error-message","rules"]),l(i,{modelValue:e(r).email,"onUpdate:modelValue":o[4]||(o[4]=s=>e(r).email=s),label:"Email *",error:!!((k=(c=e(r))==null?void 0:c.errors)!=null&&k.email),"error-message":(Q=(v=e(r))==null?void 0:v.errors)==null?void 0:Q.email,rules:[s=>!!s||"Email is required"],outlined:""},null,8,["modelValue","error","error-message","rules"]),l(J,{modelValue:e(r).district,"onUpdate:modelValue":o[5]||(o[5]=s=>e(r).district=s),options:D.districts,label:"Appointed District",outlined:"",error:!!((U=(C=e(r))==null?void 0:C.errors)!=null&&U.district_id),"error-message":(B=(q=e(r))==null?void 0:q.errors)==null?void 0:B.district_id},null,8,["modelValue","options","error","error-message"]),l(i,{modelValue:e(r).password,"onUpdate:modelValue":o[6]||(o[6]=s=>e(r).password=s),type:"password",label:"Password *",outlined:"",error:!!((N=($=e(r))==null?void 0:$.errors)!=null&&N.password),"error-message":(S=(P=e(r))==null?void 0:P.errors)==null?void 0:S.password,rules:[s=>!!s||"Password is required"]},null,8,["modelValue","error","error-message","rules"]),l(i,{modelValue:e(r).password_confirmation,"onUpdate:modelValue":o[7]||(o[7]=s=>e(r).password_confirmation=s),type:"password",label:"Confirm Password *",outlined:"",error:!!((E=(y=e(r))==null?void 0:y.errors)!=null&&E.password_confirmation),"error-message":(_=(F=e(r))==null?void 0:F.errors)==null?void 0:_.password_confirmation,rules:[s=>!!s||"Confirm Password is required",s=>s===e(r).password||"Confirm Password does not match password"]},null,8,["modelValue","error","error-message","rules"]),t("div",X,[l(z,{class:"sized-btn",type:"submit",label:"Save",color:"accent"}),l(z,{class:"sized-btn",onClick:o[8]||(o[8]=s=>a.$inertia.replace(a.route("task-group-user.index"))),label:"Cancel",color:"negative"})])]}),_:1})],64))}};export{or as default};
