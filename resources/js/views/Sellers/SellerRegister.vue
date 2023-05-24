<template>
    <div class="auth">
        <div class="login-wrapper">
            <div class="auth-section">
                <div class="auth-back">
                    <router-link to="/seller/login"><span class="fa fa-arrow-left"></span></router-link>
                </div>
                <div class="auth-card">
                    <div class="auth-logo">
                        <a href="javascript:void(0)"
                           style="display: flex; align-items: center; justify-content: flex-start;">
                            <img v-if="$appLogo != ''" :src="$storageUrl+$appLogo" style="height: 70px; width: 70px;"
                                 alt='Logo'/>
                            <img v-else :src="$baseUrl + '/images/logo.png'" style="height: 70px; width: 70px;"
                                 alt='Logo'/>
                            <h2 style="margin: 10px;">{{ $appName }}</h2>
                        </a>
                    </div>
                    <h4>Seller Register</h4>
                    <p class="auth-subtitle text-primary">Input your data to register to our website.</p>
                    <form ref="my-form" @submit.prevent="registerSeller">

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" placeholder="Username" required
                                   v-model="seller.username">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" placeholder="Store Name" required
                                   v-model="seller.store_name">
                            <div class="form-control-icon">
                                <i class="bi bi-shop-window"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" class="form-control form-control-xl" placeholder="Email" required
                                   v-model="seller.email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="number" class="form-control form-control-xl" placeholder="Mobile" required
                                   v-model="seller.mobile">
                            <div class="form-control-icon">
                                <i class="bi bi-phone"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Password" required
                                   v-model="seller.password">
                            <div class="form-control-icon">
                                <i class="fa bi-shield-lock"></i>
                            </div>
                        </div>

                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" placeholder="Confirm Password"
                                   required v-model="seller.password_confirmation ">
                            <div class="form-control-icon">
                                <i class="bi bi-lock"></i>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">
                            Sign Up
                            <b-spinner v-if="isLoading" small label="Spinning"></b-spinner>
                        </button>

                    </form>
                    <div class="auth-copyright">
                        <a href="javascript:void(0)" class="text-primary font-weight-normal"> @ 2022 eGrocer. All Right
                            Reserved</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from 'axios';
import Auth from '../../Auth.js';

export default {
    data: function () {
        return {
            isLoading: false,
            seller: {
                username: '',
                email: '',
                mobile: '',
                store_name: '',
                password: '',
                password_confirmation: '',
            },
            loggedUser: Auth.user
        };
    },
    mounted() {
        if (this.loggedUser) {
            this.$router.push('/dashboard');
        }
    },
    methods: {
        registerSeller: function () {
            let vm = this;
            this.isLoading = true;

            let url = this.$apiUrl + '/seller/register';
            axios.post(url, this.seller).then(res => {
                vm.isLoading = false;
                let data = res.data;
                if (data.status === 1) {

                    this.showMessage("success", data.message);
                    setTimeout(() => {
                        this.$router.push('/login');
                    }, 1000);


                } else {
                    vm.showError(data.message);
                }

            }).catch(error => {
                console.log(error)
                vm.isLoading = false;
                if (error.request.statusText) {
                    this.showError(error.request.statusText);
                } else if (error.message) {
                    this.showError(error.message);
                } else {
                    this.showError("Something went wrong!");
                }
            });
        }
    }
}
</script>

