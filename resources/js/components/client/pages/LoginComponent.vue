<template>

    <div class="row">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <a href="https://creativouae.com/">← Back to Website</a>
            <div id="login" class="text-center">
                <img class="img-fluid" src="/logo-creativo-normal.png" alt="Creativo" />

                <!--Login-->
                <div id="form" class="form-login" v-if="login_page">
                    <h1> Login</h1>
                    <div class="form-group">
                        <input type="email" v-model="collection.email" class="form-control" placeholder="Email Address">
                    </div>
                    <div class="form-group">
                        <template v-if="isPasswordShown">
                            <i class="far fa-eye" @click="unToggleEyeIcon()" id="togglePassword" style="margin-left: 200px;
    cursor: pointer;
    margin-top: 5px;
    position: fixed;"></i>
                        </template>
                        <template v-else>
                            <i class="far fa-eye-slash" @click="toggleEyeIcon()" id="togglePassword" style="margin-left: 200px;
    cursor: pointer;
    margin-top: 5px;
    position: fixed;"></i>
                        </template>
                        <input type="password" id="password" v-model="collection.password" class="form-control"
                            placeholder="Password">

                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6"></div>
                            <div class="col-lg-6">
                                <input type="submit" @click="login" class="form-control" value="Login →">
                            </div>
                        </div>
                    </div>
                    <div id="forgot" class="col-lg-12 text-left">
                        <p>Forgot password? <a href="#" @click="login_page=false;password_page=true">Click here.</a></p>
                    </div>
                </div>

                <!--Forgot-->
                <div class="" v-if="password_page">
                    <h1>Forgot Password</h1>
                    <div id="form">
                        <div class="form-group">
                            <input type="email" class="form-control" v-model="reset.email" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-6"></div>
                                <div class="col-lg-6">
                                    <input type="submit" @click="forgot_password()" class="form-control"
                                        value="Submit →">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="forgot" class="col-lg-12 text-left">
                        <a href="#" @click="password_page=false;login_page=true">← Back to Login</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
</template>

<script>
    export default {

        data() {
            return {

                collection: {
                    email: '',
                    password: '',
                },
                reset: {
                    email: '',
                },

                is_success: true,
                login_page: true,
                password_page: false,
                isPasswordShown: false
            };
        },
        props: [
            'login_route',
        ],
        methods: {

            login() {

                let data = this.collection
                var _this = this

                if (data.email == '') {
                    this.$toastr.e(
                        "Please Enter your Email"
                    );
                    return;
                }
                if (data.password == '') {
                    this.$toastr.e(
                        "Please enter your password"
                    );
                    return;
                }

                JsLoadingOverlay.show(this.$configs);

                axios.post(this.login_route, data).then(function (response) {
                        JsLoadingOverlay.hide();
                        if (response.data.status) {
                            window.location.href = response.data.redirect_url
                        } else {
                            this.$toastr.e(
                                "Email and Password is not Match"
                            );
                        }
                    }).catch(error => {
                        this.message(error.response)
                    })
                    .then(function () {
                        JsLoadingOverlay.hide();
                    });


            },

            message(response) {
                console.log(response)
                this.$toastr.e(
                    "User not found or your password is mismatch. Please try again."
                );
            },

            forgot_password() {

                let $this = this

                if (!this.reset.email) {
                    this.$toastr.e('Please enter your email address.')
                    return;
                }

                JsLoadingOverlay.show(this.$configs);

                axios({
                        method: 'post',
                        url: `/auth/reset-password/`,
                        data: {
                            email: $this.reset.email
                        }
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('We have sent you an email containing the reset password link.')
                        } else {
                            $this.$toastr.e(response.data.msg)
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                        JsLoadingOverlay.hide();
                    });

            },
            toggleEyeIcon() {
                const password = document.getElementById('password'); // Removed '#' from the ID selector
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type); // Update the 'type' attribute to toggle visibility
                this.isPasswordShown = true
            },
            unToggleEyeIcon() {
               const password = document.getElementById('password'); // Removed '#' from the ID selector
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type); // Update the 'type' attribute to toggle visibility
                this.isPasswordShown = false
            }
        },
        created: function () {
            console.log('realoaded')
        },
        mounted: function () {
            this.$toastr.defaultPosition = "toast-top-right";
        }
    }


//     const togglePassword = document.querySelector('#togglePassword');
//   const password = document.querySelector('#id_password');

//   togglePassword.addEventListener('click', function (e) {
//     // toggle the type attribute
//     const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
//     password.setAttribute('type', type);
//     // toggle the eye slash icon
//     this.classList.toggle('fa-eye-slash');
// });

</script>

<style>

</style>
