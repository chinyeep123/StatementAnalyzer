(self.webpackChunkaddons=self.webpackChunkaddons||[]).push([[817],{4817:(e,t,n)=>{"use strict";n.r(t),n.d(t,{default:()=>o});const r={head:{title:function(){return{inner:"Order"}}},data:function(){return{endpoint:"/datatable/orders"}},methods:{destroy:function(e){axios.delete("/api/matrices/"+e).then((function(e){}))}}};const o=(0,n(1900).Z)(r,(function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[n("portal",{attrs:{to:"title"}},[n("app-title",{attrs:{icon:"layer-group"}},[e._v("Order")])],1),e._v(" "),n("div",{staticClass:"row"},[n("div",{staticClass:"content-container"},[n("p-table",{key:"orders_table",attrs:{endpoint:e.endpoint,id:"orders","sort-by":"id","primary-key":"id"},scopedSlots:e._u([{key:"number",fn:function(t){return[n("div",{staticClass:"flex items-center"},[n("router-link",{attrs:{to:{name:"order.show",params:{order:t.record.number}}}},[e._v(e._s(t.record.number))])],1)]}},{key:"handle",fn:function(t){return[e._v("\n                        "+e._s(t.record.handle)+"\n                    ")]}},{key:"type",fn:function(t){return[n("span",{staticClass:"badge"},[e._v(e._s(t.record.type))])]}},{key:"description",fn:function(t){return[n("span",{staticClass:"text-gray-800 text-sm"},[e._v(e._s(t.record.description))])]}}])})],1)]),e._v(" "),n("portal",{attrs:{to:"modals"}},[n("p-modal",{key:"delete_matrix",attrs:{name:"delete-matrix",title:"Delete Matrix"},scopedSlots:e._u([{key:"footer",fn:function(t){return[n("p-button",{directives:[{name:"modal",rawName:"v-modal:delete-matrix",arg:"delete-matrix"}],staticClass:"ml-3",attrs:{theme:"danger"},on:{click:function(n){return e.destroy(t.data.id)}}},[e._v("Delete")]),e._v(" "),n("p-button",{directives:[{name:"modal",rawName:"v-modal:delete-matrix",arg:"delete-matrix"}]},[e._v("Cancel")])]}}])},[n("p",[e._v("Are you sure you want to permenantly delete this matrix?")])])],1)],1)}),[],!1,null,null,null).exports},1900:(e,t,n)=>{"use strict";function r(e,t,n,r,o,a,s,i){var d,l="function"==typeof e?e.options:e;if(t&&(l.render=t,l.staticRenderFns=n,l._compiled=!0),r&&(l.functional=!0),a&&(l._scopeId="data-v-"+a),s?(d=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),o&&o.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(s)},l._ssrRegister=d):o&&(d=i?function(){o.call(this,(l.functional?this.parent:this).$root.$options.shadowRoot)}:o),d)if(l.functional){l._injectStyles=d;var c=l.render;l.render=function(e,t){return d.call(t),c(e,t)}}else{var u=l.beforeCreate;l.beforeCreate=u?[].concat(u,d):[d]}return{exports:e,options:l}}n.d(t,{Z:()=>r})}}]);