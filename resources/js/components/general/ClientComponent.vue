<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-stats">
                    <!-- Card body -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col">
                                <h5 class="card-title text-uppercase text-muted mb-0">Total Clients</h5>
                                <span class="h2 font-weight-bold mb-0">2,356</span>
                            </div>
                            <div class="col-auto">
                                <div class="icon icon-shape bg-orange text-white rounded-circle shadow">
                                    <i class="ni ni-chart-pie-35"></i>
                                </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-sm">
                            <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- forms -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <client-form></client-form>
                    </div>
                </div>
            </div>
            <!-- listing -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table align-items-center table-flush">
                            <client-table></client-table>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                
            }
        },
        mounted() {
            this.getPresentations()
        },
        methods: {
            getPresentations: function () {
                return
            }
        }
    }

</script>

<style>
</style>
