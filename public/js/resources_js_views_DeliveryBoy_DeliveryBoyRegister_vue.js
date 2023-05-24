"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["resources_js_views_DeliveryBoy_DeliveryBoyRegister_vue"],{

/***/ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue?vue&type=script&lang=js&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _Auth_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../Auth.js */ "./resources/js/Auth.js");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = ({
  data: function data() {
    return {
      isLoading: false,
      delivery_boy: {
        username: '',
        email: '',
        mobile: '',
        password: '',
        password_confirmation: ''
      },
      loggedUser: _Auth_js__WEBPACK_IMPORTED_MODULE_1__["default"].user
    };
  },
  mounted: function mounted() {
    if (this.loggedUser) {
      this.$router.push('/dashboard');
    }
  },
  methods: {
    registerDeliveryBoy: function registerDeliveryBoy() {
      var _this = this;

      var vm = this;
      this.isLoading = true;
      var url = this.$apiUrl + '/delivery_boy/register';
      axios__WEBPACK_IMPORTED_MODULE_0___default().post(url, this.delivery_boy).then(function (res) {
        vm.isLoading = false;
        var data = res.data;

        if (data.status === 1) {
          _this.showMessage("success", data.message);

          setTimeout(function () {
            _this.$router.push('/login');
          }, 1000);
        } else {
          vm.showError(data.message);
        }
      })["catch"](function (error) {
        console.log(error);
        vm.isLoading = false;

        if (error.request.statusText) {
          _this.showError(error.request.statusText);
        } else if (error.message) {
          _this.showError(error.message);
        } else {
          _this.showError(__('something_went_wrong'));
        }
      });
    }
  }
});

/***/ }),

/***/ "./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue":
/*!****************************************************************!*\
  !*** ./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue ***!
  \****************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _DeliveryBoyRegister_vue_vue_type_template_id_7e2c5896___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./DeliveryBoyRegister.vue?vue&type=template&id=7e2c5896& */ "./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue?vue&type=template&id=7e2c5896&");
/* harmony import */ var _DeliveryBoyRegister_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./DeliveryBoyRegister.vue?vue&type=script&lang=js& */ "./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! !../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */
;
var component = (0,_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _DeliveryBoyRegister_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _DeliveryBoyRegister_vue_vue_type_template_id_7e2c5896___WEBPACK_IMPORTED_MODULE_0__.render,
  _DeliveryBoyRegister_vue_vue_type_template_id_7e2c5896___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns,
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue"
/* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (component.exports);

/***/ }),

/***/ "./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************!*\
  !*** ./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "default": () => (__WEBPACK_DEFAULT_EXPORT__)
/* harmony export */ });
/* harmony import */ var _node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DeliveryBoyRegister_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DeliveryBoyRegister.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js??clonedRuleSet-5[0].rules[0].use[0]!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue?vue&type=script&lang=js&");
 /* harmony default export */ const __WEBPACK_DEFAULT_EXPORT__ = (_node_modules_babel_loader_lib_index_js_clonedRuleSet_5_0_rules_0_use_0_node_modules_vue_loader_lib_index_js_vue_loader_options_DeliveryBoyRegister_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue?vue&type=template&id=7e2c5896&":
/*!***********************************************************************************************!*\
  !*** ./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue?vue&type=template&id=7e2c5896& ***!
  \***********************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DeliveryBoyRegister_vue_vue_type_template_id_7e2c5896___WEBPACK_IMPORTED_MODULE_0__.render),
/* harmony export */   "staticRenderFns": () => (/* reexport safe */ _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DeliveryBoyRegister_vue_vue_type_template_id_7e2c5896___WEBPACK_IMPORTED_MODULE_0__.staticRenderFns)
/* harmony export */ });
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_DeliveryBoyRegister_vue_vue_type_template_id_7e2c5896___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib/index.js??vue-loader-options!./DeliveryBoyRegister.vue?vue&type=template&id=7e2c5896& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue?vue&type=template&id=7e2c5896&");


