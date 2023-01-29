<template>
    <div class="row gy-2">

        <div class="col-md-4">
            <card>
                <template v-slot:header>Teacher Form</template>
                <form @submit.prevent="submitForm()">
                    <div v-if="formType != 'update-account'">
                        <form-item label="Teacher ID Number" :errors="formErrors.teacher_id_number">
                            <input type="text" v-model="formData.teacher_id_number" class="form-control" :class="formErrors.teacher_id_number ? 'is-invalid' : ''" @change="setAccountDetails">
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
                        <span v-if="formType == 'create'">Create Teacher</span>
                        <span v-else-if="formType == 'update-account'">Update Account</span>
                        <span v-else>Update Teacher</span>
                    </button>
                    <button type="button" style="display:none">Button</button>
                    <button type="button" class="btn btn-danger" v-if="formType != 'create'" @click="resetForm">Cancel</button>
                </form>
            </card>
        </div>

        <div class="col-md-8">
            <card>
                <template v-slot:header>Teachers</template>
                <form @submit.prevent="getTeachers()">
                    <div class="row gx-0">
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" v-model="teacherFilterData.searchQuery" placeholder="Search for name or ID number" aria-label="Search for name or ID number" aria-describedby="button-addon2">
                                <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Teacher ID Number</th>
                            <th>Last Name</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Ext Name</th>
                            <th>Gender</th>
                            <th>SPTS Account ID</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(teacher, index) in teachers" :key="index">
                            <td>{{ teacher.teacher_id_number }}</td>
                            <td>{{ teacher.last_name }}</td>
                            <td>{{ teacher.first_name }}</td>
                            <td>{{ teacher.middle_name }}</td>
                            <td>{{ teacher.ext_name }}</td>
                            <td>{{ teacher.gender.name }}</td>
                            <td>{{ teacher.user ? teacher.user.username : "" }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" @click="editAccount(teacher)">
                                    <i class="bi bi-person-circle"></i>
                                </button>
                                <button type="button" class="btn btn-primary" @click="editTeacher(teacher)">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-danger" @click="deleteTeacher(teacher)">
                                    <i class="bi bi-trash"></i>
                                </button>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" :class="{ active: pagination.active }" v-for="(pagination, index) in teacherPaginations" :key="index" @click="navigateTeacherPages(pagination.label)">
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
        data() {
            return {
                submit: false,
                formData: {},
                formType: "create",
                formErrors: {},
                genders: [],
                teachers: [],
                teacherPaginations: [],
                teacherFilterData: {
                    page: 1,
                    searchQuery: "",
                },
            };
        },
        methods: {
            submitForm: debounce(function(){
                this.submit = true;
                if(this.formType == "update"){
                    axios.put(route('teachers.update', this.formData.id), this.formData)
                    .then(res => {
                        this.submit = false;
                        this.getTeachers();
                        this.resetForm();
                        alert(`Teacher information has been updated.`);
                    })
                    .catch(err => {
                        this.submit = false;
                        this.formErrors = err.response.data.errors;
                    });
                }else if(this.formType == "update-account"){
                    axios.put(route('teachers.update', this.formData.userable_id), this.formData)
                    .then(res => {
                        this.submit = false;
                        this.getTeachers();
                        this.resetForm();
                        alert(`Teacher account has been updated.`);
                    })
                    .catch(err => {
                        this.submit = false;
                        this.formErrors = err.response.data.errors
                    });
                }else{
                    axios.post(route('teachers.store'), this.formData)
                    .then(res => {
                        this.submit = false;
                        this.getTeachers();
                        this.resetForm();
                        alert(`Teacher has been added.`);
                    })
                    .catch(err => {
                        this.submit = false;
                        this.formErrors = err.response.data.errors;
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
            getTeachers: debounce(function(){
                axios.get(route('teachers.index'), {
                    params: this.teacherFilterData
                })
                .then(res => {
                    this.teachers = res.data.data;
                    this.teacherPaginations = res.data.links;
                })
                .catch(err => {});
            }, 250),
            navigateTeacherPages(label){
                if(label == "Next &raquo;"){
                    label = this.teacherFilterData.page + 1;
                }else if(label == "&laquo; Previous"){
                    label = this.teacherFilterData.page - 1;
                }
                this.teacherFilterData.page = label;
                this.getTeachers();
            },
            editTeacher(teacher){
                this.formData = cloneDeep(teacher);
                this.formType = "update";
            },
            editAccount(teacher){
                if(teacher.user){
                    this.formData = cloneDeep(teacher.user);
                }
                this.formType = "update-account";
            },
            deleteTeacher(teacher){
                if(confirm("Are you sure you want to delete?")){
                    axios.delete(route('teachers.destroy', teacher.id))
                    .then(res => {
                        this.getTeachers();
                    })
                    .catch(err => {});
                }
            },
            resetForm(){
                this.formData = {};
                this.formErrors = {};
                this.formType = "create";
            },
            setAccountDetails(e){
                let teacher_id_number = e.target.value;
                this.formData = {
                    ...this.formData,
                    username: teacher_id_number,
                    password: teacher_id_number,
                }
            },
        },
        mounted() {
            this.getGenders();
            this.getTeachers();
        }
    }
</script>
