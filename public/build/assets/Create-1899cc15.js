import{Q as fe,a as ue}from"./QBreadcrumbs-f1fcde01.js";import{a1 as ve,v as ye,r as me,E as xe,o as ce,e as qe,a as l,d as a,w as pe,l as Se,m as u,u as s,c as ke,f as we,Q as ge}from"./app-a7abb58d.js";import{Q as g}from"./QSelect-57ce204b.js";import{Q as Ce}from"./QForm-ea84dcf4.js";import"./QChip-85d4182d.js";import"./rtl-36dd996b.js";const Te={class:"bg-white"},Ue={class:"flex justify-between items-center text-color"},Be={class:"full-width"},Ne=l("div",{class:"text-center full-width"},[l("p",{class:"page-header"},"FORM-4"),l("p",{class:"page-description"},"(Family Oriented SEDP hnuaia thlan tur chhungkua Village?local Level SEDP Committee ten District Level Committee hnenah rawtna an thlenna)")],-1),Qe=l("br",null,null,-1),De={class:"col-xs-12 col-sm-6"},Ae={class:"col-xs-12 col-sm-6"},Ee={class:"col-xs-12 col-sm-6"},Fe={class:"col-xs-12 col-sm-6"},He={class:"col-xs-12 col-sm-6"},Ie={class:"col-xs-12 col-sm-6"},Me={class:"col-xs-12 col-sm-6"},Le={class:"col-xs-12 col-sm-6"},Oe={class:"col-xs-12 col-sm-6"},Pe=l("div",{class:"col-xs-12"},[l("p",{class:"q-mt-md text-lg text-color"},"Bank Account")],-1),$e={class:"col-xs-12 col-sm-6"},je={class:"col-xs-12 col-sm-6"},Ke={class:"col-xs-12 col-sm-6"},Re={class:"col-xs-12 col-sm-6"},ze={class:"col-xs-12 col-sm-6"},Ge={class:"col-xs-12"},Je={class:"flex q-gutter-sm"},or={__name:"Create",props:["districts","departments"],setup(_){const d=ve(),r=ye({head_of_family:"",mobile:"",epic_no:"",address:"",district:null,constituency:null,department:null,trade:null,subTrade:null,bank_name:"",branch_name:"",ac_holder:"",ac_no:"",ifsc:""});me({name:"",relation:""});const m=me({constituencies:[],trades:[],subTrades:[]}),_e=i=>{r.transform(e=>{var t,n,c,p;return{...e,district_id:(t=e.district)==null?void 0:t.value,constituency_id:(n=e.constituency)==null?void 0:n.value,department_id:(c=e.department)==null?void 0:c.value,trade_id:e.trade.value,subtrade_id:((p=e==null?void 0:e.subTrade)==null?void 0:p.value)||null}}).post(route("application.store"),{onStart:e=>d.loading.show({message:"Submitting ..."}),onError:e=>console.log(e),onFinish:e=>d.loading.hide()})},be=i=>{i&&(r.constituency=null,d.loading.show(),axios.get(route("option.district.constituencies",i.value)).then(e=>{const{list:t}=e.data;m.constituencies=t}).catch(e=>{var t,n;d.notify({type:"negative",message:((n=(t=e==null?void 0:e.response)==null?void 0:t.data)==null?void 0:n.message)||e.toString()})}).finally(()=>d.loading.hide()))},he=i=>{i&&(r.trade=null,r.subTrade=null,d.loading.show(),axios.get(route("option.department.trades",i.value)).then(e=>{const{list:t}=e.data;m.trades=t}).catch(e=>{var t,n;d.notify({type:"negative",message:((n=(t=e==null?void 0:e.response)==null?void 0:t.data)==null?void 0:n.message)||e.toString()})}).finally(()=>d.loading.hide()))};xe(()=>{});const Ve=i=>{i&&(r.subTrade=null,d.loading.show(),axios.get(route("option.trade.subtrades",i.value)).then(e=>{const{list:t}=e.data;m.subTrades=t}).catch(e=>{var t,n;return d.notify({type:"negative",message:((n=(t=e==null?void 0:e.response)==null?void 0:t.data)==null?void 0:n.message)||e.toString()})}).finally(()=>d.loading.hide()))};return(i,e)=>(ce(),qe("div",Te,[l("div",Ue,[l("div",Be,[Ne,a(fe,null,{default:pe(()=>[a(ue,{href:i.route("dashboard"),label:"Dashboard",icon:"o_dashboard"},null,8,["href"]),a(ue,{label:"New Application"})]),_:1}),a(Se,{class:"full-width q-my-sm"})])]),Qe,a(Ce,{onSubmit:_e,class:"row q-col-gutter-sm"},{default:pe(()=>{var t,n,c,p,b,h,V,f,v,y,x,q,S,k,w,C,T,U,B,N,Q,D,A,E,F,H,I,M,L,O,P,$,j,K,R,z,G,J,W,X,Y,Z,ee,re,oe,se,le,te,ae,ne,ie,de;return[l("div",De,[a(u,{modelValue:s(r).head_of_family,"onUpdate:modelValue":e[0]||(e[0]=o=>s(r).head_of_family=o),"no-error-icon":"",placeholder:"Chhungkaw hotu hming",outlined:"",error:!!((n=(t=s(r))==null?void 0:t.errors)!=null&&n.head_of_family),"error-message":(p=(c=s(r))==null?void 0:c.errors)==null?void 0:p.head_of_family,rules:[o=>!!o||"Head of family is required"],label:"Head of Family *"},null,8,["modelValue","error","error-message","rules"])]),l("div",Ae,[a(u,{modelValue:s(r).mobile,"onUpdate:modelValue":e[1]||(e[1]=o=>s(r).mobile=o),mask:"##########","no-error-icon":"",outlined:"",error:!!((h=(b=s(r))==null?void 0:b.errors)!=null&&h.mobile),"error-message":(f=(V=s(r))==null?void 0:V.errors)==null?void 0:f.mobile,rules:[o=>!!o||"Mobile is required"],label:"Mobile No *"},null,8,["modelValue","error","error-message","rules"])]),l("div",Ee,[a(u,{modelValue:s(r).epic_no,"onUpdate:modelValue":e[2]||(e[2]=o=>s(r).epic_no=o),"no-error-icon":"",outlined:"",error:!!((y=(v=s(r))==null?void 0:v.errors)!=null&&y.epic_no),"error-message":(q=(x=s(r))==null?void 0:x.errors)==null?void 0:q.epic_no,rules:[o=>!!o||"Epic No is required"],label:"Voter Epic No *"},null,8,["modelValue","error","error-message","rules"])]),l("div",Fe,[a(u,{modelValue:s(r).address,"onUpdate:modelValue":e[3]||(e[3]=o=>s(r).address=o),type:"textarea",placeholder:"House No,Veng,Khua,District","no-error-icon":"",outlined:"",error:(k=(S=s(r))==null?void 0:S.errors)==null?void 0:k.address,"error-message":(C=(w=s(r))==null?void 0:w.errors)==null?void 0:C.address,rules:[o=>!!o||"Address is required"],label:"Address *"},null,8,["modelValue","error","error-message","rules"])]),l("div",He,[a(g,{modelValue:s(r).district,"onUpdate:modelValue":[e[4]||(e[4]=o=>s(r).district=o),be],options:_.districts,"no-error-icon":"",outlined:"",error:!!((U=(T=s(r))==null?void 0:T.errors)!=null&&U.district),"error-message":(N=(B=s(r))==null?void 0:B.errors)==null?void 0:N.district,rules:[o=>!!o||"District is required"],label:"District *"},null,8,["modelValue","options","error","error-message","rules"])]),l("div",Ie,[a(g,{modelValue:s(r).constituency,"onUpdate:modelValue":e[5]||(e[5]=o=>s(r).constituency=o),options:m.constituencies,"no-error-icon":"",outlined:"",error:!!((D=(Q=s(r))==null?void 0:Q.errors)!=null&&D.constituency_id),"error-message":(E=(A=s(r))==null?void 0:A.errors)==null?void 0:E.constituency_id,rules:[o=>!!o||"Constituency is required"],label:"Constituency *"},null,8,["modelValue","options","error","error-message","rules"])]),l("div",Me,[a(g,{modelValue:s(r).department,"onUpdate:modelValue":[e[6]||(e[6]=o=>s(r).department=o),he],options:_.departments,outlined:"","no-error-icon":"",error:!!((H=(F=s(r))==null?void 0:F.errors)!=null&&H.department_id),"error-message":(M=(I=s(r))==null?void 0:I.errors)==null?void 0:M.department_id,rules:[o=>!!o||"Department is required"],label:"Department *"},null,8,["modelValue","options","error","error-message","rules"])]),l("div",Le,[a(g,{modelValue:s(r).trade,"onUpdate:modelValue":[e[7]||(e[7]=o=>s(r).trade=o),Ve],"input-debounce":800,options:m.trades,"no-error-icon":"",outlined:"",error:!!((O=(L=s(r))==null?void 0:L.errors)!=null&&O.trade_id),"error-message":($=(P=s(r))==null?void 0:P.errors)==null?void 0:$.trade_id,rules:[o=>!!o||"Trade is required"],label:"Trade *"},null,8,["modelValue","options","error","error-message","rules"])]),l("div",Oe,[m.subTrades.length>0?(ce(),ke(g,{key:0,modelValue:s(r).subTrade,"onUpdate:modelValue":e[8]||(e[8]=o=>s(r).subTrade=o),outlined:"",options:m.subTrades,label:"Sub Trade"},null,8,["modelValue","options"])):we("",!0)]),Pe,l("div",$e,[a(u,{modelValue:s(r).ac_no,"onUpdate:modelValue":e[9]||(e[9]=o=>s(r).ac_no=o),error:!!((K=(j=s(r))==null?void 0:j.errors)!=null&&K.ac_no),"error-message":(z=(R=s(r))==null?void 0:R.errors)==null?void 0:z.ac_no,"no-error-icon":"",outlined:"",rules:[o=>!!o||"Account No is required"],label:"Account No *"},null,8,["modelValue","error","error-message","rules"])]),l("div",je,[a(u,{modelValue:s(r).bank_name,"onUpdate:modelValue":e[10]||(e[10]=o=>s(r).bank_name=o),error:!!((J=(G=s(r))==null?void 0:G.errors)!=null&&J.bank_name),"error-message":(X=(W=s(r))==null?void 0:W.errors)==null?void 0:X.bank_name,"no-error-icon":"",outlined:"",rules:[o=>!!o||"Bank name is required"],label:"Bank Name *"},null,8,["modelValue","error","error-message","rules"])]),l("div",Ke,[a(u,{modelValue:s(r).branch_name,"onUpdate:modelValue":e[11]||(e[11]=o=>s(r).branch_name=o),error:!!((Z=(Y=s(r))==null?void 0:Y.errors)!=null&&Z.branch_name),"error-message":(re=(ee=s(r))==null?void 0:ee.errors)==null?void 0:re.branch_name,"no-error-icon":"",outlined:"",rules:[o=>!!o||"Branch name is required"],label:"Branch Name *"},null,8,["modelValue","error","error-message","rules"])]),l("div",Re,[a(u,{modelValue:s(r).ac_holder,"onUpdate:modelValue":e[12]||(e[12]=o=>s(r).ac_holder=o),error:!!((se=(oe=s(r))==null?void 0:oe.errors)!=null&&se.ac_holder),"error-message":(te=(le=s(r))==null?void 0:le.errors)==null?void 0:te.ac_holder,"no-error-icon":"",outlined:"",rules:[o=>!!o||"Account holder is required"],label:"Account Holder *"},null,8,["modelValue","error","error-message","rules"])]),l("div",ze,[a(u,{modelValue:s(r).ifsc,"onUpdate:modelValue":e[13]||(e[13]=o=>s(r).ifsc=o),error:!!((ne=(ae=s(r))==null?void 0:ae.errors)!=null&&ne.ifsc),"error-message":(de=(ie=s(r))==null?void 0:ie.errors)==null?void 0:de.ifsc,"no-error-icon":"",outlined:"",rules:[o=>!!o||"IFSC is required",o=>(o==null?void 0:o.length)===11||"IFSC Code must be 11 character"],label:"IFSC *"},null,8,["modelValue","error","error-message","rules"])]),l("div",Ge,[l("div",Je,[a(ge,{type:"submit",color:"accent",label:"Submit"}),a(ge,{onClick:e[14]||(e[14]=o=>i.$inertia.get(i.route("application.received"))),color:"negative",label:"Cancel"})])])]}),_:1})]))}};export{or as default};
