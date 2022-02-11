<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Notes</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true" class="btn btn-sm btn-primary">Create</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Title</th>
                            <th scope="col">Date</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <template v-if="notes">
                        <tbody>
                            <tr v-for="(note, index) in notes" :key="index">
                                <th scope="row">
                                    <p v-html="note.notes"></p>
                                </th>
                                <td>
                                    {{ formatDate(note.created_at)  }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <ul>
                                            <li><a href="#!" @click="viewNote(note.id)"
                                                    title="View Tutorial"><i class="fas fa-eye"></i></a> </li>
                                            <li> <a href="#!" @click="deleteNote(note.id)" title="Delete Note"><i
                                                        class="fas fa-trash"></i></a> </li>

                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </template>

                </table>

                <template v-if="!notes">
                    <div class="container mt-3">
                        <div class="alert alert-warning" role="alert">
                            <strong>Sorry!</strong> No Record Found
                        </div>
                    </div>
                </template>

            </div>
        </div>
        <create-note-popup :showPopup="showPopup" :user="user" @close="showPopup = close()"></create-note-popup>
    </div>

</template>


<script>
    import Swal from 'sweetalert2'

    export default {
        data() {
            return {
                showPopup:false,
                notes: []
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
            this.getNotes()
        },
        methods: {
            /**
             * Close Modal
             * @param 
             * @return void
             */
            close() {
                // this.$emit('close', false)
                this.showPopup = false
                this.getNotes()
            },
            /**
             * Get Notes
             * @param 
             * @return void
             */
            getNotes: function () {
                let $this = this
                axios({
                        method: 'get',
                        url: `/api/v1/notes/${$this.user.id}?api_token=${window.Laravel.api_token}`,
                    }

                ).then(function (response) {
                    if (response.data.status) {
                        $this.notes = response.data.notes
                    }
                }).catch(function (error) {
                    $this.$toastr.e(error);
                }).then(function () {

                });
            },
            /**
             * View Note "Redirect to new page"
             * @param note_id
             * @return void
             */
            viewNote(note_id) {
                window.location.href = `/administrator/notes/${note_id}`
            },
            /**
             * Delete Note
             * @param note_id
             * @return void
             */
            deleteNote(note_id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to delete this note?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        // JsLoadingOverlay.show(this.$configs);
                        axios({
                                method: 'delete',
                                url: `/api/v1/notes/${note_id}?api_token=${window.Laravel.api_token}`,
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.$toastr.s('Successfully Deleted');
                                    $this.getNotes()
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
             * Format Date 
             * @param date date
             * @return formatted datetime
             */
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
        min-height: 400px;
    }

</style>
