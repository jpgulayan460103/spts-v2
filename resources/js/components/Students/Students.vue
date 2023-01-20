<template>
    <div class="row gy-2">

        <div class="col-md-4">
            <card>
                <template v-slot:header>Student Form</template>
                <form @submit.prevent="submitForm()">
                    <form-item label="Student ID Number">
                        <input type="text" v-model="formData.student_id_number" class="form-control">
                    </form-item>
                    <form-item label="Last Name">
                        <input type="text" v-model="formData.last_name" class="form-control">
                    </form-item>
                    <form-item label="First Name">
                        <input type="text" v-model="formData.first_name" class="form-control">
                    </form-item>
                    <form-item label="Middle Name">
                        <input type="text" v-model="formData.middle_name" class="form-control">
                    </form-item>
                    <form-item label="Ext Name">
                        <input type="text" v-model="formData.ext_name" class="form-control">
                    </form-item>
                    <form-item label="Gender">
                        <select v-model="formData.gender_id" class="form-control">
                            <option v-for="(item, index) in genders" :key="index" :value="item.id">{{ item.name }}</option>
                        </select>
                    </form-item>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </card>
        </div>

        <div class="col-md-8">
            <card>
                <template v-slot:header>Students</template>
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
                                <button type="button" class="btn btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </card>
        </div>

    </div>
</template>

<script>
    import Card from './../Card.vue';
    import FormItem from './../FormItem.vue';
    import axios from 'axios';

    export default {
        components: {
            Card,
            FormItem
        },
        data() {
            return {
                formData: {},
                formErrors: {},
                genders: [],
                students: [],
            };
        },
        methods: {
            submitForm(){
                axios.post(route('students.store'), this.formData);
            },
            getGenders(){
                axios.get(route('libraries.type', 'genders'))
                .then(res => {
                    this.genders = res.data;
                })
                .catch(err => {});
            },
            getStudents(){
                axios.get(route('students.index'))
                .then(res => {
                    this.students = res.data;
                })
                .catch(err => {});
            },
        },
        mounted() {
            this.getGenders();
            this.getStudents();
        }
    }
</script>
