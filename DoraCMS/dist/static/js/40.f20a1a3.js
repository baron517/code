webpackJsonp([40],{139:function(t,e,a){var s=a(24)(a(427),a(502),null,null,null);t.exports=s.exports},427:function(t,e,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0});var s=a(63);e.default={props:{dialogState:Object,groups:Array},data:function(){return{rules:{content:[{required:!0,message:this.$t("validate.inputNull",{label:this.$t("contentMessage.content")}),trigger:"blur"},{min:5,max:200,message:this.$t("validate.ranglengthandnormal",{min:2,max:200}),trigger:"blur"}]}}},methods:{confirm:function(){this.$store.dispatch("hideContentMessageForm")},submitForm:function(t){var e=this;this.$refs[t].validate(function(t){if(!t)return console.log("error submit!!"),!1;var a=e.dialogState.parentformData,n={};n.relationMsgId=a._id,n.contentId=a.contentId._id,n.utype="1",a.author?n.replyAuthor=a.author._id:a.adminAuthor&&(n.adminReplyAuthor=a.adminAuthor._id),n.content=e.dialogState.formData.content,s.a.addContentMessage(n).then(function(t){200===t.data.status?(e.$store.dispatch("hideContentMessageForm"),e.$store.dispatch("getContentMessageList"),e.$message({message:e.$t("main.addSuccess"),type:"success"})):e.$message.error(t.data.message)})})}}}},502:function(t,e){t.exports={render:function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",{staticClass:"dr-contentMessageForm"},[a("el-dialog",{attrs:{width:"35%",size:"small",title:t.$t("contentMessage.replyUser"),visible:t.dialogState.show,"close-on-click-modal":!1},on:{"update:visible":function(e){t.$set(t.dialogState,"show",e)}}},[a("el-form",{ref:"ruleForm",staticClass:"demo-ruleForm",attrs:{model:t.dialogState.formData,rules:t.rules,"label-width":"90px"}},[a("el-form-item",{attrs:{label:t.$t("contentMessage.userSaid")}},[t._v("\n                "+t._s(t.dialogState.parentformData.content)+"\n            ")]),t._v(" "),a("el-form-item",{attrs:{label:t.$t("contentMessage.reply"),prop:"content"}},[a("el-input",{attrs:{size:"small",type:"textarea"},model:{value:t.dialogState.formData.content,callback:function(e){t.$set(t.dialogState.formData,"content",e)},expression:"dialogState.formData.content"}})],1),t._v(" "),a("el-form-item",[a("el-button",{attrs:{size:"medium",type:"primary"},on:{click:function(e){t.submitForm("ruleForm")}}},[t._v(t._s(t.$t("contentMessage.reply")))])],1)],1)],1)],1)},staticRenderFns:[]}}});