/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue?vue&type=template&id=7e2c5896&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib/index.js??vue-loader-options!./resources/js/views/DeliveryBoy/DeliveryBoyRegister.vue?vue&type=template&id=7e2c5896& ***!
  \**************************************************************************************************************************************************************************************************************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony export */ __webpack_require__.d(__webpack_exports__, {
/* harmony export */   "render": () => (/* binding */ render),
/* harmony export */   "staticRenderFns": () => (/* binding */ staticRenderFns)
/* harmony export */ });
var render = function () {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "auth" }, [
    _c("div", { staticClass: "login-wrapper" }, [
      _c("div", { staticClass: "auth-section" }, [
        _c(
          "div",
          { staticClass: "auth-back" },
          [
            _c("router-link", { attrs: { to: "/delivery_boy/login" } }, [
              _c("span", { staticClass: "fa fa-arrow-left" }),
            ]),
          ],
          1
        ),
        _vm._v(" "),
        _c("div", { staticClass: "auth-card" }, [
          _c("div", { staticClass: "auth-logo" }, [
            _c(
              "a",
              {
                staticStyle: {
                  display: "flex",
                  "align-items": "center",
                  "justify-content": "flex-start",
                },
                attrs: { href: "javascript:void(0)" },
              },
              [
                _vm.$appLogo != ""
                  ? _c("img", {
                      staticStyle: { height: "70px", width: "70px" },
                      attrs: {
                        src: _vm.$storageUrl + _vm.$appLogo,
                        alt: "Logo",
                      },
                    })
                  : _c("img", {
                      staticStyle: { height: "70px", width: "70px" },
                      attrs: {
                        src: _vm.$baseUrl + "/images/logo.png",
                        alt: "Logo",
                      },
                    }),
                _vm._v(" "),
                _c("h2", { staticStyle: { margin: "10px" } }, [
                  _vm._v(_vm._s(_vm.$appName)),
                ]),
              ]
            ),
          ]),
          _vm._v(" "),
          _c("h4", [_vm._v("Delivery Boy Register")]),
          _vm._v(" "),
          _c("p", { staticClass: "auth-subtitle text-primary" }, [
            _vm._v("Input your data to register to our website."),
          ]),
          _vm._v(" "),
          _c(
            "form",
            {
              ref: "my-form",
              on: {
                submit: function ($event) {
                  $event.preventDefault()
                  return _vm.registerDeliveryBoy.apply(null, arguments)
                },
              },
            },
            [
              _c(
                "div",
                {
                  staticClass:
                    "form-group position-relative has-icon-left mb-4",
                },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.delivery_boy.username,
                        expression: "delivery_boy.username",
                      },
                    ],
                    staticClass: "form-control form-control-xl",
                    attrs: {
                      type: "text",
                      placeholder: "Username",
                      required: "",
                    },
                    domProps: { value: _vm.delivery_boy.username },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.delivery_boy,
                          "username",
                          $event.target.value
                        )
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm._m(0),
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "form-group position-relative has-icon-left mb-4",
                },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.delivery_boy.email,
                        expression: "delivery_boy.email",
                      },
                    ],
                    staticClass: "form-control form-control-xl",
                    attrs: {
                      type: "email",
                      placeholder: "Email",
                      required: "",
                    },
                    domProps: { value: _vm.delivery_boy.email },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(_vm.delivery_boy, "email", $event.target.value)
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm._m(1),
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "form-group position-relative has-icon-left mb-4",
                },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.delivery_boy.mobile,
                        expression: "delivery_boy.mobile",
                      },
                    ],
                    staticClass: "form-control form-control-xl",
                    attrs: {
                      type: "number",
                      placeholder: "Mobile",
                      required: "",
                    },
                    domProps: { value: _vm.delivery_boy.mobile },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.delivery_boy,
                          "mobile",
                          $event.target.value
                        )
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm._m(2),
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "form-group position-relative has-icon-left mb-4",
                },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.delivery_boy.password,
                        expression: "delivery_boy.password",
                      },
                    ],
                    staticClass: "form-control form-control-xl",
                    attrs: {
                      type: "password",
                      placeholder: "Password",
                      required: "",
                    },
                    domProps: { value: _vm.delivery_boy.password },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.delivery_boy,
                          "password",
                          $event.target.value
                        )
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm._m(3),
                ]
              ),
              _vm._v(" "),
              _c(
                "div",
                {
                  staticClass:
                    "form-group position-relative has-icon-left mb-4",
                },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.delivery_boy.password_confirmation,
                        expression: "delivery_boy.password_confirmation",
                      },
                    ],
                    staticClass: "form-control has-icon-left form-control-xl",
                    attrs: {
                      type: "password",
                      placeholder: "Confirm Password",
                      required: "",
                    },
                    domProps: { value: _vm.delivery_boy.password_confirmation },
                    on: {
                      input: function ($event) {
                        if ($event.target.composing) {
                          return
                        }
                        _vm.$set(
                          _vm.delivery_boy,
                          "password_confirmation",
                          $event.target.value
                        )
                      },
                    },
                  }),
                  _vm._v(" "),
                  _vm._m(4),
                ]
              ),
              _vm._v(" "),
              _c(
                "button",
                {
                  staticClass:
                    "btn btn-primary btn-block btn-lg shadow-lg mt-5",
                },
                [
                  _vm._v(
                    "\n                        Sign Up\n                        "
                  ),
                  _vm.isLoading
                    ? _c("b-spinner", {
                        attrs: { small: "", label: "Spinning" },
                      })
                    : _vm._e(),
                ],
                1
              ),
            ]
          ),
          _vm._v(" "),
          _vm._m(5),
        ]),
      ]),
    ]),
  ])
}
var staticRenderFns = [
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-control-icon" }, [
      _c("i", { staticClass: "bi bi-person" }),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-control-icon" }, [
      _c("i", { staticClass: "bi bi-envelope" }),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-control-icon" }, [
      _c("i", { staticClass: "bi bi-phone" }),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-control-icon" }, [
      _c("i", { staticClass: "bi bi-shield-lock" }),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "form-control-icon" }, [
      _c("i", { staticClass: "bi bi-lock" }),
    ])
  },
  function () {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("div", { staticClass: "auth-copyright" }, [
      _c(
        "a",
        {
          staticClass: "text-primary font-weight-normal",
          attrs: { href: "javascript:void(0)" },
        },
        [_vm._v(" @ 2022 eGrocer. All Right\n                        Reserved")]
      ),
    ])
  },
]
render._withStripped = true



/***/ })

}]);