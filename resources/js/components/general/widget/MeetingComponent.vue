<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Meeting Minutes</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true, isEdit=true" class="btn btn-sm btn-primary">Upload</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <template v-if="meetings">
                    <vue-good-table :columns="columns" :pagination-options="{ enabled: true }" theme="polar-bear"
                        :rows="rows" :sort-options="{ enabled: true, }"
                        :search-options="{ enabled: true, placeholder: 'Search Meeting Minutes'}"
                        styleClass="table align-items-center table-flush">
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'action'">
                                <div class="d-flex align-items-center">
                                    <ul>
                                        <li><a href="#!" @click="editMeeting(props.row)" title="Edit Client"><i
                                                    class="fa fa-edit"></i></a> </li>
                                        <li> <a href="#!" @click="viewMeeting(props.row)" title="View Document"><i
                                                    class="fas fa-eye"></i></a> </li>
                                        <li> <a href="#!" @click="deleteMeeting(props.row.id)"
                                                title="Delete Document"><i class="fas fa-trash"></i></a> </li>
                                    </ul>
                                </div>
                            </span>
                        </template>
                    </vue-good-table>
                </template>
                <template v-if="!meetings">
                    <div class="container mt-3">
                        <div class="alert alert-warning" role="alert">
                            <strong>Sorry!</strong> No Record Found
                        </div>
                    </div>
                </template>

            </div>
        </div>
        <meeting-minutes-popup :showPopup="showPopup" :time="time" :meeting="meeting" :isEdit="isEdit" :user="user"
            @close="reload()"></meeting-minutes-popup>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        data() {
            return {
                meeting: {},
                meetings: {},
                showPopup: false,
                isEdit: false,
                time: Date.now(),
                columns: [{
                        label: 'Name',
                        field: 'name',
                    },
                    {
                        label: 'Expiration',
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
            },

        },
        beforeCreate() {
            JsLoadingOverlay.show(this.$configs);
        },
        created() {
            JsLoadingOverlay.hide();
        },
        mounted() {
            this.getMeetings()
        },
        methods: {
            /**
             * Get Meetings
             * @return meeting object
             */
            getMeetings() {
                let $this = this
                axios({
                        method: 'get',
                        url: `/api/v1/meetings/${this.user.id}?api_token=${window.Laravel.api_token}`,
                        data: this.fields
                    }).then(function (response) {
                        $this.rows = response.data.meetings
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});
            },
            /**
             * View Meeting  
             * @param meeting string
             * @return void
             */
            viewMeeting(meeting) {

                window.open(
                    `/documents/${meeting.attachment}`,
                    '_blank' // <- This is what makes it open in a new window.
                );
                return

                this.showPopup = true
                this.time = Date.now()
                this.meeting = meeting
                // JsLoadingOverlay.show(this.$configs);
                // window.location.href = '/documents/' + filename
            },
            /**
             * Edit Meeting  
             * @param meeting string
             * @return void
             */
            editMeeting(meeting) {
                this.showPopup = true
                this.time = Date.now()
                this.meeting = meeting
                this.isEdit = true
                // JsLoadingOverlay.show(this.$configs);
                // window.location.href = '/documents/' + filename
            },
            /**
             * Format Date 
             * @param date date
             * @return formatted datetime
             */
            deleteMeeting(meetind_id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to delete this meeting?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        JsLoadingOverlay.show(this.$configs);
                        axios({
                                method: 'delete',
                                url: `/api/v1/meetings/${meetind_id}/client/${$this.user.id}?api_token=${window.Laravel.api_token}`,
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.$toastr.s('Successfully Deleted');
                                    $this.getMeetings()
                                }
                            })
                            .catch(function (error) {
                                $this.$toastr.e(error);
                            })
                            .then(function () {
                                JsLoadingOverlay.hide();
                            });
                    }
                })

            },
            /**
             * Reload data from the popup
             * @param date date
             * @return formatted datetime
             */
            reload() {
                this.showPopup = false
                this.isEdit = false
                this.getMeetings()
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
            setMeeting(meeting) {
                return this.formatDate(meeting.meeting_date)
            }
        }

    }

</script>

<style scoped>
    .card {
        height: 355px;
        overflow-y: scroll;
    }

</style>
