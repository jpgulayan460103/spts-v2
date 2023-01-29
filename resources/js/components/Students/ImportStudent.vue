<template>
    <div class="row gy-2">
        <div class="col-md-12">
            <form @submit.prevent="uploadFile()" v-if="isEmpty(fileContents)">
                <div class="row gx-2">
                    <div class="col-md-6">
                        <form-item label="Upload File" :errors="fileErrors.file">
                            <input type="file" ref="file" class="form-control" :class="fileErrors.file ? 'is-invalid' : ''" accept=".csv">
                        </form-item>
                        <button type="submit" class="btn btn-primary" :disabled="submit">
                            Upload
                        </button>
                    </div>
                    <div class="col-md-6">
                        <form-item label="Importing Format" :errors="fileErrors.file">
                            <a class="form-control" href="/spts-import-student-format.csv">Download this file to view the importing format</a>
                        </form-item>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <card>
                <template v-slot:header>Uploaded File Contents</template>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Student ID Number</th>
                                <th>Last Name</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Ext Name</th>
                                <th>Gender Name</th>
                                <th>SPTS Account ID</th>
                                <th>SPTS Password</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(fileContent, fileContentIndex) in fileContents" :key="fileContentIndex" :class="fileContent.success && fileContent.success == 1 ? 'table-success' : '' ">
                                <td>
                                    <form-item label="" :errors="hasErrors(fileContentIndex, 'student_id_number')">
                                        <input type="text" v-model="fileContent.student_id_number" class="form-control"  :class="hasErrors(fileContentIndex, 'student_id_number') ? 'is-invalid' : ''">
                                    </form-item>
                                </td>
                                <td>
                                    <form-item label="" :errors="hasErrors(fileContentIndex, 'last_name')">
                                        <input type="text" v-model="fileContent.last_name" class="form-control"  :class="hasErrors(fileContentIndex, 'last_name') ? 'is-invalid' : ''">
                                    </form-item>
                                </td>
                                <td>
                                    <form-item label="" :errors="hasErrors(fileContentIndex, 'first_name')">
                                        <input type="text" v-model="fileContent.first_name" class="form-control"  :class="hasErrors(fileContentIndex, 'first_name') ? 'is-invalid' : ''">
                                    </form-item>
                                </td>
                                <td>
                                    <form-item label="" :errors="hasErrors(fileContentIndex, 'middle_name')">
                                        <input type="text" v-model="fileContent.middle_name" class="form-control"  :class="hasErrors(fileContentIndex, 'middle_name') ? 'is-invalid' : ''">
                                    </form-item>
                                </td>
                                <td>
                                    <form-item label="" :errors="hasErrors(fileContentIndex, 'ext_name')">
                                        <input type="text" v-model="fileContent.ext_name" class="form-control"  :class="hasErrors(fileContentIndex, 'ext_name') ? 'is-invalid' : ''">
                                    </form-item>
                                </td>
                                <td>
                                    <form-item label="" :errors="hasErrors(fileContentIndex, 'gender_id')">
                                        <select class="form-control" v-model="fileContent.gender_id"  :class="hasErrors(fileContentIndex, 'gender_id') ? 'is-invalid' : ''">
                                            <option v-for="(gender, genderIndex) in genders" :key="genderIndex" :value="gender.id">{{ gender.name }}</option>
                                        </select>
                                    </form-item>
                                </td>
                                <td>
                                    <form-item label="" :errors="hasErrors(fileContentIndex, 'username')">
                                        <input type="text" v-model="fileContent.username" class="form-control"  :class="hasErrors(fileContentIndex, 'username') ? 'is-invalid' : ''">
                                    </form-item>
                                </td>
                                <td>
                                    <form-item label="" :errors="hasErrors(fileContentIndex, 'password')">
                                        <input type="text" v-model="fileContent.password" class="form-control"  :class="hasErrors(fileContentIndex, 'password') ? 'is-invalid' : ''">
                                    </form-item>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div v-if="!isEmpty(fileContents)">
                    <button type="button" class="btn btn-primary" @click="importStudent" :disabled="submit">
                        Start Importing
                    </button>
                    <button type="button" class="btn btn-danger" @click="resetData">
                        Upload New File
                    </button>
                    <button type="button" class="btn btn-success" @click="removeUploaded">
                        Remove Uploaded Students
                    </button>

                    <hr>
                    <b>Importing Status</b> <br>
                    Total Number of Students: <b>{{ fileContents.length }}</b> <br>
                    Total Number of Successfully Imported: <b>{{ fileContents.filter(item => item.success == 1).length }}</b> <br>
                    Total Number of Failed Imports: <b>{{ fileContents.filter(item => item.success == 0).length }}</b> <br>
                </div>
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
            'user',
            'genders',
        ],
        data() {
            return {
                submit: false,
                selectedFile: {},
                fileErrors: {},
                fileContents: [],
                formData: {},
                formErrors: [],
            };
        },
        methods: {
            uploadFile(){
                this.submit = true;
                this.selectedFile = this.$refs.file.files[0];
                let formData = new FormData();

                formData.append("file", this.selectedFile);

                axios.post(route('sections.import'), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(res => {
                    this.submit = false;
                    this.fileContents = res.data.contents;
                })
                .catch(err => {
                    this.submit = false;
                    this.fileErrors = err.response.data.errors;
                })
                ;
            },
            hasErrors(index, field){
                return !isEmpty(this.formErrors) ? (this.formErrors[index] ? this.formErrors[index][field] : null) : null
            },

            importStudent: debounce(async function(){
                this.submit = true;
                this.formErrors = [];
                for (let index = 0; index < this.fileContents.length; index++) {
                    try {
                        const saveResult = await this.saveStudent(this.fileContents[index]);
                        this.fileContents[index].success = 1;
                        this.formErrors = [
                            ...this.formErrors,
                            [],
                        ]
                    } catch (err) {
                        this.formErrors = [
                            ...this.formErrors,
                            err.response.data.errors,
                        ]
                        this.fileContents[index].success = 0;
                    }
                }
                this.submit = false;
            }, 250),

            async saveStudent(formData){
                return axios.post(route('students.store'), formData);
            },
            resetData(){
                this.submit = false;
                this.selectedFile = {};
                this.fileErrors = {};
                this.fileContents = [];
                this.formData = {};
                this.formErrors = [];
            },
            removeUploaded(){
                this.fileContents = this.fileContents.filter(item => item.success == 0);
                this.formErrors = [];
                console.log(this.formErrors);
            },
            isEmpty(value){
                return isEmpty(value);
            }
        },
        mounted() {
            
        },
        watch: {
            
        }
    }
</script>
