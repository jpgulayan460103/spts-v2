<template>
    <div class="row gy-2 gx-2">
        <div class="col-md-2">
            <div class="row gy-2 gx-2">
                <div class="col-md-12">
                    <card>
                        <template v-slot:header>Section Information</template>
                        <p>Section Name: <b>{{ section.section_name }}</b></p>
                        <p>School Year: <b>{{ section.school_year.name }}</b></p>
                        <p>Grade Level: <b>{{ section.grade_level.name }}</b></p>
                        <p>Track: <b>{{ section.track.name }}</b></p>
                        <p>Adviser: <b>{{ section.adviser ? section.adviser.full_name_last_name : "" }}</b></p>

                        <ul class="list-group">
                            <li class="list-group-item custom-pointer" :class="type=='class-records' ? 'active' : ''" @click="manageClassRecord(section)">Manage Class Records</li>
                            <li class="list-group-item custom-pointer" :class="type=='students' ? 'active' : ''" @click="manageStudent(section)">Manage Students</li>
                        </ul>
                    </card>
                </div>
                <div class="col-md-12" v-if="!isEmpty(classRecord)">
                    <card>
                        <template v-slot:header>Class Record Information</template>
                        <p>Class Record ID: <b>{{ classRecord.id }}</b></p>
                        <p>Semester: <b>{{ classRecord.subject.semester.name }}</b></p>
                        <p>Subject Code: <b>{{ classRecord.subject.subject_code }}</b></p>
                        <p>Subject Description: <b>{{ classRecord.subject.subject_description }}</b></p>
                        <p>Teacher: <b>{{ classRecord.teacher && classRecord.teacher.full_name_first_name ? classRecord.teacher.full_name_last_name : "" }}</b></p>
                        <ul class="list-group">
                            <li
                                class="list-group-item custom-pointer"
                                :class="(isEmpty(classRecordQuarter)) ? 'active' : ''"
                                @click="viewClassRecord(classRecord)"
                            >
                                Attendance
                            </li>

                            <li
                                class="list-group-item custom-pointer"
                                v-for="(quarter, qindex) in classRecord.quarters"
                                :key="qindex"
                                @click="manageQuarter(quarter)"
                                :class="(!isEmpty(classRecordQuarter) && classRecordQuarter.id === quarter.id) ? 'active' : ''"
                            >
                                {{ quarter.quarter.name }}
                            </li>
                        </ul>
                    </card>
                </div>
            </div>
        </div>
        <div class="col-md-10" v-if="type=='class-records'">

            <card v-if="isEmpty(classRecord)">
                <template v-slot:header>Class Records</template>
                <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Class Record ID</th>
                            <th>Semester</th>
                            <th>Subject Code</th>
                            <th>Subject Description</th>
                            <th>Teacher</th>
                            <th style="text-align:center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(class_record, csindex) in section.class_records.filter(item => item.teacher_id == user.userable_id || user.userable_id == section.adviser_id)" :key="csindex">
                            <td>{{ class_record.id }}</td>
                            <td>{{ class_record.subject.semester.name }}</td>
                            <td>{{ class_record.subject.subject_code }}</td>
                            <td>{{ class_record.subject.subject_description }}</td>
                            <td>{{ class_record.teacher && class_record.teacher.full_name_first_name ? class_record.teacher.full_name_last_name : "" }}</td>
                            <td style="text-align:center">
                                <button v-if="class_record.teacher_id == user.userable_id" type="button" class="btn btn-primary" @click="viewClassRecord(class_record)"  v-tooltip="'Manange Class Record'">
                                    <i class="bi bi-gear-fill"></i>
                                </button>

                                <button  v-else type="button" class="btn btn-secondary" @click="viewClassRecord(class_record)"  v-tooltip="'View Class Record'">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>

            </card>

            <!-- Has Selected Class Record -->
            <card v-else>
                <template v-slot:header>
                    {{ classRecord.subject.subject_description }}
                    -
                    <span v-if="isEmpty(classRecordQuarter)">Attendance</span>
                    <span v-else>{{ classRecordQuarter.quarter.name }}</span>
                </template>


                <summary-table  v-bind="$props" v-if="isEmpty(unit)" :viewUnit="viewUnit" />
                <unit-table  v-bind="$props" v-else />

            </card>
        </div>
        <div class="col-md-10" v-else-if="type=='students'">
            <card>
                <template v-slot:header>Students</template>


                <div class="modal modal-lg fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Import Students</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="uploadFile()">
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
                                <div class="row gx-2">
                                    <div class="col-md-12">
                                        <b>Importing Status</b> <br>
                                        Total Number of Students: <b>{{ fileContents.length }}</b> <br>
                                        Total Number of Successfully Imported: <b>{{ fileContents.filter(item => item.success == 1).length }}</b> <br>
                                        Total Number of Failed Imports: <b>{{ fileContents.filter(item => item.success == 0).length }}</b> <br>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                        </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop" @click="getStudents()"  v-if="user.account_type == 'admin'">
                Add Students
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Import Students
                </button>


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
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(student, index) in sectionStudents" :key="index">
                            <td>{{ student.student.student_id_number }}</td>
                            <td>{{ student.student.last_name }}</td>
                            <td>{{ student.student.first_name }}</td>
                            <td>{{ student.student.middle_name }}</td>
                            <td>{{ student.student.ext_name }}</td>
                            <td>{{ student.student.gender.name }}</td>
                            <td>
                                <button type="button" class="btn btn-danger" @click="deleteStudent(student)" v-if="user.account_type == 'admin'"  v-tooltip="'Remove Student'">
                                    <i class="bi bi-person-dash-fill"></i>
                                </button>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
                </div>

            </card>
        </div>

        <!-- Modal -->
        <div class="modal fade modal-lg" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Student List</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
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
                                <td>
                                    <button type="button" class="btn btn-primary" @click="addStudent(student)" v-tooltip="'Insert Student'">
                                        <i class="bi bi-person-plus-fill"></i>
                                    </button>
                                    
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                    <!-- <button type="button" class="btn btn-primary">Understood</button> -->
                </div>
                </div>
            </div>
        </div>

        
    </div>
