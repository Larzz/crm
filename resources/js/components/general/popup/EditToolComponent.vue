<template>
    <div>
        <transition name="fade" appear>
            <div class="modal-overlay" v-if="showPopup" @click.prevent="close"></div>
        </transition>
        <transition name="slide" appear>
            <div class="modal" v-if="showPopup">
                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-default">Tool</h6>
                    <button type="button" @click.prevent="close" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Product</label>
                                <input type="text" v-model="fields.product" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" v-model="fields.email" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">URL</label>
                                <input type="text" v-model="fields.url" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="text" v-model="fields.password" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="Purpose">Purpose</label>
                                <textarea name="" id="" cols="30" v-model="fields.purpose" class="form-control"
                                    rows="3"></textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Subscription Type</label>
                                <input type="text" v-model="fields.subscription_type" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Frequency</label>
                                <input type="text" v-model="fields.frequency_type" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Price</label>
                                <input type="text" v-model="fields.price" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="">Expiration</label>
                                <input type="date" v-model="fields.expiration" class="form-control" name="" id="">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Notes</label>
                                <textarea name="" v-model="fields.notes" class="form-control" id="" cols="30" rows="4"></textarea>
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
                    id: null,
                    product: null,
                    url: null,
                    email: null,
                    password: null,
                    purpose: null,
                    subscription_type: null,
                    frequency_type: null,
                    price: null,
                    expiration: null,
                    notes: null
                }
            }
        },
        props: {
            showPopup: {
                required: true,
                type: Boolean
            },
            tool: {
                required: true,
                type: Object
            }
        },
        mounted() {
            this.fields.id = this.tool.id
            this.fields.product = this.tool.product
            this.fields.url = this.tool.url
            this.fields.email = this.tool.email
            this.fields.password = this.tool.password
            this.fields.purpose = this.tool.purpose
            this.fields.subscription_type = this.tool.subscription_type
            this.fields.frequency_type = this.tool.frequency_type
            this.fields.price = this.tool.price
            this.fields.expiration = this.tool.expiration
            this.fields.notes = this.tool.notes
        },
        watch: {
            tool() {
                this.fields.id = this.tool.id
                this.fields.product = this.tool.product
                this.fields.url = this.tool.url
                this.fields.email = this.tool.email
                this.fields.password = this.tool.password
                this.fields.purpose = this.tool.purpose
                this.fields.subscription_type = this.tool.subscription_type
                this.fields.frequency_type = this.tool.frequency_type
                this.fields.price = this.tool.price
                this.fields.expiration = this.tool.expiration
                this.fields.notes = this.tool.notes
            }
        },
        methods: {
            editClient() {
                let $this = this
                JsLoadingOverlay.show(this.$configs);
                axios({
                        method: 'post',
                        url: `/api/v1/tools/${this.tool.id}?api_token=${window.Laravel.api_token}`,
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
