<template>
    <div>
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Meeting Minutes</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary">Create</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table align-items-center table-flush">
                    <template v-if="meetings">
                        <tbody>
                            <tr v-for="(meeting, index) in meetings" :key="index">
                                <td scope="row" width="100%">
                                    {{ meeting.name }}
                                </td>
                                <td width="100%">
                                    <div class="d-flex align-items-center">
                                        <ul>
                                            <li><a href="#!" :data-id="meeting.id" @click="viewMeeting(client.id)"
                                                    title="View Employee"><i class="fas fa-eye"></i></a> </li>
                                            <li> <a href="#!" :data-id="meeting.id" @click="editMeeting(client.id)"
                                                    title="Update Employee"><i class="fas fa-pen"></i></a> </li>
                                            <li> <a href="#!" :data-id="meeting.id" @click="deleteMeeting(client.id)"
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
                    </template> </table>
            </div>
        </div>
        <meeting-minutes-popup :showPopup="showPopup" @close="reload()"></meeting-minutes-popup>
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
        props:['user'],
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
                        $this.meetings = response.data.clients
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
            viewMeeting(meeting_id) {
                JsLoadingOverlay.show(this.$configs);
                window.location.href = '/administrator/meetings/' + meeting_id
            },
            /**
             * Edit Meeting
             * @param meeting_id string
             * @return void
             */
            editMeeting(client_id) {
                let $this = this
                JsLoadingOverlay.show(this.$configs);
                axios({
                        method: 'get',
                        url: '/api/v1/meetings/' + client_id + '?api_token=' + window.Laravel.api_token,
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
             * Format Date 
             * @param date date
             * @return formatted datetime
             */
            deleteMeeting(client_id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to delete this meeting?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios({
                                method: 'delete',
                                url: '/api/v1/meetings/' + client_id + '?api_token=' + window.Laravel.api_token,
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.$toastr.s('Successfully Deleted');
                                    $this.getClients()
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
             * Reload data from the popup
             * @param date date
             * @return formatted datetime
             */
            reload() {
                this.showPopup=false
                this.getMeetings()
            }
        }

    }

</script>

<style>

</style>
