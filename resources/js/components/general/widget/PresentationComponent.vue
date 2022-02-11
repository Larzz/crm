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
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <template v-if="presentations">
                        <tbody>
                            <tr v-for="(presentation, index) in presentations" :key="index">
                                <td scope="row" width="100%">
                                    {{ limitName(presentation.name) }}
                                </td>
                                <td width="100%">
                                    <div class="d-flex align-items-center">
                                        <ul>
                                            <li><a href="#!" :data-id="presentation.id" @click="viewPresentation(presentation.attachment)"
                                                    title="View Presentation"><i class="fas fa-eye"></i></a> </li>
                                            <li> <a href="#!" :data-id="presentation.id" @click="deletePresentation(presentation.id)"
                                                    title="Delete Presentation"><i class="fas fa-trash"></i></a> </li>
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
        <presentation-popup :user="user" :showPopup="showPopup" @close="close()"> </presentation-popup>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        data() {
            return {
                presentations: null,
                showPopup: false
            }
        },
        props: {
            user: {
                required: true,
                type: Object
            }
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
                JsLoadingOverlay.show(this.$configs);
                let $this = this
                axios({
                        method: 'get',
                        url: `/api/v1/presentations/${this.user.id}?api_token=${window.Laravel.api_token}`,
                    }).then(function (response) {
                        $this.presentations = response.data.presentations
                        console.log($this.presentations)
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {
                        JsLoadingOverlay.hide();
                    });
            },
            /**
             * View Presentation
             * @return redirect to other page
             */
            viewPresentation(filename) {
                JsLoadingOverlay.show(this.$configs);
                window.location.href = '/documents/' + filename
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
                    title: 'Are you sure you want to delete this presentation?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios({
                                method: 'delete',
                                url: `/api/v1/presentations/${presentation_id}/client/${this.user.id}?api_token=${window.Laravel.api_token}`,
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
            close() {
                this.showPopup = false
                this.getPresentation()
            },
            /**
             * Cut String
             * @param str string
             * @return str
             */
            limitName(str) {
                return str.substr(0,40)
            }
        }

    }

</script>

<style>

</style>