</template>

<script>
    import Card from './../Card.vue';
    import FormItem from './../FormItem.vue';
    import SummaryTable from './components/SummaryTable.vue'
    import UnitTable from './components/UnitTable.vue'
    import axios from 'axios';
    import { cloneDeep, isEmpty, debounce } from 'lodash'

    export default {
        props: [
            'user',
            'section',
            'classRecord',
            'classRecordQuarter',
            'unit',
            'type',
            'uuid'
        ],
        components: {
            Card,
            FormItem,
            SummaryTable,
            UnitTable
        },
        data() {
            return {
                formData: {},
                formErrors: {},
                schoolYears: [],
                gradeLevels: [],
                tracks: [],
                sections: [],
                students: [],
                sectionStudents: [],
                studentFilterData: {
                    page: 1,
                    searchQuery: "",
                    perPage: 5,
                },
                submit: false,
                fileErrors: {},
                fileContents: [],
                fileHeaders: [],
            };
        },
        methods: {
            getStudents(){
                axios.get(route('students.index'), {
                    params: this.studentFilterData
                })
                .then(res => {
                    this.students = res.data.data;
                })
                .catch(err => {});
            },
            addStudent(student){
                axios.post(route('section-students.store'), {
                    section_id : this.section.id,
                    student_id : student.id
                })
                .then(res => {
                    this.sectionStudents.unshift(res.data);
                })
                .catch(err => {
                    alert(`${student.full_name_last_name} is already added`);
                });
            },
            async insertStudent(student){
                return axios.post(route('section-students.store'), {
                    section_id : this.section.id,
                    student_id : student.id
                });
            },
            deleteStudent(student){
                if(confirm(`Are you sure you want to delete ${student.student.full_name_last_name} in the list?`)){
                    axios.delete(route('section-students.destroy', student.id))
                    .then(res => {
                        this.sectionStudents = this.sectionStudents.filter(item => item.id !== student.id)
                        // this.students = res.data;
                    })
                    .catch(err => {});
                }
            },
            manageStudent(section){
                window.location = route('sections.manage', [section.uuid, 'students']);
            },
            manageClassRecord(section){
                window.location = route('sections.manage', [section.uuid, 'class-records']);
            },
            manageQuarter(quarter){
                window.location = route('sections.manage', {
                    uuid: this.section.uuid,
                    type: 'class-records',
                    _query: {
                        cruid: this.classRecord.uuid,
                        crquid: quarter.uuid,
                    }
                })
                // window.location = route('sections.manage', [section.uuid, 'class-records']);
            },
            viewClassRecord(class_record){
                window.location = route('sections.manage', {
                    uuid: this.section.uuid,
                    type: 'class-records',
                    _query: {
                        cruid: class_record.uuid,
                    }
                })
            },
            viewUnit(unit){
                window.location = route('sections.manage', {
                    uuid: this.section.uuid,
                    type: 'class-records',
                    _query: {
                        cruid: this.classRecord.uuid,
                        crquid: this.classRecordQuarter.uuid,
                        utuid: unit.uuid
                    }
                })
            },
            async uploadFile(){
                this.submit = true;
                this.selectedFile = this.$refs.file.files[0];
                let formData = new FormData();

                formData.append("file", this.selectedFile);

                axios.post(route('sections.students.import'), formData, {
                    headers: {
                        "Content-Type": "multipart/form-data"
                    }
                })
                .then(res => {
                    this.submit = false;
                    this.fileContents = res.data.contents;
                    this.fileHeaders = res.data.headers;
                    this.importStudent();
                })
                .catch(err => {
                    console.log(err);
                    this.submit = false;
                    this.fileErrors = err.response.data.errors;
                })
                ;
            },

            importStudent: debounce(async function(){
                this.submit = true;
                this.formErrors = [];
                let rows = [
                    this.fileHeaders
                ];

                for (let index = 0; index < this.fileContents.length; index++) {
                    try {
                        const saveResult = await this.insertStudent(this.fileContents[index], false);
                        this.sectionStudents.unshift(saveResult.data);
                        this.fileContents[index].success = 1;
                    } catch (err) {
                        this.fileContents[index].success = 0;
                        rows.push([
                            this.fileContents[index].student_id_number,
                            this.fileContents[index].last_name,
                            this.fileContents[index].first_name,
                            this.fileContents[index].middle_name,
                            this.fileContents[index].ext_name,
                            this.fileContents[index].gender,
                        ]);
                    }
                }

                let csvContent = "data:text/csv;charset=utf-8," 
                    + rows.map(e => e.join(",")).join("\n");
                var encodedUri = encodeURI(csvContent);
                var link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", "failed-imports.csv");
                document.body.appendChild(link); // Required for FF

                link.click();
                this.submit = false;
            }, 250),

            async saveStudent(formData){
                return axios.post(route('students.store'), formData);
            },
            isEmpty(value){
                return isEmpty(value);
            }
        },
        mounted() {
            this.sectionStudents = cloneDeep(this.section.students);
        }
    }
</script>
