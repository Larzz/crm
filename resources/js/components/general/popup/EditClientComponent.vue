<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Upload Meeting Minutes</h6>
                    <button type="button" @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Name</label>
                                <input type="text" v-model="fields.name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Contact Email</label>
                                <input type="email" disabled v-model="fields.email" class="form-control">
                            </div>
                            <div class="form-group" style="display:none">
                                <label for="">Password</label>
                                <input type="text" v-model="fields.password" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">URL</label>
                                <input type="text" v-model="fields.url" class="form-control">
                            </div>

                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Date Joined</label>
                                <input type="date" v-model="fields.date_joined" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">Contact Numer</label>
                                <input type="text" v-model="fields.mobile_number" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="">Service type</label>
                                <input type="text" v-model="fields.service_type" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" @click="editClient" class="btn btn-primary">Save changes</button>
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
                fields: {
                    name: null,
                    email: null,
                    password: null,
                    date_joined: null,
                    mobile_number: null,
                    service_type: null,
                    url: null
                }
            }
        },
        props: {
            showPopup: {
                required: true,
                type: Boolean
            },
            client: {
                required: true,
                type: Object
            }
        },
        mounted() {

            this.fields.name = this.client.name
            this.fields.email = this.client.email
            this.fields.password = this.client.password
            this.fields.date_joined = this.client.date_joined
            this.fields.mobile_number = this.client.mobile_number
            this.fields.service_type = this.client.service_type
            this.fields.url = this.client.url
        },
        watch: {
            client() {
                this.fields.name = this.client.name
                this.fields.email = this.client.email
                this.fields.password = this.client.password
                this.fields.date_joined = this.client.date_joined
                this.fields.mobile_number = this.client.mobile_number
                this.fields.service_type = this.client.service_type
                this.fields.url = this.client.url
            }
        },
        methods: {
            editClient() {
                let $this = this
                JsLoadingOverlay.show(this.$configs);
                axios({
                        method: 'post',
                        url: '/api/v1/client/' + this.client.id + '?api_token=' + window.Laravel.api_token,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.$toastr.s('Successfully Updated!', 'Success');
                            $this.close()
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                        JsLoadingOverlay.hide();
                    });
            },
            close() {
                this.$emit('close', this.fields)
            },
            convertDate(date) {
                function pad(s) {
                    return (s < 10) ? '0' + s : s;
                }
                var d = new Date(date)
                return [pad(d.getMonth() + 1), pad(d.getDate()), d.getFullYear()].join('/')
            }

        }
    }

</script>

<style scoped>
    .customdropzone {
        width: 100%;
    }


    .form-group {
        margin-bottom: 10px;
    }

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

</style>
