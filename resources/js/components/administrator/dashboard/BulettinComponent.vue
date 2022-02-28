<template>
    <div>
        <div class="card">
            <div class="card-header bg-transparent">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="h3 mb-0">Bulletin</h4>
                    </div>
                    <div class="align-items-right">
                        <div class="col text-right"><a href="#!" @click="updateBulletin(bulletin)" class="btn btn-sm btn-primary">Edit</a></div>
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
           this.getBulettin()
        },
        methods: {
            getBulettin() {
            },
            updateBulletin(bulletin) {
                console.log(bulletin)
            }
        }
    }

</script>

<style scoped>
  .card {
        height: 476px;
    }
</style>
