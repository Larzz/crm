<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Meeting Minutes</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary">Upload</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Meeting Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <template v-if="meetings">
                        <tbody>
                            <tr v-for="(meeting, index) in meetings" :key="index">
                                <td scope="row" width="100%">
                                    {{ meeting.name }}
                                </td>
                                  <td scope="row" width="100%">
                                    {{ formatDate(meeting.meeting_date) }}
                                </td>
                                <td width="100%">
                                    <div class="d-flex align-items-center">
                                        <ul>
                                             <li><a href="#!" @click="editMeeting(meeting)" title="Edit Client"><i
                                                        class="fa fa-edit"></i></a> </li>
                                            <li><a href="#!" :data-id="meeting.id" @click="viewMeeting(meeting.attachment)" title="View Employee">
                                                <i class="fas fa-eye"></i></a> </li>
                                            <li> <a href="#!" :data-id="meeting.id" @click="deleteMeeting(meeting.id)" title="Update Employee"><i class="fas fa-trash"></i></a> </li>
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
        <meeting-minutes-popup :showPopup="showPopup" :user="user" @close="reload()"></meeting-minutes-popup>
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        data() {
            return {
                meetings: {},
                showPopup: false
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
                        $this.meetings = response.data.meetings
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
            viewMeeting(filename) {
                JsLoadingOverlay.show(this.$configs);
                window.location.href = '/documents/' + filename
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
            }
        }

    }

</script>

<style scoped>
    .card {
        height: 355px;
    }

</style>
