webpackJsonp([34],{148:function(e,t,a){var l=a(24)(a(436),a(511),null,null,null);e.exports=l.exports},436:function(e,t,a){"use strict";Object.defineProperty(t,"__esModule",{value:!0});var l=a(63);t.default={props:["dialogState","forderlist"],data:function(){return{rules:{name:[{required:!0,message:this.$t("validate.inputNull",{label:this.$t("templateConfig.name")}),trigger:"blur"},{min:1,max:12,message:this.$t("validate.rangelength",{min:1,max:12}),trigger:"blur"}],forder:[{required:!0,message:this.$t("validate.inputNull",{label:this.$t("templateConfig.temp")}),trigger:"blur"},{min:1,max:30,message:this.$t("validate.rangelength",{min:1,max:30}),trigger:"blur"}],comments:[{required:!0,message:this.$t("validate.inputNull",{label:this.$t("main.comments_label")}),trigger:"blur"},{min:2,max:30,message:this.$t("validate.ranglengthandnormal",{min:2,max:30}),trigger:"blur"}]}}},methods:{confirm:function(){this.$store.dispatch("hidetemplateConfigForm")},submitForm:function(e){var t=this;this.$refs[e].validate(function(e){if(!e)return console.log("error submit!!"),!1;var a=t.dialogState.formData;t.dialogState.edit||l.a.addTemplateItem(a).then(function(e){200===e.data.status?(t.$store.dispatch("hideTemplateConfigForm"),t.$store.dispatch("getMyTemplateList"),t.$message({message:t.$t("main.addSuccess"),type:"success"})):t.$message.error(e.data.message)})})}}}},511:function(e,t){e.exports={render:function(){var e=this,t=e.$createElement,a=e._self._c||t;return a("div",{staticClass:"dr-templateConfigForm"},[a("el-dialog",{attrs:{width:"35%",size:"small",title:e.$t("templateConfig.form_title"),visible:e.dialogState.show,"close-on-click-modal":!1},on:{"update:visible":function(t){e.$set(e.dialogState,"show",t)}}},[a("el-form",{ref:"ruleForm",staticClass:"demo-ruleForm",attrs:{model:e.dialogState.formData,rules:e.rules,"label-width":"120px"}},[a("el-form-item",{attrs:{label:e.$t("templateConfig.name"),prop:"name"}},[a("el-input",{attrs:{size:"small"},model:{value:e.dialogState.formData.name,callback:function(t){e.$set(e.dialogState.formData,"name",t)},expression:"dialogState.formData.name"}})],1),e._v(" "),a("el-form-item",{attrs:{label:e.$t("templateConfig.temp"),prop:"forder"}},[a("el-select",{attrs:{size:"small",placeholder:"请选择"},model:{value:e.dialogState.formData.forder,callback:function(t){e.$set(e.dialogState.formData,"forder",t)},expression:"dialogState.formData.forder"}},e._l(e.forderlist,function(e){return a("el-option",{key:e.name,attrs:{label:e.name,value:e.name}})}))],1),e._v(" "),a("el-form-item",{attrs:{label:e.$t("main.comments_label"),prop:"comments"}},[a("el-input",{attrs:{size:"small"},model:{value:e.dialogState.formData.comments,callback:function(t){e.$set(e.dialogState.formData,"comments",t)},expression:"dialogState.formData.comments"}})],1),e._v(" "),a("el-form-item",[a("el-button",{attrs:{size:"medium",type:"primary"},on:{click:function(t){e.submitForm("ruleForm")}}},[e._v(e._s(e.dialogState.edit?e.$t("main.form_btnText_update"):e.$t("main.form_btnText_save")))])],1)],1)],1)],1)},staticRenderFns:[]}}});