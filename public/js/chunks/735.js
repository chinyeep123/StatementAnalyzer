(self.webpackChunkaddons=self.webpackChunkaddons||[]).push([[735],{1735:(t,e,r)=>{"use strict";r.r(e),r.d(e,{default:()=>o});const n={head:{title:function(){return{inner:"Order"}}},data:function(){return{endpoint:"/datatable/orders"}},methods:{destroy:function(t){axios.delete("/api/matrices/"+t).then((function(t){}))}}};const o=(0,r(1900).Z)(n,(function(){var t=this,e=t.$createElement,r=t._self._c||e;return r("div",[r("portal",{attrs:{to:"title"}},[r("app-title",{attrs:{icon:"layer-group"}},[t._v("Order")])],1),t._v(" "),r("div",{staticClass:"row"},[r("div",{staticClass:"content-container"},[r("p-table",{key:"orders_table",attrs:{endpoint:t.endpoint,id:"orders","sort-by":"created_at","sort-in":"desc","primary-key":"id"},scopedSlots:t._u([{key:"number",fn:function(e){return[r("div",{staticClass:"flex items-center"},[r("router-link",{attrs:{to:{name:"order.show",params:{order:e.record.number}}}},[t._v(t._s(e.record.number))])],1)]}},{key:"totalInUserCurrency",fn:function(e){return[t._v("\n                        "+t._s(e.record.displayTotal)+"\n                    ")]}},{key:"type",fn:function(e){return[r("span",{staticClass:"badge"},[t._v(t._s(e.record.type))])]}},{key:"description",fn:function(e){return[r("span",{staticClass:"text-gray-800 text-sm"},[t._v(t._s(e.record.description))])]}}])})],1)]),t._v(" "),r("portal",{attrs:{to:"modals"}},[r("p-modal",{key:"delete_matrix",attrs:{name:"delete-matrix",title:"Delete Matrix"},scopedSlots:t._u([{key:"footer",fn:function(e){return[r("p-button",{directives:[{name:"modal",rawName:"v-modal:delete-matrix",arg:"delete-matrix"}],staticClass:"ml-3",attrs:{theme:"danger"},on:{click:function(r){return t.destroy(e.data.id)}}},[t._v("Delete")]),t._v(" "),r("p-button",{directives:[{name:"modal",rawName:"v-modal:delete-matrix",arg:"delete-matrix"}]},[t._v("Cancel")])]}}])},[r("p",[t._v("Are you sure you want to permenantly delete this matrix?")])])],1)],1)}),[],!1,null,null,null).exports},1900:(t,e,r)=>{"use strict";function n(t,e,r,n,o,a,s,i){var d,l="function"==typeof t?t.options:t;if(e&&(l.render=e,l.staticRenderFns=r,l._compiled=!0),n&&(l.functional=!0),a&&(l._scopeId="data-v-"+a),s?(d=function(t){(t=t||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(t=__VUE_SSR_CONTEXT__),o&&o.call(this,t),t&&t._registeredComponents&&t._registeredComponents.add(s)},l._ssrRegister=d):o&&(d=i?function(){o.call(this,(l.functional?this.parent:this).$root.$options.shadowRoot)}:o),d)if(l.functional){l._injectStyles=d;var c=l.render;l.render=function(t,e){return d.call(e),c(t,e)}}else{var u=l.beforeCreate;l.beforeCreate=u?[].concat(u,d):[d]}return{exports:t,options:l}}r.d(e,{Z:()=>n})}}]);