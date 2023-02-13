<template>
    <div class="row gy-2 gx-2">
        <!-- <div class="col-md-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item" aria-current="page">
                        <a href="/">My Students</a>
                    </li>
                </ol>
            </nav>
        </div> -->

        <div class="col-md-12">
            <card style="min-height: 90vh">
                <template v-slot:header>My Students</template>
                <form @submit.prevent="getStudents()">
                    <div class="row gx-0">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" v-model="studentFilterData.searchQuery" placeholder="Search for name or ID number" aria-label="Search for name or ID number" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Student ID Number</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Ext Name</th>
                            <th>Gender</th>
                            <th>Guardian</th>
                            <th>SPTS Account ID</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(student, index) in students" :key="index">
                            <td>{{ student.student_id_number }}</td>
                            <td>{{ student.last_name }}</td>
                            <td>{{ student.first_name }}</td>
                            <td>{{ student.middle_name }}</td>
                            <td>{{ student.ext_name }}</td>
                            <td>{{ student.gender.name }}</td>
                            <td>{{ student.guardian ? student.guardian.full_name_last_name : "" }}</td>
                            <td>{{ student.user ? student.user.username : "" }}</td>
                            <td>
                                <a type="button" class="btn btn-primary" :href="`/?stduid=${student.uuid}`" v-tooltip="'View Student'">
                                    <i class="bi bi-person-circle"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>

                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" :class="{ active: pagination.active }" v-for="(pagination, index) in studentPaginations" :key="index" @click="navigateStudentPages(pagination.label)">
                            <a class="page-link" href="javascript:void(0);" v-if="pagination.url != null">
                                <span v-html="pagination.label"></span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </card>
        </div>
        

    </div>
</template>

<script>
    import Card from './../Card.vue';
    import FormItem from './../FormItem.vue';
    import axios from 'axios';
    import { cloneDeep, isEmpty, debounce } from 'lodash'

    export default {
        components: {
            Card,
            FormItem
        },
        props: [
            'user'
        ],
        data() {
            return {
                students: [],
                studentPaginations: [],
                studentFilterData: {
                    page: 1,
                    searchQuery: "",
                },
            };
        },
        methods: {
            getStudents: debounce(function(){
                axios.get(route('guaridans.students', this.user.userable_id), {
                    params: this.studentFilterData
                })
                .then(res => {
                    this.students = res.data.data;
                    this.studentPaginations = res.data.links;
                })
                .catch(res => {});
            }, 250),
            navigateStudentPages(label){
                if(label == "Next &raquo;"){
                    label = this.studentFilterData.page + 1;
                }else if(label == "&laquo; Previous"){
                    label = this.studentFilterData.page - 1;
                }
                this.studentFilterData.page = label;
                this.getStudents();
            },
            viewGrades(){
                console.log("asdasd");
            }
        },
        mounted() {
            this.getStudents();
        }
    }
</script>
