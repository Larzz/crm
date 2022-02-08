<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Presentation</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary">Create</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table align-items-center table-flush">
                    <template v-if="presentations">
                        <tbody>
                            <tr v-for="(presentation, index) in presentations" :key="index">
                                <td scope="row" width="100%">
                                    {{ presentation.name }}
                                </td>
                                <td width="100%">
                                    <div class="d-flex align-items-center">
                                        <ul>
                                            <li><a href="#!" :data-id="presentation.id" @click="viewPresentation(presentation.id)"
                                                    title="View Employee"><i class="fas fa-eye"></i></a> </li>
                                            <li> <a href="#!" :data-id="presentation.id" @click="editPresentation(presentation.id)"
                                                    title="Update Employee"><i class="fas fa-pen"></i></a> </li>
                                            <li> <a href="#!" :data-id="presentation.id" @click="deletePresentation(presentation.id)"
                                                    title="Update Employee"><i class="fas fa-trash"></i></a> </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </template>
                    <template v-else>
                        <div class="container">
                            <div class="alert alert-warning" role="alert">
                                <strong>Sorry!</strong> No Record Found
                            </div>
                        </div>
                    </template>
                </table>
            </div>
        </div>
        <presentation-popup :showPopup="showPopup" @close="reload()"> </presentation-popup>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        data() {
            return {
                presentations: {},
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
            this.getPresentation()
        },
        methods: {
            /**
             * Get Presentation
             * @return presentation object
             */
            getPresentation() {
                let $this = this
                axios({
                        method: 'get',
                        url: '/api/v1/presentations?api_token=' + window.Laravel.api_token,
                        data: this.fields
                    }).then(function (response) {
                        $this.presentations = response.data.presentation
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});
            },
            /**
             * View Presentation
             * @return redirect to other page
             */
            viewPresentation(presentation_id) {
                JsLoadingOverlay.show(this.$configs);
                window.location.href = '/administrator/presentations/' + presentation_id
            },
            /**
             * Edit Presentation
             * @param presentation_id
             * @return presentation object
             */
            editPresentation(presentation_id) {
                let $this = this
                JsLoadingOverlay.show(this.$configs);
                axios({
                        method: 'get',
                        url: '/api/v1/presentations/' + presentation_id + '?api_token=' + window.Laravel.api_token,
                    }).then(function (response) {
                        if (response.data.status) {
                            JsLoadingOverlay.hide();
                            $this.editClientdata = response.data.client
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});
            },
            /**
             * Delete Presentation
             * @param presentation_id string
             * @return void
             */
            deletePresentation(presentation_id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to delete this client?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios({
                                method: 'delete',
                                url: '/api/v1/presentations/'+presentation_id+'?api_token='+window.Laravel.api_token,
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.$toastr.s('Successfully Deleted');
                                    $this.getPresentation()
                                }
                            })
                            .catch(function (error) {
                                $this.$toastr.e(error);
                            })
                            .then(function () {});
                    }
                })

            },
            /**
             * Reload Presentation
             * @param presentation_id string
             * @return void
             */
            reload() {
                this.showPopup = false
                this.getPresentation()
            }
        }

    }

</script>

<style>

</style>
