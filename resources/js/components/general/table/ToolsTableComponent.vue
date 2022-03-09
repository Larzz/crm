<template>
    <div>
        <template v-if="tools">
            <div class="card">
                <div class="table-responsive">
                   
                    <template v-if="tools">
                        <vue-good-table :columns="columns" :pagination-options="{ enabled: true }" theme="polar-bear"
                            :rows="rows" :sort-options="{ enabled: true, }"
                            :search-options="{ enabled: true, placeholder: 'Search Tools'}"
                            styleClass="table align-items-center table-flush">
                            <template slot="table-row" slot-scope="props">

                                
                                <span v-if="props.column.field == 'product'">
                                     {{ props.row.product }} <br />
                                </span>

                                <span v-if="props.column.field == 'details'">
                                    URL: {{ props.row.url }} <br />
                                    Email: {{ props.row.email }} <br />
                                    Password: {{ props.row.password }} <br>
                                    Purpose: {{ props.row.purpose }} <br>
                                    Subscription Type: {{ props.row.subscription_type }} <br>
                                    Frequency: {{ props.row.frequency_type }} <br>
                                    Price: {{ props.row.price }} <br>
                                    Expiration: {{ props.row.expiration }} <br>
                                    Notes: {{ props.row.notes }}
                                </span>

                                <span v-if="props.column.field == 'action'">
                                    <div class="d-flex align-items-center">
                                        <ul>
                                            <li><a href="#!" @click="editTool(props.row)" title="Edit Client"><i
                                                        class="fa fa-edit"></i></a> </li>
                                            <li> <a href="#!" @click="viewTool(props.row)" title="View Document"><i
                                                        class="fas fa-eye"></i></a> </li>
                                            <li> <a href="#!" @click="deleteTool(props.row.id)"
                                                    title="Delete Document"><i class="fas fa-trash"></i></a> </li>
                                        </ul>
                                    </div>
                                </span>


                            </template>
                        </vue-good-table>
                    </template>
                    <template v-if="!tools">
                        <div class="container mt-3">
                            <div class="alert alert-warning" role="alert">
                                <strong>Sorry!</strong> No Record Found
                            </div>
                        </div>
                    </template>
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
                isEdit: false,
                   columns: [{
                        label: 'Product',
                        field: 'product',
                    },
                    {
                        label: 'Details',
                        field: 'details',
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
                        $this.rows = response.data.tools
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
