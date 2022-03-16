<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Changed Password</h6>
                    <button type="button" @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" v-model="fields.password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">Confirm Password</label>
                                <input type="password" v-model="fields.confirmPassword" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" @click="changePassword" class="btn btn-primary">Save
                                    changes</button>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click.prevent="close" class="btn btn-link  ml-auto"
                        data-dismiss="modal">Close</button>
                </div>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                showClientPopup: false,
                fields: {
                    password: null,
                    confirmPassword: null
                }
            }
        },
        props: {
            showPopup: {
                required: true,
                type: Boolean
            },
            client: {
                required: false,
                type: Object
            },
            time: {
                required: false,
                type: Number
            }
        },
        mounted() {

        },
        watch: {

        },
        methods: {
            close() {
                this.$emit('close', this.client)
            },
            changePassword() {

                let $this = this;

                if (!this.fields.password) {
                    this.$toastr.e('Password is required')
                    return;
                }

                if (!this.fields.confirmPassword) {
                    this.$toastr.e('Confirm Password is required')
                    return;
                }

                if (this.fields.password != this.fields.confirmPassword) {
                    this.$toastr.e('Password and Confirm Password are not match')
                    return;
                }

                axios({
                        method: 'post',
                        url: `/api/v1/client/change-password/${this.client.id}?api_token=${window.Laravel.api_token}`,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.close()
                            $this.$toastr.s(response.data.message)
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                        this.fields.password = null
                        this.fields.confirmPassword = null
                        JsLoadingOverlay.hide();
                    });

            }
        }
    }

</script>

<style scoped>
    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter,
    .fade-leave-to {
        opacity: 0;
    }

    .slide-enter-active,
    .slide-leave-active {
        transition: transform .5s;
    }

    .slide-enter,
    .slide-leave-to {
        transform: translateY(-50%) translateX(100vw);
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 900;
        background-color: rgba(0, 0, 0, 0.3);
    }

    .modal {
        position: fixed;
        top: 4%;
        left: 27%;
        z-index: 1000;
        width: 100%;
        max-width: 50%;
        background-color: #FFF;
        border-radius: 16px;
        padding: 0px;
        display: block;
        height: max-content;
    }

    h1 {
        font-size: 24px;
        line-height: 1px;
    }

    .right {
        float: right;
    }


    .btn {
        font-size: .875rem;
        position: relative;
        transition: all .15s ease;
        letter-spacing: .025em;
        text-transform: none;
        will-change: transform;
    }

    .btn-primary {
        color: #fff;
        border-color: #f26f24;
        background-color: #f26f24;
        box-shadow: 0 4px 6px rgb(50 50 93 / 11%), 0 1px 3px rgb(0 0 0 / 8%);
    }

    .modal-footer {
        padding: 10px;
    }

    .modal-body {
        padding: 10px;
    }

</style>
