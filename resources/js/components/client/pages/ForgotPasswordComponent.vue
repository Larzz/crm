<template>

    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <!-- <a href="https://creativouae.com/">← Back to Website</a> -->
            <div id="login" class="text-center">
                <img class="img-fluid" src="/logo-creativo-normal.png" alt="Creativo" />

                <!--Login-->
                <div id="form" class="form-login">
                    <h1> Forgot Password</h1>
                    <div class="form-group">
                        <input type="password" v-model="fields.password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input type="password" v-model="fields.confirm_password" class="form-control"
                            placeholder="Confirm Password">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-lg-6"></div>
                            <div class="col-lg-6">
                                <input type="submit" @click="resetPassword" class="form-control" value="Submit →">
                            </div>
                        </div>
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
                fields: {
                    confirm_password: null,
                    password: null,
                    email: this.user.email,
                    code: this.user.reset_code
                },
            };
        },
        props: {
            user: {
                required: true,
                type: Object
            }
        }

        ,
        mounted() {
            console.log(this.user.email)
        },
        methods: {
            resetPassword() {



                if (!this.fields.password) {
                    this.$toastr.e('Please enter your new password.')
                    return;
                }
                if (!this.fields.confirm_password) {
                    this.$toastr.e('Please confirm your password.')
                    return;
                }
                if (this.fields.password != this.fields.confirm_password) {
                    this.$toastr.e('Your password does not match')
                    return;
                }

                let $this = this
                JsLoadingOverlay.show(this.$configs);

                axios({
                        method: 'post',
                        url: `/auth/change-password/`,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s(response.data.msg)

                            setTimeout(() => {
                                window.location.href = '/login'
                            }, 1000);
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
            }
        },
    }

</script>

<style>

</style>
