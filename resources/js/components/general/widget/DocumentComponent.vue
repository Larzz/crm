<template>
    <div>
        <div class="card">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="mb-0">Documents</h3>
                    </div>
                    <div class="col text-right">
                        <a href="#!" @click="ShowYearPopup=true" class="btn btn-sm btn-primary"><i class="fa fa-filter"> </i></a>
                        <a href="#!" @click="showPopup=true, isEdit=true" class="btn btn-sm btn-primary">Upload</a>
                    </div>
                </div>
            </div>
            <!-- <div class="table-responsive">
                <template v-if="documents">
                    <vue-good-table :columns="columns" :pagination-options="{ enabled: true }" theme="polar-bear"
                        :rows="rows" :sort-options="{ enabled: true, }"
                        :search-options="{ enabled: true, placeholder: 'Search Documents'}"
                        styleClass="table align-items-center table-flush">
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'action'">
                                <div class="d-flex align-items-center">
                                    <ul>
                                        <li><a href="#!" @click="editDocument(props.row)" title="Edit Client"><i
                                                    class="fa fa-edit"></i></a> </li>
                                        <li> <a href="#!" @click="viewDocument(props.row)" title="View Document"><i
                                                    class="fas fa-eye"></i></a> </li>
                                        <li> <a href="#!" @click="removeDocument(props.row.id)"
                                                title="Delete Document"><i class="fas fa-trash"></i></a> </li>
                                    </ul>
                                </div>
                            </span>
                        </template>
                    </vue-good-table>
                </template>
                <template v-if="!documents">
                    <div class="container mt-3">
                        <div class="alert alert-warning" role="alert">
                            <strong>Sorry!</strong> No Record Found
                        </div>
                    </div>
                </template>
            </div> -->
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Document</th>
                            <!-- <th scope="col">Starting Date</th> -->
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <template v-if="documents">
                        <tbody>
                            <tr v-for="(document, index) in documents" :key="index">
                                <th scope="row">
                                    {{ document.name }} <br/>
                                    Date Added:  {{ formatDate(document.expiration_date)  }}
                                </th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <ul>
                                              <li>
                                                <a href="#!" @click="viewDocument(document)" title="Open Document"><i
                                                        class="fa fa-eye"></i></a>
                                            </li>
                                            <li>
                                                <a href="#!" @click="removeDocument(document.id)"
                                                    title="Delete Document"><i class="fas fa-trash"></i></a> </li>
                                          
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </template>
                </table>
                <template v-if="!documents">
                    <div class="container mt-3">
                        <div class="alert alert-warning" role="alert">
                            <strong>Sorry!</strong> No Record Found
                        </div>
                    </div>
                </template>
            </div>
            <!-- <div class="card-footer border-0">
                <div class="row align-items-right text-right">
                    <div class="col text-right">
                        <a href="#!" @click="showPopup=true, isEdit=true" class="btn btn-sm btn-primary">Archive</a>
                    </div>
                </div>
            </div> -->
        </div>
        <upload-document-popup :showPopup="showPopup" :user="user" :time="time" :document="document" :isEdit="isEdit"
            @fetchDocument="getDocuments" @close="showPopup = false"></upload-document-popup>
        
        <year-popup :showPopup="ShowYearPopup" @close="sort($event)"></year-popup>
    </div>
</template>

<script>

import Swal from 'sweetalert2'

    export default {
        data() {
            return {
                document: {},
                documents: [],
                showPopup: false,
                ShowYearPopup: false,
                isEdit: false,
                time: Date.now(),
                columns: [{
                        label: 'Name',
                        field: 'name',
                    },
                    {
                        label: 'Expiration',
                        field: this.setExpiration,
                    },
                    {
                        label: 'Action',
                        field: 'action',
                    },
                ],
                rows: [],
                year: 'all'
            }
        },
        props: {
            user: {
                required: true,
                type: Object
            }
        },
        mounted() {
            this.getDocuments()
        },
        methods: {
            getDocuments() {
                let $this = this
                axios({
                        method: 'get',
                        url: `/api/v1/documents/${this.user.id}/${this.year}?api_token=${window.Laravel.api_token}`,
                    }).then(function (response) {
                        if (response.data.status) {
                            $this.rows = response.data.documents
                            $this.documents = response.data.documents
                        }
                    })
                    .catch(function (error) {
                        $this.$toastr.e(error);
                    })
                    .then(function () {});
            },
            close() {
                this.$emit('close', false)
            },
            removeDocument(document_id) {
                let $this = this
                Swal.fire({
                    icon: 'question',
                    title: 'Are you sure you want to delete this document?',
                    showCancelButton: true,
                    confirmButtonText: 'Delete',
                }).then((result) => {
                    if (result.isConfirmed) {

                        axios({
                                method: 'delete',
                                url: '/api/v1/documents/' + document_id + '?api_token=' + window.Laravel
                                    .api_token,
                            }).then(function (response) {
                                if (response.data.status) {
                                    $this.$toastr.s('Successfully Deleted');
                                    $this.getDocuments()
                                }
                            })
                            .catch(function (error) {
                                $this.$toastr.e(error);
                            })
                            .then(function () {});
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                    }
                })

            },
            viewDocument(document) {

                window.open(
                    `/documents/${document.attachment}`,
                    '_blank' // <- This is what makes it open in a new window.
                );
                return

                console.log(document)
                this.isEdit = false
                this.showPopup = true
                this.document = document
                this.time = Date.now()
            },
            editDocument(document) {
                this.isEdit = true
                this.showPopup = true
                this.document = document
                this.time = Date.now()
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
            setExpiration(document) {
                return this.formatDate(document.expiration_date)
            },
            setActions(document) {
                return ` <div class="d-flex align-items-center">
                        <ul>
                            <li><a href="#!" @click="editDocument(document)" title="Edit Client"><i
                                        class="fa fa-edit"></i></a> </li>
                            <li> <a href="#!" @click="viewDocument(document)" title="View Document"><i
                                        class="fas fa-eye"></i></a> </li>
                            <li> <a href="#!" @click="removeDocument(document.id)"
                                    title="Delete Document"><i class="fas fa-trash"></i></a> </li>
                        </ul>
                    </div>`
            },
            sort(year) {
                this.ShowYearPopup = false
                this.year = year
                this.getDocuments()
            }
        }
    }
</script>

<style scoped>
    .card {
        height: 355px !important;
    }

    .vgt-wrap.polar-bear .vgt-wrap__footer .footer__row-count__label {
        font-size: 11px !important;
    }

    .vgt-wrap.polar-bear .vgt-wrap__footer .footer__row-count__select {
        font-size: 11px !important;
    }

    .vgt-wrap.polar-bear .vgt-wrap__footer .footer__navigation__info,
    .vgt-wrap.polar-bear .vgt-wrap__footer .footer__navigation__page-info {
        font-size: 11px !important;
    }

    .vgt-wrap.polar-bear .vgt-wrap__footer .footer__navigation__page-btn {
        font-size: 11px !important;
    }

    .footer__navigation__page-btn disabled {
        font-size: 11px !important;
    }

    /* .table-flush th {
        font-size: 14px !important;
    } */

    .table-flush th {
    font-size: 12px;
}
</style>
