<template>
    <div>
        <div class="card">
            <div class="card-header bg-transparent">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="h3 mb-0">Bulettin</h4>
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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                bulletin: {}
            }
        },
        mounted() {
            this.bulletin = this.getBulettin()
        },
        methods: {

            getBulettin() {

                let $this = this
                
                axios({
                  method: 'get',
                  url: '/api/v1/bulletin?api_token='+window.Laravel.api_token,
                  data: {
                        config: {
                            headers: {
                                Authorization: 'Bearer ' + window.Laravel.api_token,
                                Accept: 'application/json'
                            }
                        },
                  }
                }).then(function (response) {
                    // console.log(response)
                })
                .catch(function (error) {
                    $this.$toastr.e(error);
                })
                .then(function () {
                });

            }
        }
    }

</script>

<style>

</style>
