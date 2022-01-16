<template>
  <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Document Expiration</h3>
                    </div>
                    <div class="col text-right">
                        <!-- <a href="#!" class="btn btn-sm btn-primary">Create</a> -->
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <!-- Projects table -->
                <table class="table align-items-center table-flush">
                    <template v-if="documents">
                        <tbody>
                           <tr v-for="(document, index) in documents" :key="index">
                                <th scope="row">
                                    {{ document.name }}
                                </th>
                                <td>August 5, 2021</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <ul>
                                            <li><a href="#!" :data-id="document.id" @click="viewdocument(document.id)"
                                                    title="View Employee"><i class="fas fa-eye"></i></a> </li>
                                            <li> <a href="#!" :data-id="document.id" @click="editdocument(document.id)"
                                                    title="Update Employee"><i class="fas fa-pen"></i></a> </li>
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
  </div>
</template>

<script>
    export default {
        data() {
            return {
                documents: []
            }
        },
        mounted() {
            this.documents = this.getExpiredDocumentExpired()
        },
        methods: {
            getExpiredDocumentExpired() {
                
              let $this = this
                
               axios({
                  method: 'get',
                  url: '/api/v1/documents?api_token='+window.Laravel.api_token,
                  data: this.fields
                }).then(function (response) {
                })
                 .catch(function (error) {
                    $this.$toastr.e(error);
                })
                .then(function () {
                });

            }
        },
        
    }
</script>

<style>

</style>