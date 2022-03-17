<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Presentation</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="ShowYearPopup=true" class="btn btn-sm btn-primary"><i class="fa fa-filter">
                            </i></a>
                        <a href="#!" @click="showPopup=true, isEdit = true" class="btn btn-sm btn-primary">Upload</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <template v-if="presentations">
                    <!-- <vue-good-table :columns="columns" :pagination-options="{ enabled: true }" theme="polar-bear"
                        :rows="rows" :sort-options="{ enabled: true, }"
                        :search-options="{ enabled: true, placeholder: 'Search Presentations'}"
                        styleClass="table align-items-center table-flush">
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'action'">
                                <div class="d-flex align-items-center">
                                    <ul>
                                        <li><a href="#!" @click="editPresentation(props.row)" title="Edit Client"><i
                                                    class="fa fa-edit"></i></a> </li>
                                        <li> <a href="#!" @click="viewPresentation(props.row)" title="View Document"><i
                                                    class="fas fa-eye"></i></a> </li>
                                        <li> <a href="#!" @click="deletePresentation(props.row.id)"
                                                title="Delete Document"><i class="fas fa-trash"></i></a> </li>
                                    </ul>
                                </div>
                            </span>
                        </template>
                    </vue-good-table> -->
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Meeting Date</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                            <tbody>
                                <tr v-for="(presentation, index) in presentations" :key="index">
                                    <td scope="row" width="100%">
                                        {{ limitName(presentation.name) }}
                                    </td>
                                    <td scope="row" width="100%">
                                        {{ formatDate(presentation.meeting_date) }}
                                    </td>
                                    <td width="100%">
                                        <div class="d-flex align-items-center">
                                            <ul>
                                                <li><a href="#!" @click="editPresentation(presentation)"
                                                        title="Edit Client"><i class="fa fa-edit"></i></a> </li>
                                                <li><a href="#!" :data-id="presentation.id"
                                                        @click="viewPresentation(presentation)"
                                                        title="View Presentation"><i class="fas fa-eye"></i></a> </li>
                                                <li> <a href="#!" :data-id="presentation.id"
                                                        @click="deletePresentation(presentation.id)"
                                                        title="Delete Presentation"><i class="fas fa-trash"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                    </table>
                </template>
                <template v-if="!presentations">
                    <div class="container mt-3">
                        <div class="alert alert-warning" role="alert">
                            <strong>Sorry!</strong> No Record Found
                        </div>
                    </div>
                </template>
            </div>
        </div>
        <presentation-popup :user="user" :showPopup="showPopup" :time="time" :isEdit="isEdit"
            :presentation="presentation" @close="close()"> </presentation-popup>
        <year-popup :showPopup="ShowYearPopup" @close="sort($event)"></year-popup>

    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        data() {
            return {
                presentations: null,
                showPopup: false,
                ShowYearPopup: false,
                isEdit: false,
                presentation: {},
                time: Date.now(),
                columns: [{
                        label: 'Name',
                        field: 'name',
                    },
                    {
                        label: 'Meeting Date',
                        field: this.setMeeting,
                    },
                    {
                        label: 'Action',
                        field: 'action',
                    },
                ],
                rows: [],
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
                        url: `/api/v1/presentations/${this.user.id}/${this.year}?api_token=${window.Laravel.api_token}`,
                    }).then(function (response) {
                        $this.rows = response.data.presentations
                        $this.presentations = response.data.presentations
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
            viewPresentation(presentation) {


                window.open(
                    `/documents/${presentation.attachment}`,
                    '_blank' // <- This is what makes it open in a new window.
                );
                return

                this.presentation = presentation
                this.showPopup = true
                this.isEdit = false
                this.time = Date.now()
                // JsLoadingOverlay.show(this.$configs);
                // window.location.href = '/documents/' + filename
            },
            editPresentation(presentation) {
                this.presentation = presentation
                this.showPopup = true
                this.isEdit = true
                this.time = Date.now()
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
                this.showPopup = false
                this.isEdit = true
                this.getPresentation()
            },
            /**
             * Cut String
             * @param str string
             * @return str
             */
            limitName(str) {
                return str.substr(0, 40)
            },
            formatDate(date) {
                const currentDate = new Date(date);
                const options = {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'short',
                    day: 'numeric'
                };
                return currentDate.toLocaleDateString('en-us', options)
            },
            setMeeting(presentation) {
                return this.formatDate(presentation.meeting_date)
            },
            sort(year) {
                this.ShowYearPopup = false
                this.year = year
                this.getPresentation()
            }
        }

    }
</script>

<style scoped>
    .card {
        height: 355px;
    }

    .card-body {
        overflow-y: scroll;
    }
</style>
