(self.webpackChunkaddons=self.webpackChunkaddons||[]).push([[172],{6700:(e,t,n)=>{"use strict";n.d(t,{Z:()=>o});var r=n(3645),a=n.n(r)()((function(e){return e[1]}));a.push([e.id,"@-webkit-keyframes spin{to{transform:rotate(1turn)}}.animate-spin{-webkit-animation:spin 1s linear infinite;animation:spin 1s linear infinite}",""]);const o=a},3645:e=>{"use strict";e.exports=function(e){var t=[];return t.toString=function(){return this.map((function(t){var n=e(t);return t[2]?"@media ".concat(t[2]," {").concat(n,"}"):n})).join("")},t.i=function(e,n,r){"string"==typeof e&&(e=[[null,e,""]]);var a={};if(r)for(var o=0;o<this.length;o++){var i=this[o][0];null!=i&&(a[i]=!0)}for(var s=0;s<e.length;s++){var l=[].concat(e[s]);r&&a[l[0]]||(n&&(l[2]?l[2]="".concat(n," and ").concat(l[2]):l[2]=n),t.push(l))}},t}},8307:(__unused_webpack_module,__webpack_exports__,__webpack_require__)=>{"use strict";__webpack_require__.d(__webpack_exports__,{Z:()=>__WEBPACK_DEFAULT_EXPORT__});const __WEBPACK_DEFAULT_EXPORT__={data:()=>({meta:{},loading:!1}),methods:{processApi(e,t){e=this.parseApi(e,t),this.loading=!0,axios[e.method](e.url).then((e=>{this.loading=!1,console.log("loaded")})).then((t=>this.parse(e.success))).catch((e=>{this.loading=!1,toast("Error: "+e.response.data.message,"failed")}))},parseApi(api,table){return{method:api.method,url:this.parse(api.url,table),success:eval(api.success)}},parseLabel(e,t){return this.parse(e,t)},parse(functionOrValue,table,defaultValue){try{functionOrValue=eval(functionOrValue)}catch(e){}return"function"==typeof functionOrValue?functionOrValue(table):void 0===functionOrValue?defaultValue:functionOrValue}}}},3379:(e,t,n)=>{"use strict";var r,a=function(){return void 0===r&&(r=Boolean(window&&document&&document.all&&!window.atob)),r},o=function(){var e={};return function(t){if(void 0===e[t]){var n=document.querySelector(t);if(window.HTMLIFrameElement&&n instanceof window.HTMLIFrameElement)try{n=n.contentDocument.head}catch(e){n=null}e[t]=n}return e[t]}}(),i=[];function s(e){for(var t=-1,n=0;n<i.length;n++)if(i[n].identifier===e){t=n;break}return t}function l(e,t){for(var n={},r=[],a=0;a<e.length;a++){var o=e[a],l=t.base?o[0]+t.base:o[0],c=n[l]||0,d="".concat(l," ").concat(c);n[l]=c+1;var u=s(d),p={css:o[1],media:o[2],sourceMap:o[3]};-1!==u?(i[u].references++,i[u].updater(p)):i.push({identifier:d,updater:h(p,t),references:1}),r.push(d)}return r}function c(e){var t=document.createElement("style"),r=e.attributes||{};if(void 0===r.nonce){var a=n.nc;a&&(r.nonce=a)}if(Object.keys(r).forEach((function(e){t.setAttribute(e,r[e])})),"function"==typeof e.insert)e.insert(t);else{var i=o(e.insert||"head");if(!i)throw new Error("Couldn't find a style target. This probably means that the value for the 'insert' parameter is invalid.");i.appendChild(t)}return t}var d,u=(d=[],function(e,t){return d[e]=t,d.filter(Boolean).join("\n")});function p(e,t,n,r){var a=n?"":r.media?"@media ".concat(r.media," {").concat(r.css,"}"):r.css;if(e.styleSheet)e.styleSheet.cssText=u(t,a);else{var o=document.createTextNode(a),i=e.childNodes;i[t]&&e.removeChild(i[t]),i.length?e.insertBefore(o,i[t]):e.appendChild(o)}}function f(e,t,n){var r=n.css,a=n.media,o=n.sourceMap;if(a?e.setAttribute("media",a):e.removeAttribute("media"),o&&"undefined"!=typeof btoa&&(r+="\n/*# sourceMappingURL=data:application/json;base64,".concat(btoa(unescape(encodeURIComponent(JSON.stringify(o))))," */")),e.styleSheet)e.styleSheet.cssText=r;else{for(;e.firstChild;)e.removeChild(e.firstChild);e.appendChild(document.createTextNode(r))}}var m=null,_=0;function h(e,t){var n,r,a;if(t.singleton){var o=_++;n=m||(m=c(t)),r=p.bind(null,n,o,!1),a=p.bind(null,n,o,!0)}else n=c(t),r=f.bind(null,n,t),a=function(){!function(e){if(null===e.parentNode)return!1;e.parentNode.removeChild(e)}(n)};return r(e),function(t){if(t){if(t.css===e.css&&t.media===e.media&&t.sourceMap===e.sourceMap)return;r(e=t)}else a()}}e.exports=function(e,t){(t=t||{}).singleton||"boolean"==typeof t.singleton||(t.singleton=a());var n=l(e=e||[],t);return function(e){if(e=e||[],"[object Array]"===Object.prototype.toString.call(e)){for(var r=0;r<n.length;r++){var a=s(n[r]);i[a].references--}for(var o=l(e,t),c=0;c<n.length;c++){var d=s(n[c]);0===i[d].references&&(i[d].updater(),i.splice(d,1))}n=o}}}},5071:(e,t,n)=>{"use strict";n.d(t,{Z:()=>l});const r={props:{variant:{default:"white"},text:{default:""},containerClass:{}},computed:{containerClassName(){return"inline-flex "+this.containerClass},className(){return"text-"+this.variant}}};var a=n(3379),o=n.n(a),i=n(6700),s={insert:"head",singleton:!1};o()(i.Z,s);i.Z.locals;const l=(0,n(1900).Z)(r,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{class:e.containerClassName},[n("svg",{class:"animate-spin -ml-1 mr-3 h-5 w-5 "+e.className,attrs:{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24"}},[n("circle",{staticClass:"opacity-25",attrs:{cx:"12",cy:"12",r:"10",stroke:"currentColor","stroke-width":"4"}}),e._v(" "),n("path",{staticClass:"opacity-75",attrs:{fill:"currentColor",d:"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"}})]),e._v(e._s(e.text)+"\n")])}),[],!1,null,null,null).exports},5172:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>l});var r=n(8307);const a={props:{loading:{}},mixins:[{components:{},methods:{closeModal(e,t){this.$bus.$emit("toggle-modal-"+e,t)},openModal(e,t){this.$bus.$emit("toggle-modal-"+e,t)}}}],components:{Spinner:n(5071).Z},mounted:function(){this.openModal("loader-modal")}};var o=n(1900);const i=(0,o.Z)(a,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return e.loading?n("div",[n("p-modal",{key:"loader_modal",attrs:{name:"loader-modal",title:""}},[n("template",{slot:"header"},[e._v(" ")]),e._v(" "),n("div",{staticClass:"flex justify-center items-center"},[n("spinner",{attrs:{variant:"black"}})],1),e._v(" "),n("template",{slot:"footer"},[e._v(" ")])],2)],1):e._e()}),[],!1,null,null,null).exports,s={mixins:[r.Z],components:{LoaderModal:i},head:{title:function(){return{inner:"Order"}}},data:function(){return{meta:{},loading:!1,endpoint:"/datatable/orders"}},computed:{hasActions:function(){return console.log("meta",this.meta),!0}},methods:{destroy:function(e){axios.delete("/api/matrices/"+e).then((function(e){}))}},beforeRouteEnter:function(e,t,n){axios.get("/api/order/meta").then((function(e){n((function(t){t.meta=e.data.data,t.$emit("updateHead")}))})).catch((function(e){n("/"),toast("The requested meta data could not be found","warning")}))},beforeRouteUpdate:function(e,t,n){var r=this;axios.get("/api/order/meta").then((function(e){r.meta=e.data.data,r.$emit("updateHead")})),n()}};const l=(0,o.Z)(s,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("portal",{attrs:{to:"title"}},[n("page-title",{attrs:{icon:"layer-group"}},[e._v("Order")])],1),e._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"content-container"},[n("p-table",{key:"orders_table",attrs:{endpoint:e.endpoint,id:"orders","sort-by":"created_at","sort-in":"desc","primary-key":"id"},scopedSlots:e._u([{key:"number",fn:function(t){return[n("div",{staticClass:"flex items-center"},[n("router-link",{attrs:{to:{name:"order.show",params:{order:t.record.number}}}},[e._v(e._s(t.record.number))])],1)]}},{key:"totalInUserCurrency",fn:function(t){return[e._v("\n                        "+e._s(t.record.displayTotal)+"\n                    ")]}},{key:"type",fn:function(t){return[n("span",{staticClass:"badge"},[e._v(e._s(t.record.type))])]}},{key:"description",fn:function(t){return[n("span",{staticClass:"text-gray-800 text-sm"},[e._v(e._s(t.record.description))])]}},{key:"actions",fn:function(t){return e.hasActions?[n("p-actions",{key:"order_actions",attrs:{id:"order_actions"}},e._l(e.meta.buttons.line,(function(r,a){return e.parse(r.visible,t,!0)?n("p-dropdown-link",{key:a,attrs:{to:r.route},on:{click:function(n){return e.processApi(r.api,t)}}},[e._v(e._s(e.parseLabel(r.label,t)))]):e._e()})),1)]:void 0}}],null,!0)})],1)]),e._v(" "),n("portal",{attrs:{to:"modals"}},[n("loader-modal",{attrs:{loading:e.loading}}),e._v(" "),n("p-modal",{key:"delete_matrix",attrs:{name:"delete-matrix",title:"Delete Matrix"},scopedSlots:e._u([{key:"footer",fn:function(t){return[n("p-button",{directives:[{name:"modal",rawName:"v-modal:delete-matrix",arg:"delete-matrix"}],staticClass:"ml-3",attrs:{theme:"danger"},on:{click:function(n){return e.destroy(t.data.id)}}},[e._v("Delete")]),e._v(" "),n("p-button",{directives:[{name:"modal",rawName:"v-modal:delete-matrix",arg:"delete-matrix"}]},[e._v("Cancel")])]}}])},[n("p",[e._v("Are you sure you want to permenantly delete this matrix?")])])],1)],1)}),[],!1,null,null,null).exports},1900:(e,t,n)=>{"use strict";function r(e,t,n,r,a,o,i,s){var l,c="function"==typeof e?e.options:e;if(t&&(c.render=t,c.staticRenderFns=n,c._compiled=!0),r&&(c.functional=!0),o&&(c._scopeId="data-v-"+o),i?(l=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),a&&a.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(i)},c._ssrRegister=l):a&&(l=s?function(){a.call(this,(c.functional?this.parent:this).$root.$options.shadowRoot)}:a),l)if(c.functional){c._injectStyles=l;var d=c.render;c.render=function(e,t){return l.call(t),d(e,t)}}else{var u=c.beforeCreate;c.beforeCreate=u?[].concat(u,l):[l]}return{exports:e,options:c}}n.d(t,{Z:()=>r})}}]);