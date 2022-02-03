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
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <template v-if="notes">
                        <tbody>
                            <tr v-for="(note, index) in notes" :key="index">
                                <th scope="row">
                                    {{ note.name }}
                                </th>
                                <td>
                                    {{ formatDate(note.expiration_date)  }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <ul>
                                            <li> <a href="#!" @click="removenote(note.id)" title="Delete Document"><i
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
    </div>
</template>

<script>
    export default {
        data() {
            return {
                notes: []
            }
        },
        beforeCreate() {
            JsLoadingOverlay.show(this.$configs);
        },
        created() {
            JsLoadingOverlay.hide();
        },
    }

</script>

<style>

</style>
