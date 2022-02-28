<template>
    <div>
        <div class="card">
            <div class="card-header bg-transparent">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="h3 mb-0">Bulletin</h4>
                    </div>
                    <div class="col">
                        <div class="align-items-right">
                            <div class="col text-right"><a href="#!" @click="showPopup=true"
                                    class="btn btn-sm btn-primary">Edit</a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <template v-if="bulletin">
                    <div class="bulettin-container">
                        <h4>{{ this.bulletin.title }}</h4>
                        <p>
                            {{ this.bulletin.message }}
                        </p>
                    </div>
                </template>

                <template v-else>
                    <div class="container">
                        <div class="alert alert-warning" role="alert">
                            <strong>Sorry!</strong> No Record Found
                        </div>
                    </div>
                </template>

            </div>
        </div>
        <edit-bulletin-popup :bulletin="bulletin" :showPopup="showPopup" @close="close()"></edit-bulletin-popup>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                bulletin: {},
                showPopup: false
            }
        },
        beforeCreate() {
            JsLoadingOverlay.show(this.$configs);
        },
        created() {
            JsLoadingOverlay.hide();
        },
        mounted() {
            this.getBulettin()
        },
        methods: {
            getBulettin() {
                let $this = this
                axios({
                        method: 'get',
                        url: '/api/v1/bulletin?api_token=' + window.Laravel.api_token,
                        data: this.fields
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.bulletin = response.data.bulletins
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});
            },
            updateBulletin() {
                this.showPopup = true
            },
            close() {
                this.showPopoup = false
            }
        }
    }

</script>

<style scoped>
    .card {
        height: 386px;
    }

</style>
