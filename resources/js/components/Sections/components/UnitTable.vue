<template>
    <div>
        <select @change="changeUnit">
            <option :selected="isEmpty(unit)" value="">Summary</option>
            <option v-for="(item, index) in classRecordQuarter.units" :key="index" :value="item.uuid" :selected="(item.uuid == unit.uuid)">{{ item.name }}</option>
        </select>
        <select v-model="viewMode">
            <option value="summary">Summary</option>
            <option value="score">Scores</option>
        </select>
        <!-- classRecord.subject.subject_category.grading_systems -->
        <div class="table-responsive mt-2">
            <table class="table table-bordered table-hover" v-if="viewMode == 'score'">
                <thead>
                    <tr>
                        <th class="br bl" rowspan="3" style="width: 320px;">Student Name</th>
                        <th class="br" :colspan="unitGradingSystem1.count != 0 ? unitGradingSystem1.count + 3 : unitGradingSystem1.count + 4">
                            {{ unitGradingSystem1.name }}
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop" @click="selectGradingSystem(unitGradingSystem1)">
                                <b>+</b>
                            </button>
                        </th>
                        <th class="br" :colspan="unitGradingSystem2.count != 0 ? unitGradingSystem2.count + 3 : unitGradingSystem2.count + 4">
                            {{ unitGradingSystem2.name }}
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop" @click="selectGradingSystem(unitGradingSystem2)">
                                <b>+</b>
                            </button>
                        </th>
                        <th class="br" :colspan="unitGradingSystem3.count != 0 ? unitGradingSystem3.count + 3 : unitGradingSystem3.count + 4">
                            {{ unitGradingSystem3.name }}
                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop" @click="selectGradingSystem(unitGradingSystem3)">
                                <b>+</b>
                            </button>
                        </th>
                        <th rowspan="2" class="br">Initial Grade</th>
                        <th rowspan="2" class="br">Transmuted Grade</th>
                        <th rowspan="3">Description</th>
                        <th rowspan="3" class="br">Remarks</th>
                    </tr>
                    <tr>
                        <th :colspan="unitGradingSystem1.count">{{ unitGradingSystem1.percentage * 100 }}%</th>
                        <th>Total</th>
                        <th>PS</th>
                        <th class="br">WS</th>
                        <th :colspan="unitGradingSystem2.count">{{ unitGradingSystem2.percentage * 100 }}%</th>
                        <th>Total</th>
                        <th>PS</th>
                        <th class="br">WS</th>
                        <th :colspan="unitGradingSystem3.count">{{ unitGradingSystem3.percentage * 100 }}%</th>
                        <th>Total</th>
                        <th>PS</th>
                        <th class="br">WS</th>
                    </tr>
                    <tr>
                        <th v-for="(unitItem, index) in unitGradingSystem1.unit_items" :key="`unit-item-1-${index}`">
                            {{ unitItem.item }}
                        </th>
                        <th v-if="isEmpty(unitGradingSystem1.unit_items)">0</th>
                        <th>{{ unitGradingSystem1.total_items }}</th>
                        <th>{{ unitGradingSystem1.percentage_score }}</th>
                        <th class="br">{{ unitGradingSystem1.weighted_score }}</th>
                        <th v-for="(unitItem, index) in unitGradingSystem2.unit_items" :key="`unit-item-2-${index}`">
                            {{ unitItem.item }}
                        </th>
                        <th v-if="isEmpty(unitGradingSystem2.unit_items)">0</th>
                        <th>{{ unitGradingSystem2.total_items }}</th>
                        <th>{{ unitGradingSystem2.percentage_score }}</th>
                        <th class="br">{{ unitGradingSystem2.weighted_score }}</th>
                        <th v-for="(unitItem, index) in unitGradingSystem3.unit_items" :key="`unit-item-3-${index}`">
                            {{ unitItem.item }}
                        </th>
                        <th v-if="isEmpty(unitGradingSystem3.unit_items)">0</th>
                        <th>{{ unitGradingSystem3.total_items }}</th>
                        <th>{{ unitGradingSystem3.percentage_score }}</th>
                        <th class="br">{{ unitGradingSystem3.weighted_score }}</th>
                        <th class="br">{{ unitItemTransmutedGrade }}</th>
                        <th class="br">{{ unitItemInitialGrade }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(sectionStudent, index) in sectionStudents" :key="index">
                        <td class="br bl">
                            <span>{{ sectionStudent.student.last_name }}</span>,
                            <span>{{ sectionStudent.student.first_name }}</span>
                            <span>{{ sectionStudent.student.middle_name }}</span>
                            <span>{{ sectionStudent.student.ext_name }}</span>
                        </td>

                        <td v-for="(unitItem, index) in unitGradingSystem1.unit_items" :key="`unit-score-1-${index}`">
                            <input type="number" min="0" style="width: 50px;" :value="unitScore(unitItem, sectionStudent, scoreGradingSystem1(sectionStudent))" :max="unitItem.item" @blur="addScore($event, unitItem, sectionStudent, scoreGradingSystem1(sectionStudent))" ref="scores">
                        </td>
                        <th v-if="isEmpty(unitGradingSystem1.unit_items)"></th>
                        <td>{{ scoreGradingSystem1(sectionStudent).total_scores }}</td>
                        <td>{{ scoreGradingSystem1(sectionStudent).percentage_score }}</td>
                        <td class="br">{{ scoreGradingSystem1(sectionStudent).weighted_score }}</td>

                        <td v-for="(unitItem, index) in unitGradingSystem2.unit_items" :key="`unit-score-2-${index}`">
                            <input type="number" min="0" style="width: 50px;" :value="unitScore(unitItem, sectionStudent, scoreGradingSystem2(sectionStudent))" :max="unitItem.item" @blur="addScore($event, unitItem, sectionStudent, scoreGradingSystem2(sectionStudent))" ref="scores">
                        </td>
                        <th v-if="isEmpty(unitGradingSystem2.unit_items)"></th>
                        <td>{{ scoreGradingSystem2(sectionStudent).total_scores }}</td>
                        <td>{{ scoreGradingSystem2(sectionStudent).percentage_score }}</td>
                        <td class="br">{{ scoreGradingSystem2(sectionStudent).weighted_score }}</td>

                        <td v-for="(unitItem, index) in unitGradingSystem3.unit_items" :key="`unit-score-3-${index}`">
                            <input type="number" min="0" style="width: 50px;" :value="unitScore(unitItem, sectionStudent, scoreGradingSystem3(sectionStudent))" :max="unitItem.item" @blur="addScore($event, unitItem, sectionStudent, scoreGradingSystem3(sectionStudent))" ref="scores">
                        </td>
                        <th v-if="isEmpty(unitGradingSystem3.unit_items)"></th>
                        <td>{{ scoreGradingSystem3(sectionStudent).total_scores }}</td>
                        <td>{{ scoreGradingSystem3(sectionStudent).percentage_score }}</td>
                        <td class="br">{{ scoreGradingSystem3(sectionStudent).weighted_score }}</td>
                        <th class="br">{{ sectionStudent.initial_grade }}</th>
                        <th class="br">{{ sectionStudent.transmuted_grade }}</th>
                        <th>{{ sectionStudent.descriptor }}</th>
                        <th class="br">{{ sectionStudent.remarks }}</th>
                    </tr>
                </tbody>
            </table>
            <table class="table table-bordered table-hover" v-else>
                <thead>
                    <tr>
                        <th class="br bl" rowspan="2" style="width: 320px;">Student Name</th>
                        <th class="br" colspan="2">{{ unitGradingSystem1.name }}</th>
                        <th class="br" colspan="2">{{ unitGradingSystem2.name }}</th>
                        <th class="br" colspan="2">{{ unitGradingSystem3.name }}</th>
                        <th rowspan="2" class="br bl">Initial Grade</th>
                        <th rowspan="2" class="br">Transmuted Grade</th>
                        <th rowspan="2">Description</th>
                        <th rowspan="2" class="br">Remarks</th>
                    </tr>
                    <tr>
                        <th class="bl">{{ unitGradingSystem1.percentage * 100 }}%</th>
                        <th>Remarks</th>
                        <th class="bl">{{ unitGradingSystem2.percentage * 100 }}%</th>
                        <th>Remarks</th>
                        <th class="bl">{{ unitGradingSystem3.percentage * 100 }}%</th>
                        <th>Remarks</th>
                        <th>Action to be Taken</th>
                        <th>Teacher’s Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(sectionStudent, index) in sectionStudents" :key="index">
                        <td class="br bl">
                            <span>{{ sectionStudent.student.last_name }}</span>,
                            <span>{{ sectionStudent.student.first_name }}</span>
                            <span>{{ sectionStudent.student.middle_name }}</span>
                            <span>{{ sectionStudent.student.ext_name }}</span>
                        </td>
                        <td class="bl">{{ scoreGradingSystem1(sectionStudent).weighted_score }}</td>
                        <td>{{ scoreGradingSystem1(sectionStudent).percentage_grade_descriptor }}</td>
                        <td class="bl">{{ scoreGradingSystem2(sectionStudent).weighted_score }}</td>
                        <td>{{ scoreGradingSystem2(sectionStudent).percentage_grade_descriptor }}</td>
                        <td class="bl">{{ scoreGradingSystem3(sectionStudent).weighted_score }}</td>
                        <td>{{ scoreGradingSystem3(sectionStudent).percentage_grade_descriptor }}</td>
                        <th class="br bl">{{ sectionStudent.initial_grade }}</th>
                        <th class="br">{{ sectionStudent.transmuted_grade }}</th>
                        <th>{{ sectionStudent.descriptor }}</th>
                        <th class="br">{{ sectionStudent.remarks }}</th>
                        <th class="br">
                            <select @change="setUnitAction($event, sectionStudent, 'action')" v-if="sectionStudent.descriptor != ''">
                                <option value="">Select Action</option>
                                <option v-for="(item, index) in actionOptions" :key="index" :value="item.id" :selected="(sectionStudent.unit_action && sectionStudent.unit_action.action_id == item.id)">{{ item.name }}</option>
                            </select>
                        </th>
                        <th class="br">
                            <div v-if="sectionStudent.descriptor != ''">
                                <textarea @change="setUnitAction($event, sectionStudent, 'feedback')" rows="1" v-if="sectionStudent.unit_action" v-model="sectionStudent.unit_action.teacher_feedback"></textarea>
                                <textarea @change="setUnitAction($event, sectionStudent, 'feedback')" rows="1" v-else></textarea>
                            </div>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- Modal -->
        <div class="modal fade modal-sm" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">{{ selectedGradingSystem.name }} {{ selectedGradingSystem.percentage * 100 }}%</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form @submit.prevent="addUnitItem()">
                        <form-item label="Number of Items" :errors="formErrors.item">
                            <input type="number" min="1" v-model="formData.item" class="form-control" :class="formErrors.item ? 'is-invalid' : ''">
                        </form-item>
                        <button type="submit" class="btn btn-primary" :disabled="submit">Add</button>
                    </form>
                    <ul class="list-group mt-2">
                        <li class="list-group-item d-flex justify-content-between align-items-center"><b>Items</b></li>
                        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="(unit_item, uiindex) in selectedGradingSystem.unit_items" :key="uiindex">
                            {{ unit_item.item }}
                            <button type="submit" class="btn btn-danger btn-sm" @click="deleteUnitItem(unit_item)">
                                <b>x</b>
                            </button>
                            <!-- <span>Delete</span> -->
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Done</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import axios from 'axios';
    import { cloneDeep, isEmpty, debounce } from 'lodash'
    import FormItem from './../../FormItem.vue';

    export default {
        components: {
            FormItem
        },
        props: [
            'section',
            'classRecord',
            'classRecordQuarter',
            'unit',
        ],
        data() {
            return {
                submit: false,
                formData: {},
                formErrors: {},
                sectionStudents: [],
                selectedGradingSystem: {},
                unitItems: [],
                unitItemInitialGrade: 0,
                unitItemTransmutedGrade: 0,
                viewMode: "summary",
                actionOptions: [],
            };
        },
        methods: {
            addUnitItem: debounce(function(){
                this.submit = true;
                const formData = {
                    ...this.formData,
                    grading_system_id: this.selectedGradingSystem.id,
                    unit_id: this.unit.id
                }
                axios.post(route('unit-items.store'), formData)
                .then(res => {
                    this.submit = false,
                    this.getUnitItems();
                    // this.getUnitScores();
                })
                .catch(err => {
                    this.submit = false,
                    this.formErrors = err.response.data.errors
                });
            }, 250),
            deleteUnitItem(unitItem){
                axios.delete(route('unit-items.destroy', unitItem.id))
                .then(res => {
                    this.getUnitItems();
                    // this.getUnitScores();
                })
                .catch(err => {});
            },
            addScore(e, unitItem, sectionStudent, gradingSystem){
                let score = e.target.value;
                if(score > unitItem.item){
                    this.$refs['scores'][0].value = unitItem.item;
                    score = unitItem.item;
                }
                if(score < 1){
                    this.$refs['scores'][0].value = 0;
                    score = 0;
                }
                const formData = {
                    score,
                    unit_id: this.unit.id,
                    unit_item_id: unitItem.id,
                    unit_items: unitItem.item,
                    section_student_id: sectionStudent.id,
                    grading_system_id: gradingSystem.id,
                }
                axios.post(route('unit-scores.store'), formData)
                .then(res => {
                    this.$refs['scores'][0].className = '';
                    this.getUnitScores();
                })
                .catch(err => {
                    console.log(this.$refs['scores'][0].className);
                    this.$refs['scores'][0].className = 'score-error';
                    
                });
            },
            unitScore(unitItem, sectionStudent, gradingSystem){
                // console.log(unitItem);
                const unitScores = gradingSystem.unit_scores.filter(item => item.section_student_id == sectionStudent.id && item.unit_item_id == unitItem.id);
                if(!isEmpty(unitScores)){
                    const unitScore = unitScores[0];
                    return unitScore.score;
                }
                return 0;
            },
            selectGradingSystem(gradingSystem){
                this.selectedGradingSystem = cloneDeep(gradingSystem);
            },
            countGradingSystem(gradingSystem){
                const unitsOfGradingSystem = this.unitItems.filter(item => item.grading_system_id === gradingSystem.id);
                return unitsOfGradingSystem.length;
            },
            getUnitItems(){
                axios.get(route('class-records.unit-items', this.classRecord.id), {
                    params: {
                        unit_id: this.unit.id
                    }
                })
                .then(res => {
                    this.unitItems = res.data.unit_items;
                    this.unitItemInitialGrade = res.data.initial_grade;
                    this.unitItemTransmutedGrade = res.data.transmuted_grade;
                    if(!isEmpty(this.selectedGradingSystem)){
                        const selectedGradingSystem = cloneDeep(this.unitItems.filter(item => item.id == this.selectedGradingSystem.id));
                        this.selectedGradingSystem = selectedGradingSystem[0];

                    }
                })
                .catch(err => {});
            },
            getUnitScores(){
                axios.get(route('class-records.unit-scores', this.classRecord.id), {
                    params: {
                        unit_id: this.unit.id
                    }
                })
                .then(res => {
                    this.sectionStudents = res.data.section_students;
                })
                .catch(err => {});
            },
            isEmpty(value){
                return isEmpty(value)
            },
            scoreGradingSystem1(sectionStudent){
                return sectionStudent.grading_system[0];
            },
            scoreGradingSystem2(sectionStudent){
                return sectionStudent.grading_system[1];
            },
            scoreGradingSystem3(sectionStudent){
                return sectionStudent.grading_system[2];
            },
            changeUnit(e){
                window.location = route('sections.manage', {
                    uuid: this.section.uuid,
                    type: 'class-records',
                    _query: {
                        cruid: this.classRecord.uuid,
                        crquid: this.classRecordQuarter.uuid,
                        utuid: e.target.value
                    }
                })
            },
            getActionOptions(){
                axios.get(route('libraries.type', 'actions'))
                .then(res => {
                    this.actionOptions = res.data
                })
                .catch(err => {});
            },
            setUnitAction(e, sectionStudent, type){
                let formData;
                if(type == "action"){
                    formData = {
                        'action_id': e.target.value == "" ? null: e.target.value,
                        'section_student_id': sectionStudent.id,
                        'unit_id': this.unit.id
                    };
                }else{
                    formData = {
                        'teacher_feedback': e.target.value,
                        'section_student_id': sectionStudent.id,
                        'unit_id': this.unit.id
                    };
                }
                axios.post(route('unit-actions.store'), formData)
                .then(res => {

                })
                .catch(err => {});
            },
        },
        mounted() {
            // this.sectionStudents = cloneDeep(this.section.sectionStudents);
            this.getUnitItems();
            this.getUnitScores();
            if(!isEmpty(this.unit)){
                this.getActionOptions();
            }
        },
        computed: {
            unitGradingSystem1(){
                if(isEmpty(this.unitItems[0])){
                    return {
                        count: 0,
                    }
                }
                return this.unitItems[0];
                // const gradingSystem = this.classRecord.subject.subject_category.grading_systems[2];
                // const unitsOfGradingSystem = this.unitItems.filter(item => item.grading_system_id === gradingSystem.id);
                // return {
                //     ...gradingSystem,
                //     unitItems: unitsOfGradingSystem,
                //     count: unitsOfGradingSystem.length
                // };
            },
            unitGradingSystem2(){
                if(isEmpty(this.unitItems[1])){
                    return {
                        count: 0,
                    }
                }
                return this.unitItems[1];
            },
            unitGradingSystem3(){
                if(isEmpty(this.unitItems[2])){
                    return {
                        count: 0,
                    }
                }
                return this.unitItems[2];
            },
        },
        watch: {
            viewMode(){
                this.getUnitScores();
            }
        }
    }
</script>

<style scoped>
    .bl{
        border-left: 2px solid black
    }
    .br{
        border-right: 2px solid black
    }
    .bt{
        border-top: 2px solid black
    }
    .bb{
        border-bottom: 2px solid black
    }
    .score-error{
        border: 1px solid red;
    }
</style>