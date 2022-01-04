<template>
    <div>
        <div class="card">
            <template v-if="feeds">
                <div class="row">
                    <div class="col-md-4" v-for="(feed, index) in feeds" :key="index">
                        <div class="card" style="width: 18rem;">
                            <img class="card-img-top" src="" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the
                                    bulk
                                    of the card's content.</p>
                                <a href="#" class="btn btn-primary">Go somewhere</a>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="pt-3 mr-4 ml-4">
                    <div class="alert alert-warning" role="alert">
                        <strong>Sorry!</strong> No Record Found
                    </div>
                </div>
            </template>

        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                feeds: []
            }
        },
        methods: {
            getFeeds() {
                return null
            }
        },
        mounted() {
            this.feeds = this.getFeeds()
        }
    }

</script>

<style>

</style>
