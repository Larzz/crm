<template>
    <div>
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
                    <textarea name="" id="" cols="30" v-model="fields.purpose" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Subscription Type</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Frequency</label>
                    <input type="text" class="form-control">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Price</label>
                    <input type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="">Expiration</label>
                    <input type="text" class="form-control" name="" id="">
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <textarea name="" class="form-control" id="" cols="30" rows="4"></textarea>
                </div>

                <div class="form-group">
                    <button type="button" @click="addTool" class="btn btn-primary">Save changes</button>
                </div>

            </div>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                fields: {
                    product: null,
                    email: null,
                    url: null,
                    password: null,
                    purpose: null,
                    subscription_type: null,
                    frequency: null,
                    price: null,
                    expiration:null,
                    note: null
                }
            }
        },
        beforeCreate() {
            JsLoadingOverlay.show(this.$configs);
        },
        created() {
            JsLoadingOverlay.hide();
        },
        methods: {
            addTool() {

                let $this = this

                if (!this.fields.product) {
                    $this.$toastr.e('Product is Required')
                    return;
                }

                if (!this.fields.email) {
                    $this.$toastr.e('Email is Required')
                    return;
                }

                if (!this.fields.password) {
                    $this.$toastr.e('Password is Required')
                    return;
                }

                if (!this.fields.url) {
                    $this.$toastr.e('URL is Required')
                    return;
                }

                if (!this.fields.purpose) {
                    $this.$toastr.e('Purpose is Required')
                    return;
                }

                JsLoadingOverlay.show(this.$configs);

                axios({
                        method: 'post',
                        url: '/api/v1/tools?api_token=' + window.Laravel.api_token,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.resetForm()
                            $this.$emit('newToolAdded', true)
                            $this.$toastr.s('Succesfully Added Tool')
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                        JsLoadingOverlay.hide();
                    });

            },
            resetForm() {
                this.fields.product = null
                this.fields.email = null
                this.fields.password = null
                this.fields.url = null
                this.fields.purpose = null
            }
        }
    }

</script>

<style scoped>
    .card {
        height: 803px;
    }

</style>
