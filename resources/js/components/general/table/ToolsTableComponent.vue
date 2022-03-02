<template>
    <div>
        <template v-if="tools">
             <div class="card">
                    <div class="card-body">
                        <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <!-- <th width="100%" scope="col">Product</th> -->
                        <!-- <th width="100%" scope="col">URL</th> -->
                        <th width="100%" scope="col">Details</th>
                        <th width="100%" scope="col">Action</th>
                    </tr>
                </thead>
              <tbody id="table-body">
                <tr v-for="(tool, index) in tools" :key="index">
                    <td scope="row" width="100%">
                       Product: {{ tool.product }} <br/>
                       URL: {{ tool.url }} <br/>
                       Email: {{ tool.email }} <br/>
                       Password: {{ tool.password }} <br>
                       Purpose {{ tool.purpose }} <br>
                       Subscription Type {{ tool.subscription_type }} <br>
                       Frequency {{ tool.frequency_type }} <br>
                       Price {{ tool.price }} <br>
                       Expiration {{ tool.expiration }} <br>
                       Notes: {{ tool.notes }}
                    </td>
                    <td width="100%">
                        <div class="d-flex align-items-center">
                            <ul>
                                <li><a href="#!" @click="editTool(tool)" title="Edit Client"><i class="fa fa-edit"></i></a> </li>
                                <li><a href="javascript:;" @click="viewTool(tool)" title="View Employee"><i class="fas fa-eye"></i></a> </li>
                                <li><a href="javascript:;" @click="deleteTool(tool.id)" title="Update Employee"><i class="fas fa-trash"></i></a> </li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
                   </table>
                    </div>
                </div>
        </template>
        <template v-else>
            <div class="container">
                <div class="alert alert-warning" role="alert">
                    <strong>Sorry!</strong> No Record Found
                </div>
            </div>
        </template>
        <edit-tool-popup :showPopup="showPopup" :isEdit="isEdit" :tool="tool" @close="close()" />
    </div>
</template>

<script>
    import Swal from 'sweetalert2'
    export default {
        data() {
            return {
                tools: {},
                showPopup: false,
                tool: {},
                isEdit: false
            }
        },
        props: {
            newToolAdded: {
                required: true,
                type: Number 
            }
        },
        watch: {
            newToolAdded: 'getTools'
        },
        beforeCreate() {
            JsLoadingOverlay.show(this.$configs);
        },
        created() {
            JsLoadingOverlay.hide();
        },
        mounted() {
            this.getTools()
        },
        methods: {
            getTools() {
                let $this = this
                axios({
                        method: 'get',
                        url: '/api/v1/tools?api_token=' + window.Laravel.api_token,
                        data: this.fields
                    }).then(function (response) {
                        console.log(response)
                        $this.tools = response.data.tools
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});
            },
            viewTool(tool) {
                this.showPopup = true
                this.tool = tool
                return
            },
            editTool(tool) {
                this.showPopup = true
                this.tool = tool
                return
                let $this = this
                JsLoadingOverlay.show(this.$configs);
                axios({
                        method: 'get',
                        url: '/api/v1/tools/' + client_id + '?api_token=' + window.Laravel.api_token,
                    }).then(function (response) {
                        if (response.data.status) {
                            JsLoadingOverlay.hide();
                            console.log(response)
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});
            },
            deleteTool(tool_id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to delete this tool?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios({
                                method: 'delete',
                                url: `/api/v1/tools/${tool_id}?api_token=${window.Laravel.api_token}`,
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.getTools()
                                    $this.$toastr.s('Successfully Deleted');
                                }
                            })
                            .catch(function (error) {
                                $this.$toastr.e(error);
                            })
                            .then(function () {});
                    }
                })

            },
            close() {
                this.showPopup = false
                this.getTools()
            }
        }

    }

</script>


<style scoped>
    #table-body {
        overflow-y: scroll;
         height: 794px;
    }
     .card {
        height: 794px;
        overflow-y: scroll;
    }
</style>