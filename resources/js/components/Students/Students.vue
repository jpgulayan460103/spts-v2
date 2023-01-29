<template>
    <div class="row gy-2">

        <div class="col-md-4">
            <card>
                <template v-slot:header>Student Form</template>
                <form @submit.prevent="submitForm()">
                    <div v-if="formType != 'update-account'">
                        <form-item label="Student ID Number" :errors="formErrors.student_id_number">
                            <input type="text" v-model="formData.student_id_number" class="form-control" :class="formErrors.student_id_number ? 'is-invalid' : ''" @change="setAccountDetails">
                        </form-item>
                        <form-item label="Last Name" :errors="formErrors.last_name">
                            <input type="text" v-model="formData.last_name" class="form-control" :class="formErrors.last_name ? 'is-invalid' : ''">
                        </form-item>
                        <form-item label="First Name" :errors="formErrors.first_name">
                            <input type="text" v-model="formData.first_name" class="form-control" :class="formErrors.first_name ? 'is-invalid' : ''">
                        </form-item>
                        <form-item label="Middle Name" :errors="formErrors.middle_name">
                            <input type="text" v-model="formData.middle_name" class="form-control" :class="formErrors.middle_name ? 'is-invalid' : ''">
                        </form-item>
                        <form-item label="Ext Name" :errors="formErrors.ext_name">
                            <input type="text" v-model="formData.ext_name" class="form-control" :class="formErrors.ext_name ? 'is-invalid' : ''">
                        </form-item>
                        <form-item label="Gender" :errors="formErrors.gender_id">
                            <select v-model="formData.gender_id" class="form-control" :class="formErrors.gender_id ? 'is-invalid' : ''">
                                <option v-for="(item, index) in genders" :key="index" :value="item.id">{{ item.name }}</option>
                            </select>
                        </form-item>
                        <form-item label="Guardian" :errors="formErrors.guardian_id">
                            <select v-model="formData.guardian_id" class="form-control" :class="formErrors.guardian_id ? 'is-invalid' : ''">
                                <option v-for="(guardian, index) in guardians" :key="index" :value="guardian.id">{{ guardian.full_name_last_name }}</option>
                            </select>
                            <!-- <vue-bootstrap-typeahead
                                :data="guardians"
                                v-model="guardianSearch"
                                size="lg"
                                :serializer="s => s.full_name_first_name"
                                placeholder="Search for name of guardian"
                                @hit="selectedGuardian = $event"
                                inputClass="form-control"
                            /> -->
                        </form-item>
                    </div>
                    <div v-if="formType != 'update'">
                        <form-item label="SPTS Account ID" :errors="formErrors.username">
                            <input type="text" v-model="formData.username" class="form-control" :class="formErrors.username ? 'is-invalid' : ''">
                        </form-item>
                        <form-item label="SPTS Password" :errors="formErrors.password" :help="formType == 'update-account' ? 'Leave blank to remain the password unchanged.' : ''">
                            <input type="text" v-model="formData.password" class="form-control" :class="formErrors.password ? 'is-invalid' : ''">
                        </form-item>
                    </div>
                    <button type="submit" class="btn btn-primary" :disabled="submit">
                        <span v-if="formType == 'create'">Create Student</span>
                        <span v-else-if="formType == 'update-account'">Update Account</span>
                        <span v-else>Update Student</span>
                    </button>
                    <button type="button" style="display:none">Button</button>
                    <button type="button" class="btn btn-danger" v-if="formType != 'create'" @click="resetForm">Cancel</button>
                </form>
            </card>
        </div>

        <div class="col-md-8">
            <card>
                <template v-slot:header>Students</template>
                <form @submit.prevent="getStudents()">
                    <div class="row gx-2">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" v-model="studentFilterData.searchQuery" placeholder="Search for name or ID number" aria-label="Search for name or ID number" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-primary" href="/students/import">Import</a>
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
                                <button type="button" class="btn btn-primary" @click="editAccount(student)">
                                    <i class="bi bi-person-circle"></i>
                                </button>
                                <button type="button" class="btn btn-primary" @click="editStudent(student)">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-danger" @click="deleteStudent(student)">
                                    <i class="bi bi-trash"></i>
                                </button>
                                
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

    const API_URL = 'https://api-url-here.com?query=:query'

    export default {
        components: {
            Card,
            FormItem
        },
        data() {
            return {
                submit: false,
                formData: {},
                formType: "create",
                formErrors: {},
                genders: [],
                students: [],
                studentPaginations: [],
                studentFilterData: {
                    page: 1,
                    searchQuery: "",
                },
                guardians: [],
                guardianSearch: '',
                selectedGuardian: null
            };
        },
        methods: {
            submitForm: debounce(function(){
                this.submit = true;
                if(this.formType == "update"){
                    axios.put(route('students.update', this.formData.id), this.formData)
                    .then(res => {
                        this.submit = false;
                        this.getStudents();
                        this.resetForm();
                        alert(`Student information has been updated.`);
                    })
                    .catch(err => {
                        this.submit = false;
                        this.formErrors = err.response.data.errors
                    });
                }else if(this.formType == "update-account"){
                    axios.put(route('students.update', this.formData.userable_id), this.formData)
                    .then(res => {
                        this.submit = false;
                        this.getStudents();
                        this.resetForm();
                        alert(`Student account has been updated.`);
                    })
                    .catch(err => {
                        this.submit = false;
                        this.formErrors = err.response.data.errors
                    });
                }else{
                    axios.post(route('students.store'), this.formData)
                    .then(res => {
                        this.submit = false;
                        this.getStudents();
                        this.resetForm();
                        alert(`Student has been added.`);
                    })
                    .catch(err => {
                        this.submit = false;
                        this.formErrors = err.response.data.errors
                    });
                }
            }, 250),
            getGenders(){
                axios.get(route('libraries.type', 'genders'))
                .then(res => {
                    this.genders = res.data;
                })
                .catch(err => {});
            },
            getStudents: debounce(function(){
                axios.get(route('students.index'), {
                    params: this.studentFilterData
                })
                .then(res => {
                    this.students = res.data.data;
                    this.studentPaginations = res.data.links;
                })
                .catch(err => {});
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
            editStudent(student){
                this.formData = cloneDeep(student);
                this.formType = "update";
            },
            editAccount(student){
                if(student.user){
                    this.formData = cloneDeep(student.user);
                }
                this.formType = "update-account";
            },
            deleteStudent(student){
                if(confirm("Are you sure you want to delete?")){
                    axios.delete(route('students.destroy', student.id))
                    .then(res => {
                        this.getStudents();
                    })
                    .catch(err => {});
                }
            },
            resetForm(){
                this.formData = {};
                this.formErrors = {};
                this.formType = "create";
            },
            getGuardians(){
                axios.get(route('all.guardians'))
                .then(res => {
                    this.guardians = res.data;
                })
                .catch(err => {});
            },
            setAccountDetails(e){
                let student_id_number = e.target.value;
                this.formData = {
                    ...this.formData,
                    username: student_id_number,
                    password: student_id_number,
                }
            }
            // async getGuardianes(query) {
            //     // const res = await fetch(API_URL.replace(':query', query))
            //     // const suggestions = await res.json()
            //     // this.guardians = suggestions.suggestions

            //     axios.get(route('guardians.index'), {
            //         params: {
            //             searchQuery: query
            //         }
            //     })
            //     .then(res => {
            //         this.guardians = res.data.data;
            //     })
            //     .catch(err => {});
            // }
        },
        mounted() {
            this.getGenders();
            this.getStudents();
            this.getGuardians();
        },
        watch: {
            guardianSearch: debounce(function(addr) { this.getGuardianes(addr) }, 500)
        }
    }
</script>
